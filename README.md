# Simple PHP MVC App

A simple web application using **pure PHP** (no frameworks) following:

- MVC architecture
- OOP principles
- PSR-4 autoloading (Composer)
- PSR-1 naming conventions

Features:

- User authentication (signup, login, logout)
- Validated data submission form (frontend JS + backend PHP)
- Reporting page with date range and user ID filtering
- Dockerized (PHP-Apache + MySQL)

## Requirements

- PHP 8+
- Composer
- Docker & Docker Compose (if running via containers)

## Installation

1. Extract this project.

2. Install Composer dependencies:

   ```bash
   composer install
   ```

3. Configure environment:

   - Edit `config/config.php` if needed (DB host, credentials, base URL, salt).

4. Database:

   - The schema is defined in `database.sql`.
   - For Docker, it will be imported automatically.
   - For local MySQL, run:

     ```bash
     mysql -u root -p < database.sql
     ```

## Running with Docker

```bash
docker-compose up --build
```

- App URL: `http://localhost:8080`
- MySQL: host `mysql`, db `simple_app`, user `root`, password `rootpassword`.

## Running locally (without Docker)

1. Create the database and tables:

   ```bash
   mysql -u root -p < database.sql
   ```

2. Update `config/config.php` with your local DB host/user/password.

3. Start PHP's built-in server from project root:

   ```bash
   php -S localhost:8080 -t public
   ```

4. Open `http://localhost:8080` in your browser.

## Usage

1. Visit `/` (login page).
2. Signup a new user.
3. Login with your credentials.
4. Go to “Submit Data” to submit a form:
   - Frontend JS validates according to assignment rules.
   - Submission is sent via AJAX to `?route=submission/store`.
   - Cookie prevents multiple submissions within 24 hours.

5. Report Page:
   - Go to “Report” from navigation.
   - Filter by date range and/or user ID.

## Notes

- Passwords are hashed using `password_hash`.
- Sessions keep user logged in.
- Routes are managed with `?route=...` in `public/index.php`.
- Hash key for each submission: `sha-512` of `receipt_id` + salt.
- Buyer IP comes from `$_SERVER['REMOTE_ADDR']`.
