# Campus App 
  
Final project for Web Programming — Information Systems, UPNVJ. 
An application for recording students and their study programs. 
  
## Requirements - PHP 8.3 or newer - Composer - MySQL (XAMPP) 
  
## Running it from scratch 
1. `git clone https://github.com/NAME/campus-app.git` 
2. `cd campus-app`
3. 3. `composer install` 
4. `cp .env.example .env`   (Windows: `copy .env.example .env`) 
5. Create an empty database called `campus_db` in phpMyAdmin 
6. Adjust DB_DATABASE in the `.env` file 
7. `php artisan key:generate` 
8. `php artisan migrate --seed` 
9. `php artisan serve` then open http://127.0.0.1:8000

## Division of work already on Grand Design
