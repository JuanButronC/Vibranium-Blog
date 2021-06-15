<?php
include '../funciones/comunes.php';
$error=false;
$msgErr="";
$idArticulo="";

if(!empty($_GET["idArticulo"])){
    if(!is_numeric($_GET["idArticulo"])){
        $msgErr="Error al recuperar el artículo: <br>El id debe ser númerico";
        $error=true;
    }else{
        $idArticulo=limpiaEntrada($_GET["idArticulo"]);
    }             
}else{
    $msgErr="Error al recuperar el artículo: <br>El id es requerido";
    $error=true;
}

if($error){
?>
<div class="row" style="margin-top: 20px;">
        <div class="col-md-12">
            <div class="card text-center bg-prim">
                <div class="card-body">
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-12 ">
                            <h3 class= 'card-title'> <span class='fa fa-exclamation-triangle'></span></h3>
                            <h3 class="card-title">Ocurrio un Error</h3>
                           <p><?phpecho $msgErr?></p> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php }else{ ?>
<div id="div-data-get" get-data-id-articulo="<?php echo $idArticulo?>" ></div>       

<div class="container" style="margin-bottom:25px">

    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12">
            <div class="card text-left bg-prim">
                <div class="card-body">
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-10">
                            <h4 class="card-title">Publicar artículo</h4>
                        </div>
                        <div class="col-md-2">
                                    <button type="submit" id="btn-publicar" class="form-control btn bg-second">Publicar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12" >   
            <div class="card text-left card-second">
              <div class="card-body">
                <h4 class="card-title">Vista Resumida</h4>
                    <div class="row justify-content-center">
                        <div class="col-md-10" id="div-preview-resum">   
                            
                        </div>
                    </div>   


              </div>
            </div>
                        
        </div>
    </div> 
    
    <div class="row" style="margin-top: 20px;">
        <div class="col-md-12" >   
            <div class="card text-left card-second">
              <div class="card-body">
                <h4 class="card-title">Vista Completa</h4>
                    <div class="row justify-content-center"">
                        <div class="col-md-10" id="div-preview-content">  
                        </div>
                    </div>  
              </div>
            </div>                        
        </div>
    </div> 

</div>

<script src="js/escritor/utilidadesPublicar.js" type="text/javascript"></script>
<?php } ?>
