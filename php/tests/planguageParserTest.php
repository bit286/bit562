<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title></title>
</head>
<body>
               
<?php

     require_once ('../Command.php');
     require_once ('../Reader.php');
     require_once('../DBManager.php');
    
     
     $DB = new DBManager ('db_dsn', 'db_username', 'db_password');

     $searchString = '/*+       SAMPLE::language=SQL::name=Study1::usage=First Code Sample: Show how to use declare statements::illustrations=DECLARE, SET, PRINT;;';
 
     echo '<h3>This is the first planguage line that will be passed to us.  
         We will use this to search for the start of the comment in the file.</h3>';
     
     echo $searchString;
     
     
     
     /*$file = fopen ('parserTesterFile.txt', 'r');
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
     $end = strpos ($fileString, '* /', $start);
     $planguageString = substr (substr ($fileString, 0, -(strlen($fileString) - $end)), $start);
     $planguageString = trim ($planguageString);
     
     

     
     echo '<h3>Our string after extracting the planguage block and cropping the comment markup and any leftover whitespace on the ends.</h3>';
     
     echo $planguageString;
     
     
     

     $commandSections = explode(';;', $planguageString);*/
     
     $newReader = new Reader($DB);
     $commands = $newReader->planguageReader('parserTesterFile.txt', 'this.txt', $searchString);


        
          
     
     echo '<h3>print_r output of the $comandSections array.</h3>';     
          
     print_r ($commands);
     
     
     
    
     
      
      
    
     
     
     /*$newCommand = '';     
     $newCommand = new Command ($commandSections[0], 'parserTesterFile.txt', $searchString);
     
     $command = $newCommand->getCommandName();
     
     echo "<p>$command</p>";
      
      
     
      
     $newCommand = new Command ($commandSections[$i], 'parserTesterFile.txt', $searchString);
     $command = $newCommand->getCommandName();
     echo '<h3><u>Command</u></h3>';
     echo $command;
     $pairs = $newCommand->getKVPairs();
     echo '<p></p>';
     print_r ($pairs);
     $reader = new Reader ($DB);
     $reader->addToPlanguage ($newCommand);
      
       
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
     $end = strpos ($fileString, '* /', $start);
     $planguageString = substr (substr ($fileString, 0, -(strlen($fileString) - $end)), $start);
     $planguageString = trim ($planguageString);
     
     

     
     echo '<h3>Our string after extracting the planguage block and cropping the comment markup and any leftover whitespace on the ends.</h3>';
     
     echo $planguageString;
     
     
     

     $commandSections = explode(';;', $planguageString);


        
          
     
     echo '<h3>print_r output of the $comandSections array.</h3>';     
          
     print_r ($commandSections);
     
     
     
     $commands = array();
     
     for($i=0; $i<count($commandSections); $i+=1) {         
     
      }
     
     
      
      echo '<h3>print_r output of the $newCommand object.</h3>';
      
     print_r ($newCommand);
     
     echo'<p></p>';
      * 
      * 
      * $newReader = new Reader($DB);
     $commands = $newReader->planguageReader('parserTesterFile.txt', 'this.txt', $searchString);
     
     print_r ($commands);
     
     $commands2 = $newReader->planguageManager($commands[0], 'parserTesterFile.txt', $searchString);
    
     print_r ($commands2); 
      */
     
          
     echo '<h1>That\'s All Folks!<h1>';

        ?>
     


<h1>The End</h1>

</body>
</html>