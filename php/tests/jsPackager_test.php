<?php
            include('../../templates/testingheader.php');
            require_once('../Packager.php');
            require_once('../jsPackager.php');

            $jsPackager = new jsPackager();

            $fileName = 'test.js';
            if (is_file($fileName))
            {     
                $braceCount = 0;
                $fileHandle = fopen($fileName, 'r');
                // Go through the file line by line.
                while (!feof($fileHandle)) {
                $line = fgets($fileHandle);
                if (strpos($line, "{") > -1) {
                    $braceCount += 1;
                }
                if (strpos($line, "}") > -1) {
                    $braceCount -= 1;
                }
                $line =  $jsPackager->packager($line, $braceCount); 
#               echo "<p>$braceCount</p>";
                echo $line;
            }
            }
            
            include('../../templates/footer.php');
        ?>
    
