# Castle Royal Agro - Ghana Green Gold Revolution (3GR)

## 📌 Project Overview
Castle Royal Agro is a robust, highly secure agricultural investment web application built to power the Ghana Green Gold Revolution (3GR). The platform allows users to browse agricultural packages, invest capital by purchasing units, track their pure-profit projected ROI, and request withdrawals upon maturity. 

The system provides administrators with a highly secure, Two-Factor Authentication (2FA) protected portal to manage the entire investment lifecycle, complete with rigorous audit logging for absolute operational transparency.

## 🛠 Tech Stack
*   **Backend Framework:** Laravel 12.x (PHP 8.2+)
*   **Database:** PostgreSQL (Cloud hosting via Aiven)
*   **Frontend Engine:** Laravel Blade, Tailwind CSS v4, Alpine.js
*   **Authentication & Authorization:** Laravel Breeze, Spatie Laravel Permission, PragmaRX Google2FA
*   **Deployment & Hosting:** Render (CI/CD Integrated)
*   **External APIs:** Brevo v3 API (Transactional Emails), Cloudinary Native PHP SDK (Media Asset Management)

## ✨ Key Features & Architecture
*   **Dynamic Investor Marketplace:** Browse and purchase agricultural packages. Logic in `MarketplaceController` explicitly calculates pure profit (`$totalAmount * ($package->roi_percentage / 100)`) and stores it safely as `expected_roi`.
*   **Advanced Role Management:** Four-tier access hierarchy (System Owner, Super Admin, Admin, Investor). System Ownership can be securely transferred via `SystemSettingController`.
*   **Fortified Admin Security:** Mandatory TOTP 2FA middleware (`RequireTwoFactor`) intercepts all admin routes.
*   **Immutable Audit Logging:** Every investment approval, rejection, withdrawal, and system change is permanently recorded with the acting admin's ID and timestamp.
*   **Automated Email Triggers:** Custom `BrevoMailService` implementation utilizing the direct HTTP API to fire instant welcome sequences, admin alerts, and withdrawal approval/rejection notifications.
*   **Cloud Asset Management:** Package imagery is uploaded directly to Cloudinary via their native PHP SDK in the `PackageController`, bypassing ephemeral server storage limitations.
*   **Magic Login Loophole:** Authorized admins can generate secure, temporary, signed URLs to bypass passwords for critical user support interventions.

## 🚀 Local Installation & Setup

**1. Clone and Initialize**
```bash
git clone <your-repository-url>
cd CastleRoyalAgro
composer install
npm install
npm run build