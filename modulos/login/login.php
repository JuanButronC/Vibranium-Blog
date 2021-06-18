<?php
$servidor = "localhost";
$usuario = "root";
$pwd = "";
$nombreBD = "vibraniumblogdb";
$conn = new mysqli($servidor, $usuario, $pwd, $nombreBD);

if (!$conn) {
    echo 'Error en conexión: ' . mysqli_connect_error();
}

if (isset($_POST['submit'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, $_POST['pass']);

    //Iniciar sesión
    $sql = "SELECT * FROM usuarios "
        . "WHERE correo = '$email' AND "
        . "contrasenia = '$pass'";

    $resultado = mysqli_query($conn, $sql);
    if ($resultado !==false && $resultado->num_rows == 1) {
        session_start();

        //variables de sesión
        $usuario = mysqli_fetch_assoc($resultado);
        $idUser = $usuario["id"];
        $_SESSION['idUsuario'] = $idUser;
        $_SESSION['correo'] = $usuario["correo"];
        $_SESSION['rol'] = $usuario["id_rol"];
        $_SESSION['aut'] = true;

        //datos personales
        $sqlDatos = "SELECT nombre FROM datos_personales WHERE id_usuario = '$idUser'";
        if ($resultDatos = mysqli_query($conn, $sqlDatos)) {
            $datos = mysqli_fetch_assoc($resultDatos);
            //echo $datos["nombre"];
            $_SESSION['nombreUsuario'] = $datos["nombre"];
            $resultDatos->close();
        }

        //redireccionamiento de acuerdo a rol
        if ($usuario["id_rol"] == 1) {
            //Si se trata de un Escritor
            //echo "Escritor";
            header('Location: ../escritor/misArticulos.php');
        } else {
            //Si se trata de un Lector
            //echo "Lector";
            header('Location: ../home/home.php');
        }
    } else {
        //El usuario no está registrado
        
        //$error = 1;
        //echo $error;
        echo
        '<div class="alert alert-danger">
            <strong>¡Atención!</strong> El usuario no se encuentra registrado o la contraseña es incorrecta.
        </div>'
        ;
    }
    mysqli_free_result($resultado);
}else {}
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
    <link rel="stylesheet" href="../../css/templates.css">
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
                                    echo "Bienvenido " . $_SESSION["nombreUsuario"];
                                }
                                ?>
                                <i class="fa fa-user" style="margin-left: 10px;"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <?php
                                if (isset($_SESSION["aut"]) && isset($_SESSION["nombreUsuario"])) {
                                    echo "
                                            <a class='dropdown-item' href='../datosPersonales/datosPersonales.php'>Datos personales</a>
                                            <a class='dropdown-item' href='../login/cerrarSesion.php'>Cerrar Sesión</a>
                                        ";
                                } else {
                                    echo "
                                            <a class='dropdown-item' href='../login/login.php'>Iniciar sesión</a>
                                            <a class='dropdown-item' href='../signIn/registro.php'>Registrarse</a>
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
                        <a class="nav-link" href="../home/home.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../home/vistas/articulos.php">Artículos</a>
                    </li>

                    <?php
                    if (isset($_SESSION["aut"]) && isset($_SESSION["nombreUsuario"]) && isset($_SESSION["rol"]) && $_SESSION["rol"] == 1) {
                        echo "
                            <li class='nav-item'>
                                <a class='nav-link' href='misArticulos.php'>Mis artículos</a>
                            </li>";
                    }
                    ?>
                </ul>
            </div>
        </nav>
    </header>

    <!-- -->
    <div class="container" style="height:1000px; margin-top:50px;">
        <div class="jumbotron">
            <h1 class="display-4"><i class="fa fa-user"></i>¡Bienvenido de nuevo!</h1>
            <br>
            <p class="lead">Si ya estas registrado, ingresa tus datos a continuación:</p>
            <hr class="my-4">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" type="submit" id="formLogin" name="formLogin">
                <div class="row">
                    <div class="col">
                        <h5 align="left">Correo</h5>
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text fa fa-at" id="correo"></span>
                            </div>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Correo">
                        </div>
                        <br>
                        <h5 align="left">Contraseña</h5>
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text fa fa-lock" id="contrasenia"></span>
                            </div>
                            <input type="password" name="pass" id="pass" class="form-control" placeholder="Contraseña">
                        </div>
                        <br>
                        <button id="btnIni" name="submit" class="btn btn-success" type="submit">
                            <span class="fa fa-sign-in"></span> Iniciar sesión
                        </button>
                        <br><br>
                        <br>
                        <p>¿No tienes una cuenta?<a href="#""><i><u style="margin-left:60px">Registrate, es gratis</u></i></a></p>
                    </div>
                    <div class="col">
                        <div class=container" style="text-align:right">
                            <button id="btnCancelar" class="btn btn-danger" type="button" name="cancelar" onclick="location.href='../home/home.php'">
                                <span class="fa fa-undo-alt"></span> Volver
                            </button>
                        </div>
                    </div>
                </div>
            </form>
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

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js" integrity="sha512-RdSPYh1WA6BF0RhpisYJVYkOyTzK4HwofJ3Q7ivt/jkpW6Vc8AurL1R+4AUcvn9IwEKAPm/fk7qFZW3OuiUDeg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../../js/login/loginFunciones.js" type="text/javascript"></script>


</body>

</html>