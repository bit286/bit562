<?php

// Return the keywords for all records in a table

class KeyWordDataPipe extends BaseDataPipe {

	protected $security;

	function __construct($tableMapManager, $dataManager) {
		parent::__construct($tableMapManager, $dataManager);
		$this->authoroid = $_REQUEST['authoroid'];
		$this->security = $_REQUEST['security'];
	}
	
	function execute() {
		$sql = $this->select();
		$this->dataManager->testDescription("From KeyWordDataPipe.execute: ".$this->dataManager->scrub($sql));
		$result = $this->dataManager->execute($sql);
		return $result;		
	}
	
	function select() {
		$sql = "SELECT object_ID, keywords ";
		$from = " FROM ".$this->tableName." ";
		$sql .= $from.$this->where();
		return $sql;		
	}
	
	function where() {
		if ( strlen($this->groupoid) < 23 ) {
			$clause = " where authoroid = '".$this->authoroid."'";
			$clause .= " and security <= ".$this->security;
			return $clause;
		}
		else {
			$clause = " where groupoid = '".$this->groupoid."'";
			$clause .= " and security <= ".$this->security;
			return $clause;
		}
	}
	
	function resultToXML($recordSet) {
		$XML = "";
		while ( $record = mysql_fetch_row($recordSet) ) {
			$XML .= "<row tableName=\"keywords\">";
			$XML .= "<field name=\"object_ID\">".$this->dataManager->deScrub($record[0])."</field>";
			$XML .= "<field name=\"keywords\">".$this->dataManager->deScrub($record[1])."</field>";
			$XML .= "</row>";
		}
		// $this->dataManager->testDescription($this->dataManager->deScrub($XML));
		return $XML;
	}
	

}


?>