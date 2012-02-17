<?php 

// Class designed to handle tablemaps so that select, insert, and update statements
// can be written automatically.  Name form elements, name table elements, and decide 
// which SQL format is needed, then automatically generate SQL, query the DB, and
// save, insert, delete, or select to automatically wrap the data in XML form and 
// send back to the browser.  The tableMapManager assumes an open database.  The 
// tableMapManager needs only be constructed one time per use.  The tablemaps get
// stored in $mapObjects.

include('tableMap.php');

class tableMapManager {
	
	private $mapObjects = array();
	
	// The constructor moves the tableMaps table into memory as the $mapObjects array.
	function __construct($dbName) {
		$sql = "select tableName, browserFormName, dbColumnName, queryType, dataType ";
		$sql .= "from tablemaps order by tableName, queryType, seqNum";
		$result = $dbName->execute($sql);
		while ( $result_array = mysql_fetch_row($result)) {
			$this->mapObjects[] = new tableMap($result_array[0], $result_array[1], 
									$result_array[2], $result_array[3], $result_array[4]);
		}
	}
	
	// Search the mapObjects and find the maps which match table and querytype.  Return the mapObjects as an array.
	function findMatchingMaps( $tableName, $queryType ) {
		$shortMap = array();
		foreach ( $this->mapObjects as $i => $mapObj ) {
			if ( ($mapObj->getTableName() == $tableName) && ($mapObj->getQueryType() == $queryType)) {
				$shortMap[] = $mapObj;
			}	
		}
		return $shortMap;
	}
	
}


?>