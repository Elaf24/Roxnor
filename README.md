# Roxnor - PHP Form Submission System with Authentication

[![PHP Version](https://img.shields.io/badge/PHP-8.1-blue.svg)](https://www.php.net/)
[![Docker](https://img.shields.io/badge/Docker-Ready-2496ED.svg)](https://www.docker.com/)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

A simple, production-ready web application built with **pure PHP** (no frameworks) following **MVC architecture**, **OOP principles**, **PSR-4 autoloading**, and **PSR-1 naming conventions**. The application includes user authentication, validated form submission system, and comprehensive reporting features, all containerized with Docker.

## 🚀 Quick Start (Docker)

### Docker Hub Image

**Image URL**: https://hub.docker.com/r/elaf24/roxnor

**Pull Command**:

```bash
docker pull elaf24/roxnor:latest
```

### Run with Docker Compose

1. **Clone the repository**

   ```bash
   git clone https://github.com/Elaf24/Roxnor.git
   cd roxnor
   ```

2. **Start containers** (uses Docker Hub image automatically)

   ```bash
   docker-compose up -d
   ```

3. **Access the application**

   - Open browser: `http://localhost:8080`
   - Database is automatically initialized

4. **Create your first account**
   - Go to: `http://localhost:8080/login.php`
   - Click "Sign Up" tab and register

That's it! The application is ready to use.

## ⚡ Key Highlights

- ✅ **Pure PHP** - No frameworks, clean MVC architecture
- ✅ **Docker Ready** - Pre-built image on Docker Hub: `elaf24/roxnor:latest`
- ✅ **Complete Authentication** - Signup, Login, Logout with session management
- ✅ **Form Submission** - Validated form with frontend (JS) and backend (PHP) validation
- ✅ **Reporting System** - View and filter submissions by date range and user ID
- ✅ **PSR Standards** - PSR-4 autoloading and PSR-1 naming conventions
- ✅ **Security** - Password hashing, SQL injection prevention, XSS protection
- ✅ **24-Hour Rate Limiting** - Cookie-based submission prevention

## 📋 Table of Contents

- [Features](#-features)
- [Requirements](#-requirements)
- [Installation](#-installation)
- [Usage](#-usage)
- [Project Structure](#-project-structure)
- [Architecture](#-architecture)
- [Database Schema](#-database-schema)
- [Validation Rules](#-validation-rules)
- [Docker Deployment](#-docker-deployment)
- [API Endpoints](#-api-endpoints)
- [Security Features](#-security-features)
- [Development](#-development)
- [Troubleshooting](#-troubleshooting)
- [Contributing](#-contributing)
- [License](#-license)

## ✨ Features

### 🔐 Authentication Module

- **User Signup**

  - Fields: name, email (unique), password (hashed with bcrypt)
  - Frontend validation (JavaScript)
  - Backend validation (PHP)
  - Email uniqueness check

- **User Login**

  - Email and password authentication
  - Session-based authentication
  - Secure session management
  - Automatic redirect for authenticated users

- **Protected Routes**

  - Only logged-in users can access protected pages
  - Automatic redirect to login page for unauthorized access
  - Session-based access control

- **Logout**
  - Session destruction
  - Secure logout functionality

### 📝 Data Submission Module

- **MySQL Database Table**

  - All required fields as per specification
  - Proper data types and constraints
  - Auto-increment primary key
  - Timestamp tracking

- **Frontend Form**

  - JavaScript-based validation
  - Real-time validation feedback
  - Multiple items management interface
  - Phone number auto-formatting (880 prepend)
  - Word count for note field (30 words limit)

- **Backend Validation**

  - Server-side PHP validation
  - Comprehensive input sanitization
  - Type checking and format validation

- **AJAX Submission**

  - Asynchronous form submission
  - No page reload
  - Real-time error handling
  - Success/error feedback

- **Automatic Field Population**

  - `buyer_ip`: Automatically captured from user's browser IP
  - `hash_key`: SHA-512 encrypted string of `receipt_id` + salt
  - `entry_at`: Submission date in local timezone (Asia/Dhaka)

- **24-Hour Submission Prevention**
  - Cookie-based prevention mechanism
  - Prevents multiple submissions within 24 hours
  - User-specific cookie tracking

### 📊 Reporting Module

- **View All Submissions**

  - Comprehensive table view
  - All submission fields displayed
  - User information included

- **Advanced Filtering**
  - Filter by date range (start date and/or end date)
  - Filter by user ID (entry_by)
  - Real-time filtering with AJAX
  - Reset filters functionality

## 📦 Requirements

### System Requirements

- **PHP**: >= 7.4 (8.1 recommended)
- **MySQL**: 8.0 or higher
- **Composer**: For dependency management
- **Docker**: For containerized deployment (recommended)
- **Docker Compose**: For multi-container orchestration

### PHP Extensions

- PDO
- PDO_MySQL
- mysqli
- session
- json
- mbstring

## 📦 Installation (Detailed)

### Option 1: Docker (Recommended)

The Docker Hub image is pre-built and ready to use. The `docker-compose.yml` file automatically pulls the image from Docker Hub.

1. **Start Docker containers**

   ```bash
   docker-compose up -d
   ```

2. **Verify containers are running**

   ```bash
   docker-compose ps
   ```

3. **Access the application**
   - Open your browser: `http://localhost:8080`
   - Database is automatically initialized

### Option 2: Local Installation (Without Docker)

1. **Install dependencies**

   ```bash
   composer install
   ```

2. **Configure database**

   - Update `config/database.php` with your database credentials
   - Import `database/schema.sql` to your MySQL database

3. **Configure application**

   - Update `config/app.php` if needed
   - Set proper timezone

4. **Start PHP development server**

   ```bash
   php -S localhost:8000 -t public
   ```

5. **Access the application**
   - Open your browser: `http://localhost:8000`

## 💻 Usage

### First Time Setup

1. **Access the login page**

   - Navigate to: `http://localhost:8080/login.php`

2. **Create an account**

   - Click on "Sign Up" tab
   - Fill in:
     - Name
     - Email (must be unique)
     - Password (minimum 6 characters)
   - Submit the form

3. **Login**
   - Enter your email and password
   - Click "Login"
   - You'll be redirected to the submission form

### Form Submission

1. **Fill out the submission form**

   - **Amount**: Enter a positive number
   - **Buyer**: Text, spaces, and numbers only (max 20 characters)
   - **Receipt ID**: Letters only (max 20 characters)
   - **Items**: Click "Add Item" to add multiple items (text only)
   - **Buyer Email**: Valid email format (max 50 characters)
   - **Note**: Any text including Unicode (max 30 words)
   - **City**: Text and spaces only (max 20 characters)
   - **Phone**: Numbers only (880 will be auto-prepended)
   - **Entry By**: Positive number

2. **Submit the form**
   - Click "Submit" button
   - Form is submitted via AJAX
   - Success/error message will be displayed
   - Note: Only one submission per 24 hours is allowed

### View Reports

1. **Navigate to Reports**

   - Click "Report" in the navigation bar
   - Or visit: `http://localhost:8080/report.php`

2. **Filter submissions**

   - **By Date Range**: Select start date and/or end date
   - **By User ID**: Enter the entry_by user ID
   - Click "Filter" to apply filters
   - Click "Reset" to clear all filters

3. **View results**
   - All matching submissions are displayed in a table
   - Results update dynamically via AJAX

## 📁 Project Structure

```
roxnor/
├── app/
│   ├── Controllers/          # Controller classes (MVC)
│   │   ├── AuthController.php
│   │   └── SubmissionController.php
│   ├── Core/                 # Core application classes
│   │   ├── Bootstrap.php     # Application initialization
│   │   ├── Controller.php    # Base controller class
│   │   ├── Database.php      # Database connection (Singleton)
│   │   └── Session.php       # Session management
│   ├── Models/                # Model classes (MVC)
│   │   ├── Submission.php    # Submission model
│   │   └── User.php          # User model
│   └── Views/                 # View templates (MVC)
│       ├── login.php         # Login/Signup page
│       ├── report.php        # Report page
│       └── submission_form.php # Submission form page
├── config/                    # Configuration files
│   ├── app.php               # Application configuration
│   └── database.php          # Database configuration
├── database/                  # Database files
│   └── schema.sql            # Database schema (SQL)
├── public/                    # Public web root
│   ├── css/
│   │   └── style.css         # Application styles
│   ├── js/
│   │   ├── auth.js           # Authentication JavaScript
│   │   ├── report.js         # Report filtering JavaScript
│   │   └── submission.js     # Form submission JavaScript
│   ├── index.php             # Submission form entry point
│   ├── login.php             # Login/Signup entry point
│   ├── logout.php            # Logout handler
│   ├── report.php            # Report page entry point
│   └── submit.php            # Form submission handler
├── vendor/                    # Composer dependencies (auto-generated)
├── .dockerignore             # Docker ignore file
├── .gitignore                # Git ignore file
├── composer.json             # Composer configuration
├── composer.lock             # Composer lock file
├── Dockerfile                # Docker image configuration
├── docker-compose.yml        # Docker Compose configuration
└── README.md                 # This file
```

## 🏗️ Architecture

### MVC Pattern

The application follows the **Model-View-Controller** architectural pattern:

- **Models** (`app/Models/`): Handle all database operations and business logic

  - `User.php`: User authentication and management
  - `Submission.php`: Form submission data management

- **Views** (`app/Views/`): Present data to users (HTML templates)

  - `login.php`: Authentication interface
  - `submission_form.php`: Form submission interface
  - `report.php`: Report viewing interface

- **Controllers** (`app/Controllers/`): Handle HTTP requests and coordinate between Models and Views
  - `AuthController.php`: Authentication logic
  - `SubmissionController.php`: Form submission and reporting logic

### OOP Principles

- **Encapsulation**: Private/protected properties and methods
- **Inheritance**: Controllers extend base `Controller` class
- **Single Responsibility**: Each class has one clear purpose
- **Dependency Injection**: Database connection via Singleton pattern

### PSR Standards

- **PSR-4 Autoloading**: Implemented via Composer
  - Namespace: `App\`
  - Base directory: `app/`
- **PSR-1 Naming Conventions**:
  - Classes: `PascalCase` (e.g., `AuthController`)
  - Methods: `camelCase` (e.g., `getUserId()`)
  - Constants: `UPPER_SNAKE_CASE`
  - Properties: `camelCase`

## 🗄️ Database Schema

### Tables

#### `users`

Stores user authentication information.

| Column     | Type         | Description                 |
| ---------- | ------------ | --------------------------- |
| id         | INT          | Primary key, auto-increment |
| name       | VARCHAR(255) | User's full name            |
| email      | VARCHAR(255) | User's email (unique)       |
| password   | VARCHAR(255) | Hashed password (bcrypt)    |
| created_at | TIMESTAMP    | Account creation timestamp  |

#### `submissions`

Stores form submission data.

| Column      | Type         | Description                       |
| ----------- | ------------ | --------------------------------- |
| id          | BIGINT(20)   | Primary key, auto-increment       |
| amount      | INT(10)      | Transaction amount                |
| buyer       | VARCHAR(255) | Buyer name                        |
| receipt_id  | VARCHAR(20)  | Receipt identifier                |
| items       | VARCHAR(255) | Comma-separated items             |
| buyer_email | VARCHAR(50)  | Buyer's email                     |
| buyer_ip    | VARCHAR(20)  | Buyer's IP address                |
| note        | TEXT         | Submission notes (max 30 words)   |
| city        | VARCHAR(20)  | City name                         |
| phone       | VARCHAR(20)  | Phone number (with 880 prefix)    |
| hash_key    | VARCHAR(255) | SHA-512 hash of receipt_id + salt |
| entry_at    | DATE         | Submission date                   |
| entry_by    | INT(10)      | User ID who submitted             |
| created_at  | TIMESTAMP    | Submission timestamp              |

See `database/schema.sql` for complete SQL schema.

## ✅ Validation Rules

### Frontend Validation (JavaScript)

All validations are performed in real-time before form submission:

1. **Amount**: Only positive numbers (`/^\d+$/`)
2. **Buyer**: Text, spaces, and numbers only; max 20 characters (`/^[a-zA-Z0-9\s]+$/`)
3. **Receipt ID**: Letters only; max 20 characters (`/^[a-zA-Z]+$/`)
4. **Items**: Text only; at least one item required
5. **Buyer Email**: Valid email format; max 50 characters
6. **Note**: Max 30 words (word count displayed in real-time)
7. **City**: Text and spaces only; max 20 characters (`/^[a-zA-Z\s]+$/`)
8. **Phone**: Numbers only; auto-prepended with "880"
9. **Entry By**: Positive numbers only (`/^\d+$/`)

### Backend Validation (PHP)

Server-side validation ensures data integrity:

- All frontend validations are re-validated
- Type checking and format validation
- SQL injection prevention via prepared statements
- XSS prevention via output escaping
- Unicode support for note field

## 🐳 Docker Deployment

### Docker Configuration

The project includes complete Docker setup:

- **Dockerfile**: PHP 8.1 + Apache web server
- **docker-compose.yml**: Multi-container orchestration (Web + MySQL)

### Services

#### Web Server (PHP 8.1 + Apache)

- **Container**: `roxnor_web`
- **Port**: `8080:80`
- **Document Root**: `/var/www/html/public`
- **Features**:
  - PHP 8.1 with required extensions
  - Apache with mod_rewrite enabled
  - Composer pre-installed
  - Auto-configured Apache virtual host

#### MySQL Database

- **Container**: `roxnor_db`
- **Port**: `3306:3306`
- **Database**: `roxnor_db`
- **Credentials**:
  - Username: `root`
  - Password: `root`
- **Features**:
  - MySQL 8.0
  - Auto-initialization with schema.sql
  - Persistent data volume

### Environment Variables

Configure in `docker-compose.yml`:

| Variable    | Default                 | Description                  |
| ----------- | ----------------------- | ---------------------------- |
| `DB_HOST`   | `db`                    | Database hostname            |
| `DB_NAME`   | `roxnor_db`             | Database name                |
| `DB_USER`   | `root`                  | Database username            |
| `DB_PASS`   | `root`                  | Database password            |
| `BASE_URL`  | `http://localhost:8080` | Application base URL         |
| `HASH_SALT` | `roxnor_salt_key_2024`  | Salt for hash key generation |

### Docker Commands

```bash
# Build and start containers
docker-compose up -d

# View logs
docker-compose logs -f

# Stop containers
docker-compose down

# Restart containers
docker-compose restart

# Rebuild containers
docker-compose up -d --build

# Access web container shell
docker-compose exec web bash

# Access database
docker-compose exec db mysql -uroot -proot roxnor_db
```

### Building the Docker Image (Optional)

If you want to build the image yourself instead of using the pre-built one:

```bash
# Build image
docker build -t elaf24/roxnor:latest .

# Push to Docker Hub (requires login)
docker login
docker push elaf24/roxnor:latest
```

## 🔌 API Endpoints

### Authentication Endpoints

- **POST** `/login.php` (action=signup)

  - Sign up new user
  - Body: `name`, `email`, `password`
  - Response: JSON with success/error

- **POST** `/login.php` (action=login)

  - User login
  - Body: `email`, `password`
  - Response: JSON with success/error

- **GET** `/logout.php`
  - User logout
  - Redirects to login page

### Submission Endpoints

- **POST** `/submit.php`
  - Submit form data
  - Requires: Authentication
  - Body: All form fields
  - Response: JSON with success/error
  - Rate Limit: 1 submission per 24 hours

### Report Endpoints

- **GET** `/report.php`
  - View all submissions
  - Query Parameters:
    - `start_date`: Filter start date (optional)
    - `end_date`: Filter end date (optional)
    - `entry_by`: Filter by user ID (optional)
  - Response: HTML page or JSON (if AJAX)

## 🔒 Security Features

1. **Password Security**

   - Bcrypt hashing with `password_hash()`
   - Secure password verification

2. **SQL Injection Prevention**

   - All queries use prepared statements
   - PDO with parameter binding

3. **XSS Prevention**

   - Output escaping with `htmlspecialchars()`
   - Input sanitization

4. **Session Security**

   - Secure session management
   - Session-based authentication
   - Automatic session timeout

5. **Input Validation**

   - Frontend validation (JavaScript)
   - Backend validation (PHP)
   - Type checking and format validation

6. **Rate Limiting**
   - Cookie-based 24-hour submission limit
   - Prevents abuse and spam

## 🛠️ Development

### Code Structure

- **PSR-4 Autoloading**: All classes follow PSR-4 standard
- **PSR-1 Naming**: Consistent naming conventions
- **MVC Architecture**: Clear separation of concerns
- **OOP Principles**: Object-oriented design patterns

### Core Classes

- **`Database`**: Singleton pattern for database connection
- **`Session`**: Session management wrapper
- **`Controller`**: Base controller with common methods
- **`Bootstrap`**: Application initialization

### Adding New Features

1. Create model in `app/Models/`
2. Create controller in `app/Controllers/`
3. Create view in `app/Views/`
4. Add route in `public/` directory
5. Follow PSR-4 and PSR-1 standards

### Testing

```bash
# Run in Docker
docker-compose exec web php -v

# Test database connection
docker-compose exec web php -r "require 'vendor/autoload.php'; use App\Core\Database; Database::getInstance();"
```

## 🐛 Troubleshooting

### Common Issues

#### Database Connection Error

```bash
# Check if database container is running
docker-compose ps

# Check database logs
docker-compose logs db

# Restart database
docker-compose restart db
```

#### Composer Autoload Error

```bash
# Install dependencies
docker-compose exec web composer install

# Regenerate autoload
docker-compose exec web composer dump-autoload
```

#### Permission Issues

```bash
# Fix permissions in container
docker-compose exec web chown -R www-data:www-data /var/www/html
docker-compose exec web chmod -R 755 /var/www/html
```

#### Port Already in Use

```bash
# Change port in docker-compose.yml
# Edit: ports: "8080:80" to "8081:80"
docker-compose up -d
```

### Debug Mode

Enable error reporting in `config/app.php`:

```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

## 🤝 Contributing

Contributions are welcome! Please follow these guidelines:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Follow PSR-4 and PSR-1 standards
4. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
5. Push to the branch (`git push origin feature/AmazingFeature`)
6. Open a Pull Request

### Coding Standards

- Follow PSR-4 autoloading standard
- Follow PSR-1 naming conventions
- Use meaningful variable and function names
- Add comments for complex logic
- Keep functions small and focused

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.


