<?php
    include 'comunes.php';


    $error=false;
    $filtros_siglo="";
    $filtros_decada="";
    $temp="";
    for($cont=20;$cont>21;$cont++){
        if(!empty($_GET["inputSiglo".$cont])){
            if(!is_numeric($_GET["inputSiglo".$cont])){
                $msgErr="El filtro debe ser númerico";
                $error=true;
            }else{
                $temp=limpiaEntrada($_GET["inputSiglo".$cont]);
                $filtros_siglo=$filtros_siglo.$temp.","; 
            }             
        }
    }
    for($cont=0;$cont>9;$cont++){
        if(!empty($_GET["inputDecada".$cont])){
            if(!is_numeric($_GET["inputDecada".$cont])){
                $msgErr="El filtro debe ser númerico";
                $error=true;
            }else{
                $temp=limpiaEntrada($_GET["inputDecada".$cont]);
                $filtros_decada=$filtros_decada.$temp.","; 
            }             
        }
    }   

    if(!$error){
        $resultado=null;
        if(empty($filtros_siglo)){
        $filtros_decada = substr($filtros_decada, 0, -1);
        $resultado=get_coincidencias_decadas($filtros_decada);

        }else if(empty($filtros_decada)){
            $filtros_siglo= substr($filtros_siglo, 0, -1);
        $resultado=get_coincidencias_siglos($filtros_siglo);

        }else{
            $filtros_siglo= substr($filtros_siglo, 0, -1);
            $filtros_decada = substr($filtros_decada, 0, -1);
            $resultado=get_coincidencias_filtros($filtros_siglo,$filtros_decada);
        }       
        
        if($resultado["estado"]==0){
            $articulos=$resultado["resultado"];


            while($fila = mysqli_fetch_array($articulos)){
                echo "<div class='row' style='margin-bottom: 20px;'>";
                echo "<div class= 'col ' >";        
                echo "<div class= 'card bg-prim card-articulo' id='articulo-".$fila["id_articulo"]."'id-articulo='".$fila["id_articulo"]."' decada-articulo='".$fila["decada"]."' siglo-articulo='".$fila["siglo"]."'>"; 
                echo "<div class= 'card-header text-right '>"; 
                echo "<span class= 'badge bg-second '><a class='a-area' id='".$fila["id_articulo"]."-".$fila["id_area"]."' href= ' '>".$fila["area"]."</a></span>"; 
                echo "<span class= 'badge bg-second '><a class='a-cientificos' id='".$fila["id_articulo"]."-".$fila["cientificos"]."' href= ' '>".$fila["cientificos"]."</a> </span>"; 
                echo "<span class= 'badge bg-second '><a class='a-siglo' id='".$fila["id_articulo"]."-".$fila["siglo"]."' href= ' '> Siglo ".$fila["siglo"]."</a></span>"; 
                echo "<span class= 'badge bg-second '><a class='a-decada' id='".$fila["id_articulo"]."-".$fila["decada"]."' href= ' '>".get_decada_label($fila["decada"])."</a></span>"; 
                echo "</div>";   
                echo "<img class= 'card-img-top card-articulo-img' src = 'data:image/png;base64,". base64_encode($fila['imagen'])."' height= '200px '  width= '100% ' alt= ' '>"; 
                echo "<div class= 'card-body card-articulo-body'>"; 
                echo "<h3 class= 'card-title text-left '>".$fila["titulo"]."</h3>"; 
                echo "<p class= 'text-left '>".$fila["autor"]."</p>"; 
                echo "<h5 class= 'text-left '>Resumen</h5>"; 
                echo "<p class= 'card-text text-justify '>".$fila["resumen"]."</p>"; 
                echo "</div>"; 
                echo "</div>"; 
                echo "</div>"; 
                echo "</div>";               
            }

            mysqli_free_result($articulos);  
            }else{
                echo "<div class='row' style='margin-bottom: 20px;'>";
                echo "<div class= 'col ' >";        
                echo "<div class= 'card bg-prim card-articulo text-center'>"; 
                echo "<div class= 'card-body '>"; 
                echo "<h3 class= 'card-title'> <span class='fa fa-exclamation-triangle'></span></h3>"; 
                echo "<p>".$resultado['msgError']."</p>"; 
                echo "</div>"; 
                echo "</div>"; 
                echo "</div>"; 
                echo "</div>"; 
            } 
    }else{
        echo "<div class='row' style='margin-bottom: 20px;'>";
                echo "<div class= 'col ' >";        
                echo "<div class= 'card bg-prim card-articulo text-center'>"; 
                echo "<div class= 'card-body '>"; 
                echo "<h3 class= 'card-title'> <span class='fa fa-exclamation-triangle'></span></h3>"; 
                echo "<p>".$msgErr."</p>"; 
                echo "</div>"; 
                echo "</div>"; 
                echo "</div>"; 
                echo "</div>"; 
    } 

    


?>