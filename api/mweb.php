<?php

/*
 *   Author: MWEB - Mobile Web
 *   Website: <http://getmweb.hol.es>
 *   Date created: NULL
 *
 */
class mweb
{
   private $_db;
   private $_where_clause = NULL;
   private $_group_by = NULL;
   private $_order_by = NULL;
   private $_result = NULL;
   private $_having = NULL;
   private $_query = NULL;
   private $_execute = NULL;
   private static $_instance;

   // Singleton instance!
   public static function connect($_host, $_user, $_pass, $_dbase)
   {
      if (!self::$_instance)
      {
         self::$_instance = new mweb($_host, $_user, $_pass, $_dbase);
      }
      return self::$_instance;
   } // End of getInstance function!

   // Create a constructor!
   public function __construct($_host, $_user, $_pass, $_dbase)
   {
      $this->_db = new MySQLi($_host, $_user, $_pass, $_dbase);
      if (mysqli_connect_error())
      {
         // Display the error message...
         die('There was something error: ' . mysqli_connect_error());
      }
      else
      {
         // Set the unicode format...
         $this->_db->set_charset('utf-8');
      } // End of else statement...
   } // End of construct function!

   // Querying data in database!
   public function select_all($tbl_name = NULL, $limit = NULL, $offset = NULL)
   {
      if ($tbl_name !== NULL AND $tbl_name !== FALSE)
      {
         $this->_query = "SELECT * FROM " . $tbl_name;
      }
   } // End of select all function!

   // Selecting specific fields in the table!
   public function select_fields($tbl_name = NULL, $fields = NULL, $limit = NULL, $offset = NULL)
   {
      if ($fields !== NULL AND $fields !== FALSE)
      {
         $fields = implode(', ', $fields);
         $this->_query = "SELECT $fields FROM " . $tbl_name;
      }
   } // End of select fields function!

   // Function counting the records in the table
   public function select_count($tbl_name = NULL)
   {
      return $this->aggregate_function($tbl_name, null,'COUNT');
   } // End of select count function
   
   // Function for getting the average
   public function get_average($tbl_name = NULL, $column = NULL)
   {
      if ($column !== NULL AND $column !== FALSE) 
      {
         return $this->aggregate_function($tbl_name, $column,'AVG');
      }
   } // End of average function

   // Function for getting the sum
   public function get_sum($tbl_name = NULL, $column = NULL)
   {
      if ($column !== NULL AND $column !== FALSE) 
      {
         return $this->aggregate_function($tbl_name, $column, 'SUM');
      }
   } // End of sum function

   // Function for getting the max
   public function get_max($tbl_name = NULL, $column = NULL)
   {
      if ($column !== NULL AND $column !== FALSE) 
      {
         return $this->aggregate_function($tbl_name, $column, 'MAX');
      }
   } // End of max function

   // Function for getting the min
   public function get_min($tbl_name = NULL, $column = NULL)
   {
      if ($column !== NULL AND $column !== FALSE) 
      {
         return $this->aggregate_function($tbl_name, $column, 'MIN');
      }
   } // End of min function

   // Function for getting the variance
   public function get_variance($tbl_name = NULL, $column = NULL)
   {
      if ($column !== NULL AND $column !== FALSE) 
      {
         return $this->aggregate_function($tbl_name, $column, 'VARIANCE');
      }
   } // End of variance function


   // Function for getting the sttdev
   public function get_sttdev($tbl_name = NULL, $column = NULL)
   {
      if ($column !== NULL AND $column !== FALSE) 
      {
         return $this->aggregate_function($tbl_name, $column, 'STDDEV');
      }
   } // End of sttdev function

   // Function aggregate sql function
   private function aggregate_function($tbl_name = NULL, $column = NULL, $type = NULL)
   {
      if ($tbl_name !== NULL AND $tbl_name !== FALSE)
      {
         $aggregate = NULL;
         switch (ucwords($type)) {
            case 'COUNT':
               $aggregate = 'COUNT(*) AS total_item';
               break;
            case 'AVG':
               $aggregate = 'AVG('.$column.') AS average_'.$column.'';
               break;
            case 'SUM':
               $aggregate = 'SUM('.$column.') AS sum_'.$column.'';
               break;
            case 'MAX':
               $aggregate = 'MAX('.$column.') AS max_'.$column.'';
               break;
            case 'MIN':
               $aggregate = 'MIN('.$column.') AS min_'.$column.'';
               break;
            case 'VARIANCE':
               $aggregate = 'VARIANCE('.$column.') AS variance_'.$column.''; // Get the definition in SQL books
               break;
            case 'STDDEV':
               $aggregate = 'STDDEV('.$column.') AS stddev_'.$column.''; // Get the definition in SQL books
               break;
         }
         $this->_query = "SELECT $aggregate FROM " . $tbl_name;
         $this->_result = $this->_db->query($this->_query);
         $this->sql_error();
         return $this->fetch_query($this->_result);
      }
   } // End of aggregate function

   // Function for limit!
   public function limit($limit = NULL)
   {
      if ($limit !== NULL AND $limit !== FALSE)
      {
         $this->_query .= ' LIMIT ' . $limit;
      }
   } // End of limit function

   // Function for offset!
   public function offset($offset = NULL)
   {
      if ($offset !== NULL AND $offset !== FALSE)
      {
         $this->_query .= ' OFFSET ' . $offset;
      }
   } // End of offset function!

   // Function for getting the specific data!
   public function where($clause = NULL, $operator = NULL, $condition = NULL)
   {
      // Condition for checking the clause variable if array or string!
      if (is_array($clause))
      {
         // If condition is NULL set the condition to AND
         if ($condition === NULL || $condition === FALSE)
         {
            $condition = 'AND';
         }
         // If operator is NULL set the operator to equal (=)
         if ($operator === NULL || $operator === FALSE)
         {
            $operator = '=';
         }
         // clause variable is array!
         foreach ($clause as $key =>$val)
         {
            $this->_where_clause .= $key . " $operator " . " '".$this->_db->real_escape_string($this->escape_html_string($val))."' $condition";
         }
         $this->_query .= " WHERE " . substr($this->_where_clause, 0, strripos($this->_where_clause, $condition)) . ' ';
      }
      else
      {
         $this->_query .= $clause;
      }
   } // End of where function!

   // Function for where like
   public function where_like($column_name = NULL, $value = NULL)
   {
      if ($column_name !== NULL AND $value !== NULL)
      {
         $this->_query .= " WHERE " . $column_name . " LIKE '".$value."' ";
      }
   } // End of where like function!

   // Function for where not like
   public function where_not_like($column_name = NULL, $value = NULL)
   {
      if ($column_name !== NULL AND $value !== NULL)
      {
         $this->_query .= " WHERE " . $column_name . " NOT  LIKE '".$value."' ";
      }
   } // End of where not like function!

   // Function for where in!
   public function where_in($column_name = NULL, $value = array())
   {
      if ($column_name !== NULL AND is_array($value))
      {
         $param = null;
         foreach ($value as $val)
         {
            $param .=  "'" . $val . "',";
         }
         $this->_query .= " WHERE " . $column_name . " IN (".substr($param, 0, strripos($param, ',')).") ";
      }
   } // End of where in function!

   // Function for order by!
   public function order_by($order_column = NULL)
   {
      // Check if the order by is associative array!
      if (is_array($order_column) AND count($order_column) > 0)
      {
         foreach ($order_column as $key => $value)
         {
            $this->_order_by .= $key . " " . $value . ",";
         }
         $this->_query .= " ORDER BY " . substr($this->_order_by, 0, strripos($this->_order_by, ','));
      }
   } // End of order by function!

   // Function for group by
   public function group_by($group_column = NULL)
   {
      if ($group_column !== NULL)
      {
         // Check if the group by is associative array!
         if (is_array($group_column))
         {
            if (count($group_column) > 0)
            {
               foreach ($group_column as $key => $value)
               {
                  $this->_group_by .= $value . ",";
               }
            }
         }
         else if (is_string($group_column) AND $group_column !== NULL) // Else this is a string!
         {
            $this->_group_by = $group_column . ",";
         }
         $this->_query .= " GROUP BY " . substr($this->_group_by, 0, strripos($this->_group_by, ','));
      }
   } // End of group by function

   // Function for having clause!
   public function having($having = NULL, $operator = NULL, $value = NULL)
   {
      if (is_string($having) AND $operator !== NULL AND $value !== NULL)
      {
         $this->_query .= " HAVING " . $having . " " . $operator . " " . "'".$this->_db->real_escape_string($this->escape_html_string($value))."'";
      }
   } // End of having function

   // Function for join tables
   public function join($table_name = NULL, $column_join = NULL, $join_type = NULL)
   {
      if ($table_name !== NULL AND $table_name !== FALSE) 
      {
         $join = NULL;
         if ($join_type !== NULL AND $join_type !== FALSE) // Check if the join type is not empty!
         {
            switch (ucwords($join_type)) {
               case 'LEFT':
                  $join = $join_type;
                  break;
               case 'RIGHT':
                  $join = $join_type;
                  break;
               case 'LEFT OUTER':
                  $join = $join_type;
                  break;
               case 'RIGHT OUTER':
                  $join = $join_type;
                  break;
            }
         }
         $this->_query .= ($join !== NULL ? ' ' . $join : '') . " JOIN $table_name ON $column_join ";
      }
      return $this->_query;
   } // End of join function

   // Function for executing the queries!
   public function execute()
   {
      $this->_result = $this->_db->query($this->_query);
      $this->sql_error();
      return $this->fetch_row_query($this->_result);
   } // End of execute function!

   // Function for checking the query!
   public function check_query()
   {
      return $this->_query;
   } // End of check query function

###################################### MANIPULATING DATABASE ###########################################################################################

   // Function for inserting data!
   public function insert($tbl_name = NULL, $data = array())
   {
      // Check if the table name is not NULL!
      if ($tbl_name !== NULL AND $tbl_name !== FALSE)
      {
         if (is_array($data))
         {
            $column = NULL;
            $values = NULL;
            foreach ($data as $key => $value)
            {
               // Check if the array data is multple insertion or not!
               if (is_array($value))
               {
                  foreach ($value as $key => $value)
                  {
                     $column .= $key . ",";
                     $values .= " ' ".$this->_db->real_escape_string($this->escape_html_string($value))." ', ";
                  }
                  if ($column !== NULL AND $values !== NULL)
                  {
                     $query = "INSERT INTO $tbl_name (".substr($column, 0, strripos($column, ',')).") VALUES (".substr($values, 0, strripos($values, ',')).") ";
                     $this->_result = $this->_db->query($query);
                     $this->sql_error();
                     $column = NULL;
                     $values = NULL;
                  }
               }
               else // Single insertion!
               {
                  $column .= $key . ",";
                  $values .= " ' ".$this->_db->real_escape_string($this->escape_html_string($value))." ', ";
               }
            }
            if ($column !== NULL AND $values !== NULL)
            {
               $this->insert_func($tbl_name, $column, $values);
            }
            return $this->_result === true ? true : false;
         }
      }
   } // End of insert function!

   // Function inserting the data!
   private function insert_func($tbl_name, $column, $values)
   {
      $query = "INSERT INTO $tbl_name (".substr($column, 0, strripos($column, ',')).") VALUES (".substr($values, 0, strripos($values, ',')).") ";
      $this->_result = $this->_db->query($query);
      $this->sql_error();
   } // End of insert func!

   // Function for updating the table!
   public function update($tbl_name = NULL, $data = array())
   {
      if ($tbl_name !== NULL AND $tbl_name !== NULL)
      {
         if (is_array($data))
         {
            $param = NULL;
            foreach ($data as $key => $value)
            {
               $param .= $key . ' = ' . "'" . $this->_db->real_escape_string($this->escape_html_string($value)) . "'" . ",";
            }
            $query = "UPDATE $tbl_name SET ".substr($param, 0, strripos($param, ','))." ".($this->_where_clause !== NULL ? " $this->_where_clause" : "")." ";
            $this->_result = $this->_db->query($query);
            $this->sql_error();
         }
         $this->_where_clause = NULL;
         return $this->_db->affected_rows;
      }
   } // End of update function!

   // Function for delete data!
   public function delete($tbl_name = NULL)
   {  // Check if the table name is empty!
      if ($tbl_name !== NULL AND $tbl_name !== NULL)
      {
         $query = "DELETE FROM $tbl_name ".($this->_where_clause !== NULL ? " $this->_where_clause" : "") . " ";
         $this->_result = $this->_db->query($query);
         $this->sql_error(); // Check if there was a sql error!
         $this->_where_clause = NULL;
         return $this->_db->affected_rows;
      }
   } // End of delete function!

   // Function for truncating table!
   public function truncate($tbl_name = NULL)
   {  // Check if the table name is empty!
      if ($tbl_name !== NULL AND $tbl_name !== NULL)
      {
         $query = "TRUNCATE $tbl_name";
         $this->_result = $this->_db->query($query);
         $this->sql_error();
         return $this->_result === true ? true : false;
      }
   } // End of truncate function!

#######################################################################################################################################

   // Using your own query!
   public function query($query)
   {
      // Check if the query is select, insert, update, delete!
      switch (ucwords(substr($query, 0, strpos($query, ' ')))) {
         case 'SELECT':
               $this->_result = $this->_db->query($query);
               return $this->fetch_row_query($this->_result);
            break;
         case 'INSERT':
               $this->_result = $this->_db->query($query);
               return $this->_result === true ? true : false;
            break;
         case 'UPDATE':
               $this->_result = $this->_db->query($query);
               return $this->_db->affected_rows;
            break;
         case 'DELETE':
               $this->_result = $this->_db->query($query);
               return $this->_db->affected_rows;
            break;
         case 'TRUNCATE':
               $this->_result = $this->_db->query($query);
               return $this->_result === true ? true : false;
            break;
      }
      $this->sql_error(); // Display if there was an error!
   } // End of query function!

   // Get the number returned rows!
   public function get_num_rows()
   {
      return $this->_result->num_rows;
   } // End of get num rows!

   // Function for fetching result row query and desanitize the row!
   private function fetch_row_query($result)
   {
      $rows = array();
      while($records = $result->fetch_object())
      {
         $rows[] = $records;
      }
      return $this->sanitize_row_array($rows);
      //return $this->result;
   } // End of fetch query function!

   // Function for fetching single object
   private function fetch_query($result)
   {
      return $result->fetch_object();
   }  

   // Remove the htmlentities and escaping the string!
   private function sanitize_row_array($array)
   {
      $sanitize_arr = array();
      foreach ($array as $key => $value)
      {
         foreach ($value as $k => $val)
         {
            $sanitize_arr[$key][$k] = $this->_db->real_escape_string($this->escape_html_string($val));
         }
      }
      $this->_where_clause = NULL;
      return json_decode(json_encode($sanitize_arr));
   } // End of sanitize row array!

   // Function for SQL escaping the string!
   public function sanitize_string($string)
   {
      return $this->_db->real_escape_string($this->escape_html_string($string));
   } // End of sanitize string function!

   // Remove the html codes in the string!
   private function escape_html_string($string)
   {
      return htmlentities(stripslashes($string));
   } // End of escape html string function!

################################ RETRIEVING SQL ERROR ################################################################

   // Function for showing the SQL error!
   private function sql_error()
   {
      if (!$this->_result)
      {
         die('<p style="background-color: #dedede; font-family: verdana; padding: 20px; border: 1px solid #CCC;"><span style="color: red;">Oops error:</span> ' . $this->_db->error . '</p>');
      }
   } // End of sql error function!

######################################################################################################################

}
