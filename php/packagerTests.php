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
      $divcounter = 0;
      $functionmarker = 0;
      
      $this->tests['comment'] = function($fileLine, $bracecount) use (&$block, &$wrapper, &$div) {
         $fileLine = trim($fileLine);
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
      
      $this->tests['class'] = function($fileLine, &$bracecount) use (&$block, &$wrapper, &$divcounter) {
         if (preg_match('/class/', $fileLine)
               && !$wrapper
               && !$block) {
            $fileLine = '<span class="classDefinition bracecount'
                  .$bracecount.'">'.$fileLine.'</span><div id="classBody">';
            $bracecount++;
            $wrapper = true;
         }
         return $fileLine;
      };
      
      $this->tests['function'] = function($fileLine, &$bracecount) use (&$block, &$wrapper, &$functionmarker) {
         if (preg_match('/function/', $fileLine)
               && !$wrapper
               && !$block) {
            $fileLine = '<span class="functionDefinition bracecount'
                  .$bracecount.'">'.$fileLine.'</span><div id="functionBody">';
            if ( $functionmarker === 0 ) {
               $fileLine = '<div id="functionDeclaration">'
                           .'<span class="expandFunction">++</span>'.$fileLine;
               $bracecount++;
               $functionmarker = $bracecount;
            }
            $wrapper = true;
         }
         return $fileLine;
      };
      
      $this->tests['codeline'] = function($fileLine, &$bracecount) use (&$block, &$wrapper, &$functionmarker) {
         if (!$wrapper && !$block) {
            $fileLine = trim($fileLine);
            if ( strpos($fileLine, '//') > -1 ) {
               $parts = explode('//', $fileLine);
               $parts[1] = '<span class="comment">//'.$parts[1].'</span>';
               $fileLine = implode('', $parts);
            }
            $fileLine = $fileLine.'</span><br />';
            $wrapper = true;
            if ( $bracecount > 0 && strpos($fileLine, '}') > -1) {
               $fileLine .= "</div></div>";
               $bracecount === $functionmarker ? $functionmarker = 0 : FALSE;
               $bracecount--;
            }
            $fileLine = '<span class="codeline bracecount'.$bracecount.'">'. $fileLine;
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
