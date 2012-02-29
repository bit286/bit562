<?php

/**************************************************************************************
 * Managing database connections is a critical feature of any program interacting
 * with a database.  Having an object to perform the basic house cleaning of 
 * connection and execution makes for good clarity of code throughout programs 
 * using the database.  Having a connection object allows for connection to multiple
 * databases at the same time, each database gets its own database manager.
 * 
 * A sample dsn string for a mysql database looks like the following:
 *    $db_dsn = "mysql:host={$db_host};dbname={$db_database}";
 * where $db_host is often "localhost" and database name is the local schema.
 * The $db_host, $db_database, $db_username, and $db_password are typically
 * stored in a db_login.php file which is imported prior to constructing the DBManager
 */
class DBManager {
    
     private $db_dsn;
     private $db_username;
     private $db_password;
     private $connection = null; //Object is instantiated when connection is opened
     private $positiveTest = true;
     private $assertOn = false;

     function __construct($db_dsn, $db_username, $db_password) {
       $this->db_dsn = $db_dsn;
       $this->db_username = $db_username;
       $this->db_password = $db_password;
     }

     /*+ TODO::location=DBManager.php::task=When fail to open, pass control to an included
      *           file which displays an acceptable user message.  See pp 76-77 in text.::
      *           author=Ed Anderson
      */
     
     // The open function sets up the database for operation.
     public function open() {
       try {
           $this->connection = new PDO($this->db_dsn, 
                                       $this->db_username, 
                                       $this->db_password);
       }
       catch(PDOException $e) {
           echo "An database connection error occurred: {$e->getMessage()}";
           exit();
       }
     }

     /************************************************************************
      * All SQL shour be operated through the DBManager.execute method.
      * The method has proper exception protection built in and thus 
      * eliminates the need to constantly write exception code around SQL
      * execution.
      */
     public function execute($sql) {
       try {
         $result = $this->connection->query($sql);
         if ( !$result ) {
            throw new PDOException();
         }
         return $result;
       }
       catch (PDOException $e ) {
         $this->test("Execute failed: ".$sql);
         return $result;
       }
     }

     // Replace apostrophes in a string with "%pos;"
     public function scrub ( $targetStr ) {
       $targetArray = explode("'", $targetStr);
       $newStr = implode('%pos;', $targetArray);
       $newStr = str_replace("\%", "%", $newStr);       
       return $newStr;
     }

     // Replace "&pos;" with apostrophes in strings.
     public function deScrub( $targetStr ) {
       $targetArray = explode("%pos;", $targetStr);
       return implode("'", $targetArray);
     }

     // Send a text string to the database test table.
     // Use the connection directly for the query to avoid using the
     // DBManger.execute function.  That function uses test and a loop
     // would be created if it was called from test.
     public function test( $description ) {

        if ( $this->positiveTest == true)
        {
          $description = $this->scrub($description);	 
          $testSQL = "INSERT INTO test SET description = '".$description."'";
          $testResult = $this->connection->query($testSQL);
        }
     }

     // "assert" sends a message to the test table in the database.  It also
     // sends whether the test was true or false.
     // Do not use an assert inside DBManager as it would create a loop.
     public function assert( $condition, $message ) {
       if ( !$this->assertOn ) 
         return;

       if ( $condition ) {
         $success = "true";
       } else {
         $success = "false";
       }
       $message = $this->scrub($message);
       $assertSQL = "INSERT INTO test SET description = '"
                        .$message."', success = '".$success."'";
       $result = $this->execute($assertSQL);
     }

     public function assertToggle() {
       if ( $this->assertOn ) {
         $this->assertOn = false;
       } else {
         $this->assertOn = true;
       }
     }

     public function positiveTestToggle() {
       if ($this->positiveTest) {
         $this->positiveTest = false;
       } else {
         $this->positiveTest = true;
       }
     }

} // End of DBManager

?>