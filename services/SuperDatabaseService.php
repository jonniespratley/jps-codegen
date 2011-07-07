<?php 
require_once "SuperDatabaseAccess.php";
include 'config.php';
class SuperDatabaseService {
    private $service;
    public $svcResultFormat;
    public $svcDatabase;
    public $svcTable;
    
    /**
     * I am a simple service class for multiplating a mysql database. Either through amfphp or javascript.
     * For returning json just set the resultFormat = 'json'. Then you should be all set. Be sure to
     * enter your credentials in the constructor of this class.
     * @return
     */
    public function __construct() {
        //TODO: Credentials here
		
        #$this->service = new SuperDatabaseAccess('mysql', 'localhost', null, 'root', 'fred');
        $this->service = new SuperDatabaseAccess('mysql', DB_HOST, null, DB_USER, DB_PASS);
    }
    /**
     * I return all the databases on the server with information about the contents.
     * @return [array] - Tree ready array holding all databases with child nodes as tables, and table fields as child nodes.
     */
    public function getDatabases() {
    	$args = array();
        return $this->returnResult( 'getDatabases', $args, $this->service->getDatabases());
    }
    /**
     * I return all records from the specified database/table.
     * @param [string] - $database - The database name.
     * @param [string] - $table - The table name.
     * @return  [array] - All records from table.
     */
    public function get($database, $table, $columns = "*", $where = null, $count = 25, $page = 0, $sort = null) {
        $this->svcDatabase = $database;
        $this->svcTable = $table;       
		$args = array('columns' => $columns, 'where' => $where, 'count' => $count, 'page' => $page, 'sort' => $sort);
        return $this->returnResult( 'get', $args, $this->service->select($database, $table, $columns, $where, $count, $page, $sort));
    }
	
	public function one($database, $table, $keyvalue){
		return $this->returnResult('get', null, $this->service->selectOne($database, $table, $keyvalue));
	}
	
    /**
     * I create/update a record in the databases table.
     * @param [string] - $database - The database name.
     * @param [string] - $table - The table name.
     * @param [object] - $vo - Assoc array containing all name/value for the object.
     * This can be post fields where the key are the column names and the value is the new/edited values.
     * If the table does not have a primary key then there is a problem and will not be saved.
     * For testing in amfphp create your object like this. (ex. For updating: {"id":"4", "tag":"Flex"}) (ex. For creating: {"id":"0", "tag":"Flex"} )
     * @return [object] - The object that was sent if the call was successfull or false if it was not.
     */
    public function save($database, $table, $vo) {
        $this->svcDatabase = $database;
        $this->svcTable = $table;
        $args = $vo;
        return $this->returnResult( 'save', $args, $this->service->save($database, $table, $vo));
    }
    /**
     * I create a record in the databases table.
     * @param [string] - $database - The database name.
     * @param [string] - $table - The table name.
     * @param [object] - $vo - Assoc array containing all name/value for the object.
     * This can be post fields where the key are the column names and the value is the new/edited values.
     * If the table does not have a primary key then there is a problem and will not be saved.
     * For testing in amfphp create your object like this. (ex. For updating: {"id":"4", "tag":"Flex"}) (ex. For creating: {"id":"0", "tag":"Flex"} )
     * @return [object] - The object that was sent if the call was successfull or false if it was not.
     */
    public function create($database, $table, $vo) {
        $this->svcDatabase = $database;
        $this->svcTable = $table;
        $args = $vo;
        return $this->returnResult( 'create', $args, $this->service->create($database, $table, $vo));
    }
    /**
     * I update a record in the databases table.
     * @param [string] - $database - The database name.
     * @param [string] - $table - The table name.
     * @param [object] - $vo - Assoc array containing all name/value for the object.
     * This can be post fields where the key are the column names and the value is the new/edited values.
     * If the table does not have a primary key then there is a problem and will not be saved.
     * For testing in amfphp create your object like this. (ex. For updating: {"id":"4", "tag":"Flex"}) (ex. For creating: {"id":"0", "tag":"Flex"} )
     * @return [object] - The object that was sent if the call was successfull or false if it was not.
     */
    public function update($database, $table, $vo) {
        $this->svcDatabase = $database;
        $this->svcTable = $table;        
		$args = $vo;
        return $this->returnResult( 'update', $args, $this->service->update($database, $table, $vo));
    }
    /**
     * I remove a record from the database/table.
     * @param [string] - $database - The database name.
     * @param [string] - $table - The table name.
     * @param [object] - $vo - Assoc array containing name/value pairs, for deleting to be successful send the primary key as the key and the record id value
     * to delete. (ex. Amfphp: {"id":"4"} )
     * @return - [bool] - true or false of the call
     */
    public function remove($database, $table, $vo) {
        $this->svcDatabase = $database;
        $this->svcTable = $table;
        $args = $vo;
        return $this->returnResult( 'search', $args, $this->service->remove($database, $table, $vo));
    }
    /**
     * I get all of the tables with information about them from the specified database.
     * @param [string] - $database - The database name.
     * @return [array] - All tables with information
     */
    public function getTables($database) {
        $this->svcDatabase = $database;
        
		$args = array('database' => $database);
        return $this->returnResult( 'getTables', $args, $this->service->getTables($database));
    }
    /**
     * I search any table/column that is specified in the paramenters.
     * @param object $database
     * @param object $table
     * @param object $columns [optional]
     * @param object $where [optional]
     * @param object $query [optional]
     * @param object $count [optional]
     * @param object $page [optional]
     * @param object $sort [optional]
     * @return
     */
    public function search($database, $table, $columns = "*", $where = null, $query = null, $count = 25, $page = 0, $sort = null) {
        $this->svcDatabase = $database;
        $this->svcTable = $table;
        $args = array('columns' => $columns, 'where' => $where, 'query' => $query, 'count' => $count, 'page' => $page, 'sort' => $sort);
        return $this->returnResult( 'search', $args, $this->service->search($database, $table, $columns, $where, $query, $count, $page, $sort));
    }
    
    /**
     *
     * @return
     */
    public function readLog() {        
		$args = array();
        return $this->returnResult( 'readLog', $args, $this->service->readLog());
    }

	public function writeLog($title, $var) {        
		$args = array();
        return $this->returnResult( 'writeLog', $args, $this->service->writeLog($title, $var));
    }


 
 	/**
 	 * 
 	 * @param object $call
 	 * @param object $args
 	 * @param object $results
 	 * @return 
 	 */
    private function returnResult($call,$args, $results) {
    	$argCount = count($args);
		
		
        if ('json' === $this->svcResultFormat) {
            #header('Content-type: application/json');
            
			header('Content-type: text/plain');
            return json_encode(array(array($results)));
            
        } else if ('php' === $this->svcResultFormat) {
            #header('Content-type: application/x-httpd-php');
            
			header('Content-type: text/plain');
            return serialize($results);
            
        } else if ('sql' === $this->svcResultFormat) {
           
		    header('Content-type: text/plain');
            $sql = '';
			
            foreach($results["data"] as $result) {
                
                $sql .= 'INSERT INTO '.$this->svcDatabase.'.'.$this->svcTable.' VALUES ';
                foreach ($result as $key=>$value) {
                    $sql .= $key.' = '.$value.', ';
                }
				$sql = substr($sql, 0, strlen($sql) - 2);
                $sql .= ";\n";
            }
            return $sql;

            
        } else if ('xml' === $this->svcResultFormat) {
            header('Content-type: text/xml');
						
            $xml = '<?xml version="1.0"?>';
            $xml .= "\n";
           	$xml .= '<results status="'.$results["status"].'" database="'.$results["database"].'" table="'.$results["table"].'" count="'.$results["count"].'">';
			
			if($results["data"]){
				$resultsData = $results["data"];
				$xml .= "\n";
				
				if ($call === 'get' || $call === 'search'){
				
	            	for ($i = 0; $i < count($resultsData); $i++) {
	            		
	                	#$xml .= '<'.$results["table"].' row="'.($i + 1).'">';
	                	$xml .= '<row number="'.($i + 1).'">';
	             	   	$xml .= "\n";
	                
	                	foreach ($resultsData[$i] as $key=>$value) {
	                    	$xml .= '<'.htmlentities(trim($key)).'>'.htmlentities(trim($value)).'</'.htmlentities(trim($key)).'>';
	                    	$xml .= "\n";
	                	}
	                	#$xml .= '</'.$results["table"].'>';
	                	$xml .= "</row>";
	                	$xml .= "\n";
	            	} 
				} else {
					foreach ($resultsData as $key=>$value) {
                    	$xml .= '<'.htmlentities(trim($key)).'>'.htmlentities(trim($value)).'</'.htmlentities(trim($key)).'>';
                    	$xml .= "\n";
                	}
				}
			}
            
            $xml .= "\n";
            $xml .= '</results>';
            
            return $xml;
        } else {
            return $results;
        }
    }

    
}
?>
