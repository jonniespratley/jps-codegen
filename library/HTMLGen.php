<?php
/**
 * @name  	HTMLGen.php
 * @author  Jonnie Spratley
 * @version 1.9
 */

require_once 'TemplateManager.php';
require_once 'FileSystemService.php';
require_once 'ConfigManager.php';
require_once 'SchemaManager.php';
require_once 'Utilities.php';


class HTMLGen
{
	/**
	 * I generate a HTML table list containing a list of the records in the database.
	 * I can update and remove records as well.
	 * 
	 * Here is the code I loop over per field in table.
	 * 
	 * <code>
	 * <th scope="col">'. ucfirst( $field [ 'name' ] ) . '</th>';
	 * </code>
	 * 
	 * <code>
	 * $recordList .= "<td>$postVO->' . $field [ 'name' ] . '</td>";
	 * </code>
	 *
	 * @param [string] $output - The location where the file is to be placed once generated
	 * @param [string] $namespace - Applications namespace. example( com.domain.project )
	 * @param [string] $database - The applications database name.
	 * @param [string] $table - The applications databases table.
	 * @param [array] $fields - The applications table fields.
	 * @return [array] - An array containing the filename and the real file path.
	 */
	public static function generateHTMLList( $filepath, $namespace, $database, $table, $fields = null )
	{
		$tableUFirst = ucfirst ( $table );
		$filename = $tableUFirst . 'List.php';
		
		$folderNamespace = Utilities::namespaceFolders ( $namespace );
		$namespace = Utilities::namespaceApplication ( $namespace );
		
		$htmlFieldList = '';
		$htmlFieldHeader = '';
		$tableKey = '';

		//<th scope="col">Title</th>
		//$recordList .= "<td>$postVO->' . $field [ 'name' ] . '</td>";
		foreach ( $fields as $field )
		{
			$htmlFieldHeader .= '
			<th scope="col">'. ucfirst( $field [ 'name' ] ) . '</th>';
			
			$htmlFieldList .= '
			$recordList .= "<td>$recordVO->' . $field [ 'name' ] . '</td>";';

			if ( $field['key'] )
			{
				$tableKey = $field['key'];
			}
		}
		$htmlFieldHeader .= '<th scope="col">Actions</th>';
	
		$tableService = FileSystemService::readFile ( TemplateManager::$HTML_TEMPLATE_LOCATION . 'list.txt' );
		
		$template = preg_replace ( TemplateManager::$TABLE_UFIRST_PATTERN, $tableUFirst, $tableService );
		$template = preg_replace ( TemplateManager::$HTML_FIELD_HEADER_PATTERN, $htmlFieldHeader, $template );
		$template = preg_replace ( TemplateManager::$HTML_FIELD_LIST_PATTERN, $htmlFieldList, $template );
		$template = preg_replace ( TemplateManager::$TABLE_PRIMARY_KEY_PATTERN, $tableKey, $template );
		$template = preg_replace ( TemplateManager::$DATABASE_PATTERN, ucfirst( $database ), $template );
 
		Utilities::checkOrMakeFolders ( TemplateManager::$SERVER_OUTPUT, $folderNamespace, 'html' );
		$file = FileSystemService::writeFile ( TemplateManager::$SERVER_OUTPUT . $folderNamespace . '/' . $filename, $template );
		
		//return 'Generated PHP Value Object for ' . $tableUFirst;
		return array ( 
			'label' => $tableUFirst . 'List.php', 'data' => $file 
		);
	}
	
	/**
	 * I generate a HTML form for the table, and inputs per field.
	 *
	 * I loop over the fields and clear the values.
	 * <code>
	 * $FIELD_NAME = ''; 
	 * </code>
	 * 
	 * I also loop over the fields to set the values.
	 * <code>
	 * $FIELD_NAME = $recordVO->FIELD_NAME;
	 * </code>
	 * 
	 * I also loop over this to create the form inputs.
	 * <code>
	 * <div>
	 *		<label for="FIELD_NAME">FIELD_NAME</label>
	 *	 	<input type="text" name="FIELD_NAME" value="<?php echo $FIELD_NAME; ? >"/ >
	 *	</div>
	 * </code>
	 * 
	 * 
	 * @param [string] $output - The location where the file is to be placed once generated
	 * @param [string] $namespace - Applications namespace. example( com.domain.project )
	 * @param [string] $database - The applications database name.
	 * @param [string] $table - The applications databases table.
	 * @param [array] $fields - The applications table fields.
	 * @return [array] - An array containing the filename and the real file path.
	 */
	public static function generateHTMLForm( $filepath, $namespace, $database, $table, $fields = null )
	{
		$tableUFirst = ucfirst ( $table );
		$filename = $tableUFirst . 'Form.php';
		
		$folderNamespace = Utilities::namespaceFolders ( $namespace );
		$namespace = Utilities::namespaceApplication ( $namespace );
		
		$fieldSetVars = '';
		$fieldClearVars = '';
		$fieldFormFields = '';
		$tableKey = '';
		
		/*
		 * HTML_CLEAR_VARS
		 * $id = '';
		 * 
		 * HTML_SET_VARS
		 * $id = $postVO->id;
		 * 
		 * HTML_FORM_FIELDS
		 * <div>
		 * 	<label for="title">Title</label>
		 * 	<input type="text" name="title" value="<?php echo $title; ?>"/>
		 * </div>
		*/
		foreach ( $fields as $field )
		{
			$fName = $field [ 'name' ]; 
			
			$fieldSetVars .= '
			$'.$fName.' = $recordVO->'.$fName.';';
			
			$fieldClearVars .= '
			$'.$fName.' = "";';
			
			$fieldFormFields .= '
			<div>
		 		<label for="'.$fName.'">'.ucfirst( $fName ).'</label>
		 		<input type="text" name="'.$fName.'" value="<?php echo $'.$fName.'; ?>"/>
		 	</div>';
			
			if ( $field['key'] )
			{
				$tableKey = $field['key'];
			}
		}
		
		$copywrite = ConfigManager::getConfigSetting ( $filepath, $database, 'copywrite' );
		
		$tableService = FileSystemService::readFile ( TemplateManager::$HTML_TEMPLATE_LOCATION . 'form.txt' );
		
		$template = preg_replace ( TemplateManager::$TABLE_UFIRST_PATTERN, $tableUFirst, $tableService );
		$template = preg_replace ( TemplateManager::$HTML_CLEAR_VARS_PATTERN, $fieldClearVars, $template );
		$template = preg_replace ( TemplateManager::$HTML_SET_VARS_PATTERN, $fieldSetVars, $template );
		$template = preg_replace ( TemplateManager::$HTML_FORM_FIELDS_PATTERN, $fieldFormFields, $template );
		$template = preg_replace ( TemplateManager::$TABLE_PRIMARY_KEY_PATTERN, $tableKey, $template );
		
		$template = preg_replace ( TemplateManager::$NAMESPACE_PATTERN, $namespace, $template );
		$template = preg_replace ( TemplateManager::$COPYWRITE_PATTERN, $copywrite, $template );
		$template = preg_replace ( TemplateManager::$CG_VERSION_PATTERN, CGManager::$CG_VERSION, $template );
		$template = preg_replace ( TemplateManager::$CG_AUTHOR_PATTERN, CGManager::$CG_AUTHOR, $template );
		
		Utilities::checkOrMakeFolders ( TemplateManager::$SERVER_OUTPUT, $folderNamespace, 'html' );
		$file = FileSystemService::writeFile ( TemplateManager::$SERVER_OUTPUT . $folderNamespace . '/' . $filename, $template );
		
		//	return 'Generated PHP Value Object for ' . $tableUFirst;
		return array ( 
			'label' => $tableUFirst . 'Form.php', 'data' => $file 
		);
	}
	
	/**
	 * I generate a HTML main page, that holds links to all of the table lists.
	 * 
	 * Here is what I loop over to add links to the table list html pages.
	 * <code>
	 * <li><a href="TABLE_NAMEList.php">TABLE_NAME</a></li>
	 * </code>
	 *
	 * @param [string] $output - The location where the file is to be placed once generated
	 * @param [string] $namespace - Applications namespace. example( com.domain.project )
	 * @param [string] $database - The applications database name.
	 * @param [string] $table - The applications databases table.
	 * @param [array] $fields - The applications table fields.
	 * @return [array] - An array containing the filename and the real file path.
	 */
	public static function generateHTMLMain( $filepath, $namespace, $database, $table, $fields = null )
	{
		$filename = ucfirst( $database ) . 'Main.php';
		
		$folderNamespace = Utilities::namespaceFolders ( $namespace );
		$namespace = Utilities::namespaceApplication ( $namespace );
		
		$tableLinks = '';
		
		//<li><a href="List.php">Posts</a></li>
		foreach ( $table as $tbl )
		{
			$tableUFirst = ucfirst ( $tbl['table'] );
			$tableLinks .= '
			<li><a href="' . $tableUFirst . 'List.php">' . $tableUFirst . '</a></li>
			';
		}
		
		$copywrite = ConfigManager::getConfigSetting ( $filepath, $database, 'copywrite' );
		
		$tableService = FileSystemService::readFile ( TemplateManager::$HTML_TEMPLATE_LOCATION . 'main.txt' );
		
		$template = preg_replace ( TemplateManager::$TABLE_UFIRST_PATTERN, $tableUFirst, $tableService );
		$template = preg_replace ( TemplateManager::$HTML_TABLE_LIST_PATTERN, $tableLinks, $template );
		$template = preg_replace ( TemplateManager::$NAMESPACE_PATTERN, $namespace, $template );
		$template = preg_replace ( TemplateManager::$COPYWRITE_PATTERN, $copywrite, $template );
		$template = preg_replace ( TemplateManager::$CG_VERSION_PATTERN, CGManager::$CG_VERSION, $template );
		$template = preg_replace ( TemplateManager::$CG_AUTHOR_PATTERN, CGManager::$CG_AUTHOR, $template );
		
		Utilities::checkOrMakeFolders ( TemplateManager::$SERVER_OUTPUT, $folderNamespace, 'vo' );
		
		//Copy over the header/footer/css/js but in the header replace the applications name
		$css = FileSystemService::readFile ( TemplateManager::$HTML_TEMPLATE_LOCATION . 'styles.txt' );
		$js = FileSystemService::readFile ( TemplateManager::$HTML_TEMPLATE_LOCATION . 'jquery.txt' );
		$header = FileSystemService::readFile ( TemplateManager::$HTML_TEMPLATE_LOCATION . '_header.txt' );
		$footer = FileSystemService::readFile ( TemplateManager::$HTML_TEMPLATE_LOCATION . '_footer.txt' );
		
		$header = preg_replace ( TemplateManager::$APPLICATION_PATTERN, ConfigManager::getConfigSetting ( $filepath, $database, 'application' ), $header );
		$footer = preg_replace ( TemplateManager::$APPLICATION_PATTERN, ConfigManager::getConfigSetting ( $filepath, $database, 'application' ), $footer );
		
		
		FileSystemService::writeFile ( TemplateManager::$SERVER_OUTPUT . $folderNamespace . '/' . '_header.php', $header );
		FileSystemService::writeFile ( TemplateManager::$SERVER_OUTPUT . $folderNamespace . '/' . '_footer.php', $footer );
		FileSystemService::writeFile ( TemplateManager::$SERVER_OUTPUT . $folderNamespace . '/' . 'styles.css', $css );
		FileSystemService::writeFile ( TemplateManager::$SERVER_OUTPUT . $folderNamespace . '/' . 'jquery.js', $js );
		
		$mainFilepath = TemplateManager::$SERVER_OUTPUT . $folderNamespace . '/' . $filename;
		
		$file = FileSystemService::writeFile ( $mainFilepath, $template );
		
		//TODO:Testing the URL
		echo $mainFilepath;
		
		
		
		
		//Now set the location of the file for the front end demo
		//	return 'Generated PHP Value Object for ' . $tableUFirst;
		return array ( 
			'label' => ucfirst( $database ) . 'Main.php', 'data' => $file 
		);
	}
}

?>