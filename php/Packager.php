<?php
/***************************************************************************
 *
 * There is only one Packager object.  What changes is the test sequence
 * sent from the PackagerFactory.  The test sequence essentially passes
 * the code that the Packager executes as it works on file lines.  Packager
 * only does one fileLine at a time.  Reader sends the fileLines, one line at
 * a time; Packager controls the code executed against the line.
 *
 **************************************************************************/
/*+ 
 * AUTHOR::name=Ed Anderson::created=02/02/2012;;
 * TRACE::requirement=METADATA.PLANGUAGE::location=Packager.php::
 *     description=Packager object controls wrapping Javascript code in HTML;;
 */

 /*+
	LINK::href=PackagerTests.html::title=Home of the codeline tests and 
		HTML packaging::visible=Go to PackagerTests;;
	LINK::href=PackagerFactory.html::title=Source of all packager objects::
		visible=The source of packager objects for each file type.
*/

include('packagerTests.php');

class Packager {
   
   private $packagerTestObj;
   private $tests = array();
   private $testFlags = array();
   private $braceCount = 0;
   
   function __construct($testSequenceFromPackagerFactory) {
      $this->packagerTestObj = new PackagerTests();
      $this->tests = $this->packagerTestObj->getTests();
      $this->testFlags = $testSequenceFromPackagerFactory;
   }
   
   public function packager($fileLine, &$braceCount) {
         
      // Test for each line type in the javascript array.  
		// Wrap the line in HTML once an approriate test is found.
		// Package with HTML when a test is triggered.
      $this->tests['setWrapper']();
      foreach ($this->testFlags as $name) {
         $fileLine = $this->tests[$name]($fileLine, $braceCount);
      }
      
      return $fileLine;
      
   }

   // Function added by Michael Olmstead. Created 02/29/2012.
   // A zero count indicates that file type to be packaged
   // is not recognized by the ProjectFactory.
   public function getTestFlagsCount() {
      return count($this->testFlags);
   }
   
}

?>
