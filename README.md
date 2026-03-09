# 🎮 EtecGames Remake --- Backend

![RepoSize](https://img.shields.io/github/repo-size/4NUB1Ss2/etecGamesRemake-backend?style=f)
![LastCommit](https://img.shields.io/github/last-commit/4NUB1Ss2/etecGamesRemake-backend)
![Issues](https://img.shields.io/github/issues/4NUB1Ss2/etecGamesRemake-backend)
![License](https://img.shields.io/github/license/4NUB1Ss2/etecGamesRemake-backend)
![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?logo=php)
![Laravel](https://img.shields.io/badge/Laravel-API-red?logo=laravel)
![API](https://img.shields.io/badge/API-REST-green)

Backend API for **EtecGames Remake**, a platform designed to showcase **games, applications, and websites** created by **technical school students**.

The project aims to provide a **centralized hub** where student projects can be **published, discovered, and shared**, helping preserve and highlight the work developed during **technical education programs**.

**EtecGames Remake** is a **redesigned and improved version** of my original **Technical Course Final Project (TCC)**, rebuilt with a stronger focus on **architecture**, **scalability**, and **production-ready development practices**.

---

## 📌 About

**EtecGames Remake** is designed to **centralize projects created by students from technical courses**.  
The backend provides the **core functionality of the platform**, including **authentication**, **role management**, **school association**, and **game publishing**.

**Main responsibilities of this API:**

- **User authentication**
- **Role-based access control**
- **School association**
- **Game management**
- **RESTful endpoints** for the frontend


---

## 🧱 Tech Stack

![PHP](https://img.shields.io/badge/PHP-8.4-777BB4?logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-Framework-FF2D20?logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?logo=mysql&logoColor=white)
![Composer](https://img.shields.io/badge/Composer-Dependency%20Manager-885630?logo=composer&logoColor=white)
![REST API](https://img.shields.io/badge/API-REST-25A162)


---

## 👥 Roles

The system defines different types of users with specific permissions:

| Role | Description |
|-----|-------------|
| **user** | Can view published games |
| **student** | Can create, edit and delete their own games |
| **professor** | Can manage students and games within their school |
| **admin** | Full platform management |

------------------------------------------------------------------------

## 📂 Project Structure

    app/
     ├── Http/
     │   ├── Controllers
     │   ├── Requests
     ├── Models
     ├── Services

    database/
    routes/
    config/

The architecture follows a RESTful design with separation between
controllers, services, models and validation requests.

------------------------------------------------------------------------
## 🔑 Authentication

Authentication is **planned for a future version** of the API and will
be implemented using **Laravel Sanctum** to provide **secure token-based
authentication** for protected routes.

The system will generate an **API token** when a user successfully logs
in.

**Example expected login response:**

``` json
{
  "token": "API_TOKEN"
}
```

**Authenticated requests must include the token in the Authorization
header:**

    Authorization: Bearer TOKEN

This mechanism will allow the API to **secure protected endpoints** and
ensure that **only authenticated users can access restricted
resources**.



---

## ⚙️ Installation

Clone the repository:

``` bash
git clone https://github.com/4NUB1Ss2/etecGamesRemake-backend.git
cd etecGamesRemake-backend
```

Install dependencies:

``` bash
composer install
```

Create the environment configuration file:

``` bash
cp .env.example .env
```

Generate the application key:

``` bash
php artisan key:generate
```

Configure your database inside `.env`, then run:

``` bash
php artisan migrate
```

Start the development server:

``` bash
php artisan serve
```


---

## 🚀 Features

-   **Authentication system**
-   **Game CRUD operations**
-   **School association**
-   **Role-based permissions**
-   **RESTful API design**

------------------------------------------------------------------------

## 🧪 Testing

Run tests with:

``` bash
php artisan test
```

------------------------------------------------------------------------

## 🚀 Deployment

The API can be deployed using cloud platforms or servers such as:

-   **Render**
-   **VPS**
-   **Docker environments**

------------------------------------------------------------------------

## 🤝 Contributing

1.  Fork the repository
2.  Create a feature branch

```{=html}
<!-- -->
```
    git checkout -b feature/my-feature

3.  Commit your changes
4.  Push the branch
5.  Open a Pull Request

------------------------------------------------------------------------

## 👨‍💻 Author

Giovanni Rohrig\
Backend Developer


<p align="left">
  <a href="https://github.com/4NUB1Ss2">
    <img src="https://img.shields.io/badge/GitHub-4NUB1Ss2-181717?logo=github" />
  </a>
  <a href="https://instagram.com/g.b_rohrig">
    <img src="https://img.shields.io/badge/Instagram-@g.b_rohrig-		E4405F?logo=instagram&logoColor=white" />
  </a>
</p>
