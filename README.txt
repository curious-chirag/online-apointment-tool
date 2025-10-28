Instructions for running the Online Appointment Booking System project.
## How to run (quick steps)
1. Install WAMP/XAMPP and enable Apache + MySQL.
2. Place files in the `www` (WAMP) or `htdocs` (XAMPP) folder inside a directory, e.g., `appointment/`.
3. Import `database.sql` into phpMyAdmin (or run via MySQL CLI). Create DB `appointment_system`.
4. Open `config.php` and set the database credentials.
5. Visit `http://localhost/proj/index.php` in your browser.
6. Register a new user, then login and book appointments. For admin: either seed an admin account directly in DB or register and change role to 'admin' in users table.