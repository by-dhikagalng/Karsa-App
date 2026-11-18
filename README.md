# Karsa App 
  
Final project for Web Programming — Information Systems, UPNVJ. 
An application for fragment information from KSM / Organization at UPNVJ 
  
## Requirements - PHP 8.3 or newer - Composer - MySQL (XAMPP) 
  
## Running it from scratch 
1. `git clone https://github.com/by-dhikagalng/Karsa-App.git` 
2. `cd Karsa` 
 
 
3. `composer install` 
4. `cp .env.example .env`   (Windows: `copy .env.example .env`) 
5. Create an empty database called `campus_db` in phpMyAdmin 
6. Adjust DB_DATABASE in the `.env` file 
7. `php artisan key:generate` 
8. `php artisan migrate --seed` 
9. `php artisan serve` then open http://127.0.0.1:8000 
  
## Division of work 
| Name | Student no. | Part built | 
|------|-------------|------------| 
| Andhika | 2510512080 | project skeleton, Models, relations, merging PRs | 
| Adiva | 2510512111 | student list feature | 
| Nasywa | 2510512128 | program list feature | 
| Khansa | 2510512059 | program list feature | 
| Arya Ramadhan Kawi | 2510512079 | program list feature | 
