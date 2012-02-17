<?php 

// Fundamental data pipe code.  Given a tablemap,  a tablename, a query type,
// an author, and an essay number, automatically create the needed sql for selects,
// insertions, updates, and deletes.  The tablename, query type, author, and essay
// number come in with the REQUEST object.  The rest of the data in the REQUEST
// object is identified from the tablemap.

include ('utilities.php');

class BaseDataPipe {

	protected $mapObjs;
	protected $tableName;
	protected $queryType;
	protected $object_ID;
	protected $dataManager;
	protected $groupoid;
	protected $authoroid;
	
	function __construct($tableMapManager, $dataManager) {
		$this->object_ID = $_REQUEST['object_ID'];
		$this->dataManager = $dataManager;
		$this->tableName = $this->setTableName();
		$this->queryType = $_REQUEST['queryType'];
		$this->groupoid = $_REQUEST['groupoid'];
		if ( !is_string($this->groupoid) ) {
			$this->groupoid = "null";
		}
		
		// Look first to see if there is a map specific to this table and queryType.
		$this->mapObjs = $tableMapManager->findMatchingMaps($this->tableName, $this->queryType);
		
		// If no specific map was found, try the table and the 'select' map.
		if ( count($this->mapObjs) == 0 && $this->tableName !== 'authors') {
			$this->mapObjs = $tableMapManager->findMatchingMaps($this->tableName, "select" );
		}
		
		// If nothing was present in the map table, then get the column headings from the table itself.  Assume 
		// the browser side and the table side are the same in this case.
		if ( count($this->mapObjs) == 0 ) {
			$sql = "SHOW COLUMNS FROM ".$this->tableName;
			$result = $this->dataManager->execute($sql);
			while ( $result_array = mysql_fetch_row($result) ) {
				if ( substr($result_array[1], 0, 3) == "int" ) {
					$alphanumeric = "numeric";	
				}
				else {
					$alphanumeric = "alpha";
				}
				$this->mapObjs[] = new tableMap($this->tableName, $result_array[0],
				      $result_array[0], $this->queryType, $alphanumeric );			
			}
		}
		$this->dataManager->assert($this->groupoidPresent() == true, "Constructor test of groupoidPresent.");
	}
	
	// Execute creates the necessary sql and then executes it.  The result set is returned.
	function execute() {
		$masterSql = "";
		switch ( $this->queryType ) {
		
			case "search";
				$sql = $this->select();
				$this->tableName = $this->tableName."Search";
				break;
				
			case "select":
				$sql = $this->select();
				break;
				
			case "insert":
				$sql = $this->insert();
				$masterSql = "insert into masterID ( object_ID, tableName, authoroid ) ";
				$masterSql .= "values ( '".$this->object_ID."', '".
				            $this->tableName."', '".$_REQUEST['authoroid']."' )";
				break;
				
			case "delete":
				$sql = $this->delete();
				$masterSql = "delete from masterid where object_ID = '".$this->object_ID."'";
				break;
				
			case "update":
				$sql = $this->update();
				$masterSql = "update masterid set entryDate = '".date('Y-m-d H:i:s').
					 "' where object_ID = '".$this->object_ID."'";
				break;
		}
		if ( strlen($masterSql) > 0 ) {
			$this->dataManager->manageMasterID($masterSql);
		}
		$this->dataManager->testDescription($this->dataManager->scrub($sql));
		$result = $this->dataManager->execute($sql);
		return $result;
	}
	
	function select() {
		$sql = "SELECT ";
		$fieldList = "";
		$fieldList = $this->fieldList($fieldList);
		$from = " FROM ".$this->tableName." ";
		$sql .= $fieldList.$from.$this->where();
		return $sql;
	}
	
	function insert() {
		$_REQUEST['object_ID'] = getObjectID();
		$this->object_ID = $_REQUEST['object_ID'];
		$sql = "INSERT INTO ".$this->tableName;
		$fieldList = " ( ";
		$fieldList = $this->fieldList($fieldList)." ) ";
		$values = "VALUES ( ";
		for ( $i=0; $i<count($this->mapObjs); $i+=1 ) {
			if ( $this->mapObjs[$i]->getDataType() == "alpha" ) {
				$thisData = 
					$this->dataManager->scrub($_REQUEST[$this->mapObjs[$i]->getBrowserFormName()]);
				if ( strpos($this->mapObjs[$i]->getBrowserFormName(), "Date") > 0 ) {
					if ( strlen($thisData) == 0 ) {
						$thisData = "0000-00-00";
					}
				}
				if ( $this->mapObjs[$i]->getBrowserFormName() != "entryDate" ) {
					$values .= "'".$thisData."', ";
				}
			}
			else {
				$thisData = $_REQUEST[$this->mapObjs[$i]->getBrowserFormName()];
				if ( strlen($thisData) == 0 ) {
					$thisData = 0;
				}
				$values .= $thisData.", ";
			}
		}
		$values = substr($values, 0, strrpos($values, ", "))." ) ";
		$this->dataManager->testDescription($this->dataManager->scrub("From baseDataPipe insert: ".$sql.$fieldList.$values));
		return $sql.$fieldList.$values;
		
	}
	
	// Can't take this out without removing it from the master index as well.  There are trigger issues as well.
	function delete() {
		$sql = "DELETE FROM ".$this->tableName." ".$this->where();
		return $sql;
	}
	
	function update() {
		$sql = "UPDATE ".$this->tableName." SET ";
		for ( $i=0; $i<count($this->mapObjs); $i+=1 ) {
		
			// Analyze each field to insure that it has data.  If data is missing, the field does not get added to the update.
			$browserField = $this->mapObjs[$i]->getBrowserFormName();
			$dataValue = $_REQUEST[$this->mapObjs[$i]->getBrowserFormName()];
			if ( $this->mapObjs[$i]->getDataType() == "alpha" || strpos($browserField, "Date") ) {
				if ( strlen($dataValue) < 1 )
					continue;
			}
			if ( $this->mapObjs[$i]->getDataType() == "numeric" ) {
				if ( !is_numeric($dataValue) ) 
					continue;
			}
			
			$sql .= $this->mapObjs[$i]->getDBColumnName()." = ";
			if ( $this->mapObjs[$i]->getDataType() == "alpha" ) {
				$sql .= "'".$this->dataManager->scrub($_REQUEST[$this->mapObjs[$i]->getBrowserFormName()])."', ";
			}
			else {
				$sql .= $_REQUEST[$this->mapObjs[$i]->getBrowserFormName()].", ";
			}
		}
		$sql .= "entryDate = '".date('Y-m-d H:i:s')."', ";
		$sql = substr($sql, 0, strrpos($sql, ", "))." ";
		$sql .= $this->where();
		return $sql;
	}

	function resultToXML($recordSet) {
		$XML = "";
		$offset = 1;
		if ( $this->tableName === "viewers"
             || $this->tableName === "allcomments" 
			 || $this->tableName === "alternativeqs" )
			$offset = 0;
		switch ( $this->queryType ) {
			case "update" :
			case "delete" :
			case "insert" :
				$successFlag = "@true@";
				if ( $recordSet != 1 ) {
					$successFlag = "@false@";
				}
				$XML .="<row tableName=\"success\">";
				$XML .= "<field name=\"object_ID\">".$this->object_ID."</field>";
				$XML .= "<field name=\"result\">".$successFlag."</field>";
				$XML .= "</row>";
				break;
			case "keyword" :
				$this->tableName = "keywords";
			case "search" :
			case "select" :
				while ( $record = mysql_fetch_row($recordSet) ) {					
					$XML .= "<row tableName=\"".$this->tableName."\">";
					for ( $i=0; $i<count($this->mapObjs)-$offset;$i+=1 ) {
						$XML .= "<field name=\"".$this->mapObjs[$i]->getBrowserFormName().
						           "\">".$this->dataManager->deScrub($record[$i]);
						$XML .= "</field>";
					}

					if ( strlen($record[$i]) > 0 ) {
						$XML .= "<field name=\"commentPresent\">".$this->dataManager->deScrub($record[$i]);
						$XML .= "</field>";
					}
					$XML .= "</row>";

				}				
		}
		
		return $XML;
	}
	
	function where() {
		return "WHERE object_ID = '".$this->object_ID."'";
	}
	
	// Convert the mapObjs into a field list for a SQL command.
	function fieldlist($fieldList) {
		for ( $i=0; $i<count($this->mapObjs); $i+=1 ) {
			if ( stripos($this->mapObjs[$i]->getDBColumnName(), "entryDate") === false ) {
				if ( stripos($this->mapObjs[$i]->getDBColumnName(), ".") === false )
					$fieldList .= $this->tableName.".".$this->mapObjs[$i]->getDBColumnName().", ";
				else
					$fieldList .= $this->mapObjs[$i]->getDBColumnName().", ";
			}
		}
		if ( strrpos($fieldList, ", " ) ) {
			$fieldList = substr($fieldList, 0, strrpos($fieldList, ", "));
		}
		return $fieldList;
	}
		
	// If the tableName is given in the REQUEST, use it.  Otherwise, look up the object_ID in the masterid
	// table and find the name of the table it resides in.
	function setTableName() {
		$this->tableName = $_REQUEST['tableName'];
		if ( strlen($this->tableName) > 0 ) {
			return $this->tableName;
		}
		
		return lookUpInMaster( $this->object_ID );
		
	}
	
	function getTableName() {
		return $this->tableName;
	}
	
	// Look through the tableMaps to see if one of them is a groupoid.  Return true if there is one.
	function groupoidPresent() {
		$len = count($this->mapObjs);
		for ( $i=0; $i<$len; $i+=1 ) {
			if ( $this->mapObjs[$i]->getDBColumnName() == "groupoid" ) 
				return true;		
		}
		return false;			
	}
		
}

?>