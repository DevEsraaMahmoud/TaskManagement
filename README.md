
# Task Management API

A simple RESTful API built with Laravel 10 for managing tasks. The API supports full CRUD operations, advanced filtering, and authentication via Laravel Sanctum.

## Features

- Create, read, update, and delete tasks.
- Authentication with Laravel Sanctum.
- Task filtering by name, status, and date range.
- Soft delete support for tasks.
- Input validation for all incoming requests.
- Pagination support for listing tasks.

## Prerequisites

Before setting up the project, make sure you have the following:

- PHP >= 8.1
- Composer
- MySQL (or any other supported database)

## Installation

Follow these steps to set up the project on your local environment.

### 1. Clone the repository

```bash
git clone <repository-url>
cd <repository-folder>
```

### 2. Install dependencies

Run the following command to install all required dependencies:

```bash
composer install
```

### 3. Configure environment settings

- Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

- Open the `.env` file and configure the database settings:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### 4. Run database migrations and seeders

To set up the database tables and seed the initial data, run:

```bash
php artisan migrate --seed
```

### 5. Generate the application key

Run the following command to generate the application key:

```bash
php artisan key:generate
```

### 6. Run the application

Start the development server:

```bash
php artisan serve
```

You can now access the API at `http://127.0.0.1:8000`.

## API Endpoints

### Authentication

- **Register**: `POST /api/register`
  - Request body:
    ```json
    {
      "name": "John Doe",
      "email": "john@example.com",
      "password": "password"
    }
    ```

- **Login**: `POST /api/login`
  - Request body:
    ```json
    {
      "email": "john@example.com",
      "password": "password"
    }
    ```
  - Returns a token for subsequent API requests.

### Tasks

- **List all tasks**: `GET /api/tasks`
  - Supports query parameters for filtering:
    - `filter[name]`: Filter by task name.
    - `filter[status]`: Filter by task status.
    - `filter[created_between]`: Filter by date range (e.g., `2024-01-01,2024-12-31`).

- **Get task by ID**: `GET /api/tasks/{id}`

- **Create a task**: `POST /api/tasks`
  ```json
  {
    "name": "Task name",
    "description": "Task description",
    "status": "pending"
  }
  ```

- **Update a task**: `PUT /api/tasks/{id}`

- **Delete a task**: `DELETE /api/tasks/{id}`

## Testing

To run the test suite:
```bash
php artisan test
```

## Notes

- This API uses the `spatie/laravel-query-builder` package for advanced filtering.
- Authentication is required for all endpoints.

## License

This project is open-sourced under the MIT License.
