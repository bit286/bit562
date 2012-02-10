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
           span.bracecount2 {
              position: relative;
              left: 100px;
           }
           span.bracecount1 {
              position: relative;
              left: 50px;
           }
           span.bracecount3 {
              position: relative;
              left: 150px;
           }
           span.bracecount4 {
              position: relative;
              left: 100px;
           }

                    .bigcode { font-size: 36pt;
                    font-weight: bold;
         }
         
         .codeline { cursor: pointer;
         }
         
         .classDefinition { color: green;
                            cursor: pointer;
         }
         
         #classBody { margin: 0;
         }
         
         .functionDefinition { color: magenta;
                               cursor: pointer;
         }
         
         #functionBody { position: relative;
                         display: none;
         }
         
         .expandFunction { cursor: pointer;
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
      <script>
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
         
         $(".expandFunction").click(function() {
            if ($(this).html() === "++") {              
              $("#functionBody").show();
              $(this).html("--");               
            } else {
              $("#functionBody").hide();
              $(this).html("++");
            }
         });
         
      </script>

    </body>
</html>
