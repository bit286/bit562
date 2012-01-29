<?php

// phpPackager puts HTML around php class name lines, comments, method calls,
// and codelines.
class jsPackager implements Packager {
   
	private $divCount = 0;
   
	function __construct() {
      
	}
   
	public function packager($fileLine, $braceCount) {
      
		$html = '';
		$commentExpr = '/^.*(\/\/.*$)+/';
		$functionExpr = '/^.*(function)+(.\w)*\(.*\)( )*{$/';
		$codelineExpr = '//';

		if (strpos($fileLine, 'function') > -1) {
			$this->divCount = $braceCount;
		}
		
		// Code for putting HTML around the code line goes here.

		// matches a line comment
		$commentMatch = preg_match($commentExpr, $fileLine, $lineComment);
		if ($commentMatch === 1) {
			return "<span class=\"comment\">$lineComment[1]</span>";
		}

		$functionMatch = preg_match($functionExpr, $fileLine, $lineFunction);
		if ($functionMatch === 1) {
			return "<span class=\"function\">$lineFunction[0]</span>";
		}
			
		// Close off the nested <div> surrounding the code.
		if ($this->divCount === $braceCount) {
			$html .= '</div>';
		}
		
		return $html;
	}
}
