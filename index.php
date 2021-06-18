<?php
    session_start();
    $_SESSION["dirRaiz"] = getcwd() . "/";

    header("location: modulos/home/home.php");
?>