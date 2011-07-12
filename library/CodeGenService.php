<?php
require_once 'CairngormGen.php';
require_once 'FileSystemService.php';
require_once 'FlexGen.php';
require_once 'HTMLGen.php';
require_once 'EclipseGen.php';
require_once 'PHPGen.php';
require_once 'Utilities.php';
class CodeGenService {

	private $phpGen;
	private $cairngormGen;
	private $flexGen;
	private $htmlGen;
	private $classGen;
	private $eclipseGen;
	private $options;
	private $utils;

	public function __construct($opts = array()) {
		ini_set("memory_limit", "25M");
		$postsFields = array( array('name' => 'id',
			'type' => 'int',
			'alias' => 'postId'),
			array('name' => 'title',
				'type' => 'string',
				'alias' => 'postTitle'),
			array('name' => 'body',
				'type' => 'string',
				'alias' => 'postBody'),
			array('name' => 'users_id',
				'type' => 'int',
				'alias' => null),
			array('name' => 'categorys_id',
				'type' => 'int',
				'alias' => null),
			array('name' => 'tags_id',
				'type' => 'int',
				'alias' => null),
			array('name' => 'created',
				'type' => 'datetime',
				'alias' => 'postCreated'));
		$categorysFields = array( array('name' => 'id',
			'type' => 'int',
			'alias' => null),
			array('name' => 'category',
				'type' => 'string',
				'alias' => null),
			array('name' => 'users_id',
				'type' => 'int',
				'alias' => null));
		$usersFields = array( array('name' => 'id',
			'type' => 'int',
			'alias' => null),
			array('name' => 'name',
				'type' => 'string',
				'alias' => null),
			array('name' => 'email',
				'type' => 'string',
				'alias' => null),
			array('name' => 'created',
				'type' => 'datetime',
				'alias' => null));
		$tagsFields = array( array('name' => 'id',
			'type' => 'int',
			'alias' => null),
			array('name' => 'tag',
				'type' => 'string',
				'alias' => null),
			array('name' => 'user_id',
				'type' => 'int',
				'alias' => null));

		$this -> options = $opts;

		$this -> utils = new Utilities();
		$this -> phpGen = new PHPGen($this -> options);
		$this -> flexGen = new FlexGen($this -> options);
		$this -> htmlGen = new HTMLGen($this -> options);
		$this -> eclipseGen = new EclipseGen($this -> options);
		$this -> cairngormGen = new CairngormGen($this -> options);
	}

	/* #######################################
	 * PHPGen Functions
	 * 1. generateBaseService(table:string, fields:array) -
	 * 2. generateRESTService(tables:array) -
	 * 3. generateValueObject(table:string, fields:array) -
	 * 4. writeConnection -
	 * ####################################### */

	public function phpGen_genValueObject($table =null, $fields =null) {
		//TODO: This is here for testing, remove before using
		#return $this->phpGen->generateValueObject($table, $this->options['tables'][3]['fields']);
		return $this -> phpGen -> generateValueObject($table, $fields);
	}

	public function phpGen_genBaseService($table =null, $fields =null) {
		//TODO: This is here for testing, remove before using
		#return $this->phpGen->generateBaseService($table, $this->options['tables'][3]['fields']);
		return $this -> phpGen -> generateBaseService($table, $fields);
	}

	public function phpGen_genRESTService($tables =null) {
		//TODO: This is here for testing, remove before using
		return $this -> phpGen -> generateRESTService($tables);
	}

	/* #######################################
	 * FlexGen Functions
	 * 1. generateApplication(tables:array) -
	 * 2. generateForm(table:string, fields:array) -
	 * 3. generateList(table:string, fields:array) -
	 * 4. generateRESTService(tables:array) -
	 * 5. generateTableMain(table:string) -
	 * 6. generateValueObject(table:string, fields:array) -
	 * ####################################### */

	/* #######################################
	 * CairngormGen Functions
	 * 1. generateController -
	 * 2. generateDelegate -
	 * 3. generateServiceLocator -
	 * 4. generateModelLocator -
	 * 5. generateValueObject -
	 * 6. generateSaveEvent -
	 * 7. generateSaveCommand -
	 * 8. generateRemoveEvent -
	 * 9. generateRemoveCommand -
	 * 10. generateGetEvent -
	 * 11. generateGetCommand -
	 * ####################################### */

	public function flexGen_genAmfphpService($tables =null, $fields =null) {
		return $this -> flexGen -> generateAMFPHPService($tables, $fields);
	}

	public function flexGen_genValueObject($table =null, $fields =null) {
		//TODO: This is here for testing, remove before using
		#return $this->flexGen->generateValueObject($table, $this->options['tables'][3]['fields']);
		return $this -> flexGen -> generateValueObject($table, $fields);
	}

	public function flexGen_genTableForm($table =null, $fields =null) {
		//TODO: This is here for testing, remove before using
		#return $this->flexGen->generateForm($table, $this->options['tables'][3]['fields']);
		return $this -> flexGen -> generateForm($table, $fields);
	}

	public function flexGen_genTableMain($table =null) {
		#return $this->flexGen->generateTableMain($table);
		return $this -> flexGen -> generateTableMain($table);
	}

	public function flexGen_genTableList($table =null, $fields =null) {
		#return $this->flexGen->generateList($table, $this->options['tables'][3]['fields']);
		return $this -> flexGen -> generateList($table, $fields);
	}

	public function flexGen_genRestService($tables =null, $fields =null) {
		# return $this->flexGen->generateRESTService($table, $this->options['tables'][3]['fields']);
		return $this -> flexGen -> generateRESTService($tables, $fields);
	}

	public function flexGen_genApplication($tables =null) {
		return $this -> flexGen -> generateApplication($tables);
	}

	public function getOptions() {
		return $this -> options;
	}

}

class Options {

	public $database;
	public $host;
	public $user;
	public $pass;

	public $application;
	public $copywrite;
	public $framework;
	public $namespace;
	public $endpoint;
	public $path;
	public $tables;

	public function __construct($obj) {
		if($obj != null) {
			$this -> database = $obj['database'];
			$this -> host = $obj['host'];
			$this -> user = $obj['user'];
			$this -> pass = $obj['pass'];
			$this -> application = $obj['application'];
			$this -> copywrite = $obj['copywrite'];
			$this -> framework = $obj['framework'];
			$this -> namespace = $obj['namespacee'];
			$this -> endpoint = $obj['endpoint'];
			$this -> path = $obj['path'];
			foreach($obj['tables'] as $table) {
				$this -> tables[] = new Table($table);
			}
		}
	}

}

class Table {
	public $name;
	public $fields;
	public $key;
	public function __construct($obj) {
		if($obj != null) {
			$this -> name = $obj['name'];
			$this -> key = $obj['key'];
			foreach($obj['fields'] as $field) {
				$this -> fields[] = new Field($field);
			}
		}
	}

}

class Field {
	public $name;
	public $type;
	public $nullable;
	public $defaultt;
	public $comments;
	public function __construct($obj) {
		if($obj != null) {
			$this -> name = $obj['name'];
			$this -> type = $obj['type'];
			$this -> nullable = $obj['nullable'];
			$this -> defaultt = $obj['defaultt'];
			$this -> comments = $obj['comments'];
		}
	}

}

 
?>
