<?php
/**
 * @name  	PHPGen.php
 * @author  Jonnie Spratley
 * @version 1.7
 * @description 
 * 
 * This class holds all of the static methods 
 * for creating all the neccessary files for the PHP on the server side.
 * 
 * @method generateValueObject -
 * @method generateBaseService -
 * @method generateRESTService -
 * 
 */

//require_once all of the table services and value objects


//Set up the variables for the calls
$mode = '';
$table = '';
$queryVO = '';
$format = '';

//The Mode
if ( isset ( $_REQUEST [ 'm' ] ) )
{
	$mode = $_REQUEST [ 'm' ]; //Mode
}

//The Table
if ( isset ( $_REQUEST [ 't' ] ) )
{
	$table = $_REQUEST [ 't' ]; //Table
}

//The Query ( arguments )
if ( isset ( $_REQUEST [ 'q' ] ) )
{
	$queryVO = $_REQUEST [ 'q' ]; //Query
}

/* ********************************************
 * Switch based on the mode
 * ********************************************/
switch ( $mode )
{
	case 'get':
	
	/* ********************************************
	 * Switch based on the table
	 * ********************************************/
	switch ( $table )
		{
			case 'categories':
				$service = new TextpatternService ( );
				$categories = $service->getAllTextpattern ();
				
				print_r ( json_encode ( $categories ) );
				break;
		
		} //ends table switch
		

		break; //ends getAll switch
	

	case 'save':
	
	/* ********************************************
	 * Switch based on the table
	 * ********************************************/
	switch ( $table )
		{
			case 'categories':
				$service = new TextpatternService ( );
				$categories = $service->saveTextpattern ( $queryVO );
				
				print json_encode ( $categories );
				break;
		
		} //ends table switch
		

		break; //ends save switch
	

	case 'remove':
	
	/* ********************************************
	 * Switch based on the table
	 * ********************************************/
	switch ( $table )
		{
			case 'categories':
				$service = new TextpatternService ( );
				$vo = new TextpatternServiceVO ( $queryVO );
				
				foreach ( $vo as $var => $value )
				{
					echo "\n" . $var . ' is ' . $value;
				}
				//$categories = $service->removeCategories( $vo );
				break;
		
		} //ends table switch
		

		break; //ends remove switch


}

?>