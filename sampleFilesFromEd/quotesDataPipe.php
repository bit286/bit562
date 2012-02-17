<?php 

// Many special selects will work off of the baseDataPipe with a simple change
// in the where clause.  Some require a change to the select and the where.  This 
// latter case occurs when two or more tables are involved.

// ChangeGroupDataPipe works with 

class QuotesDataPipe extends BaseDataPipe {

	protected $foreignKey;
	protected $foreignValue;
	protected $security;
	protected $biblioid;
	
	function __construct($tableMapManager, $dataManager) {
		parent::__construct($tableMapManager, $dataManager);
		$this->foreignKey = $_REQUEST['foreignKey'];
		$this->foreignValue = $_REQUEST['foreignValue'];
		$this->security = $_REQUEST['security'];
		$this->biblioid = $_REQUEST['biblioid'];
	}
	
	function select() {
		$sql = "SELECT ";
		$fieldList = "";
		$fieldList = $this->fieldList($fieldList);
		$fieldList .= ", IFNULL(comment, \"false\")";
		$from = " FROM ".$this->tableName." left join comments on ".$this->tableName.".object_ID = comments.targetoid ";
		$sql .= $fieldList.$from.$this->where();
		return $sql;
	}	
		
	function where() {
		$where = " WHERE ".$this->tableName.".".$this->foreignKey." = '".$this->foreignValue;
		$where .= "' and security <= ".$this->security;
		$where .= " and biblioid = '".$this->biblioid."'";
		return $where;
	}
	
	
	
	
	
}

?>