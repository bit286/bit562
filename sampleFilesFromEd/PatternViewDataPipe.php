<?php 

// There is no table named patternsview.  The patterns table is a crossreference
// table supporting a many-to-many relationship between pages and frames.
// The PatternsView pipe pulls data from frames depending on the pattern name
// sent as part of the command.

/* var command = {
		pipe : "patternview",
		tableName : "patternview",
		queryType : "select",
		name : "essayDisplay"
	}
	
Since there is no table for a view, the view list will have to be put in "tablemaps".

*/

class PatternViewDataPipe extends BaseDataPipe {

	protected $name;
	
	function __construct($tableMapManager, $dataManager) {
		parent::__construct($tableMapManager, $dataManager);
		$this->name = $_REQUEST['name'];
	}
	
	function select() {
		$sql = "SELECT patterns.object_ID, pages.name, patterns.name, frames.datatype, frames.frame, patterns.security ";
		$from = "FROM pages, patterns, frames ";
		return $sql.$from.$this->where();
	}
	
	function where() {
		return "WHERE pages.object_ID = patterns.pageoid AND frames.object_ID = patterns.frameoid AND patterns.name = '".$this->name."'";
	}
	
}

?>