<?php

// Managing database connections is a critical feature of any program interacting with a database.
// Having an object to perform the basic house cleaning of connection and execution makes for
// good clarity of code.  
class DBManager {

	private $db_host;
	private $db_username;
	private $db_password;
	private $db_database;
    private $db_dsn;
	private $connection = null; //Object is instantiated when connection is opened
	private $db_select;
	private $positiveTest = true;
	private $assertOn = false;
	
	function __construct($db_host, $db_username, $db_password, $db_database) {
          $this->db_host = $db_host;
          $this->db_username = $db_username;
          $this->db_password = $db_password;
          $this->db_database = $db_database;
          $this->db_dsn = "mysql:host={$db_host};dbname={$db_database}";
	}
	
	public function getDBName() {
          return $this->db_database;
	}
	
	// Given that the four relevant pieces of information were created when the DBManager was created,
	// the open function sets up the database for operation.
	public function open() {
          try {
              $this->connection = new PDO($this->db_dsn, $this->db_username, $this->db_password);
          }
          catch(PDOException $e) {
              echo "An error occured while connecting to the database: {$e->getMessage()}";
          }
	}
	
	
	// All SQL should be operated through the DBManager.execute method.  The method has the proper 
	// exception protection built in and thus prevents the need to constantly write exception code.
	public function execute($sql) {
          try {
            $result = $this->connection->query($sql);
            if ( !$result ) 
                    throw new Exception();
            return $result;
          }
          catch (Exception $e ) {
            $this->testDescription("Execute failed: ".$this->scrub($sql));
            return $result;
          }
          catch (PDOException $e) {
              echo "A PDO Exception occured querying the database: {$e->getMessage()}";
          }
	}
	
	// Replace apostrophes in a string with "%pos;"
	public function scrub ( $targetStr ) {
          $targetArray = split("'", $targetStr);
          $newStr = join('%pos;', $targetArray);
          $newStr = str_replace("\%", "%", $newStr);
          return $newStr;
	}

	// Replace "&pos;" with apostrophes in strings.
	public function deScrub( $targetStr ) {
          $targetArray = split("%pos;", $targetStr);
          return join("'", $targetArray);
	}

	// Send a text string to the database test table.
	public function test( $description ) {
	   
           if ( $this->positiveTest == true)
           {
             $description = $this->scrub($description);	 
             $testSQL = "INSERT INTO test SET description = '".$description."'";
             $testResult = $this->connection->query($testSQL);
           }
	}

	// Do not use an assert inside DBManager as it creates a loop.
	// "assert" sends a message to the test table in the database.  It also
	// sends whether the test was true or false.
	public function assert( $condition, $message ) {
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
	
	public function assertToggle() {
          if ( $this->assertOn )
            $this->assertOn = false;
          else
            $this->assertOn = true;
	}
	
	public function positiveTestToggle() {
          if ($this->positiveTest)
            $this->positiveTest = false;
          else
            $this->positiveTest = true;
	}
		
} // End of DBManager

?>