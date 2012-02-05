<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title></title>
</head>
<body>
               
<?php

     require_once ('../Command.php');
    
     $searchString = '/*+       SAMPLE::language=SQL::name=Study1::usage=First Code Sample: Show how to use declare statements::illustrations=DECLARE, SET, PRINT;;';
 
     echo '<h3>This is the first planguage line that will be passed to us.  
         We will use this to search for the start of the comment in the file.</h3>';
     
     echo $searchString;
     
     
     $file = fopen ('parserTesterFile.txt', 'r');
     $fileString = '';
         while (!feof($file)) {
            $lineString = fgets ($file);
            if ($lineString === false) continue;
            $lineString = trim($lineString);
            if (strlen($lineString) == 0) continue;
            $fileString .= $lineString;
        }
        fclose($file);
     
     echo '<h3>Our file converted to a string, ready for planguage extraction.</h3>';
     
     echo $fileString;
        
     $start = strpos ($fileString, $searchString);
     $start = $start + 3;
     $end = strpos ($fileString, '*/', $start);
     $planguageString = substr (substr ($fileString, 0, -(strlen($fileString) - $end)), $start);
     $planguageString = trim ($planguageString);
     
     

     
     echo '<h3>Our string after extracting the planguage block and cropping the comment markup and any leftover whitespace on the ends.</h3>';
     
     echo $planguageString;
     
     
     

     $commandSections = explode(';;', $planguageString);


        
          
     
     echo '<h3>print_r output of the array.</h3>';     
          
     print_r ($commandSections);
     
          
     $newCommand = '';     
     $newCommand = new Command ($commandSections[0], 'parserTesterFile.txt', $searchString);
     
     $command = $newCommand->getCommandName();
     
     echo "<p>$command</p>";
     
          
     echo '<h1>That\'s All Folks!<h1>';

        ?>
     


<h1>The End</h1>

</body>
</html>