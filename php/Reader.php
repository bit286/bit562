<?php

require_once('PackagerFactory.php');
require_once('Command.php');
require_once('ProjectFile.php');

class Reader {
   
   protected $planguage = array();
   private   $projectFiles = array();
   private   $projectName;
   private   $location = 0;
   private   $packagers = array();
   protected $mgr;
   protected $braceCounter = 0;
   
   
   function __construct(DBManager $databaseManager) { 
      $this->mgr = $databaseManager;
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
       $result = $this->mgr->execute("SELECT * FROM project_files WHERE project='{$projectName}'"); 
       
       // Loop through projects files, putting each into an object, placing that object in the $projectFiles array
       
       while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
           $this->projectFiles[] = new ProjectFile($row['object_ID'], $row['source'],
                   $row['destination'], $row['name'], $row['description'], $row['entryDate']);
       }
   }
   
    // Go through all project files, controlling the reading of the files and then the writing
    // of the HTML version of the file to the documentation folder.  
    public function readAndWriteProject(){
        
        $numProjFiles = count($this->projectFiles);
        for ($i = 0; $i < $numProjFiles; $i++) {
            $this->readAndWriteFile($this->projectFiles[$i]->getSource(), $this->projectFiles[$i]->getDestination());
        }
    }

    // Handle one file at a time given the file name and the target HTML name.
    // Read a single file, one line at a time, and convert the single lines to
    // HTML one at a time.  
    protected function readAndWriteFile($inputFilename, $outputFilename) {

        $filePackager = packagerFactory($inputFilename);
        $fileReader = fopen($inputFilename, 'r');
        $fileWriter = fopen($outputFilename, 'w');
        
        fwrite($fileWriter, '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"\n
            "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">\n\n
            <html xmlns="http://www.w3.org/1999/xhtml">\n\n <head>\n
            <link rel="stylesheet" type="text/css" href="css/doc_style.css" />
            <title>'.pathinfo($inputFilename, PATHINFO_FILENAME).'</title>\n </head>\n\n<body>');
        
        while (!feof($fileReader)) {
            $fileLine = fgets($fileReader);
            if (strpos($fileLine, '/*+') !== false) {
                $this->planguageReader($fileReader, $fileWriter, $fileLine);
            }
            else {
                $html = $filePackager->packager($fileLine, $braceCount);
                fwrite($fileWriter, $html.'\n');
            }
        }
        
        fwrite($fileWriter, '</body>\n\n</html>');
        fclose($fileReader);
        fclose($fileWriter);
    }
   
   // When the beginning of a planguage comment is present in a file line,
   // pass the line to the planguageReader.  The planguageReader handles an entire planguage
   // comment, regardless of comment length and regardless of the number of commands
   // in the comment.  Comment strings are parsed and put into the planguage array.  Some
   // commands will be packaged in the planguageReader and sent to the write file as HTML.
   // The LINK command would be an example.
   function planguageReader($readHandle, $writeHandle, $commentLine) {
      
      $fileString = '';
   
       //Open the file and read it one line at a time into a string.
       $file = fopen ($readHandle, 'r');
          while (!feof($file)) {
             $lineString = fgets ($file);          
             if ($lineString === false) continue;        
             $lineString = trim($lineString);      
             if (strlen($lineString) == 0) continue;     
             $fileString .= $lineString;           
         }
         fclose($file);      
      
      $commentLine = trim($commentLine);  
      
      //Extract the desired planguage string from the file string, removing the comment markups.
      //Trim off any existing whitespace from the ends of the planguage string.
      $start = strpos ($fileString, $commentLine); 
      $start = $start + 3;                         
      $end = strpos ($fileString, '*/', $start); 
      $planguageString = substr (substr ($fileString, 0, -(strlen($fileString) - $end)), $start); 
      $planguageString = trim ($planguageString);  
      
      //Seperate the individual command sections in the planguage string into an array.
      $commandSections = explode(';;', $planguageString);
      
      //For each command section, break down into Command Name and Key/Value pairs and store in a jagged array.
      for($i=0; $i<count($commandSections); $i+=1) {     
      $commandObject = new Command ($commandSections[$i], $readHandle, $commentLine);  
      $this->addToPlanguage($commandObject);     
   }
      //Return the completed planguage array.
      return $this->planguage;
   
      }
   
   
   
   
}

?>
