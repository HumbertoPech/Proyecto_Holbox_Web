<?php
session_start();
$_SESSION['aksi'] = $_GET['aksi'];
$_SESSION['nik'] = $_GET['nik'];
include_once("../config/variables.php");
header("Location:{$url_base}adminUsuarios/iniciar");
?>