/**Your Copywrite information*/package com.project.codegentest.control{	import com.project.codegentest.events.*;	import com.project.codegentest.commands.*;		import com.adobe.cairngorm.control.FrontController;	public final class TestController extends FrontController	{		public function TestController()		{			this.initialize();		}		private function initialize() : void		{		   
			this.addCommand( GetContactsEvent.GET_CONTACTS_EVENT, GetContactsCommand );
			this.addCommand( RemoveContactsEvent.REMOVE_CONTACTS_EVENT, RemoveContactsCommand );
			this.addCommand( SaveContactsEvent.SAVE_CONTACTS_EVENT, SaveContactsCommand );
			
			this.addCommand( GetProjectsEvent.GET_PROJECTS_EVENT, GetProjectsCommand );
			this.addCommand( RemoveProjectsEvent.REMOVE_PROJECTS_EVENT, RemoveProjectsCommand );
			this.addCommand( SaveProjectsEvent.SAVE_PROJECTS_EVENT, SaveProjectsCommand );
					}	}}       