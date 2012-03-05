<?php
/*
 * This file contains Unit tests for baseDataPipe.php
 * author: Chris Griffing
 */

include_once('../BaseDataPipe.php');
include_once('baseTest.php');

class BaseDataPipeUT extends BaseTest {
    // Utility functions
    private function setRequest($object_id, $queryType, $groupoid, $tableName){
        $_REQUEST['object_ID'] = $object_id;
        $_REQUEST['queryType'] = $queryType;
        $_REQUEST['groupoid'] = $groupoid;
        $_REQUEST['tableName'] = $tableName;
    }

    // Tests
    public function arbitrary1() {
        return TRUE;
    }
    public function arbitrary2() {
        return TRUE;
    }
    public function arbitrary3() {
        return FALSE;
    }
    public function arbitrary4() {
        return TRUE;
    }
    
    
    
}
//$theBaseDataPipe = new baseDataPipe();



?>