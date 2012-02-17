<?php 

// Many special selects will work off of the baseDataPipe with a simple change
// in the where clause.

class ProcedureDataPipe extends BaseDataPipe {

	protected $procedure;
	protected $XML;
	
	function __construct($tableMapManager, $dataManager) {
		parent::__construct($tableMapManager, $dataManager);
		$this->procedure = $_REQUEST['procedure'];
	}
	
	function select() {
		switch ( $this->procedure ) {
			
			case "p_testProcedure":
				$sql = 'call p_testProcedure(1, @answerNum)';
				break;
				
			case "answer_info":
				$sql = 'call answer_info(1, @answers, @numbytes)';
				break;
				
		}
		return $sql;
	}
	
	function execute() {
		$mysqli = new mysqli("localhost", "root", "", "essay");
	
		$sql = $this->select();
		$result = $mysqli->query($sql);
		switch ( $this->procedure ) {
			case "p_testProcedure":				
				$result = $mysqli->query("select @answerNum as answerx");
				break;
			
			case "answer_info":
				$result = $mysqli->query("select @answers as answers, @numbytes as numbytes");
				break;
		}
		$row = $result->fetch_object();
		
		switch ( $this->procedure ) {
			
			case "p_testProcedure":
				$this->XML = "Results of procedure call: ".$row->answerx;
				break;
				
			case "answer_info":
				$this->XML = "Results of procedure call: ".$row->answers."   ->   ".$row->numbytes;
				break;
		}
		
	}
	
	function resultToXML($recordSet) {
		$successFlag = "@true@";
		$XML = "";
		$XML .="<row tableName=\"success\">";
		$XML .= "<field name=\"object_ID\">proce-proce-proce-proce</field>";
		$XML .= "<field name=\"result\">".$successFlag."</field>";
		$XML .= "<field name=\"procXML\">".$this->XML."</field>";		
		$XML .= "</row>";
	
		return $XML;
	}	

}

?>