<?php 

// Many special selects will work off of the baseDataPipe with a simple change
// in the where clause.

class EssayQuestionDataPipe extends ManyDataPipe {

	protected $essayoid;
	
	function __construct($tableMapManager, $dataManager) {
		parent::__construct($tableMapManager, $dataManager);
		$this->essayoid = $_REQUEST['essayoid'];
	}
	
	function where() {
		$where = "WHERE ( essayoid = '".$this->essayoid."' AND purpose = 'essay' AND ".$this->tablename."security <= ".$this->security." )";
		if ( $this->foreignKey == "authoroid" ) {
			$where .= " OR  (".$this->tableName.".".$this->foreignKey." = '".$this->foreignValue."'" and "essayoid = '".$this->essayoid."' ";
			$where .= "and purpose = 'personal' ";
			if ( $this->groupoidPresent() ) {
				$where .= " and CHAR_LENGTH(".$this->tableName.".groupoid) < 23 ";
			}
			if ( $this->security ) {
				$where .= "and ".$this->tableName.".".security." <= ".$this->security;
			}
			$where .= " )";
			return $where;
		}
		else {
			return "OR (".$this->tableName.".".$this->foreignKey." = '".$this->foreignValue."'"
					." and ".$this->tableName.".".security." <= ".$this->security." and essayoid = '".$this->essayoid."' )";
		}
		
		return $where;
	}
	
}

?>