<?php

// A tablemap object holds one tableMap record.  Used in automatically creating select,
// insert, and update statements for moving data to and from forms and tables.
// They are also used when making XML from resultsets captured during selects.
class tableMap {

	private $tableName;
	private $browserFormName;
	private $dbColumnName;
	private $queryType;
	private $dataType;

	function __construct($tableName, $browserFormName, $dbColumnName, $queryType, $dataType) {
		$this->tableName = $tableName;
		$this->browserFormName = $browserFormName;
		$this->dbColumnName = $dbColumnName;
		$this->queryType = $queryType;
		$this->dataType = $dataType;
	}

	function getTableName() {
		return $this->tableName;		
	}
	
	function getBrowserFormName() {
		return $this->browserFormName;
	}
	
	function getDBColumnName() {
		return $this->dbColumnName;
	}
	
	function getDataType() {
		return $this->dataType;
	}
	
	function getQueryType() {
		return $this->queryType;
	}
	
	function compare ( $tableName, $queryType ) {
		return ($this->tableName == $tableName) && ($this->queryType == $queryType);
	}
	
}

?>