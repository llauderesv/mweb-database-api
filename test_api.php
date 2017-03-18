<?php

require_once('api/api.php');

$db = Database::getIntance();

// SQL select statement by using the method select_all($var1, null, null)
// This will accept 3 parameters the first one is the table name that will be selected the second is
// The limit which is optional and the third is the offset which is optional
// Consider this example:
// $users = $db->select_all('tbl_users');

// This will return an associative array you can access this object by using the lambda expression (->).
// Example:

/*

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

// Selecting for specific fields or column in the table by using select_fields($var1, $var2, null, null) method
// The third and fourth parameter is optional
// $array_fields = array('fname');
// $users = $db->select_fields($array_fields, 'tbl_users');

// You can a string using your own query by using a method query($string) which accept a one parameter
// this will return an associative array!
// Consider this example:
// $db->query("SELECT * FROM tbl_users");

// The SQL where clause statement by using the method where(array(), $var2, $var3)
// You can pass an associative array in the where clause!
// Consider this example!
// The first parameter in the where method accept an associative array which contains a key value pair!
// The second parameter in the where method is the operator that you will use in the query!
// The third parameter in the where method is the condition that you will use in the query!
// Note: if the third parameter is null the default value is 'AND' condition!
// Consider this example!
// $val = array('fname' => 'test', 'lname' => 'test');
// $db->where($val, '=', 'AND');
// $users = $db->select_all('tbl_users'); // This will output SELECT * FROM tbl_users WHERE fname = 'test' AND lname = test
// This is also execute safer queries!

// You can pass a string in the where clause method by using your own condition
// $condition = "fname = 'test' AND lname = 'test2' "
// $db->where($condition);

$db->where(array('id' => '1000'), '=');
$users = $db->select_all("tbl_users");
$num_rows = $db->get_num_rows();
print_r("Returned rows: " . $num_rows);

?>
<table border="1" cellpadding="10" cellspacing="0">
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
</table> <br />
<?php

$db->where("WHERE id > '2002' ");
$users_two = $db->query("SELECT id AS lesson_id, topic_name FROM tbl_lessons WHERE id > '2002' ");
$num_rows = $db->get_num_rows();
print_r("Returned rows: " . $num_rows);
?>

<table border="1" cellpadding="10" cellspacing="0">
   <thead>
      <tr>
         <th>Lesson ID</th>
         <th>Topic name</th>
      </tr>
   </thead>
   <tbody>
      <?php
         foreach ($users_two as $row) {
            echo '<tr>';
               echo '<td>'.$row->lesson_id.'</td>';
               echo '<td>'.$row->topic_name.'</td>';
            echo '</tr>';
         }
      ?>
   </tbody>
</table>
