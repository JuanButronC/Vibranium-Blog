<?php
   function obtenConexionBD() {
      $servidorBD = "localhost";
      $usuarioBD = "root";
      $contraseniaBD = "";
      $nombreBD = "VibraniumBlogDB";

      $conexion = mysqli_connect($servidorBD, $usuarioBD, $contraseniaBD, $nombreBD);

      return $conexion;
   }

   function obtenDatosPersonales ($conexionBD, $idUsuario, &$respuesta) {
      $sentencia = mysqli_prepare($conexionBD, "SELECT nombre, ape_pat, ape_mat, fecha_nac, sexo FROM datos_personales WHERE id_usuario = ?");
      mysqli_stmt_bind_param($sentencia, "i", $idUsuario);
      mysqli_stmt_execute($sentencia);

      $respuesta["codError"] = mysqli_stmt_errno($sentencia);
      $respuesta["datos"] = mysqli_stmt_get_result($sentencia);
      $respuesta["msjError"] = mysqli_stmt_error($sentencia);
      mysqli_stmt_free_result($sentencia);
      mysqli_close($conexionBD);
   }

   $idUsuario = (int) $_POST["idUsuario"];
   $respuesta = ["codError" => 0, "datos" => "", "msjError" => ""];
   $conexionBD = obtenConexionBD();
   $json = "";

   if ($conexionBD) {
      obtenDatosPersonales ($conexionBD, $idUsuario, $respuesta);

      if (mysqli_num_rows($respuesta["datos"]) === 1) {
         $respuesta["datos"] = mysqli_fetch_assoc($respuesta["datos"]);
      }
      else {
         $respuesta["codError"] = -1;
         $respuesta["msjError"] = "No se encontraron los datos personales de este usuario";
      }

      $json = json_encode($respuesta);
   }
   else {
      $respuesta["codError"] = mysqli_connect_errno();
      $respuesta["msjError"] = mysqli_connect_error();
      $json = json_encode($respuesta);
   }

   echo $json;
?>