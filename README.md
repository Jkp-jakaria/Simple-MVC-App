Simple MVC App (PHP, MySQL, Docker)
A simple web application built with pure PHP (no frameworks), following MVC architecture, OOP principles, PSR-1, and PSR-4 autoloading.
The project includes authentication, AJAX-based form submission, validation, reporting, and is fully containerized with Docker.

---

Tech Stack
• PHP 8+ (OOP + MVC)
• MySQL 8
• Composer (PSR-4 autoloading)
• Vanilla JavaScript (AJAX + validation)
• HTML / CSS (light & dark theme)
• Docker & Docker Compose

---

Features
Authentication
• Signup (name, email, password)
• Login (email + password, hashed)
• Logout (session-based)
• Protected pages (requires login)
Data Submission
• AJAX form submission
• Frontend + backend validation
• Prevent multiple submissions (24h cookie)
• Automatic fields:
o buyer IP
o submission date
o hash key (sha-512)
Reports
• View all submissions
• Filter by date range or user ID
• Edit & delete entries
• Clean, modern UI with theme toggle

---

Project Structure
src/
├── Controllers/
├── Models/
├── Views/
├── Core/ (Database + Validator)
public/
├── index.php
├── css/
└── js/
config/
database.sql
Dockerfile
docker-compose.yml
composer.json

---

Running the Project (Docker)

1. Clone the repo
   git clone https://github.com/Jkp-jakaria/Simple-MVC-App.git
   cd Simple-MVC-App
2. Start using Docker Compose
   docker-compose up --build
   • App: http://localhost:8080
   • MySQL auto-loads database.sql with schema + sample data

---

Run Using Prebuilt Docker Image (No Setup)
docker run -p 8080:80 jkp016/simple-mvc-app:1.1
Open:
http://localhost:8080

---

Sample User (for testing)
Email: jkp.jakaria@gmail.com
Password: 123456
Or register a new account using Signup.

---

Validation Summary
• Amount: numbers only
• Buyer: letters, numbers, spaces (max 20 chars)
• Receipt ID: text
• Items: multiple items, text
• Email: valid format
• Note: max 30 words
• City: letters + spaces only
• Phone: numbers (auto prepends 880)
• Entry By: numbers only

---

About the Code
• Routing is handled by public/index.php (simple GET-based router)
• Controllers manage request handling
• Models interact with the database via PDO
• Views render templates via a shared layout
• Autoloading is handled through Composer (PSR-4)
• Dockerfile builds the app using php:8.x-apache
• docker-compose runs app + MySQL linked together

---

Author
Jakaria Kabir Provati
• GitHub: https://github.com/Jkp-jakaria/Simple-MVC-App.git
• Docker Hub: https://hub.docker.com/r/jkp016/simple-mvc-app
