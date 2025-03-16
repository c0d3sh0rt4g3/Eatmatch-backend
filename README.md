# Eatmatch-backend

Eatmatch-backend is a Laravel-based application that serves as the backend for the Eatmatch platform.

## System Requirements

The following are required for the project to function properly:

* PHP Version: 8.1
* Laravel Version: 10.0
* Node Version: 20.0
* MySQL Version: latest


## Architecture

Eatmatch-backend follows the Laravel MVC (Model-View-Controller) architecture, which separates the application logic into three interconnected components:

**Model**

- Represents the application's data and business logic
- Interacts with the database to retrieve, store, and modify data
- Maintains data consistency and integrity

**Controller**

- Handles user requests and processes inputs
- Acts as an intermediary between Models and Views
- Contains the application's business logic for handling specific actions


## Installation

Follow these steps to set up the Eatmatch-backend:

1. Clone the repository

```bash
git clone https://github.com/c0d3sh0rt4g3/Eatmatch-backend.git
```

2. Navigate to the project directory

```bash
cd Eatmatch-backend
```

3. Install Composer dependencies

```bash
composer install
```

4. Install NPM dependencies (if applicable)

```bash
npm install
```

5. Create environment file

```bash
cp .env.example .env
```

6. Generate application key

```bash
php artisan key:generate
```

7. Configure your database in the .env file

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eatmatch
DB_USERNAME=root
DB_PASSWORD=your_password
```

8. Run database migrations

```bash
php artisan migrate
```

9. Seed the database (if seeders are available)

```bash
php artisan db:seed
```

10. Set up storage link

```bash
php artisan storage:link
```

11. Set appropriate permissions (Unix/Linux)

```bash
chmod -R 777 storage bootstrap/cache
```

## Directory Structure

The project follows Laravel's standard directory structure:

- **app/** - Contains the core code of the application, including models, controllers, and middleware
- **bootstrap/** - Contains files that bootstrap the framework and configure autoloading
- **config/** - Contains all application configuration files
- **database/** - Contains database migrations, seeders, and factories
- **public/** - Contains the front controller and public assets
- **resources/** - Contains views, raw assets, and localization files
- **routes/** - Contains all route definitions
- **storage/** - Contains compiled templates, file caches, and logs
- **tests/** - Contains automated tests
- **vendor/** - Contains Composer dependencies


## Features

- Authentication with JWT (JSON Web Tokens)
- RESTful API endpoints
- Database interaction through Eloquent ORM
- CRUD operations for core application entities


## Usage

For development:

1. Start the development server

```bash
php artisan serve
```

For production:

1. Install optimized dependencies

```bash
composer install --prefer-dist --no-dev -a
```
