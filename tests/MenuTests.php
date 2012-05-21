<?php

require_once(dirname(__FILE__).'/simpletest/autorun.php');
require_once(dirname(__FILE__).'/simpletest/mock_objects.php');
require_once(dirname(__FILE__).'/simpletest/web_tester.php');
require_once(dirname(__FILE__).'/../php/baseDataPipe.php');
require_once(dirname(__FILE__).'/../php/CodeSnippetsDataPipe.php');
require_once(dirname(__FILE__).'/../php/tableMapManager.php');
require_once(dirname(__FILE__).'/../php/tableMap.php');
require_once(dirname(__FILE__).'/../php/DataPipeFactory.php');
require_once(dirname(__FILE__).'/../php/DBManager.php');

Mock::generate('tableMap');
Mock::Generate('DBManager');

class TestsForCodeSnippets extends UnitTestCase {
    function testCodeSnippetsFilesExist() {
        $dp_exists = file_exists(dirname(__FILE__).
            '/../php/CodeSnippetsDataPipe.php');
        $this->assertTrue($dp_exists, "CodeSnippets Datapipe File Exists");
        $form_exists = file_exists(dirname(__FILE__).
            '/../forms/codesnippets.php');
        $this->assertTrue($form_exists, "Codesnippets Form Exists");
        $js_exists = file_exists(dirname(__FILE__).
            '/../controls/codesnippetsControl.js');
        $this->assertTrue($js_exists, "Codesnippets Controller exists");
        $dpFactoryStr = file_get_contents(dirname(__FILE__).
            '/../php/DataPipeFactory.php');
        $dpFactoryReg = '/case "codesnippets" :/';
        $this->assertPattern($dpFactoryReg, $dpFactoryStr);
    }

    function testCodeSnippetsObject() {
        $_REQUEST = array(
            'tableName' => 'codeSnippets',
            'tableMap' => 'codeSnippets',
            'pipe' => 'codesnippets',
            'queryType' => 'select',
        );
        include(dirname(__FILE__).'/../php/db_login.php');
        $db_dsn = "mysql:host={$db_host};".
            "dbname={$db_database}";
        $db = new DBManager(
            $db_dsn, $db_username, $db_password);
        $db->open();
        $tm = new TableMapManager($db);
        $snippetsDP = new CodeSnippetsDataPipe($tm, $db);
        $this->assertIsA($snippetsDP, CodeSnippetsDataPipe);
        $snippetReflection = new ReflectionObject($snippetsDP);
        $this->assertIsA($snippetReflection, ReflectionObject);
    }
}

class TestForCodeSnippetsPage extends WebTestCase {
    function testPage() {
        $url = 'http://localhost/bit562/forms/login.php';
        $params = array(
            pipe => 'codesnippets',
            queryType => 'select',
            tablename => 'codeSnippets',
            tableMap => 'codesnippets'
        );
        $this->get($url);
        $this->assertResponse(200);
        $this->assertTitle('Login');
        $this->clickSubmitById('submit');
        $this->assertCookie('PHPSESSID');
        $this->assertResponse(200);
        $this->assertTitle
            ('BIT 285 Class Project: BIT561 Vision Statement and Test Menu');
        $this->clickLinkById('codesnippetsForm');
        $this->assertResponse(200);
        $this->assertTitle('Code Snippets');
        // Mike's tests
        $this->clickLinkById('something');
        $this->assertResponse(200);
        $this->assertTitle('somting');
        
        
    }
}