<?php
// This makeshift Unit Testing framework relies on convention over configuration
// runTests($verbose) will find all test Classes in $testDirectory
// Then it will load all public methods as tests and run them.
// Setting the $verbose flag to TRUE will output html to the browser.
// With the $verbose flag set to FALSE, the runTests() method returns an array of test results.
// The array is multidimensional as follows. array[testClassName][methodName] = $result
// Results are TRUE for test success and FALSE for test failure.


//Conventions: (must = required, should = recommended)

// "include()"s within test class files must be relative to the entry point. (UTJumpPoint.php is currently located in "tests")
// Test classes must inherit baseTest
// Test class must be the same as the class it is testing + "UT"
// Test class Files must be the class name + ".php"
// The only public methods of Test classes must be tests.  Utility methods can be defined but must be private or protected.






class UnitTester {

    //requires trailing slash
    private $testDirectory = './unit-tests/';
    
    
    public function runTests($verbose) {
        $theTestFiles = $this->getTestFiles();
        foreach($theTestFiles as $testFile) {
            require_once($this->testDirectory.$testFile);
            $testClassName = explode(".php", $testFile);
            $testClass = new $testClassName[0];
            
            $testClass->runTests($verbose);
            
        }
    }
    
    private function isTestFile($fileName) {
        if(substr($fileName, -6) == "UT.php") {
            
            return TRUE;
        }
        else {
        return FALSE;
        }
    }
    
    private function getTestFiles() {
        $unscannedFiles = scandir('./unit-tests/');
        $scannedFiles = array();
        foreach($unscannedFiles as $file) {
            if($this->isTestFile($file)) {
                array_push($scannedFiles, $file);
            }
        }
        return $scannedFiles;
    }
 
}