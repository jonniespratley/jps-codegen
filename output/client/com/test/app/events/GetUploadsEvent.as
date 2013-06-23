/**
This is a sample application.
*/
package com.test.app.events
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import flash.events.Event;
		
	public final class GetUploadsEvent extends CairngormEvent
	{
		public static const GET_UPLOADS_EVENT:String = "GET_UPLOADS_EVENT";

		public function GetUploadsEvent()
		{
			super( GET_UPLOADS_EVENT );
		}
		
		override public function clone():Event
		{
			return new GetUploadsEvent();
		}
	}
}