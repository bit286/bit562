<?php

/**
 * Description of myjsPackager
 *
 * @author Edwin-Lap
 */

/*+ 
 * AUTHOR::name=Ed Anderson::created=02/02/2012;;
 * TRACE::requirement=METADATA.PLANGUAGE::location=Packager.php::
 *     description=Packager object for wrapping Javascript code in HTML;;
 */

include('packagerTests.php');

class Packager {
   
   private $packagerTestObj;
   private $tests = array();
   public $testFlags = array();
   private $braceCount = 0;
   
   function __construct() {
      $this->packagerTestObj = new PackagerTests();
      $this->tests = $this->packagerTestObj->getTests();
   }
   
   public function packager($fileLine, &$braceCount) {
         
      // Test for each line type in the javascript array.  Package when a test is found.
      $this->tests['setFlags']();
      foreach ($this->testFlags as $name) {
         $fileLine = $this->tests[$name]($fileLine, $braceCount);
      }
      
      return $fileLine;
      
   }
   
}

?>
