<?php
/**
 *
 * Your Copywrite information
 *
 * @version CodeGen - 1.9.1
 * @author CodeGen - Jonnie Spratley - http://code.google.com/p/flex-codegen/ 
 *
 * @package @NAMESPACE_AS3
 */



			require_once ( "ContactsService.php" );
			require_once ( "vo/ContactsVO.php" );
			
			require_once ( "ProjectsService.php" );
			require_once ( "vo/ProjectsVO.php" );
			

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
			
				case "Contacts":
					$service = new ContactsService();
					$results = $service->getAllContacts();
					print_r( json_encode( $results ) );
				break;
				
				case "Projects":
					$service = new ProjectsService();
					$results = $service->getAllProjects();
					print_r( json_encode( $results ) );
				break;
					
			
		}//ends table switch
	break;//ends get switch

	
/******************************************** SAVE FOR EACH TABLE********************************************/
	
	case 'save':
		switch ( $table )
		{
			
				case "Contacts":
					$service = new ContactsService();
					$results = $service->saveContacts( $query );
					print_r( json_encode( $results ) );
				break;
				
				case "Projects":
					$service = new ProjectsService();
					$results = $service->saveProjects( $query );
					print_r( json_encode( $results ) );
				break;
				
				
		}//ends table switch
	break;//ends save switch
	
	
/******************************************** REMOVE FOR EACH TABLE********************************************/
	
	case 'remove':
		switch ( $table )
		{
			
				case "Contacts":
					$service = new ContactsService();
					$results = $service->removeContacts( $query );
					print_r( json_encode( $results ) );
				break;
				
				case "Projects":
					$service = new ProjectsService();
					$results = $service->removeProjects( $query );
					print_r( json_encode( $results ) );
				break;
				
			
		}//ends table switch
	break;//ends remove switch

}//ends mode switch

?>