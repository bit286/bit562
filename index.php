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
            include('php/Packager.php');
            include('php/myjsPackager.php');
            
            $testarray = array( '   // This is a comment.',
                                 '$codeLine = explode("::", $fileLine);',
                                 'class TesterClass {',
                                 'function showAndTell() {',
                                     '$bracecount = $bracecount + 1;',
                                 '}',
                                 '}',
            
                                 '/* This is a block comment.*/',
                                 '   */',
                                 '   /* Beginning a comment block',
                                 '  * put the magic word function in here. ',
                                 '  */',
                                 'return structure;',
                                 '    $bracecount = $bracecount + 50; // Using pixels in bracecount.',
                                 '$S.fn.getType = function() {',);
            
            $packer = new myjsPackager();
            $braceCount = 0;
            for ($i=0; $i<count($testarray); $i+=1) {
               echo $packer->packager($testarray[$i], $braceCount);
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
