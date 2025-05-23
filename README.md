# 💻 Laravel API Starter

A boilerplate setup for a Laravel-based API application. This guide walks you through setting up, running, and testing the API locally.

---

## 🛠️ Requirements

Ensure the following are installed on your machine:

- PHP >= 8.1  
- Composer  
- Laravel 10 or newer  
- MySQL or PostgreSQL  
- Node.js & npm (if using frontend assets)  
- Postman, Insomnia, or cURL (for API testing)

---

## 🚀 Installation

Follow these steps to set up the project on your local machine:

```bash
# 1. Clone the repository
git clone git@github.com:automatonatm/whishlist_assesment_api.git
cd whishlist_assesment_api

# 2. Install PHP dependencies
composer install

# 3. Set up environment variables
cp .env.example .env
php artisan key:generate

# 4. Configure your database in the .env file
# Example:
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=your_db_name
# DB_USERNAME=your_db_user
# DB_PASSWORD=your_db_password

# 5. Run migrations
php artisan migrate

# 6. Serve the application
php artisan serve

# 7. Seed the database
php artisan db:seed

# 7. Run test
php artisan test
