<?php

/**********************************************************
 *  Post for this data pipe with:
 *     {
            "pipe" : "projectfiles",
 *          "queryType" : "select",
 *          "tableName" : "projectfiles",
 *          "project" : "BIT561"
 *      }
 **********************************************************/
class ProjectFilesDataPipe extends baseDataPipe {

    protected $project;
    
    function __construct($tableMapManager, $dataManager) {
		parent::__construct($tableMapManager, $dataManager);
		$this->project = $_REQUEST['project'];       
    }
    
    function where() {
        return "WHERE project = '".$this->project."'";
    }
    
}

?>