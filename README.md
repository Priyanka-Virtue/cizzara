### Run

- **composer install**
- **php artisan migrate:fresh --seed**
OR
- **php artisan db:seed --class=UserSeeder**

- mysql>SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));


 
# Release
## 1.1
# Features

### By role
Contestants:
    Login/Registration/Email verify/Reset password
    Select Audition from the available auditions
    Payment
    Add profile details
    Add Audition details
        select team type Solo, Duo, Group
        If group, max 8 members
        Show payment amount based on team size
    Upload Video
        Max 2 videos per audition/payment
        50 MB per videos
        Videos will stored in Amazon Bucket

Admin:
    Login/Reset password
    Can add/Update gurus
    Activate/Deactivate Guru login
    Assign guru to auditions
    - Export:
        Only Admin can now export list for contestant and videos
    - Admin will see Average rating by all gurus
    - Top 500 most rated contestants first
    - Send reminder rating emails to gurus

Guru:
    Login/Reset password
    Can not see contestant's personal details
    Can see the audition videos assigned to him
    Can rate each videos 
    Can add comment with email for any video

### By functionality
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
        Only Admin can now export list for contestant and videos
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
    #15-05-2024
- Redirect outside links to new tabs
- Add logos in email
- If Dance only show dance TnC If Singing only show Sing tnc
- Fix mobile blur issue (Already done)
- Got automation tool access for whatsapp api integration

    
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

