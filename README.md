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
| Andhika Galang Adisaputro | 2510512080 | Project Lead dan Koordinasi Jadwal, Fondasi Laravel (Database, Migration, Seeder), Integrasi | 
| Bekti Nur Wicaksono | 2510512043 | Authentication & Role Management (Admin KSM / Super Admin) | 
| Adiva Mayyadah Putri Prasetyo | 2510512111 | Event Management & Event Discovery (CRUD, Filter, status pendaftaran otomatis) | 
| Arya Ramadhan Kawi | 2510512073 | Poster dan Preferences (Download, Upload, Delete Poster, Kategori terakhir yang dipilih pengunjung) | 
| Nasywa Athiyyah Aufa | 2510512084 | User Interface (Layout, CSS, Tampilan Katalog, Detail, Jadwal) |
| Khansa Khayyira Kurniawan | 2510512059 | User Interaction (Javascript) | 
