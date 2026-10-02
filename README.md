# ipt10-lab-db


## Requirements

* XAMPP
* PHP
* MySQL
* Web browser

## Installation

1. Download and install **XAMPP**.
2. Open the **XAMPP Control Panel**.
3. Start **Apache** and **MySQL**.
4. Make sure the required PHP extensions are enabled in `php.ini`, especially:

   * `mysqli`
   * `pdo_mysql`
5. Restart Apache after changing `php.ini`.

## Create the Database

1. Open **phpMyAdmin** through XAMPP.
2. Create a database named:

```text
ip10_lab
```

3. Import or execute the provided SQL script to create the `students` table and sample records.
4. Make sure the database uses `utf8mb4` character encoding.

## Run the Application

1. Copy the project folder into:

```text
C:\xampp\htdocs\
```

2. Start Apache and MySQL from XAMPP.
3. Open the application in a browser:

```text
http://localhost/ipt10_lab/ipt10_lab/
```

4. The application can then be used to create, view, edit, and delete student records.

## Database Configuration

The application connects to MySQL using:

```text
Host: 127.0.0.1
Database: ip10_lab
Username: root
Password: empty
```

Make sure MySQL is running before using the application.
