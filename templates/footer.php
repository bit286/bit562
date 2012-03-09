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