<?php 

// Many special selects will work off of the baseDataPipe with a simple change
// in the where clause.

class EssayAnswerDataPipe extends ManyDataPipe {

	protected $essayoid;
	
	function __construct($tableMapManager, $dataManager) {
		parent::__construct($tableMapManager, $dataManager);
		$this->essayoid = $_REQUEST['essayoid'];		
	}
	
	function where() {	
		if ( $this->foreignKey == "authoroid" ) {
			$where = "WHERE ".$this->tableName.".".$this->foreignKey." = '".$this->foreignValue."'" and "essayoid = '".$this->essayoid."' ";
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
					." and ".$this->tableName.".".security." <= ".$this->security." and essayoid = '".$this->essayoid."'";
		}
	}
	
}

?>