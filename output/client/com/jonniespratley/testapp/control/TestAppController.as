/**Test app by jonnie spratley*/package com.jonniespratley.testapp.control{	import com.jonniespratley.testapp.events.*;	import com.jonniespratley.testapp.commands.*;		import com.adobe.cairngorm.control.FrontController;	public final class TestAppController extends FrontController	{		public function TestAppController()		{			this.initialize();		}		private function initialize() : void		{		   
			this.addCommand( GetPostsEvent.GET_POSTS_EVENT, GetPostsCommand );
			this.addCommand( RemovePostsEvent.REMOVE_POSTS_EVENT, RemovePostsCommand );
			this.addCommand( SavePostsEvent.SAVE_POSTS_EVENT, SavePostsCommand );
			
			this.addCommand( GetUploadsEvent.GET_UPLOADS_EVENT, GetUploadsCommand );
			this.addCommand( RemoveUploadsEvent.REMOVE_UPLOADS_EVENT, RemoveUploadsCommand );
			this.addCommand( SaveUploadsEvent.SAVE_UPLOADS_EVENT, SaveUploadsCommand );
					}	}}       