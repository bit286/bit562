<?php

class SiteFeedbackDataPipe extends BaseDataPipe {

	protected $authoroid;
	protected $remote_addr;
	
	function __construct($tableMapManager, $dataManager) {
		parent::__construct($tableMapManager, $dataManager);
		$_REQUEST['remote_addr'] = $_SERVER['REMOTE_ADDR'];
		$this->remote_addr = $_REQUEST['remote_addr'];
		$this->authoroid = $_REQUEST['authoroid'];
		if ( strlen($authoroid) < 23 ) 
			$_REQUEST['authoroid'] = "sitex-sitex-sitex-sitex";
	}
	
	function select() {
		$sql = "SELECT ";
		$fieldList = "";
		$fieldList = $this->fieldList($fieldList);
		$from = " FROM sitefeedback ";
		$sql .= $fieldList.$from.$this->where();
		return $sql;
	}
	
	function where() {
		if ( strlen($this->authoroid) == 23 ) {
			$where = "WHERE authoroid = '".$this->authoroid."'";
		}
		else {
			$where = "WHERE remote_addr = '".$this->remote_addr."'";
		}
		return $where;	
	}
	
}
	
?>