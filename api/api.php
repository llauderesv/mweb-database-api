<?php

/*
 *   Author: Vncnt Llrds
 *   Website: <http://getmweb.hol.es>
 *   Date created: NULL
 *
 */

class Database
{
   private $_db;
   private $_where_clause = null;
   private $_result = null;
   private static $_instance;

   // Singleton instance!
   public static function getInstance()
   {
      if (!self::$_instance)
      {
         self::$_instance = new self();
      }
      return self::$_instance;
   } // End of getInstance function!

   // Create a constructor!
   public function __construct()
   {
      $this->_db = new MySQLi('localhost', 'root', 'llauderesv321', 'mweb0');
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
   public function select_all($tbl_name = null, $limit = null, $offset = null)
   {
      if ($tbl_name !== null)
      {
         $query = "SELECT * FROM " . $tbl_name . ($this->_where_clause !== null ? " $this->_where_clause" : "") . ($limit !== null ? " LIMIT " . $limit : "") . ($offset !== null ? " , " . $offset : "");
         $this->_result = $this->_db->query($query);
         $this->sql_error();
      }
      $this->_where_clause = null;
      return $this->fetch_query($this->_result);
      //return $query;
   } // End of select all function!

   // Selecting specific fields in the table!
   public function select_fields($fields = null, $tbl_name = null, $limit = null, $offset = null)
   {
      if ($tbl_name !== null AND $fields !== null)
      {
         $fields = implode(', ', $fields);
         $query = "SELECT $fields FROM " . $tbl_name . ($this->_where_clause !== null ? " $this->_where_clause" : "") . ($limit !== null ? " LIMIT " . $limit : "") . ($offset !== null ? " , " . $offset : "");
         $this->_result = $this->_db->query($query);
         $this->sql_error();
      }
      //return $query;
      $this->_where_clause = null;
      return $this->fetch_query($this->_result);
   } // End of select fields function!

   // Using your own query!
   public function query($query)
   {
      $this->_result = $this->_db->query($query);
      $this->sql_error();
      return $this->fetch_query($this->_result);
   } // End of query function!

   // Get the number returned rows!
   public function get_num_rows()
   {
      return $this->_result->num_rows;
   } // End of get num rows!

   // Fetching the result query and desanitize the row!
   private function fetch_query($result)
   {
      $rows = array();
      while($records = $result->fetch_object())
      {
         $rows[] = $records;
      }
      return $this->sanitize_row_array($rows);
      //return $this->result;
   } // End of fetch query function!

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
      return json_decode(json_encode($sanitize_arr));
   } // End of sanitize row array!

   // Remove the html codes in the string!
   private function escape_html_string($string)
   {
      return htmlentities(stripslashes($string));
   } // End of escape html string function!

   // Function for getting the specific data!
   public function where($clause = null, $operator = null, $condition = null)
   {
      // Condition for checking the clause variable if array or string!
      if (is_array($clause))
      {
         // If condition is null set the condition to AND
         if ($condition === null || $condition === FALSE)
         {
            $condition = 'AND';
         }
         // If operator is null set the operator to equal (=)
         if ($operator === null || $operator === FALSE)
         {
            $operator = '=';
         }
         // clause variable is array!
         foreach ($clause as $key =>$val)
         {
            $this->_where_clause .= $key . " $operator " . " '".$this->_db->real_escape_string($this->escape_html_string($val))."' " . " $condition ";
         }
         $this->_where_clause = "WHERE " . substr($this->_where_clause, 0, strripos($this->_where_clause, $condition));
      }
      else
      {
         $this->_where_clause = $clause;
      }
      //$this->_where_clause = $clause;
   } // End of where function!

   // Function for showing the SQL error!
   private function sql_error()
   {
      if (!$this->_result)
      {
         die('<p style="background-color: #dedede; font-family: verdana; padding: 20px; border: 1px solid #CCC;"><span style="color: red;">Oops error:</span> ' . $this->_db->error . '</p>');
      }
   } // End of sql error function!

   // Function for inserting data!
   public function insert($tbl_name = null, $data = array())
   {
      // Check if the table name is not null!
      if ($tbl_name !== null || $tbl_name !== FALSE)
      {
         if (is_array($data))
         {
            $column = null;
            $values = null;
            // Check if the array data is multple insertion or not!
            foreach ($data as $key => $value)
            {
               if (is_array($value))
               {
                  foreach ($value as $key => $value) {
                     $column .= $key . ",";
                     $values .= "'$value',";
                     if ($column !== null && $values !== null) {
                        $query = "INSERT INTO $tbl_name (".substr($column, 0, strripos($column, ',')).") VALUES (".substr($values, 0, strripos($values, ',')).") ";
                        $this->_result = $this->_db->query($query);
                        $this->sql_error();
                     }
                     $column = null;
                     $values = null;
                  }
               } else {
                  $column .= $key . ",";
                  $values .= "'$value',";
                  if ($column !== null && $values !== null) {
                     $query = "INSERT INTO $tbl_name (".substr($column, 0, strripos($column, ',')).") VALUES (".substr($values, 0, strripos($values, ',')).") ";
                     $this->_result = $this->_db->query($query);
                     $this->sql_error();
                  }
               }
            }
            return $this->_result === true ? true : false;
         }
      }
   } // End of insert function!

   // Function for getting insert id!
   public function get_insert_id()
   {
      $this->sql_error();
      return $this->_db->insert_id;
   } // End of get insert function!

}
