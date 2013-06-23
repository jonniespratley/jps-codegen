/**
This is a sample application.
*/
package com.jonniespratley.test.events
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import flash.events.Event;
		
	public final class GetPostsEvent extends CairngormEvent
	{
		public static const GET_POSTS_EVENT:String = "GET_POSTS_EVENT";

		public function GetPostsEvent()
		{
			super( GET_POSTS_EVENT );
		}
		
		override public function clone():Event
		{
			return new GetPostsEvent();
		}
	}
}