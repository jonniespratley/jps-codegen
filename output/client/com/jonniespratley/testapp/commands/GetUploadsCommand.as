/**
Test app by jonnie spratley
*/
package com.jonniespratley.testapp.commands
{

	import com.jonniespratley.testapp.model.*;
	import com.jonniespratley.testapp.events.*;
	import com.jonniespratley.testapp.vo.*;
	import com.jonniespratley.testapp.business.*;
	
	import com.adobe.cairngorm.commands.ICommand;
	import com.adobe.cairngorm.control.CairngormEvent;

	import mx.collections.ArrayCollection;
	import mx.controls.Alert;
	import mx.rpc.IResponder;
	import mx.rpc.events.FaultEvent;
	import mx.rpc.events.ResultEvent;
	import mx.utils.ArrayUtil;
	
	public class GetUploadsCommand implements ICommand, IResponder
	{
		private var model:ModelLocator = ModelLocator.getInstance();

		public function execute( event:CairngormEvent ) : void
		{
			var evt:GetUploadsEvent = event as GetUploadsEvent;		
			var delegate:UploadsServiceDelegate = new UploadsServiceDelegate( this );
				delegate.getAllUploads();
		}

		public function result( data:Object ) : void
		{
			var result:ResultEvent = data as ResultEvent;
	
			//model.collection = new ArrayCollection( ArrayUtil.toArray( data.result ) );
			model.UploadsCollection = initVO( data.result ) ;
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
				tempArray.addItem( new UploadsVO( resultArray[s] ) );				
			}
			return tempArray;
		}	
	}
}