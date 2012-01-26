<?php

require_once('Packager.php');
require_once('phpPackager.php');

function packagerFactory($codeFileName) {
   
   $packager = new phpPackager();
   
   return $packager;
   
}

?>
