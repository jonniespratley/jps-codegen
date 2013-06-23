/**
This is a sample application.
*/
package com.jonniespratley.test.events
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import flash.events.Event;
	import com.jonniespratley.test.vo.*;
		
	public final class RemoveUploadsEvent extends CairngormEvent
	{
		public static const REMOVE_UPLOADS_EVENT:String = "REMOVE_UPLOADS_EVENT";

		public var vo:UploadsVO;
		public var index:int;
		
		public function RemoveUploadsEvent( vo:UploadsVO, index:int )
		{
			super( REMOVE_UPLOADS_EVENT );
			this.vo =  vo;
			this.index = index;
		}
		
		override public function clone():Event
		{
			return new RemoveUploadsEvent( vo, index );
		}
	}
}