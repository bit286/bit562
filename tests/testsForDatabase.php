<?php

require_once(dirname(__FILE__).'/simpletest/autorun.php');
require_once(dirname(__FILE__).'/../php/db_login.php');
require_once(dirname(__FILE__).'/../php/DBManager.php');

class DatabaseTester extends UnitTestCase {

    function testExistenceOfDatabaseFiles() {
        $this->assertTrue(file_exists(dirname(__FILE__).
            '/../php/DBManager.php'));
        $this->assertTrue(file_exists(dirname(__FILE__).
            '/../php/db_login.php'));
    }

    function testDataBaseCredentials() {
        $this->assertNotNull($GLOBALS['db_username']);
        $this->assertNotNull($GLOBALS['db_password']);
        $this->assertNotNull($GLOBALS['db_database']);
    }

    function testDataBaseManager() {
        $db_dsn = "mysql:host={$GLOBALS['db_host']};".
            "dbname={$GLOBALS['db_database']}";
        $databaseManager = new DBManager(
            $db_dsn, $GLOBALS['db_username'], $GLOBALS['db_password']);
        $databaseManager->open();
        $this->assertIsA($databaseManager, 'DBManager');
    }
}

?>
