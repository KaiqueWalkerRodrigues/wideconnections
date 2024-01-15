<?php 
    include_once('class/Conexao.php');
    include_once('class/Helper.php');
    include_once('class/Usuario.php');

    $token = $_GET['token'];

    $Usuario = new Usuario();

    $Usuario->autentificar($token);
?>