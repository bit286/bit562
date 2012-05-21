<?php

/**************************************************************************************
*
*  CodeLineIdentifierTesting.php
*  When we have a source code line and we want to package that in HTML for
*  AUTODOC presentation, we have to decide what kind of code line we have.
*  A series of classes based on a foundation of CodeLineIdentifier will be used.
*  for that identification. This class begins the testing process for the Identifier
*  objects
*
***************************************************************************************/

require_once('simpletest/autorun.php');
require_once('../classes/CodeLineIdentifier.php');

class CodeLineIdentifierTesting extends UnitTestCase {

  function testForTheExistenceOfCodeLineidentifier() {
    $this->assertTrue(file_exists('../classes/CodeLineIdentifier.php'));
  }
  
  function testForCodeLineIdentifierInstantiation(){
  $codeLineIdentifier = new CodeLineIdentifier();
  $this->assertEqual("CodeIdentifier",get_class($codeLineIdentifier));
  }
}
  
?>
