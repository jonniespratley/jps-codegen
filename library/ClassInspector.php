<?php 
/**
 * @name  	ClassInspector.php
 * @author  Jonnie Spratley
 * @version 1.9
 */
class ClassInspector {
    public function __construct() {
    }
    
    /**
     * I get all of the methods and comments about a class.
     *
     * @param [string] $classfile - The file path of the file.
     * @return [array]
     */
    static public function inspectClass($classfile) {
        $classPath = pathinfo($classfile);
        
        $fileDir = $classPath['dirname'];
        $fileBase = $classPath['basename'];
        $fileClass = $classPath['filename'];
        $fileExt = $classPath['extension'];
        
        $fileLocation = $fileDir.DIRECTORY_SEPARATOR.$fileBase;

        //Need to include the file or it wont be found
        include_once ($fileLocation);
        
        $classArray = array();
        $classMethod = array();
        $classComments = '';
        
        //Create a new ReflectionClass of that class
        $reflection = new ReflectionClass($fileClass);
        
        //Get all the methods in the class
        $methods = $reflection->getMethods();
        //Get the Class doc comments
        $classComments = $reflection->getDocComment();
        
        //This creates an instance of: 
        //ReflectionFunction class, see documentation for all available methods
        foreach ($methods as $reflectionMethod) {
          
            //Set up the values
            $methodParams = array();
            $methodComments = '';
            
            //Make sure its public
            if ($reflectionMethod->isPublic()) 
            {
               
                //Make sure that we get the constructor comments
                if ($reflectionMethod->isConstructor()) {
                   
                    //Get the class Comments
                    $classComments .= $reflectionMethod->getDocComment();
                } 
                else {
                    
                    //Grab the method comments
                    $methodCommentArray = self::cleanComment( $reflectionMethod->getDocComment() );
                    
                    //Do some method checking
                    $isStatic = $reflectionMethod->isStatic() ? 'true' : 'false';
                    $isFinal = $reflectionMethod->isFinal() ? 'true' : 'false';
                    $isAbstract = $reflectionMethod->isAbstract() ? 'true' : 'false';
                    $methodNumParams = $reflectionMethod->getNumberOfParameters();
                    $methodNumRequiredParams = $reflectionMethod->getNumberOfRequiredParameters();
               
                    //Set the method name
                    $methodName = $reflectionMethod->getName();
                    
                    //Set the class name to be sure
                    $className = $reflectionMethod->getDeclaringClass()->getName();
                    
                    //Array of parameters
                    $reflectionParameterArray = $reflectionMethod->getParameters();
                    
                    //Loop the parameters for the method
                   
                    //This creates an instance of: 
                    //ReflectionParameter class, see documentation for all available methods
                        foreach ($reflectionParameterArray as $parameter) {
                      
                            //Set the name of the parameter
                            $paramName = $parameter->getName();
                        
                            //See if there is a default value for the parameter
                            $paramDefault = $parameter->isDefaultValueAvailable() ? $parameter->getDefaultValue() : '';
                            $paramType = '';
                            $paramType = $parameter->isArray() ? 'array' : 'object';
                       
                            //Build up the parameter array, with the name of the parameter, and there default values
                            $methodParams[] = array(
                                'paramName'=> $paramName, 
                                'paramDefault'=>$paramDefault, 
                                'paramType' => $paramType,
                                'paramOptional'=>$parameter->isOptional() ? 'true' : 'false', 'paramComment'=>'');
                   
                        } //ends param loop

                    
                    //Build up the method array, with the name of the class, method, comments, etc.
                    $classMethod[] = array(
                        'methodClass'=>$className, 
                        'methodName'=>$methodName, 
                        'methodParamCount'=>$methodNumParams, 
                        'methodRequiredParamCount'=>$methodNumRequiredParams, 
                        'methodComments'=>$methodCommentArray, 
                        'isFinal'=>$isFinal, 
                        'isStatic'=>$isStatic, 
                        'isAbstract'=>$isAbstract, 
                        'methodParams'=>$methodParams );
                    
                } //ends isConstructor()
            } //ends isPublic
        } //ends method loop

        
        //Finish it off with an array containing all of the information about the class.
        $classArray = array('className'=>$className, 'classFilename'=>$fileBase, 'classLocation'=>$fileLocation, 'classMethods'=>$classMethod, 'classComments'=>self::cleanComment($classComments));
        
        return $classArray;
    }
    
    /**
     * I call a user defined function in the provided class
     *
     * @param [string] $classFile - The full path including the file in which to call upon
     * @param [string] $method - The name of the method to invoke
     * @param [*] $arguments - The arguments that are required for the method
     * @return [array] - The result from the method call
     */
    static public function call($classFile, $method, $arguments = null) {
        if ($classFile) {
        
            //Include the file, which is the class we are going to be using
            include_once ($classFile);
            
            //Here we are getting the information about the file, this returns an array of containing the path, extension, filename, basename.
            $classInfo = pathinfo($classFile);
            
            //Set the class to the filename of the file from the pathinfo function, which returns the name of the file no extension or path, just ClassName,
            //And php defines classes by the same name as the file, so we can use this later
            $class = $classInfo['filename'];
            
            //Create a new instance of the $class, which is going to be ClassName, because we got only the nameof the file
            $classObj = new $class();
            $argArray = array();
            if ($arguments) {
                $argArray = explode(',', $arguments);
            }
            if (method_exists($classObj, $method)) {
                return call_user_func_array(array($classObj, $method), $argArray);
            }
            
        }
    }
    
    /**
     * Cleans the comment string by removing all comment start and end characters.
     *
     * @static
     * @private
     * @param $comment(String) The method's comment.
     */
    static public function cleanComment($comment) {
       
        $comment = str_replace("/**", "", $comment);
        $comment = str_replace("*/", "", $comment);
        $comment = str_replace("*", "", $comment);
        $comment = str_replace("\r", "", trim($comment));
        $comment = str_replace("", "", trim($comment));        
        $comment = eregi_replace("\n", "", trim($comment));
        $comment = str_replace("\n", "", trim($comment));
        $comment = eregi_replace("[\t]+", " ", trim($comment));
        $comment = str_replace("\"", "\\\"", $comment);
       
        #$comments = explode( "@", $comment );
       
        return $comment;        
    }
    
}


/*=====================================================Class testing ====================================
 *


$classfile = 'Utilities.php';
$func = '';
$args = array();
$request[] = ClassInspector::inspectClass($classfile);

echo json_encode($request);
//print_r($request);


/*=====================================================Class testing ====================================*/
?>
