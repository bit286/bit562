<?php
session_start();

	$izoid = $_SESSION['izoid'];
	$object_ID = $_SESSION['object_ID'];

	include('db_login.php');
	include('DBManager.php');
	include('utilities.php');

	$essay = new DBManager($db_host, $db_username, $db_password, $db_database);	
	$essay->open();
	$essay->assertToggle();
	
	header('Content-Type: text/xml');
	echo '<?xml version="1.0" ?>';	

	$XML = "<row tableName=\"marker\"><field name=\"izoid\">".$izoid."</field>";
	$XML .= "<field name=\"object_ID\">".$object_ID."</field></row>";
	echo "\n<XMLroot>".$XML."</XMLroot>";
	
?>