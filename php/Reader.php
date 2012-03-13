<?php

require_once('PackagerFactory.php');
require_once('Command.php');
require_once('ProjectFile.php');
require_once('Brace.php');

class Reader {

    protected $planguage = array();
    private $projectFiles = array();
    private $projectName;
    private $location = 0;
    private $packagers = array();
    protected $mgr;
    protected $braceCounter = 0;
    protected $links = array();
    private $results = array();
	 private $br;

    function __construct(DBManager $databaseManager) {
        $this->mgr = $databaseManager;
		  $this->br = new Brace($databaseManager);
    }

    public function getCommandType($commandType) {
        return $this->planguage[$commandType];
    }

    public function getProjectFiles() {
        return $this->projectFiles;
    }

    // Place a new command object in the planguage data structure.
    public function addToPlanguage(Command $commandObj) {
        $command = $commandObj->getCommandName();
        $this->planguage[$command][] = $commandObj;
    }

    // Read the project file names and target file names from the database.
    // Create a projectFiles array by making a ProjectFile object for each
    // project file and putting it in the array.
    public function retrieveProjectFiles($projectName) {
        $this->projectName = $projectName;

        // Retrieve table of projectfiles from database
        $this->mgr->open();
        $result = $this->mgr->execute("SELECT * FROM projectfiles WHERE project='".$projectName."'");

       if (!$result) {
           $this->results[] = array('success'=>FALSE
               ,'description'=>"There are no ".$this->projectName." files to document in the project_files table");
           return $this->results;
       } // Return when the result set is empty.

        // Loop through projects files, putting each into an object, placing that object in the $projectFiles array

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $this->projectFiles[] = new ProjectFile($row['object_ID'], $row['source'],
                            $row['destination'], $row['name'], $row['description'], $row['entryDate']);
        }
    }

    // Go through all project files, controlling the reading of the files and then the writing
    // of the HTML version of the file to the documentation folder.  
    public function readAndWriteProject() {

        $numProjFiles = count($this->projectFiles);
        for ($i = 0; $i < $numProjFiles; $i++) {
            $this->readAndWriteFile($this->projectFiles[$i]->getSource(), $this->projectFiles[$i]->getDestination());
        }
        return $this->results;
    }

    // Handle one file at a time given the file name and the target HTML name.
    // Read a single file, one line at a time, and convert the single lines to
    // HTML one at a time.  
    protected function readAndWriteFile($inputFilename, $outputFilename) {

        $this->location = 0;

        if (!is_file($inputFilename)){
            $this->results[] = array('success'=>FALSE,
               'description'=>"Input file does not exist: ".$inputFilename);
            return;
        }

        $filePackager = packagerFactory($inputFilename);

        if ( $filePackager->getTestFlagsCount() === 0 ){
            $this->results[] = array('success'=>FALSE,
               'description'=>"Input file type not recognized: ".$inputFilename);
            return;
        }
        
        $lastSlashPos = strrpos($outputFilename, '/');
        if (!$lastSlashPos){ 
           $lastSlashPos = strrpos($outputFilename, '\\'); 
        }
        $outputFilePath = substr($outputFilename,0,$lastSlashPos);
        
        if (!is_dir($outputFilePath)){
            $this->results[] = array('success'=>FALSE,
               'description'=>"Output document path does not exist: ".$outputFilename);
            return;
        }

        $fileReader = fopen($inputFilename, 'r');
        $fileWriter = fopen($outputFilename, 'w');

        fwrite($fileWriter, '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"'."\n".
            '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'."\n\n".
            '<html xmlns="http://www.w3.org/1999/xhtml">'."\n\n".'<head>'."\n".
            '<link rel="stylesheet" type="text/css" href="../css/doc_style.css" />'."\n".
            '<title>' . pathinfo($inputFilename, PATHINFO_FILENAME) . '</title>'."\n".'</head>'."\n\n".'<body>'."\n");

        while (!feof($fileReader)) {
            $fileLine = fgets($fileReader);
				$fileLine = trim($fileLine);
            $this->location += 1;
            if (strpos($fileLine, '/*+') === 0) {
               $this->planguageReader($fileReader, $fileWriter, $inputFilename, $fileLine);
            }
            else {
               if (strpos($fileLine,'<') === 0) { 
						$fileLine = '&lt;'.substr($fileLine,1); 
					}
               $html = $filePackager->packager($fileLine, $braceCount);
               fwrite($fileWriter, $html . "\n");
            }
        }

        // Get Javascript.
        fwrite($fileWriter, "\n".
        '<script type="text/javascript" src="../tools/jquery-1.5.2.min.js"></script>'."\n".
        '<script type="text/javascript" language="javascript" src="../javascript/doc_style.js"></script>'."\n\n");

        fwrite($fileWriter, '</body>'."\n\n".'</html>');
        fclose($fileReader);
        fclose($fileWriter);

        $this->results[] = array('success'=>TRUE,
               'description'=>"Output document was successfully created: ".$outputFilename);
    }

    // When the beginning of a planguage comment is present in a file line,
    // pass the line to the planguageReader.  The planguageReader handles an entire planguage
    // comment, regardless of comment length and regardless of the number of commands
    // in the comment.  Comment strings are parsed and put into the planguage array.  Some
    // commands will be packaged in the planguageReader and sent to the write file as HTML.
    // The LINK command would be an example.
    function planguageReader($readHandle, $writeHandle, $filePath, $commentLine) {


        //Extract desired planguage block from file.
        $planguageString = $commentLine;
        $planguageLocation = $this->location;
        while (strpos($planguageString, '*/') === false) {
            $planguageString .= fgets($readHandle);
            $this->location++;
        }
        $planguageString = trim($planguageString);
        $planguageString = trim($planguageString, '*/+');

        //Separate the individual command sections in the planguage string into an array
        //and trim the whitespace from all strings.
        $commandSections = explode(';;', $planguageString);
        $commandSections = array_map('trim', $commandSections);

        //For each command section, break down into Command Name and Key/Value pairs and store in a jagged array.
        for ($i = 0; $i < count($commandSections); $i+=1) {
            $commandObject = new Command($commandSections[$i], $filePath, $planguageLocation);
            if ($commandObject->getCommandName() === 'LINK') {
                $pairs = $commandObject->getKVPairs();
                $this->linkBuilder($pairs);
            }
            else {
                $this->addToPlanguage($commandObject);
            }
            $planguageLocation++;
        }
    }

    protected function planguageReporter() {
        $html = "<!DOCTYPE html>\n<html>\n<head>\n<title>Planguage Report</title>\n</head>\n<body>\n";
        $html .= "<h1>Planguage Report</h1>\n";
        foreach ($this->planguage as $commandType => $commandObjects) {
            //Create table header
            $html .= "<table>\n<tr><th>$commandType</th></tr>\n<tr>";
            //Create column headers
            foreach ($commandObjects[0]->getKVPairs() as $column => $value) {
                $html .= "<th>$column</th>";
            }
            $html .= "</tr>\n";

            //Create a row for each use of the given planguage command
            foreach ($commandObjects as $commandObject) {
                $html .= '<tr>';
                $commandPieces = $commandObject->getKVPairs();
                foreach ($commandPieces as $commandPiece) {
                    $html .= "<td>$commandPiece</td>";
                }
                $html .= "</tr>\n";
            }
            $html .= "</table>\n";
        }
        $html .= "</body>\n</html>";
        return $html;
    }

    protected function linkBuilder($pairs) {
//        $linkHtml = '<a href="' . $pairs['href'] . '" title="' . $pairs['title'] . '">link</a>';
//        $this->links[] = $linkHtml;
    }

}

?>
