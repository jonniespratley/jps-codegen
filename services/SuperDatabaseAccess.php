<?php 
class SuperDatabaseAccess {

    /**
     * @var
     */
    public $apiDatabase;
    
    /**
     * @var
     */
    public $apiMaxCount = 200;
    
    /**
     * @var
     */
    public $apiUseKey = false;
    
    /**
     * @var
     */
    public $apiUseThrottle;
    
    /**
     * @var
     */
    public $apiThrottleMax;
    
    /**
     * @var
     */
    public $apiResultFormat;
    
    /**
     * @var
     */
    public $svcDatabase;
    
    /**
     * @var
     */
    public $svcTable;
    
    /**
     * @var
     */
    public $svcType;
    
    /**
     * @var
     */
    private $dsn = '';
    
    /**
     * @var
     */
    private $dbh = null;
    
    /**
     *
     * @param object $dbType [optional]
     * @param object $dbHost [optional]
     * @param object $dbPort [optional]
     * @param object $dbUser [optional]
     * @param object $dbPass [optional]
     * @return
     */
    public function __construct($dbType = 'mysql', $dbHost = 'localhost', $dbPort = 3306, $dbUser = null, $dbPass = null) {
    
        if ($dbType == 'mysql') {
            $this->svcType = 'mysql';
            $this->dsn = 'mysql:host='.$dbHost.'';
            $this->dsn .= $dbPort != null ? ':'.$dbPort.';' : ';';
            
        } else if ($dbType == 'sqlite') {
        
            $this->svcType = 'sqlite';
            $this->dsn = 'sqlite2:'.$dbName.'.db';
        }
        
        try {
            $this->dbh = new PDO($this->dsn, $dbUser, $dbPass);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e) {
            echo 'Connection failed: '.$e->getMessage();
            die();
        }
        
    }
    
    /**
     *
     * @param object $mode
     * @param object $database
     * @param object $table [optional]
     * @param object $sql [optional]
     * @param object $vo [optional]
     * @return
     */
    public function execute($mode, $database, $table = null, $sql = null, $vo = null) {
    
        try {
            $this->writeLog('SQL', $sql);
            $result = array();
            $return = null;
            
            //Function management variables
            $voColumns = '';
            $voBindColumns = '';
            $voKeyValue = '';
            $voValues = array();
            $voPrimaryKey = null;
            
            //Check if we are returning data
            if ($mode == 'select' || $mode == 'search') {
                $statement = $this->dbh->prepare($sql);
                $statement->execute();
                $records = array();
                while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    $records[] = $row;
                }
                $result = array('status'=>'success', 'database'=>$database, 'table'=>$table, 'count'=>$statement->rowCount(), 'data'=>$records);
                $return = $result;
                
                //Check if its an insert
            } else if ($mode == 'insert') {
            
                //Make sure there is assoc array for vo
                if ($vo != null) {
                
                    //Loop each key=value for the vo
                    foreach ($vo as $column=>$value) {
                        $voColumns .= $column.', ';
                        
                        //build the bind params
                        $voBindColumns .= '?, ';
                        
                        //push the values to a value array
                        array_push($voValues, $value);
                    }
                    
                    //Trim the strings
                    $voColumns = $this->trimSQL($voColumns);
                    $voBindColumns = $this->trimSQL($voBindColumns);
                    
                    //Build the sql
                    $sql = "INSERT INTO $database.$table ( $voColumns ) VALUES ( $voBindColumns )";
                    
                    //log it
                    $this->writeLog('SQL', $sql);
                    
                    //Prepare database with the ? placeholders
                    $statement = $this->dbh->prepare($sql);
                    
                    //If the query executed properly
                    if ($statement->execute($voValues)) {
                    
                        //Prep the result to return
                        $result = array('status'=>'success', 'database'=>$database, 'table'=>$table, 'count' => 1, 'data'=>array('insertid'=>$this->dbh->lastInsertId()));
                        $return = $result;
                    }
                }

                
            } else if ($mode == 'update') {
                if ($vo != null) {
                
                    $voPrimaryKey = $this->getKey($database, $table);
                    
                    if (array_key_exists($voPrimaryKey, $vo)) {
                        $voKeyValue = $vo[$voPrimaryKey];
                    }
                    foreach ($vo as $column=>$value) {
                        $voBindColumns .= $column.'= ?, ';
                        array_push($voValues, $value);
                    }
                    array_push($voValues, $voKeyValue);
                    
                    $voBindColumns = $this->trimSQL($voBindColumns);
                    
                    $sql = "UPDATE $database.$table SET $voBindColumns WHERE $voPrimaryKey = ?";
                    
                    $this->writeLog('SQL', $sql);
                    $statement = $this->dbh->prepare($sql);
                    
                    if ($statement->execute($voValues)) {
                        $result = array('status'=>'success', 'database'=>$database, 'table'=>$table, 'count' => 1, 'data'=>array('updateid'=>$voKeyValue));
                        $return = $result;
                    }
                }
                
            } else if ($mode == 'delete') {
                if ($vo != null) {
                    $voPrimaryKey = $this->getKey($database, $table);
                    $voKeyValue = '';
                    if (array_key_exists($voPrimaryKey, $vo)) {
                        $voKeyValue = $vo[$voPrimaryKey];
                    }
                    
                    $sql = "DELETE FROM $database.$table WHERE $voPrimaryKey = ?";
                    
                    $this->writeLog('SQL', $sql);
                    $statement = $this->dbh->prepare($sql);
                    
                    if ($statement->execute(array($voKeyValue))) {
                        $result = array('status'=>'success', 'database'=>$database, 'table'=>$table, 'count' => 1,'data'=>array('deleteid'=>$voKeyValue));
                        $return = $result;
                    }
                }
                
            }
            
        }
        catch(PDOException $e) {
            $result = array('status'=>'error', 'message'=>$e->getMessage());
        }

        
        return $return;
    }
    
    /**
     *
     * @param object $database
     * @param object $table
     * @param object $columns [optional]
     * @param object $where [optional]
     * @param object $count [optional]
     * @param object $page [optional]
     * @param object $sort [optional]
     * @return
     */
    public function select($database, $table, $columns = "*", $where = null, $count = 25, $page = 0, $sort = null) {
        $sorting = ($sort != null) ? "ORDER BY $sort" : "";
        $count = ($count > $this->apiMaxCount) ? $this->apiMaxCount : $count;
        $counting = "LIMIT $page, $count";
        $sql = "SELECT $columns FROM $database.$table $sorting $counting ";
        
        return $this->execute('select', $database, $table, $sql);
    }
    
    /**
     *
     * @param object $database
     * @param object $table
     * @param object $vo
     * @return
     */
    public function selectOne($database, $table, $keyvalue) {
        $primarykey = $this->getKey($database, $table);
        #$primarykeyValue = $vo[$primarykey];
        $sql = "SELECT * FROM $database.$table WHERE $primarykey = $keyvalue LIMIT 1";
        
        return $this->execute('select', $database, $table, $sql);
    }
    
    /**
     *
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
        $sorting = ($sort != null) ? "ORDER BY $sort" : "";
        $limiting = "LIMIT $page, $count";
        $count = ($count > $this->apiMaxCount) ? $this->apiMaxCount : $count;
        $sql = "SELECT $columns FROM $database.$table WHERE $where LIKE '%$query%' $sorting $limiting";
        
        return $this->execute('search', $database, $table, $sql);
    }
    
    /**
     *
     * @param object $database
     * @param object $table
     * @param object $vo
     * @return
     */
    public function save($database, $table, $vo) {
        $primarykey = $this->getKey($database, $table);
        $primarykeyValue = $vo[$primarykey];
        
        $choice = '';
        if ($primarykeyValue == 0 || $primarykeyValue == '') {
            $choice = $this->create($database, $table, $vo);
        } else {
            $choice = $this->update($database, $table, $vo);
        }
        return $choice;
    }
    
    /**
     *
     * @param object $database
     * @param object $table
     * @param object $vo
     * @return
     */
    public function update($database, $table, $vo) {
        return $this->execute('update', $database, $table, null, $vo);
    }
    
    /**
     *
     * @param object $database
     * @param object $table
     * @param object $vo
     * @return
     */
    public function create($database, $table, $vo) {
        return $this->execute('insert', $database, $table, null, $vo);
    }
    
    /**
     *
     * @param object $database
     * @param object $table
     * @param object $vo
     * @return
     */
    public function remove($database, $table, $vo) {
        return $this->execute('delete', $database, $table, null, $vo);
    }
    
    /**
     *
     * @param object $database
     * @param object $table
     * @return
     */
    public function getKey($database, $table) {
    
        if ($this->svcType == 'mysql') {
        
            $sql = "SHOW INDEX FROM $database.$table";
            $keys = $this->executeAndReturn($sql);
            $primaryKey = '';
            if ($keys) {
                //TODO: Find a alt to tables not having a key
                foreach ($keys as $key) {
                    if ($key['Key_name'] == 'PRIMARY') {
                        $primaryKey = $key['Column_name'];
                    }
                }
                return $primaryKey;
            }
        }
    }
	/**
     * I get the databases in the mysql server
     *
     * @return [array] - Tree ready array of database, tables, and fields
     */
    public function getDatabases() {
        if ($this->svcType == 'mysql') {
        
            $sql = "SHOW DATABASES";
            
            $databases = array();
            
            $statement = $this->dbh->prepare($sql);
            $statement->execute();
            while ($database = $statement->fetch(PDO::FETCH_ASSOC)) {

            
                $tables = array();
                
                foreach ($database as $data) {
                    $tables = $this->getTables($data);
                }
                
                $databases[] = array("label"=>$data, "type"=>"database", "children"=>$tables);
                
            }
            
            return $databases;
        }
    }
    /**
     * I get the tables, fields, and information about the tables from the database.
     *
     * @param [string] $database
     * @return array
     */
    public function getTables($whatDatabase) {
        if ($this->svcType == 'mysql') {
        
            $tables = array();
            $sql = "SHOW TABLES FROM $whatDatabase";
            $statement = $this->dbh->prepare($sql);
            $statement->execute();
            while ($table = $statement->fetch(PDO::FETCH_ASSOC)) {
            
                $fields = array();
                $indexes = array();
                
                foreach ($table as $t_key=>$t_value) {
                    $fields = $this->describeTable($whatDatabase, $t_value);
                    $primaryKey = $this->getKey($whatDatabase, $t_value);
                }
                
                $tables[] = array("label"=>$t_value, "type"=>'table', "key"=>$primaryKey, "children"=>$fields);
                
            }
            sort($tables);
            
            return $tables;
        }
    }
    
    /**
     * I describe a table for the getDatabasesAndTables() method
     *
     * @param [string]  $database the database
     * @param [string]  $table the table
     * @return [array]
     */
    public function describeTable($whatDatabase, $whatTable) {
        $sql = "DESCRIBE $whatDatabase.$whatTable";
        $statement = $this->dbh->prepare($sql);
        $statement->execute();
        
        $tables = array();
        $pattern = '/(\(\d*\))/';
        
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        
            $field = $row['Field']; //Field Name
            $type = $row['Type']; //Field Type
            
            preg_match($pattern, $type, $matches);
            
            #$typeOpts = $matches[0];
            #$type = str_replace( $type, $matches[0] );
            
            //TODO: Fix these values
            $default = $row['Default']; //Field Default Value
            $nullable = ($row['Null'] == 'YES') ? 'true' : 'false';
            $tables[] = array('label'=>$field, 'type'=>'field', 'fieldDefault'=>$default, 'fieldType'=>$type, 'fieldLength'=>'', 'fieldNullable'=>$nullable);
        }
        
        return $tables;
    }

    
    /**
     *
     * @param object $sql
     * @return
     */
    private function executeAndReturn($sql) {
        try {
            $this->writeLog('SQL', $sql);
            $statement = $this->dbh->prepare($sql);
            $statement->execute();
            $result = array();
            $records = array();
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $records[] = $row;
            }
            $result = $records;
            if (count($result) <= 0) {
                $result = false;
            }
        }
        catch(PDOException $e) {
            $result = false;
        }
        return $result;
    }
    
    /**
     *
     * @param object $obj
     * @return
     */
    private function mapObject($obj) {
        require_once "ValueObject.php";
        $array = array();
        
        while ($row = mysqli_fetch_assoc($obj)) {
            $vo = new ValueObject();
            foreach ($row as $key=>$value) {
                $vo->__set($key, $value);
            }
            $array[] = $vo;
        }
        return $array;
    }
    
    /**
     *
     * @param object $value
     * @return
     */
    private function escape($value) {
        $escaped = $value;
        
        if (!is_numeric($value)) {
            $escaped = $this->dbh->quote(trim($value));
        }
        return $escaped;
    }
    
    /**
     *
     * @param object $sql
     * @return
     */
    private function trimSQL($sql) {
        return substr($sql, 0, strlen($sql) - 2);
    }
    
    /**
     *
     * @param object $type
     * @param object $var
     * @return
     */
    public function writeLog($type, $var) {
        $file = "log/service_log.log";
        $fp = fopen($file, "a+");
        $date = date('[D M j Y H:i:s] ', mktime());
        $contents = "\n".$date.'['.$type.'] '.$var;
        fwrite($fp, $contents);
        fclose($fp);
    }
    
    /**
     *
     * @return
     */
    public function readLog() {
        $file = "log/service_log.log";
        $fp = fopen($file, "r");
        $lines = file($file);
        $log = array();
        foreach ($lines as $line_num=>$line) {
            $log[] = array('line'=>$line_num, 'data'=>$line);
        }
        return $log;
    }
    
    /**
     *
     * @param object $prefix
     * @return
     */
    public function generateKey($prefix) {
        $hash = uniqid($prefix);
        
        return $hash;
    }
    
    /**
     *
     * @param object $key
     * @return
     */
    public function checkKey($key) {
        $return = false;
        $sql = "SELECT * FROM ".$this->apiDatabase.".keys WHERE apikey = '$key'";
        $result = $this->executeAndReturn($sql);
        if ($result) {
            $return = true;
        }
        return $return;
    }
    
    /**
     *
     * @param object $prefix
     * @param object $userid
     * @return
     */
    public function updateKey($prefix, $userid) {
        $return = false;
        $key = $this->generateKey($prefix);
        $sql = "UPDATE ".$this->apiDatabase.".keys SET apikey = '$key' WHERE user_id = $userid";
        $result = $this->executeAndReturn($sql);
        if ($result) {
            $return = true;
        }
        return $return;
    }
    
}

/* *************************
 * Testing
 * ************************
 echo '<pre>';
 $svc = new DatabaseAccess('mysql', 'localhost', null, 'root', 'fred');
 $svc->apiDatabase = 'restapi';
 $svc->apiMaxCount = 50;
 $svc->apiUseKey = false;
 $svc->apiResultFormat = 'json';
 $prefix = 'api-';
 $email = 'jonniedollas@gmail.com';
 $newkey = $svc->generateKey($prefix);
 $oldkey = 'api-4ab5f0b7091f5';
 $validKey = $svc->checkKey($oldkey);
 $updateKey = $svc->updateKey($prefix, '2');
 echo '<h3>Insert Record</h3>';
 $newrecord = array('id'=>0, 'name'=>'New Work Schedule', 'color'=>'Green', 'user_id'=>7);
 $create = $svc->create('test', 'calendars', $newrecord);
 print_r($create);
 echo "<br/>";
 echo '<h3>Update Record</h3>';
 $oldrecord = array('id'=>2, 'name'=>'Old Work Schedule', 'color'=>'Blue', 'user_id'=>3);
 $update = $svc->update('test', 'calendars', $oldrecord);
 print_r($update);
 echo "<br/>";
 echo '<h3>Delete Record</h3>';
 $removeKey = ($create['response']['insertid'] - 1);
 $delete = $svc->remove('test', 'calendars', array('id'=>$removeKey));
 print_r($delete);
 echo "<br/>";
 echo '<h3>Get Records</h3>';
 $getrecord = $svc->select('test', 'posts', '*', null, 2);
 print_r($getrecord);
 echo "<br/>";
 echo '<h3>Search Records</h3>';
 $searchrecord = $svc->search('test', 'addresses', '*', 'state', 'ca', 15, 0, 'id asc');
 print_r($searchrecord);
 echo "<br/>";
 echo '<h3>Old API Key</h3>';
 echo $oldkey;
 echo "<br/>";
 echo '<h3>New API Key</h3>';
 echo $newkey;
 echo "<br/>";
 echo '<h3>Update API Key</h3>';
 var_dump($updateKey);
 echo "<br/>";
 echo '<h3>Valid Key Check</h3>';
 var_dump($validKey);
 echo "<br/>";
 echo '</pre>';
 */
?>
