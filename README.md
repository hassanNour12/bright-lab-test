# bright-lab-test
 offline software to manage data and online software to backup

# OFFLINE SOFTWARE

Is a software that mr x can manage:
- customers (view, add, edit, delete, and restore)
- toppings (view, add, edit, delete, and restore)
- orders (view, add, edit, delete, and restore)

# Installation
The Project use PHP version 8  and laravel framework 8
First run:
```sh
composer install
```
Second run:
```sh
php artisan migrate:fresh
```
Then run:
```sh
php artisan seed:db
```
This command will generate customers, 5 toppings (chocolate banana, strawberry banana, vanilla banana, cheese banana, banana) , and orders, and Mr x account (email:mrx.test.brightlab@gmail.com, password: password).
Know run:
```sh
php artisan serve
```
## OR
on your browser add to the url "/add_new/register" to register a new account. At this Step this account will be created in the online database.

# ONLINE SOFTWARE

Is a software where mr x backup his data from offline database.

# Installation
The Project use PHP version 7  and laravel framework 8
First run:
```sh
composer install
```
Second run:
```sh
php artisan migrate:fresh
```
Then run:-to create Mr x account- 
```sh
php artisan seed:db
```
# How It Works

In the offline software the user can modify his data. When modifying or creating new records the synced_at attribute in the database still null. As user enters Sync Data page in the dashboard and clicks sync data button first it will prompt him to enter his email and password to login to the online database. if he enters correct email and password the api will return a token to use it in the upcomming requests.
function will start collecting data from offline database under two groups:
- new records: records where synced at attribute is null
- updated records: records where updated at timestamp greater than synced at timestamp

After success syncing all synced rows sync at timestamp will be updated and a record will be added to offline database stating number of rows synced and time.

## IMPORTANT NOTES:
- The Two softwares must be running at the same time.
- Please make sure that each project on separate computer/laptop but on same network (working locally)
- Get the ip of the copmputer/laptop where ONLINE SOFTWARE
- In File explorer navigate to 
   - your-project/app/Http/Controllers/Auth/RegisterController.php line:92 and change (192.168.1.5) to ip you get
   - your-project/app/Http/Controllers/SyncDataController.php line:89 and line:162 and change (192.168.1.5) to ip you get
- I tried to implement sending email to mr x after syncing finishes but still getting an auth-error saying that it can not be authorized
