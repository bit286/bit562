<?php

class BaseTest {

    public function runTests($verbose) {
        $class = get_class($this);
        // if $verbose wasn't set, do nothing
        if($verbose !== TRUE && $verbose !== FALSE) {
            return;
        }
        
        //Filtering out the inherited methods
        $methods = get_class_methods($this);
        $array1 = get_class_methods($class);
        if($parent_class = get_parent_class($this)) {
            $parentMethods = get_class_methods($parent_class);
            $uniqueMethods = array_diff($methods, $parentMethods);
        } else {
            $uniqueMethods = $methods;
        }

        //Filtering out private and protected methods
        $publicMethods = array();
        foreach ($uniqueMethods as $method) {
            $reflect = new ReflectionMethod(get_class($this), $method);
            if($reflect->isPublic()) {
            array_push($publicMethods , $method);
            }
        }
                // verbose checks can be lenient because of the check at the beginning
        
        if($verbose) {
            foreach($publicMethods as $method) {
                $result = eval('return $this->$method();');
                if($result) $result = "TRUE";
                else $result = "FALSE";
                
                echo "| class name: $class | method name: $method | result: $result | <br />";
            }
            return;
        }
        else {
            foreach($publicMethods as $method) {
                $results = array();
                $result = $this->$method;
                $results[$class][$method] = $result;
            }
            
            return $results;
        }
    }
}








?>