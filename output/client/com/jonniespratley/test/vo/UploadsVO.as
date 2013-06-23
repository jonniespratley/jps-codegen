/**This is a sample application.*/package com.jonniespratley.test.vo{		[RemoteClass(alias="com.jonniespratley.test.vo.UploadsVO")]		[Bindable]	public class UploadsVO extends Object	{		
			public var id:String;
			public var name:String;
			public var path:String;
			public var size:String;
			public var type:String;				public function  UploadsVO( obj:Object = null )		{						if ( obj != null )			{				
			this.id = obj["id"];
			this.name = obj["name"];
			this.path = obj["path"];
			this.size = obj["size"];
			this.type = obj["type"];			} 		}	}}       