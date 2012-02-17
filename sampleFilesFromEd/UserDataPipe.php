<?php 

// Many special selects will work off of the baseDataPipe with a simple change
// in the where clause.

// User datapipe gets you the author record when the user_ID and password are known.

class UserDataPipe extends BaseDataPipe {

	protected $user_ID;
	protected $password;
	
	function __construct($tableMapManager, $dataManager) {
		parent::__construct($tableMapManager, $dataManager);
		$this->user_ID = $_REQUEST['user_ID'];
		$this->password = $_REQUEST['password'];
	}
	
	function where() {
		return "WHERE user_ID = '".$this->user_ID."' and password = '".$this->password."'";
	}
	
}

?>