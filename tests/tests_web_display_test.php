<?php

require_once(dirname(__FILE__) . '/simpletest/autorun.php');
require_once(dirname(__FILE__) . '/simpletest/web_tester.php');
require_once(dirname(__FILE__).'/../php/db_login.php');
require_once(dirname(__FILE__).'/../php/DBManager.php');

class TestOfTestsWebDisplay extends UnitTestCase {
    private $DBManager;

    function setUp() {
        $db_dsn = "mysql:host={$GLOBALS['db_host']};".
            "dbname={$GLOBALS['db_database']}";
        $this->DBManager = new DBManager(
            $db_dsn, $GLOBALS['db_username'], $GLOBALS['db_password']);
    }

    function testTestTableExistence() {
        $this->DBManager->open();
        $s = $this->DBManager->execute(
            'SELECT COUNT(*) '.
            'FROM information_schema.tables '.
            "WHERE table_schema = '{$GLOBALS['db_database']}' ".
            "AND table_name = 'test';"
        );
        $res = $s->fetch();
        $this->assertEqual($res[0], "1");
    }

    function testDBManagerReturnsAllTests() {
        $this->DBManager->open();
        $countSel = $this->DBManager->execute('SELECT COUNT(*) FROM test');
        $count = $countSel->fetchAll();
        $res = $this->DBManager->getDBTests();
        $this->assertEqual(count($res), $count[0][0]);
    }

    function testHtmlWrappedTest() {
        $this->DBManager->open();
        $res = $this->DBManager->getDBtests();
        $row = $res[0];
        $html = $this->DBManager->rowWrap($row);
        $this->assertPattern('/<tr>.*<\/tr>/', $html);
        $edReg = '/.*<td>'.$row['entryDate'].'<\/td>.*/';
        $succReg = '/.*<td>'.$row['success'].'<\/td>.*/';
        $this->assertPattern($edReg, $html);
        $this->assertPattern($succReg, $html);
    }
}

class TestOfTestWebDisplayWebTests extends WebTestCase {
    function testPageExists() {
        $this->get('http://localhost/bit562/php/dbtest.php');
        $this->assertResponse(200);
    }

}
