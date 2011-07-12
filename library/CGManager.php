<?php
/**
 * @name  	CGManager.php
 * @author  Jonnie Spratley
 * @version 1.9
 * 
 */

class CGManager
{
	public static $CG_VERSION = '1.9.3';
	public static $CG_UPDATE_CHECK = '';
	public static $CG_UPDATED_DATE = '7-11-2011';
	public static $CG_GIT_URL = 'https://github.com/jonniespratley/jps-codegen';
	public static $CG_AUTHOR = 'Jonnie Spratley - https://github.com/jonniespratley/';
	public static $CG_LOG = array ();
	
	public static $PHP_VO_GEN;
	public static $PHP_DAO_GEN;
	public static $PHP_REST_GEN;
	public static $PHP_CONN_GEN;
	
	public static $HTML_FORM_GEN;
	public static $HTML_LIST_GEN;
	public static $HTML_MAIN_GEN;
	
	public static $CAIRNGORM_GET_EVENT_GEN;
	public static $CAIRNGORM_SAVE_EVENT_GEN;
	public static $CAIRNGORM_REMOVE_EVENT_GEN;
	public static $CAIRNGORM_GET_COMMAND_GEN;
	public static $CAIRNGORM_SAVE_COMMAND_GEN;
	public static $CAIRNGORM_REMOVE_COMMAND_GEN;
	public static $CAIRNGORM_SERVICE_DELEGATE_GEN;
	public static $CAIRNGORM_VO_GEN;
	public static $CAIRNGORM_MODEL_GEN;
	public static $CAIRNGORM_CONTROLLER_GEN;
	public static $CAIRNGORM_SERVICE_LOCATOR_GEN;
	
	public static $FLEX_APP_GEN;
	public static $FLEX_REST_SERVICE_GEN;
	public static $FLEX_LIST_GEN;
	public static $FLEX_FORM_GEN;
	public static $FLEX_MAIN_GEN;
	public static $FLEX_VO_GEN;
	
	static public function GET_CG_LOG()
	{
		$phpArray = array ( 
			self::$PHP_VO_GEN, self::$PHP_DAO_GEN, self::$PHP_REST_GEN, self::$PHP_CONN_GEN 
		);
		$htmlArray = array ( 
			self::$HTML_FORM_GEN, self::$HTML_LIST_GEN, self::$HTML_MAIN_GEN 
		);
		$cairngormArray = array ( 
			
				self::$CAIRNGORM_GET_EVENT_GEN, 
				self::$CAIRNGORM_GET_COMMAND_GEN, 
				self::$CAIRNGORM_REMOVE_COMMAND_GEN, 
				self::$CAIRNGORM_REMOVE_EVENT_GEN, 
				self::$CAIRNGORM_SAVE_COMMAND_GEN, 
				self::$CAIRNGORM_SAVE_EVENT_GEN, 
				self::$CAIRNGORM_SERVICE_DELEGATE_GEN, 
				self::$CAIRNGORM_SERVICE_LOCATOR_GEN, 
				self::$CAIRNGORM_VO_GEN, 
				self::$CAIRNGORM_CONTROLLER_GEN, 
				self::$CAIRNGORM_MODEL_GEN 
		);
		$flexArray = array ( 
			self::$FLEX_APP_GEN, self::$FLEX_FORM_GEN, self::$FLEX_LIST_GEN, self::$FLEX_MAIN_GEN, self::$FLEX_VO_GEN, self::$FLEX_REST_SERVICE_GEN 
		);
		/*
		$log = array ( 
		//Server Side
				'PHP_VO_GEN' => self::$PHP_VO_GEN, 
				'PHP_DAO_GEN' => self::$PHP_DAO_GEN, 
				'PHP_REST_GEN' => self::$PHP_REST_GEN, 
				'PHP_CONN_GEN' => self::$PHP_CONN_GEN, 
		//Cairngorm Framework (if)
				'CAIRNGORM_GET_EVENT_GEN' => self::$CAIRNGORM_GET_EVENT_GEN, 
				'CAIRNGORM_GET_COMMAND_GEN' => self::$CAIRNGORM_GET_COMMAND_GEN, 
				'CAIRNGORM_REMOVE_COMMAND_GEN' => self::$CAIRNGORM_REMOVE_COMMAND_GEN, 
				'CAIRNGORM_REMOVE_EVENT_GEN' => self::$CAIRNGORM_REMOVE_EVENT_GEN, 
				'CAIRNGORM_SAVE_COMMAND_GEN' => self::$CAIRNGORM_SAVE_COMMAND_GEN, 
				'CAIRNGORM_SAVE_EVENT_GEN' => self::$CAIRNGORM_SAVE_EVENT_GEN, 
				'CAIRNGORM_SERVICE_DELEGATE_GEN' => self::$CAIRNGORM_SERVICE_DELEGATE_GEN, 
				'CAIRNGORM_SERVICE_LOCATOR_GEN' => self::$CAIRNGORM_SERVICE_LOCATOR_GEN, 
				'CAIRNGORM_VO_GEN' => self::$CAIRNGORM_VO_GEN, 
				'CAIRNGORM_CONTROLLER_GEN' => self::$CAIRNGORM_CONTROLLER_GEN, 
				'CAIRNGORM_MODEL_GEN' => self::$CAIRNGORM_MODEL_GEN, 
		//Client Side Flex
				'FLEX_APP_GEN' => self::$FLEX_APP_GEN, 
				'FLEX_FORM_GEN' => self::$FLEX_FORM_GEN, 
				'FLEX_LIST_GEN' => self::$FLEX_LIST_GEN, 
				'FLEX_MAIN_GEN' => self::$FLEX_MAIN_GEN, 
				'FLEX_VO_GEN' => self::$FLEX_VO_GEN,
				'FLEX_REST_SERVICE_GEN' => self::$FLEX_REST_SERVICE_GEN 
		);
		*/
		
		$cgArray = array ( $htmlArray, $flexArray, $phpArray, $cairngormArray );
		
		return $cgArray;
	}

}

?>