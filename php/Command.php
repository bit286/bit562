<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Command
 *
 * @author Edwin-Lap
 */
class Command {
   
   private $object_ID;
   private $fileName;
   private $fileLine;
   private $commandName;
   private $kvPairs = array();
   
   function __construct( $kvString, $file, $location) {
      $this->fileLine = $location;
      $this->fileName = $file;
      $this->object_ID = "";
      
      $commandPieces = explode("::", $kvString);
      $this->commandName = $commandPieces[0];
   
      for($i=1; $i<count($commandPieces); $i+=1) {
         $nameValuePair = explode("=", $commandPieces[$i]);
         $this->kvPairs[$nameValuePair[0]] = $nameValuePair[1];
      }
      
   }
   
   public function getCommandName() {
      return $this->commandName;
   }
   
   public function getKVPairs() {
      return $this->kvPairs;
   }
   
   public function getValue($key) {
      return $this->kvPairs[$key];
   }
   
   public function matchObjectID($objectID) {
      return $objectID === $this->object_ID;
   }
   
   public function getObjectID() {
      return $this->object_ID;
   }
}

?>
