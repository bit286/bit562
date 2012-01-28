<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>fileReader.php Test</title>
		<script src="http://code.jquery.com/jquery-1.7.1.js" type="text/javascript" ></script>
		<script>
		$(document).ready(function(){$(".fnBlock").click(function() {$(this).toggle();});});
		</script>
        <style>
           .comment { color: red; }
		   
        </style>
    </head>
    <body>
        <?php
        
             require_once('../Indentation.php');
             
             $position = 0;
             $braceCounter = 0;
             
             // See if you can open the named file
             $fileName = 'test.js';
             $testPath = is_file($fileName);            
             $fileHandle = fopen($fileName, 'r');
             
             // Go through the file line by line.
             while (!feof($fileHandle)) {
               $suffix = "";
               $prefix = "";
                
               $firstLine = fgets($fileHandle);
               
               if (substr($firstLine, 0, 2) === "//") {
                  $prefix = '<span class="comment">';
                  $suffix = '</span>';
               }
               
               // Look for an open brace in the line.
               $lineOut = $prefix.$firstLine.$suffix;
               $prefix .= createIndentationHTML($lineOut, $braceCounter);
               $position = 0;
               while (strpos($lineOut, "{", $position) > -1) {
                  $position = strpos($lineOut, "{", $position) + 1;
                  $braceCounter += 1;
				  //echo "<div class='fnBlock'>";
               }
               
               // Look for a close brace in the line.
               $position = 0;
               while ( strpos($lineOut, "}", $position) > -1 ) {
                  $position = strpos($lineOut, "}", $position) + 1;
                  $braceCounter -= 1;
				  //echo "</div>";
               }
               
               echo $prefix.$firstLine.$suffix."<br />";
             }
             echo "The brace count is ".$braceCounter;
                          
        ?>
    </body>
</html>