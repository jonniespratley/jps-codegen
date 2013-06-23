/**Your Copywrite information*/package com.project.codegentest.business{	import com.adobe.cairngorm.business.ServiceLocator;		import mx.rpc.AsyncToken;	import mx.rpc.IResponder;	import com.project.codegentest.vo.*;	public class ProjectsServiceDelegate	{		private var responder:IResponder;		private var service:Object;		public function ProjectsServiceDelegate( responder:IResponder )		{			this.service = ServiceLocator.getInstance().getHTTPService( "ProjectsService" );			this.responder = responder;		}				public function getAllProjects():void		{			var token:AsyncToken = service.send( {												m: 'get'												} );				 token.addResponder( responder );		}						public function saveProjects( vo:ProjectsVO ):void		{			var token:AsyncToken = service.send( {												m: 'save',																								} );				 token.addResponder( responder );		}					public function removeProjects( vo:ProjectsVO, index:int ):void		{			var token:AsyncToken = service.send( {												m: 'remove',																								} );				token.addResponder( responder );				token.vo = vo;				token.index = index;		}			}}                     