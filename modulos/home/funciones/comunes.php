<?php 

function limpiaEntrada($input){
    $input=trim($input);
    $input=stripcslashes($input);
    $input=htmlspecialchars($input);
    return $input;

}

    function get_conn(){
        $servidor="localhost";
        $usuarioDB="root";
        $pwDB="";
        $nomDB="vibraniumblogdb";
        $db=mysqli_connect($servidor,$usuarioDB,$pwDB,$nomDB);
        if(!$db){
            die("La conexión fallo:".mysqli_connect_error());
        }else{
            mysqli_query($db,"SET NAMES 'UTF8'");
        }
        return $db;
    }

    function close_conn($db){
    mysqli_close($db);
    }

    function get_decada_label($decada){
        $decadaLabel="";
        switch($decada){
            case "1":
                $decadaLabel="10's";
            break;
            case "2":
                $decadaLabel="20's";
            break;
            case "3":
                $decadaLabel="30's";
            break;
            case "4":
                $decadaLabel="40's";
            break;
            case "5":
                $decadaLabel="50's"; 
            break;
            case "6":
                $decadaLabel="60's";
            break;
            case "7":
                $decadaLabel="70's";
            break;
            case "8":
                $decadaLabel="80's";
            break;
            case "9":
                $decadaLabel="90's";
            break;
            default:
                $decadaLabel="";
            break;
        }
    
        return $decadaLabel;

    }

    function get_articulos(){
        
        $sql="SELECT ARTICULOS.id as id_articulo,
                     ARTICULOS.titulo as titulo,
                     ARTICULOS.resumen as resumen,
                     ARTICULOS.siglo as siglo,
                     ARTICULOS.decada as decada,
                     ARTICULOS.cientificos as cientificos,
                     USUARIOS.nombre as autor,
                     ARTICULOS.id_area as id_area,
                     ARTICULOS.imagen as imagen,
                     AREAS.nombre as area
                FROM ARTICULOS 
                     INNER JOIN USUARIOS ON
                            USUARIOS.id=ARTICULOS.id_escritor
                     INNER JOIN AREAS ON
                            AREAS.id=ARTICULOS.id_area
                    WHERE ARTICULOS.estatus=1";

        return ejecuta_consulta($sql);
    }

    function get_areas(){
      
        $sql="SELECT AREAS.id as id,
                     AREAS.nombre as area
                FROM AREAS";
        return ejecuta_consulta($sql);
    }
    function get_autores_dest(){
      
        $sql="SELECT 
                     USUARIOS.id as id,
                     USUARIOS.nombre as autor
                FROM  USUARIOS 
                WHERE USUARIOS.id_rol=1
                LIMIT 5";
        return ejecuta_consulta($sql);
    }


    function get_coincidencias($cadena){
       
        $sql="SELECT ARTICULOS.id as id_articulo,
                     ARTICULOS.titulo as titulo,
                     ARTICULOS.resumen as resumen,
                     ARTICULOS.siglo as siglo,
                     ARTICULOS.decada as decada,
                     ARTICULOS.cientificos as cientificos,
                     USUARIOS.nombre as autor,
                     ARTICULOS.imagen as imagen,
                     ARTICULOS.id_area as id_area,
                     AREAS.nombre as area
                FROM ARTICULOS 
                     INNER JOIN USUARIOS ON
                            USUARIOS.id=ARTICULOS.id_escritor
                     INNER JOIN AREAS ON
                            AREAS.id=ARTICULOS.id_area
                WHERE ARTICULOS.titulo LIKE '%$cadena%'
                AND ARTICULOS.estatus=1";

              return ejecuta_consulta($sql);
    }

    function get_coincidencias_filtros($filtros_siglo,$filtros_decada){
     
        $sql="SELECT ARTICULOS.id as id_articulo,
                     ARTICULOS.titulo as titulo,
                     ARTICULOS.resumen as resumen,
                     ARTICULOS.siglo as siglo,
                     ARTICULOS.decada as decada,
                     ARTICULOS.cientificos as cientificos,
                     USUARIOS.nombre as autor,
                     ARTICULOS.imagen as imagen,
                     ARTICULOS.id_area as id_area,
                     AREAS.nombre as area
                FROM ARTICULOS 
                     INNER JOIN USUARIOS ON
                            USUARIOS.id=ARTICULOS.id_escritor
                     INNER JOIN AREAS ON
                            AREAS.id=ARTICULOS.id_area
                WHERE ARTICULOS.siglo IN ($filtros_siglo) 
                AND ARTICULOS.decada IN ($filtros_decada)
                AND ARTICULOS.estatus=1";

          return ejecuta_consulta($sql);
    }



    function get_coincidencias_area($idArea){
       
        $sql="SELECT ARTICULOS.id as id_articulo,
                     ARTICULOS.titulo as titulo,
                     ARTICULOS.resumen as resumen,
                     ARTICULOS.siglo as siglo,
                     ARTICULOS.decada as decada,
                     ARTICULOS.cientificos as cientificos,
                     USUARIOS.nombre as autor,
                     ARTICULOS.imagen as imagen,
                     ARTICULOS.id_area as id_area,
                     AREAS.nombre as area
                FROM ARTICULOS 
                     INNER JOIN USUARIOS ON
                            USUARIOS.id=ARTICULOS.id_escritor
                     INNER JOIN AREAS ON
                            AREAS.id=ARTICULOS.id_area
                     WHERE ARTICULOS.id_area=$idArea
                     AND ARTICULOS.estatus=1";

          return ejecuta_consulta($sql);
    }

    function get_coincidencias_autor($idAutor){
   
      $sql="SELECT ARTICULOS.id as id_articulo,
                   ARTICULOS.titulo as titulo,
                   ARTICULOS.resumen as resumen,
                   ARTICULOS.siglo as siglo,
                   ARTICULOS.decada as decada,
                   ARTICULOS.cientificos as cientificos,
                   USUARIOS.nombre as autor,
                   ARTICULOS.imagen as imagen,
                   ARTICULOS.id_area as id_area,
                   AREAS.nombre as area
              FROM ARTICULOS 
                   INNER JOIN USUARIOS ON
                          USUARIOS.id=ARTICULOS.id_escritor
                   INNER JOIN AREAS ON
                          AREAS.id=ARTICULOS.id_area
                   WHERE ARTICULOS.id_escritor=$idAutor
                   AND ARTICULOS.estatus=1";

      return ejecuta_consulta($sql);
  }

  function get_coincidencias_siglos($filtros_siglo){
    
    $sql="SELECT ARTICULOS.id as id_articulo,
                 ARTICULOS.titulo as titulo,
                 ARTICULOS.resumen as resumen,
                 ARTICULOS.siglo as siglo,
                 ARTICULOS.decada as decada,
                 ARTICULOS.cientificos as cientificos,
                 USUARIOS.nombre as autor,
                 ARTICULOS.imagen as imagen,
                 ARTICULOS.id_area as id_area,
                 AREAS.nombre as area
            FROM ARTICULOS 
                 INNER JOIN USUARIOS ON
                        USUARIOS.id=ARTICULOS.id_escritor
                 INNER JOIN AREAS ON
                        AREAS.id=ARTICULOS.id_area
            WHERE ARTICULOS.siglo IN ($filtros_siglo)
            AND ARTICULOS.estatus=1";

      return ejecuta_consulta($sql);
}


function get_coincidencias_decadas($filtros_decada){

  $sql="SELECT ARTICULOS.id as id_articulo,
               ARTICULOS.titulo as titulo,
               ARTICULOS.resumen as resumen,
               ARTICULOS.siglo as siglo,
               ARTICULOS.decada as decada,
               ARTICULOS.cientificos as cientificos,
               USUARIOS.nombre as autor,
               ARTICULOS.imagen as imagen,
               ARTICULOS.id_area as id_area,
               AREAS.nombre as area
          FROM ARTICULOS 
               INNER JOIN USUARIOS ON
                      USUARIOS.id=ARTICULOS.id_escritor
               INNER JOIN AREAS ON
                      AREAS.id=ARTICULOS.id_area
          WHERE  ARTICULOS.decada IN ($filtros_decada)
          AND    ARTICULOS.estatus=1";

  return ejecuta_consulta($sql);
}


function get_coincidencias_siglo($siglo){

  $sql="SELECT ARTICULOS.id as id_articulo,
               ARTICULOS.titulo as titulo,
               ARTICULOS.resumen as resumen,
               ARTICULOS.siglo as siglo,
               ARTICULOS.decada as decada,
               ARTICULOS.cientificos as cientificos,
               USUARIOS.nombre as autor,
               ARTICULOS.imagen as imagen,
               ARTICULOS.id_area as id_area,
               AREAS.nombre as area
          FROM ARTICULOS 
               INNER JOIN USUARIOS ON
                      USUARIOS.id=ARTICULOS.id_escritor
               INNER JOIN AREAS ON
                      AREAS.id=ARTICULOS.id_area
          WHERE ARTICULOS.siglo = $siglo
          AND ARTICULOS.estatus=1";
  return ejecuta_consulta($sql);
}


function get_coincidencias_decada($decada){
  
  $sql="SELECT ARTICULOS.id as id_articulo,
              ARTICULOS.titulo as titulo,
              ARTICULOS.resumen as resumen,
              ARTICULOS.siglo as siglo,
              ARTICULOS.decada as decada,
              ARTICULOS.cientificos as cientificos,
              USUARIOS.nombre as autor,
              ARTICULOS.imagen as imagen,
              ARTICULOS.id_area as id_area,
              AREAS.nombre as area
          FROM ARTICULOS 
              INNER JOIN USUARIOS ON
                      USUARIOS.id=ARTICULOS.id_escritor
              INNER JOIN AREAS ON
                      AREAS.id=ARTICULOS.id_area
          WHERE  ARTICULOS.decada = $decada
          AND ARTICULOS.estatus=1";

  return ejecuta_consulta($sql);
}

function get_coincidencias_cientificos($cadena){

  $sql="SELECT ARTICULOS.id as id_articulo,
               ARTICULOS.titulo as titulo,
               ARTICULOS.resumen as resumen,
               ARTICULOS.siglo as siglo,
               ARTICULOS.decada as decada,
               ARTICULOS.cientificos as cientificos,
               USUARIOS.nombre as autor,
               ARTICULOS.imagen as imagen,
               ARTICULOS.id_area as id_area,
               AREAS.nombre as area
          FROM ARTICULOS 
               INNER JOIN USUARIOS ON
                      USUARIOS.id=ARTICULOS.id_escritor
               INNER JOIN AREAS ON
                      AREAS.id=ARTICULOS.id_area
          WHERE ARTICULOS.cientificos = '$cadena'
          AND ARTICULOS.estatus=1";

  return ejecuta_consulta($sql);
}

function ejecuta_consulta($sql){
  $resul = array(
      'resultado'   => null,
      'estado'      => 0,
      'msgError'    => ''
  );

  $db=get_conn();
  $resultado=mysqli_query($db,$sql);
  if($resultado){
    $field_cnt = mysqli_num_rows($resultado);
    if($field_cnt<=0){
      $resul['msgError']="Sin datos";
      $resul['estado']=-1;
    }else{
      $resul['resultado']=$resultado;
    }                  
  }   else{
      $resul['msgError']="Error: ".$sql.":".mysqli_error($db)."</h3>";
      $resul['estado']=-1;
  }       
  close_conn($db);
  return $resul;
}




    ?>