/**
Your Copywrite information
*/
package com.project.codegentest.model 
{
	import com.adobe.cairngorm.model.IModelLocator;
	import mx.collections.ArrayCollection;
	
	import com.project.codegentest.vo.*;

    [Bindable]
	public final class ModelLocator implements IModelLocator
	{
		/**
		 * Defines the Singleton instance of the Application ModelLocator
		 */
		private static var instance:ModelLocator;

		public function ModelLocator()
		{
			if( instance != null ) 
			throw new Error( "Error: Singletons can only be instantiated via getInstance() method!" );

			ModelLocator.instance = this;
		}

		/**
		 * Returns the Singleton instance of the Application ModelLocator
		 */
		public static function getInstance():ModelLocator
		{
			if( instance == null )	instance = new ModelLocator();

			return instance;
		}

		// *********** Public Variables that our views are going to bind to ************** \
		
			public var ContactsCollection:ArrayCollection;
			public var selectedContacts:ContactsVO;
			
			public var ProjectsCollection:ArrayCollection;
			public var selectedProjects:ProjectsVO;
			
		
		// ***************** Public Static Variables for Work View States ************* \
		public var workflowState:uint = 0;
		public static const LOGIN_SCREEN:uint = 0;
		public static const WELCOME_SCREEN:uint = 1;
	}
}