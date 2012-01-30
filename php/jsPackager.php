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
		
		/*
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
		*/
		
		
		$commented = $this->commentParse($fileLine);
		$thenFunctioned = $this->functionParse($commented);
		
		if ($fileLine == $thenFunctioned)
		{
			$html = '<div class="code-line">' . $thenFunctioned . '</div>';
			
		}
		else
		{
			$html = $thenFunctioned;
		}
		
		
		
		
		
		return $html;
	}
	
	public function commentParse($line)
	{	
		$myCommentRegex = "/(?<!\:)\/\//";
		$matched = preg_match($myCommentRegex, $line, $theMatches);
		if($matched === 1)
		{
			//explode($theMatches[1], $line, $theLineArray);
			$startOfComment = strpos($line, $theMatches[0]) - 1;
			if ($startOfComment > 0)
			{
				$theLineArray = str_split($line, $startOfComment);
				$newLine = '';
				$newLine .= $theLineArray[0];
				$newLine .= '<div class="comment">';
				$theCount = count($theLineArray);
				for ($i = 1; $i < $theCount; $i++)
				{
					$newLine .= $theLineArray[$i];
				}
				$newLine .= '</div>';
			}
			else
			{
				$newLine = '<div class="comment">' . $line . '</div>';
			}
			
			$line = $newLine;
		}		
		//return '<div class="code-line">' . $line . '</div>';
		return $line;
	}
	
	public function functionParse($line)
	{
		$myFunctionRegex = '/(function)(?!\(\))/';		
		$matched = preg_match($myFunctionRegex, $line, $theMatches);
		if ($matched === 1)
		{
			$line = '<div class="functionBlock">' . $line . '</div>';
			$this->divCount += 1;
		}
		
		return $line;
	}
}
