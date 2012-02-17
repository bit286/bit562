<?php
	
	// testDBManager.php is an exercise page for the DBManager.php object.
	// testDBManager.php is an exercise page for the DBManager.php object.
	include('db_login.php');
	include('DBManager.php');
	
	$essay = new DBManager($db_host, $db_username, $db_password, $db_database);
	$essay->open();
	$essay->assertToggle();

	include('tableMapManager.php');	
	include('DataPipeFactory.php');
	
	$mapManager = new tableMapManager($essay);
	
	
	$dataPipe = dataPipeFactory($mapManager, $essay);
	$result = $dataPipe->execute();	
	
	// Pack the data as XML.
	header('Content-Type: text/xml');
	echo '<?xml version="1.0" ?>';	

	$XML = $dataPipe->resultToXML($result);
	echo "\n<XMLroot>".$XML."</XMLroot>";
	
	
?>