<?php

   function createIndentationHTML($lineOut, $braceCount) {
      
      $html = "";
      $indentNumber = $braceCount;
      if (strpos($lineOut, "}") > -1 ) {
         $indentNumber -= 1;
      }
      // Add one image for each braceCount.
      for ($i=0; $i<$indentNumber; $i += 1) {
         $html .= '<img src="../images/whiteBlank.gif" height="10" width="24"></img>';
      }
      return $html;
   }
?>
