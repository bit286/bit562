<?php 

// Many special selects will work off of the baseDataPipe with a simple change
// in the where clause.

class ManyDataPipe extends BaseDataPipe {

	protected $foreignKey;
	protected $foreignValue;
	protected $security;
	
	function __construct($tableMapManager, $dataManager) {
		parent::__construct($tableMapManager, $dataManager);
		$this->foreignKey = $_REQUEST['foreignKey'];
		$this->foreignValue = $_REQUEST['foreignValue'];
		$this->security = $_REQUEST['security'];
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
		if ( $this->foreignKey == "authoroid" ) {
			$where = "WHERE ".$this->tableName.".".$this->foreignKey." = '".$this->foreignValue."'";
			if ( $this->groupoidPresent() ) {
				$where .= " and CHAR_LENGTH(".$this->tableName.".groupoid) < 23 ";
			}
			if ( $this->security ) {
				$where .= "and ".$this->tableName.".".security." <= ".$this->security;
			}
			return $where;
		}
		else {
			return "WHERE ".$this->tableName.".".$this->foreignKey." = '".$this->foreignValue."'"
					." and ".$this->tableName.".".security." <= ".$this->security;
		}
	}
	
}

?>