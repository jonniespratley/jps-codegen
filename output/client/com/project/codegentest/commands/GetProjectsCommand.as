/**
Your Copywrite information
*/
package com.project.codegentest.commands
{

	import com.project.codegentest.model.*;
	import com.project.codegentest.events.*;
	import com.project.codegentest.vo.*;
	import com.project.codegentest.business.*;
	
	import com.adobe.cairngorm.commands.ICommand;
	import com.adobe.cairngorm.control.CairngormEvent;

	import mx.collections.ArrayCollection;
	import mx.controls.Alert;
	import mx.rpc.IResponder;
	import mx.rpc.events.FaultEvent;
	import mx.rpc.events.ResultEvent;
	import mx.utils.ArrayUtil;
	
	public class GetProjectsCommand implements ICommand, IResponder
	{
		private var model:ModelLocator = ModelLocator.getInstance();

		public function execute( event:CairngormEvent ) : void
		{
			var evt:GetProjectsEvent = event as GetProjectsEvent;		
			var delegate:ProjectsServiceDelegate = new ProjectsServiceDelegate( this );
				delegate.getAllProjects();
		}

		public function result( data:Object ) : void
		{
			var result:ResultEvent = data as ResultEvent;
	
			//model.collection = new ArrayCollection( ArrayUtil.toArray( data.result ) );
			model.ProjectsCollection = initVO( data.result ) ;
		}

		public function fault( fault:Object ):void
		{
			var faultEvt:FaultEvent = fault as FaultEvent;			
			
			Alert.show(faultEvt.fault.toString(), "Service Error");
			
			trace(faultEvt.fault.faultString);
		}
		
		private function initVO( resultArray:Array ):ArrayCollection
		{
			var tempArray:ArrayCollection = new ArrayCollection();
			
			for ( var s:String in resultArray )
			{
				tempArray.addItem( new ProjectsVO( resultArray[s] ) );				
			}
			return tempArray;
		}	
	}
}