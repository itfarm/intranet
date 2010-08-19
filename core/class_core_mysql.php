<?php
 /*
##################################################################################
#Christ CMS is the content management system for managing ministries,churches
#Author:Jacob Kwizera Mtalitinya
#class christMysqlDB is MySql database class
##################################################################################
*/
class christMysqlDB
{
	var $connection_id;
	var $result;
	var $record = array();

/**
 * MySql class constructor
 *
 * The constructor establishes a connection to a MySQL server and set working database.
 * If an error occures return with false else return with the connection_id.
 *
 * @param string $hostname
 * @param string $username
 * @param string $userpassword
 * @param string $database
 * @param bool   $persistent optional
 *
 * @return connection_id
 *
 */
	function christMysqlDB($hostname, $username, $userpassword, $database, $persistent = true)
	{
        $this->host       = $hostname;
		$this->user       = $username;
		$this->password   = $userpassword;
		$this->dbname     = $database;
        $this->persistent = $persistent;

		$this->connection_id = ($this->persistent) ? mysql_pconnect($this->host, $this->user, $this->password) : mysql_connect($this->host, $this->user, $this->password);

		if ($this->connection_id)
		{
			if ($this->dbname != "")
			{
				$dbselect = mysql_select_db($this->dbname);

				if( !$dbselect )
				{
					mysql_close($this->db_connect_id);
					$this->connection_id = false;
				}
			}
			return $this->connection_id;
		}
		else
			return false;
	}

	function f_CloseConnection()
	{
		if( $this->connection_id )
			return mysql_close($this->connection_id);
		else
			return false;
	}

	function f_ExecuteSql($sql = "")
	{
		unset($this->result);

		if ($sql != "")
			$this->result = mysql_query($sql, $this->connection_id);

        if (!$this->result) {
            $err = mysql_error();
        }
            
		if ($this->result)
		{
			unset($this->record[$this->result]);
			return $this->result;
		}
	}

	function f_GetSelectedRows($query_id = 0)
	{
		if( !$query_id ) $query_id = $this->result;

		return ( $query_id ) ? mysql_num_rows($query_id) : false;
	}

	function f_GetAffectedRows()
	{
		return ( $this->connection_id ) ? mysql_affected_rows($this->connection_id) : false;
	}

    function f_GetRecord($query_id = 0)
    {
        if( !$query_id ) $query_id = $this->result;
        if ($query_id)
        {
         	$this->record = mysql_fetch_assoc($query_id);
            return $this->record;
        }
        else
            return false;
    }

	function f_SetRecordPointer($recordnumber, $query_id = 0)
	{
		if( !$query_id ) $query_id = $this->result;

		return ( $query_id ) ? mysql_data_seek($query_id, $recordnumber) : false;
	}

	function f_GetNextId()
	{
		return ( $this->connection_id ) ? mysql_insert_id($this->connection_id) : false;
	}

	function f_FreeResult($query_id = 0)
	{
		if( !$query_id ) $query_id = $this->query_result;

		if ( $query_id )
		{
			unset($this->record[$query_id]);

			mysql_free_result($query_id);

			return true;
		}
		else
			return false;
	}

	function f_GetSqlError()
	{
		$result['message'] = mysql_error($this->connection_id);
		$result['code']    = mysql_errno($this->connection_id);

		return $result;
	}
}
?>