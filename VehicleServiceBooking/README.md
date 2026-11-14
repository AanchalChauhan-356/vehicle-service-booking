# AutoCare - Vehicle Service Booking System

PHP forms + SQLite web app. Customers book vehicle services; admin manages bookings.

## Run it with only a GitHub login (no installation)
1. Open this repository on github.com.
2. Click the green **Code** button -> **Codespaces** tab -> **Create codespace on main**.
3. Wait ~1 minute. The website opens automatically in a new browser tab.
   If it does not: open the **Ports** tab at the bottom of the editor and click the globe icon next to port **8000**.

**Admin login:** `admin@vsbs.com` / `admin123`  (customers: use Register)

If the site is not running (Codespaces sleep after 30 min idle), open the Terminal and run:
`php -S 0.0.0.0:8000 -t .`  then open port 8000 from the Ports tab.

## Run on your own PC
Install/extract PHP 8.1+ (with pdo_sqlite), then run `php -S localhost:8000` in this folder, or double-click `start.bat` on Windows.

## Structure
`index.php, services.php` public | `register.php, login.php` auth | `book.php, my_bookings.php` customer | `admin/` admin | `includes/` db + layout | `assets/` CSS | `data/` SQLite DB (auto-created)
