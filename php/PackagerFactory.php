<?php

require_once('Packager.php');

function packagerFactory($codeFileName) {
   
    $packager = new Packager();
   
    //getting extension
    $extension = substr($codeFileName, strrpos($codeFileName, ".") + 1);
   
    switch($extension)
    {
        case "html":
            $packager->testFlags = array("comment", "codeline");
            break;
        case "js":
            $packager->testFlags = array("comment", "class", "function", "codeline");
            break;
        case "php":
            $packager->testFlags = array("comment", "class", "function", "codeline");
            break;
        case "sql":
            //I know its possible to  define functions in most SQL packages, should they be tested for?
            $packager->testFlags = array("comment", "codeline");
            break;
        case "css":
            $packager->testFlags = array("comment", "codeline");
            break;
            
        default:
            $packager->testFlags = array();
            break;
    }

    return $packager;  
}


?>
