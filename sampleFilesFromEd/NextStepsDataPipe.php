<?php

// Complex query designed to produce a list of next steps from all of
// an authors projects.  To use this object send
//   var obj = {};
//   obj.tableName = "nextsteps";
//   obj.queryType = "nextsteps";
//   obj.object_ID = STRUCTURE.getAuthor();

class NextStepsDataPipe extends BaseDataPipe {

	function __construct($tableMapManager, $dataManager) {
		parent::__construct($tableMapManager, $dataManager);
	}
	
	function select() {
	   $sql = "select a.object_ID as object_ID, p.projectName as project, p.description as description, p.priority as priority, ";
	   $sql .= "a.dueDate as dueDate, a.name as actionName, a.description as actionDescription ";
	   $sql .= "from projects p, ";
	   $sql .= "(select targetoid, objectoid ";
	   $sql .= "  from sequenceoids o, sequences s ";
	   $sql .= "  where o.seqNum = 1 ";
	   $sql .= "    and o.sequenceoid = s.object_ID ";
	   $sql .= "    and s.authoroid = '".$this->object_ID."' ) as t, actions a ";
	   $sql .= "where p.object_ID = t.targetoid ";
	   $sql .= "  and objectoid = a.object_ID ";
	   $sql .= "  and p.active_inactive = 'true' ";
	   $sql .= "  and a.performed = 'false' ";
	   $sql .= "order by p.priority;";
	   return $sql;
	}
	
}
?>