<?php 

session_start();
session_destroy();

session_start();
$_SESSION['trocar']     = true;
$_SESSION['token']    = $_GET['token'];

header('location:trocarsenha.php');
?>