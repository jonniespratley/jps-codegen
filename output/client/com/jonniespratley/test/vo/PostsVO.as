/**This is a sample application.*/package com.jonniespratley.test.vo{		[RemoteClass(alias="com.jonniespratley.test.vo.PostsVO")]		[Bindable]	public class PostsVO extends Object	{		
			public var created:String;
			public var id:String;
			public var post_content:String;
			public var post_title:String;
			public var updated:String;				public function  PostsVO( obj:Object = null )		{						if ( obj != null )			{				
			this.created = obj["created"];
			this.id = obj["id"];
			this.post_content = obj["post_content"];
			this.post_title = obj["post_title"];
			this.updated = obj["updated"];			} 		}	}}       