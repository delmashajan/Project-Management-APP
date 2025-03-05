# Laravel Assessment Project

This project is a RESTful API built with Laravel to manage users, projects, timesheets, and dynamic attributes for projects using the EAV (Entity-Attribute-Value) model. It includes authentication, CRUD operations, dynamic attribute management, and flexible filtering.

---

## Table of Contents
1. [Features](#features)
2. [Setup Instructions](#setup-instructions)
3. [API Documentation](#api-documentation)
4. [Example Requests and Responses](#example-requests-and-responses)
5. [Test Credentials](#test-credentials)
6. [Database Schema](#database-schema)
7. [Technologies Used](#technologies-used)

---

## Features
- **Authentication**: User registration, login, and logout using Laravel Passport.
- **Core Models**:
  - User: Manage users with fields like `first_name`, `last_name`, `email`, and `password`.
  - Project: Manage projects with fields like `name` and `status`.
  - Timesheet: Manage timesheets with fields like `task_name`, `date`, and `hours`.
- **EAV Model**:
  - Attribute: Manage fields like `name` and `type`.
  - Attribute Values: Manage fields like `attribute_id`, `entity_id`, and `value`.
- **Flexible Filtering**:
  - Filter projects by regular fields and dynamic attributes.
  - Support for operators like `=`, `>`, `<`, and `LIKE`.
- **RESTful API**:
  - Standard CRUD endpoints for all models.
  - Proper validation and error handling.

---

## Setup Instructions

### Prerequisites
- PHP >= 8.0
- Composer
- MySQL
- Laravel CLI

### Steps
1. **Clone the Repository**:
   
   git clone https://github.com/delmashajan/Project-Management-APP.git
   cd project-management-app
   ```
2. **Install Dependencies**:
   
   composer install
   ```
3. **Set Up Environment**:
   
   cp .env.example .env
   ```
4. **Update `.env` with your database credentials**:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=project_management
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```
5. **Generate Application Key**:
   
   php artisan key:generate
   ```
6. **Run Migrations and Seeders**:

   php artisan migrate --seed

   ```
7. **Install Laravel Passport**:
   
   php artisan install:api --passport
   ```
8. **Start the Development Server**:
   
   php artisan serve
   ```
9. **Access the API**:
   - The API will be available at `http://localhost:8000`

---

## API Documentation

### Authentication
1. Register: `POST /api/register`
2. Login: `POST /api/login`
3. Logout: `POST /api/logout`

### Core Models
#### User
1. List Users: `GET /api/users`
2. Get User: `GET /api/users/{id}`
3. Create User: `POST /api/users`
4. Update User: `PUT /api/users/{id}`
5. Delete User: `DELETE /api/users/{id}`

#### Project
1. List Projects: `GET /api/projects`
2. Get Project: `GET /api/projects/{id}`
3. Create Project: `POST /api/projects`
4. Update Project: `PUT /api/projects/{id}`
5. Delete Project: `DELETE /api/projects/{id}`

#### Timesheet
1. List Timesheets: `GET /api/timesheets`
2. Get Timesheet: `GET /api/timesheets/{id}`
3. Create Timesheet: `POST /api/timesheets`
4. Update Timesheet: `PUT /api/timesheets/{id}`
5. Delete Timesheet: `DELETE /api/timesheets/{id}`

### EAV Model
#### Attribute
1. List Attributes: `GET /api/attributes`
2. Get Attribute: `GET /api/attributes/{id}`
3. Create Attribute: `POST /api/attributes`
4. Update Attribute: `PUT /api/attributes/{id}`
5. Delete Attribute: `DELETE /api/attributes/{id}`

#### AttributeValue
1. List Attribute Values: `GET /api/attribute-values`
2. Get Attribute Value: `GET /api/attribute-values/{id}`
3. Create Attribute Value: `POST /api/attribute-values`
4. Update Attribute Value: `PUT /api/attribute-values/{id}`
5. Delete Attribute Value: `DELETE /api/attribute-values/{id}`

### Filtering
1. Filter Projects: `GET /api/projects?filters[name]=Project A&filters[department]=IT`

---

## Example Requests and Responses

### Register User
**Request:**
```json
POST /api/register
Content-Type: application/json
{
  "first_name": "Delvin",
  "last_name": "Doe",
  "email": "delvin.doe@example.com",
  "password": "delvin@123"
}
```

**Response:**
```json
{
    "message": "User registered successfully",
    "user": {
        "first_name": "Delvin",
        "last_name": "Doe",
        "email": "delvin.doe@example.com",
        "updated_at": "2025-03-05T17:39:46.000000Z",
        "created_at": "2025-03-05T17:39:46.000000Z"
    }
}
```

### Create Project with Dynamic Attributes
**Request:**
```json
POST /api/projects
Content-Type: application/json
Authorization: Bearer {token}
{
    "name": "Project B",
    "status": "completed",
    "attributes": [
        {
            "attribute_id": 1,
            "value": "HR"
        }
    ]
}
```

**Response:**
```json
{
    "name": "Project B",
    "status": "completed",
    "updated_at": "2025-03-05T17:42:35.000000Z",
    "created_at": "2025-03-05T17:42:35.000000Z",
    "id": 4,
    "attribute_values": [
        {
            "id": 6,
            "attribute_id": 1,
            "entity_id": 4,
            "value": "HR",
            "created_at": "2025-03-05T17:42:35.000000Z",
            "updated_at": "2025-03-05T17:42:35.000000Z"
        }
    ]
}
```

---

## Test Credentials
**Email**: delmashajan@gmail.com
**Password**: delma@123

---

## Database Schema
- Users: `id, first_name, last_name, email, password, created_at, updated_at`
- Projects: `id, name, status, created_at, updated_at`
- Timesheets: `id, task_name, date, hours, user_id, project_id, created_at, updated_at`
- Attributes: `id, name, type, created_at, updated_at`
- AttributeValues: `id, attribute_id, entity_id, value, created_at, updated_at`

---

## Technologies Used
- **PHP**: >= ^8.2
- **Laravel**: ^12.0
- **MySQL**: Database
- **Laravel Passport**: Authentication
- **Postman**: API Testing

