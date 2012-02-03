<?php

// phpPackager puts HTML around php class name lines, comments, method calls,
// and codelines.
class jsPackager implements Packager {
   
    private $divCount = 0;
    private $commentBlock = FALSE;

    function __construct() {
    }
   
    public function packager($fileLine, $braceCount) {
        
        $html = '';
        $cmExpr = '/(?<!:)\/\/.*$/';
        $fnExpr = '/^(.*)?function(.\w)?\((.*)?\)( )*{/';
        $emExpr = '/^( )*$/';
        $codelineExpr = '';

        // Open's div wrapper for code block
        if ($this->divCount < $braceCount) {
            $this->divCount = $braceCount;
            $html = '<div>';
        }

        // Toggle for comment block
        if (strpos($fileLine, '/*') > -1) {
            $this->commentBlock = TRUE;
        }

        // skip line tests if in a comment block
        if ($this->commentBlock === FALSE) {
            switch ($fileLine) {
                // matches comment
                case (preg_match($cmExpr, $fileLine, $lnCm) ? TRUE : FALSE) :
                    $codeLine = explode("//", $fileLine);
                    isset($lnCm[0]) AND
                        $html .= "<div class='codeLine'>$codeLine[0]<span class='comment'>$lnCm[0]</span></div>";
                    break;
                // matches function
                case (preg_match($fnExpr, $fileLine, $lnFn) ? TRUE : FALSE) :
                    $this->divCount = $braceCount;
                    $html .= "<div class='blockStart'>$fileLine</div>";
                    break;
                // matches empty line
                case (preg_match($emExpr, $fileLine, $lnEm) ? TRUE : FALSE) :
                    break;

                default :
                    $html = "<div class='codeLine'>$fileLine</div>";
            }
        } else {
            $html = "<span class='comment'>$fileLine</span><br />";
        }

        // Toggle turn comment block off
        if (strpos($fileLine, '*/') > -1) {
            $this->commentBlock = FALSE;
        }

        // Close off the nested <div> surrounding the code.
        if ($this->divCount > $braceCount) {
          $this->divCount = $braceCount;
          $html .= '</div>';
        }
        return $html;
    }
}
