<?php

class XMLLog
{
	
	public static $fileName;
	public static $doc;
	public static $log;
	public static $date;
	
	static public function start( $fileName )
	{
		XMLLog::$fileName = $fileName;
		//$date = date ( 'H:i:s' );
		

		//create new dom doc
		XMLLog::$doc = new DOMDocument ( );
		
		//format the output
		XMLLog::$doc->formatOutput = true;
		
		//create the root
		XMLLog::$log = XMLLog::$doc->createElement ( "log" );
		
		//add the root to the dom
		XMLLog::$doc->appendChild ( XMLLog::$log );
		
	//add a attribute to the root 
	//XMLLog::$log->setAttribute ( 'date', $date );
	}
	
	static public function add( $message )
	{
		$mess_obj = XMLLog::$doc->createElement ( "message" );
		$text = XMLLog::$doc->createTextNode ( $message );
		$mess_obj->appendChild ( $text );
		XMLLog::$log->appendChild ( $mess_obj );
		
	//add a attribute to the root 
	//	$mess_obj->setAttribute ( 'date', $this->date );
	}
	
	static public function close()
	{
		XMLLog::$doc->save ( XMLLog::$fileName . '.xml' );
	}
	
	static public function instance()
	{
		static $instance = null;
		if ( ! isset ( $instance ) )
		{
			$instance = new XMLLog ( );
		}
		return $instance;
	}
}

?>