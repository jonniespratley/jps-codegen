/**
Your Copywrite information
*/
package com.project.codegentest.events
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import flash.events.Event;
	import com.project.codegentest.vo.*;
		
	public final class RemoveContactsEvent extends CairngormEvent
	{
		public static const REMOVE_CONTACTS_EVENT:String = "REMOVE_CONTACTS_EVENT";

		public var vo:ContactsVO;
		public var index:int;
		
		public function RemoveContactsEvent( vo:ContactsVO, index:int )
		{
			super( REMOVE_CONTACTS_EVENT );
			this.vo =  vo;
			this.index = index;
		}
		
		override public function clone():Event
		{
			return new RemoveContactsEvent( vo, index );
		}
	}
}