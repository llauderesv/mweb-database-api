# What is MWEB - Database api?
MWEB Database api is a tool that you can use when you are manipulatiing data in your database like performing queries, joins etc.
It is an open source project that you can use when you are developing WEB applications by simply downloading the file and 
follow the instructions below.<br />
Want to contribute in this project?<br />
Kindly email this llauderesv@gmail.com<br />

## Why should I use this?
Imagine you are using the old fashion way when you are perfoming queries to your database you store them in the variable and execute them
every time when you are making a query it is a tremendous waste lines of code by executing over and over again by the same approach
In MWEB Database api you can simple call the built in methods and automatically execute it and also prevent the 
SQL injection when someone hackers attacks your database
By using this you can write a safer and cleaner code in your system and imagine its open source.

### How to use? <br />
First and foremost you must include the mweb database api in your php file
assigned it to variable your database connection. That's it!

#### Example: 
```
require_once('api/mweb.php'); // Include the mweb database api to your project

$db = mweb::connect($param1, $param2, $param3, $param4);
```
The mweb constructor is consist of 4 parameters<br />
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
select_all($table_name)
```
This will accept 1 parameter which is the table that will be selected

#### Example:

```
$db->select_all('tbl_users'); // Get all the users

$users = $db->get(); // Return an associative array of objects
````

This will return an associative array. You can access return value by using the lambda expression (->).

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
| Vianca         | Llauderes    | Calma       |
| Vench John     | Llauderes    | Calma       |

Note: When you are performing SQL select statement don't forget to call this method <b>$db->get()</b> or <b>$db->get_single_row()</b> (for selecting single row only)
for every query to get the return values in your queries
if not you query is not take effect

If you want to return a single row only kindly call the method
```
$users = $db->get_single_row(); // This will return an associative array of objects

echo $users->fname; // Display the first name 
```
Note: If you perform a get_single_row() and get() method and theres no data in your table the return value of this method is 0 that is interger indicating theres no data will be return

### Selecting for specific fields or column in the table by using the method
```
select_fields($table_name, array())
```
The first parameter is the table that will be selected in the database<br />
The second parameter accepts an array which consists of array of fields<br />

#### Example:

```
$arr_fields = array('fname', 'lname', 'mname'); // Create an array of fields that will be selected in the table

$db->select_fields('tbl_users', $array_fields); // Call the method

$users = $db->get(); // This will return an associative array of objects
```

### SQL limit function by using the method

```
limit($num); 
```

This will accepts an integer value that the number of rows that you want to limit in your select statement

#### Example:

```
$db->select_all('tbl_users');

$db->limit(10); // Limit the number of returned rows to 10

$users = $db->get(); // This will return an associative array of objects
```

### SQL order by statement by using the method

```
order_by($order_cloumn, $order_type)
```

#### Example:

```
$db->select_all('tbl_users');

$db->order_by('fname', 'ASC'); // Order the returned rows to ascending

$db->limit(10);

$users = $db->get();  // This will output SELECT * FROM tbl_users ORDER BY fname ASC LIMIT 10

```
If you want to order multiple columns. You can achieve this by simply passing an associative array in the 
first parameter and make it empty the second parameter
The key is the fields or column that you want to be sorted and the value is the type of sort that you want

#### Example:

```
$db->select_all('tbl_users');

// Sort the first name column to descending order and last name to ascending order

$db->order_by(array('id' => 'DESC', 'fname' => 'ASC')); 

$db->limit(10);

$users = $db->get();

echo $db->check_query(); // This will output SELECT * FROM tbl_users ORDER BY id DESC, fname ASC LIMIT 10
```

Note: Be careful the sequence of calling the methods when performing queries because this will cause an error

The sequence is the same when performing queries in the SQL.

#### Example:

```
$db->order_by(array('fname' => 'ASC')); // Invalid place of order by method

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
$group_by_arr = array('fname', 'lname'); // Create an array of fields for group by

$db->select_all('tbl_users');

$db->order_by('fname', 'ASC');

$db->group_by($group_by_arr); // Call the group by method

$users = $db->get(); // This will output SELECT * FROM tbl_users GROUP BY fname, lname
```

or if you pass a string in the group by method

```
$db->select_all('tbl_users'); 

$db->order_by('fname', 'ASC');

$db->group_by('fname'); // Call the group by first name

$users = $db->get(); // This will output SELECT * FROM tbl_users GROUP BY fname
```

### SQL having statement by using the method 

```
having($column_name, $operator, $value);
```
This method accepts three parameters.<br /> 
The first parameter is the column name.<br />
The second parameter is the operator that you will use. The third parameter is the value<br />

#### Example:

```
$db->select_all('tbl_users');

$db->having('lname', '=', 'Cruz'); // Select all the users having last name cruz

$db->order_by('lname', 'ASC');

$users = $db->get(); // This will output SELECT * FROM tbl_users HAVING lname = 'Cruz'
```

### SQL where clause statement by using the method 

```
where(array(), $condition)
```

The first parameter is an associative array in the where clause which consist of key value pair<br />
The key in the associative array is the name of your fields or column followed by the operator that you'll use <br />
where the value in the associative array is the data that will be selected<br />
The second parameter is the condition that you will use the where clause if you leave it null the default value of this is 'AND' condition<br />

#### Example:

```
$arr = array('fname=' => 'John', 'lname=' => 'Cruz');

$db->select_all('tbl_users'); 

$db->where($arr, 'AND'); 

$user = $db->get_single_row();

echo $db->check_query(); // This will output SELECT * FROM tbl_users WHERE fname = 'John' AND lname = 'Cruz'
```

Note: You're not to worried about in SQL injection because this is also execute safer queries!

### SQL where like statement by using the method 

```
where_like($column_name, $value);
```
The first parameter is the column name the second parameter is the value that will get the occurence

#### Example:

```
$db->select_all('tbl_users');

$db->where_like('fname', 'John');

$users = $db->get(); // This will output SELECT * FROM tbl_users WHERE fname LIKE "John";
```
Note: You can use your own wildcard when performing where_like

#### Example:

```
$db->select_all('tbl_users');

$db->where_like('fname', '%John%');

$users = $db->get(); // This will output SELECT * FROM tbl_users WHERE fname LIKE "%John%";
```

You can use also the where not like function which means compliment of like

#### Example:

```
$db->select_all('tbl_users');

$db->where_not_like('fname', '%John%');

$users = $db->get(); // This will output SELECT * FROM tbl_users WHERE fname NOT LIKE "%John%";
```
### SQL where in statement by using the method 

```
where_in($column_name, array());
```
This will accepts 2 parameters the first parameter is the column name and the second is an array of values.

#### Example:

```
$db->select_all('tbl_users');

$db->where_in('fname', array('John', 'Alex', 'Jayson'));

$users = $db->get(); // This will output SELECT * FROM tbl_users WHERE fname IN ('John', 'Alex', 'Jayson');
```

You can also use the where not in method by using the 

```
where_not_in($column_name, array());
```
The parameters is the same in where_in method

### SQL join statement by using the method 

```
join($table_name, $column_join, $join_type);
```

This will accepts 3 parameters. <br />
The first one is the table name that you want to join. The second is the column name that you want to join<br />
and the third is the join type that is(LEFT, RIGHT, INNER, LEFT OUTER, RIGHT OUTER)<br />

#### Example:

```
$db->select_fields('tbl_users AS a', array('a.fname', 'b.comment'));

$db->join('tbl_comment AS b', 'a.id = b.user_id', 'INNER');

$users = $db->get();

echo $db->check_query(); 

// This will output SELECT a.fname, b.comment FROM tbl_users AS a INNER JOIN tbl_comment AS b ON a.id = b.id

```

If you want to perform multiple joins kindly call again the method join for example

```
$db->select_fields('tbl_users AS a', array('a.fname', 'b.comment'));

$db->join('tbl_comment AS b', 'a.id = b.user_id', 'INNER');

$db->join('tbl_post AS c', 'a.id = c.user_id', 'INNER');

$users = $db->get();

echo $db->check_query();
// This will output SELECT a.fname, b.comment FROM tbl_users AS a INNER JOIN tbl_comment AS b ON a.id = b.id INNER JOIN tbl_post AS c ON a.id = c.id
```

Note: in my previous example I use an alias in tables when performing joins to make it easier

### MWEB Database API also supports method chaining

#### Example:

```
$users = $db->select_all('tbl_users')
            ->having('lname', '=', 'Llauderes')
            ->order_by('lname', 'ASC')
            ->get();

print_r($users); // This will return an associative array

echo $db->check_query(); // This will output SELECT * FROM tbl_users HAVING lname = 'Llauderes' ORDER BY lname ASC

```
Note: When you are performing method chaining don't forget to call the get() method in the last of your chaining

### SQL insert statement by using this method 

```
insert($table_name, array());
```

This methods accepts two parameters. The first parameter is the name of your table
The second is the data will be insert, which is an associative array consist of key value pair.
The key is the column name in your table and the value is the data will be inserted in the your column

#### Example:

```
$data = array('fname' => 'John', 'lname' => 'Cruz', 'mname' => 'De Ocampo');

$db->insert('tbl_users', $data);

echo $db->execute(); // The return value of this method is number of affected rows in your table

echo $db->check_query();  // This will output INSERT INTO tbl_users (fname, lname, mname) VALUES ('John', 'Cruz', 'De Ocampo');
```

If you want to insert batch data's you can achieve this by using multiple associative array inside an array

#### Example:

```
$data =
  array(
    array('fname' => 'John', 'lname' => 'Cruz', 'mname' => 'De Ocampo'),
    array('fname' => 'Alex', 'lname' => 'Cruz', 'mname' => 'De Ocampo'),
    array('fname' => 'Johny', 'lname' => 'Cruz', 'mname' => 'De Ocampo')
  );

$db->insert('tbl_users', $data);

echo $db->execute();
```
Note: If you're performing the INSERT, UPDATE, DELETE don't forget to call the method execute() to make your query take effect
The return value of this is the affected rows in your tables

### SQL update statement by using the method 

```
update($table_name, array());
```

This methods accepts two parameters. The first parameter is the name of your table
The second is the data will be update which is an associative array consist of key value pair.
The key is the fields or column name in your table and the value is the data will be updated in your table

#### Example:

```
$data = array('fname' => 'John', 'lname' => 'Llyod', 'mname' => 'Cruz');

$db->update('tbl_users', $data); 

echo $db->execute(); // This is will return the number of rows affected in your table

echo $db->check_query() // This will output UPDATE tbl_users SET fname = 'Vincent', lname = 'Llauderes'

```
Note: You can also use the where function when updating data's

#### Example:

```
$data = array('fname' => 'Vincent', 'lname' => 'Llauderes');

$db->update('tbl_users', $data); 

$db->where(array('id=' => '1'));

echo $db->execute(); // The return value of this method is number of rows that will updated!

echo $db->check_query(); // This will output UPDATE tbl_users SET fname = 'Vincent', lname = 'Llauderes' WHERE id = 1;
```

### SQL delete statement by using the method 

```
delete($table_name);
```

This methods accepts one parameter. The first parameter is the name of your table which will be data deleted!
Note: You can also use the where function when deleting data's

#### Example:

```
$db->delete('tbl_users');

$db->where_in('fname', array('vincent', 'llauderes'));

echo $db->execute(); // The return value of this method is number of rows that will deleted!

echo $db->check_query();  // This will output DELETE tbl_users WHERE fname IN ('vincent', 'llauderes');
```

### SQL truncate statement by using the method 

```
truncate($table_name);
```

This methods accepts one parameter. The first parameter is the name of your table which will be truncated!


You can use also the query() method for creating you own query

#### Example:

```
$users = $db->query("SELECT * FROM tbl_users WHERE id > 5");

print_r($users);
```

#### Example:

```
$db->truncate('tbl_users'); // This will output TRUNCATE tbl_users;
```
The return value of this method is 1 or 0 to determine if the query is work!

### SQL get insert id by using method

```
get_insert_id();
```

Basically this method will use after perform insert statement!<br />
This method has a return value that will get the inserted id in the table!<br />

#### Example:

Let's say you perform a SQL insert statement
if will get the inserted id

```
echo $db->get_insert_id() // This will get the inserted id
```

### SQL get num rows statement by using method 
```
get_num_rows();
```

Basically this method will use after perform select statement!
This method has a return value that will get the num of rows that will be selected in the table!

#### Example:

Let's say you perform a SQL select statement 
if you perform the get_num_rows method
if will get the number of returned rows

```
echo $db->get_num_rows();
```

### SQL aggregate function

```
select_count($table_name) method
```
Counting the number of rows in your tables
This method accepts one parameter which the table that you will count

#### Example:

```
$total = $db->select_count('tbl_users')->get();
// The return value of this method is associative array which you can access 
by using your variable that you will store the select count and lamda expression followed by the total_item

echo $total->total_item; // Display the total number of users
```

Note: When performing aggregate function always call also the get() in the last of your query.
It also supports method chaning.


```
get_average($table_name, $column_name)->get();
```

Get the average of the specified column

#### Example:

```
$avg = $db->get_average('tbl_users', 'id')->get(); // The return value of this method is associative array which you can access 
by using your variable that you will store followed by the 
name of your column that is (id) in our example//
echo $avg->id;
```
```
get_max($table_name, $column_name);
```
Get the maximum value in the specified column

#### Example:

```
$max_id = $db->get_max('tbl_users', 'id')->get();
echo $max_id->id; // Get the maximum value in column id
```
```
get_min($table_name, $column_name);
```
Get the minimum value in the specified column

#### Example:
```
$min_id = $db->get_min('tbl_users', 'id')->get();
echo $min_id->id; // Get the minimum value in column id
```
```
get_variance($table_name, $column_name);
```
Get the variance in the specified table

#### Example:
```
$variance = $db->get_variance('tbl_users', 'id')->get();
echo $variance->id; // Get the variance in column id
```

```
get_sttdev($table_name, $column_name);
```
Get the standard deviation in the specified table

#### Example:
```
$sttdev = $db->get_sttdev('tbl_users', 'id')->get();
echo $sttdev->id; // Get the standard deviation in column id
```

### SQL Transactions
MWEB Database api is also supports transactions

#### Example:
Beginning the transactions
```
$db->beginTransaction(); // Start the transaction
```

If you want to commit transaction kindly call the method
```
$db->commit(); // Committing all the changes
```
