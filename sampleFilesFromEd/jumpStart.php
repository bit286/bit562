<?php
session_start();
	
	// testDBManager.php is an exercise page for the DBManager.php object.
	include('db_login.php');
	include('DBManager.php');
	include('utilities.php');
	
	$essay = new DBManager($db_host, $db_username, $db_password, $db_database);
	$essay->open();
	$essay->assertToggle();
	
	$userID = $_REQUEST["userID"];
	$pword = $_REQUEST["pword"];
	$remote_addr = $_SERVER["REMOTE_ADDR"];
	
	$sql = "select object_ID from authors where user_ID = '".$userID."' and ";
	$sql .= "password = '".$pword."'";
	
	$result = $essay->execute($sql);
	
	if ( $userPresent = mysql_fetch_row($result) ) {
		$authoroid = $userPresent[0];
		$object_ID = getObjectID();

		$sql = "insert into authentications ( object_ID, authoroid, remote_addr ) ";
		$sql .= "values ( '".$object_ID."', '".$authoroid."', '".$remote_addr."' )";
		$result = $essay->execute($sql);
		if ( $result ) {
			$outcome = "@true@";
			$_SESSION['izoid'] = $object_ID;
			$_SESSION['object_ID'] = $authoroid;
		}
		else {
			$outcome = "@falseone@";
		}
	}
	else {
		$outcome = "@falsetwo@";
	}

	header('Content-Type: text/xml');
	echo '<?xml version="1.0" ?>';	

	$XML = "<row tableName=\"result\"><field name=\"success\">".$outcome."</field></row>";
	echo "\n<XMLroot>".$XML."</XMLroot>";
	
?>