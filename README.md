## Launch the  project 
Clone the repository
Switch to the repo folder
```
cd backend-assignement
```
Copy the example env file and make the required configuration changes in the .env file

```
cp .env.example .env
```
Install all the dependencies using composer
```
composer install
```
Run the database migrations (Set the database connection in .env before migrating)
```
php artisan migrate
```
Run the database seeder (import json data to database)

```
php artisan db:seed
```
Start the local development server

```
php artisan serve

```