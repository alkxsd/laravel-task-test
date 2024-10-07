## Installation instruction

## Requirements
Before running this application, ensure you have the following installed:

* **Docker Desktop:**  [Download Docker Desktop](https://www.docker.com/products/docker-desktop/)
* **Composer:** [Download Composer](https://getcomposer.org/)
* **PHP 8 or higher:** (This is typically included with Docker Desktop)
* **Postman:** [Download Postman](https://www.postman.com/downloads/) (For testing the API)
* **Available Ports(ensure these ports were not being used by other application):**
    * **Port 80:**  (For the web server)
    * **Port 3306:** (For the MySQL database)
## My approach


*   **Component-based architecture with `Livewire 3`:** I built the frontend using Livewire and WireUI, breaking down the UI into smaller, reusable components for improved organization and maintainability(See *`app\Livewire`* directory to see the action).
*   **Service classes(with Dependency Injection):** I used service classes (`TaskService`, `CategoryService`) to encapsulate business logic and promote separation of concerns and use them accross the components and api via *Dependency Injection*.
*   **Lean controllers:**  The `TaskController` primarily acts as a router for Livewire components, delegating logic and rendering to the components.
*   **WireUI components:** I utilized WireUI's pre-built components (cards, buttons, etc.) for streamlined development and a consistent UI.
*   **Data Transfer Objects (DTOs):** I used DTOs (`TaskDto`) to ensure type safety and data integrity when interacting with the `Task` model, preventing errors and maintaining data consistency.

## Stretch Goals
* Web App
    - Can filter task by title searching, status and category select filter.
    - Uses Trait(App/Traits/Tasks/Filterable)
    - Pagination implementation
* API
    - The GET api/tasks should also be able to filter with title searching, status and category, please see api doc for the GET api/tasks
    - Uses Trait(App/Traits/Tasks/Filterable)

## Installation and Usage

1. **Clone the repository:**

   ```bash
   git clone https://github.com/alkxsd/laravel-task-test
   ```
2. **Navigate to the project directory:**

    ```Bash
    cd laravel-task-test
    ```
    **NOTE: Please copy `.env.example` to `.env` at the root folder of the project and modify DB_* section if necesarry, default is MySQL. **
    ```
    ...
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=
    ...
    ```

3. **Install dependencies(to make sure it installs the `sail`):**

    ```Bash
    composer install
    ```

4. **Start Docker containers:**

    ```Bash
    ./vendor/bin/sail up -d
    ```


5. **Update Composer dependencies (`./vendor/bin/sail` ensures that we're running commands within the Docker container):**

    ```Bash
    ./vendor/bin/sail composer update
    ```

6. **Run DB migration and seed the database:**

    ```Bash
    ./vendor/bin/sail artisan migrate:fresh --seed
    ```
7. **Clear cache:**

    ```Bash
    ./vendor/bin/sail optimize:clear
    ```

7. **Visit the application in your browser:**

    ```Bash
    http://localhost/login
    ```

8. **Login with the following credentials:**
   - Email: `test@example.com`
   - Password: `password`

9. **Or register with a new user**
    ```Bash
    http://localhost/register
    ```

# Testing with PESTphp
- Covered web frontend aspect of the app
- Wrote unit testing for TaskService
- Complete feature testing on API endpoints

Simply run:
```
./vendor/bin/sail artisan test
```
Or run this for parallel testing:
```
./vendor/bin/sail artisan test --parallel
```

# Task Management API

## NOTE: You can easily interact with this API using Postman. A Postman collection file named `taskmaster-api-postman.json` is available in the root directory of the project. Simply follow these steps:

1. **Import the Postman Collection**:
   - Open Postman, and in the "File" menu, click "Import."
   - Select the `taskmaster-api-postman.json` file from the root directory of the project.

2. **Register or Login to Obtain a Token**:
   - Use the **POST Register** or **POST Login** requests under the **"Task Management API"** collection to either register a new user or log in using an existing account.
   - Both actions will return a token that is needed to authenticate other requests.

3. **Update the Token in Postman**:
   - Once you have the token, in Postman, open the **"Task Management API"** collection.
   - Navigate to the **"Variables"** tab and update the `token` variable with the token you received from logging in or registering.
4. **Implemented Laravel Policy here in case you try to modify a task id that is not created by your authenticated account and will throw this response:**
    ```
    {
        "message": "This action is unauthorized."
    }
    ```
## API Documentation
## Base URL

 ```
 http://localhost
 ```

## Authorization

All protected routes require a Bearer Token:

- Key: `Authorization`
- Value: `Bearer {{token}}`

---

### Register

- **Method**: `POST`
- **Endpoint**: `/api/register`

#### Headers

| Key   | Value               |
|-------|---------------------|
| Accept | application/json    |

#### Body

```json
{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password"
}
```

---

### Login

- **Method**: `POST`
- **Endpoint**: `/api/login`

#### Headers

| Key   | Value               |
|-------|---------------------|
| Accept | application/json    |

#### Body

```json
{
    "email": "test@example.com",
    "password": "password"
}
```

---

### Get Tasks

- **Method**: `GET`
- **Endpoint**: `/api/tasks`
- **Authorization**: Bearer Token required

#### Headers

| Key   | Value               |
|-------|---------------------|
| Accept | application/json    |


#### Query Parameters

| Parameter | Description                                    |
| --------- | ---------------------------------------------- |
| `search`   | (Optional) Search by task title                |
| `status`   | (Optional) Filter by task status(eg: *"New"*, *"In Progress"*, *"Under Review"*, *"Completed"* )              |
| `category_id` | (Optional) Filter by category ID            |

---

### Create Task

- **Method**: `POST`
- **Endpoint**: `/api/tasks`
- **Authorization**: Bearer Token required

#### Headers

| Key   | Value               |
|-------|---------------------|
| Accept | application/json    |

#### Body

```json
{
    "title": "New API Task",
    "description": "This is a task created via the API",
    "category_id": 1,
    "status": "New"
}
```

---

### Get Task

- **Method**: `GET`
- **Endpoint**: `/api/tasks/{task_id}`
- **Authorization**: Bearer Token required

#### Headers

| Key   | Value               |
|-------|---------------------|
| Accept | application/json    |

---

### Update Task

- **Method**: `PUT`
- **Endpoint**: `/api/tasks/{task_id}`
- **Authorization**: Bearer Token required

#### Headers

| Key   | Value               |
|-------|---------------------|
| Accept | application/json    |

#### Body

```json
{
    "title": "Updated API Task",
    "description": "This task was updated via the API",
    "category_id": 2,
    "status": "In Progress"
}
```

---

### Delete Task

- **Method**: `DELETE`
- **Endpoint**: `/api/tasks/{task_id}`
- **Authorization**: Bearer Token required

#### Headers

| Key   | Value               |
|-------|---------------------|
| Accept | application/json    |

---

### Update Task Status

- **Method**: `POST`
- **Endpoint**: `/api/tasks/{task_id}/update-status`
- **Authorization**: Bearer Token required

#### Headers

| Key   | Value               |
|-------|---------------------|
| Accept | application/json    |

#### Body

```json
{
    "status": "Under Review"
}
```

---

## Variables

| Key     | Value        |
|---------|--------------|
| baseUrl | localhost    |
| token   | [your_token] |

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
