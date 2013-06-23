<?php
/**
 *
 * Test app by jonnie spratley
 *
 * @version CodeGen - 1.9.1
 * @author CodeGen - Jonnie Spratley - http://code.google.com/p/flex-codegen/ 
 *
 * @package @NAMESPACE_AS3
 */



			require_once ( "PostsService.php" );
			require_once ( "vo/PostsVO.php" );
			
			require_once ( "UploadsService.php" );
			require_once ( "vo/UploadsVO.php" );
			

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
			
				case "Posts":
					$service = new PostsService();
					$results = $service->getAllPosts();
					print_r( json_encode( $results ) );
				break;
				
				case "Uploads":
					$service = new UploadsService();
					$results = $service->getAllUploads();
					print_r( json_encode( $results ) );
				break;
					
			
		}//ends table switch
	break;//ends get switch

	
/******************************************** SAVE FOR EACH TABLE********************************************/
	
	case 'save':
		switch ( $table )
		{
			
				case "Posts":
					$service = new PostsService();
					$results = $service->savePosts( $query );
					print_r( json_encode( $results ) );
				break;
				
				case "Uploads":
					$service = new UploadsService();
					$results = $service->saveUploads( $query );
					print_r( json_encode( $results ) );
				break;
				
				
		}//ends table switch
	break;//ends save switch
	
	
/******************************************** REMOVE FOR EACH TABLE********************************************/
	
	case 'remove':
		switch ( $table )
		{
			
				case "Posts":
					$service = new PostsService();
					$results = $service->removePosts( $query );
					print_r( json_encode( $results ) );
				break;
				
				case "Uploads":
					$service = new UploadsService();
					$results = $service->removeUploads( $query );
					print_r( json_encode( $results ) );
				break;
				
			
		}//ends table switch
	break;//ends remove switch

}//ends mode switch

?>