<?php

/**
 * Description of packagerTests
 *
 * @author Edwin-Lap
 */

/*+ 
 * AUTHOR::name=Ed Anderson::created=02/02/2012;;
 * TRACE::requirement=METADATA.PLANGUAGE::location=myjsPacakger.php::
 *     description=Packager object for wrapping Javascript code in HTML;;
 */
class PackagerTests {
   
   private $tests = array();
   
   function __construct() {
      
      $block = false;
      $wrapper = false;
      $div = false;
      
      $this->tests['comment'] = function($fileLine, $bracecount) use (&$block, &$wrapper, &$div) {
         $fileLine = trim($fileLine);
         $comment = '/*';
         if ((preg_match('/^(\/\/)|^(\/\*)|^(\*\/)/', $fileLine) || $block) && !$wrapper) {
            $fileLine = '<span class="comment bracecount'.$bracecount.'">'.$fileLine.'</span><br />';
            if (strpos($fileLine, '/*') > -1) {
               $block = true;
            }
            if (strpos($fileLine, '*/') > -1) {
               $block = false;
            }
            $wrapper = true;
         }
         return $fileLine;
      };
      
      $this->tests['function'] = function($fileLine, $bracecount) use (&$block, &$wrapper, &$div) {
         if (preg_match('/function/', $fileLine)
               && !$wrapper
               && !$block) {
            $fileLine = '<span class="functionDefinition bracecount'
                  .$bracecount.'">'.$fileLine.'</span><div id="functionBody"><br />';
            if ( !$div && $bracecount > 0 && $bracecount < 2) {
               $fileLine = '<div id="functionDeclaration">'
                           .'<span class="expandFunction">++</span>'.$fileLine;
               $div = true;
            }
            $wrapper = true;
         }
         return $fileLine;
      };
      
      $this->tests['codeline'] = function($fileLine, $bracecount) use (&$block, &$wrapper, &$div) {
         if (!$wrapper && !$block) {
            $fileLine = trim($fileLine);
            if ( strpos($fileLine, '//') > -1 ) {
               $parts = explode('//', $fileLine);
               $parts[1] = '<span class="comment">//'.$parts[1].'</span>';
               $fileLine = implode('', $parts);
            }
            $fileLine = '<span class="codeline bracecount'.$bracecount.'">'.$fileLine.'</span><br />';
            $wrapper = true;
            if ( $div && $bracecount == 1) {
               $fileLine .= "</div></div>";
               $div = false;
            }
         }
         return $fileLine;
      };
      
      $this->tests['setFlags'] = function() use (&$wrapper) {
         $wrapper = false;
         $block = false;
      };
      
   }
   
   public function getTests() {
      return $this->tests;
   }
   

}

?>
