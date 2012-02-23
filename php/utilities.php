<?php
// Keeps a smorgasbord of utilties for my coaching web site.

// Create a random object id of the form xxxxx-xxxxx-xxxxx-xxxxx.
function getObjectID()
{
	$objectID = "";
	
	for ( $i=1; $i<21; $i++ )
	{
		$objectID .= chr(mt_rand(97,122));
		if ( $i < 20 && ( $i%5 ) == 0 )
			$objectID .= "-";
	}
	
	return $objectID;
	
}


// This function simply reads a file.  The name reflects the fact that the caller expects the file to be in XML format.
function readXML($filename) {
	$fHandle = fopen($filename, 'r');
	if ( !fHandle ) {
		return "File not found.";
	}
	
	$blockSize = 4 * 1024;
	while ( $data = fread($fHandle, $blockSize)) {
		$XML .= $data;
	}
	fclose($fHandle);
	return $XML;
}


// Work with docplus to create files.
function readAndFilter($filename, $finalFile, $structure) {
	$fHandle = fopen($filename, 'r');
	$tHandle = fopen($finalFile, 'w');
	if ( !fHandle || !$tHandle) {
		return "File not found.";
	}
	
	$blockSize = 4 * 1024;
	$count = 0;
	$counting = 0;
	fwrite($tHandle, HTMLheader());
	while ( $data = fgets($fHandle, $blockSize)) {
		if (  $count < 2 ) {
			$command = strpos($data, "/*+");
			if ( !($command === false) )
				$command = true;
			
			switch ( $command ) {
				case true:
					$commObj = docFactory($data);
					if ( strlen($commObj->onTheSpot()) > 5 ) {
						$data = "<span class=\"command\">".$commObj->onTheSpot()."</span><br />\n";
						fwrite($tHandle, $data);
					}
					$structure->add($commObj);
					break;
					
				case false:					
					if ( count(split("//", $data)) > 1 )
						$data = "<span class=\"comment\">".$data;
					else
						$data = "<span class=\"code\">".$data;
					$data = $data."</span><br />";
					fwrite($tHandle, $data);
					break;
					
			}
		}
		$count += bracketCounter($data);	
	}
	fwrite($tHandle, HTMLfooter());
	fclose($fHandle);
	fclose($tHandle);
	
	$path_parts = pathinfo($filename);
	$filename = str_replace(".js", ".html", $filename);
	$filename = str_replace("c:/xampp/htdocs/", "../../", $filename);
	return "Successful completion for <a href='$filename'>{$path_parts['filename']}</a>.<br />\n";
}

// Count the open braces and plus one and the close braces as minus one.  Return the count.
function bracketCounter($str) {
	$ndx = 0;
	$counter = count(split("{", $str))-1;
	$counter -= count(split("}", $str))-1;
	return $counter;	
}

// Create an HTML header to go prior to any code lines in the file.
function HTMLheader() {
	$str = "<html>\n";
	$str .= "<head>\n";
	$str .= "<title>Coachsez Documentation.</title>\n";
	$str .= "<style>\n";
	$str .= "    .comment { color : green; }\n";
	$str .= "</style>\n";
	$str .= "</head>\n";
	$str .= "<body>\n";
	return $str;
}

// Finish off the HTML file.
function HTMLfooter() {
	$str = "</body>\n";
	$str .= "</html>\n";
	return $str;
}




// Check the masterID table to see if an id is present,  If so, return the table the id is located in.  If not, return false.
function lookUpInMaster( $oid ) {

	$query = "select tableName from masterID where object_ID = '".$oid."'";
	testDescription($query);
	$result = mysql_query($query);
	if ( $result_row = mysql_fetch_array($result, MYSQL_ASSOC) ) {
		return $result_row['tableName'];
	}
	else {
	    return false;
	}

}		



?>