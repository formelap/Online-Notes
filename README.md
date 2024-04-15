# Note Creation and Editing Application

## Description
This web-based note management application allows users to create, edit, and delete notes. It also enables account management, including changing login details and email addresses.

## Features
- Create, edit, and delete notes.
- Account registration with verification via an activation link sent to the email address.
- Password reminder with the ability to reset via a link sent to email.
- Manage account data: change login, email address, and password.
- Session remembering with cookies.
- Contact form for administrator communication.

## Technologies
- AJAX
- jQuery
- Bootstrap
- PHP
- MySQL

## Installation
1. Download and install a local XAMPP server.
2. Download the repository files.
3. Start Apache and MySQL from the XAMPP control panel.
4. Extract the downloaded repository files into the `htdocs` folder in the XAMPP directory.
5. Open PHPMyAdmin (`http://localhost/phpmyadmin`).
6. Create a database and import tables using the `database.sql` script found in the `database` directory.
7. Launch the application by accessing `localhost` in your browser.

## Configuration
To use all the functionalities of the application, it is essential to configure Sendmail on the XAMPP server.
Configure the `.env` file in the main directory of the application, filling in the email handling details.

## Test Data
- Login: Test
- Email: test@test.test
- Password: Qwe123
