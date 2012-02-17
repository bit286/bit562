<?php

// Returns viewers selected by a particular user along with their lastname, firstname, and userid from the authors table.

class ViewerDataPipe extends BaseDataPipe {

	protected $security;

	function __construct($tableMapManager, $dataManager) {
		parent::__construct($tableMapManager, $dataManager);
		$this->authoroid = $_REQUEST['authoroid'];
	}
	
	function select() {
	    $sql = "SELECT ";
		$fieldList = "";
		$fieldList = $this->fieldList($fieldList);
		$fieldList .= ", IFNULL(comment, \"false\")"; 
		$from = " FROM viewers left join comments on viewers.object_ID = comments.targetoid, authors ";
		$sql .= $fieldList.$from.$this->where();
		return $sql;		
	}
	
	function where() {
		$where = " where vieweroid = authors.object_ID ";
		$where .= " and viewers.authoroid = '".$this->authoroid."'";
		return $where;
	}
	
}

