<?php

	// testDBManager.php is an exercise page for the DBManager.php object.
	include('db_login.php');
	include('DBManager.php');
	
	$essay = new DBManager($db_host, $db_username, $db_password, $db_database);
	$essay->open();
	$essay->assertToggle();
	
	$tableName = $_REQUEST['tableName'];
	
	// Make sure the user is logged in and valid. Authentication cannot occur when working with newuser accounts.
	if ( !($tableName == 'authors' 
		 || $tableName == 'alternativeqs' 
		 || $tableName == 'analytics'
		 || $tableName == 'sitefeedback'
		 || $tableName == 'pages' 
		 || $tableName == 'frames'
		 || $tableName == 'essays'
		 || $tableName == 'eQuestions'
		 || $tableName == 'eAnswers'
		 || $tableName == 'memberships' ) ) {
		if ( $essay->failAuthenticate() ) {
			
			// Pack the authentication failure as XML.
			header('Content-Type: text/xml');
			echo '<?xml version="1.0" ?>';	
			$XML = "<row tableName=\"authentic\"><field name=\"success\">"."@false@"."</field></row>";
			echo "\n<XMLroot>".$XML."</XMLroot>";
			exit();
		}
		else {
			// Authentication passed.  Go on to lookup data.
		}
	}
	
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

	$essay->testDescription($XML);
	
?>