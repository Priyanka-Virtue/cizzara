### Run

- **composer install**
- **php artisan migrate:fresh --seed**
OR
- **php artisan db:seed --class=UserSeeder**

- mysql>SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));


### TODO:
- Check video upload:
    - must get correct plan id
    - must check validition with plan id
- DONE - add design template to all auth files and upload video
- aws
 
