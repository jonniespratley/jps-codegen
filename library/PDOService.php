<h1></h1><?php

/**
* PDO Service class
*/
class PDOService
{
    
    private $dbconn;
    private $dsn;
    public function __construct($type, $options = array() )
    {
        $dsn = null;
        switch ($type) 
        {
            case 'mysql':
                $d = 'mysql:host='.$options['host'].';';
                $this->dsn = $d;
                try {
            	    $dbh = new PDO( $dsn, $options['user'], $options['password']);
                    $this->dbconn = $dbh;
                } 
                catch (PDOException $e) {
            	    echo 'Connection failed: ' . $e->getMessage();
                }
            break;
        
            case 'sqlite':
                $d = 'sqlite:"'.$options['path'].'"';
            	$this->dsn = $d;
                try {
            	    $dbh = new PDO( $dsn );
            	    $this->dbconn = $dbh;
                } 
                catch ( PDOException $e ) {
            	    echo 'Connection failed: ' . $e->getMessage();
                }
            break;
            
            default:
                echo 'Must Specify a type.';
                die();
            break;
       }
	    
    }
	
	public function execute( $sql )
	{
		$return = array();
		
		try {
			$db = new PDO($this->dsn);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			

			foreach ( $db->query($sql) as $row)
			{
				$return[] = $row;
			}
	
		} catch ( PDOException $e ){
			echo '<br/>PDO Exception Caught.';
			echo '<br/>Error with the database:';
			echo '<br/>SQL Query: ', $sql;
			echo '<br/>Error: ' . $e->getMessage();
		}
		return $return;
	}
}
 

?>