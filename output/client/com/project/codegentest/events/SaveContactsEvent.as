/**
Your Copywrite information
*/
package com.project.codegentest.events
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import flash.events.Event;
	import com.project.codegentest.vo.*;
		
	public final class SaveContactsEvent extends CairngormEvent
	{
		public static const SAVE_CONTACTS_EVENT:String = "SAVE_CONTACTS_EVENT";

		public var vo:ContactsVO;
		
		public function SaveContactsEvent( vo:ContactsVO )
		{
			super( SAVE_CONTACTS_EVENT );
			this.vo =  vo;
		}
		
		override public function clone():Event
		{
			return new SaveContactsEvent( vo );
		}
	}
}