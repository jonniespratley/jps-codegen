<?php
require_once 'Utilities.php';

class SQLGen
{
	
	static public function generateSQL(){}
	
	static public function writeHeader( $table )
	{
		/**
		 * # Dump of table users
		 *	# ------------------------------------------------------------
		 */
		$header = "# Dump of table $table\n";
		$header .= "# ---------------------------------------------------\n";
		
		return $header;
	}
	
	static public function writeCreateTable( $table, $fields )
	{
	
		/**
		 * DROP TABLE IF EXISTS `users`;
		 *	CREATE TABLE `users` (
		 *	`id` int(11) NOT NULL auto_increment,
		 *	`email` varchar(255) default 'none',
		 *	`name` varchar(255) default 'Joe',
		 *	PRIMARY KEY  (`id`)
		 *	) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
		 * 
		 */
		$tableSQL = "DROP TABLE IF EXISTS ". Utilities::sqlBackquotes( $table ).";\n";
		$tableSQL .= "CREATE TABLE ". Utilities::sqlBackquotes( $table )." (\n";
		
		//Write Fields and attributes
		foreach( $fields as $field )
		{
			$tableSQL .= Utilities::sqlBackquotes( $field['name'] ). " ". $field['type']. " ". $field['required'].",\n";
		}
		
		$tableSQL .= "PRIMARY KEY ( ". Utilities::sqlBackquotes( $field['key'] )." )\n";
		$tableSQL .= ") ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;\n\n";
		  
		return $tableSQL;
	}
	
	static public function writeInsertData( $table, $fields, $data )
	{
	
		/**
		 * INSERT INTO `users` (`id`,`email`,`name`)
		 *	VALUES
		 *	(1,'ruby@gmail.com','Ruby'),
		 *	(5,'jonniedollas@gmail.com','Jonnie');
 		 */
	
	}
	
	static public function lockTable( $table )
	{
	
		/**
		 * LOCK TABLES `users` WRITE;
		 */
		$lock = "LOCK TABLES ".Utilities::sqlBackquotes( $table )." WRITE\n";
		
		return $lock;
	}
	
	static public function unlockTable()
	{
		/**
		 * UNLOCK TABLES;
		 */
		$unlock = "UNLOCK TABLES\n\n";
		
		return $unlock;
	}
}


/*
echo '<pre>';

echo SQLGen::writeHeader ( 'tags' );
echo SQLGen::lockTable ( 'tags' );
echo SQLGen::writeCreateTable('tags', array( array( 'name' => 'id', 'type' => 'varchar', 'required', 'NULL', 'key' => 'id' ) ) );
echo '</pre>';
*/
?>