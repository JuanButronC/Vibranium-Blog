<?php
   session_start();

   include $_SESSION["dirRaiz"] . 'templates/header.php';
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="container">
   <br>

   <h1 class="text-center">Datos Personales</h1>
   <br>

   <div class="row justify-content-center">
      <form class="form col-md-5" id="formActualizar">
         <div class="form-group">
            <label for="nombre">Nombre</label>
            <div class="input-group">
               <div class="input-group-prepend">
                  <i class="input-group-text fas fa-user"></i>
               </div>
               <input type="text" class="form-control" name="nombre" id="nombre" readonly>
            </div>
         </div>

         <div class="form-group">
            <label for="nombre">Apellido Paterno</label>
            <div class="input-group">
               <div class="input-group-prepend">
                  <i class="input-group-text fas fa-users"></i>
               </div>
               <input type="text" class="form-control" name="apPat" id="apPat" readonly>
            </div>
         </div>

         <div class="form-group">
            <label for="nombre">Apellido Materno</label>
            <div class="input-group">
               <div class="input-group-prepend">
                  <i class="input-group-text fas fa-users"></i>
               </div>
               <input type="text" class="form-control" name="apMat" id="apMat" readonly>
            </div>
         </div>

         <div class="form-group">
            <label for="nombre">Fecha de nacimiento</label>
            <div class="input-group">
               <div class="input-group-prepend">
                  <i class="input-group-text fas fa-calendar"></i>
               </div>
               <input type="text" class="form-control" name="fecNac" id="fecNac" disabled>
            </div>
         </div>

         <div class="form-group">
            <label for="nombre">Sexo</label>
            <div class="input-group">
               <div class="input-group-prepend">
                  <i class="input-group-text fas fa-venus-mars"></i>
               </div>
               <select class="form-control" id="sexo" name="sexo" disabled>
                  <option value="-1">Seleccione un sexo</option>
                  <option value="0">Femenino</option>
                  <option value="1">Masculino</option>
               </select>
            </div>
         </div>

         <br>

         <div class="text-center">
            <button type="button" id="btnEditar" class="btn btn-warning">Editar</button>
            <button type="button" id="btnCancelar" class="btn btn-danger">Cancelar</button>
            <button type="submit" id="btnActualizar" class="btn text-white" type="submit" style="background-color: #4b608a;">Actualizar</button>
         </div>
      </form>
   </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
   let idUsuario = <?php echo $_SESSION["idUsuario"] ?>;
</script>

<script src="datosPersonales.js"></script>

<?php
   include $_SESSION["dirRaiz"] . 'templates/footer.html';
?>