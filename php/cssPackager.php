<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* 
 * create the code for packaging the css file as html
 * test line
 */
class cssPackager implements Packager {
   
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
