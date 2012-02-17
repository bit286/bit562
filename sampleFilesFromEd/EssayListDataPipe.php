<?php 

// Many special selects will work off of the baseDataPipe with a simple change
// in the where clause.

class EssayListDataPipe extends BaseDataPipe {

	protected $courseoid;
	
	function __construct($tableMapManager, $dataManager) {
		parent::__construct($tableMapManager, $dataManager);
		$this->courseoid = $_REQUEST['courseoid'];
	}
	
	function where() {
		return "WHERE courseoid = '".$this->courseoid."'";
	}
	
}

?>