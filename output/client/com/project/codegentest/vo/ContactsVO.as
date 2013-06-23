/**Your Copywrite information*/package com.project.codegentest.vo{		[RemoteClass(alias="com.project.codegentest.vo.ContactsVO")]		[Bindable]	public class ContactsVO extends Object	{		
			public var address:String;
			public var city:String;
			public var email:String;
			public var id:String;
			public var name:String;
			public var phone:String;
			public var state:String;				public function  ContactsVO( obj:Object = null )		{						if ( obj != null )			{				
			this.address = obj["address"];
			this.city = obj["city"];
			this.email = obj["email"];
			this.id = obj["id"];
			this.name = obj["name"];
			this.phone = obj["phone"];
			this.state = obj["state"];			} 		}	}}       