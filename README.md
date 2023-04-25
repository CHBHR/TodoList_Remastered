# TodoList_Remastered

Projet 8 pour le parcours "Développeur PHP / Symfony" - openclassroom

A to do list web application to manage your tasks.

Registered users can create, edit and delete tasks on a board to get organized. 
Tasks can have a deadline and can be toggled as "done".

Admin users can create, edit or delete users and Orphan tasks.

The tasks of a deleted user will become "Orphan tasks", that then can only be accessed by admins.

## Installation

PHP : 8.1.0

Symfony: 6.2.7

You can clone or download the github project

```bash
git clone https://github.com/CHBHR/TodoList_Remastered.git
```
Don't forget to change local variables in the .env file

Instal dependencies with composer

```bash
composer install
```
Create database

```bash
php bin/console doctrine:database:create
```

Update and add the tables

```bash
php bin/console doctrine:migrations:migrate
```
You can add fixtures to the normal database to check functionnalities

```bash
php bin/console doctrine:fixtures:load
```

Start Symfony server

```bash
symfony server:start
```
## Testing

To check out testing and coverage, modify your .env.test file

Then load the testing fixtures

```bash
php bin/console doctrine:fixtures:load --env=test
```

You can start phpunit testing with this command
```bash
php bin/phpunit
```

You can generate the coverage repport with this command
```bash
php vendor/bin/phpunit --coverage-html coverage
```

## Resources

Code quality has been analyzed with Codacy.
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/818ec0ea00c64315adf9d17d55a2f404)](https://app.codacy.com/gh/CHBHR/TodoList_Remastered/dashboard?utm_source=gh&utm_medium=referral&utm_content=&utm_campaign=Badge_grade)

Code coverage was analyzed using PHPUnit and the HTML report.

The different issues can be found on the old Github repository (https://github.com/CHBHR/TodoList/issues?q=is%3Aissue).
They are the same used for the updated project.

All the documentation can be consulted here: (TOBEFILLED)

## Versioning

GitHub was used for versioning the project.

## Old branch

This project was a reboot within an up to date version of PHP / Symfony of the old todolist project.

The old project repository can be consulted here:
https://github.com/CHBHR/TodoList

Because of the amount of issues and bugs while migrating this project, the old and confusing code architecture and the time spent on updating, I decided to transfer all the functionnalities to anew project.
Thus saving on developpement time, maintainability and better execution management.

All the information on the developpement can be found here:
