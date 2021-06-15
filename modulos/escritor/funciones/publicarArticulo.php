<?php

    include 'comunes.php';
    $_SESSION["idUsuario"]=3;


    $error=false;
    $msgErr="";
    $idArticulo="";
    $idAutor="";

    if(isset($_SESSION["idUsuario"])){
        if(!is_numeric($_SESSION["idUsuario"])){
            $msgErr="El id debe ser númerico";
            $error=true;
        }else{
            $idAutor=limpiaEntrada($_SESSION["idUsuario"]);
        }             
    }else{
        $msgErr="El id es requerido";
        $error=true;
    }

    if(isset($_GET["idArticulo"])){
        if(!is_numeric($_GET["idArticulo"])){
            $msgErr="El id debe ser númerico";
            $error=true;
        }else{
            $idArticulo=limpiaEntrada($_GET["idArticulo"]);
        }             
    }else{
        $msgErr="El id es requerido";
        $error=true;
    }

    if(!$error){
        $resultado_art=get_data_articulo($idArticulo);
            if($resultado_art["estado"]==0){
                
                $res=$resultado_art["resultado"];
                $fila = mysqli_fetch_array($res);
                $id_escritor=$fila["id_autor"];
                $estado=$fila["estado"];
                if($idAutor===$id_escritor){  
                    if($estado!=="1"){                                      
                        $resultado=publica_articulo($idArticulo,$idAutor);            
                        if($resultado["estado"]==0){                      
                            echo "<p>Estimado escritor, su articulo se publico exitosamente.</p>";            
                        }else{   
                            echo "<p>".$resultado['msgError']."</p>"; 
                        } 
                    }else{
                        echo "<p>Imposible publicar el atículo, ya se encuentra publicado.</p>"; 
                    }
                }else{
                    echo "<p>Imposible publicar el atículo, no tiene privilegios sobre el artículo.</p>"; 
                }
        } else{   
            echo "<p>".$resultado_art['msgError']."</p>"; 
        } 
    }else{      
                   echo "<p>".$msgErr."</p>"; 
    } 

    


?>