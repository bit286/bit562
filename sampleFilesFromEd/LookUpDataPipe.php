<?php 

// Many special selects will work off of the baseDataPipe with a simple change
// in the where clause.

class LookUpDataPipe extends BaseDataPipe {

	function __construct($tableMapManager, $dataManager) {
		parent::__construct($tableMapManager, $dataManager);
	}

	function where() {
		$where = " WHERE authoroid = '".$this->object_ID."'";
		return $where;
	}
	
}

?>