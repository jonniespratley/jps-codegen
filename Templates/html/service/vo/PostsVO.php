<?php/**My Test Application*//**  * I am a object representing the @TABLE table. *  * @version CodeGen - 1.8 * @author CodeGen - Jonnie Spratley (http://jonniespratley.com/code) * * @package com.domain.project.VO * @name PostsVO.php */class PostsVO{	/* Official boycott on amphp, because its trash */	//public $_explicitType = 'com.domain.project.vo.PostsVO';		
			public $body;
			public $date;
			public $id;
			public $title;
			public $user_id;		public function __construct(){}		public function mapObject( $vo )	{		
			$this->body = $vo["body"];
			$this->date = $vo["date"];
			$this->id = $vo["id"];
			$this->title = $vo["title"];
			$this->user_id = $vo["user_id"];	}		public function setNamespace( $namespace )	{		$this->explicitType = $namespace;	}		public function __get( $name )	{		return $this->$name;	}		public function __set( $name, $value )	{		$this->$name = $value;	}	}?>                                          