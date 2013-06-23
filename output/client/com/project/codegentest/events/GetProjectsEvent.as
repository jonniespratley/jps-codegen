/**
Your Copywrite information
*/
package com.project.codegentest.events
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import flash.events.Event;
		
	public final class GetProjectsEvent extends CairngormEvent
	{
		public static const GET_PROJECTS_EVENT:String = "GET_PROJECTS_EVENT";

		public function GetProjectsEvent()
		{
			super( GET_PROJECTS_EVENT );
		}
		
		override public function clone():Event
		{
			return new GetProjectsEvent();
		}
	}
}