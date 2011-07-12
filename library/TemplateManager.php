<?php
/**
 * @name  	PHPGen.php
 * @author  Jonnie Spratley
 * @version 1.9
 * 
 */

class TemplateManager
{
	public static $COMPONENT_NAMESPACE_PATTERN = '(@COMPONENT_NAMESPACE)';
	public static $NAMESPACE_URL_PATTERN = '(@NAMESPACE_URL)';
	public static $INIT_VALIDATORS_PATTERN = '(@INITVALIDATORS)';
	public static $VALIDATORS_PATTERN = '(@VALIDATORS)';
	public static $EVENT_CONST = '(@EVENTCONST)';
	public static $NAMESPACE_PATTERN = '(@NAMESPACE_AS3)';
	public static $TABLE_PATTERN = '(@TABLE)';
	public static $TABLE_REGULAR_PATTERN = '(@TABLE_REGULAR)';
	public static $TABLE_UFIRST_PATTERN = '(@TABLE_UFIRST)';
	public static $TABLE_UPPERCASE_PATTERN = '(@TABLE_UC)';
	public static $TABLE_LOWERCASE_PATTERN = '(@TABLE_LC)';
	public static $FIELD_VARS_PATTERN = '(@FIELDVARS)';
	public static $FIELDS_PATTERN = '(@FIELDS)';
	public static $ENDPOINT_PATTERN = '(@ENDPOINT)';
	public static $GATEWAY_PATTERN = '(@GATEWAY)';
	public static $CLEAR_FIELDS_PATTERN = '(@CLEARFIELDS)';
	public static $SET_FIELDS_PATTERN = '(@SETFIELDS)';
	public static $FORM_FIELDS_PATTERN = '(@FORMFIELDS)';
	public static $LIST_FIELDS_PATTERN = '(@LISTFIELDS)';
	public static $FIELDS_QUERY_PATTERN = '(@FIELD_TO_QUERY)';
	public static $HOST_PATTERN = '(@HOST)';
	public static $USER_PATTERN = '(@USER)';
	public static $PASS_PATTERN = '(@PASS)';
	public static $DATABASE_PATTERN = '(@DATABASE)';
	public static $APPLICATION_PATTERN = '(@APPLICATION)';
	public static $EVENT_COMMAND_PATTERN = '(@EVENTSCOMMANDS)';
	public static $CG_AUTHOR_PATTERN = '(@CG_AUTHOR)';
	public static $CG_VERSION_PATTERN = '(@CG_VERSION)';
	public static $FILE_INCLUDES_PATTERN = '(@INCLUDES)';
	public static $REST_TABLE_GET_PATTERN = '(@REST_TABLE_GET)';
	public static $REST_TABLE_SAVE_PATTERN = '(@REST_TABLE_SAVE)';
	public static $REST_TABLE_REMOVE_PATTERN = '(@REST_TABLE_REMOVE)';
	public static $SERVICE_GET_CALL_PATTERN = '(@SERVICE_GET_CALL)';
	public static $SERVICE_SAVE_CALL_PATTERN = '(@SERVICE_SAVE_CALL)';
	public static $SERVICE_REMOVE_CALL_PATTERN = '(@SERVICE_REMOVE_CALL)';
	public static $SERVICE_GET_RESULT_PATTERN = '(@SERVICE_GET_RESULT)';
	public static $SERVICE_SAVE_RESULT_PATTERN = '(@SERVICE_SAVE_RESULT)';
	public static $SERVICE_REMOVE_RESULT_PATTERN = '(@SERVICE_REMOVE_RESULT)';
	public static $SERVICE_COMMENTS_PATTERN = '(@SERVICE_COMMENTS)';
	public static $COPYWRITE_PATTERN = '(@COPYWRITE)';
	public static $TABLE_SELECTED_PATTERN = '(@TABLE_SELECTED)';
	public static $TABLE_COLLECTION_PATTERN = '(@TABLE_COLLECTION)';
	public static $TABLE_DATA_PATTERN = '(@FIELDS_QUERY)';
	public static $TABLE_PRIMARY_KEY_PATTERN = '(@PRIMARY_KEY)';
	
	public static $HTML_FIELD_LIST_PATTERN = '(@HTML_FIELD_LIST)';
	public static $HTML_FIELD_HEADER_PATTERN = '(@HTML_FIELD_HEADER)';
	public static $HTML_TABLE_LIST_PATTERN = '(@HTML_TABLE_LIST)';
	public static $HTML_CLEAR_VARS_PATTERN = '(@HTML_CLEAR_VARS)';
	public static $HTML_SET_VARS_PATTERN = '(@HTML_SET_VARS)';
	public static $HTML_FORM_FIELDS_PATTERN = '(@HTML_FORM_FIELDS)';
	
	public static $CAIRNGORM_TEMPLATE_LOCATION = 'Templates/flex/cairngorm/';
	public static $FLEX_TEMPLATE_LOCATION = 'Templates/flex/';
	public static $PHP_TEMPLATE_LOCATION = 'Templates/php/';
	public static $ECLIPSE_TEMPLATE_LOCATION = 'Templates/eclipse/';
	public static $HTML_TEMPLATE_LOCATION = 'Templates/html/';
	public static $SERVER_OUTPUT = 'output/server/';
	public static $CLIENT_OUTPUT = 'output/client/';
	public static $CONFIG_OUTPUT = 'output/';
	
	public static $OUTPUT = 'output/';
	public static $PATH = '/';
	
	public static $EXTERNAL_SERVER_OUTPUT = 'output/server/';
	public static $EXTERNAL_CLIENT_OUTPUT = 'output/client/';
	public static $EXTERNAL_CONFIG_OUTPUT = 'output/';
	
	public static $FRAMEWORK_AS3 = 'AS3';
	public static $FRAMEWORK_CAIRNGORM = 'Cairngorm';
	
	//../output/APP/server
	//../output/APP/client
	
	static public function getServerOutputPath( $appName )
	{
		return self::$PATH.self::$OUTPUT.$appName.'/';
	}
}

?>