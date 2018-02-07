<!-- echo php_file_tree("/home/sparky/uploads/", "javascript:alert('You clicked on [link]');"); -->

<!-- 
Use $return_link to specify the action you want done when the user clicks on a file name. Use [link] as the placeholder for the filename. For example,

    php_file_tree("your_dir/", "http://example.com/?url=[link]");

would send the user to http://example.com/?url=filename.ext
-->

<?php

function php_file_tree($directory, $return_link, $extensions = array()) { // assign an empty array to $extensions variable	
	// Remove trailing slash; The substr() function returns a part of a string; substr(string,start,length);
    // Start (negative number) at a specified position from the end of the string
	if( substr($directory, -1) == "/" ) $directory = substr($directory, 0, strlen($directory) - 1); // decrease length by 1
    // this turns /home/sparky/uploads/ into this /home/sparky/uploads
	$code .= php_file_tree_dir($directory, $return_link, $extensions);
	return $code;
}

// Recursive function called by php_file_tree() to list directories/files
function php_file_tree_dir($directory, $return_link, $extensions = array(), $first_call = true) {
		
	// Get and sort directories/files
	if( function_exists("scandir") ) $file = scandir($directory); // this function does not exist
    else $file = php4_scandir($directory);// this does exist and is the last function on this page
    // it passes the value of the $directory variable, and the function will return the list of files to the $file variable
    
    // The natcasesort() function sorts an array by using a "natural order" algorithm. The values keep their original keys.
    //in a natural algorithm, the number 2 is less than the number 10. In computer sorting, 10 is less than 2, because the first number in "10" is less than 2.
    //this function is case-insensitive.
    //this function returns TRUE on success, or FALSE on failure.    
	natcasesort($file);
    
	// Make directories first
	$files = $dirs = array();// this sets two variables at the same time; like this: $a = $b = $c = $d = array();
    
	foreach($file as $this_file) {// for each file that is in the array
        // The is_dir() function checks whether the specified file is a directory.
        // This function returns TRUE if the directory exists.
        // $directory/$this_file = /home/sparky/uploads/xxxxx.xml
        // if it is a dir, add it to the $dirs array, else add it to the $files array
		if( is_dir("$directory/$this_file" ) ) $dirs[] = $this_file; else $files[] = $this_file;
	}
    // merge two arrays into one, directories first
	$file = array_merge($dirs, $files);
	
	// Filter unwanted extensions
	if( !empty($extensions) ) { // if extensions is NOT empty
		foreach( array_keys($file) as $key ) { // array_keys returns just the keys of the merged array, not the values
			if( !is_dir("$directory/$file[$key]") ) {
				$ext = substr($file[$key], strrpos($file[$key], ".") + 1); 
				if( !in_array($ext, $extensions) ) unset($file[$key]);
			}
		}
	}
	
	if( count($file) > 2 ) { // Return the number of elements in an array: Use 2 instead of 0 to account for . and .. "directories"
        // start building the HTML markup
		$php_file_tree = "<ul";
        if( $first_call ) { // if $first_call is TRUE
            $php_file_tree .= " class=\"php-file-tree\""; $first_call = false; }
            $php_file_tree .= ">";
		foreach( $file as $this_file ) {
			if( $this_file != "." && $this_file != ".." ) {
				if( is_dir("$directory/$this_file") ) {// if it's a directory
					// Directory
					$php_file_tree .= "<li class=\"pft-directory\"><a href=\"#\">" . htmlspecialchars($this_file) . "</a>";
					$php_file_tree .= php_file_tree_dir("$directory/$this_file", $return_link ,$extensions, false);
					$php_file_tree .= "</li>";
				} else {// it's not a directory, so it must be a file
					// Get extension (prepend 'ext-' to prevent invalid classes from extensions that begin with numbers)
					$ext = "ext-" . substr($this_file, strrpos($this_file, ".") + 1); 
					$link = str_replace("[link]", "$directory/" . urlencode($this_file), $return_link);
                    // wrap in a form tag so it can be submitted to the summary.php page and parsed into a twiz sheet
					$php_file_tree .= "<form action='scripts/test.php' method='post' enctype='multipart/form-data' target='_blank'>";
                    $php_file_tree .= "<input type='hidden' name='cardarchive' value='" . htmlspecialchars($this_file) . "'><br>";
                    $php_file_tree .= "<button type='submit' class='btn btn-success btn-u-md'><i class='fa fa-file-text-o'></i>" . htmlspecialchars($this_file) . "</button>";
                    $php_file_tree .= "</form>";
					$php_file_tree .= php_file_tree_dir("$directory/$this_file", $return_link ,$extensions, false);
				}
			}
		}
		$php_file_tree .= "</ul>";
	}
	return $php_file_tree;
}

// For PHP4 compatibility
function php4_scandir($dir) { // /home/sparky/uploads
	$dh  = opendir($dir);// Open a directory, read its contents, then close
	while( false !== ($filename = readdir($dh)) ) {
	    $files[] = $filename; // this is the short syntax for array creation; files are read and added to the array
	}
	sort($files); // sort the array low to high
	return($files); // return the array to the calling code
}
