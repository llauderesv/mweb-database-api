# What is MWEB-Database-API?
MWEB Database API is a PHP framework that may use when manipulating or querying in the databases for now it will supports only MySQL

### How to connect?<br />
You can simply achieve this by including the connection in your php file and assigned it to the variable in your database connection.
```
$db = mweb::connect($param1, $param2, $param3 $param4);
```
The database constructor class has consist of 4 parameter!<br />
The first parameter is the host name that is (localhost)!<br />
The second parameter is the username of your phpmyadmin for default that is (root)!<br />
The third parameter is the password of your phpmyadmin!<br />
The fourth parameter is the database that you will use!<br />
#### Consider this example
```
$db = mweb::connect('localhost', 'root', '', 'students_db');
```
### SQL select statement by using the method<br />
```
select_all($var1, null, null)
```
This will accepts 3 parameters the first one is the table name that will be selected the second is
The limit which is optional and the third is the offset which is optional again
#### Consider this example
```
$users = $db->select_all('tbl_users');
```
Note: This will return an associative array you can access this object by using the lambda expression (->).
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

##### Selecting for specific fields or column in the table 
```
select_fields($var1, $var2, null, null)
```
The first parameter accepts an associative array which consists of array of fields!
The second parameter is the fields that will be selected in the table which an array variable that consist of name of the field
The third and fourth parameter is optional
Consider this example:
```
$array_fields = array('fname', 'lname', 'mname');
$users = $db->select_fields('tbl_users', $array_fields);
```

###  SQL where like statement by using the method 
```
where_like($column_name, $value, $limit, $offset);
```
The first parameter is the column name the second parameter is the value that will get the occurence
The third and fourth parameter is optional which is the limit and offset
#### Consider this example
```
$db->where_like('fname', 'vincent');
$db->select_all('tbl_users'); // This will output SELECT * FROM tbl_users WHERE fname LIKE "%vincent%";
```
Note: You can use your own wildcard when performing where_like
```
$db->where_like('fname', '%vincent%');
$db->select_all('tbl_users'); // This will return all the users who's first name is vincent
```


