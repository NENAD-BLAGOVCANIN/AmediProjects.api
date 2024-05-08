# Requirements

1. Composer
2. Dbeaver or some other database management tool
3. node.js

# Installation

To install this project do the following steps:

1. Open the project folder and run composer install --ignore-platform-reqs
2. Then run "php artisan migrate". If this command doesn't automatically create the database with name given in .env then manually create the database. 
3. php artisan serve.
4. Connect to the database with dbeaver or some other database tool, in the roles table add a new row with name="user".
