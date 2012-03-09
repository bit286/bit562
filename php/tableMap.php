<?php

/*+
 * NOTE::note=The middle tier code will not function without a
 *          maps table, a masterID table, and a test table.::
 *          author=Ed Anderson::location=tableMap.php
 */


/*********************************************************************
 * In order to have automatic SQL writing in the middle tier, the browser
 * name for data must be mapped to the database column name for the data.
 * One method of creating that map is to put the information in the database.
 * There is a table called tablemaps which has tablename, browserFormName,
 * dbColulmnName, queryType, and dataType as its primary data columns.  The 
 * queryType is 'select', 'insert', or 'update'.  Each record in the table
 * maps one browser field to one data table column so there will be several 
 * records for each browser form.  When the contents of this table are 
 * loaded into memory, each record is stored in a single tableMap object.  
 * 
 * Each select statement used in the application has a list of column names, 
 * e.g., select object_ID, essayoid, authoroid, groupoid, paragraph_ID,
 *              name, note, purpose, security
 *       from enotes
 * The list of column names used in the select can be dynamically constructed
 * from the tableMap objects for the "enotes" table.  
 *
 * A standard calling for naming form data names matching the database
 * column name makes table map records unnceccary.  MOST SELECT COLUMN LISTS
 * are generated from the relevant table itself using 'show columns from tablename'.
 * 
 ********************************************************************/
class tableMap {

    private $values = array();

	function __construct($tableName, 
                                 $browserFormName, 
                                 $dbColumnName, 
                                 $queryType, 
                                 $dataType) {
                                 
		$this->values['table']= $tableName;
		$this->values['browser'] = $browserFormName;
		$this->values['dbCol'] = $dbColumnName;
		$this->values['query']= $queryType;
		$this->values['dataType'] = $dataType;
        
	}

    public function get($element) {
        return $this->values[$element];
    }

}

?>
