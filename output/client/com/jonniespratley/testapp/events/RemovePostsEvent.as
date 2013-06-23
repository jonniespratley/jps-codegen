/**
Test app by jonnie spratley
*/
package com.jonniespratley.testapp.events
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import flash.events.Event;
	import com.jonniespratley.testapp.vo.*;
		
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