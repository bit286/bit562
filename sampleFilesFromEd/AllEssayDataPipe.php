<?php 

// Many special selects will work off of the baseDataPipe with a simple change
// in the where clause.

class AllEssayDataPipe extends ManyDataPipe {

	protected $essayoid;
	
	function __construct($tableMapManager, $dataManager) {
		parent::__construct($tableMapManager, $dataManager);
		$this->essayoid = $_REQUEST['essayoid'];		
	}
	
	
}

?>