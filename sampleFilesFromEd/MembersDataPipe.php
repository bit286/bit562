<?php 

// Many special selects will work off of the baseDataPipe with a simple change
// in the where clause.  Some require a change to the select and the where.  This 
// latter case occurs when two or more tables are involved.

class MembersDataPipe extends BaseDataPipe {

	protected $groupoid;
	
	function __construct($tableMapManager, $dataManager) {
		parent::__construct($tableMapManager, $dataManager);
		$this->groupoid = $_REQUEST['groupoid'];
	}
	
	function select() {
		$sql = "select m.object_ID, m.name, a.lastName, a.firstName, a.user_ID, m.security, m.groupoid, m.authoroid ";
		$sql .= "from members m, authors a ";
		$sql .= $this->where();
		return $sql;
	}
	
	function where() {
		return "WHERE m.groupoid = '".$this->groupoid."' and m.authoroid = a.object_ID";
	}
	
}

?>