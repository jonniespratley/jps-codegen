<?php
/**
 *
 * 
 *
 * @version CodeGen - 1.9.3
 * @author CodeGen - Jonnie Spratley - https://github.com/jonniespratley/ 
 *
 * @package @NAMESPACE_AS3
 */




$mode = '';
$table = '';
$query = '';
$format = '';
$service = '';
$results = '';

if ( isset ( $_GET ) )
{
	$query = $_GET;
	
	if ( isset ( $_GET [ 'm' ] ) )
	{
		$mode = $_GET [ 'm' ]; //Mode
		unset ( $query [ 'm' ] );
	}
	
	if ( isset ( $_GET [ 't' ] ) )
	{
		$table = $_GET [ 't' ]; //Table
		unset ( $query [ 't' ] );
	}
	
}

switch ( $mode )
{
/******************************************** GET FOR EACH TABLE********************************************/
	
	case 'get':	
		switch ( $table )
		{
				
			
		}//ends table switch
	break;//ends get switch

	
/******************************************** SAVE FOR EACH TABLE********************************************/
	
	case 'save':
		switch ( $table )
		{
			
				
		}//ends table switch
	break;//ends save switch
	
	
/******************************************** REMOVE FOR EACH TABLE********************************************/
	
	case 'remove':
		switch ( $table )
		{
			
			
		}//ends table switch
	break;//ends remove switch

}//ends mode switch

?>