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
        
        $sql="SELECT articulos.id as id_articulo,
                     articulos.titulo as titulo,
                     articulos.resumen as resumen,
                     articulos.siglo as siglo,
                     articulos.decada as decada,
                     articulos.cientificos as cientificos,
                     datos_personales.nombre as autor,
                     articulos.id_area as id_area,
                     articulos.imagen as imagen,
                     areas.nombre as area
                FROM articulos 
                      INNER JOIN datos_personales ON
                            datos_personales.id_usuario=articulos.id_escritor
                     INNER JOIN areas ON
                            areas.id=articulos.id_area
                    WHERE articulos.estatus=1";

        return ejecuta_consulta($sql);
    }

    function get_areas(){
      
        $sql="SELECT areas.id as id,
                     areas.nombre as area
                FROM areas";
        return ejecuta_consulta($sql);
    }
    function get_autores_dest(){
      
        $sql="SELECT 
                     USUARIOS.id as id,
                     datos_personales.nombre as autor
                FROM  USUARIOS 
                INNER JOIN datos_personales ON
                            datos_personales.id_usuario=USUARIOS.id
                WHERE USUARIOS.id_rol=1
                LIMIT 5";
        return ejecuta_consulta($sql);
    }


    function get_coincidencias($cadena){
       
        $sql="SELECT articulos.id as id_articulo,
                     articulos.titulo as titulo,
                     articulos.resumen as resumen,
                     articulos.siglo as siglo,
                     articulos.decada as decada,
                     articulos.cientificos as cientificos,
                     datos_personales.nombre as autor,
                     articulos.imagen as imagen,
                     articulos.id_area as id_area,
                     areas.nombre as area
                FROM articulos 
                INNER JOIN datos_personales ON
                            datos_personales.id_usuario=articulos.id_escritor
                     INNER JOIN areas ON
                            areas.id=articulos.id_area
                WHERE articulos.titulo LIKE '%$cadena%'
                AND articulos.estatus=1";

              return ejecuta_consulta($sql);
    }

    function get_coincidencias_filtros($filtros_siglo,$filtros_decada){
     
        $sql="SELECT articulos.id as id_articulo,
                     articulos.titulo as titulo,
                     articulos.resumen as resumen,
                     articulos.siglo as siglo,
                     articulos.decada as decada,
                     articulos.cientificos as cientificos,
                     datos_personales.nombre as autor,
                     articulos.imagen as imagen,
                     articulos.id_area as id_area,
                     areas.nombre as area
                FROM articulos 
                INNER JOIN datos_personales ON
                            datos_personales.id_usuario=articulos.id_escritor
                     INNER JOIN areas ON
                            areas.id=articulos.id_area
                WHERE articulos.siglo IN ($filtros_siglo) 
                AND articulos.decada IN ($filtros_decada)
                AND articulos.estatus=1";

          return ejecuta_consulta($sql);
    }



    function get_coincidencias_area($idArea){
       
        $sql="SELECT articulos.id as id_articulo,
                     articulos.titulo as titulo,
                     articulos.resumen as resumen,
                     articulos.siglo as siglo,
                     articulos.decada as decada,
                     articulos.cientificos as cientificos,
                     datos_personales.nombre as autor,
                     articulos.imagen as imagen,
                     articulos.id_area as id_area,
                     areas.nombre as area
                FROM articulos 
                INNER JOIN datos_personales ON
                            datos_personales.id_usuario=articulos.id_escritor
                     INNER JOIN areas ON
                            areas.id=articulos.id_area
                     WHERE articulos.id_area=$idArea
                     AND articulos.estatus=1";

          return ejecuta_consulta($sql);
    }

    function get_coincidencias_autor($idAutor){
   
      $sql="SELECT articulos.id as id_articulo,
                   articulos.titulo as titulo,
                   articulos.resumen as resumen,
                   articulos.siglo as siglo,
                   articulos.decada as decada,
                   articulos.cientificos as cientificos,
                   datos_personales.nombre as autor,
                   articulos.imagen as imagen,
                   articulos.id_area as id_area,
                   areas.nombre as area
              FROM articulos 
              INNER JOIN datos_personales ON
                            datos_personales.id_usuario=articulos.id_escritor
                   INNER JOIN areas ON
                          areas.id=articulos.id_area
                   WHERE articulos.id_escritor=$idAutor
                   AND articulos.estatus=1";

      return ejecuta_consulta($sql);
  }

  function get_coincidencias_siglos($filtros_siglo){
    
    $sql="SELECT articulos.id as id_articulo,
                 articulos.titulo as titulo,
                 articulos.resumen as resumen,
                 articulos.siglo as siglo,
                 articulos.decada as decada,
                 articulos.cientificos as cientificos,
                 datos_personales.nombre as autor,
                 articulos.imagen as imagen,
                 articulos.id_area as id_area,
                 areas.nombre as area
            FROM articulos 
            INNER JOIN datos_personales ON
                            datos_personales.id_usuario=articulos.id_escritor
                 INNER JOIN areas ON
                        areas.id=articulos.id_area
            WHERE articulos.siglo IN ($filtros_siglo)
            AND articulos.estatus=1";

      return ejecuta_consulta($sql);
}


function get_coincidencias_decadas($filtros_decada){

  $sql="SELECT articulos.id as id_articulo,
               articulos.titulo as titulo,
               articulos.resumen as resumen,
               articulos.siglo as siglo,
               articulos.decada as decada,
               articulos.cientificos as cientificos,
               datos_personales.nombre as autor,
               articulos.imagen as imagen,
               articulos.id_area as id_area,
               areas.nombre as area
          FROM articulos 
          INNER JOIN datos_personales ON
                            datos_personales.id_usuario=articulos.id_escritor
               INNER JOIN areas ON
                      areas.id=articulos.id_area
          WHERE  articulos.decada IN ($filtros_decada)
          AND    articulos.estatus=1";

  return ejecuta_consulta($sql);
}


function get_coincidencias_siglo($siglo){

  $sql="SELECT articulos.id as id_articulo,
               articulos.titulo as titulo,
               articulos.resumen as resumen,
               articulos.siglo as siglo,
               articulos.decada as decada,
               articulos.cientificos as cientificos,
               datos_personales.nombre as autor,
               articulos.imagen as imagen,
               articulos.id_area as id_area,
               areas.nombre as area
          FROM articulos 
          INNER JOIN datos_personales ON
                            datos_personales.id_usuario=articulos.id_escritor
               INNER JOIN areas ON
                      areas.id=articulos.id_area
          WHERE articulos.siglo = $siglo
          AND articulos.estatus=1";
  return ejecuta_consulta($sql);
}


function get_coincidencias_decada($decada){
  
  $sql="SELECT articulos.id as id_articulo,
              articulos.titulo as titulo,
              articulos.resumen as resumen,
              articulos.siglo as siglo,
              articulos.decada as decada,
              articulos.cientificos as cientificos,
              datos_personales.nombre as autor,
              articulos.imagen as imagen,
              articulos.id_area as id_area,
              areas.nombre as area
          FROM articulos 
          INNER JOIN datos_personales ON
                            datos_personales.id_usuario=articulos.id_escritor
              INNER JOIN areas ON
                      areas.id=articulos.id_area
          WHERE  articulos.decada = $decada
          AND articulos.estatus=1";

  return ejecuta_consulta($sql);
}

function get_coincidencias_cientificos($cadena){

  $sql="SELECT articulos.id as id_articulo,
               articulos.titulo as titulo,
               articulos.resumen as resumen,
               articulos.siglo as siglo,
               articulos.decada as decada,
               articulos.cientificos as cientificos,
               datos_personales.nombre as autor,
               articulos.imagen as imagen,
               articulos.id_area as id_area,
               areas.nombre as area
          FROM articulos 
          INNER JOIN datos_personales ON
                            datos_personales.id_usuario=articulos.id_escritor
               INNER JOIN areas ON
                      areas.id=articulos.id_area
          WHERE articulos.cientificos = '$cadena'
          AND articulos.estatus=1";

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