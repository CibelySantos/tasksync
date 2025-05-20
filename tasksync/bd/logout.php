<?php
session_start();

if (isset($_SESSION['nome_usuarios'])) {
    unset($_SESSION['nome_usuarios']); 
}

session_unset();

session_destroy();
header('Location: ../index.php');
exit();
?>