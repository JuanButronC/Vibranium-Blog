<?php
   session_start();

   $dirRaiz = getcwd() . "/";
   include $dirRaiz . 'templates/header.php';
?>

<div class="container">
   <br>

   <h1 class="text-center">Mis Artículos</h1>

   <br>

   <div class="row justify-content-center">
      <div class="col-auto">
         <?php
            include "listadoArticulos.php";
         ?>
      </div>
   </div>
</div>

<?php
   include $dirRaiz . 'templates/footer.html';
?>