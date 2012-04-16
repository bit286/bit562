<?php


class DBConfig {
    private $database, $username, $password, $hostname;

    function __construct() {
        include('db_login.php');
        $this->database = $db_database;
        $this->username = $db_username;
        $this->password = $db_password;
        $this->hostname = $db_host;
    }

    function getDatabase() {
        return $this->database;
    }

    function getUsername() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }

    function getHostname() {
        return $this->hostname;
    }
}
