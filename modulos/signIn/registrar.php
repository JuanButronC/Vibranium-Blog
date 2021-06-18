<?php

   function validaNombre($nombre) {
      return preg_match("/^[A-ZÁEÍÓÚÑ]{2,}(\s[A-ZÁEÍÓÚÑ]{2,})?$/", $nombre);
   }

   function validaContrasenia($contrasenia) {
      return preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])[a-zA-Z0-9.]{6,}$/", $contrasenia);
   }

   function validaFecha($fecha) {
      return DateTime::createFromFormat("d/m/Y", $fecha);
   }

   function validaSexo($sexo, $nombreSexo) {
      return ($sexo === 0 || $sexo === 1) && ($nombreSexo === "FEMENINO" || $nombreSexo === "MASCULINO");
   }

   function validaDatos($datos, &$respuesta) {
      $datosValidos = [
         "nombre" => validaNombre($datos["nombre"]),
         "apPat" => validaNombre($datos["apPat"]),
         "apMat" => validaNombre($datos["apMat"]),
         "correo" =>  filter_var($datos["correo"], FILTER_VALIDATE_EMAIL),
         "contrasenia" => validaContrasenia($datos["contrasenia"]),
         "fecNac" => validaFecha($datos["fecNac"]),
         "sexo" => validaSexo($datos["sexo"], $datos["nombreSexo"])
      ];

      $mensajesError = [
         "nombre" => "<li>El <strong>nombre</strong> no es válido</li>",
         "apPat" => "<li>El <strong>apellido paterno</strong> no es válido</li>",
         "apMat" => "<li>El <strong>apellido materno</strong> no es válido</li>",
         "correo" => "<li>El <strong>correo electrónico</strong> no es válido</li>",
         "contrasenia" => "<li>La <strong>contrasenia</strong> no es válida. Debe de tener mínimo 6 caracteres, al menos 1 letra minúscula, 1 letra mayúscula y 1 número</li>",
         "fecNac" => "<li>La <strong>fecha de nacimiento</strong> no es válida</li>",
         "sexo" => "<li>El <strong>sexo</strong> seleccionado no es válido</li>"
      ];

      foreach ($datosValidos as $llave => $valor) {
         if ($valor === false) {
            $respuesta["msjError"] .= $mensajesError[$llave];
         }
      }

      if ($respuesta["msjError"] !== "") {
         $respuesta["codError"] = -1;
         $respuesta["msjError"] = "<ul>" . $respuesta["msjError"] . "</ul>";
      }

      return $respuesta["codError"] === 0;
   }

   function obtenConexionBD() {
      $servidorBD = "localhost";
      $usuarioBD = "root";
      $contraseniaBD = "root";
      $nombreBD = "VibraniumBlogDB";

      $conexion = mysqli_connect($servidorBD, $usuarioBD, $contraseniaBD, $nombreBD);

      return $conexion;
   }

   function registraUsuario ($conexion, $datos, &$respuesta) {
      $sentencia = mysqli_prepare($conexion, "INSERT INTO usuarios (correo, contrasenia, id_rol) VALUES (?, ?, 2)");
      mysqli_stmt_bind_param($sentencia, "ss", $datos["correo"], $datos["contrasenia"]);
      mysqli_stmt_execute($sentencia);

      $respuesta["codError"] = mysqli_stmt_errno($sentencia);
      $respuesta["msjError"] = mysqli_stmt_error($sentencia);
      mysqli_stmt_free_result($sentencia);

      if ($respuesta["codError"] !== 0) {   
         mysqli_rollback($conexion);
         mysqli_close($conexion);

         return;
      }

      $idUsuario = mysqli_stmt_insert_id($sentencia);

      $sentencia = mysqli_prepare($conexion, "INSERT INTO datos_personales VALUES (?, ?, ?, ?, ?, ?)");
      mysqli_stmt_bind_param($sentencia, "issssi", $idUsuario, $datos["nombre"], $datos["apPat"], $datos["apMat"], $datos["fecNac"], $datos["sexo"]);
      mysqli_stmt_execute($sentencia);

      $respuesta["codError"] = mysqli_stmt_errno($sentencia);
      $respuesta["msjError"] = mysqli_stmt_error($sentencia);
      mysqli_stmt_free_result($sentencia);

      if ($respuesta["codError"] !== 0) {
         mysqli_rollback($conexion);
         mysqli_close($conexion);

         return;
      }
      
      mysqli_commit($conexion);
      mysqli_close($conexion);
   }

   $datos = [
      "nombre" => $_POST["nombre"],
      "apPat" => $_POST["apPat"],
      "apMat" => $_POST["apMat"],
      "correo" => $_POST["correo"],
      "contrasenia" => $_POST["contrasenia"],
      "fecNac" => $_POST["fecNac"],
      "sexo" => (int) $_POST["sexo"],
      "nombreSexo" => $_POST["nombreSexo"]
   ];
   
   $respuesta = ["codError" => 0, "msjError" => ""];
   $json = "";

   if (validaDatos($datos, $respuesta)) {
      $conexionBD = obtenConexionBD();

      if ($conexionBD) {
         mysqli_autocommit($conexionBD, false);
         registraUsuario($conexionBD, $datos, $respuesta);
         $json = json_encode($respuesta);
      }
      else {
         $respuesta["codError"] = mysqli_connect_errno();
         $respuesta["msjError"] = mysqli_connect_error();
         $json = json_encode($respuesta);
      }
   }
   else {
      $json = json_encode($respuesta);
   }

   echo $json;
?>