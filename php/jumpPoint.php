<?php

   require_once('Reader.php');
   require_once('DBManager.php');
   require_once('db_login.php');
   
   $db_dsn = "mysql:host={$db_host};dbname={$db_database}";

   $databaseManager = new DBManager($db_dsn, $db_username, $db_password);
   // $databaseManager->open();
   // $databaseManager->assertToggle();
   
   $reader = new Reader($databaseManager);
   $reader->retrieveProjectFiles('BIT561');
   $result = $reader->readAndWriteProject();
   
   if ($result) {
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
      The result is <?php echo $result; ?>.
   </body>
</html>
