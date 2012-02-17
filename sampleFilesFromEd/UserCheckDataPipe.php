<?php 

// Many special selects will work off of the baseDataPipe with a simple change
// in the where clause.  Some require a change to the select and the where.  This 
// latter case occurs when two or more tables are involved.

class UserCheckDataPipe extends BaseDataPipe {

	protected $lastName;
	protected $firstName;
	protected $user_ID;
	
	function __construct($tableMapManager, $dataManager) {
		parent::__construct($tableMapManager, $dataManager);
		$this->lastName = $_REQUEST['lastName'];
		$this->firstName = $_REQUEST['firstName'];
		$this->user_ID = $_REQUEST['user_ID'];
	}
	
	function select() {
		$sql = "select object_ID from authors ";
		$sql .= $this->where();
		return $sql;
	}
	
	function where() {
		return "WHERE lastName = '".$this->lastName."' and firstName = '".$this->firstName."' and user_ID = '".$this->user_ID."'";
	}
	
	function resultToXML($recordSet) {
		$XML = "";
		while ( $record = mysql_fetch_row($recordSet) ) {
			$XML .= "<row tableName=\"usercheck\">";
			$XML .= "<field name=\"authoroid\">".$this->dataManager->deScrub($record[0])."</field>";
			$XML .= "</row>";
		}
		$this->dataManager->testDescription($this->dataManager->deScrub($XML));
		return $XML;
	}
	
}

?>