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

    function publica_articulo($idArticulo,$idAutor){
        $fechaAct = date("Y/m/d");
        $sql="UPDATE ARTICULOS 
                SET ARTICULOS.estatus=1,
                ARTICULOS.fecha_publicacion='$fechaAct' 
                WHERE ARTICULOS.id=$idArticulo
                AND ARTICULOS.id_escritor=$idAutor";

        return ejecuta_consulta_update($sql);
    }

    function get_content_articulo($idArticulo){
        
        $sql="SELECT ARTICULOS.id as id_articulo,
                     ARTICULOS.contenido as contenido                 
                FROM ARTICULOS 
                WHERE ARTICULOS.id=$idArticulo";

        return ejecuta_consulta($sql);
    }

    function get_preview_articulo($idArticulo){
        
        $sql="SELECT ARTICULOS.id as id_articulo,
                     ARTICULOS.titulo as titulo,
                     ARTICULOS.resumen as resumen,
                     ARTICULOS.siglo as siglo,
                     ARTICULOS.decada as decada,
                     ARTICULOS.cientificos as cientificos,
                     DATOS_PERSONALES.nombre as autor,
                     ARTICULOS.id_area as id_area,
                     ARTICULOS.imagen as imagen,
                     AREAS.nombre as area                 

                FROM ARTICULOS 
                      INNER JOIN DATOS_PERSONALES ON
                            DATOS_PERSONALES.id_usuario=ARTICULOS.id_escritor
                     INNER JOIN AREAS ON
                            AREAS.id=ARTICULOS.id_area
                WHERE ARTICULOS.id=$idArticulo";

        return ejecuta_consulta($sql);
    }

    function get_data_articulo($idArticulo){
        
        $sql="SELECT ARTICULOS.id as id_articulo,
                     ARTICULOS.id_escritor as id_autor,
                     ARTICULOS.estatus as   estado      
                FROM ARTICULOS 
                WHERE ARTICULOS.id=$idArticulo";

        return ejecuta_consulta($sql);
    }


    function ejecuta_consulta_update($sql){
        $resul = array(
            'resultado'   => null,
            'estado'      => 0,
            'msgError'    => ''
        );
      
        $db=get_conn();
        $resultado=mysqli_query($db,$sql);
        if(!$resultado){
            $resul['msgError']="Error: ".$sql.":".mysqli_error($db)."</h3>";
            $resul['estado']=-1;
        }
        close_conn($db);
        return $resul;
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