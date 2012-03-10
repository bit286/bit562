<?php

require_once ('checkUser.php');

$username = $_REQUEST['userName'];
$password = $_REQUEST['password'];

$newCheck = new CheckUser ($username, $password);

$result = $newCheck->authenticate();

if ($result == 1) {
				session_start();
			    $_SESSION['username'] = $username;
			    $_SESSION['password'] = $password;
			    $_SESSION['loggedIn'] = true;
			    header("Location:../index.php");
			} else {
				echo 'Login Failed';
			}

?>