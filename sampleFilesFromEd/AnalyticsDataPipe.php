<?php

class AnalyticsDataPipe extends BaseDataPipe {

	protected $ip;
	protected $command;
	protected $description;
	
	function __construct($tableMapManager, $dataManager) {
		parent::__construct($tableMapManager, $dataManager);
		$this->ip = $_SERVER['REMOTE_ADDR'];
		$this->command = $_REQUEST['command'];
		$this->description = $_REQUEST['description'];
	}
	
	function insert() {
		$sql = "INSERT INTO analytics ( IPaddress, command, description ) ";
		$sql .= "VALUES ( '".$this->ip."', '".$this->command."', '".$this->description."')";
		return $sql;
	}
	
	function execute() {
		$sql = $this->insert();
		$result = $this->dataManager->execute($sql);
		return $result;
	}
	
	function resultToXML($recordSet) {
		$XML = "";
		$successFlag = "@true@";
		if ( $recordSet != 1 ) {
			$successFlag = "@false@";
		}
		$XML .="<row tableName=\"success\">";
		$XML .= "<field name=\"object_ID\">".getObjectID()."</field>";
		$XML .= "<field name=\"result\">".$successFlag."</field>";
		$XML .= "</row>";
		return $XML;
	}
	
}
	
?>