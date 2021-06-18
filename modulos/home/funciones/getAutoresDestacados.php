
<?php

include 'comunes.php';




$resultado_autores=get_autores_dest();


if($resultado_autores["estado"]==0){
    $autores=$resultado_autores["resultado"];
        echo "Autores destacados";
    while($fila = mysqli_fetch_array($autores)){
        echo "<br>";
        echo "<button type='button' class='form-control text-left btn bg-second btn-autores' id='".$fila["autor"]."-".$fila["id"]."'>";
        echo "<span class='fa fa-user'></span> ";
        echo $fila["autor"];
        echo "</button>";                
     }

     mysqli_free_result($autores);  
}else{
                echo "<h3 class= 'text-center'> <span class='fa fa-exclamation-triangle'></span></h3>"; 
                echo "<p class= 'text-center'>".$resultado_autores['msgError']."</p>"; 
               
} 



?>