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
     
//Use the different search strings below to change which planguage block is searched for.

     
     $searchString = '/*+TABLE::tablename=users::database=BIT276/285_database ::description=Stores information related to user accounts.;;';
//     $searchString = '/*+       SAMPLE::language=SQL::name=Study1::usage=First Code Sample: Show how to use declare statements::illustrations=DECLARE, SET, PRINT;;';
//     $searchString = '/*+       TABLE::tablename=users::database=pctools::description=Description of the database        */';
//     $searchString = '/*+LINK:: href=picture.jpg:: title=Show the picture.;;';
 
     echo '<h3>This is the first planguage line that will be passed to us.<br />  
         We will use this to search for the start of the comment in the file.</h3>';
     
     echo $searchString;
   
     
     $newReader = new Reader($DB);
     $commands = $newReader->planguageReader('parserTesterFile.txt', 'this.txt', $searchString);
     
     echo '<h3>Output of the $planguage array</h3><p><pre>';
     print_r ($commands);
     echo '</pre></p>';

     
     
          
     echo '<h1>That\'s All Folks!<h1>';

        ?>
     



</body>
</html>