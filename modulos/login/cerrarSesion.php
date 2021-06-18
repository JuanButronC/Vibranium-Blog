<?php
unset($_SESSION['idUsuario']);
unset($_SESSION['correo']);
unset($_SESSION['rol']);
unset($_SESSION['aut']);
unset($_SESSION['nombreUsuario']);
header("Location: ../home/home.php");
?>