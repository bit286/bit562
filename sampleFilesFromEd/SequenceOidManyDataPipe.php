<?php 

// Used to read and sort sequenceoids.
class SequenceOidManyDataPipe extends BaseDataPipe {

	protected $foreignKey;
	
	function __construct($tableMapManager, $dataManager) {
		parent::__construct($tableMapManager, $dataManager);
		$this->foreignKey = $_REQUEST['foreignKey'];
		$dataManager->testDescription("SequenceOidManyDataPipe constructor.");
	}
	
	function where() {
		return "WHERE ".$this->foreignKey." = '".$this->object_ID."' ORDER BY seqNum";
	}
	
}


?>