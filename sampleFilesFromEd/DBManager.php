<?php

// Managing database connections is a critical feature of any program interacting with a database.
// Having an object to perform the basic house cleaning of connection and execution makes for
// good clarity of code.  
class DBManager {

	private $db_host;
	private $db_username;
	private $db_password;
	private $db_database;
	private $connection;
	private $db_select;
	private $positiveTest = true;
	private $assertOn = false;
	
	function __construct($db_host, $db_username, $db_password, $db_database) {
		$this->db_host = $db_host;
		$this->db_username = $db_username;
		$this->db_password = $db_password;
		$this->db_database = $db_database;
	}
	
	// Given that the four relevant pieces of information were created when the DBManager was created,
	// the open function sets up the database for operation.
	function open() {
		try {
			$connection = mysql_connect($this->db_host, $this->db_username, $this->db_password);
			if ( !$connection ) {
				throw new Exception ("The database connection was not made correctly.".$this->db_host."  ".$this->db_password."  ".$this->db_database);
			}
			
			$db_select = mysql_select_db($this->db_database);
			if ( !$db_select ) {
				throw new Exception ("Could not find the requested database.");
			}
		}
		catch(Exception $e) {
			echo $e->getMessage();
		}
	}
	
	
	// All SQL should be operated through the DBManager.execute method.  The method has the proper 
	// exception protection built in and thus prevents the need to constantly write exception code.
	function execute($sql) {
		try {
			$result = mysql_query($sql);
			if ( !$result ) 
				throw new Exception();
			return $result;
		}
		catch (Exception $e ) {
			$this->testDescription("Execute failed: ".$this->scrub($sql));
			return $result;
		}		
	}
	
	// Make any needed changes to the MasterID table.  Called from baseDataPipe execute() method.
	function manageMasterID( $sql ) {
		try {
			$result = mysql_query($sql);
			if ( !$result ) 
				throw new Exception("<row tableName=\"failure\"><field name=\"manageMasterID()\"</field></row>");
			return $result;
		}
		catch ( Exception $e ) {
//			echo $e->getMessage();
			return $result;
		}
	}
	
	// Replace apostrophes in a string with "%pos;"
	function scrub ( $targetStr )
	{
		$targetArray = split("'", $targetStr);
		$newStr = join('%pos;', $targetArray);
		$newStr = str_replace("\%", "%", $newStr);
		return $newStr;
	}

	// Replace "&pos;" with apostrophes in strings.
	function deScrub( $targetStr )
	{
		$targetArray = split("%pos;", $targetStr);
		return join("'", $targetArray);
	}

	// Send a text string to the database test table.
	function testDescription( $description )
	{
	   
	   if ( $this->positiveTest == true)
	   {
		   $description = $this->scrub($description);	 
		   $testSQL = "INSERT INTO test SET description = '".$description."'";
		   $testResult = mysql_query($testSQL);
	   }
	}

	// Do not use an assert inside DBManager as it creates a loop.
	// "assert" sends a message to the test table in the database.  It also
	// sends whether the test was true or false.
	function assert( $condition, $message ) 
	{
		if ( !$this->assertOn ) 
			return;
			
		if ( $condition ) 
		{
			$success = "true";
		}
		else
		{
			$success = "false";
		}
		$message = $this->scrub($message);
		$assertSQL = "INSERT INTO test SET description = '".$message."', success = '".$success."'";
		$result = $this->execute($assertSQL);
	}
	
	function assertToggle() {
		if ( $this->assertOn )
			$this->assertOn = false;
		else
			$this->assertOn = true;
	}
	
	function positiveTestToggle() {
		if ($this->positiveTest)
			$this->positiveTest = false;
		else
			$this->positiveTest = true;
	}
	
	// If a user enters the application at a page other than the
	// home page, they need to get bumped to the login page.  failAuthenticate
	// checks to see that the user is logged into the application correctly before
	// showing any data.
	function failAuthenticate() {
		$izoid = $_REQUEST['izoid'];
		$remote_addr = $_SERVER['REMOTE_ADDR'];
		$sql = "select * from authentications where object_ID = '".$izoid."' and ";
		$sql .= "remote_addr = '".$remote_addr."'";
		$result = $this->execute($sql);
		if ( mysql_num_rows($result) > 0 ) {
			return false;
		}
		else {
			return true;
		}
		return false;
	}
	
	function getDBName() {
		return $this->db_database;
	}
	
	
} // End of DBManager



?>