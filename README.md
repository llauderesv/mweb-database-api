# What is MWEB - PHP Database api?
MWEB PHP Database api is a tool that you can use when you are manipulatiing data in your database like performing queries, joins etc.
It is an open source project that you can use when you are developing WEB applications by simply downloading the file and 
follow the instructions below.<br />
Want to contribute in this project?<br />
Kindly email this llauderesv@gmail.com<br />

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
limit($num); 
```
This will accepts a integer value that the number of rows that you want to limit in your select statement
#### Example:
```
$db->select_all('tbl_users');

$db->limit(10); // Limit the number of return rows to 10

$users = $db->get(); // This will return an associative array
```

### SQL order by statement by using the method
```
order_by($order_cloumn, $order_type)
```
#### Example:
```
$db->select_all('tbl_users');
$db->order_by('fname', 'ASC');
$db->limit(10);
$users = $db->get();  // This will output SELECT * FROM tbl_users ORDER BY fname ASC LIMIT 10
```
If you want to order multiple columns you can achieve this by simply passing an associative array in the 
first parameter and make null in the second parameter
The key is the fields or column that you want to be sorted and the value is the type of sort that you want
#### Example:
```
$db->order_by(array('id' => 'DESC', 'fname' => 'ASC'));
$db->limit(10);
$users = $db->get();
echo $db->check_query(); // This will output SELECT * FROM tbl_users ORDER BY id DESC, fname ASC LIMIT 10
```

Note: Be careful the sequence when calling the methods when you are performing queries because this will cause an error
The sequence is the same like when you are performing queries in the SQL.
#### Example:
```
$db->order_by(array('fname' => 'ASC'));
$db->select_all('tbl_users');
$users = $db->get(); // This will get an error
echo $db->check_query(); // The will output ORDER BY fname ASC SELECT * FROM tbl_users 
```

### SQL group by statement by using the method
```
group_by($val)
```
This method accepts a string or an array parameter
#### Example if you want to pass an array in the group by method
```
$group_by_arr = array('fname', 'lname')
$db->select_all('tbl_users');
$db->order_by('fname', 'ASC');
$db->group_by($group_by_arr); // Call the group by method
$users = $db->get(); // This will output SELECT * FROM tbl_users GROUP BY fname, lname
```
or if you pass a string in the group by method
```
$db->select_all('tbl_users'); 
$db->order_by('fname', 'ASC');
$db->group_by('fname'); // Call the group by method
$users = $db->get(); // This will output SELECT * FROM tbl_users GROUP BY fname
```

### SQL having statement by using the method 
```
having($column_name, $operator, $value);
```
This method accepts three parameters. The first parameter is the column name that you want to specify and
second parameter is the operator that you will use. The third parameter is the value
#### Example:
```
$db->select_all('tbl_users');
$db->having('lname', '=', 'Cruz');
$db->order_by();
$users = $db->get();
```

### SQL where clause statement by using the method 
```
where(array(), $condition)
```
The first parameter is an associative array in the where clause which consist of key value pair
The key in the associative array is the name of your fields or column followed by the operator that you'll use 
where the value in the associative array is the data that will be selected
The second parameter is the condition that you will use the where clause if you leave it null the default value of this is 'AND' condition

#### Example:
```
$arr = array('fname=' => 'John', 'lname=' => 'Cruz');
$db->select_all('tbl_users'); 
$db->where($arr, 'AND'); 
$user = $db->get_single_row();
echo $db->check_query(); // This will output SELECT * FROM tbl_users WHERE fname = 'John' AND lname = 'Cruz'
```
Note: This is also execute safer queries!

You can also pass a string in the where clause method by using your own condition
```
$my_condition = "fname = 'test' AND lname = 'test2' ";
$db->select_all('tbl_users'); 
$db->where($condition);
$user = $db->get_single_row();
```