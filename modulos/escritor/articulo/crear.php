<!--Crear artículo-->
<?php
//Recuperar las variables de sesión
session_start();

//Conexión a la base de datos
$servidor = "localhost";
$usuarioBD = "root";
$pwdBD = "";
$nomBD = "vibraniumblogdb";

$conn = new mysqli($servidor, $usuarioBD, $pwdBD, $nomBD);

if (!$conn) {
    echo 'Error de conexión: ' . mysqli_connect_error();
} else {
    mysqli_query($conn, "SET NAMES 'UTF8'");
}

//Acciones en POST
if (isset($_POST['submit'])) {
    //Obtener todos los campos
    $idUser = $_SESSION["idUsuario"];
    $fechaCrea = date("Y/m/d");
    $tituloA = mysqli_real_escape_string($conn, $_POST['titulo']);
    $resumen = mysqli_real_escape_string($conn, $_POST['resumen']);
    $lugarA = mysqli_real_escape_string($conn, $_POST['lugar']);
    $premiosA = mysqli_real_escape_string($conn, $_POST['premios']);
    $decadaA = mysqli_real_escape_string($conn, $_POST['decada']);
    $sigloA = mysqli_real_escape_string($conn, $_POST['siglo']);
    $cientificosA = mysqli_real_escape_string($conn, $_POST['cientificos']);
    $areaA = mysqli_real_escape_string($conn, $_POST['area']);
    $contenidoA = mysqli_real_escape_string($conn, $_POST['contenido']);

    //Relacionado a la imagen
    if(getimagesize($_FILES['imagefile']['tmp_name']) == false){
        echo "Por favor, seleccione una imagen antes.";
    }else{
        $imagenA = $_FILES['imagefile']['tmp_name'];
        $imagenA = base64_encode(file_get_contents(addslashes($imagenA)));

        //insert
        $sql = "INSERT INTO `articulos`(`id`, `id_escritor`, `estatus`, `titulo`, `resumen`, `id_area`, `fecha_creacion`, `fecha_publicacion`, `decada`, `siglo`, `cientificos`, `lugar`, `premios`, `contenido`, `imagen`) VALUES (NULL,'$idUser','0','$tituloA','$resumen','$areaA','$fechaCrea',NULL,'$decadaA','$sigloA','$cientificosA','$lugarA','$premiosA','$contenidoA','$imagenA')";
        //echo $sql;

        //Ejecución del query para insertar el artículo
        $resultado = mysqli_query($conn, $sql);
        if ($resultado) {
            //Redirección al home del Escritor
            echo
            '<div class="alert alert-success">
                <strong>¡Éxito!</strong> Artículo creado satisfactoriamente.
            </div>';
            //header('Location: ');
        }
        else
        {
            //Mensaje de error
            $msjeError = " Error: " . $sql . ":" . mysqli_error($conn);
            echo
            '<div class="alert alert-danger"><strong>¡Atención!</strong>'.$msjeError.'</div>';
        }
    }
}
?>
<!doctype html>
<html lang="es">

<head>
    <title>Vibranium Blog</title>
    <link rel="icon" type="image/png" href="../../../img/icono.png" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="../../../css/templates.css">
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
                                    <a class='dropdown-item' href='../../datosPersonales/datosPersonales.php'>Datos personales</a>
                                    <a class='dropdown-item' href='../../login/cerrarSesion.php'>Cerrar Sesión</a>
                                        ";
                                } else {
                                    echo "
                                            <a class='dropdown-item' href='iniciarSesion.php'>Iniciar sesión</a>
                                            <a class='dropdown-item' href='registro.php'>Registrarse</a>
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
        <hr style="background-color:white; margin-bottom: 2px; margin-top: 2px;">
        <nav class="navbar navbar-expand-lg navbar-dark" style="padding-top:0px;">

            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="../../escritor/listadoArticulos.php">Artículos</a>
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
    
    <!--Creando artículo-->
            <div class="container" style="margin-top:40px; margin-bottom: 40px">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" type="submit" id="formCrear" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">
                            <div align="left">
                                <h1>Escribir un nuevo artículo</h1>
                            </div>
                            <hr>
                        </div>
                        <div class="col-md-6">
                            <input hidden name="idArticulo" value="<?php echo $idArticulo; ?>" />
                            <label for="basic-url">Título</label>
                            <div class="input-group mb-3">
                                <input name="titulo" type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3">
                            </div>
                            <label for="basic-url">Lugar de descubrimiento</label>
                            <div class="input-group mb-3">
                                <input name="lugar" type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3">
                            </div>
                            <label for="basic-url">Premios</label>
                            <div class="input-group mb-3">
                                <input name="premios" type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3">
                            </div>
                            <label for="basic-url">Década</label>
                            <div class="input-group mb-3">
                                <select type="text" class="form-control" id="selectDecada" name="decada">
                                    <option value="-1">Selecciona una opción</option>
                                    <option value="0">00's</option>
                                    <option value="1">10's</option>
                                    <option value="2">20's</option>
                                    <option value="3">30's</option>
                                    <option value="4">40's</option>
                                    <option value="5">50's</option>
                                    <option value="6">60's</option>
                                    <option value="7">70's</option>
                                    <option value="8">80's</option>
                                    <option value="9">90's</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="basic-url">Fecha de descubrimiento</label>
                            <div class="input-group mb-3">
                                <select type="text" class="form-control" id="selectSiglo" name="siglo">
                                    <option value="-1">Selecciona una opción</option>
                                    <option value="20">Siglo XX</option>
                                    <option value="21">Siglo XXI</option>
                                </select>
                            </div>
                            <label for="basic-url">Atribuido a</label>
                            <div class="input-group mb-3">
                                <input name="cientificos" type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3">
                            </div>
                            <label for="basic-url">Área</label>
                            <div class="input-group mb-3">
                                <select type="text" class="form-control" id="selectArea" name="area">
                                    <option value="-1">Selecciona una opción</option>
                                    <!--Consulta de areas-->
                                    <?php
                                    $servidor = "localhost";
                                    $usuarioBD = "root";
                                    $pwdBD = "";
                                    $nomBD = "vibraniumblogdb";
                                    $db = mysqli_connect($servidor, $usuarioBD, $pwdBD, $nomBD);
                                    $query = "SELECT id, nombre 
                                        FROM areas";
                                    $resultado = mysqli_query($db, $query);
                                    while ($mostrarArea = mysqli_fetch_array($resultado)) {
                                        if ($mostrarArea['id'] == $area) {
                                    ?>
                                            <option selected value="<?php echo $mostrarArea['id'] ?>"><?php echo $mostrarArea['nombre'] ?></option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="<?php echo $mostrarArea['id'] ?>"><?php echo $mostrarArea['nombre'] ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div align="left"><br>
                            <hr>
                                <h3>Resumen</h3>
                            </div>
                            <textarea id="resumen" name="resumen" style="width: 100%; height: 150px; max-height:100%; background-color: #ffffff" maxlength="50000"></textarea>
                        </div>
                        <div class="col-md-12">
                            <hr>
                            <div align="left"><br>
                                <h3>Contenido</h3>
                            </div>
                            <div id="editorContainer" style="width: 100%; height: 1000px; background-color: #ffffff">
                            <textarea id="editor"></textarea>
                            </div>
                            <textarea hidden id="contenido" name="contenido">Reemplazo</textarea>
                            <br>
                            <div align="right">
                                <div align="right" style="display: inline-block; float:left;">
                                    <input type="file" name="imagefile" id="cargaImagen" class="btn btn-secondary" style="margin-top: 10px;padding-top: 2px; padding-bottom: 2px" required>
                                </div>
                                <button id="save" type="submit" name="submit" class="btn btn-secondary" style="margin-top: 10px;padding-top: 2px; padding-bottom: 2px; display: inline-block;">
                                    <span class="fa fa-save"></span>
                                    Guardar
                                </button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    <?php
        
    
    ?>

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

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js" integrity="sha512-RdSPYh1WA6BF0RhpisYJVYkOyTzK4HwofJ3Q7ivt/jkpW6Vc8AurL1R+4AUcvn9IwEKAPm/fk7qFZW3OuiUDeg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jodit/3.4.25/jodit.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jodit/3.4.25/jodit.min.js"></script>
    <script src="../../../js/articulo/crearFunciones.js" type="text/javascript"></script>


</body>

</html>