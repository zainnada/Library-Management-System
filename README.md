# Library managment system - PHP CRUD

This is a simple web application built with PHP and MySQL to manage user records.
It allows you to **Create**, **Read**, **Update**, and **Delete** Books and Friends data through a simple user interface.

## Features:
- Login and logout for Admins.
- Display all Books, Friends, and Borrows in a table.
- Add new Books, Friends, and Borrows record.
- Update existing Books and Friends.
- Return the borrowed books.
- Delete Books and Friends. (Make sure they don't have a records in Borrows table)

## How to Run the Project:
1. Copy the project files into your local server directory (e.g., `htdocs` for XAMPP).
2. Create a new MySQL database, `zain_library_db`.
3. Import the SQL file (`LMS_DB.sql`) into the database using phpMyAdmin or the MySQL command line.
4. Update the database connection in `db_connect.php` if needed:
   ```php
   $conn = mysqli_connect("localhost", "root", "", "zain_library_db");
   // or
   $conn = new mysqli("172.0.0.1", "root", "", "zain_library_db");
   
## Open the project in your browser:
- http://localhost/library-managment-system/
- http://localhost/your-folder-name/

## Notes:
- Make sure Apache and MySQL are running before accessing the project.  
