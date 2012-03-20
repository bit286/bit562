<?php

require_once('Packager.php');

function packagerFactory($codeFileName) {

    //getting extension
    $extension = substr($codeFileName, strrpos($codeFileName, ".") + 1);


    switch($extension) {
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
            $packager = new Packager(array("comment", "codeline"));
            break;
        case "css":
            $packager = new Packager(array("comment", "selector", "rule"));
            break;

        default:
            $packager = new Packager(array());
            break;
    }

    return $packager;
}

?>
