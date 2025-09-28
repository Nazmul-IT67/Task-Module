# Task Management API (Laravel)

A simple Laravel-based API to manage tasks (single or bulk insert).  
This project is structured for scalability and can be extended into a full task management system.

---

## 🚀 Setup Instructions

### ✅ Prerequisites

- PHP >= 8.1
- Composer
- MySQL / PostgreSQL
- Node.js & NPM (if frontend integration is required)
- Laravel 11

### ⚡ Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/your-username/task-api.git
   cd task-api
   ```

2. Install dependencies:

   ```bash
   composer install
   ```

3. Copy environment file:

   ```bash
   cp .env.example .env
   ```

4. Generate app key:

   ```bash
   php artisan key:generate
   ```

5. Configure your **.env** file (DB connection, APP_URL etc.)

6. Run migrations:

   ```bash
   php artisan migrate
   ```

7. Start local server:
   ```bash
   php artisan serve
   ```

👉 Access API at:  
`http://127.0.0.1:8000/api/tasks/bulk`

---

## 📌 API Endpoints

### Create Multiple Tasks

**POST** `/api/tasks/bulk`

#### Request Body:

```json
{
  "tasks": [
    { "title": "Task 1", "description": "Description 1" },
    { "title": "Task 2", "description": "Description 2" }
  ]
}
```

#### Success Response:

```json
{
  "success": true,
  "message": "Tasks added successfully!"
}
```

---

## 🛠 Architecture

- **Controllers**: Handle API logic (e.g., `TaskController`)
- **Models**: Eloquent ORM (`Task`)
- **Migrations**: Database schema
- **Routes**: Defined in `routes/api.php`
