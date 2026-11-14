AUTOCARE - VEHICLE SERVICE BOOKING SYSTEM  (PHP + SQLite)
=========================================================
No XAMPP, no MySQL, no installer. Uses PHP's built-in web server and a single-file SQLite database.

ONE-TIME SETUP (Windows, ~30 MB)
 1. Download "VS17 x64 Thread Safe" ZIP from https://windows.php.net/download  (PHP 8.1 or newer)
 2. Extract the ZIP into a folder called  php  inside this project folder (so php\php.exe exists).
 3. Double-click  start.bat   -> browser opens at http://localhost:8000
 (If PHP is already installed on your PC, start.bat will simply use it.)

LOGIN DETAILS
 Admin    : admin@vsbs.com / admin123
 Customer : click Register to create one

FOLDER STRUCTURE
 index.php, services.php        public pages
 register.php, login.php        authentication
 book.php, my_bookings.php      customer pages
 admin/                         dashboard, bookings, services management
 includes/                      db.php (database + helpers), header.php, footer.php
 assets/style.css               styling
 data/vsbs.sqlite               auto-created on first run (delete it to reset all data)
