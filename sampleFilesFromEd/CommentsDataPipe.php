<?php 

// Many special selects will work off of the baseDataPipe with a simple change
// in the where clause.

/* var command = {
		pipe : "comments",
		tableName : "allcomments",
		queryType : "select",
		targetID : "xieir-isiet-ieiwr-skdie"
	}
	
*/

class CommentsDataPipe extends BaseDataPipe {

	protected $author_ID;
	protected $essay_ID;
	
	function __construct($tableMapManager, $dataManager) {
		parent::__construct($tableMapManager, $dataManager);
		$this->target_ID = $_REQUEST['target_ID'];
	}
	
	function select() {
		$sql = "SELECT c.object_ID, c.name, c.comment, c.answerquestion, c.authoroid, c.targetoid, c.targetauthoroid, c.groupoid, a.lastName, a.firstName ";
		$from .= "FROM comments c, authors a ";
		$sql .= $from.$this->where();
		return $sql;
	}
	
	function where() {
		return "WHERE c.targetoid = '".$this->target_ID."' and a.object_ID = c.authoroid";
	}
	
}

?>