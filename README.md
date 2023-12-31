## Miniature Disco

## Setup Instructions

**Requirements:**

> - PHP >= 8.1
> - Composer >= 2.4.3
> - MySQL >= 8.0

**Step 1:** Clone the repository in your terminal using `https://github.com/victorive/miniature-disco.git`

**Step 2:** Navigate to the project’s directory using `cd miniature-disco`

**Step 3:** Run `composer install` to install the project’s dependencies.

**Step 4:** Run `cp .env.example .env` to create the .env file for the project’s configuration
and `cp .env.example .env.testing` to create the .env file for the testing environment.

**Step 5:** Run `php artisan key:generate` to set the application key.

**Step 6:** Create a database with the name **miniature_disco** or any name of your choice in your current database
server and configure the DB_DATABASE, DB_USERNAME and DB_PASSWORD credentials respectively, in the .env files located in
the project’s root folder. eg.

> DB_DATABASE={{your database name}}
>
> DB_USERNAME= {{your database username}}
>
> DB_PASSWORD= {{your database password}}

**Step 7:** Configure the FREE_API_URL variable in the .env file to https://jsonplaceholder.typicode.com.

**Step 8:** Run `php artisan migrate --seed` to create your database tables. This command also seeds your database with an Admin and a Regular 
user. The login details are as follows:

**Admin User:**

- Email: admin@admin.com
- Password: Password1234#

**Regular User:**

- Username: johndoe@example.com
- Password: Password1234#

**Step 9:** Run `php artisan passport:install` create the personal access and password grant clients which will be used to generate access tokens.

**Step 10:** Setup `php artisan schedule:work` to run the commands to fetch the posts for each user from the provided URL.

**Step 11:** Run `php artisan serve` to serve your application, then use the link generated to access the API via any
API testing software of your choice.

**Step 12:** To run the test suites, make sure you have configured the testing environment using the `.env.testing` file
generated earlier, then run `php artisan test` to test.

Feel free to fork the repo, make any changes or report any issues, and submit a PR. Happy coding!
