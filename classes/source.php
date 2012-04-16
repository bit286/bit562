<?php
class Sourceline {
    public $linetype;
    public $line;

    function __construct($line) {
        $this->line = $line;
        $this->setLineType($line);
    }

    function setLineType($line) {
        $commentPattern = '/^(\/\/|\/\*).*$/';
        if (preg_match($commentPattern, $line) > 0) {
            $this->linetype = 'comment';
        } else {
            $this->linetype = 'codeline';
        }
    }
}