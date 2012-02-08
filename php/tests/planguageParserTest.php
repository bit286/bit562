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

     $searchString = '/*+TABLE::tablename=users::database=BIT276/285_database ::description=Stores information related to user accounts.;;';
 
     echo '<h3>This is the first planguage line that will be passed to us.  
         We will use this to search for the start of the comment in the file.</h3>';
     
     echo $searchString;
   
     
     $newReader = new Reader($DB);
     $commands = $newReader->planguageReader('parserTesterFile.txt', 'this.txt', $searchString);


        
          
     
     echo '<h3>Output of the $commands array.</h3>';     
          
     echo '<ul>';
     foreach ($commands as $name => $value) {
         echo "<li>$name</li>";
         echo'<li style="list-style-type:none"><ul>';
         foreach ($value as $name =>$value) {
             echo "<li style=\"color:#990000\"><u>$name</u></li>";
             echo'<li style="list-style-type:none"><ul>';
             foreach ($value as $name =>$value) {
             echo "<li><span style=\"color:#006600\"><b>$name</b></span> - <span style=\"color:#003399\">$value</span></li>";
         }
         echo '</ul></li>';
         }
         echo '</ul></li>';
     }
     echo '</ul>';
     
     
    
     
      
      
    
     
     
     
          
     echo '<h1>That\'s All Folks!<h1>';

        ?>
     



</body>
</html>