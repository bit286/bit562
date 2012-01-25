<?php

// phpPackager puts HTML around php class name lines, comments, method calls,
// and codelines.
class phpPackager implements Packager {
   
   private $divCount = 0;
   
   function __construct() {
      
   }
   
   public function packager($fileLine, $braceCount) {
      
      $html = '';
      
      if (strpos($fileLine, 'function') > -1) {
         $this->divCount = $braceCount;
      }
      
      // Code for putting HTML around the code line goes here.
      
      // Close off the nested <div> surrounding the code.
      if ($divCount === $braceCount) {
         $html .= '</div>';
      }
      
      return $html;
   }
}

?>
