<?php defined('BASEPATH') || exit('No direct script access allowed');

if (! function_exists('createFolder')) {

	function createFolder($embedName, $templateFileName){
		mkdir(config_item('smartembed_static_site_location'). $embedName, 0755);
		$zip = new ZipArchive;
	
		if ($zip->open(config_item('smartembed_template_location'). $templateFileName) === TRUE) {
		    $zip->extractTo(config_item('smartembed_static_site_location'). $embedName);
		    $zip->close();				    
		}
	}
}
if (! function_exists('copyFolder')) {

	function copyFolder($src,$dst){
	
		$dir = opendir($src); 
	    @mkdir($dst); 
		    while(false !== ( $file = readdir($dir)) ) { 
		        if (( $file != '.' ) && ( $file != '..' )) { 
		            if ( is_dir($src . '/' . $file) ) { 
		                copyFolder($src . '/' . $file,$dst . '/' . $file); 
		            } 
		            else { 
		                copy($src . '/' . $file,$dst . '/' . $file); 
		            } 
		        } 
		    } 
	    	closedir($dir); 

		}
}
if (! function_exists('getFolderURL')) {

	function getFolderURL($embedName){
		return config_item('smartembed_static_site_location'). $embedName;
	}
	
}

if (! function_exists('deleteFile')) {

	function deleteFile($deletePath){
		$is_file_delete = false;
		if(file_exists($deletePath)){
	        if(unlink($deletePath)){
	        	$is_file_delete = true;				        
	        }
	        else{ 
	            $is_file_delete = false;
	        }

	    }
	    else{       //if file not exist
	    	$is_file_delete = false;
	    }
	    return $is_file_delete;
	}
	
}

if (! function_exists('deleteFolderAndAllFiles')) {

	function deleteFolderAndAllFiles($deletePath){
		$is_file_delete = false;
		if(file_exists($deletePath)){
			
			delete_files($deletePath, true);
			@closedir($deletePath);
	        if(rmdir($deletePath)){
	        	$is_file_delete = true;				        
	        }
	        else{ 
	            $is_file_delete = false;
	        }

	    }
	    else{       //if file not exist
	    	$is_file_delete = false;
	    }
	    return $is_file_delete;
	}	
}


?>