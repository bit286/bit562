<?php
// Using namespaces in this way allows "monkey patching" of classes and methods.
// Since namespacing is restricted to the first line of the script, 
//   it means that different mock outputs need to be refactored into separate files
namespace NoMockPDONeeded;
class PDO extends \PDO {

    public function __construct($a, $b, $c) {
        //empty 
        echo "some bullshit";
        return;
    }

    public function query($sql) {
        return 'some text';
        
        /* pseudo-code for more accurate input/response cycle
            if( $sql matches $pattern ) {
                return realistic result
            }
        */       
    }
}
//use ExpectedResults\PDO as PDO;
//* This file is for Units Tests of the DBManager class.

if(!class_exists('UnitTestCase')) include('simpletest/autorun.php');
if(!class_exists('DBManager')) include('../php/DBManager.php');

class DBManagerTests extends \UnitTestCase {
    
    public function testConstructor() {
    
        $DBManager = new \DBManager("arbitrary string", "user", "pass");
        $DBMReflection = new \ReflectionObject($DBManager);
        
        $this->assertTrue($DBMReflection->hasProperty("db_dsn"), "The DBManager should have a property called db_dsn");
        if($DBMReflection->hasProperty("db_dsn")) {
            $propertyDBDSN = $DBMReflection->getProperty("db_dsn");
            $propertyDBDSN->setAccessible(true);
            $this->assertEqual($propertyDBDSN->getValue($DBManager), "arbitrary string", "The dsn should be properly set using arbitrary strings.  If any validation is placed on the input of the dsn, then this test must be modified accordingly.");
        }
        
        $this->assertTrue($DBMReflection->hasProperty("db_username"), "The DBManager should have a property called db_username");
        if($DBMReflection->hasProperty("db_username")) {
            $propertyUserName = $DBMReflection->getProperty("db_username");
            $propertyUserName->setAccessible(true);
            $this->assertEqual($propertyUserName->getValue($DBManager), "user", "The user name should be properly set using arbitrary strings");
        }
        
        $this->assertTrue($DBMReflection->hasProperty("db_password"), "The DBManager should have a property called db_password");
        if($DBMReflection->hasProperty("db_password")) {
            $propertyPassword = $DBMReflection->getProperty("db_password");
            $propertyPassword->setAccessible(true);
            $this->assertEqual($propertyPassword->getValue($DBManager), "pass", "The pass should be properly set using arbitrary strings");
        }
        
        // The DBManager does not have any type of data validation on the constructor.
        //  It is currently uncertain what should happen on improper input.  The subsequent tests assume the constructor would fail and return null.
        $arbitraryObject = new \stdClass();
        $DBManager = new \DBManager($arbitraryObject, "user", "pass");
        $this->assertNull($DBManager, "An object instead of a string was passed to the db_dsn property which should result in a null object");
        $DBManager = new \DBManager("arbitrary string", $arbitraryObject, "pass");
        $this->assertNull($DBManager, "An object instead of a string was passed to the db_username property which should result in a null object");
        $DBManager = new \DBManager("arbitrary string", "user", $arbitraryObject);
        $this->assertNull($DBManager, "An object instead of a string was passed to the db_password property which should result in a null object");
        
        
    }
    
    public function testGetDBTestsWithEmptyDSN() {
        $DBManager = new \DBManager("", "user", "pass");
        $getTestsResult = $DBManager->getDBTests();
        $this->assertNull($getTestsResult, "This should be null because the DBManager has not opened its connection yet.");
    }
    
    public function testGetDBTestsWithProperDSN() {
        $DBManager = new \DBManager("mysql:host={$GLOBALS['db_host']};dbname={$GLOBALS['db_database']}", $GLOBALS['db_username'], $GLOBALS['db_password']);
        $getTestsResult = $DBManager->getDBTests();
        $this->assertTrue(is_array($getTestsResult), "The response should be an array.");
        
    }
    
    public function testScrub() {
        // DBManager constructor arguments don't matter for this test 
        $DBManager = new \DBManager("", "user", "pass");
        $scrubbed = $DBManager->scrub("'");
        $this->assertEqual($scrubbed, "%pos;", "Should scrub a lone apostrophe into %pos;");
        $scrubbed = $DBManager->scrub("");
        $this->assertEqual($scrubbed, "", "An empty input should return an empty output"); 
    }
    
    public function testDeScrub() {
        $DBManager = new \DBManager("", "user", "pass");
        $deScrubbed = $DBManager->deScrub("%pos;");
        $this->assertEqual($deScrubbed, "'", "Should scrub a lone %pos; into '");
        $deScrubbed = $DBManager->deScrub("");
        $this->assertEqual($deScrubbed, "", "An empty input should return an empty output"); 
    }
    
    
    //I realized assertOn and positiveTest are private, so these two test methods are meaningless right now.
    public function testAssertToggle() {
        $DBManager = new \DBManager("", "user", "pass");
        $DBMReflection = new \ReflectionObject($DBManager);
        $propertyAssertOn = $DBMReflection->getProperty("assertOn");
        $propertyAssertOn->setAccessible(true);
        $this->assertFalse($propertyAssertOn->getValue($DBManager), "The constructor should set assertOn to false.");
        $DBManager->assertToggle();
        $this->assertTrue($propertyAssertOn->getValue($DBManager), "This should be true since the variable declaration starts out false.");
        $DBManager->assertToggle();
        $this->assertFalse($propertyAssertOn->getValue($DBManager), "This is verifying that the toggle works both ways, assuming the previous test passed.");
    }
    
    public function testPositiveTestToggle() {
        $DBManager = new \DBManager("", "user", "pass");
        $DBMReflection = new \ReflectionObject($DBManager);
        $propertyPositiveTest = $DBMReflection->getProperty("positiveTest");
        $propertyPositiveTest->setAccessible(true);
        $this->assertTrue($propertyPositiveTest->getValue($DBManager), "This should be true at object creation.");
        $DBManager->positiveTestToggle();
        $this->assertFalse($propertyPositiveTest->getValue($DBManager), "This should be false since the variable declaration starts out true.");
        $DBManager->positiveTestToggle();
        $this->assertTrue($propertyPositiveTest->getValue($DBManager), "This is verifying that the toggle works both ways, assuming the previous test passed.");
    }
   
}

//namespace ExpectedResults;

// I am trying to override the PDO object so that we can unit test the methods that need a database connection.

class DBManagerTestsWithExpectedResults extends \UnitTestCase {
    
    function testOpenAndExecute() {
        $DBManager = new \DBManager("","","");
        $DBManager->open();
        /*
        $pdo = new PDO('','','');
        $DBMReflection = new \ReflectionObject($DBManager);
        $propertyConnection = $DBMReflection->getProperty("connection");
        $propertyConnection->setAccessible(true);
        $propertyConnection->setValue($DBManager, $pdo);*/
        
        $connectionClass = $DBMReflection->getProperty("connection")->class;
        $this->assertIsA($connectionClass, '\PDO', "after the open method, the connection should be a PDO object.");
        $result = $DBManager->execute("some sql");
        $this->assertEqual($result, "some text", "This test needs to be changed.");
    }
    
}


?>