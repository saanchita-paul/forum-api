## Forum API

This repository contains the source code for Forum API. The API allows users to create posts. User will be able to create the post and get requests to get those posts paginated. Every post have a like feature. There is track who and how many likes have been posted for a post with like count. Every Post have multiple comments from the user.




## Installation

To set up the Forum API on your local machine, follow these steps:

- Clone the repository using the following command:

```
git clone https://github.com/saanchita-paul/forum-api.git
```

- Navigate to the cloned directory:

```
cd social-post-api
```
- Install dependencies:

```
composer install
```

- Use my provided .env file:

```
cp .env.example .env
```
- Generate an application key:

```
php artisan key:generate
```

- Configure the database in the .env file:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```
- Migrate the database:

```markdown
php artisan migrate
```


- Start the development server:

```
php artisan serve
```

- Visit [localhost](http://localhost:8000) in your web browser to use the application.


