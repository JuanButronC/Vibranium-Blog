<?php
   session_start();

   function validaNombre($nombre) {
      return preg_match("/^[A-ZÁEÍÓÚÑ]{2,}(\s[A-ZÁEÍÓÚÑ]{2,})?$/", $nombre);
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
         "fecNac" => validaFecha($datos["fecNac"]),
         "sexo" => validaSexo($datos["sexo"], $datos["nombreSexo"])
      ];

      $mensajesError = [
         "nombre" => "<li>El <strong>nombre</strong> no es válido</li>",
         "apPat" => "<li>El <strong>apellido paterno</strong> no es válido</li>",
         "apMat" => "<li>El <strong>apellido materno</strong> no es válido</li>",
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
      $contraseniaBD = "";
      $nombreBD = "vibraniumblogdb";

      $conexion = mysqli_connect($servidorBD, $usuarioBD, $contraseniaBD, $nombreBD);

      return $conexion;
   }

   function actualizarDatosPersonales ($conexion, $idUsuario, $datos, &$respuesta) {
      $sentencia = mysqli_prepare($conexion, "UPDATE datos_personales SET nombre = ?, ape_pat = ?, ape_mat = ?, fecha_nac = ?, sexo = ? WHERE id_usuario = ?");
      mysqli_stmt_bind_param($sentencia, "ssssii", $datos["nombre"], $datos["apPat"], $datos["apMat"], $datos["fecNac"], $datos["sexo"], $idUsuario);
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

   $idUsuario = $_SESSION["idUsuario"];
   $datos = [
      "nombre" => $_POST["nombre"],
      "apPat" => $_POST["apPat"],
      "apMat" => $_POST["apMat"],
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
         actualizarDatosPersonales($conexionBD, $idUsuario, $datos, $respuesta);
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