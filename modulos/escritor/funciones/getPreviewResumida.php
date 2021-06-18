<?php
    session_start();
    include 'comunes.php';

    $error=false;
    $msgErr="";
    $idArticulo="";

    if(isset($_SESSION["idArticulo"])){
        if(!is_numeric($_SESSION["idArticulo"])){
            $msgErr="El id debe ser númerico";
            $error=true;
        }else{
            $idArticulo=limpiaEntrada($_SESSION["idArticulo"]);
        }             
    }else{
        $msgErr="El id es requerido";
        $error=true;
    }

    if(!$error){
        $resultado=get_preview_articulo($idArticulo);

        
        if($resultado["estado"]==0){
            $articulos=$resultado["resultado"];


            while($fila = mysqli_fetch_array($articulos)){
                echo "<div class= 'card bg-prim card-articulo' id='articulo-".$fila["id_articulo"]."'id-articulo='".$fila["id_articulo"]."' decada-articulo='".$fila["decada"]."' siglo-articulo='".$fila["siglo"]."'>"; 
                echo "<div class= 'card-header text-right '>"; 
                echo "<span class= 'badge bg-second '><a class='a-area' id='".$fila["id_articulo"]."-".$fila["id_area"]."' href= ' '>".$fila["area"]."</a></span>"; 
                echo "<span class= 'badge bg-second '><a class='a-cientificos' id='".$fila["id_articulo"]."-".$fila["cientificos"]."' href= ' '>".$fila["cientificos"]."</a> </span>"; 
                echo "<span class= 'badge bg-second '><a class='a-siglo' id='".$fila["id_articulo"]."-".$fila["siglo"]."' href= ' '> Siglo ".$fila["siglo"]."</a></span>"; 
                echo "<span class= 'badge bg-second '><a class='a-decada' id='".$fila["id_articulo"]."-".$fila["decada"]."' href= ' '>".get_decada_label($fila["decada"])."</a></span>"; 
                echo "</div>";   
                echo "<img class= 'card-img-top card-articulo-img' src = 'data:image/png;base64,". $fila['imagen']."' height= '200px '  width= '100% ' alt= ' '>"; 
                echo "<div class= 'card-body card-articulo-body'>"; 
                echo "<h3 class= 'card-title text-left '>".$fila["titulo"]."</h3>"; 
                echo "<p class= 'text-left '>".$fila["autor"]."</p>"; 
                echo "<h5 class= 'text-left '>Resumen</h5>"; 
                echo "<p class= 'card-text text-justify '>".$fila["resumen"]."</p>"; 
                echo "</div>"; 
                echo "</div>";             
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