<?php

require_once('PackagerFactory.php');
require_once('Command.php');

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
      
      // Complete this function.
   }
   
   // Go through all project files, controlling the reading of the files and then the writing
   // of the HTML version of the file to the documentation folder.  
   public function readAndWriteProject(){
      // Complete this function.
      
      return false;
   }
   
   // Handle one file at a time given the file name and the target HTML name.
   // Read a single file, one line at a time, and convert the single lines to
   // HTML one at a time.  
   protected function readAndWriteFile($inputFilename, $outputFilename) {
      
      $filePackager = packagerFactory($inputFileName);
      
      // Complete this function. 
   }
   
   // When the beginning of a planguage comment is present in a file line,
   // pass the line to the planguageReader.  The planguageReader handles an entire planguage
   // comment, regardless of comment length and regardless of the number of commands
   // in the comment.  Comment strings are parsed and put into the planguage array.  Some
   // commands will be packaged in the planguageReader and sent to the write file as HTML.
   // The LINK command would be an example.
   protected function planguageReader($readHandle, $writeHandle, $commentLine) {
      // Complete this function.
   }
   
}

?>
