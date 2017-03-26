<style media="screen">
   * {
      font-family: consolas;
   }

</style>
<?php
require_once('api/mweb_pdo.php');

$db = mweb_pdo::connect('localhost', 'root', 'llauderesv321', 'mweb0');

/*
What is MWEB - Mobile Web PHP Database api?
MWEB PHP Database api is a tool that you can use when you are manipulatiing data in your database like performing queries, joins etc.
It is an open source project that you can use when you are developing WEB applications by simply downloading the file and 
follow the instructions below.
Want to contribute in this project?
Kindly email this llauderesv@gmail.com
*/

/*
* Why should I use this?
* Image you are using the old fashion way when you are perfoming queries in your database you store them in the variable and execute it 
* every time when you are making a query it is a tremendous lines of code by executing over and over again 
* In MWEB Database API you can simple call the method and automatically execute it and also prevent the 
* SQL injection when some hackers attack your database
* By using this you can write a safer and cleaner code in your system and its open source
*/
##########################################################################################################################################################
/*
* How to use?
* First and foremost you must include the mweb database api in your php file
* assigned it to variable your database connection
* Example: 
* require_once('api/mweb.php');
* $db = mweb::connect($param1, $param2, $param3, $param4);
* The mweb constructor class has consist of 4 parameters
* The first parameter is the host name that is (localhost) for default
* The second parameter is the username of your phpmyadmin for default that is (root)
* The third parameter is the password of your phpmyadmin
* The fourth parameter is the database that you will use in the rest of your life
* Example:
* $db = mweb::connect('localhost', 'root', '', 'students_db'); // You are connected to the database
*/
##########################################################################################################################################################
/*
* Performing queries
* SQL select statement by using the method select_all($table_name, null, null)
* This will accept 1 parameter the which is the table that will be selected
* Consider this example:
* $db->select_all('tbl_users'); 
* $users = $db->get();
* This will return an associative array. You can access this object by using the lambda expression (->).
* Example:
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
Note: When you are performing SQL select statement also remember that you call this method $db->get() or $db->get_single_row() (for selecting single row only)
for every query to get the return values in your queries
if not you query is not take effect

* If you want to return a single row only kindly call the method
* $users = $db->get_single_row(); // This will return a single row only
* echo $users->fname; // Display the first name
* Note: If you perform a get_single_row() method and theres no data in your table the return value of this method is 0 indicating theres no data will be return
*/
##########################################################################################################################################################
/*
* Selecting for specific fields or column in the table by using select_fields($table_name, $arr_fields) method
* The first parameter is the table that will be selected in the database 
* The second parameter accepts an associative array which consists of array of fields
* Example:
* $arr_fields = array('fname', 'lname', 'mname');
* $db->select_fields('tbl_users', $array_fields); 
* $users = $db->get(); // This will return an associative array
*/
##########################################################################################################################################################
/*
* SQL limit by using the method limit($num);
* This will accepts a integer value that the number of rows that you want to limit in your select statement
* Example:
* $db->select_all('tbl_users');
* $db->limit(10); // Limit the number of return rows to 10
* $users = $db->get(); // This will return an associative array
*/
##########################################################################################################################################################
/*
* SQL order by statement by using the method order_by($order_cloumn, $order_type)
* Example:
* $db->select_all('tbl_users');
* $db->order_by('fname', 'ASC');
* $db->limit(10);
* $users = $db->get();  // This will output SELECT * FROM tbl_users ORDER BY fname ASC LIMIT 10

* If you want to order multiple columns you can achieve this by simply passing an associative array in the 
* first parameter and make null in the second parameter
* The key is the fields or column that you want to be sorted and the value is the type of sort that you want
* Example:
* $db->order_by(array('id' => 'DESC', 'fname' => 'ASC'));
* $db->limit(10);
* $users = $db->get();
* echo $db->check_query(); // This will output SELECT * FROM tbl_users ORDER BY id DESC, fname ASC LIMIT 10

* Note: Be careful the sequence when calling the methods when you are performing query because this will cause an error
* The sequence is the same like when you are performing queries
* Example:
* $db->order_by(array('fname' => 'ASC'));
* $db->select_all('tbl_users');
* $users = $db->get(); // This will get an error
* echo $db->check_query(); // The will output ORDER BY fname ASC SELECT * FROM tbl_users 
*/
##########################################################################################################################################################
/*
* SQL group by statement by using the method group_by($val)
* This method accepts a string or an array parameter
* Example if you want to pass an array in the group by method
* $group_by_arr = array('fname', 'lname')
* $db->select_all('tbl_users');
* $db->order_by('fname', 'ASC');
* $db->group_by($group_by_arr); // Call the group by method
* $users = $db->get(); // This will output SELECT * FROM tbl_users GROUP BY fname, lname
* or if you pass a string in the group by method
* $db->select_all('tbl_users'); 
* $db->order_by('fname', 'ASC');
* $db->group_by('fname'); // Call the group by method
* $users = $db->get(); // This will output SELECT * FROM tbl_users GROUP BY fname
*/
##########################################################################################################################################################
/*
* SQL having statement by using the method having($column_name, $operator, $value);
* This method accepts three parameters. The first parameter is the column name that you want to specify and
* second parameter is the operator that you will use. The third parameter is the value
* Example:
* $db->select_all('tbl_users');
* $db->having('lname', '=', 'Cruz');
* $db->order_by();
* $users = $db->get();
* $where_select = $db->select_fields('tbl_users');
* $db->having('fname', '=', 'vincent');
* This will output SELECT * FROM tbl_users HAVING fname = 'John'
*/
##########################################################################################################################################################
/*
* SQL where clause statement by using the method where(array(), $condition)
* The first parameter is an associative array in the where clause which consist of key value pair
* The key in the associative array is the name of your fields or column in your tables and the operator that you will use
* where the value in the associative array is the data that will be selected
* The second parameter is the condition that you will use the where clause if you leave it null the default value of this is 'AND' condition

* Consider this example!
* $arr = array('fname=' => 'John', 'lname=' => 'Cruz');
* $db->select_all('tbl_users'); 
* $db->where($arr, 'AND'); 
* $user = $db->get_single_row();
* echo $db->check_query(); // This will output SELECT * FROM tbl_users WHERE fname = 'John' AND lname = 'Cruz'

* This is also execute safer queries!

* You can also pass a string in the where clause method by using your own condition
* $my_condition = "fname = 'test' AND lname = 'test2' ";
* $db->select_all('tbl_users'); 
* $db->where($condition);
* $user = $db->get_single_row();
*/
##########################################################################################################################################################
/*
* SQL where like statement by using the method where_like($column_name, $value);
* The first parameter is the column name the second parameter is the value that will get the occurence
* Example:
* $db->select_all('tbl_users');
* $db->where_like('fname', 'John');
* $users = $db->get(); // This will output SELECT * FROM tbl_users WHERE fname LIKE "John";
* Note: You can use your own wildcard when performing where_like
* Example:
* $db->select_all('tbl_users');
* $db->where_like('fname', '%John%');
* $users = $db->get(); // This will output SELECT * FROM tbl_users WHERE fname LIKE "%John%";


* You can use also the where not like function which means compliment of like
* Example:
* $db->select_all('tbl_users');
* $db->where_like('fname', '%John%');
* $users = $db->get(); // This will output SELECT * FROM tbl_users WHERE fname NOT LIKE "%John%";
*/
##########################################################################################################################################################
/*
* The SQL where in statement by using the method where_in($column_name, array());
* This will accepts 2 parameters the first parameter is the column name and the second is an array of values
* Example:
* $db->select_all('tbl_users');
* $db->where_in('fname', array('John', 'Alex', 'Jayson'));
* $users = $db->get(); // This will output SELECT * FROM tbl_users WHERE fname IN ('John', 'Alex', 'Jayson');
* You can also use the where not in method by using the method where_not_in($column_name, array());
* The parameters is the same in where_in
*/
##########################################################################################################################################################
/*
* 
* SQL join statement by using the method join($table_name, $column_join, $join_type);
* This will accepts 3 parameters. The first one is the table name that you want to join. The second is the column name that you want to join
* and the third is the join type that is(LEFT, RIGHT, INNER, LEFT OUTER, RIGHT OUTER)
* Example:
* $db->select_fields('tbl_users AS a', array('a.fname', 'b.comment'));
* $db->join('tbl_comment AS b', 'a.id = b.user_id', 'INNER');
* $users = $db->get();
* echo $db->check_query(); // This will output SELECT a.fname, b.comment FROM tbl_users AS a INNER JOIN tbl_comment AS b ON a.id = b.id
* If you want to perform multiple joins kindly call again the method join for example
* $db->select_fields('tbl_users AS a', array('a.fname', 'b.comment'));
* $db->join('tbl_comment AS b', 'a.id = b.user_id', 'INNER');
* $db->join('tbl_post AS c', 'a.id = c.user_id', 'INNER');
* $users = $db->get();
* echo $db->check_query(); // This will output 
* SELECT a.fname, b.comment FROM tbl_users AS a INNER JOIN tbl_comment AS b ON a.id = b.id INNER JOIN tbl_post AS c ON a.id = c.id
* Note: in my example previous I use an alias when performing joins
*/
##########################################################################################################################################################
/*
* SQL insert statement by using this method insert($table_name, array());
* This methods accepts two parameters. The first parameter is the name of your table
* The second is the data will be insert, which is an associative array consist of key value pair.
* The key is the column name in your table and the value is the data will be inserted in the your table
* Example:
* $data = array('fname' => 'John', 'lname' => 'Cruz', 'mname' => 'De Ocampo');
* $db->insert('tbl_users', $data);
* echo $db->check_query();  // This will output INSERT INTO tbl_users (fname, lname, mname) VALUES ('John', 'Cruz', 'De Ocampo');
* Note: The return value of this method is number of affected rows in your table

* If you want to insert multiple data's you can achieve this by using multiple associative array inside an array
* Consider this example:
* $data =
*   array(
*     array('fname' => 'John', 'lname' => 'Cruz', 'mname' => 'De Ocampo'),
*     array('fname' => 'Alex', 'lname' => 'Cruz', 'mname' => 'De Ocampo'),
*     array('fname' => 'Johny', 'lname' => 'Cruz', 'mname' => 'De Ocampo')
*   );
* $db->insert('tbl_users', $data);
* echo $db->execute();
* Note: If you perform the INSERT, UPDATE, DELETE you need to call the method execute() to your query take effect
* The return value of this is the affected rows in the database
*/
##########################################################################################################################################################
/*
* SQL update statement by using the method update($table_name, array());
* This methods accepts two parameters. The first parameter is the name of your table
* The second is the data will be update which is associative array consist of key value pair.
* The key is the fields or column name in your table and the value is the data will be updated in your table
* Example:
* $data = array('fname' => 'John', 'lname' => 'Llyod', 'mname' => 'Cruz');
* $db->update('tbl_users', $data); // This will output UPDATE tbl_users SET fname = 'Vincent', lname = 'Llauderes'
* Note: You can also use the where function when updating data's

* Example:
* $data = array('fname' => 'Vincent', 'lname' => 'Llauderes');
* $db->update('tbl_users', $data); // This will output UPDATE tbl_users SET fname = 'Vincent', lname = 'Llauderes' WHERE id = 1;
* $db->where(array('id =' => '1'));
* echo $db->execute(); // The return value of this method is number of rows that will updated!
*/
##########################################################################################################################################################
/*
* SQL delete statement by using the method delete($table_name);
* This methods accepts one parameter. The first parameter is the name of your table which will be data deleted!
* Note: You can also use the where function when deleting data's
* Consider this example:
* $db->delete('tbl_users'); // This will output UPDATE tbl_users SET fname = 'Vincent', lname = 'Llauderes' WHERE id = 1;
* $db->where_in('fname', array('vincent', 'llauderes'));
* echo $db->execute(); // The return value of this method is number of rows that will deleted!
*/
##########################################################################################################################################################
/*
* SQL truncate statement by using the method truncate($table_name);
* This methods accepts one parameter. The first parameter is the name of your table which will be truncated!
* $db->truncate('tbl_users'); // This will output TRUNCATE tbl_users;
* The return value of this method is 1 or 0 to determine if the query is work!
*/
##########################################################################################################################################################
/*
* SQL get insert id by using method get_insert_id();
* Basically this method will use after perform insert statement!
* This method has a return value that will get the inserted id in the table!
* Consider this example:
* Let's say you perform a SQL insert statement using db query
* $db->query('INSERT INTO tbl_users (id, fname, mname, lname) VALUES (1011, 'Vincent', 'Llauderes', 'Calma') ');
* if you perform the get insert id method
* if will get the inserted id
* $db->get_insert_id() // This will output 1011;
*/
##########################################################################################################################################################
/*
* SQL get num rows statement by using method get_num_rows();
* Basically this method will use after perform select statement!
* This method has a return value that will get the num of rows that will be selected in the table!
* Consider this example:
* Let's say you perform a SQL select statement using db query
* $db->query("SELECT * FROM tbl_users"); // Let's assume that the number of data will be selected is 10
* if you perform the get_num_rows method
* if will get the number of return rows
* $db->get_num_rows() // This will output 10;
*/
##########################################################################################################################################################
/*
*
* SQL aggregate function
* select_count($table_name) method
* Counting the number of rows
* This method accepts one parameter which the table that you will count
* Example:
* $total = $db->select_count('tbl_users'); // The return value of this method is associative array which you can access 
* by using your variable that you will store the select count and lamda expression followed by the total_item
* echo $total->total_item; // Display the total number of users
* 
*/
##########################################################################################################################################################
/*
* get_average($table_name, $column_name);
* Get the average of the specified column
* Example:
* $avg = $db->get_average('tbl_users', 'id');
* // The return value of this method is associative array which you can access 
* by using your variable that you will store followed by the 
* name of your column that is (id) in our example//
* echo $avg->id
*
*
*/
##########################################################################################################################################################
/*
* get_max($table_name, $column_name);
* Get the maximum value in the specified column
* Example:
* $max_id = $db->get_max('tbl_users', 'id');
* echo $max_id->id; // Get the maximum value in column id
*
*/
##########################################################################################################################################################
/*
* get_min($table_name, $column_name);
* Get the minimum value in the specified column
* Example:
* $min_id = $db->get_min('tbl_users', 'id');
* echo $min_id->id; // Get the minimum value in column id
*
*/
##########################################################################################################################################################
/*
* get_variance($table_name, $column_name);
* Get the variance in the specified table
* Example:
* $variance = $db->get_variance('tbl_users', 'id');
* echo $variance->id; // Get the variance in column id
*
*/
##########################################################################################################################################################
/*
* get_sttdev($table_name, $column_name);
* Get the standard deviation in the specified table
* Example:
* $sttdev = $db->get_sttdev('tbl_users', 'id');
* echo $sttdev->id; // Get the standard deviation in column id
*
*/

// $db->select_fields('tbl_users AS b', array('COUNT(b.fname)'));
// $db->join('tbl_students AS a', 'b.id = a.id', 'RIGHT OUTER');
// $db->where(array('lname' => 'llauderes'));
// $db->order_by(array('id' => 'DESC', 'fname' => 'ASC'));
// $db->limit(1);

// $users =$db->select_count('tbl_users');
// echo json_encode($users->total_item);

// $users =$db->get_variance('tbl_users', 'id');
// echo json_encode($users->variance_id);


// $db->select_all('tbl_users');
// echo json_encode($db->get());


// $db->delete('tbl_users');
// $db->where_in('fname', array('vincent', 'vench'));
// echo json_encode($db->check_query());


// $db->update('tbl_users', array('fname' => 'vincent', 'lname' => 'llauderes'));
// $db->where_in('fname', array('vincent', 'vench'));
// echo json_encode($db->check_query());


// $users =$db->select_count('tbl_users');
// echo json_encode($db->check_query());


// $db->select_fields('tbl_users AS b', array('b.fname'));
// $db->join('tbl_students AS a', 'b.id = a.id', 'LEFT');
// $db->order_by(array('b.id' => 'DESC', 'b.fname' => 'ASC'));
// $db->limit(1);
// echo json_encode($db->get_result()->fname);

// $users = $db->insert('tbl_users', 
//    array('fname'=> 'vincent', 'mname' => 'calma', 'lname'=>'vincent'));
// echo json_encode($users);

// $db->update('tbl_users', array('fname' => 'ssa', 'lname' => 'ssb'));
// $db->where("WHERE mname = 'calma'");
// $db->limit(1);
// echo json_encode($db->check_query());


// $arr_fields = array('id');
// $db->select_fields('tbl_comment', $arr_fields);
// $users = $db->get(); // This will return an associative array
// print_r($users);

/*

* You can also use your own query statement by passing a string in the method query($string) which accept one parameter

* Consider this example:
* $db->query("SELECT * FROM tbl_users WHERE fname = 'VINCENT' "); // Perform a select query

* $db->query("DELETE FROM tbl_users WHERE id = 1011"); // Perform a delete query

* $db->query("INSERT INTO tbl_users (fname) VALUES ('vincent')"); // Perform an insert statement

* $db->query("UPDATE tbl_users SET mname = 'no' WHERE id = '1000' LIMIT 1"); // Perform an update statement
*/


/*

// $arr = array('fname' => 'John', 'lname' => 'Cruz');

// $arr = array('fname' => 'ssa');
// $db->select_all('tbl_comment'); 
// // $db->where($arr, '=', 'AND');
// $db->where_between('id', 2000, 2005);
// $user = $db->get(); // This will output SELECT * FROM tbl_users WHERE fname = 'John' AND lname = 'Cruz'

// print_r($user);

// echo $db->check_query();

*/


// require_once('api/mweb.php');

// $db = mweb::connect('localhost', 'root', 'llauderesv321', 'mweb0');

//$data = array('fname' => 'John', 'lname' => 'Cruz', 'mname' => 'De Ocampo');
// $data =
//    array(
//      array('fname' => 'John', 'lname' => 'Cruz', 'mname' => 'De Ocampo'),
//      array('fname' => 'Alex', 'lname' => 'Cruz', 'mname' => 'De Ocampo'),
//      array('fname' => 'Johny', 'lname' => 'Cruz', 'mname' => 'De Ocampo')
//    );
// $db->insert('tbl_users', $data);
// print_r($db->execute());
// print_r($db->get_insert_id());
//print_r($db->check_query());

//$db->commit();

//$db->beginTransaction();
//print_r($db->check_query());

// $data2 =array('fname' => 's', 'lname' => 'Llauderes', 'mname' => 'Calma');
// $db->update('tbl_users', $data2);
// print_r($db->execute());
// print_r($db->check_query());

// $db->delete('tbl_users');
// $db->where(array('id>' => '1152'));
// print_r($db->execute());

// $arr = array('id=' => '2001', 'forum_id=' => '4001');
// $db->select_all('tbl_comment');
//$db->where_between('id', '2000', '2002');
//$db->having('id', '=', '2000');
// $db->order_by('id', 'asc');
// print_r($db->get());
// echo '<br />';
// print_r($db->get_num_rows());
//print_r($db->check_query());

//$db->truncate('tbl_users');
//$db->execute();

// $arrs = array('forum_id=' => '4001');
// $db->select_all('tbl_comment');
// $db->where($arrs);
// $db->limit(1);
// echo '<br />';
// print_r($db->get());
// echo '<br />';
// print_r($db->check_query());

// $arr1 = array('user_id=' => '1002');
// $db->select_all('tbl_comment');
// $db->where($arr1);
// $db->limit(1);
// echo '<br />';
// print_r($db->get());
// echo '<br />';
// print_r($db->check_query());

// $db->select_all('tbl_comment');
// $db->where_not_like('id','2001');
// echo '<br />';
// print_r($db->get());
// echo '<br />';
// print_r($db->check_query());

// $db->select_fields('tbl_comment', array('id'));
// $db->where_not_in('id', array('2000', '2001', '2002'));
// echo '<br />';
// print_r($db->get());
// echo '<br />';
// print_r($db->check_query());

// $db->select_fields('tbl_comment AS a', array('a.id'));
//$db->join('tbl_users AS b', 'a.user_id = b.id', 'INNER');
// $db->group_by('forum_id');
// $db->having('forum_id', '>', '4002');
// $db->order_by(array('id' => 'ASC', 'forum_id' => 'ASC'));
// echo '<br />';
// echo json_encode($db->get());
// echo '<br />';
// print_r($db->check_query());

// $arr = array('id=' => '2001');
// $db->select_fields('tbl_comment', array('id')); 
// $db->where($arr);
// print_r($db->get_single_row());

// print_r($db->check_query());


// $max = $db->get_min('tbl_comment', 'id');
// print_r($max->min_id);



?>
