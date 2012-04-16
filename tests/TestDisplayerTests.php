<?php

require_once(dirname(__FILE__).'/../php/TestDisplayer.php');
require_once(dirname(__FILE__).'/simpletest/mock_objects.php');

class TestDisplayerTests extends UnitTestCase {
    function testTestDisplayerObject() {
        $methods = get_class_methods(TestDisplayer);
        $this->assertTrue(in_array('createTable', $methods),
            "TestDisplayer has class method createTable()");
        $this->assertTrue(in_array('rowWrap', $methods),
            "TestDisplayer has class method rowWrap()");
    }

    function testTestDisplayerRowWrap() {
        $db_array = array(
            entryDate => '2012-04-07 21:27:45',
            description => 'Execute failed: SELECT COUNT(*) FROM TEST ',
            success => "Pass"
        );
        $html = TestDisplayer::rowWrap($db_array);
        $this->assertIsA($html, String);
        $this->assertPattern('/<tr>.*<\/tr>/', $html);
        $edReg = '/.*<td>'.$db_array['entryDate'].'<\/td>.*/';
        $succReg = '/.*<td>'.$db_array['success'].'<\/td>.*/';
        $this->assertPattern($edReg, $html);
        $this->assertPattern($succReg, $html);
    }

    function testTestDisplayerCreateTable() {
        $db_array = array();
        for ($i = 0; $i < 10; $i++) {
            array_push($db_array, array(
                entryDate => '2012-04-07 21:27:45',
                description => 'Execute failed: SELECT COUNT(*) FROM TEST ',
                success => "Pass"
            ));
        }
        $table = TestDisplayer::createTable($db_array);
        $this->assertIsA($table, String);
        $tableReg = '/<table>.*<\/table>/';
        $this->assertPattern($tableReg, $table, "String is a HTML Table");
        $trReg = '/.*<tr>.*<\/tr>.*/';
        $this->assertPattern($trReg, $table, "HTML Table has a Row");
        $thReg = '/.*<th>.*<\/th>.*/';
        $this->assertPattern($thReg, $table, "HTML Table has a Head Cells");
    }

}

?>
