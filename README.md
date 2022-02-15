# LARAVEL GITHUB WRAPPER APP

A simple laravel app for middle layer between github and react app

## Instructions

Download or clone the repo.

Install dependencies
```bash
composer install
```

Create new project OAuth Apps in GitHub and set callback {front_url}/auth/github/callback

Copy .env and update values
- FRONT_APP_URL
- GITHUB_CLIENT_ID
- GITHUB_CLIENT_SECRET
- GITHUB_CALLBACK ({front_url}/auth/github/callback)

Configure database and migrate table
```bash
php artisan migrate
```

Runs the development server for the apps.
```bash
php artisan serve --port=8000
```

Hit the url in the browser
```bash
APP_URL= http://localhost:8000
```
