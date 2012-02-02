<?php

// phpPackager puts HTML around php class name lines, comments, method calls,
// and codelines.
class jsPackager implements Packager {
   
    private $divCount = 0;

    function __construct() {
    }
   
    public function packager($fileLine, $braceCount) {
        
        $html = '';
        $cmExpr = '/\/\/.*$/';
        $fnExpr = '/^(.*)function(.\w)*\(.*\)( )*{$/';
		$emExpr = '/^( )*$/';
        $codelineExpr = '';

		switch ($fileLine) {
			// matches comment
			case (preg_match($cmExpr, $fileLine, $lnCm) ? TRUE : FALSE ) :
				$codeLine = explode("//", $fileLine);
                isset($lnCm[0]) AND
                    $html = "$codeLine[0]<span class='comment'>$lnCm[0]</span><br />";
				break;
			// matches function
			case (preg_match($fnExpr, $fileLine, $lnFn) ? TRUE : FALSE) :
                $this->divCount = $braceCount;
                $html = "<div><div>$fileLine</div>";
				break;
			// matches empty line
			case (preg_match($emExpr, $fileLine, $lnEm) ? TRUE : FALSE) :
				break;

			default :
				$html = "<div class='codeLine'>$fileLine</div>";
		}
        
        // Close off the nested <div> surrounding the code.
        if ($this->divCount > $braceCount) {
          $this->divCount = $braceCount;
          $html .= '</div>';
        }
		return $html;
    }
}
