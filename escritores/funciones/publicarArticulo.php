<?php

    include 'comunes.php';
    $_SESSION["id-articulo"]=3;
    $_SESSION["id-escritor"]=3;


    $error=false;
    $msgErr="";
    $idArticulo="";
    $idAutor="";

    if(isset($_SESSION["id-escritor"])){
        if(!is_numeric($_SESSION["id-escritor"])){
            $msgErr="El id debe ser númerico";
            $error=true;
        }else{
            $idAutor=limpiaEntrada($_SESSION["id-escritor"]);
        }             
    }else{
        $msgErr="El id es requerido";
        $error=true;
    }

    if(isset($_SESSION["id-articulo"])){
        if(!is_numeric($_SESSION["id-articulo"])){
            $msgErr="El id debe ser númerico";
            $error=true;
        }else{
            $idArticulo=limpiaEntrada($_SESSION["id-articulo"]);
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