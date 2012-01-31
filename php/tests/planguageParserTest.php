<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title></title>
</head>
<body>
               
<?php
            $planguage = 'gibberish gibberish gibberish gibberish gibberish gibberish gibberish   /*+SAMPLE::language=SQL::name=Study1::usage=First Code Sample: Show how to use declare statements::illustrations=DECLARE, SET, PRINT;;
                         TABLE::tablename=test::database=B122_dbdesign::description=testing out string removal function::filename=test::description=test stuff::filedescription=moretest::description=test more stuff       */   gibberish gibberish gibberish gibberish 
                         gibberish gibberish gibberish gibberish gibberish gibberish gibberish gibberish  
                         /*+TABLE::tablename=users::database=pctools::description=Description of the database
                         */ gibberish gibberish gibberish gibberish gibberish';
       
    echo '<h3>This is the full text string to extract the comment from.</h3>';
            
    echo $planguage;  
   
    
     $searchString = '/*+SAMPLE::language=SQL::name=Study1::usage=First Code Sample: Show how to use declare statements::illustrations=DECLARE, SET, PRINT;;';
 
     echo '<h3>This is the first planguage line that will be passed to us.  
         We will use this to search for the start of the comment.</h3>';
     
     echo $searchString;
     
     $start = strpos ($planguage, $searchString);
     $start = $start + 3;
     $end = strpos ($planguage, '*/', $start);
     $fullString = substr (substr ($planguage, 0, -(strlen($planguage) - $end)), $start);
     $fullString = trim ($fullString);
     
     echo '<h3>Our string after extracting the planguage block and cropping the comment markup and any leftover whitespace on the ends.</h3>';
     
     echo $fullString;
     
     $i = strpos ($fullString, ';;');
     
     if (is_int($i)) {
         $commandPairs = array();
         $commandSections = explode(';;', $fullString);
         foreach ($commandSections as $a) {
             $commandParts = explode('::', $a);
             $commandParts = array_map('trim',$commandParts);
             $commandName = $commandParts[0];
             $commandPairs[] = $commandName;
             foreach ($commandParts as $b) {
                 list ($name,$value) = explode('=', $b);
                 $commandPairs[$name] = $value;
         }
         }
 
          } else {
              $commandPairs = array();
              $commandParts = explode('::', $fullString);
              $commandParts = array_map('trim',$commandParts);              
              $commandName = $commandParts[0];
              $commandPairs[] = $commandName;
              foreach ($commandParts as $a) {
                  list ($name,$value) = explode('=',$a);
                  $commandPairs[$name] = $value;
                  
              }
          }

        
          
     
     echo '<h3>print_r output of the array.</h3>';     
          
     print_r ($commandPairs);     
     
         /*$commandSections = array_map(create_function('$a', 'return $commandParts = explode(\'::\', $a);'), explode(';;', $fullString));
         } else {
         $commandSections = array_map(create_function('$a', 'return $commandParts = explode(\'=\', $a);'), explode('::', $fullString));*/
        ?>
     


<h1>The End</h1>

</body>
</html>