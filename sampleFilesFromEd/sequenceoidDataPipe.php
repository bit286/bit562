<?php 

class SequenceoidDataPipe extends BaseDataPipe {

	protected $foreignKey;
	
	function __construct($tableMapManager, $dataManager) {
		parent::__construct($tableMapManager, $dataManager);
		$this->foreignKey = $_REQUEST['foreignKey'];
	}
	
	function message() {
		return "From message in SequenceoidDataPipe object.";
	}
	
	// Execute creates the necessary sql and then executes it.  The result set is returned.
	function execute() {
		switch ( $this->queryType ) {
			case "select":
				$sql = $this->select();
				break;
			case "insert":
				$sql = $this->insert();
				break;
			case "delete":
				$sql = $this->delete();
				break;
			case "update":
				$sql = $this->update();
				break;
		}
		$result = $this->dataManager->execute($sql);
		return $result;
	}

	function delete() {
		$sql = "DELETE FROM ".$this->tableName." ".$this->where();
		return $sql;
	}
		
	function where() {
		return "WHERE ".$this->foreignKey." = '".$this->object_ID."'";
	}
	
}
?>