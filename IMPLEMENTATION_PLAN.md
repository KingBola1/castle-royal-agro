### Document 2: Master Implementation & Resumption Plan
*(Save this in your project management notes. It dictates exactly where you paused and what must happen next.)*

# Castle Royal Agro: Master Implementation Plan

## Executive Summary
This document outlines the strategic implementation phases for the Castle Royal Agro platform. Based on a comprehensive codebase audit, all core application infrastructure, security, frontend, and backend financial logic have been successfully executed. The project is currently paused in a "Pre-Flight" state.

## Phase 1: Foundation & Core Infrastructure (✅ Completed)
*   **Environment Setup:** Laravel 12 installed, Tailwind v4 configured.
*   **Database Provisioning:** PostgreSQL migrations established for `users`, `packages`, `investments`, `withdrawals`, and `audit_logs`.
*   **Authentication Scaffolding:** Laravel Breeze implemented for auth routing.

## Phase 2: System Security & Access Control (✅ Completed)
*   **Role Hierarchy:** Spatie Laravel Permission implemented with `System Owner`, `Super Admin`, `Admin`, and `Investor` roles.
*   **2FA Middleware Pipeline:** `RequireTwoFactor` active on all `admin/*` routes.
*   **Accountability Engine:** `AuditLog` interceptors actively track the `admin_id` of all critical system actions.

## Phase 3: Investor Workflows & Marketplace (✅ Completed)
*   **Marketplace Logic:** `MarketplaceController` dynamically renders packages and calculates expected ROI strictly as pure profit.
*   **Withdrawal UI:** History sorted via descending order (newest first). `WithdrawalController` calculates the true available balance (`Projected Return - Unavailable Funds`) to prevent over-drawing.

## Phase 4: Backend Operations & Admin Flow (✅ Completed)
*   **Dashboard Metrics:** `AdminController` successfully aggregates total system investments vs. pending withdrawals.
*   **Financial Processing:** `AdminWithdrawalController` successfully decrements the user's active balance (`projected_roi`) upon withdrawal approval.
*   **User Management:** `UserController` features `suspend` and `restore` methods to freeze bad actors.
*   **Cloud Integrations:** `PackageController` pushes imagery to Cloudinary via Native SDK. `BrevoMailService` handles all transactional SMTP alerts.

## Phase 5: The "Pause State" / Production Launch Prep (⏸ Currently Paused / Next Up)
*This is the exact entry point when development resumes.*
*   **Objective 5.1 (Data Sanitization):** Execute a strict database wipe of all localized test data (e.g., test accounts like "Mariam Ibrahim", dummy investments, and test packages) using `php artisan migrate:fresh`.
*   **Objective 5.2 (Live Seeding):** Run production seeders to establish the true System Owner root account and the final, legally verified Moringa package pricing.
*   **Objective 5.3 (Environment Verification):** Ensure the live Render `.env` file contains the correct production `BREVO_API_KEY`, `CLOUDINARY_URL`, and `MAIL_FROM_ADDRESS`.
*   **Objective 5.4 (End-to-End Testing):** Conduct a final, live user test involving a real account registration, package purchase, and admin withdrawal approval to verify the Brevo email sequence in a production environment.
*   **Objective 5.5 (SEO & Go-Live):** Inject final meta tags, Open Graph images, and Google Analytics tracking codes into `master.blade.php`, then point the primary domain to the Render server.