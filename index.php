<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <style>
            .comment {
                color: red;
            }
            
            .codeline {
                color: blue;
            }
            
            .body {
                margin-left: 50px;
            }
                
            .bigcode {
                font-size: 36pt;
                font-weight: bold;
            }
                
            .codeline {
                cursor: pointer;
            }
                
            .classDefinition {
                color: green;
                cursor: pointer;
            }
                
            .class .body {
                position: relative;
            }
                
            .functionDefinition {
                color: magenta;
                cursor: pointer;
            }
                
            .function .body {
                position: relative;
            }
                
            .expandFunction {
                cursor: pointer;
            }
        </style>
    </head>
    <body>
               
        <?php
            require_once('php/Packager.php');
            require_once('php/packagerFactory.php');
            
            $fileName = 'php/tests/test2.js';
            if (is_file($fileName))
            {   
                $packager = packagerFactory($fileName);
                $braceCount = 0;
                $fileHandle = fopen($fileName, 'r');
                // Go through the file line by line.
                while (!feof($fileHandle)) {
                    $line = fgets($fileHandle);
                    
                    $line =  $packager->packager($line, &$braceCount); 
                    echo $line;
                }
            }

        ?>
      <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
      <script type="text/javascript">
          function performTest() {
            alert($(".codeLine").size());
         }
         
         $(".codeline").click(function() {
            $(this).toggleClass("bigcode");
         });
         
         $(".classDefinition").click(function() {
            $(this).toggleClass("bigcode");
         });
         
         $(".functionDefinition").click(function() {
            $(this).toggleClass("bigcode");
         });
          
            jQuery(document).ready(function() {
                jQuery(".function.body").hide();
                //toggle the component with class msg_body
                jQuery(".expandFunction").click(function()
                {
                    jQuery(this).nextAll(".function.body").slideToggle(125);
                });
            });
      </script>

    </body>
</html>
