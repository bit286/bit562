<?php 

// phpTest.php
// author: Michael McGinn
        
            include_once('templates/header.php');
            
            
            
            
            
            require_once('php/Packager.php');
            require_once('php/packagerFactory.php');
            //Testing Code
            $fileName = 'php/tests/phpTestFile.php';
            if (is_file($fileName))
            {
                $packager = packagerFactory($fileName);
                
                $fileHandle = fopen($fileName, 'r');
                // Go through the file line by line.
                while (!feof($fileHandle)) {
                    $line = fgets($fileHandle);
                    
                    $line =  $packager->packager($line, $braceCount); 
                    echo $line;
                }
            }
            
            
            include_once('templates/footer.php');
        ?>
