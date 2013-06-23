<?php/**  * I am a object representing the @TABLE table. *  * Test app by jonnie spratley * * @version CodeGen - 1.9.1 * @author CodeGen - Jonnie Spratley - http://code.google.com/p/flex-codegen/ * * @package com.jonniespratley.testapp.VO * @name PostsVO.php */class PostsVO{	/* Official boycott on amphp, because its trash */	//public $_explicitType = 'com.jonniespratley.testapp.vo.PostsVO';		
			public $created;
			public $id;
			public $post_content;
			public $post_title;
			public $updated;		public function __construct(){}		public function mapObject( $vo )	{		
			$this->created = $vo["created"];
			$this->id = $vo["id"];
			$this->post_content = $vo["post_content"];
			$this->post_title = $vo["post_title"];
			$this->updated = $vo["updated"];	}		public function setNamespace( $namespace )	{		$this->explicitType = $namespace;	}		public function __get( $name )	{		return $this->$name;	}		public function __set( $name, $value )	{		$this->$name = $value;	}	}?>                                          