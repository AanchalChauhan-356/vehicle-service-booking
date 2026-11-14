[README.md](https://github.com/user-attachments/files/34842956/README.md)
<div align="center">

# AutoCare - Vehicle Service Booking System

**Book your vehicle service online in under a minute.**

A web application built with **PHP forms** and **SQLite** where customers book vehicle services and the workshop admin manages bookings.

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?logo=php&logoColor=white)
![SQLite](https://img.shields.io/badge/SQLite-3-003B57?logo=sqlite&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?logo=javascript&logoColor=black)

**Live demo:** _add your Render link here_

</div>

---

## Problem Statement
Most small workshops still take service appointments over phone calls and paper registers. Customers cannot see which slots are free, workshops get double bookings, and nobody can track the status of a job. This project provides a simple online system to solve these problems without any complex setup.

## Screenshots


| Home | Services |
|---|---|
| ![Home](screenshots/home.png) | ![Services](screenshots/services.png) |

| Book a Service | My Bookings |
|---|---|
| ![Book](screenshots/book.png) | ![My Bookings](screenshots/my_bookings.png) |

| Login | Admin Dashboard |
|---|---|
| ![Login](screenshots/login.png) | ![Admin](screenshots/admin_dashboard.png) |

## Features

**Customer**
- Register and log in securely
- Book a service with vehicle type, model, registration number, date and time slot
- Live estimated cost and duration on the booking form
- View all bookings with status (Pending, Confirmed, Completed, Cancelled) and cancel them

**Admin**
- Dashboard with total bookings, pending count, customers and revenue
- View, filter and update the status of every booking
- Add and delete services

**System**
- Slot capacity control: maximum 2 vehicles per time slot
- Rejects past dates and Sundays (workshop closed)
- Role-based access (customer and admin)
- Security: hashed passwords, prepared statements (SQL injection safe), CSRF tokens, output escaping (XSS safe)
- Zero-setup database: SQLite file is created automatically on first run

## Tech Stack

| Layer | Technology |
|---|---|
| Front-end | HTML5, CSS3, JavaScript |
| Back-end | PHP 8 (form handling, sessions, validation) |
| Database | SQLite 3 via PDO |
| Server | PHP built-in server (`php -S`) |
| Hosting | GitHub Codespaces / Render (Docker) |

## Demo Logins

| Role | Email | Password |
|---|---|---|
| Admin | `admin@vsbs.com` | `admin123` |
| Customer | `demo@vsbs.com` | `demo123` |

You can also create a new customer account from the **Register** page.

## Project Structure

```
VehicleServiceBooking/
├── index.php, services.php       # public pages
├── register.php, login.php       # authentication
├── book.php, my_bookings.php     # customer pages
├── admin/                        # dashboard, bookings, services management
├── includes/                     # db.php (PDO + helpers), header.php, footer.php
├── assets/style.css              # styling
├── data/                         # SQLite database (auto-created)
└── Dockerfile                    # for deployment
```

## Database Design

- **users** - id, name, email (unique), phone, password (hash), role
- **services** - id, name, description, price, duration_hrs
- **bookings** - id, user_id (FK), service_id (FK), vehicle_type, vehicle_model, reg_no, booking_date, time_slot, notes, status

One user can have many bookings, and one service can appear in many bookings.

## Run the Project

### Option 1: GitHub Codespaces (no installation)
1. Click **Code → Codespaces → Create codespace on main**
2. In the terminal run:
   ```bash
   cd VehicleServiceBooking
   php -S 0.0.0.0:8000
   ```
3. Open the **Ports** tab and click the globe icon next to port 8000.

### Option 2: Your own computer
Install PHP 8.1+ (with `pdo_sqlite`), then:
```bash
cd VehicleServiceBooking
php -S localhost:8000
```
Open http://localhost:8000

To reset all data, stop the server and delete `data/vsbs.sqlite`.

## Deploy on Render (free)
1. Sign in at [render.com](https://render.com) with GitHub
2. **New → Web Service** and select this repository
3. Runtime: **Docker**, Root Directory: `VehicleServiceBooking`, Instance type: **Free**
4. Click **Create Web Service** and open the generated link

> On the free plan the service sleeps after inactivity and the SQLite data resets on restart. Demo accounts are recreated automatically.

## Limitations
- No online payment gateway; payment is made at the workshop
- No email or SMS notifications
- Single workshop with fixed time slots
- No forgot-password feature
- SQLite suits modest traffic only

## Future Work
- Email / SMS / WhatsApp booking reminders
- UPI payments and invoice generation
- Save multiple vehicles and view service history
- Admin-configurable slots, holidays and capacity
- MySQL/PostgreSQL support and multi-branch deployment
- Reports, charts and export to PDF/Excel


## Author
Made by [@AanchalChauhan-356](https://github.com/AanchalChauhan-356)
