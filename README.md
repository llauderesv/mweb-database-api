# What is MWEB - PHP Database api?
MWEB PHP Database api is a tool that you can use when you are manipulatiing data in your database like performing queries, joins etc.
It is an open source project that you can use when you are developing WEB applications by simply downloading the file and 
follow the instructions below.
Want to contribute in this project?
Kindly email this llauderesv@gmail.com

## Why should I use this?
Imagine you are using the old fashion way when you are perfoming queries in your database you store them in the variable and execute it 
every time when you are making a query it is a tremendous lines of code by executing over and over again 
In MWEB Database API you can simple call the method and automatically execute it and also prevent the 
SQL injection when some hackers attack your database
By using this you can write a safer and cleaner code in your system and its open source.

### How to use? <br />
First and foremost you must include the mweb database api in your php file
assigned it to variable your database connection
#### Example: 
```
require_once('api/mweb.php');
$db = mweb::connect($param1, $param2, $param3, $param4);
```
The mweb constructor class has consist of 4 parameters<br />
The first parameter is the host name that is (localhost) for default<br />
The second parameter is the username of your phpmyadmin for default that is (root)<br />
The third parameter is the password of your phpmyadmin<br />
The fourth parameter is the database that you will use in the rest of your life<br />
### Example:
```
$db = mweb::connect('localhost', 'root', '', 'students_db'); // You are connected to the database
```

## Performing queries

### SQL select statement by using the method 
```
select_all($table_name, null, null)
```
This will accept 1 parameter which is the table that will be selected
#### Example:
```
$db->select_all('tbl_users'); // Get all the users

$users = $db->get();
````
This will return an associative array. You can access this object by using the lambda expression (->).
#### Example:
```
<table border="1">
   <thead>
      <tr>
         <th>First name</th>
         <th>Last name</th>
         <th>Middle name</th>
      </tr>
   </thead>
   <tbody>
      <?php

         foreach ($users as $row) {
            echo '<tr>';
            echo '<td>'.$row->fname.'</td>';
            echo '<td>'.$row->lname.'</td>';
            echo '<td>'.$row->mname.'</td>';
            echo '</tr>';
         }
      ?>
   </tbody>
</table>
```
##### Output:
| First name     | Last name    | Middle name |
| ---------------|--------------|-------------|
| Vincent        | Llauderes    | Calma       |
| Vainca         | Llauderes    | Calma       |
| Vench John     | Llauderes    | Calma       |

Note: When you are performing SQL select statement also remember that you call this method $db->get() or $db->get_single_row() (for selecting single row only)
for every query to get the return values in your queries
if not you query is not take effect

If you want to return a single row only kindly call the method
```
$users = $db->get_single_row(); // This will return a single row only
echo $users->fname; // Display the first name
```
Note: If you perform a get_single_row() method and theres no data in your table the return value of this method is 0 indicating theres no data will be return

### Selecting for specific fields or column in the table by using the method
```
select_fields($table_name, $arr_fields)
```
The first parameter is the table that will be selected in the database<br />
The second parameter accepts an associative array which consists of array of fields<br />
#### Example:
```
$arr_fields = array('fname', 'lname', 'mname'); // Create an array of fields that will be selected in the table

$db->select_fields('tbl_users', $array_fields); // Call the method

$users = $db->get(); // This will return an associative array
```

### SQL limit by using the method 
```
// This will accepts a integer value that the number of rows that you want to limit in your select statement
limit($num); 
```
#### Example:
```
$db->select_all('tbl_users');

$db->limit(10); // Limit the number of return rows to 10

$users = $db->get(); // This will return an associative array
```