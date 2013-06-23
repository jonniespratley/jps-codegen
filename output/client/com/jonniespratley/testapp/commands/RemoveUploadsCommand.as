/**Test app by jonnie spratley*/package com.jonniespratley.testapp.commands{	import com.jonniespratley.testapp.model.*;	import com.jonniespratley.testapp.events.*;	import com.jonniespratley.testapp.vo.*;	import com.jonniespratley.testapp.business.*;		import com.adobe.cairngorm.commands.ICommand;	import com.adobe.cairngorm.control.CairngormEvent;	import mx.collections.ArrayCollection;	import mx.controls.Alert;	import mx.rpc.IResponder;	import mx.rpc.events.FaultEvent;	import mx.rpc.events.ResultEvent;	import mx.utils.ArrayUtil;	public class RemoveUploadsCommand implements ICommand, IResponder	{		private var model:ModelLocator = ModelLocator.getInstance();		public function execute( event:CairngormEvent ) : void		{			var evt:RemoveUploadsEvent = event as RemoveUploadsEvent;					var delegate:UploadsServiceDelegate = new UploadsServiceDelegate( this );				 delegate.removeUploads( evt.vo, evt.index );		}		public function result( data:Object ) : void		{			var result:ResultEvent = data as ResultEvent;						//Remove the item that was deleted at the index, from the token			model.UploadsCollection.removeItemAt( result.token.index );		}		public function fault( fault:Object ):void		{			var faultEvt:FaultEvent = fault as FaultEvent;									Alert.show(faultEvt.fault.toString(), "Service Error");						trace(faultEvt.fault.faultString);		}	}}       