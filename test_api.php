<style media="screen">
   * {
      font-family: consolas;
   }

</style>
<?php

require_once('api/mweb.php');

$db = mweb::connect('localhost', 'root', 'llauderesv321', 'mweb0');

/*

What is MWEB - Mobile Web PHP Database api?
MWEB PHP Database api is a tool in manipulatiing data in the database like performing queries, joins etc.
It is an open source project that you can use when you are developing WEB applications by simply downloading the file and 
follow some instructions below.

Want to contribute in this project?

*/


/*
* How to use?
* You can simply achieve this by including the connection in your php file and
* assigned it to variable to your database connection!
* The database constructor class has consist of 4 parameter!
* The first parameter is the host name that is (localhost)!
* The second parameter is the username of your phpmyadmin for default that is (root)!
* The third parameter is the password of your phpmyadmin!
* The fourth parameter is the database that you will use!
* Consider this example:
* $db = mweb::connect('localhost', 'root', '', 'students_db');
*/

/*

* SQL select statement by using the method select_all($var1, null, null)
* This will accept 3 parameters the first one is the table name that will be selected the second is
* The limit which is optional and the third is the offset which is optional again
* Consider this example:
* $users = $db->select_all('tbl_users');
* This will return an associative array you can access this object by using the lambda expression (->).
* Consider this example:

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

*/

//$users = $db->select_all('tbl_users');

/*
* Selecting for specific fields or column in the table by using select_fields($var1, $var2, null, null) method
* The first parameter accepts an associative array which consists of array of fields!
* The second parameter is the fields that will be selected in the table which an array variable that consist of name of the field
* The third and fourth parameter is optional
* Consider this example:
* $array_fields = array('fname', 'lname', 'mname');
* $users = $db->select_fields('tbl_users', $array_fields);

*/

/*

* You can also use your own query statement by passing a string variable by using a method query($string) which accept one parameter
* Consider this example:

* $db->query("SELECT * FROM tbl_users WHERE fname = 'VINCENT' "); // This will return an associative array!
* $db->query("DELETE FROM tbl_users WHERE id = 1011"); // This will return the number of affected rows!
* $db->query("INSERT INTO tbl_users (fname) VALUES ('vincent')"); // This will return 0 or 1 if the query is work or not!
* $db->query("UPDATE tbl_users SET mname = 'no' WHERE id = '1000' LIMIT 1"); // This will return the number of affected rows!

*/

/*
* The SQL where clause statement by using the method where(array(), $operator, $condition, $limit)
* The first parameter is an associative array in the where clause!
* The key in the associative array is the name of your column in your tables
* where the value in the associative array is the data that will be selected

* Consider this example!
* $arr = array('fname' => 'test', 'lname' => 'test 2');
* $db->where($val, '=', 'AND');
* $users = $db->select_all('tbl_users'); // This will output SELECT * FROM tbl_users WHERE fname = 'test' AND lname = 'test 2'

* The first parameter in the where clause method accepts an associative array which contains a key value pair!
* The second parameter in the where method is the operator that you will use in the query!
* The third parameter in the where method is the condition that you will use in the query!

* Note: if the second parameter is null the default value is '=' condition!
* Note: if the third parameter is null the default value is 'AND' condition!

* This is also execute safer queries!
*/

/*

* You can pass a string in the where clause method by using your own condition
* $my_condition = "fname = 'test' AND lname = 'test2' LIMIT 1";
* $db->where($condition);

/*
* The SQL where like statement by using the method where_like($column_name, $value, $limit, $offset);
* The first parameter is the column name the second parameter is the value that will get the occurence
* The third and fourth parameter is optional which is the limit and offset
* Consider this example:
* $db->where_like('fname', 'vincent');
* $db->select_all('tbl_users'); // This will output SELECT * FROM tbl_users WHERE fname LIKE "%vincent%";
* Note: You can use your own wildcard when performing where_like
* Example:
* $db->where_like('fname', '%vincent%');
* $db->select_all('tbl_users'); // This will return all the users who's first name is vincent

* You can use also the where not like function which means not like
* Example:
* $db->where_not_like('fname', '%vincent%');
* $db->select_all('tbl_users'); // This will return all the users who's first name is not vincent
*/

// $db->where_in('fname', array('vincent', 'vianca', 'vench'));
// $users = $db->select_all("tbl_users");
// $num_rows = $db->get_num_rows();
// print_r("Returned rows: " . $num_rows);

?>
<!-- <table border="1" cellpadding="10" cellspacing="0">
   <thead>
      <tr>
         <th>First name</th>
         <th>Last name</th>
         <th>Middle name</th>
      </tr>
   </thead>
   <tbody>
      <?php
         //
         // foreach ($users as $row) {
         //    echo '<tr>';
         //    echo '<td>'.$row->fname.'</td>';
         //    echo '<td>'.$row->lname.'</td>';
         //    echo '<td>'.$row->mname.'</td>';
         //    echo '</tr>';
         // }
      ?>
   </tbody>
</table> <br /> -->
<?php

// $db->where(array('id'=>'2001'), '>');
// $users_two = $db->select_all('tbl_lessons');
// if (isset($users_two)) {
// $num_rows = $db->get_num_rows();
// print_r("Returned rows: " . $num_rows);
// }
?>

<!-- <table border="1" cellpadding="10" cellspacing="0">
   <thead>
      <tr>
         <th>Lesson ID</th>
         <th>Topic name</th>
      </tr>
   </thead>
   <tbody>
      <?php
         // foreach ($users_two as $row) {
         //    echo '<tr>';
         //       echo '<td>'.$row->id.'</td>';
         //       echo '<td>'.$row->topic_name.'</td>';
         //    echo '</tr>';
         // }
      ?>
   </tbody>
</table> -->


<?php

/*
* SQL insert statement by using this method insert($table_name, array());
* This methods accepts two parameters. The first parameter is the name of your table which will be data inserted
* The second is the data will be insert which is associative array consist of key value pair.
* The key is the column name in your table and the value is the data will be inserted in the table
* Consider this example:
* $data = array('fname' => 'Vincent', 'lname' => 'Llauderes', 'mname' => 'Calma');
* Call the insert method
* $db->insert('tbl_users', $data)); // This will output INSERT INTO tbl_users (fname, lname, mname) VALUES ('Vincent', 'Llauderes', 'Calma');
* Note: the return value of this method is 1 or 0 this will indicate if the query is work or not!
* If you want to insert multiple data's you can achieve this by using multiple associative array inside an array
* Consider this example:
* $data =
*   array(
*     array('fname' => 'Vincent', 'lname' => 'Llauderes', 'mname' => 'Calma'),
*     array('fname' => 'Vianca', 'lname' => 'Llauderes', 'mname' => 'Calma'),
*     array('fname' => 'Vench John', 'lname' => 'Llauderes', 'mname' => 'Calma')
*   );
* echo $db->insert('tbl_users', $data);

*/

/*
* SQL update statement by using the method update($table_name, array());
* This methods accepts two parameters. The first parameter is the name of your table which will be data inserted
* The second is the data will be insert which is associative array consist of key value pair.
* The key is the column name in your table and the value is the data will be inserted in the table

* Consider this example:
* $data = array('fname' => 'Vincent', 'lname' => 'Llauderes');
* Call the update method
* $db->update('tbl_users', $data); // This will output UPDATE tbl_users SET fname = 'Vincent', lname = 'Llauderes'
* Note: You can also use the where function when updating data's


* Example:
* $db->where(array('id' => '1'));
* $data = array('fname' => 'Vincent', 'lname' => 'Llauderes');
* $db->update('tbl_users', $data); // This will output UPDATE tbl_users SET fname = 'Vincent', lname = 'Llauderes' WHERE id = 1;
* The return value of this method is number of rows that will updated!
*/

/*
* SQL delete statement by using the method delete($table_name);
* This methods accepts one parameter. The first parameter is the name of your table which will be data deleted!
* Note: You can also use the where function when deleting data's
* Consider this example:
* $db->where(array('id' => '1', 'fname' => 'llauderes', '=', 'AND', 1));
* $db->delete('tbl_users'); // This will output DELETE FROM tbl_users WHERE id = 1 AND fname = 'llauderes' LIMIT 1;
* The return value of this method is number of rows that will deleted!
*/


/*

* SQL truncate statement by using the method truncate($table_name);
* This methods accepts one parameter. The first parameter is the name of your table which will be truncated!
* $db->truncate('tbl_users'); // This will output TRUNCATE tbl_users;
* The return value of this method is 1 or 0 to determine if the query is work!

*/

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

/*
* SQL order by statement by using order_by(array()) method
* This method accepts an associative array that consists of your table that you want to order by
* The key in the associative array is the column name that you want to order and
* The value in the associative array is order by type that is ASC or DESC
* Example:
* $db->order_by(array('id' => 'DESC', 'fname' => 'ASC'));
* $db->select_all('tbl_users'); // This will output SELECT * FROM tbl_users ORDER BY id DESC, fname ASC
*/

/*
* SQL group by statement by using the method group_by($val)
* This method accepts a string or an array!
* Example of if you want to pass an array in the group by method
* $group_by_arr = array('fname', 'lname')
* $db->group_by($group_by_arr); // Call the group by method
* $db->select_all('tbl_users'); // This will output SELECT * FROM tbl_users GROUP BY fname, lname
* or if you pass a string in the group by method
* $db->group_by('fname')
* $db->select_all('tbl_users'); // This will output SELECT * FROM tbl_users GROUP BY fname
*
*/
// echo $db->where_like('fname', 'vincent', 5, 10);

/*
* SQL having statement by using the method having($column_name, $operator, $value);
* This method accepts three parameters. The first parameter is the column name that you want to specify and
* second parameter is the operator that you will use. The third parameter is the value
* Example:
* $db->where_in('fname', array('vincent', 'test', 'vench'));
* $db->order_by(array('id' => 'DESC', 'fname' => 'ASC'));
* $db->having('fname', '=', 'Vincent');
* $where_select = $db->select_fields('tbl_users');
* This will output SELECT * FROM tbl_users WHERE fname IN ('vincent','test','vench') HAVING fname = 'Vincent' ORDER BY id DESC,fname ASC
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

?>
