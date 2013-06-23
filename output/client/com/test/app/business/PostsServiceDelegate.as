/**This is a sample application.*/package com.test.app.business{	import com.adobe.cairngorm.business.ServiceLocator;		import mx.rpc.AsyncToken;	import mx.rpc.IResponder;	import com.test.app.vo.*;	public class PostsServiceDelegate	{		private var responder:IResponder;		private var service:Object;		public function PostsServiceDelegate( responder:IResponder )		{			this.service = ServiceLocator.getInstance().getHTTPService( "PostsService" );			this.responder = responder;		}				public function getAllPosts():void		{			var token:AsyncToken = service.send( {												m: 'get'												} );				 token.addResponder( responder );		}						public function savePosts( vo:PostsVO ):void		{			var token:AsyncToken = service.send( {												m: 'save',																								} );				 token.addResponder( responder );		}					public function removePosts( vo:PostsVO, index:int ):void		{			var token:AsyncToken = service.send( {												m: 'remove',																								} );				token.addResponder( responder );				token.vo = vo;				token.index = index;		}			}}                     