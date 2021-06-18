<?php
session_start();
include '../funciones/comunes.php';
$error=false;
$msgErr="";
$idArticulo="";

if(!empty($_GET["idArticulo"])){
    if(!is_numeric($_GET["idArticulo"])){
        $msgErr="Error al recuperar el artículo: <br>El id debe ser númerico";
        $error=true;
    }else{
        $_SESSION["idArticulo"]=limpiaEntrada($_GET["idArticulo"]);

    }             
}else{
    $msgErr="Error al recuperar el artículo: <br>El id es requerido";
    $error=true;
}
?>
<!doctype html>
<html lang="es">

<head>
    <title>Vibranium Blog</title>
    <link rel="icon" type="image/png" href="../../../img/icono.png" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    
    <link rel="stylesheet" href="../../../css/templates.css">
    <link rel="stylesheet" href="../../../css/home.css">




    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js" integrity="sha512-RdSPYh1WA6BF0RhpisYJVYkOyTzK4HwofJ3Q7ivt/jkpW6Vc8AurL1R+4AUcvn9IwEKAPm/fk7qFZW3OuiUDeg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <!-- Brand -->
            <a class="navbar-brand" href="#"><img src="../../../img/logoBlogW.png" alt="logo" width="170px" height="60px"></a>

            <!-- Toggler/collapsibe Button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                </ul>

                <form class="form-inline my-2 my-lg-0">
                    <li class="nav-item dropdown" style="list-style-type:none;">
                        <label class="my-2 my-sm-0" style="font-size: 24px; margin-right: 60px;">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php
                                if (isset($_SESSION["aut"]) && isset($_SESSION["nombreUsuario"])) {
                                    echo "Bienvenido " . $_SESSION["nombreUsuario"];
                                }
                                ?>
                                <i class="fa fa-user" style="margin-left: 10px;"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <?php
                                if (isset($_SESSION["aut"]) && isset($_SESSION["nombreUsuario"])) {
                                    echo "
                                            <a class='dropdown-item' href='.././datosPersonales/datosPersonales.php'>Datos personales</a>
                                            <a class='dropdown-item' href='../../login/cerrarSesion.php'>Cerrar Sesión</a>
                                        ";
                                } else {
                                    echo "
                                            <a class='dropdown-item' href='../../login/login.php'>Iniciar sesión</a>
                                            <a class='dropdown-item' href='../../singIn/registro.php'>Registrarse</a>
                                        ";
                                }
                                ?>

                                <a class="dropdown-item" href="#" hidden>Another action</a>
                                <a class="dropdown-item" href="#" hidden>Something else here</a>
                            </div>
                        </label>
                    </li>
                </form>
            </div>
        </nav>
        <hr style="background-color:white; margin-bottom: 2px;">
        <nav class="navbar navbar-expand-lg navbar-dark" style="padding-top:0px;">

            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item">
                        <a class="nav-link" href="../../home/home.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../home/vistas/articulos.php">Artículos</a>
                    </li>

                    <?php
                    if (isset($_SESSION["aut"]) && isset($_SESSION["nombreUsuario"]) && isset($_SESSION["rol"]) && $_SESSION["rol"] == 1) {
                        echo "
                            <li class='nav-item'>
                                <a class='nav-link' href='../misArticulos.php'>Mis artículos</a>
                            </li>";
                    }
                    ?>
                </ul>
            </div>
        </nav>
    </header>
<?php if($error){
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

<script src="../../../js/escritor/utilidadesPublicar.js" type="text/javascript"></script>
<?php } ?>

<footer>
        <div class="row">
            <div class="col-md-3">
                <h3>Contáctanos</h3>
                <h5>Redes Sociales</h5>
                <p>
                    <img src="../../../img/facebook.png" alt="facebook" height="50px" width="50px">
                    <img src="../../../img/instagram.png" alt="instagram" height="50px" width="50px">
                    <img src="../../../img/youtube.png" alt="youtube" height="50px" width="50px">
                </p>
                <h5>Email</h5>
                <h6>vibraniumblog@contactme.com</h6>
            </div>
            <div class="col-md-6">
            <h3>Colaboradores</h3>
                <ul>
                    <li>
                        <h5>Butrón Cañada Juan Jesús</h5>
                    </li>
                    <li>
                        <h5>Díaz Rodríguez Andrés Heladio</h5>
                    </li>
                    <li>
                        <h5>Martínez Carrillo Leonardo</h5>
                    </li>
                    <li>
                        <h5>Reyes Montiel Fernando Braulio</h5>
                    </li>
                    <li>
                        <h5>Rodriguez Duarte Brando Ivan</h5>
                    </li>
                </ul>
            </div>
            </div>
            <div class="col-md-3">
                <h3>Newsletter</h3>
                <p align="justify">Unete a nosotros para obtener las últimas novedades.</p>
                <div class="input-group mb-4">
                    <div class="input-group-prepend">
                        <span class="input-group-text fa fa-paper-plane" id="basic-addon1"></span>
                    </div>
                    <input type="text" class="form-control" aria-describedby="basic-addon1">
                </div>
                <p><u>Términos y condiciones</u></p>
            </div>
        </div>
        <hr>
        <h5>2021 Vibranium Blog <i class="fa fa-registered"></i></h5>

    </footer>

</body>

</html>
