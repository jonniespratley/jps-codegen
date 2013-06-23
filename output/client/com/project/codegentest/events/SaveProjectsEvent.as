/**
Your Copywrite information
*/
package com.project.codegentest.events
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import flash.events.Event;
	import com.project.codegentest.vo.*;
		
	public final class SaveProjectsEvent extends CairngormEvent
	{
		public static const SAVE_PROJECTS_EVENT:String = "SAVE_PROJECTS_EVENT";

		public var vo:ProjectsVO;
		
		public function SaveProjectsEvent( vo:ProjectsVO )
		{
			super( SAVE_PROJECTS_EVENT );
			this.vo =  vo;
		}
		
		override public function clone():Event
		{
			return new SaveProjectsEvent( vo );
		}
	}
}