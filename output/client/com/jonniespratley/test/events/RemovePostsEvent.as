/**
This is a sample application.
*/
package com.jonniespratley.test.events
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import flash.events.Event;
	import com.jonniespratley.test.vo.*;
		
	public final class RemovePostsEvent extends CairngormEvent
	{
		public static const REMOVE_POSTS_EVENT:String = "REMOVE_POSTS_EVENT";

		public var vo:PostsVO;
		public var index:int;
		
		public function RemovePostsEvent( vo:PostsVO, index:int )
		{
			super( REMOVE_POSTS_EVENT );
			this.vo =  vo;
			this.index = index;
		}
		
		override public function clone():Event
		{
			return new RemovePostsEvent( vo, index );
		}
	}
}