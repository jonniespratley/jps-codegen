/**
Test app by jonnie spratley
*/
package com.jonniespratley.testapp.events
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import flash.events.Event;
	import com.jonniespratley.testapp.vo.*;
		
	public final class SavePostsEvent extends CairngormEvent
	{
		public static const SAVE_POSTS_EVENT:String = "SAVE_POSTS_EVENT";

		public var vo:PostsVO;
		
		public function SavePostsEvent( vo:PostsVO )
		{
			super( SAVE_POSTS_EVENT );
			this.vo =  vo;
		}
		
		override public function clone():Event
		{
			return new SavePostsEvent( vo );
		}
	}
}