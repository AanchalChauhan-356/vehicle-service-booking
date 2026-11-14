# AutoCare - Vehicle Service Booking System
PHP forms + SQLite. Customers book vehicle services; admin manages bookings.

**Demo logins:** admin `admin@vsbs.com` / `admin123`  |  customer `demo@vsbs.com` / `demo123`

## Run in GitHub Codespaces
```
cd VehicleServiceBooking      # only if your files are inside this folder
php -S 0.0.0.0:8000
```
Open the Ports tab -> globe icon beside port 8000.

## Deploy on Render (free, GitHub login)
1. render.com -> Sign in with GitHub -> New -> Web Service -> pick this repo.
2. Language/Runtime: Docker. Root Directory: the folder that contains the Dockerfile (VehicleServiceBooking if your files are in that folder, otherwise blank).
3. Instance type: Free -> Create Web Service. Wait ~3-5 minutes; open the onrender.com link.
Note: on the free plan the SQLite database resets when the service sleeps/redeploys (demo data is re-created automatically).
