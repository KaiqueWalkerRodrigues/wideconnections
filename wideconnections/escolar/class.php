<?php 
    include_once('../class/Conexao.php');
    include_once('../class/Helper.php');
    include_once('../class/Usuario.php');
    include_once('../class/Escola.php');
    include_once('../class/Estado.php');
    include_once('../class/Cidade.php');
    include_once('../class/Noticia.php');
    include_once('../class/Subcategoria.php');

    session_start();
    Helper::logadoescolar();
?>