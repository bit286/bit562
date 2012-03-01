<?php

/**********************************************************
 *  Post for this data pipe with:
 *     {
            "pipe" : "users",
 *          "queryType" : "select",
 *          "tableName" : "users",
 *          "project" : "BIT561"
 *      }
 **********************************************************/
class UsersDataPipe extends baseDataPipe {

    protected $user;

    function __construct($tableMapManager, $dataManager) {
        parent::__construct($tableMapManager, $dataManager);
        $this->user = $_REQUEST['users'];       
    }

    function where() {
        return "WHERE userName = '".$this->user."'";
    }

}

