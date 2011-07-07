<?php
/**
 * @name  	FileSystemService.php
 * @author  Jonnie Spratley
 * @version 1.9
 * 
 */

class FileSystemService
{
	private $filename;
	private $filepath;
	
	public function __construct()
	{
		error_reporting ( E_ERROR | E_USER_ERROR | E_PARSE );
	}
	
	/**
	 * @return unknown
	 */
	public function getFilename()
	{
		return $this->filename;
	}
	
	/**
	 * @param unknown_type $filename
	 */
	public function setFilename( $filename )
	{
		$this->filename = $filename;
	}
	
	/**
	 * @return unknown
	 */
	public function getFilepath()
	{
		return $this->filepath;
	}
	
	/**
	 * @param unknown_type $filepath
	 */
	public function setFilepath( $filepath )
	{
		$this->filepath = $filepath;
	}
	
	/**
	 * I browse the directory 
	 *
	 * @param [string] $aPath Path of which directory
	 * @return [array]
	 */
	public function browseDirectory( $path = '.', $level = 0, $jsonEncode )
	{
		// Directories to ignore when listing output. Many hosts will deny PHP access to the cgi-bin.
		$ignore = array ( 
			'cgi-bin', '.', '..', '.DS_Store', '.svn' 
		);
		
		// Open the directory to the handle $dh
		$dh = opendir ( $path );
		
		$folders = array ();
		
		// Loop through the directory
		while ( false !== ( $file = readdir ( $dh ) ) )
		{
			//get the extension from the filename
			$ext = substr ( strrchr ( $file, '.' ), 1 );
			
			// Check that this file is not to be ignored
			if ( ! in_array ( $file, $ignore ) )
			{
				$fullPath = "$path/$file";
				// Its a directory, so we need to keep reading down...
				if ( is_dir ( "$path/$file" ) )
				{
					//$pathInfo = pathinfo( $file );
					

					// Re-call this same function but on a new directory.this is what makes function recursive.
					$folders [] = array ( 
						
							'filename' => $file, 
							'path' => $fullPath, 
							//'filePath' => , 
							'ext' => $ext, 
							'isDir' => ( is_dir ( $fullPath ) ) ? 'true' : 'false', 
							'isFile' => ( is_file ( $fullPath ) ) ? 'true' : 'false', 
							'isWritable' => ( is_writable ( $fullPath ) ) ? 'true' : 'false', 
							'isReadable' => ( is_readable ( $fullPath ) ) ? 'true' : 'false', 
							'children' => $this->browseDirectory ( $fullPath, $level + 1 ) 
					);
					
					rsort ( $folders );
				}
				else
				{
					
					$folders [] = array ( 
						
							'filename' => $file, 
							'path' => "$path/$file", 
							//'filePath' => pathinfo( $file ), 
							'ext' => $ext, 
							'isDir' => ( is_dir ( $fullPath ) ) ? 'true' : 'false', 
							'isFile' => ( is_file ( $fullPath ) ) ? 'true' : 'false', 
							'isWritable' => ( is_writable ( $fullPath ) ) ? 'true' : 'false', 
							'isReadable' => ( is_readable ( $fullPath ) ) ? 'true' : 'false' 
					);
				#	sort ( $folders );
				}
			}
		}
		
		closedir ( $dh );
		
		return $folders;
	}
	
	public function browseSubDirectory( $folder )
	{
		$subdirArray = array ();
		$subDirHandle = opendir ( $folder );
		{
			while ( false !== ( $file = readdir ( $subDirHandle ) ) )
			{
				if ( $file != '.' && $file != '..' )
				{
					$subdirArray [] = array ( 
						'label' => $file 
					);
				}
			
			}
			closedir ( $subDirHandle );
		}
		return $subdirArray;
	}
	
	/**
	 * I get the disk information
	 *
	 * @param [string] $aPath the path
	 * @return [array]
	 */
	public function getDiskInfo( $aPath )
	{
		$diskInfoArray = array ( 
			'freeSpace' => disk_free_space ( $aPath ), 'totalSize' => disk_total_space ( $aPath ) 
		);
		
		return $diskInfoArray;
	}
	
	/**
	 * I change the permissions on a file, or directory
	 *
	 * @param [string] $whatDir the directory
	 * @param [int] $aPermissions the permissions
	 * @return [boolean]
	 */
	public function changePermissions( $whatDir, $aPermissions )
	{
		
		if ( ! $aPermissions )
		{
			$aPermissions = 0777;
		}
		$change = false;
		// Everything for owner, read and execute for others

		if ( chmod ( $whatDir, $aPermissions ) )
		{
			$change = true;
		}
		
		return $change;
	}
	
	/**
	 * I write to a file
	 *
	 * @param [string] $filename the file name
	 * @param [string] $contents file contents
	 */
	static public function writeFile( $filename, $contents )
	{
		self::recursiveChmod($filename, 0777, 0777);
		$fp = fopen ( $filename, 'w' );
		
		//make sure file is writable
		//chmod ( $filename );
		$result = array ( 
			'file' => $filename 
		);
		
		$written = fwrite ( $fp, $contents );
		if ( $written )
		{
			return $result;
		}
		
		fclose ( $fp );
		
		return $filename;
	}
	
	static public function appendFile( $filename, $contents )
	{
		
		$fp = fopen ( $filename, 'a' );
		//make sure file is writable
		//chmod ( $filename );
		$result = array ( 
			'file' => $filename 
		);
		
		$written = fwrite ( $fp, $contents."\n" );
		if ( $written )
		{
			return $result;
		}
		
		fclose ( $fp );
		
		return $filename;
	}
	
	static public function readFile( $file )
	{
		$data = '';
		//$contents = array ();
		if ( is_file ( $file ) )
		{
			
			$fp = fopen ( $file, 'r' );
			
			//make sure file is readable
			//chmod ( $filename, 0755 );
			

			if ( ! $fp )
			{
				echo 'File could not be opened';
				exit ();
			}
			
			while ( ! feof ( $fp ) )
			{
				//$contents = array ( 'contents' => fgets ( $fp, 9999 ));
				$data .= fgets ( $fp, 9999 );
				//dump the contents into an array
			}
			
			fclose ( $fp );
		}
		return $data;
	}
	
	/**
	 * I create a directory
	 *
	 * @param [string] $aFolder name of the folder
	 * @param [int] $aPermissions the permissions
	 */
	public function createDirectory( $aFolder, $aPermissions = 0755 )
	{
		$oldmask = umask ( 0 );
		$newPath = mkdir ( $aFolder, $aPermissions );
		$message = '';

		umask ( $oldmask );
		
		if ( ! $newPath )
		{
			$message = 'Error creating ' . $newPath;
		}
		else
		{
			$message = 'Created' . $newPath;
		}
		return $message;
	}
	
	/**
	 * I remove a file
	 *
	 * @param [string] $whatDir
	 * @param [string] $whatFile
	 * @return [string]
	 */
	public function removeFile( $whatDir, $whatFile )
	{
		$filepath = "$whatDir/$whatFile";
		$this->changePermissions ( $filepath, 0777 );
		
		$removeFile = unlink ( $filepath );
		$message = '';
		if ( ! $removeFile )
		{
			$message = 'There was a problem removing the file.';
		}
		else
		{
			$message = "$whatFile was removed.";
		}
		return $message;
	}
	
	public function escapeContents( $contents )
	{
		return htmlspecialchars ( $contents );
	}
	
	private function getFormattedDate( $aFile )
	{
		$newDate = date ( 'j F Y H:i', $aFile );
		
		return $newDate;
	}
	
	public function getDirectory( $path = '.', $level = 0 )
	{
		// Directories to ignore when listing output. Many hosts will deny PHP access to the cgi-bin.
		$ignore = array ( 
			'cgi-bin', '.', '..' 
		);
		
		// Open the directory to the handle $dh
		$dh = opendir ( $path );
		
		$folders = array ();
		$subFolders = array ();
		
		// Loop through the directory
		while ( false !== ( $file = readdir ( $dh ) ) )
		{
			// Check that this file is not to be ignored
			if ( ! in_array ( $file, $ignore ) )
			{
				// Its a directory, so we need to keep reading down...
				if ( is_dir ( "$path/$file" ) )
				{
					// Re-call this same function but on a new directory.this is what makes function recursive.
					$folders [] = array ( 
						'label' => $file, 'path' => "$path/$file", 'children' => $this->getDirectory ( "$path/$file", $level + 1 ) 
					);
				}
				else
				{
					$folders [] = array ( 
						'label' => $file 
					);
				}
			}
		}
		closedir ( $dh );
		return $folders;
	}
	
	public function compressFile( $filename )
	{
		$zipfile = "$filename.zip";
		
		//Load file
		$data = file_get_contents ( $filename );
		
		//compress file
		file_put_contents ( "compress.zlib://$zipfile", $data );
		
		return $zipfile;
	}
	
	/**
	 * I recursivly copy files/folders/contents to a destination.
	 *
	 * @param [string] $dirsource - The source
	 * @param [string] $dirdest - The destination
	 * @return true
	 */
	static public function recursiveCopy( $dirsource, $dirdest )
	{
		if ( is_dir ( $dirsource ) )
		{
			$dir_handle = opendir ( $dirsource );
		}
		$dirname = substr ( $dirsource, strrpos ( $dirsource, "/" ) + 1 );
		
		mkdir ( $dirdest . "/" . $dirname, 0777 );
		
		while ( $file = readdir ( $dir_handle ) )
		{
			if ( $file != "." && $file != ".." )
			{
				if ( ! is_dir ( $dirsource . "/" . $file ) ) copy ( $dirsource . "/" . $file, $dirdest . "/" . $dirname . "/" . $file );
				else
				{
					$dirdest1 = $dirdest . "/" . $dirname;
					self::recursiveCopy ( $dirsource . "/" . $file, $dirdest1 );
				}
			}
		}
		closedir ( $dir_handle );
		
		return true;
	}
	
	static public function chmodr( $path, $filemode = 0775) { 
	    if (!is_dir($path)) 
	        return chmod($path, $filemode); 

	    $dh = opendir($path); 
	    while (($file = readdir($dh)) !== false) { 
	        if($file != '.' && $file != '..') { 
	            $fullpath = $path.'/'.$file; 
	            if(is_link($fullpath)) 
	                return FALSE; 
	            elseif(!is_dir($fullpath) && !chmod($fullpath, $filemode)) 
	                    return FALSE; 
	            elseif(!self::chmodr($fullpath, $filemode)) 
	                return FALSE; 
	        } 
	    } 

	    closedir($dh); 

	    if(chmod($path, $filemode)) 
	        return TRUE; 
	    else 
	        return FALSE; 
	}
	
	/**
	 * I recursively move all files in a source to a destination
	 *
	 * @param [string] $dirsource - The source to move
	 * @param [string] $dirdest - The destination where new files will be moved
	 */
	static public function recursiveMove( $dirsource, $dirdest )
	{
		if ( is_dir ( $dirsource ) )
		{
			$dir_handle = opendir ( $dirsource );
		}
		
		$dirname = substr ( $dirsource, strrpos ( $dirsource, "/" ) + 1 );
		
		mkdir ( $dirdest . "/" . $dirname, 0777 );
		
		while ( $file = readdir ( $dir_handle ) )
		{
			if ( $file != "." && $file != ".." )
			{
				if ( ! is_dir ( $dirsource . "/" . $file ) )
				{
					copy ( $dirsource . "/" . $file, $dirdest . "/" . $dirname . "/" . $file );
					unlink ( $dirsource . "/" . $file );
				}
				else
				{
					$dirdest1 = $dirdest . "/" . $dirname;
					self::recursiveMove ( $dirsource . "/" . $file, $dirdest1 );
				}
			}
		}
		closedir ( $dir_handle );
		rmdir ( $dirsource );
	}
	/**
      Chmods files and folders with different permissions.

      This is an all-PHP alternative to using: \n

      @param $path An either relative or absolute path to a file or directory
      which should be processed.
      @param $filePerm The permissions any found files should get.
      @param $dirPerm The permissions any found folder should get.
      @return Returns TRUE if the path if found and FALSE if not.
      @warning The permission levels has to be entered in octal format, which
      normally means adding a zero ("0") in front of the permission level. \n
      More info at: http://php.net/chmod.
   */

   static public function recursiveChmod($path, $filePerm=0755, $dirPerm=0755)
   {
      // Check if the path exists
      if(!file_exists($path))
      {
         return(FALSE);
      }
      // See whether this is a file
      if(is_file($path))
      {
         // Chmod the file with our given filepermissions
         chmod($path, $filePerm);
      // If this is a directory...
      } elseif(is_dir($path)) {
         // Then get an array of the contents
         $foldersAndFiles = scandir($path);
         // Remove "." and ".." from the list
         $entries = array_slice($foldersAndFiles, 2);
         // Parse every result...
         foreach($entries as $entry)
         {
            // And call this function again recursively, with the same permissions
            self::recursiveChmod($path."/".$entry, $filePerm, $dirPerm);
         }
         // When we are done with the contents of the directory, we chmod the directory itself
         chmod($path, $dirPerm);
      }
      // Everything seemed to work out well, return TRUE
      return(TRUE);
   }
	
	

}

?>