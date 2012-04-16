<?php

require_once(dirname(__FILE__).'/simpletest/autorun.php');
require_once(dirname(__FILE__).'/simpletest/mock_objects.php');
require_once(dirname(__FILE__).'/../php/DBConfig.php');

Mock::generate('DBConfig');

class DBConfigTester extends UnitTestCase {
    function testDBConfigObject() {
        $dbconfig = new DBConfig();
        include(dirname(__FILE__).'/../php/db_login.php');
        $database = $dbconfig->getDatabase();
        $username = $dbconfig->getUsername();
        $password = $dbconfig->getPassword();
        $hostname = $dbconfig->getHostname();
        $this->assertIsA($dbconfig, DBConfig);
        $this->assertIsA($database, String, "Returns string");
        $this->assertEqual($database, $db_database, "Has Database Name");
        $this->assertIsA($username, String, "Returns string");
        $this->assertEqual($username, $db_username, "Has Username");
        $this->assertIsA($password, String, "Returns string");
        $this->assertEqual($password, $db_password, "Has Password");
        $this->assertIsA($hostname, String, "Returns string");
        $this->assertEqual($hostname, $db_host, "Has hostname");
    }
}
