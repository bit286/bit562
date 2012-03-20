<?php

require_once ('checkUser.php');

$username = $_REQUEST['userName'];
$password = $_REQUEST['password'];

$newCheck = new CheckUser ($username, $password);

$result = $newCheck->authenticate();

if ($result !== false) {
    session_start();
    $_SESSION['loggedIn'] = true;
                header("Location:../index.php");

} else {
    echo 'Login Failed';
}

?>
