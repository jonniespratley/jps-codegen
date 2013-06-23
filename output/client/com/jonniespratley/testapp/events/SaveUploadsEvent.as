/**
Test app by jonnie spratley
*/
package com.jonniespratley.testapp.events
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import flash.events.Event;
	import com.jonniespratley.testapp.vo.*;
		
	public final class SaveUploadsEvent extends CairngormEvent
	{
		public static const SAVE_UPLOADS_EVENT:String = "SAVE_UPLOADS_EVENT";

		public var vo:UploadsVO;
		
		public function SaveUploadsEvent( vo:UploadsVO )
		{
			super( SAVE_UPLOADS_EVENT );
			this.vo =  vo;
		}
		
		override public function clone():Event
		{
			return new SaveUploadsEvent( vo );
		}
	}
}