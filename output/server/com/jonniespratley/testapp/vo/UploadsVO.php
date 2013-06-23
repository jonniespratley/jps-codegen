<?php/**  * I am a object representing the @TABLE table. *  * Test app by jonnie spratley * * @version CodeGen - 1.9.1 * @author CodeGen - Jonnie Spratley - http://code.google.com/p/flex-codegen/ * * @package com.jonniespratley.testapp.VO * @name UploadsVO.php */class UploadsVO{	/* Official boycott on amphp, because its trash */	//public $_explicitType = 'com.jonniespratley.testapp.vo.UploadsVO';		
			public $id;
			public $name;
			public $path;
			public $size;
			public $type;		public function __construct(){}		public function mapObject( $vo )	{		
			$this->id = $vo["id"];
			$this->name = $vo["name"];
			$this->path = $vo["path"];
			$this->size = $vo["size"];
			$this->type = $vo["type"];	}		public function setNamespace( $namespace )	{		$this->explicitType = $namespace;	}		public function __get( $name )	{		return $this->$name;	}		public function __set( $name, $value )	{		$this->$name = $value;	}	}?>                                          