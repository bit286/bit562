<?php

   require_once('DBManager.php');
   require_once('db_login.php');
   require_once('tableMapManager.php');
   require_once('tableMap.php');
   require_once('DataPipeFactory.php');
   
//   $_REQUEST['tableName'] = 'projectfiles';
//  $_REQUEST['pipe'] = 'projectfiles';
//  $_REQUEST['project'] = 'BIT561';
//  $_REQUEST['queryType'] = 'select';
//   $_REQUEST['authoroid'] = 'xxxxx-xxxxx-xxxxx-xxxxx';
   
   $db_dsn = "mysql:host={$db_host};dbname={$db_database}";

   $databaseManager = new DBManager($db_dsn, $db_username, $db_password);
   $databaseManager->open();
   $databaseManager->test('This is the first check to see if the database works. Is the DB Working? If you see this it is.');
   
   $tableMap = new TableMap('quotes', 'quote', 'quote', 'select', 'alpha');
   $browserName = $tableMap->get('browser');
   
   $tableMapManager = new TableMapManager($databaseManager);
   $dataPipe = dataPipeFactory($tableMapManager, $databaseManager);
   
   $result = $dataPipe->execute();
   
   // Pack the data as XML.
   header('Content-Type: text/xml');
   echo '<?xml version="1.0" ?>';
   
   $XML = $dataPipe->resultToXML($result);
   echo '<XMLroot>'.$XML.'</XMLroot>';
      
?>

