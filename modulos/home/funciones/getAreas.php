<?php
include 'comunes.php';


$resultado_areas=get_areas();


if($resultado_areas["estado"]==0){
    $areas=$resultado_areas["resultado"];
    while($fila = mysqli_fetch_array($areas)){
        echo "<li class='nav-item'>";
        echo "<a class='nav-link text-white navArea' href='#' id='".$fila["area"]."-".$fila["id"]."'>".$fila["area"]."</a>";
        echo "</li> ";                            
     }
     mysqli_free_result($areas);  
}else{
    echo "<h5 class='text-danger'>Error</h5>";
    echo "<p class='text-danger'>".$resultado_autores['msgError']."</p>";
}    
?>