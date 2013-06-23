<?php
/**
 * @name  	Utilities.php
 * @author  Jonnie Spratley
 * @version 1.9
 * 
 */

class Utilities
{
	/**
	 * I camel case a string
	 *
	 * @param [string] $in  -    the input string
	 * @return string
	 */
	static public function toCamelCase( $in )
	{
		$ret = str_replace ( ' ', '_', ucwords ( preg_replace ( '/[^A-Z^a-z^0-9]+/', ' ', $in ) ) );
		if ( $ret == "Default" )
		{
			$ret = "DefaultOption";
		}
		return ( $ret );
		
	//return $in;
	}
	
	
	static public function toCamelCaseMember( $in )
	{
		$ret = ( strtolower ( substr ( $in, 0, 1 ) ) . substr ( $this->toCamelCase ( $in ), 1, strlen ( $in ) - 1 ) );
		if ( $ret == "default" )
		{
			$ret = "defaultOption";
		}
		return ( $ret );
		
	//return $in;
	}
	
	/**
	 * 
	 * @param object $array
	 * @return 
	 */
	static public function printNestedArray( $array )
	{
		echo '<ul>';
		
		foreach ( $array as $key => $value )
		{
			echo '<li>' . htmlspecialchars ( "$key: " );
			
			if ( is_array ( $value ) )
			{
				$this->printNestedArray ( $value );
			}
			else
			{
				echo htmlspecialchars ( "$value " ) . '</li>';
			}
		}
		echo '</ul>';
	}
	
	/**
	 * 
	 * @param object $type
	 * @param object $var
	 * @return 
	 */
	static public function log( $type, $var )
	{
		//write to log file
		$file = dirname(__FILE__).DIRECTORY_SEPARATOR."codegen.log";
		
		//$date = date('n/j/y  g:i a  ');
		//Date [Sat Jul 11 02:04:15 2009] [error] [client 127.0.0.1]
		$date = date('[D M j Y H:i:s] ', mktime());
		
		//append to end of content in log fil
		$fp = fopen ( $file, "a+" );

		$contents = "\n".$date.'['.$type.'] '. $var;
	
		fwrite($fp, $contents);
		
		fclose ( $fp );
	}
	 /**
     *
     * @return
     * @param object $type
     * @param object $var
     */
 
	static public function readLog()
	{
		$file = "log.txt";
		
		$print = file_get_contents ( $file );
		echo '<pre>';
		print_r ( $print );
		echo '</pre>';
	}
	/**
	 * I dump out a varable
	 * @param object $title - name of the variable
	 * @param object $var - the variable
	 * @return 
	 */
	static public function dump( $title, $var )
	{
		echo "<h3>$title</h3>";
		echo '<pre>';
		print_r ( $var );
		echo '<pre>';
	}
	/**
	 *  I trim the last comma in generated sql.
	 * @param object $sql - the sql
	 * @return 
	 */
	static public function trimSQL( $sql )
	{
		return substr ( $sql, 0, strlen ( $sql ) - 2 );
	}
	/**
	 * 
	 * @param object $str
	 * @param object $len
	 * @return 
	 */
	static public function trim( $str, $len )
	{
		return substr ( $str, 0, strlen ( $str ) - $len );
	}
	/**
	 * 
	 * @param object $namespace
	 * @return 
	 */
	static public function namespaceFolders( $namespace )
	{
		$folderNamespace = str_replace ( '.', '/', $namespace );
		
		return $folderNamespace;
	}
	/**
	 * 
	 * @param object $namespace
	 * @return 
	 */
	static public function namespaceApplication( $namespace )
	{
		$folderNamespace = str_replace ( '/', '.', $namespace );
		
		return $folderNamespace;
	}
	/**
	 * 
	 * @param object $namespace
	 * @return 
	 */
	static public function makeServerNamespaceFolders( $namespace )
	{
		$newNamespace = str_replace ( '.', '/', $namespace );
		
		if ( ! is_dir ( 'output/' . $newNamespace ) )
		{
			//true makes all children
			mkdir ( $newNamespace, 0777, true );
		}
		//we need to change all permissions on unix
	#	chmod ( $newNamespace, 0777 );
		
		return $newNamespace;
	}
	/**
	 * 
	 * @param object $namespace
	 * @return 
	 */
	static public function makeClientNamespaceFolders( $namespace )
	{
		$newNamespace = str_replace ( '.', '/', $namespace );
	
		if ( ! is_dir ( 'output/' . $newNamespace ) )
		{	
			mkdir ( $newNamespace, 0755, true );
		}
		//chmod ( $newNamespace, 0777 );
		
		return $newNamespace;
	}
	
	/**
	 * I replace the numbers from the table schema to nothing.
	 *
	 * @param [string] $search type you want replaced
	 * @return [string] the string with the (num) taken off
	 */
	static public function replaceNumbers( $search )
	{
		$replacement = '';
		$pattern = '/[(\d*)]/';
		$new = preg_replace ( $pattern, $replacement, $search );
		return $new;
	}
	/**
	 * 
	 * @param object $outputLocation
	 * @param object $folderNamespace
	 * @param object $folder
	 * @return 
	 */
	static public function checkOrMakeFolders( $outputLocation, $folderNamespace, $folder )
	{
		$path = $outputLocation . $folderNamespace . $folder . '/';
		if ( ! is_dir ( $outputLocation . $folderNamespace . '/' . $folder ) )
		{
			mkdir ( $outputLocation . $folderNamespace . '/' . $folder, 0777, true );
		}
		//chmod ( $outputLocation . $folderNamespace . '/' . $folder, 0777 );
		
		return $path;
	}
	
	/**
	 * 
	 * @param object $str
	 * @return 
	 */
	static public function sqlBackquotes( $str )
	{
		return "`$str`";
	}
}

?>