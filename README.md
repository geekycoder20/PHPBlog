# About
This is a user friendly blogging system developed in PHP OOP,MYSQL(with PDO + Prepared Statements),JQERY(AJAX) and Bootstrap 
## Users
There are three types of users for managing backend with different privileges
1. Author (only creates and views his own posts)
2. Moderator (create posts,view all posts,Approve,Edit,Delete Posts and Comments)
3. Admin (all access on categories,posts,comments,pages,sliders,users,messages and settings)

Usernames and Passwords
1. Admin User
Username: Admin
2. Moderator
Username: akram123
3. Author
Username: habib123

Password is "arazzaq123" for all users


# Features

- Dynamic CRUD  Queries with pdo + prepared statements
- Neat and clean Database design with One to One, One to Many and Many to Many relationships
- View Posts by category without page reload (ajax)
- Load More Posts pagination functionality without page reload (ajax)
- Search Posts without page reload (ajax)
- Quick View Post without page reload (ajax)
- Comments and reply system
- SEO Friendly URL for posts and pages
- Secure From Common Web exploits like SQL Injection,XSS and File Upload vulnerabilities
- Different roles and permissions for users 

# Configurations

- Create "blog" folder in htdocs or www folder
- Copy all the files into "blog" folder
- Configure database in classes/database.php
- Replace `$project_dir = "/blog/"` with your project directory in config/init.php (if you have created folder with another name in htdocs)
- Replace `<base href="http://localhost/blog/">` with home page url of your site in includes/header.php on line 8
- Replace `$project_path = "/blog/"` with your htdocs folder in backend/ajax/myajax.php

# Workflow
This is the workflow used in this blog project <br>
First of all ajax with jquery is used in "js/myscripts.js" file and it sends requests to ajax/myajax.php file <br>
In myajax.php file different methods of different classes are called to do specific tasks

# How to Use Dynamics SQL Queries
## Insert
Insert query should be call like this
``` PHP
insert_query($table_name,$cols,$vals); //cols and vals should be arrays
```
Example
``` PHP
$cols = array("title","slug","content");
$vals = array("Some title","Some slug","Some content of page");
$result = $database->insert_query("pages",$cols,$vals); // $database is the object of database class
```

## Update
Update query should be call like this
``` PHP
update_query($table_name,$cols,$vals,$myval,$col); // $col is an optional parameter
```
**Example without $col //if you want to update records based on id column**
``` PHP
$cols = array("title","slug","content");
$vals = array("Updated title","Updated slug","Updated content of page");
$myval = 1; // id of page
$result = $database->update_query("pages",$cols,$vals,$myval);
// It will be "UPDATE pages SET $cols,$vals WHERE id=1"
// Note: Use it when your primary key column name is "id" and you want to update records based on id field
```
**Example with $col //if you want to update records based on another column**
``` PHP
$cols = array("title","slug","content");
$vals = array("Updated title","Updated slug","Updated content of page");
$col = "title"; // column name of your choice
$myval = "Some title"; // value you want to find out of column name
$result = $database->update_query("pages",$cols,$vals,$myval,$col);
//it will be "UPDATE pages SET $col,$vals WHERE title='Some title' "
// Note: Use it when you want to update records based on your desired column name
```
## Delete
Delete query should be call like this
``` PHP
delete_query($table_name,$myval,$col); //$col is an optional parameter
```
**Example without $col**
``` PHP
$myval = 1; //id of record
$result = $database->delete_query("pages",$myval);
//it will be "DELETE FROM pages WHERE id=1"
```
**Example with $col**
``` PHP
$col = "title"; // column name of your choice
$myval = "Some title"; //value of your column
$result = $database->delete_query("pages",$myval,$col);
//it will be "DELETE FROM pages WHERE title='Some title' "
```
## Find
Find query should be call like this
``` PHP
find_query($table_name,$myval,$col) //$col is an optional parameter
```
**Example without $col**
``` PHP
$myval = 1; //id of record
$result = $database->find_query("pages",$myval);
//it will be "SELECT * FROM pages WHERE id=1"
```
**Example with $col**
``` PHP
$col = "title"; // column name of your choice
$myval = "Some title"; //value of your column
$result = $database->find_query("pages",$myval,$col);
//it will be "SELECT * FROM pages WHERE title='Some Title' ";
```
Note: Use loops to fetch data from find or select query
``` PHP
$col = "title"; // column name of your choice
$myval = "Some title"; //value of your column
$result = $database->find_query("pages",$myval,$col);
while($row = $result->fetch()){
  echo $row['id'];
}
```
**Some more queries for finding and selecting records are defined in database class which you can explore**