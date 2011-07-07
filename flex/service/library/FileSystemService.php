<?php

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
	
	public function browseDirectory( $aPath, $aResultFormat = '' )
	{
		$directoryHandle = opendir ( $aPath );
		
		while ( $file = readdir ( $directoryHandle ) )
		{
			//loop files
			$fileInfoArray [] = array ( 
				
					'aFilename' => $file, 
					'aSize' => filesize ( $file ), 
					'aCreated' => filemtime ( $file ), 
					'aType' => filetype ( $file ), 
					'aDatabase' => '', 
					'aPermissions' => decoct ( fileperms ( $file ) ), 
					'isDir' => ( is_dir ( $file ) ) ? 'true' : 'false', 
					'isFile' => ( is_file ( $file ) ) ? 'true' : 'false', 
					'isReadable' => ( is_readable ( $file ) ) ? 'true' : 'false', 
					'isWritable' => ( is_writable ( $file ) ) ? 'true' : 'false' 
			);
		}
		closedir ( $directoryHandle );
		
		return json_encode ( $fileInfoArray );
	}
	
	public function getDiskInfo( $aPath )
	{
		//disk information
		$diskInfoArray = array ( 
			'diskFreeSpace' => disk_free_space ( $aPath ), 'diskTotalSize' => disk_total_space ( $aPath ) 
		);
		
		return $diskInfoArray;
	}
	
	public function changePermissions( $whatDir, $aPermissions = 0755 )
	{
		// Everything for owner, read and execute for others
		$change = chmod ( $whatDir, $aPermissions );
		if ( $change )
		{
			return true;
		}
	
	}
	
	public function createDirectory( $aFolder, $aPermissions = 0777 )
	{
		$oldmask = umask ( 0 );
		$newPath = mkdir ( $aFolder, $aPermissions );
		
		umask ( $oldmask );
		if ( ! $newPath )
		{
			echo 'Error creating folders';
		}
		else
		{
			
			echo 'created';
		}
	}
	
	public function removeFile( $whatDir, $whatFile )
	{
		$filepath = "$whatDir/$whatFile";
		$this->changePermissions ( $filepath, 0777 );
		
		$removeFile = unlink ( $filepath );
		
		if ( $removeFile )
		{
			return "$whatFile was removed.";
		}
		return 'There was a problem removing the file.';
	}
	
	public function getFormattedDate( $aFile )
	{
		$newDate = date ( 'j F Y H:i', $aFile );
		
		return $newDate;
	}
	
	public function dump_var( $var )
	{
		print "<pre>\n";
		print_r ( $var );
		print "</pre>\n";
	}
}

?>