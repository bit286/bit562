<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
               
        <?php
            require_once('/php/Command.php');
            require_once('/php/Reader.php');
            require_once('/php/DBManager.php');
            
            $db_host = 'localhost';
            $db_username = '';
            $db_password = '';
            $db_database = '';
            
            $databaseManager = new DBManager($db_host, $db_username, $db_password, $db_database);

            $nameStr = "Rumpelstiltskin";
            $column = strpos($nameStr, "skin");
            $subWord = substr($nameStr, 6, 5 );
            
            $sampleString = 
               'LINK::href=structureImage.html::text=Show an image for STRUCTURE.';
            $commandObj = new Command($sampleString, 'Structure.js', 3);
            $reader = new Reader($databaseManager);
            
            $reader->addToPlanguage($commandObj);
            
            $sampleStringTwo = 
               'LINK::href=carousel.html::text=A carousel.js diagram for clarification.';
            $commandObj = new Command($sampleStringTwo, 'Structure.js', 25);
            
            $reader->addToPlanguage($commandObj);
        ?>
        <h2><?php echo $subWord; ?></h2>
        <h2><?php echo $column; ?></h2>
        <h2>The End</h2>
        <h2><?php echo $commandObj->getValue("href") ?></h2>
        <h2><?php echo $commandObj->getValue("text") ?></h2>
        <h2><?php echo $commandObj->matchObjectID("abcde-abcde-abcde-abcde") ?></h2>
        <a href="php/fileReader.php">Check out the file reader</a><br /><br />
        <a href="php/codeTest.php">Take a look at a code sample</a>
    </body>
</html>
