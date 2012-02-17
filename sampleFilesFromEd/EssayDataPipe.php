<?php 

// Many special selects will work off of the baseDataPipe with a simple change
// in the where clause.

class EssayDataPipe extends BaseDataPipe {

	protected $author_ID;
	protected $essay_ID;
	
	function __construct($tableMapManager, $dataManager) {
		parent::__construct($tableMapManager, $dataManager);
		$this->author_ID = $_REQUEST['author_ID'];
		$this->essay_ID = $_REQUEST['essay_ID'];		
	}
	
	function where() {
		return "WHERE author_ID = ".$this->author_ID." and essay_ID = ".$this->essay_ID;
	}
	
}

?>