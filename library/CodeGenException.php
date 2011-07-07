<?php

class CodeGenException extends Exception
{
	
	/**
	 * 
	 *@param message[optional] 
	 *@param code[optional] 
	 */
	public function __construct( $message, $code )
	{
		parent::__construct ( $message, $code );
		//TODO - Insert your code here
	}
	
	public function __toString()
	{
		return $this->cgMessage ();
	}
	
	private function cgMessage()
	{
		return 'You Fucked Up';
	}
}

try
{
	
	echo urldecode ( $_REQUEST );

}
catch ( CodeGenException $e )
{
	echo $e->__toString ();
}

?>