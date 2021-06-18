<?php
session_start();
$servidor = "localhost";
$usuario = "root";
$pwd = "";
$nombreBD = "vibraniumblogdb";
$conn = new mysqli($servidor, $usuario, $pwd, $nombreBD);
session_start();
if (!$conn) {
    echo 'Error de conexión: ' . mysqli_connect_error();
}

$estatusPublicado = false;
if (isset($_POST['eliminar'])) {
    $id_borrar = mysqli_real_escape_string($conn, $_POST['id_articulo']);
    $query = "SELECT estatus FROM articulos where id ='$id_borrar'";
    $estatus = mysqli_query($conn, $query);
    if ($estatus->num_rows == 1) {
        $publicado = mysqli_fetch_assoc($estatus);
    }
    if ($publicado["estatus"] == 1) {
        $estatusPublicado = true;
    } else {
        $sql = "DELETE FROM articulos  WHERE id ='$id_borrar'";
        $resultado = mysqli_query($conn, $sql);
        if ($resultado) {
            header('Location: ../../modulos/escritor/articulo/eliminar.php?id=');
        } else {
            echo "Error: " . $sql . ":" . mysqli_error($conn);
        }
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id == null) {
        $sql = "SELECT 'No Existe ' as titulo, 3 as estatus, 0 as siglo, 
                        'No aplica lugar' as lugar, 'No aplica científicos' as cientificos, 
                        'No aplica premios' as premios,'No aplica área' as nombre, 10 as decada, 
                        'Sin contenido' as contenido 
                        FROM dual";
        $id = -1;
    } else {
        $sql = "SELECT articulos.titulo, articulos.estatus, articulos.siglo, 
                        articulos.lugar, articulos.cientificos, 
                        articulos.premios,areas.nombre, articulos.decada, 
                        articulos.contenido 
                        FROM articulos INNER JOIN areas ON articulos.id_area=areas.id where articulos.id='$id'";
    }

    //Iniciar sesión


    $resultado = mysqli_query($conn, $sql);
    if ($resultado->num_rows == 1) {

        $articulo = mysqli_fetch_assoc($resultado);
    }
}

$decada = $articulo['decada'];
switch ($decada) {
    case 0:
        $decada = "Los 00's";
        break;
    case 1:
        $decada = "Los 10's";
        break;
    case 2:
        $decada = "Los 20's";
        break;
    case 3:
        $decada = "Los 30's";
        break;
    case 4:
        $decada = "Los 40's";
        break;
    case 5:
        $decada = "Los 50's";
        break;
    case 6:
        $decada = "Los 60's";
        break;
    case 7:
        $decada = "Los 70's";
        break;
    case 8:
        $decada = "Los 80's";
        break;
    case 9:
        $decada = "Los 90's";
        break;
    case 10:
        $decada = "No aplica decada";
        break;
}

?>

<!doctype html>
<html lang="es">

<head>
    <title>Vibranium Blog</title>
    <link rel="icon" type="image/png" href="../../img/icono.png" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jodit/3.4.25/jodit.min.css">
    <link rel="stylesheet" href="../../css/templates.css">
    <link rel="stylesheet" href="../../css/eliminar.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <!-- Brand -->
            <a class="navbar-brand" href="#"><img src="../../img/logoBlogW.png" alt="logo" width="170px" height="60px"></a>

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
                                    echo "Bienvenido " + $_SESSION["nombreUsuario"];
                                }
                                ?>
                                <i class="fa fa-user" style="margin-left: 10px;"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <?php
                                if (isset($_SESSION["aut"]) && isset($_SESSION["nombreUsuario"])) {
                                    echo "
                                            <a class='dropdown-item' href='../../datosPersonales/datosPersonales.php'>Datos personales</a>
                                            <a class='dropdown-item' href='../../login/cerrarSesion.php'>Cerrar Sesión</a>
                                        ";
                                } else {
                                    echo "
                                            <a class='dropdown-item' href='../../login/login.php'>Iniciar sesión</a>
                                            <a class='dropdown-item' href='../../signIn/registro.php'>Registrarse</a>
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
                                <a class='nav-link' href='../../escritor/misArticulos.php'>Mis artículos</a>
                            </li>";
                    }
                    ?>
                </ul>
            </div>
        </nav>
    </header>
    <div style="padding: 3%;">
        <a href="../home/home.php" class="btn btn-outline-dark my-2 my-sm-0" type="submit"><i class="fa fa-chevron-left"></i> Regresar</a>
        <br>
        <br>
        <div class="text-center">
            <h1 aling="center"><b>Eliminar Artículo</b></h1>
            <hr class="border-primary">
        </div>
        <br>

        <p id="tituloArticulo"><i class="fa fa-bookmark"></i> <b>
                <?php $leyenda = 'Nombre Artículo: ' . $articulo['titulo'];
                if ($articulo['estatus'] == 1) {
                    $leyenda = $leyenda . ' (Publicado).';
                } else if ($articulo['estatus'] ==  0) {
                    $leyenda = $leyenda . ' (No Publicado).';
                } else {
                }
                echo $leyenda;
                ?>

            </b></p>
        <div class="row">
            <div class="offset-md-1 col-md-10">
                <h3><b>Detalles</b></h3>
                <div class="card border-info">
                    <div class="card-body">
                        <div id="detalles">
                            <div class="row">
                                <div id="izquierda" class="col-md-6">
                                    <label> Descubierto en: </label>
                                    <input type="text" class="form-control text-left" disabled id="inDescubierto" name="inDescubierto" value="<?php if ($articulo['siglo'] != 0) {
                                                                                                                                                    echo 'Siglo ' . $articulo['siglo'];
                                                                                                                                                } else {
                                                                                                                                                    echo 'No aplica siglo';
                                                                                                                                                }
                                                                                                                                                ?>" />
                                    <label> Atribuido a: </label>
                                    <input type="text" class="form-control" disabled id="inAtribuido" name="inAtribuido" value="<?php echo $articulo['cientificos'] ?>" />
                                    <label> Área: </label>
                                    <input type="text" class="form-control" disabled id="inArea" name="inArea" value="<?php echo $articulo['nombre'] ?>" />
                                </div>
                                <div id="derecha" class="col-md-6">
                                    <label> Lugar de descubrimiento: </label>
                                    <input type="text" class="form-control" disabled id="inDescubierto" name="inDescubierto" value="<?php echo $articulo['lugar'] ?>" />
                                    <label> Premios: </label>
                                    <input type="text" class="form-control" disabled id="inAtribuido" name="inAtribuido" value="<?php echo $articulo['premios'] ?>" />
                                    <label> Década: </label>
                                    <input type="text" class="form-control" disabled id="inArea" name="inArea" value="<?php echo $decada ?>" />
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="offset-md-1 col-md-10">
                <h3><b>Contenido</b></h3>
                <div class="card border-info">
                    <div class="card-body">
                        <?php echo $articulo['contenido'] ?>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="text-center">
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#Modal" style="font-size: 18px;">
                <i class="fa fa-trash mr-2"></i> Eliminar
            </button>
            <?php
            include 'modalesEliminar.php';
            ?>
        </div>
    </div>


    <footer>
        <div class="row">
            <div class="col-md-3">
                <h3>Contáctanos</h3>
                <h5>Redes Sociales</h5>
                <p>
                    <img src="../../img/facebook.png" alt="facebook" height="50px" width="50px">
                    <img src="../../img/instagram.png" alt="instagram" height="50px" width="50px">
                    <img src="../../img/youtube.png" alt="youtube" height="50px" width="50px">
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

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jodit/3.4.25/jodit.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js" integrity="sha512-RdSPYh1WA6BF0RhpisYJVYkOyTzK4HwofJ3Q7ivt/jkpW6Vc8AurL1R+4AUcvn9IwEKAPm/fk7qFZW3OuiUDeg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        var estatus = "<?php echo $estatusPublicado; ?>";
        var id = "<?php echo $id; ?>" == "-1";
    </script>
    <script src="../../js/eliminar.js" type="text/javascript"></script>
</body>

</html>