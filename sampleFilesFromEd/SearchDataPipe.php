<?php

// Searching is a capability that goes with several forms.  Carousel sets up the search and 
// sends the request.  The search is primarily dictated by the where clause, consequently,
// the where below is considerably more complicated than is normal for datapipe where
// clauses.

// Searches supported:
//    More than one word can be or'd together in a field being searched, e.g., mind || management.
//    More than one word can be and'd together in a field being searched. e.g., mind && management.
//    Phrases in quotes will be searched for as a unit.
//    Individual words within a field will be searched for as or'd together.

class SearchDataPipe extends BaseDataPipe {

	Protected $authoroid;
	Protected $security;
	
	function __construct($tableMapManager, $dataManager) {
		parent::__construct($tableMapManager, $dataManager);
		$this->authoroid = $_REQUEST['authoroid'];
		$this->security = $_REQUEST['security'];
	}
	
	// Returns a where clause to limit the search select.
	function where() {
		if ( strlen($this->groupoid) < 23 ) {
			$clause = " WHERE authoroid = '".$this->authoroid."' and (";
		}
		else {
			$clause = " WHERE groupoid = '".$this->groupoid."' and (";
		}
		for ( $i=0; $i<count($this->mapObjs); $i+=1 ) {
		
			// Look through the request fields using the mapObject to dictate the form field names.
			$searchName = $this->mapObjs[$i]->getBrowserFormName();
			if ( substr($searchName, count($searchName)-4, 3) == "oid" || $searchName == "security")
				continue;
			
			// Find the form field name value, if there is one.
			$searchValue = $_REQUEST[$this->mapObjs[$i]->getBrowserFormName()];
			if ( $searchValue ) {
				$searchValue = $this->dataManager->scrub($searchValue);
				
				// Break a field like "mind || management" into its pieces.  Returns a single word if no || is present.
				$orSearchPieces = explode("||", trim($searchValue));
				for ( $k=0; $k<count($orSearchPieces); $k+=1 ) {
					// Break a field like "mind && management" into its pieces.  Returns a single word if no && is present.
					$andSearchPieces = explode("&&", $orSearchPieces[$k]);
					for ( $ndx=0; $ndx<count($andSearchPieces); $ndx+=1 ) {
					
						// Look for quote marks.  Expressions in quotes (phrases) are searched for as a unit.
						if ( substr($andSearchPieces[$ndx], 0, 1 ) == '"' ) {
							$begin = strpos($andSearchPieces[$ndx], '"')+1;
							$end = strripos($andSearchPieces[$ndx], '"')-1;
							if ( $ndx < count($andSearchPieces)-1 )
								$andOr = " or";
							else
								$andOr = "";
							$phrase = substr($andSearchPieces[$ndx], $begin, $end );
							$clause .= $this->likeWriter( $this->mapObjs[$i]->getBrowserFormName(),
								$phrase, $andOr);
						}
						else {
							$spaceSearchPieces = explode(" ", trim($andSearchPieces[$ndx]));
							for ( $fin=0; $fin<count($spaceSearchPieces); $fin+=1 ) {
								if ( $fin < count($spaceSearchPieces)-1 )
									$andOr = "or";
								else
									$andOr = "";
								$clause .= $this->likeWriter( $this->mapObjs[$i]->getBrowserFormName(),
									$spaceSearchPieces[$fin], $andOr );
							}
							if ( $ndx < count($andSearchPieces)-1)
								$clause .= " and ";
						}
					}
					if ( $k < count($orSearchPieces)-1 )
						$clause .= " or ";
				}
				$clause .= " or ";
			}		
		}
		$clause = substr($clause, 0, count($clause)-4).")";
		$clause .= " and security <= ".$this->security;
		
		// The consolidation field is a special case.  It always needs to be and'd.
		$clause = str_replace("or consolidation", "and consolidation", $clause);
		return $clause;
	}
	
	// Construct the next and/or phrase in the where class.
	function likeWriter( $field, $likeValue, $andOr ) {
		$phrase = $field." like '%".$likeValue."%' ";
		if ( $andOr ) 
			$phrase .= $andOr." ";
		return $phrase;		
	}

}

?>