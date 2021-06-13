<?php

    include 'comunes.php';
    $_SESSION["id-articulo"]=3;


    $error=false;
    $msgErr="";
    $idArticulo="";

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
        $resultado=get_content_articulo($idArticulo);

        
        if($resultado["estado"]==0){
            $articulos=$resultado["resultado"];


            while($fila = mysqli_fetch_array($articulos)){                      
                echo $fila["contenido"];              
            }

            mysqli_free_result($articulos);  
            }else{   
                echo "<div class= 'card bg-prim card-articulo text-center'>"; 
                echo "<div class= 'card-body '>"; 
                echo "<h3 class= 'card-title'> <span class='fa fa-exclamation-triangle'></span></h3>"; 
                echo "<p>".$resultado['msgError']."</p>"; 
                echo "</div>"; 
                echo "</div>";
            } 
    }else{      
                echo "<div class= 'card bg-prim card-articulo text-center'>"; 
                echo "<div class= 'card-body '>"; 
                echo "<h3 class= 'card-title'> <span class='fa fa-exclamation-triangle'></span></h3>"; 
                echo "<p>".$msgErr."</p>"; 
                echo "</div>"; 
                echo "</div>";
    } 

    


?>