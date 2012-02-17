<?php 

// Many special selects will work off of the baseDataPipe with a simple change
// in the where clause.  Some require a change to the select and the where.  This 
// latter case occurs when two or more tables are involved.

// ChangeGroupDataPipe works with 

class ChangeGroupDataPipe extends BaseDataPipe {

	protected $authoroid;
	
	function __construct($tableMapManager, $dataManager) {
		parent::__construct($tableMapManager, $dataManager);
		$this->authoroid = $_REQUEST['object_ID'];
	}
	
	function select() {
		$sql = "select g.object_ID, m.authoroid, g.name, description ";
		$sql .= "from members m, groups g ";
		$sql .= $this->where();
		return $sql;
	}
	
	function where() {
		return "WHERE m.authoroid = '".$this->authoroid."' and m.groupoid = g.object_ID";
	}
	
}

?>