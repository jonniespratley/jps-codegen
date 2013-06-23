/**
Your Copywrite information
*/
package com.project.codegentest.events
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import flash.events.Event;
		
	public final class GetContactsEvent extends CairngormEvent
	{
		public static const GET_CONTACTS_EVENT:String = "GET_CONTACTS_EVENT";

		public function GetContactsEvent()
		{
			super( GET_CONTACTS_EVENT );
		}
		
		override public function clone():Event
		{
			return new GetContactsEvent();
		}
	}
}