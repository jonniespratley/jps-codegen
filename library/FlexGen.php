<?php
/**
 * @name  	FlexGen.php
 * @author  Jonnie Spratley
 * @version 1.9
 * 
 * @method generateApplication - Creates ApplicationMain.mxml
 * @method generateMain - Creates DatabaseMain.mxml
 * @method generateList - Creates TableList.mxml
 * @method generateForm - Creates TableForm.mxml
 * @method generateRESTService - Creates DatabaseService.as
 * @method generateAMFPHPService - Creates DatabaseSerivce.as
 * @method generateValueObject - Creates TableVO.as
 *
 */

require_once 'TemplateManager.php';
require_once 'FileSystemService.php';
require_once 'ConfigManager.php';
require_once 'SchemaManager.php';
require_once 'Utilities.php';

class FlexGen
{
	
	/**
	 * I generate the main application file that will hold the DatabaseMain.mxml component, which is holding all of the TableMain.mxml components.
	 *
	 * @param [string] $output - The location where the file is to be placed once generated
	 * @param [string] $namespace - Applications namespace. example( com.domain.project )
	 * @param [string] $database - The applications database name.
	 * @param [string] $table - The applications databases table.
	 * @param [array] $fields - The applications table fields.
	 * @return [array] - An array containing the filename and the real file path.
	 */
	public static function generateApplication( $output, $namespace, $database, $table, $fields = null )
	{
		//make the folder namespace com/jonnie/test/
		$folderNamespace = Utilities::namespaceFolders ( $namespace );
		
		//make the actual namespace com.jonnie.test
		$namespace = Utilities::namespaceApplication ( $namespace );
		
		$tableComponents = '';
		$tableNamespaces = '';
		
		//Build the form inputs
		foreach ( $table as $tbl )
		{
			$tableName = ucfirst ( $tbl [ 'table' ] );
			
			$tableComponents .= '
			<' . $tableName . ':' . $tableName . 'Main  
				label="' . $tableName . '"/>';
			
			$tableNamespaces .= '
			xmlns:' . $tableName . '="' . $namespace . '.view.' . $tableName . '.*" ';
		}
		
		/**
		 * Check to see weither to create the cairngorm template list or the rest
		 * @todo: Added 05/04/09 
		 */
		$framework = ConfigManager::getConfigSetting ( $output, $database, 'framework' );
		
		if ( $framework == TemplateManager::$FRAMEWORK_CAIRNGORM )
		{
			$flexForm = FileSystemService::readFile ( TemplateManager::$FLEX_TEMPLATE_LOCATION . 'FlexApplicationCAIRNGORM.txt' );
		}
		else
		{
			$flexForm = FileSystemService::readFile ( TemplateManager::$FLEX_TEMPLATE_LOCATION . 'FlexApplicationREST.txt' );
		}
		
		$template = preg_replace ( TemplateManager::$COMPONENT_NAMESPACE_PATTERN, $tableNamespaces, $flexForm );
		$template = preg_replace ( TemplateManager::$TABLE_PATTERN, $tableComponents, $template );
		$template = preg_replace ( TemplateManager::$NAMESPACE_PATTERN, $namespace, $template );
		$template = preg_replace ( TemplateManager::$NAMESPACE_URL_PATTERN, $folderNamespace, $template );
		
		$application = ConfigManager::getConfigSetting ( $output, $database, 'application' );
		$template = preg_replace ( TemplateManager::$APPLICATION_PATTERN, $application, $template );
		
		$copywrite = ConfigManager::getConfigSetting ( $output, $database, 'copywrite' );
		$template = preg_replace ( TemplateManager::$COPYWRITE_PATTERN, $copywrite, $template );
		
		Utilities::checkOrMakeFolders ( TemplateManager::$CLIENT_OUTPUT, $folderNamespace, 'view' );
		$file = FileSystemService::writeFile ( TemplateManager::$CLIENT_OUTPUT . $folderNamespace . '/view/' . ucfirst ( $application ) . 'Main.mxml', $template );
		
	
		
		return array ( 
			'label' => ucfirst ( $application ) . 'Main.mxml', 'data' => $file 
		);
	}
	
	/**
	 * I create a TableMain.mxml file that holds both the list and form for that table.
	 *
	 * @param [string] $output - The location where the file is to be placed once generated
	 * @param [string] $namespace - Applications namespace. example( com.domain.project )
	 * @param [string] $database - The applications database name.
	 * @param [string] $table - The applications databases table.
	 * @param [array] $fields - The applications table fields.
	 * @return [array] - An array containing the filename and the real file path.
	 */
	public static function generateTableMain( $output, $namespace, $database, $table, $fields = null )
	{
		$tableUFirst = ucfirst ( $table );
		
		//make the folder namespace com/jonnie/test/
		$folderNamespace = Utilities::namespaceFolders ( $namespace );
		
		//make the actual namespace com.jonnie.test
		$namespace = Utilities::namespaceApplication ( $namespace );
		
		/* Read the template, and prepare to search and replace the template */
		/**
		 * Check to see if it should create the cairngorm template list or the rest
		 * @todo: Added 05/04/09 
		 */
		$framework = ConfigManager::getConfigSetting ( $output, $database, 'framework' );
		
		if ( $framework == TemplateManager::$FRAMEWORK_CAIRNGORM )
		{
			$flexMain = FileSystemService::readFile ( TemplateManager::$FLEX_TEMPLATE_LOCATION . 'FlexTableMainCAIRNGORM.txt' );
		}
		else
		{
			$flexMain = FileSystemService::readFile ( TemplateManager::$FLEX_TEMPLATE_LOCATION . 'FlexTableMainREST.txt' );
		
		}
		
		$copywrite = ConfigManager::getConfigSetting ( $output, $database, 'copywrite' );
		$template = preg_replace ( TemplateManager::$COPYWRITE_PATTERN, $copywrite, $flexMain );
		/* Set and replace the table name*/
		$template = preg_replace ( TemplateManager::$TABLE_UFIRST_PATTERN, $tableUFirst, $template );
		
		$template = preg_replace ( TemplateManager::$COPYWRITE_PATTERN, $copywrite, $template );
		
		/* Set and replace the namespaces */
		$template = preg_replace ( TemplateManager::$NAMESPACE_PATTERN, $namespace, $template );
		
		Utilities::checkOrMakeFolders ( TemplateManager::$CLIENT_OUTPUT, $folderNamespace, 'view/' . $tableUFirst . '/' );
		$file = FileSystemService::writeFile ( TemplateManager::$CLIENT_OUTPUT . $folderNamespace . '/view/' . $tableUFirst . '/' . $tableUFirst . 'Main.mxml', $template );
		
		return array ( 
			'label' => $tableUFirst . 'Main.mxml', 'data' => $file 
		);
	}
	
	/**
	 * Here is the MXML I am looping over to create the proper columns for the list.
	 * 
	 * <code>
	 * <mx:DataGridColumn headerText="FIELD_NAME" dataField="FIELD_NAME"/>
	 * </code>
	 * 
	 * @param [string] $output - The location where the file is to be placed once generated
	 * @param [string] $namespace - Applications namespace. example( com.domain.project )
	 * @param [string] $database - The applications database name.
	 * @param [string] $table - The applications databases table.
	 * @param [array] $fields - The applications table fields.
	 * @return [array] - An array containing the filename and the real file path.
	 */
	public static function generateList( $output, $namespace, $database, $table, $fields = null )
	{
		$tableUFirst = ucfirst ( $table );
		$tableUC = strtoupper ( $table );
		
		//make the folder namespace com/jonnie/test/
		$folderNamespace = Utilities::namespaceFolders ( $namespace );
		
		//make the actual namespace com.jonnie.test
		$namespace = Utilities::namespaceApplication ( $namespace );
		
		$listFields = '';
		
		/*
		 * Build the datagrid list - <mx:DataGridColumn headerText="Category_id" dataField="category_id"/>
		 */
		foreach ( $fields as $field )
		{
			//prop the datagrid for insertion
			$listFields .= '
			<mx:DataGridColumn headerText="' . ucfirst ( $field [ 'name' ] ) . '" dataField="' . $field [ 'name' ] . '"/>';
		}
		
		/**
		 * Check to see weither to create the cairngorm template list or the rest
		 * @todo: Added 05/04/09 
		 */
		
		$copywrite = ConfigManager::getConfigSetting ( $output, $database, 'copywrite' );
		$framework = ConfigManager::getConfigSetting ( $output, $database, 'framework' );
		$endpoint = ConfigManager::getConfigSetting ( $output, $database, 'endpoint' );
		
		if ( $framework == TemplateManager::$FRAMEWORK_CAIRNGORM )
		{
			$flexForm = FileSystemService::readFile ( TemplateManager::$FLEX_TEMPLATE_LOCATION . 'FlexListCAIRNGORM.txt' );
		}
		else if ( $framework == TemplateManager::$FRAMEWORK_AS3 )
		{
			$flexForm = FileSystemService::readFile ( TemplateManager::$FLEX_TEMPLATE_LOCATION . 'FlexListREST.txt' );
		}
		
		/* Set and replace the ufirst table name*/
		$template = preg_replace ( TemplateManager::$TABLE_UFIRST_PATTERN, $tableUFirst, $flexForm );
		
		/* Set and replace the all upper case table name in the form */
		$template = preg_replace ( TemplateManager::$TABLE_UPPERCASE_PATTERN, $tableUC, $template );
		$template = preg_replace ( TemplateManager::$ENDPOINT_PATTERN, $endpoint, $template );
		$template = preg_replace ( TemplateManager::$DATABASE_PATTERN, ucfirst ( $database ), $template );
	
		/* Set and replace the namespaces */
		$template = preg_replace ( TemplateManager::$NAMESPACE_PATTERN, $namespace, $template );
		$template = preg_replace ( TemplateManager::$NAMESPACE_URL_PATTERN, $folderNamespace, $template );
		
		/* Set and replace the datagrid columns */
		$template = preg_replace ( TemplateManager::$LIST_FIELDS_PATTERN, $listFields, $template );
		
		/* Set and replace the copywrite header */
		$template = preg_replace ( TemplateManager::$COPYWRITE_PATTERN, $copywrite, $template );
		
		Utilities::checkOrMakeFolders ( TemplateManager::$CLIENT_OUTPUT, $folderNamespace, 'view/' . $tableUFirst . '/' );
		$file = FileSystemService::writeFile ( TemplateManager::$CLIENT_OUTPUT . $folderNamespace . '/view/' . $tableUFirst . '/' . $tableUFirst . 'List.mxml', $template );
		
		return array ( 
			'label' => $tableUFirst . 'List.mxml', 'data' => $file 
		);
	}
	
	/**
	 * I generate a TableNameForm.mxml, for the Flex client side.
	 * 
	 * Here is the MXML that I am looping for the form inputs.
	 *
	 * <code>
	 * <mx:FormItem label="FIELD_NAME" require="true">
	 *		<mx:TextInput id="txt_FIELD_NAME" editable="false" text="{ selectedRecord.FIELD_NAME }"/>
	 *	</mx:FormItem>
	 * </code>
	 * 
	 * Here is the AS that I am looping for setting the values of the inputs to the attributes of the value object.
	 * 
	 * <code>
	 * vo.FIELD_NAME = txt_FIELD_NAME.text;
	 * <code>
	 * 
	 * Here is the AS that I also loop for setting up for clearing the field values and creating a new instance of a value object.
	 * 
	 * <code>
	 * txt_FIELD_NAME.text = "";
	 * txt_FIELD_NAME.errorString = "";
	 *	</code>
	 * 
	 * For required fields I make each form item required, so at initialization I add every validator to a validator array.
	 * 
	 * <code>
	 * validators = [ FIELD_NAMEV ];
	 * <code>
	 * 
	 * And here is the MXML that I loop creating a validator for every field that is required, that also is the one that gets pushed into an array.
	 *
	 * <code>
	 * <mx:StringValidator id="FIELD_NAMEV" source="{ txt_FIELD_NAME }" required="true" property="text"/> 
	 * </code>
	 * 
	 * @param [string] $output - The location where the file is to be placed once generated
	 * @param [string] $namespace - Applications namespace. example( com.domain.project )
	 * @param [string] $database - The applications database name.
	 * @param [string] $table - The applications databases table.
	 * @param [array] $fields - The applications table fields.
	 * @return [array] - An array containing the filename and the real file path.
	 */
	public static function generateForm( $output, $namespace, $database, $table, $fields = null )
	{
		$tableUFirst = ucfirst ( $table );
		$tableUC = strtoupper ( $table );
		$database = ucfirst ( $database );
		
		//make the folder namespace com/jonnie/test/
		$folderNamespace = Utilities::namespaceFolders ( $namespace );
		
		//make the actual namespace com.jonnie.test
		$namespace = Utilities::namespaceApplication ( $namespace );
		
		$tableModel = $database . 'Service';
		
		$framework = ConfigManager::getConfigSetting ( $output, $database, 'framework' );
		if ( $framework == TemplateManager::$FRAMEWORK_CAIRNGORM )
		{
			$tableModel = 'model';
		}
		
		//Flex Form
		$formFields = '';
		$setFields = '';
		$clearFields = '';
		$validatorFields = '';
		$validatorInitFields = '';
		
		foreach ( $fields as $fieldNode )
		{
			$field = $fieldNode [ 'name' ]; //Field Name
			$required = $fieldNode [ 'required' ];
			
			/* ==========================================================
			 * Build the form inputs - ex.( 
			 * 
			 * <mx:FormItem label="Category_id" required="true" width="100%">
			 *		<mx:TextInput id="txt_category_id" text="{ model.selectedCategories.category_id }" width="100%"/>
			 *	</mx:FormItem> )
			 * ========================================================== */
			$formFields .= '
				<mx:FormItem label="' . ucfirst ( $field ) . '" required="' . $required . '" width="100%">
					<mx:TextInput id="txt_' . $field . '" text="{ ' . $tableModel . '.SELECTED_' . $tableUC . '.' . $field . ' }" width="100%"/>
				</mx:FormItem>';
			
			/* ========================================================== 
			 *  Set the fields for all fields in table - ex. ( vo.FIELD_NAME = txt_FIELD_NAME.text );
			 * ==========================================================*/
			$setFields .= '
			vo.' . $field . ' = txt_' . $field . '.text;';
			
			/* ========================================================== 
			 * Clear the field values - ex. ( txt_FIELD_NAME.text = ""; );
			 * 									 ( txt_FIELD_NAME.errorString = "" ); 
			 * ==========================================================*/
			$clearFields .= '
			txt_' . $field . '.text = "";
			txt_' . $field . '.errorString = "";
			';
			
			//If the field is required in the database, and the schema.xml file
			if ( $required )
			{
				
				/* ========================================================== 
				 *  Set up the validators inside of the init - ex. ( validators = [ @INITVALIDATORS ] );
			 	 * ==========================================================*/
				$validatorInitFields .= '' . $field . 'V, ';
				
				/* ========================================================== 
			 	*  Set up the validators in the main component - ex. ( 
				* <mx:StringValidator id="FIELD_NAMEV" source="{ txt_FIELD_NAME }" required="true" property="text"/> )
			 	* ==========================================================*/
				$validatorFields .= '
				<mx:StringValidator id="' . $field . 'V" source="{ txt_' . $field . ' }" required="true" property="text"/>';
			}
		}
		
		$validatorInitFields = Utilities::trimSQL ( $validatorInitFields );
		
		/**
		 * Check to see weither to create the cairngorm template list or the rest
		 * @todo: Added 05/04/09 
		 */
		$copywrite = ConfigManager::getConfigSetting ( $output, $database, 'copywrite' );
		$endpoint = ConfigManager::getConfigSetting ( $output, $database, 'endpoint' );
		
		if ( $framework == TemplateManager::$FRAMEWORK_CAIRNGORM )
		{
			$flexForm = FileSystemService::readFile ( TemplateManager::$FLEX_TEMPLATE_LOCATION . 'FlexFormCAIRNGORM.txt' );
		}
		else if ( $framework == TemplateManager::$FRAMEWORK_AS3 )
		{
			$flexForm = FileSystemService::readFile ( TemplateManager::$FLEX_TEMPLATE_LOCATION . 'FlexFormREST.txt' );
		}
		
		/* Set and replace the URL location the services will be located */
		$template = preg_replace ( TemplateManager::$ENDPOINT_PATTERN, $endpoint, $flexForm );
		
		/* Set and replace the copywrite in each files header */
		$template = preg_replace ( TemplateManager::$COPYWRITE_PATTERN, $copywrite, $template );
		
		/* Set and replace the table name */
		$template = preg_replace ( TemplateManager::$TABLE_UFIRST_PATTERN, $tableUFirst, $template );
		
		/* Set and replace the all uppercase table name */
		$template = preg_replace ( TemplateManager::$TABLE_UPPERCASE_PATTERN, $tableUC, $template );
		
		/* Set and replace the all uppercase table name */
		$template = preg_replace ( TemplateManager::$DATABASE_PATTERN, $database, $template );
		
		/* Set and replace the form fields */
		$template = preg_replace ( TemplateManager::$FORM_FIELDS_PATTERN, $formFields, $template );
		
		/* Set and replace the namespaces */
		$template = preg_replace ( TemplateManager::$NAMESPACE_PATTERN, $namespace, $template );
		$template = preg_replace ( TemplateManager::$NAMESPACE_URL_PATTERN, $folderNamespace, $template );
		
		/* Set and replace the clearing of the form field values */
		$template = preg_replace ( TemplateManager::$CLEAR_FIELDS_PATTERN, $clearFields, $template );
		
		/* Set and replace the values on the new object for insertion */
		$template = preg_replace ( TemplateManager::$SET_FIELDS_PATTERN, $setFields, $template );
		
		/* Set and replace the form init validators array */
		$template = preg_replace ( TemplateManager::$INIT_VALIDATORS_PATTERN, $validatorInitFields, $template );
		
		/* Set and replace the validator fields at the bottom of the template */
		$template = preg_replace ( TemplateManager::$VALIDATORS_PATTERN, $validatorFields, $template );
		
		Utilities::checkOrMakeFolders ( TemplateManager::$CLIENT_OUTPUT, $folderNamespace, 'view/' . $tableUFirst . '/' );
		$file = FileSystemService::writeFile ( TemplateManager::$CLIENT_OUTPUT . $folderNamespace . '/view/' . $tableUFirst . '/' . $tableUFirst . 'Form.mxml', $template );
		
		//return 'Flex Form for ' . $tableUFirst . ' Complete';
		return array ( 
			'label' => $tableUFirst . 'Form.mxml', 'data' => $file 
		);
	}
	
	/**
	 * I create a get/save/remove method for the application server side service.
	 *
	 * @param [string] $output - The location where the file is to be placed once generated
	 * @param [string] $namespace - Applications namespace. example( com.domain.project )
	 * @param [string] $database - The applications database name.
	 * @param [string] $table - The applications databases table.
	 * @param [array] $fields - The applications table fields.
	 * @return [array] - An array containing the filename and the real file path.
	 */
	public static function generateRESTService( $output, $namespace, $database, $table, $fields = null )
	{
		$database = ucfirst ( $database );
		$filename = $database . 'Service.as';
		
		//make the folder namespace
		$folderNamespace = Utilities::namespaceFolders ( $namespace );
		$namespace = Utilities::namespaceApplication ( $namespace );
		
		$serviceGetCall = '';
		$serviceSaveCall = '';
		$serviceRemoveCall = '';
		$serviceTableSelected = '';
		$serviceTableCollection = '';
		$serviceGetResult = '';
		$serviceSaveResult = '';
		$serviceRemoveResult = '';
		$serviceComments = '';
		
		//loop all tables in array
		foreach ( $table as $tbl )
		{
			$tableOrgName = $tbl [ 'table' ];
			$tableUFirstName = ucfirst ( $tbl [ 'table' ] );
			$tableUCName = strtoupper ( $tbl [ 'table' ] );
			$tableLCName = strtolower ( $tbl [ 'table' ] );
			
			/* ========================================================== 
			 * Create the method info and break for all table records 
			 * ==========================================================*/
			$serviceComments .= '
			/* ****************************************************************
 			* TABLE: ' . $tableOrgName . '
 			* CALLS: get' . $tableUFirstName . ', save' . $tableUFirstName . ', remove' . $tableUFirstName . '
 			* ****************************************************************/';
			
			/* ========================================================== 
			 * Create the selected table record for all table records 
			 * ==========================================================*/
			$serviceTableSelected .= '
			[Bindable] static public var SELECTED_' . $tableUCName . ':' . $tableUFirstName . 'VO';
			
			/* ========================================================== 
			 * Create the table collection variables for all table records 
			 * ==========================================================*/
			$serviceTableCollection .= '
			[Bindable] static public var ' . $tableUCName . '_COLLECTION:ArrayCollection;';
			
			/* ========================================================== 
			 * Create the get call for all table records 
			 * ==========================================================*/
			$serviceGetCall .= '
			public function get' . $tableUFirstName . '():void
			{
				this.sendQuery( "' . $tableOrgName . '", "get", "", null, onResult_get' . $tableUFirstName . ' );
			}
			';
			
			/* ========================================================== 
			 * Create the save call for all table records 
			 * ==========================================================*/
			$serviceSaveCall .= '
			public function save' . $tableUFirstName . '( ' . $tableLCName . ':' . $tableUFirstName . 'VO ):void
			{
				this.sendQuery( "' . $tableOrgName . '", "save", ' . $tableLCName . '.toQueryString(), ' . $tableLCName . ', onResult_save' . $tableUFirstName . ' );
			}
			';
			
			/* ========================================================== 
			 * Create the remove call for all table records 
			 * ==========================================================*/
			$serviceRemoveCall .= '
			public function remove' . $tableUFirstName . '( ' . $tableLCName . ':' . $tableUFirstName . 'VO, index:int ):void
			{
				this.sendQuery( "' . $tableOrgName . '", "remove", ' . $tableLCName . '.toQueryString(), index, onResult_remove' . $tableUFirstName . ' );
			}
			';
			
			/* ========================================================== 
			 * Create the get result handler for all table records 
			 * ==========================================================*/
			$serviceGetResult .= '
			private function onResult_get' . $tableUFirstName . '( event:ResultEvent ):void
			{
				if ( event.result is String )
				{
					var rawData:String = String( event.result );
					var jsonArray:Array = ( JSON.decode( rawData ) as Array );
					var tempAC:ArrayCollection = new ArrayCollection();
	
					for ( var s:String in jsonArray )
					{
						tempAC.addItem( new ' . $tableUFirstName . 'VO( jsonArray[ s ] ) );
					}
					' . $database . 'Service.' . $tableUCName . '_COLLECTION = tempAC;
				}
			}
			';
			
			/* ========================================================== 
			 * Create the save result handler for all table records 
			 * ==========================================================*/
			$serviceSaveResult .= '
			private function onResult_save' . $tableUFirstName . '( event:ResultEvent ):void
			{
				' . $database . 'Service.' . 'SERVICE_DUMP += "Service Result Token: " + event.result.toString();
			}
			';
			
			/* ========================================================== 
			 * Create the remove result handler for all table records 
			 * ==========================================================*/
			$serviceRemoveResult .= '
			private function onResult_remove' . $tableUFirstName . '( event:ResultEvent ):void
			{
				var index:int = event.token.resultToken;
	
				' . $database . 'Service.' . $tableUCName . '_COLLECTION.removeItemAt( index );
				' . $database . 'Service.SERVICE_DUMP += "\nService Result Token: " + index;
				
			}
			';
		
		} //ends table for loop
		

		/**
		 * Check to see weither to create the cairngorm template list or the rest
		 * @todo: Added 05/04/09 
		 */
		$copywrite = ConfigManager::getConfigSetting ( $output, $database, 'copywrite' );
		$framework = ConfigManager::getConfigSetting ( $output, $database, 'framework' );
		
		if ( $framework == TemplateManager::$FRAMEWORK_CAIRNGORM )
		{
			return;
		}
		else if ( $framework == TemplateManager::$FRAMEWORK_AS3 )
		{
			$databaseService = FileSystemService::readFile ( TemplateManager::$FLEX_TEMPLATE_LOCATION . 'FlexRESTService.txt' );
		}
		$template = preg_replace ( TemplateManager::$COPYWRITE_PATTERN, $copywrite, $databaseService );
		
		$template = preg_replace ( TemplateManager::$DATABASE_PATTERN, ucfirst ( $database ), $template );
		$template = preg_replace ( TemplateManager::$NAMESPACE_PATTERN, $namespace, $template );
		
		$template = preg_replace ( TemplateManager::$TABLE_SELECTED_PATTERN, $serviceTableSelected, $template );
		$template = preg_replace ( TemplateManager::$TABLE_COLLECTION_PATTERN, $serviceTableCollection, $template );
		
		$template = preg_replace ( TemplateManager::$SERVICE_GET_CALL_PATTERN, $serviceGetCall, $template );
		$template = preg_replace ( TemplateManager::$SERVICE_SAVE_CALL_PATTERN, $serviceSaveCall, $template );
		$template = preg_replace ( TemplateManager::$SERVICE_REMOVE_CALL_PATTERN, $serviceRemoveCall, $template );
		
		$template = preg_replace ( TemplateManager::$SERVICE_REMOVE_RESULT_PATTERN, $serviceRemoveResult, $template );
		$template = preg_replace ( TemplateManager::$SERVICE_SAVE_RESULT_PATTERN, $serviceSaveResult, $template );
		$template = preg_replace ( TemplateManager::$SERVICE_GET_RESULT_PATTERN, $serviceGetResult, $template );
		
		Utilities::checkOrMakeFolders ( TemplateManager::$CLIENT_OUTPUT, $folderNamespace, 'services' );
		$file = FileSystemService::writeFile ( TemplateManager::$CLIENT_OUTPUT . $folderNamespace . '/services/' . $filename, $template );
		
		return array ( 
			'label' => ucfirst ( $database ) . 'Service.as', 'data' => $file 
		);
	}
	
	/**
	 * I create a Service Class for use with amfphp.
	 * Even tho I am boycotting amfphp as of 5/1/09 I will still create it.
	 *
	 * @param [string] $output - The location where the file is to be placed once generated
	 * @param [string] $namespace - Applications namespace. example( com.domain.project )
	 * @param [string] $database - The applications database name.
	 * @param [string] $table - The applications databases table.
	 * @param [array] $fields - The applications table fields.
	 * @return [array] - An array containing the filename and the real file path.
	 */
	public static function generateAMFPHPService( $output, $namespace, $database, $table, $fields = null )
	{
		//upper case the table name
		$tableUFirst = ucfirst ( $table );
		
		//Create the fileame
		$filename = $tableUFirst . 'ServiceDelegate.as';
		
		//make the folder namespace
		$folderNamespace = Utilities::namespaceFolders ( $namespace );
		$namespace = Utilities::namespaceApplication ( $namespace );
		
		$copywrite = ConfigManager::getConfigSetting ( $output, $database, 'copywrite' );
		$tableService = FileSystemService::readFile ( TemplateManager::$CAIRNGORM_TEMPLATE_LOCATION . 'Delegate.txt' );
		
		//replace the table name inside of the template
		$template = preg_replace ( TemplateManager::$TABLE_PATTERN, $tableUFirst, $tableService );
		$template = preg_replace ( TemplateManager::$NAMESPACE_PATTERN, $namespace, $template );
		$template = preg_replace ( TemplateManager::$COPYWRITE_PATTERN, $copywrite, $template );
		
		Utilities::checkOrMakeFolders ( TemplateManager::$CLIENT_OUTPUT, $folderNamespace, 'business' );
		$file = FileSystemService::writeFile ( TemplateManager::$CLIENT_OUTPUT . $folderNamespace . '/business/' . $filename, $template );
		
		return array ( 
			'label' => $tableUFirst . 'ServiceDelegate.as', 'data' => $file 
		);
	}
	
	/**
	 * I generate a Data Value Object that represents a entity.
	 * I make Flex builder strong check my attributes.
	 *
	 * @param [string] $output - The location where the file is to be placed once generated
	 * @param [string] $namespace - Applications namespace. example( com.domain.project )
	 * @param [string] $database - The applications database name.
	 * @param [string] $table - The applications databases table.
	 * @param [array] $fields - The applications table fields.
	 * @return [array] - An array containing the filename and the real file path.
	 */
	public static function generateValueObject( $output, $namespace, $database, $table, $fields = null )
	{
		$tableUFirst = ucfirst ( $table );
		
		$folderNamespace = Utilities::namespaceFolders ( $namespace );
		$namespace = Utilities::namespaceApplication ( $namespace );
		
		$fieldVars = '';
		$fieldsCon = '';
		$fieldsQuery = '';
		
		foreach ( $fields as $field )
		{
			$fieldVars .= '
			public var ' . $field [ 'name' ] . ':String;';
			
			$fieldsCon .= '
			this.' . $field [ 'name' ] . ' = obj["' . $field [ 'name' ] . '"];';
			
			$fieldsQuery .= '"&' . $field [ 'name' ] . '=" + ' . $field [ 'name' ] . '+ ';
		
		}
		
		$fieldsQuery = Utilities::trim ( $fieldsQuery, 2 );
		$copywrite = ConfigManager::getConfigSetting ( $output, $database, 'copywrite' );
		
		$tableService = FileSystemService::readFile ( TemplateManager::$FLEX_TEMPLATE_LOCATION . 'FlexValueObject.txt' );
		$template = preg_replace ( TemplateManager::$TABLE_UFIRST_PATTERN, $tableUFirst, $tableService );
		$template = preg_replace ( TemplateManager::$FIELD_VARS_PATTERN, $fieldVars, $template );
		$template = preg_replace ( TemplateManager::$FIELDS_PATTERN, $fieldsCon, $template );
		$template = preg_replace ( TemplateManager::$FIELDS_QUERY_PATTERN, $fieldsQuery, $template );
		$template = preg_replace ( TemplateManager::$NAMESPACE_PATTERN, $namespace, $template );
		$template = preg_replace ( TemplateManager::$COPYWRITE_PATTERN, $copywrite, $template );
		
		Utilities::checkOrMakeFolders ( TemplateManager::$CLIENT_OUTPUT, $folderNamespace, 'vo' );
		$file = FileSystemService::writeFile ( TemplateManager::$CLIENT_OUTPUT . $folderNamespace . '/vo/' . $tableUFirst . 'VO.as', $template );
		
		return array ( 
			'label' => $tableUFirst . 'VO.as', 'data' => $file 
		);
	}

}
?>