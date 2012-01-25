<?php

include('Packager.php');
include('phpPackager.php');

function packagerFactory($codeFileName) {
   
   $packager = new phpPackager();
   
   return $packager;
   
}

?>
