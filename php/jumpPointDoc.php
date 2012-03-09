<?php

   require_once('Reader.php');
   require_once('DBManager.php');
   require_once('db_login.php');
   
   $db_dsn = "mysql:host={$db_host};dbname={$db_database}";

   $databaseManager = new DBManager($db_dsn, $db_username, $db_password);
   $databaseManager->open();
   // $databaseManager->assertToggle();
   
   $reader = new Reader($databaseManager);
   $reader->retrieveProjectFiles('BIT561');
   $results = $reader->readAndWriteProject();
   
   
   if (count($results) >= 1) {
       $databaseManager->assertToggle();
       $numResults = count($results);
       for ($i = 0; $i < $numResults; $i++) {
           $databaseManager->assert($results[$i]['success'],$results[$i]['description']);
       }
       $result = '@true@';
   } else {
       $result = '@false@';
   }
   
?>


<html>
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <title></title>
   </head>
   <body>
      <h2>The jumpPoint run was successful.</h2>
      <p>The result is <?php echo $result; ?>.</p>
      <p>Please see the results in the <b>bit561</b> database <b>test</b> table.</p>
   </body>
</html>
