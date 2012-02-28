<?php 

/*********************************************************************
 * tableMapManager:
 * A class which looks in tablemaps and finds records which match the tablename and
 * query being executed.  "findMatchingMaps" executes a select against tablemaps and
 * finds a short list of browser to table column maps.  The list is placed into tableMap
 * objects and returned to the calling program, usually a BaseDataPipe.  The class 
 * assumes the database connection passed in through dbName has been opened.
 *********************************************************************/

include('tableMap.php');

class tableMapManager {
	
    private $db = $dbName;
	
	function __construct($dbName) {
        $this->db = $dbName;
	}
	
	// Given a table name and a query type, retrieve matching records from 
    // tableMaps and put them as tableMap objects into an array.  Return the array.
	public function findMatchingMaps( $tableName, $queryType ) {
    
		$shortMap = array();
        
        // Find the tablemap records for this tablename and query type.
        $sql = 'select ';
        $sql = "tableName, browserFormName, dbColumnName, queryType, dataType ";
        $sql .= "from tablemaps ";
        $sql .= "where tableName = '".$tableName."' and queryType = '".$queryType."' ";
        $sql .= "order by tableName, queryType, seqNum";
        $result = $this->db->execute($sql);
        
		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$shortMap[] = new tableMap($row['tableName'], $row['browserFormName'], 
									$row['dbColumnName'], $row['queryType'], $row['dataType']);
		}
		return $shortMap;
	}
	
}


?>