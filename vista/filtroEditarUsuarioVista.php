<?php
session_start();
$_SESSION['nik'] = $_GET['nik'];
$_SESSION['pesan'] = $_GET['pesan'];
include_once("../config/variables.php");
header("Location:{$url_base}adminUsuarios/editarUsuario");
?>