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
        $this->user = $_REQUEST['email'];       
    }

    function where() {
        return "WHERE email LIKE '".$this->user."'";
    }

}

