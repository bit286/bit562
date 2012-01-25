<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>fileReader.php Test</title>
        <style>
           .comment { color: red; }
        </style>
    </head>
    <body>
        <?php
        
             require_once('indentation.php');
             
             $position = 0;
             $braceCounter = 0;
             
             // See if you can open the named file.
             $fileName = "C:/xampp/htdocs/base/structure.js";
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
               }
               
               // Look for a close brace in the line.
               $position = 0;
               while ( strpos($lineOut, "}", $position) > -1 ) {
                  $position = strpos($lineOut, "}", $position) + 1;
                  $braceCounter -= 1;
               }
               
               echo $prefix.$firstLine.$suffix."<br />";
             }
             echo "The brace count is ".$braceCounter;
                          
        ?>
    </body>
</html>
