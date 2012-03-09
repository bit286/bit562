<?php

/*
 * This file contains Unit tests for TableMap
 * author: Chris Griffing
 */
//includes are relative to entry point in the parent folder
include_once("baseTest.php");
include_once("../tableMap.php");

class TableMapUT extends BaseTest {
    
    
    public function testConstructorClassName() {
        $tableMap = new TableMap(
                                    "TestTable",
                                    "TestBrowserFormName", 
                                    "TestDBColumnName", 
                                    "TestQueryType", 
                                    "TestDataType"
                                );
        
        if(get_class($tableMap) != "TableMap") {
            return FALSE;
        }
        return TRUE;
    }
    
    public function testConstructorAndGetTableValue() {
        $tableMap = new TableMap(
                                    "TestTableName",
                                    "TestBrowserFormName", 
                                    "TestDBColumnName", 
                                    "TestQueryType", 
                                    "TestDataType"
                                );
        if($tableMap->get("table") != "TestTableName") {
            return FALSE;
        }
        return TRUE;
    }
    
    public function testConstructorAndGetBrowserValue() {
        $tableMap = new TableMap(
                                    "TestTableName",
                                    "TestBrowserFormName", 
                                    "TestDBColumnName", 
                                    "TestQueryType", 
                                    "TestDataType"
                                );
        if($tableMap->get("browser") != "TestBrowserFormName") {
            return FALSE;
        }
        return TRUE;
    }
    
    public function testConstructorAndGetDBColValue() {
        $tableMap = new TableMap(
                                    "TestTableName",
                                    "TestBrowserFormName", 
                                    "TestDBColumnName", 
                                    "TestQueryType", 
                                    "TestDataType"
                                );
        if($tableMap->get("dbCol") != "TestDBColumnName") {
            return FALSE;
        }   
        return TRUE;
    }
    
    public function testConstructorAndGetQueryValue() {
        $tableMap = new TableMap(
                                    "TestTableName",
                                    "TestBrowserFormName", 
                                    "TestDBColumnName", 
                                    "TestQueryType", 
                                    "TestDataType"
                                );
        if($tableMap->get("query") != "TestQueryType") {
            return FALSE;
        }
        return TRUE;
    }
    
    public function testConstructorAndGetDataTypeValue() {
        $tableMap = new TableMap(
                                    "TestTableName",
                                    "TestBrowserFormName", 
                                    "TestDBColumnName", 
                                    "TestQueryType", 
                                    "TestDataType"
                                );
        if($tableMap->get("dataType") != "TestDataType") {
            return FALSE;
        }
        return TRUE;
    }
    


}






?>