<?php
/**
 * This is a Sample Class
 *
 */
class SampleClass
{
	/**
	 * I dont have any arguments for this construstor
	 *
	 * @return SampleClass
	 */
	public function SampleClass()
	{
	
	}
	
	/**
	 * I am a sample test method, and I say hello
	 *
	 * @return string
	 */
	public function methodOne()
	{
		return 'No arguments in this method';
	}
	public function hello()
	{
		return 'You said hello';
	}
	
	
	/**
	 * I return your name
	 *
	 * @param unknown_type $name
	 * @return unknown
	 */
	public function sayMyName( $name )
	{
		return 'Your name is '.$name;
	}
	
	/**
	 * I return your age.
	 *
	 * @param [number] $age - Your fuckin age
	 * @return [string] 
	 */
	public function sayMyAge( $age )
	{
		return 'Your age is '.$age;
	}
	
	/**
	 * I say something about you.
	 *
	 * @param [string] $message - A shitty message
	 * @param [string] $from - From a guy
	 * @return [string]
	 */
	public function saySomething( $message, $from )
	{
		return 'You said '. $message. ' '. $from;
	}
	
	/**
	 * I am a method that has alot of parameters
	 *
	 * @param [string] $arg1 - Anything fancy
	 * @param [string] $arg2 - Anything nice
	 * @param [string] $arg3 - Your favorite color
	 * @param [string] $arg4 - Your moms name
	 * @param [string] $arg5 - Your moms age
	 * @return [string]
	 */
	public function shortStory( $person1, $person2, $person3, $person4 = 'Sue', $person5 = 'Grandpa' )
	{
	
		$message = "A person named $person1 was walking to the store, and they saw there friend $person2
		$person1 decided to stop and talk to $person2 for awhile.
		as they were talking $person3 came up behind $person1 and surprised $person1. Then $person4 and $person5 showed up to finally start the party.";
	
		return $message;
	}

}
?>