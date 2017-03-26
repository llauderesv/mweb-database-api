<?php
/*
 *   Author: MWEB - Mobile Web
 *   Website: <http://getmweb.hol.es>
 *   Date created: 3/18/2017
 *
 */
class mweb {

   private $_db;
   private $_where_clause = NULL;
   private $_group_by = NULL;
   private $_order_by = NULL;
   private $_stmt = NULL;
   private $_having = NULL;
   private $_query = NULL;
   private $_where_values = array();
   private static $_instance;

    // Singleton instance!
    public static function connect($_host, $_user, $_pass, $_dbase)
    {
	    if (!self::$_instance)
	    {
	        self::$_instance = new mweb($_host, $_user, $_pass, $_dbase);
	    }
      	return self::$_instance;
    }  // End of getInstance function!

    // Create a constructor!
    public function __construct($_host, $_user, $_pass, $_dbase)
    {
	   	try 
	   	{
	     	$this->_db = new PDO('mysql:host='.$_host.'; dbname='.$_dbase.'; charset=utf8mb4', $_user, $_pass);
	        $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    		$this->_db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	   	} 
	   	catch(PDOException $err) 
	   	{
			echo $err->getMessage();
		}
    } // End of construct function!

    /*
	* SQL Transaction
	*
    */
    // Function for start the database transaction
    public function beginTransaction()
    {
    	if (func_num_args() === 0) 
    	{
    		$this->_db->beginTransaction(); // Begin the transaction
    	}
	    else
	    {	// Display the error if the parameter is null
	    	$this->display_error('Invalid passing a parameter in beginTransaction() method.', debug_backtrace());
	    }
    } // End of database transaction

    // Function for committing the database transaction
    public function commit($param = NULL)
    {
    	if (func_num_args() === 1 AND $param !== NULL) 
    	{
    		$this->_db->commit(); // Commit the transaction
    	}
    	else if ($param === NULL)
    	{
    		$this->_db->rollback(); // Commit the transaction
    	}
	    else
	    {	// Display the error if the parameter is null
	    	$this->display_error('Invalid passing a parameter in commit() method.', debug_backtrace());
	    }
    } // End of commit transaction

	/* End of SQL Transaction */

    /*
	* SQL Select statement
	*
    */
	// Querying data in database!
	public function select_all($tbl_name = NULL)
	{
	    if ($tbl_name !== NULL AND func_num_args() === 1) // Check if the table name is empty and the number of argument that will pass
	    {
	        $this->_query = "SELECT * FROM " . $tbl_name;
	    }
	    else
	    {	// Display the error if the parameter is null
	    	$this->display_error('Invalid passing a parameter in select_all(tbl_name) method.', debug_backtrace());
	    }
	} // End of select all function

    // Selecting specific fields in the table
    public function select_fields($tbl_name = NULL, $fields = NULL)
    {
        if (is_array($fields) AND !empty($fields) AND $tbl_name !== NULL  AND func_num_args() === 2)
        {
            $fields = implode(', ', $fields);
            $this->_query = "SELECT $fields FROM " . $tbl_name;
        }
	    else
	    {	// Display the error if the parameter is null
	    	$this->display_error('Invalid passing a parameter in select_fields($tbl_name, array()) method.', debug_backtrace());
	    }
    } // End of select fields function

    // Function for join tables
   	public function join($table_name = NULL, $column_join = NULL, $join_type = NULL)
   	{
      	if ($table_name !== NULL AND $column_join !== NULL AND $join_type !== NULL AND func_num_args() === 3) // Validate all the parameter if has a value
      	{
         	$join = NULL;
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
	            case 'INNER':
	               $join = $join_type;
	               break;
         	}
         	$this->_query .= ($join !== NULL ? ' ' . $join : '') . " JOIN $table_name ON $column_join ";
      	}
      	else
	    {	// Display the error if the parameter is null
	    	$this->display_error('Invalid passing a parameter in join($table_name, $column_join, $join_type) method.', debug_backtrace());
	    }
      	return $this->_query;
   	} // End of join function

    // Function counting the records in the table
    public function select_count($tbl_name = NULL)
    {
      	return $this->select_aggregate_function($tbl_name, '0', 'COUNT', debug_backtrace(), 1, 'select_count($tbl_name)');
    } // End of select count function

   	// Function for getting the average
   	public function get_average($tbl_name = NULL, $column = NULL)
   	{
      	return $this->select_aggregate_function($tbl_name, $column, 'AVG', debug_backtrace(), func_num_args(), 2, 'get_average($tbl_name, $column)');
   	} // End of average function

   	// Function for getting the sum
   	public function get_sum($tbl_name = NULL, $column = NULL)
   	{
        return $this->select_aggregate_function($tbl_name, $column, 'SUM', debug_backtrace(), func_num_args(), 2, 'get_sum($tbl_name, $column)');
   	} // End of sum function

   	// Function for getting the max
   	public function get_max($tbl_name = NULL, $column = NULL)
   	{	
   		return $this->select_aggregate_function($tbl_name, $column, 'MAX', debug_backtrace(), func_num_args(), 2, 'get_max($tbl_name, $column)');
   	} // End of max function

   	// Function for getting the min
   	public function get_min($tbl_name = NULL, $column = NULL)
   	{
   		return $this->select_aggregate_function($tbl_name, $column, 'MIN', debug_backtrace(), func_num_args(), 2, 'get_min($tbl_name, $column)');
   	} // End of min function

   	// Function for getting the variance
   	public function get_variance($tbl_name = NULL, $column = NULL)
   	{
   		return $this->select_aggregate_function($tbl_name, $column, 'VARIANCE', debug_backtrace(), func_num_args(), 2, 'get_variance($tbl_name, $column)');
   	} // End of variance function

   	// Function for getting the sttdev
   	public function get_sttdev($tbl_name = NULL, $column = NULL)
   	{
   		return $this->select_aggregate_function($tbl_name, $column, 'STDDEV', debug_backtrace(), func_num_args(), 2, 'get_sttdev($tbl_name, $column)');
   	} // End of sttdev function

    // Function aggregate sql function
    private function select_aggregate_function($tbl_name = NULL, $column = NULL, $type = NULL, $debug, $func_num_args, $num_ars, $func_name)
    {
        if ($tbl_name !== NULL AND $column !== NULL AND $type !== NULL AND $func_num_args === $num_ars) // Validate the parameter
        {
	        $aggregate = NULL;
	        switch (ucwords($type)) { // Check the aggregate function
	            case 'COUNT':
	               $aggregate = 'COUNT(*) AS total_item';
	               break;
	            case 'AVG':
	               $aggregate = 'AVG('.$column.') AS '.$column.'';
	               break;
	            case 'SUM':
	               $aggregate = 'SUM('.$column.') AS '.$column.'';
	               break;
	            case 'MAX':
	               $aggregate = 'MAX('.$column.') AS '.$column.'';
	               break;
	            case 'MIN':
	               $aggregate = 'MIN('.$column.') AS '.$column.'';
	               break;
	            case 'VARIANCE':
	               $aggregate = 'VARIANCE('.$column.') AS '.$column.''; // Get the definition in SQL books
	               break;
	            case 'STDDEV':
	               $aggregate = 'STDDEV('.$column.') AS '.$column.''; // Get the definition in SQL books
	               break;
	        }
	        $this->_query = "SELECT $aggregate FROM " . $tbl_name;
	    	return $this->get_func('single_row', $debug);
      	}
        else
	    {	// Display the error if the parameter is null
	    	$this->display_error("Invalid passing a parameter in your $func_name method.", $debug);
	    }
	} // End of aggregate function

	// Function for get the queries
	public function get()
	{
		if (func_num_args() === 0) 
		{
    		return $this->get_func(NULL, debug_backtrace());
		}
		else
	    {	// Display the error if the parameter is null
	    	$this->display_error("No parameter that will passed in your get() method.", debug_backtrace());
		}
	} // End of get function

	// Function for get the single object
    public function get_single_row()
    {
		if (func_num_args() === 0) 
		{
    		return $this->get_func('single_row', debug_backtrace());
		}
		else
	    {	// Display the error if the parameter is null
	    	$this->display_error("No parameter that will passed in your get_single_row() method.", debug_backtrace());
		}
    } // End of get result

    // Function getting result
    private function get_func($type = NULL, $debug, $manipulate = NULL)
    {	
    	try
    	{
    		//$this->_db->beginTransaction(); // Begin the transaction

    		$this->_stmt = $this->_db->prepare($this->_query); // Prepare the PDO statement

    		$this->_stmt->execute($this->_where_values); // Execute the PDO statement with a parameterize query

   			$this->_where_values = array(); // Clear first the parameter value

    		//$this->_db->commit(); // Commit the transaction
    		if ($manipulate !== NULL)
		    {
		    	return $this->_stmt->rowCount();
		    }
		    if ($this->_stmt->rowCount() > 0) // Check the number of returned rows
		    {
		      	$json = ($type === NULL ? $this->_stmt->fetchAll(PDO::FETCH_OBJ) : $this->_stmt->fetch());
		      	return json_decode(json_encode($json));
		    }
		    else
		    {
		    	return 0;
		    }
    	} 
    	catch(PDOException $error)
    	{
    		//$this->_db->rollback(); // Rollback the database transaction
    		return $this->display_error($error->getMessage(), $debug); // Display the error to make them debuggable
    	}
    } // End of get function

    // Function for limit!
    public function limit($limit = NULL)
    {
        if ($limit !== NULL AND func_num_args() === 1)
        {
          	$this->_query .= ' LIMIT ' . $limit;
        }
        else
	    {	// Display the error if the parameter is null
	    	$this->display_error("Invalid passing a parameter in limit($limit) method.", debug_backtrace());
	    }
    } // End of limit function

    // Function for offset!
    public function offset($offset = NULL)
    {
        if ($offset !== NULL AND func_num_args() === 1)
        {
         	$this->_query .= ' OFFSET ' . $offset;
        }
        else
	    {	// Display the error if the parameter is null
	    	$this->display_error("Invalid passing a parameter in offset($offset) method.", debug_backtrace());
	    }
    } // End of offset function!

    /*
	*
	* SQL Where statement
	*
	*
    */

    // Function for getting the specific data!
    public function where($clause = array(), $condition = NULL)
    {
        //$this->_where_values = array(); // Clear the placeholder in the prepared statement
        // Condition for checking the clause variable if array or string!
        if (is_array($clause) AND count(array_filter(array_keys($clause), 'is_string')) > 0 AND func_num_args() <= 2)
        {
         	// If condition is NULL set the condition to AND
         	if ($condition === NULL)
	        {
	         	$condition = 'AND';
	        }
         	foreach ($clause as $key => $val)
         	{
            	$this->_where_clause .= $key . '?' . ' ' . $condition . " ";
            	$this->_where_values[] = $val;
         	}
         	$this->_query .= " WHERE " . substr($this->_where_clause, 0, strripos($this->_where_clause, $condition)) . ' ';
         	$this->_where_clause = " WHERE " . substr($this->_where_clause, 0, strripos($this->_where_clause, $condition)) . ' ';
         	$this->_where_clause = NULL;
      	}
      	else
	    {	
	    	// Display the error if the parameter is null
	    	$this->display_error('Invalid passing a parameter in where(array(), $condition) method.', debug_backtrace());
	    }
	  //  $this->_where_values = array();
   	} // End of where function!

   	// Function for where like
   	public function where_like($column_name = NULL, $value = NULL)
   	{
      	$this->where_like_func($column_name, $value, '', 2, func_num_args(), debug_backtrace(), 'where_like($column_name, $value)'); // Call the method of where like
   	} // End of where like function!

   	// Function for where not like
   	public function where_not_like($column_name = NULL, $value = NULL)
   	{
      	$this->where_like_func($column_name, $value, 'NOT', 2, func_num_args(), debug_backtrace(), 'where_not_like($column_name, $value)'); // Call the method of where like
   	} // End of where not like function!

   	// Function for where like
   	private function where_like_func($column_name = NULL, $value = NULL, $type, $num_args, $func_num_args, $debug, $method_name)
   	{
        //$this->_where_values = array(); // Clear the placeholder in the prepared statement
      	if ($column_name !== NULL AND $value !== NULL AND $func_num_args === $num_args)
      	{
         	//$placeholder = ':'.$column_name;
            $this->_where_values[] = $value;
         	$this->_query .= " WHERE " . $column_name . " ".($type !== NULL ? $type : '')." LIKE ? ";
         	$this->_where_clause = " WHERE " . $column_name . " ".($type !== NULL ? $type : '')." LIKE ? ";
         	$this->_where_clause = NULL;
      	}
      	else
      	{
	    	// Display the error if the parameter is null
	    	$this->display_error('Invalid passing a parameter in '.$method_name.' method.', $debug);
      	}
   	} // End of where like function

   	// Function for where in!
   	public function where_in($column_name = NULL, $value = array())
   	{
      	$this->where_in_func($column_name, $value, NULL, 2, func_num_args(), debug_backtrace(), 'where_in($column_name, array())'); // Call the method of where in
   	} // End of where in function!

   	// Function for where not in
   	public function where_not_in($column_name = NULL, $value = array())
   	{
      	$this->where_in_func($column_name, $value, 'NOT', 2, func_num_args(), debug_backtrace(), 'where_not_in($column_name, array())'); // Call the method of where in
   	} // End of where not in function

   	// Function for where in and where not in
   	private function where_in_func($column_name = NULL, $value = array(), $type, $num_args, $func_num_args, $debug, $method_name)
   	{
        //$this->_where_values = array(); // Clear the placeholder in the prepared statement
      	if ($column_name !== NULL AND is_array($value) AND $func_num_args === $num_args)
      	{
         	$placeholder = null;
         	foreach ($value as $val)
         	{
         		$placeholder .= '?,';
            	$this->_where_values[] = $val; // add the placeholder in the prepared statement array
         	}
         	$this->_query .= " WHERE " . $column_name . " ".($type !== NULL ? $type : '')." IN (".substr($placeholder, 0, strripos($placeholder, ',')).") ";
         	$this->_where_clause = " WHERE " . $column_name . " ".($type !== NULL ? $type : '')." IN (".substr($placeholder, 0, strripos($placeholder, ',')).") ";
         	$this->_where_clause = NULL;
      	}
      	else
      	{
	    	// Display the error if the parameter is null
	    	$this->display_error('Invalid passing a parameter in '.$method_name.' method.', $debug);
      	}
   	} // End of where function

   	// Function for where between!
   	public function where_between($column_name = NULL, $value = NULL, $value_two = NULL)
   	{
        //$this->_where_values = array(); // Clear the placeholder in the prepared statement
      	if ($column_name !== NULL AND $value !== NULL AND $value_two !== NULL AND func_num_args() === 3) 
      	{
            $this->_where_values[] = $value; // add the placeholder in the prepared statement array
            $this->_where_values[] = $value_two; // add the placeholder in the prepared statement array

         	$this->_query .= " WHERE " . $column_name . " BETWEEN ".'?'." AND ".'?' ." ";
         	$this->_where_clause = " WHERE " . $column_name . " BETWEEN ".'?'." AND ".'?' ." ";
         	$this->_where_clause = NULL;
      	}
      	else
      	{
	    	// Display the error if the parameter is null
	    	$this->display_error('Invalid passing a parameter in where_between($column_name, $value, $value_two) method.', debug_backtrace());
      	}
   	} // End of where between function

   	/*
	*
	* End of SQL Where statement
	*
   	*/

   	// Function for order by!
   	public function order_by($order_column = NULL, $order_type = NULL)
   	{
      	// Check if the order by is associative array!
      	if (is_array($order_column) AND count($order_column) > 0 AND func_num_args() === 1)
      	{
         	foreach ($order_column as $key => $value)
         	{
            	$this->_order_by .= $key . " " . $value . ",";
         	}
         	$this->_query .= " ORDER BY " . substr($this->_order_by, 0, strripos($this->_order_by, ','));
      	}
      	else if (is_string($order_column) AND $order_type !== NULL AND func_num_args() === 2)
      	{
         	$this->_query .= " ORDER BY " . $order_column . ' ' . $order_type;
      	}
      	else
      	{
	    	// Display the error if the parameter is null
	    	$this->display_error('Invalid passing a parameter in order_by(array(), $order_type) method.', debug_backtrace());
      	}
   	} // End of order by function!

   	// Function for group by
   	public function group_by($group_column = NULL)
   	{
        if ($group_column !== NULL AND func_num_args() === 1)
        {
         	// Check if the group by is associative array!
         	if (is_array($group_column) AND count($group_column) > 0)
         	{
	            foreach ($group_column as $key => $value)
	            {
	                $this->_group_by .= $value . ",";
	            }
         	}	
         	else if (is_string($group_column) AND $group_column !== NULL) // Else this is a string!
         	{
            	$this->_group_by = $group_column . ",";
         	}
	      	else
	      	{
		    	// Display the error if the parameter is null
		    	$this->display_error('Invalid passing a parameter in group_by($group_column) method.', debug_backtrace());
	      	}
         	$this->_query .= " GROUP BY " . substr($this->_group_by, 0, strripos($this->_group_by, ','));
      	}
      	else
      	{
	    	// Display the error if the parameter is null
	    	$this->display_error('Invalid passing a parameter in group_by($group_column) method.', debug_backtrace());
      	}
   	} // End of group by function

   	// Function for having clause!
   	public function having($column = NULL, $operator = NULL, $value = NULL)
   	{
   		//$this->_where_values = array();
      	if (is_string($column) AND $operator !== NULL AND $value !== NULL AND func_num_args() === 3)
      	{
            $this->_where_values[] = $value;
         	$this->_query .= " HAVING " . $column . " " . $operator .'?'." ";
      	}
      	else
      	{
	    	// Display the error if the parameter is null
	    	$this->display_error('Invalid passing a parameter in having($column, $operator, $value) method.', debug_backtrace());
      	}
   	} // End of having function
   	/*
   	*
   	* SQL Manipulating Database
   	*
   	*
   	*/
   	// Function for inserting data!
   	public function insert($tbl_name = NULL, $data = array())
   	{
   		//$this->_where_values = array();
      	// Check if the table name is not NULL!
      	if ($tbl_name !== NULL AND $data !== NULL AND func_num_args() === 2)
      	{
         	if (is_array($data))
         	{
            	$column = NULL;
            	$param = NULL;
               	$placeholder = NULL;
            	foreach ($data as $key => $value)
            	{
            		if (is_array($value)) 
            		{
            			foreach ($value as $key => $val) 
            			{
                     		$column .= $key . ", ";
         					$placeholder .= '?,';
            			}
	                  	if ($column !== NULL AND $placeholder !== NULL)
	                  	{
	                     	$param .= "(".substr($placeholder, 0, strripos($placeholder, ','))."),";
	                     	$this->_query = "INSERT INTO $tbl_name (".substr($column, 0, strripos($column, ', ')).") VALUES ".substr($param, 0, strripos($param, ','))."";
	                     	$column = NULL;
	                     	$placeholder = NULL;
	                  	}  
						// Merge the values in the placeholder
				    	$this->_where_values = array_merge($this->_where_values, array_values($value)); 
					}
					else
					{
                   		$column .= $key . ",";
          				$placeholder .= '?,'; // Placeholder in prepared statement
	               		$this->_query = "INSERT INTO $tbl_name (".substr($column, 0, strripos($column, ',')).") VALUES (".substr($placeholder, 0, strripos($placeholder, ',')).") ";
	               		$this->_where_values = array_values($data); // Get the value in the array that will be inserted
					}

            	} // End of for each

         	} // End of if statement
      	} 
      	else
      	{
	    	// Display the error if the parameter is null
	    	$this->display_error('Invalid passing a parameter in insert($tbl_name, $data) method.', debug_backtrace());
      	} // End of if statement

   	} // End of insert function!

   	// Function for updating the table!
   	public function update($tbl_name = NULL, $data = array())
   	{
      	if ($tbl_name !== NULL AND $data !== NULL AND func_num_args() === 2)
      	{
         	if (is_array($data))
         	{
            	$placeholder = NULL;
            	foreach ($data as $key => $value)
            	{
               		$placeholder .= $key . '='."?" . ", ";
               		$this->_where_values[] = $value;
            	}
            	$this->_query = "UPDATE $tbl_name SET ".substr($placeholder, 0, strripos($placeholder, ', '))." ";
         	}
        }
        else
        {
	    	// Display the error if the parameter is null
	    	$this->display_error('Invalid passing a parameter in update($tbl_name, $data) method.', debug_backtrace());
        }
    } // End of update function!

    // Function for delete data!
   	public function delete($tbl_name = NULL)
   	{  	
   		//$this->_where_values = array(); // Clear first the parameter value
   		// Check if the table name is empty!
      	if ($tbl_name !== NULL AND func_num_args() === 1)
      	{
         	$this->_query = "DELETE FROM $tbl_name ";
			//echo $this->_query; // Execute the insert statement
      	}
      	else
        {
	    	// Display the error if the parameter is null
	    	$this->display_error('Invalid passing a parameter in delete($tbl_name) method. Expects passing a one parameter only.', debug_backtrace());
      	}
   	} // End of delete function!


   	// Function for truncating table!
   	public function truncate($tbl_name = NULL)
   	{  	// Check if the table name is empty!
      	if ($tbl_name !== NULL AND func_num_args() === 1)
      	{
	      	try
	    	{
	    		$this->_stmt = $this->_db->prepare("TRUNCATE $tbl_name"); // Prepare the PDO statement

	    		$this->_stmt->execute(); // Execute the PDO statement with a parameterize query
	    	} 
	    	catch(PDOException $error)
	    	{
	    		//$this->_db->rollback(); // Rollback the database transaction
	    		return $this->display_error($error->getMessage(), debug_backtrace()); // Display the error to make them debuggable
	    	}
      	}
      	else
      	{
	    	// Display the error if the parameter is null
	    	$this->display_error('Invalid passing a parameter in truncate($tbl_name) method. Expects passing a one parameter only.', debug_backtrace());
      	}
   	} // End of truncate function!
   	/*End of SQL manipulating database*/

   	// Function for executing the queries
   	public function execute()
   	{
   		if (func_num_args() === 0) 
   		{
			return $this->get_func(NULL, debug_backtrace(), 'true'); // Execute the insert statement
   		}
   		else
        {
	    	// Display the error if the parameter is null
	    	$this->display_error('Invalid passing a parameter in execute() method. Expects no parameter.', debug_backtrace());
      	}
   	} // End of execute function

   	// Function for getting the insert id in the table
   	public function get_insert_id()
   	{
   		if (func_num_args() === 0) 
   		{
   			return $this->_db->lastInsertId(); // Get the last insert id in the table
   		}
   		else
        {
	    	// Display the error if the parameter is null
	    	$this->display_error('Invalid passing a parameter in get_insert_id() method. Expects no parameter.', debug_backtrace());
      	}
   	} // End of get insert if function

   	// Function for getting the num rows
   	public function get_num_rows()
   	{
   		if (func_num_args() === 0) 
   		{
   			return $this->_stmt->rowCount();
   		}
   		else
        {
	    	// Display the error if the parameter is null
	    	$this->display_error('Invalid passing a parameter in get_insert_id() method. Expects no parameter.', debug_backtrace());
      	}
   	}

   	// Function for checking the query!
   	public function check_query()
   	{
   		if (func_num_args() === 0) 
   		{
   	   		return $this->_query;
   		}
   		else
	    {	
	    	// Display the error if the parameter is null
	    	$this->display_error('Invalid passing a parameter in check_query() method.', debug_backtrace());
	    }
   	} // End of check query function

    // Function for showing the SQL error!
    private function display_error($error, $debug)
    {
     	echo "<link rel='stylesheet' href='api/styles.css'>";
		echo '<p class="div_error">Error found in ' . $debug[0]['file'] . ' on line ' . $debug[0]['line'] .'.<br />'. $error . ' </p>';
    	die();
    } // End of sql error function!

} // End of class mweb
