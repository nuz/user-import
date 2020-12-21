Import users from CSV files.

## Installation

1. Clone project
2. Run `composer install` command
3. Add database details in the `.env` file
4. Run `php artisan:migrate` command

## Usage

* To create a user: `php artisan user:create`
* To delete a user: `php artisan user:delete {id}` 
* To find a user: `php artisan user:find` and use one of allowed options:
    * `{--firstname=}` - Find user by the first name 
    * `{--lastname=}` - Find user by the last name 
    * `{--email=}` - Find user by the email
    * `{--phonenumber1=}` - Find user by the first phone number
    * `{--phonenumber2=}` - Find user by the second phone number
    * `{--comment=}` - Find user by the part of the comment
* To import users from the file: `php artisan user:import {filename}` and provide a csv filename.
If file was not provided, you will be asked to input it.
   
## Notes
* To import a file it should be in `/storage` directory
* There are 3 demo files to run the tests
* First name, Last name, Email, Phone number #1 are required. Phone number2, commment are optional.
* If file contains duplicated records, they are skipped and at the end of import, there will be a message how many of them were not imported.

