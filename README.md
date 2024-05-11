# kitchenSpurs

Task Management Application API

## Requirements

-   Laravel 10.x (PHP 8.2)
-   NodeJS > 14
-   Composer

## How to install

### Clone Repository

open your terminal, go to the directory that you will install this project, then run the following command:

```bash
git clone https://github.com/Vaibhavgawali/kitchenSpurs.git

cd kitchenSpurs
```

### Install packages

Install vendor using composer

```bash
composer install
```

### Configure .env

Copy .env.example file

```bash
cp .env.example .env
```

Add mysql database name in .env file

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=KitchenSpurs
DB_USERNAME=root
DB_PASSWORD=
```

Then run the following command :

```php
php artisan key:generate
```

### Migrate Data

Run the following command to generate all tables :

```php
php artisan migrate
```

Run the following command to seed dummy data of Users:

```php
php artisan db:seed --class=UserSeeder
```

### Running Application

To serve the laravel app, you need to run the following command in the project director (This will serve your app, and give you an adress with port number 8000 or etc)

-   **Note: You need run the following command into new terminal tab**

```php
php artisan serve
```

### User Login Details

```php
email : vaibhav@example.com
password : password
```

### Postman API Link

You can find the Postman API collection [here](https://api.postman.com/collections/34860756-e4c35097-9157-4144-9e19-82ff66322ad1?access_key=PMAT-01HXM3DWYPZJ5KKPBSMBFPFFG5).

## Authentication

To authenticate requests, include a bearer token in the header:

```php
Authorization: Bearer <your_token_here>
```

## Base URL

```php
http://127.0.0.1:8000/api
```

## Endpoints

## Login

### Description

Logs in a user and returns a bearer token if the provided credentials are correct.

### Login Request

-   **URL:** `/login`
-   **Method:** `POST`
-   **Headers:**
    -   `Content-Type: application/json`
-   **Body:**
    ```json
    {
        "email": "vaibhav@example.com",
        "password": "password"
    }
    ```

### 1. Get Tasks

-   **URL:** `/tasks`
-   **Method:** `GET`
-   **Description:** Retrieve all tasks.
-   **Parameters:**
    -   None
-   **Request Headers:**
    -   `Authorization: Bearer <your_token_here>`
-   **Response:**

    -   Status: 200 OK
    -   Body:

        ```json
        {
            "tasks": [
                {
                    "id": 1,
                    "title": "Task 1",
                    "description": "Description of Task 1",
                    "due_date": "2024-05-13",
                    "status": "pending",
                    "created_at": "2024-05-08T18:33:05.000000Z",
                    "updated_at": "2024-05-08T18:33:05.000000Z"
                },
                {
                    "id": 2,
                    "title": "Task 2",
                    "description": "Description of Task 2",
                    "due_date": "2024-05-13",
                    "status": "pending",
                    "created_at": "2024-05-08T18:33:05.000000Z",
                    "updated_at": "2024-05-08T18:33:05.000000Z"
                }
            ]
        }
        ```

### 2. Create Task

-   **URL:** `/tasks`
-   **Method:** `POST`
-   **Description:** Create a new task.
-   **Parameters:**
    -   `title` (string, required): Title of the task.
    -   `description` (string, optional): Description of the task.
    -   `due_date` (string, optional): Due date of the task in YYYY-MM-DD format.
    -   `status` (string, optional): Status of the task. Can be one of "pending", "in progress", or "completed"..
-   **Request Headers:**
    -   `Authorization: Bearer <your_token_here>`
-   **Request Body:**
    ```json
    {
        "title": "New Task",
        "description": "Description of the new task",
        "status": "in progress",
        "created_at": "2024-05-08T18:33:05.000000Z",
        "updated_at": "2024-05-08T18:33:05.000000Z"
    }
    ```
