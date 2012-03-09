<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProjectFile
 *
 * @author Logan Tegman
 */
class ProjectFile {
    
    private $object_ID;
    private $source;
    private $destination;
    private $name;
    private $description;
    private $entryDate;
    
    public function __construct($object_ID, $source, $destination, $name, $description, $entryDate) {
        $this->object_ID = $object_ID;
        $this->source = $source;
        $this->destination = $destination;
        $this->name = $name;
        $this->description = $description;
        $this->entryDate = $entryDate;
    }
    
    public function getObjectID() {
        return $this->object_ID;
    }
    
    public function getSource() {
        return $this->source;
    }
    
    public function getDestination() {
        return $this->destination;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getDescription() {
        return $this->description;
    }
    
    public function getEntryDate() {
        return $this->entryDate;
    }
}

?>
