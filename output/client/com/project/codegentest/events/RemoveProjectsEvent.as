/**
Your Copywrite information
*/
package com.project.codegentest.events
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import flash.events.Event;
	import com.project.codegentest.vo.*;
		
	public final class RemoveProjectsEvent extends CairngormEvent
	{
		public static const REMOVE_PROJECTS_EVENT:String = "REMOVE_PROJECTS_EVENT";

		public var vo:ProjectsVO;
		public var index:int;
		
		public function RemoveProjectsEvent( vo:ProjectsVO, index:int )
		{
			super( REMOVE_PROJECTS_EVENT );
			this.vo =  vo;
			this.index = index;
		}
		
		override public function clone():Event
		{
			return new RemoveProjectsEvent( vo, index );
		}
	}
}