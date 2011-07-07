<?php
/**
My Test Application
*/

/**
 * @version CodeGen - 1.8
 * @author CodeGen - Jonnie Spratley (http://jonniespratley.com/code) 
 *
 * @package @NAMESPACE_AS3
 */



			require_once ( "PostsService.php" );
			require_once ( "vo/PostsVO.php" );
			
			require_once ( "UsersService.php" );
			require_once ( "vo/UsersVO.php" );
			

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
				
				case "Users":
					$service = new UsersService();
					$results = $service->getAllUsers();
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
				
				case "Users":
					$service = new UsersService();
					$results = $service->saveUsers( $query );
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
				
				case "Users":
					$service = new UsersService();
					$results = $service->removeUsers( $query );
					print_r( json_encode( $results ) );
				break;
				
			
		}//ends table switch
	break;//ends remove switch

}//ends mode switch

?>