<?php

require_once('Packager.php');

function packagerFactory($codeFileName) {
   
    $packager = new Packager();
   
    //getting extension
    $extension = substr($codeFileName, strrpos($codeFileName, ".") + 1);
   
    switch($extension)
    {
        case "html":
            $packager = new Packager(array("comment", "codeline"));
            break;
        case "js":
            $packager = new Packager(array("comment", "class", "function", "codeline"));
            break;
        case "php":
            $packager = new Packager(array("comment", "class", "function", "codeline"));
            break;
        case "sql":
            //I know its possible to  define functions in most SQL packages, should they be tested for?
            $packager = new Packager(array("comment", "codeline"));
            break;
        case "css":
            $packager = new Packager(array("comment", "codeline"));
            break;
            
        default:
            $packager = new Packager(array());
            break;
    }

    return $packager;  
}


?>
