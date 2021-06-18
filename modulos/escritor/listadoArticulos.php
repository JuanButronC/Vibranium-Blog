<?php
   function obtenConexionBD() {
      $servidorBD = "localhost";
      $usuarioBD = "root";
      $contraseniaBD = "";
      $nombreBD = "VibraniumBlogDB";

      $conexion = mysqli_connect($servidorBD, $usuarioBD, $contraseniaBD, $nombreBD);

      return $conexion;
   }

   function obtenDatosArticulos($conexion, $idEscritor) {
      $sentencia = mysqli_prepare($conexion, "SELECT id, imagen, titulo, fecha_creacion, fecha_publicacion, estatus FROM articulos WHERE id_escritor = ?");
      mysqli_stmt_bind_param($sentencia, "i", $idEscritor);
      mysqli_stmt_execute($sentencia);
      $datosUsuario = mysqli_stmt_get_result($sentencia);
      mysqli_stmt_free_result($sentencia);

      mysqli_close($conexion);

      return $datosUsuario;
   }

   function obtenNombreEstatus($estatus) {
      $estatusArr = array("No publicado", "Publicado");

      return $estatusArr[$estatus];
   }

   $idEscritor = $_SESSION["idUsuario"];
   $conexionBD = obtenConexionBD();

   if ($conexionBD) {
      $datosArticulos = obtenDatosArticulos($conexionBD, $idEscritor);
      $numFilas = mysqli_num_rows($datosArticulos);
      $tabla = "
         <table class='table table-responsive'>
            <thead class='text-white' style='background-color: #4b608a;'>
               <tr>
                  <th class='text-center align-middle' style='width: 30%;'>Imagen</th>
                  <th class='text-center align-middle' style='width: 10%;'>Titulo</th>
                  <th class='text-center align-middle' style='width: 10%;'>Fecha de creación</th>
                  <th class='text-center align-middle' style='width: 10%;'>Fecha de publicación</th>
                  <th class='text-center align-middle' style='width: 10%;'>Estatus</th>
                  <th class='text-center align-middle' style='width: 10%;'>Editar</th>
                  <th class='text-center align-middle' style='width: 10%;'>Eliminar</th>
                  <th class='text-center align-middle' style='width: 10%;'>Publicar</th>
               </tr>
            </thead>

            <tbody>
      ";

      if ($numFilas > 0) {
         while ($fila = mysqli_fetch_assoc($datosArticulos)) {
            $tabla .= "
               <tr>
                  <td class='text-center'><img src='" . 'data:image/jpeg;base64,' . $fila['imagen'] . "' style='max-width: 50%; height: auto;'></td>
                  <td class='text-center align-middle'>" . $fila["titulo"] . "</td>
                  <td class='text-center align-middle'>" . $fila["fecha_creacion"] . "</td>
                  <td class='text-center align-middle'>" . $fila["fecha_publicacion"] . "</td>
                  <td class='text-center align-middle'>" . obtenNombreEstatus($fila["estatus"]) . "</td>";
   
            if ($fila["estatus"] == 0) {
               $tabla .= "
                     <td class='text-center align-middle'><a href='articulo/actualizar.php?idArticulo=" . $fila["id"] . "' class='btn btn-warning'>Editar</a></td>
                     <td class='text-center align-middle'><a href='articulo/eliminar.php?id=" . $fila["id"] . "' class='btn btn-danger'>Eliminar</a></td>
                     <td class='text-center align-middle'><a href='vistas/publicar.php?idArticulo=" . $fila["id"] . "' class='btn btn-info'>Publicar</a></td>
                  </tr>
               ";
            }
            else {
               $tabla .= "
                     <td class='text-center align-middle'>N/A</td>
                     <td class='text-center align-middle'>N/A</td>
                     <td class='text-center align-middle'>N/A</td>
                  </tr>
               ";
            }
         }
      }
      else {
         echo "
            <tr>
               <td colspan='8' class='text-center'>Sin resultados</td>
            </tr>
         ";
      }

      $tabla .= "
               </tbody>
            </table>
         ";

      echo $tabla;
   }
   else {
      echo "
         <div class='alert alert-danger'>"
         . "Error al conectar con la base de datos: " . mysqli_connect_error() .
         "</div>
      ";
   }
?>