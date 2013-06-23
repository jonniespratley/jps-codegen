<?php /** * I am the Database Access Layer, I can manipulate the database. *  * This is a sample application. * * @version CodeGen - 1.9.1 * @author CodeGen - Jonnie Spratley - http://code.google.com/p/flex-codegen/ * * @package com.test.app * @name PostsService.php */require_once "testConnection.php";require_once "vo/PostsVO.php";class PostsService{	private $conn;	/**	 * I am the instance of a Database Access Object	 *	 * @return [link]	 */	public function __construct()	{		//TODO: need to enter in the proper credentials		$conn = new testConnection();		$this->conn = $conn;	}	/**	 * I get all records from the specified database and table	 * @return [array]	 */	public function getAllPosts()	{		return $this->_executeReturn("SELECT * FROM test.posts");	}	/**	 * I get one record from the specified database and table.	 *	 * @param [string] $keyvalue the value of your request	 * @return [array] the matching record	 */	public function getOnePosts($keyvalue)	{		return $this->_executeReturn("SELECT * 										FROM test.posts 										WHERE ".$this->_getKey()." = $keyvalue");	}	/**	 * I save a record to the specified database and table	 * @param [string] $vo the name/value object	 * @return [array] the inserted record	 */	public function savePosts($vo)	{		$choice = '';		$primarykey = $this->_getKey();		$primarykeyValue = $vo[$primarykey];		if ($primarykeyValue == 0 || $primarykeyValue == '')		{			$choice = $this->createPosts($vo);		}		else		{			$choice = $this->updatePosts($vo);		}		return $choice;	}	/**	 * I update a record in the database/table	 *	 * @param [string] $vo the name/value object	 * @return [array] the inserted object	 */	private function updatePosts($vo)	{		//get the primary key		$key = $this->_getKey();		//value of the key		$keyvalue = '';		//check if the object has a key with the same value as the primary key		if (array_key_exists($key, $vo))		{			//set the keyvalue variable to the array key inside the object,			//the key should be the same name as the key in the table			$keyvalue = $vo[$key];		}		//get the columns, the columns should be the name of the keys		//Get the name=values for the update set		$updateSet = '';		foreach ($vo as $name=>$value)		{			$updateSet .= $name.' = '.testConnection::escape($value).', ';		}		$updateSet = testConnection::trimSQL($updateSet);		//build the query		$sql = "UPDATE test.posts SET $updateSet WHERE $key = ".testConnection::escape($keyvalue);		//return sql for debugging		//return $this->_returnSQL ( $sql );		return $this->conn->execute($sql);	}	/**	 * I create a new record in the database/table	 *	 * @param [string] $vo the name/value object	 * @return [boolean] the inserted object	 */	private function createPosts($vo)	{		//get the columns, the columns should be the name of the keys		$voColumns = '';		$voValues = '';		foreach ($vo as $column=>$value)		{			$voColumns .= $column.', ';			$voValues .= testConnection::escape($value).', ';		}		$voColumns = testConnection::trimSQL($voColumns);		$voValues = testConnection::trimSQL($voValues);		//build the query		$sql = "INSERT test.posts ( $voColumns ) VALUES ( $voValues )";		//return		//return $this->_returnSQL ( $sql );		return $this->conn->execute($sql);	}	/**	 * I remove a record from the specified database/table	 *	 * @param [string] $keyvalue the value of the key	 * @return [boolean] the result	 */	public function removePosts($vo)	{		$keyvalue = $vo[$this->_getKey()];		return $this->conn->execute("DELETE FROM test.posts WHERE ".$this->_getKey()." = '$keyvalue'");	}	/**	 * I get the primary key for table.	 *	 * @return [string] the name of the primary key	 */	private function _getKey()	{		$keys = $this->conn->executeAndReturn("SHOW INDEX FROM test.posts");		$primaryKey = '';		foreach ($keys as $key)		{			if ($key['Key_name'] == 'PRIMARY')			{				$primaryKey = $key['Column_name'];			}		}		return $primaryKey;	}	/**	 * I map the resulting recordset to a posts object.	 *	 * @param [result] a result from a database query	 * @return [array] an array of Posts objects	 */	private function _mapObjectToPosts($obj)	{		$array = array ();		while ($row = mysqli_fetch_assoc($obj))		{			$vo = new PostsVO();			foreach ($row as $key=>$value)			{				$vo->__set($key, $value);			}			$array[] = $vo;		}		return $array;	}	/**	 * I execute a statment on the database, and return a array of	 * posts objects.	 *	 * @param [string] the query string to execute	 * @return [array] array of Posts objects	 */	private function _executeReturn($sql)	{		$query = $this->conn->execute($sql);		if ($query)		{			return $this->_mapObjectToPosts($query);		}		else		{			return false;		}	}	/**	 * I execute a raw query and return the result.	 * @param [string] $sql the query	 */	private function _execute($sql)	{		$query = $this->conn->execute($sql);		if ($query)		{			return $this->_mapObject($query);		}		else		{			return false;		}	}	private function _returnSQL($sql)	{		return $sql;	}}/** ============================================================================================== * REST SERVICE FOR CLASS * ============================================================================================== *///Set up the variables for the calls$mode = '';$query = '';/* ******************************************** * Switch based on the mode * ********************************************/$service = new PostsService();switch($_SERVER['REQUEST_METHOD']){	case 'GET':		$query = $_GET;		if ( isset ($_GET['m']))		{			$mode = $_GET['m']; //Mode			unset ($query['m']);		}		switch($mode)		{			case 'get':				$result = $service->getAllPosts();				echo json_encode($result);				break;			case 'getOne':				$result = $service->getOne($query);				echo json_encode($result);				break;		}	break;	case 'POST':		$query = $_POST;		if ( isset ($_POST['m']))		{			$mode = $_POST['m']; //Mode			unset ($query['m']);		}		switch($mode)		{			case 'save':				$result = $service->savePosts($query);				echo json_encode($result);				break;			case 'remove':				$result = $service->removePosts($query);				echo json_encode($result);				break;		}	break;}?>