<?php/**  * I am a object representing the @TABLE table. *  * this is your default copywrite, much better than before. * * @version CodeGen - 1.9.1 * @author CodeGen - Jonnie Spratley - http://code.google.com/p/flex-codegen/ * * @package com.demo.app.VO * @name PostsVO.php */class PostsVO{	/* Official boycott on amphp, because its trash */	//public $_explicitType = 'com.demo.app.vo.PostsVO';		
			public $id;
			public $title;
			public $body;
			public $created;		public function __construct(){}		public function mapObject( $vo )	{		
			$this->id = $vo["id"];
			$this->title = $vo["title"];
			$this->body = $vo["body"];
			$this->created = $vo["created"];	}		public function setNamespace( $namespace )	{		$this->explicitType = $namespace;	}		public function __get( $name )	{		return $this->$name;	}		public function __set( $name, $value )	{		$this->$name = $value;	}	}?>                                          