<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <title>Code Test</title>
      <style>
         
         .bigcode { font-size: 36pt;
                    font-weight: bold;
         }
         
         .codeLine { cursor: pointer;
         }
         
         .functionDefinition { color: blue;
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
      <div id="functionDeclaration">
         <span class="expandFunction">++</span>
               <span class="functionDefinition"> function createIndentationHTML($lineOut, $braceCount) {</span>
         <div id="functionBody">
            <span class="codeLine">$html = "";</span><br />
            <span class="codeLine">$indentNumber = $braceCount;</span><br />
            <span class="codeLine">if (strpos($lineOut, "}") > -1 ) {</span><br />
            <span class="codeLine">$indentNumber -= 1;</span><br />
            <span class="codeLine">}</span><br />
            <span class="codeLine">}</span><br />
         </div>
      </div>
      <br /><br /><button onclick="javascript: performTest();">Do a test</button>
      <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
      <script>
         function performTest() {
            alert($(".codeLine").size());
         }
         
         $(".codeLine").click(function() {
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
