<?php

/**
 * Description of myjsPackager
 *
 * @author Edwin-Lap
 */

/*+ 
 * AUTHOR::name=Ed Anderson::created=02/02/2012;;
 * TRACE::requirement=METADATA.PLANGUAGE::location=myjsPacakger.php::
 *     description=Packager object for wrapping Javascript code in HTML;;
 */

include('packagerTests.php');

class myjsPackager implements Packager {
   
   private $packagerTestObj;
   private $tests = array();
   private $javascript = array('comment', 'class', 'function', 'codeline');
   
   function __construct() {
      $this->packagerTestObj = new PackagerTests();
      $this->tests = $this->packagerTestObj->getTests();
   }
   
   public function packager($fileLine, &$braceCount) {
         
      // Test for each line type in the javascript array.  Package when a test is found.
      $this->tests['setFlags']();
      foreach ($this->javascript as $name) {
         $fileLine = $this->tests[$name]($fileLine, $braceCount);
      }
      
      return $fileLine;
      
   }
   
}

?>
