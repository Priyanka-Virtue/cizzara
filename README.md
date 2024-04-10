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
 
# Release
## 1.1
# Features
    - Name change:
        Allowed name change on credit card field
    - Comments:
        Added Comments from Guru section so that Guru can ask contestant to use different style in next round, Contestand will get email for Guru's comment If checked.
        Added warning that Guru won't be able to change rating again
    - Upload:
        Added feature for contestant so that he can upload upto 2 different style videos
    - Allowed max 100Mb file size
    - Rating
        - Guru will rate each video
        - Admin will see Average rating by all gurus
    - Export:
        Admin can now export list for contestant and videos
    - Guru login
        Admin can create, edit, delete Guru
        Added Guru login
        Admin can deactivate Guru's login        
    - Prmission:
        Only main admin will see user's personal details
        Gurus won't see other Gurus rating and avg rating
        Guru won't be able to rate If not assigned to that audition 
    - Whatsapp:
        Added whatsapp icon at bottom show that contestant can click there and start message
    - On payment success email to contestant(whatsapp message requires Business account setup so we have added email)

    - Show top scored users to admins


 # Todo:
    Connecting AWS
    Download video option
    Assign/Revoke guru to audition
    Once moved to next round, contestant should be able to add 2 new videos again
    Design changes

    
#10-04-2024
Rename auditions TUP
Filter and sort by not rated
Show rating by judges in admin
make 2 videos rating compulsory
add note for contestant 2 videos are not mandatory
show top 500 directly 
Filter by commented
Show Comments to admin
auto generate excel for entries and sent it to whatsapp
Action: qualified/disqualified/pending
Show audition No

