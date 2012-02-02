<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>fileReader.php Test</title>
		<style>
			.comment { color: red; }
			div { border: 1px solid blue; margin: 5px; padding: 5px; }
		</style>
    </head>
    <body>
        <?php
            require_once('../Packager.php');
            require_once('../jsPackager.php');

			$jsPackager = new jsPackager();

            $fileName = 'test2.js';
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
#				echo "<p>$braceCount</p>";
				echo $line;
			}
			}
		?>
    </body>
</html>
