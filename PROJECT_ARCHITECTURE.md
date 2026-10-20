# Castle Royal Agro - Encyclopedic Project Architecture & Rebuild Manual

This document is the **definitive, exhaustive technical manual** for the Castle Royal Agro web application. It leaves absolutely no architectural stone unturned. If this application is lost, an AI or human software engineer can use this exact document to reconstruct the architecture from scratch.

---

## 1. Executive Summary & Core Technologies
The system is an agro-investment platform modeled on the "Ghana Green Gold Revolution" (3GR). It allows users to browse agricultural packages (Moringa initiatives), invest capital by purchasing units, and request withdrawals upon maturity. Administrators manage the platform, approve investments/withdrawals, and log all operational activities.

### Core Stack
- **Framework:** Laravel 11.x (PHP 8.2+)
- **Database:** PostgreSQL (Aiven cloud hosting)
- **Frontend Engine:** Laravel Blade templating, styled aggressively with **Tailwind CSS** via CDN/Build.
- **Frontend Reactivity:** **Alpine.js** (for Modals, Dropdowns, and mobile toggles).
- **Authentication Base:** Laravel Breeze (Blade stack).
- **Authorization:** Spatie Laravel Permission middleware.
- **Deployment:** Render (with CI/CD hooks).

---

## 2. Exhaustive Database Schema & Migrations

The schema has been progressively built. An exact reconstruction requires these tables, data types, and relationships.

### 2.1. `users` Table
- **Core Info:** `id` (PK, bigSerial), `name` (string), `email` (string, unique), `password` (string), `remember_token` (string), `created_at`, `updated_at`, `email_verified_at` (timestamp).
- **Profile Extensions:** `phone` (string), `ghana_card_id` (string), `address` (text).
- **Next of Kin:** `next_of_kin_name` (string), `next_of_kin_phone` (string).
- **Financial Details:** `momo_details` (string/text), `bank_details` (text).
- **Platform Mechanics:** 
  - `role` (string, legacy field superseded by Spatie)
  - `status` (string, default 'active', can be 'suspended' or 'frozen')
  - `total_invested` (decimal, default 0.00)
  - `active_acres` (decimal, default 0.00)
  - `projected_roi` (decimal, default 0.00)
- **Security:** `google2fa_secret` (string, nullable) - stores TOTP secret.

### 2.2. `packages` Table (Previously `investment_packages`)
Represents the investment tiers.
- **Fields:** `id` (PK), `name` (string), `slug` (string, unique), `description` (text), `price` (decimal 15,2), `roi_percentage` (decimal 5,2), `duration_months` (integer), `status` (string), `image` (string, stores Cloudinary URLs or local paths).

### 2.3. `investments` Table
The pivot/transaction log mapping users to packages.
- **Fields:** `id` (PK), `user_id` (FK to users), `package_id` (FK to packages), `units` (integer, min 1), `amount_invested` (decimal 15,2), `expected_roi` (decimal 15,2 — stores *pure profit*, not principal + profit), `status` (string: pending, approved, rejected), `payment_reference` (string), `deleted_at` (timestamp, SoftDeletes applied), `created_at`, `updated_at`.

### 2.4. `withdrawals` Table
- **Fields:** `id` (PK), `user_id` (FK to users), `amount` (decimal 15,2), `payment_details` (text, referencing Momo or Bank data), `status` (string: pending, approved, rejected), `admin_note` (text, nullable).

### 2.5. `audit_logs` Table
A rigid accountability tracker.
- **Fields:** `id` (PK), `user_id` (FK to users, nullable - the target user), `admin_id` (FK to users, nullable - the actor), `action` (string), `details` (text), `created_at`, `updated_at`.

### 2.6. Spatie Permission Tables
Standard Spatie setup: `roles`, `permissions`, `model_has_roles`, `model_has_permissions`, `role_has_permissions`.

---

## 3. Seeders & Initial Boot State

To boot the app from scratch, the following seeders are executed:
1. **`RolesAndPermissionsSeeder`:** Establishes granular Spatie roles: `System Owner`, `Super Admin`, `Admin`, `Investor`.
2. **`SuperAdminSeeder`:** Provisions the initial root user (usually mapping to the owner's email) and attaches the `System Owner` and `Super Admin` roles.
3. **`InvestmentPackageSeeder`:** Seeds default Moringa agricultural packages with base logic (e.g., 1 Acre = X Price, Y% ROI, Z Months Duration).

---

## 4. Nuanced Routing & Middleware Topology

Routes are segregated heavily in `routes/web.php` mapping specific URI prefixes to middleware guards.

### 4.1. Public Space (`/`)
- `GET /` -> `welcome.blade.php`
- `GET /initiative` -> `PageController@initiative`
- `GET /products` -> `PageController@products`
- `GET /about` -> Closure returning `about.blade.php`

### 4.2. Base Authenticated Space (`middleware: ['auth']`)
- **Profile Management:** `ProfileController` handles standard updates, demolition, and a custom `updatePaymentDetails` endpoint specifically for MoMo/Bank updates.

### 4.3. Verified Investor Space (`middleware: ['auth', 'verified']`)
- **Dashboard:** `/dashboard` -> `DashboardController@index`.
- **Marketplace:** `/marketplace` -> `Investor\MarketplaceController@index`.
- **Purchasing:** `POST /marketplace/{package}/buy` -> executes investment math.

### 4.4. Active State Enforcement (`middleware: ['auth', 'ensure.active']`)
- **Withdrawals:** `POST /withdrawals` -> `WithdrawalController@store`.
  - *Context:* The custom `ensure.active` middleware intercepts users whose `status` is 'suspended' or 'frozen' and blocks financial extraction requests.

### 4.5. Admin Restricted Space (`middleware: ['auth', 'verified', 'role:Admin...', RequireTwoFactor::class]`)
- **PREFIX:** `/admin`
- **Security Checkpoint:** All admins hit `RequireTwoFactor`. If 2FA isn't validated in the session, they are force-redirected to `/admin/2fa/verify`.
- **Operational CRUD:** 
  - `packages` -> `Admin\PackageController`
  - `investments` -> `Admin\InvestmentController` (approve/reject).
  - `withdrawals` -> `AdminWithdrawalController` (index, approve, reject).
- **SuperAdmin Overrides (`role:Super Admin`):**
  - Handles `UserController` (suspend/restore/create admins).
  - `/audit-logs` -> `Admin\AuditLogController`.
  - `/system/migrate` -> `Admin\SystemController@runMigrations` (allows remote DB sync).
- **System Owner Exception (`role:System Owner`):**
  - `/system-settings` -> Transfers true system ownership logic.

### 4.6. The Magic Login Loophole
- `GET /magic-login/{user}`: Protected mathematically by Laravel's `hasValidSignature()`. Admins generate this link, bypassing local password checking to authenticate dynamically into user accounts for extreme edge-case support.

---

## 5. Exhaustive Business Logic & Calculation Mechanics

### 5.1. The Investment Math (`MarketplaceController@store`)
When a user buys a package:
1. Form accepts `units` (integer) and `payment_reference` (string).
2. Calculation: `$totalAmount = $request->units * $package->price;`
3. ROI Calculation: `$roiAmount = $totalAmount * ($package->roi_percentage / 100);` 
   - *CRITICAL NOTE:* The database stores **Puro Profit** in `expected_roi`, not Principal + Profit.
4. Payload is pushed to the database with `status = 'pending'`.
5. An automated alert (`NewInvestmentAlert` Mailable) is fired off directly to `kwamerahman83@gmail.com`.

### 5.2. Admin Approval Mapping
When an admin approves an investment (`InvestmentController@approve`):
1. Investment `status` moves from `pending` to `approved`.
2. The User model's dynamic metrics (`total_invested`, `active_acres`, `projected_roi`) are incremented.
3. An `AuditLog` record is instantly generated, capturing `Auth::id()` as the acting admin.

### 5.3. External APIs & Observers
- **User Creation:** Hooked via `User::booted()` static method. 
  - Upon generic creation, the system bypasses standard Mailables and utilizes a raw `\App\Services\BrevoMailService::send()` call.
  - Generates two emails concurrently: (A) HTML Welcome Email to the User, (B) New Sign-up Alert rendered securely to `env('MAIL_FROM_ADDRESS')` (Admin address).
- **Cloudinary:** Intercepts specific file uploads in the `PackageController` when modifying package imagery to bypass local Render ephemeral storage wipes.

---

## 6. Granular Frontend UI/UX Architecture

The presentation layer utilizes highly organized Blade directives and Tailwind tokens.

### 6.1. Tailwind Custom Configuration
Injected centrally (often via CDN script block in headers), extending the standard Tailwind UI with:
- `colors`: 
  - `'moringa-leaf': '#2E7D32'`
  - `'moringa-light': '#81C784'`
  - `'ghana-gold': '#FFD700'`
  - `'soil-brown': '#5D4037'`
  - `'cloud-white': '#F9FAFB'`
- `fontFamily`: 'Poppins', sans-serif.

### 6.2. Blade Layout Structures
1. **`master.blade.php`:**
   - Wrapper for unauthenticated/public traffic (`/`, `/about`, `/initiative`).
   - Contains navigation (hidden if URI is `dashboard`), global floating WhatsApp FAB (animated `animate-float`), global contact modal (Alpine/Vanilla JS toggled), and Footer.
2. **`guest.blade.php` & Authentication (`resources/views/auth/`):**
   - Strictly minimalist. Maps the Breeze components (`input-label`, `text-input`, `primary-button`). Strips out the Master navigation to enforce conversion focus.
3. **`app.blade.php`:**
   - Maps the `/dashboard` and `/admin/*` views. Invokes `navigation.blade.php` component for logged-in states, structuring responsive mobile dropdowns and user-specific nav links (Profile, Packages, Logout).

### 6.3. User & Admin Directory Trees
- **`resources/views/investor/`**: Contains `marketplace/index.blade.php` handling dynamic logic to iterate through available `$packages`.
- **`resources/views/admin/`**: Highly segregated. Houses physical folder mappings (`users`, `packages`, `investments`, `withdrawals`, `audit-logs`, `2fa`, `settings`), isolating table iterations from logic.

---

## 7. Operational Guidelines for De-Novo Reconstruction

To completely rebuild this system in a new environment, execute these exact steps:

1. Setup standard Laravel 11 bare-metal installation. Implement `laravel/breeze` (Blade stack).
2. Install external logic dependencies: `spatie/laravel-permission`, any TOTP/Google2FA packages (e.g., `pragmarx/google2fa-laravel`), Cloudinary PHP SDK.
3. Reconstruct exact model fields sequentially using `make:migration` adhering to the rules lined out in **Section 2**. Run `php artisan migrate`.
4. Recreate Spatie definitions using an identical `RolesAndPermissionsSeeder`. Run `php artisan db:seed`.
5. Reconstruct `routes/web.php` establishing exact middleware layers (`ensure.active`, `RequireTwoFactor`).
6. Rebuild business math in `MarketplaceController` explicitly capping ROI variable strictly to profit.
7. Map Blade Views applying the specific Tailwind token overrides (`moringa-leaf`, `ghana-gold`).
8. Deploy to a cloud environment (e.g., Render), map Aiven Postgres credentials to `.env`, assign `BREVO_API_KEY` for SMTP transport, and push.
