<?php session_start();

$_SESSION['LoggedIn'] = false;
setcookie('username', '', time() - 3600);

header('Location: login.php');
exit();

