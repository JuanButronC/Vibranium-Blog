<?php session_start(); 
if(isset($_SESSION["idUsuario"])){
    $idUsuario = $_SESSION["idUsuario"];
} else {
    $idUsuario = null;
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
                                <a class='nav-link' href='../misArticulos.php'>Mis artículos</a>
                            </li>";
                    }
                    ?>
                </ul>
            </div>
        </nav>
    </header>
    <!--Publicar nuevo comentario-->
    <?php
    if (isset($_POST["comentarioNuevo"]) && isset($_POST["idUsuario"]) && isset($_POST["idArticulo"])) {
        $idUsuario = $_POST["idUsuario"];
        $servidor = "localhost";
        $usuarioBD = "root";
        $pwdBD = "";
        $nomBD = "vibraniumblogdb";

        $db = mysqli_connect($servidor, $usuarioBD, $pwdBD, $nomBD);
        $idArticulo = mysqli_real_escape_string($db, $_POST["idArticulo"]);
        $idLector = mysqli_real_escape_string($db, $idUsuario);
        $comentarioNuevo = mysqli_real_escape_string($db, $_POST["comentarioNuevo"]);
        if (!$db) {
            die("La conexión falló: " . mysqli_connect_error());
        } else {
            mysqli_query($db, "SET NAMES UTF8");
            date_default_timezone_set("America/Mexico_City");
            $date = date("Y-m-d H:i:s");
            $sql = "INSERT INTO comentarios VALUES (NULL,'$idArticulo','$idLector', '$comentarioNuevo','$date')";
        }
        if (mysqli_query($db, $sql)) {
            $_SESSION["estatusComentario"] = "Su comentario ha sido añadido con éxito";
        } else {
            echo "Error " . $sql . " :" . mysqli_error($db);
            $_SESSION["estatusComentario"] = "Su comentario no pudo añadirse";
        }
    }
    ?>


    <div class="container" style="height:100%; margin-bottom:40px; margin-top:40px; background-color: white!important;">
        <?php
        $servidor = "localhost";
        $usuarioBD = "root";
        $pwdBD = "";
        $nomBD = "vibraniumblogdb";

        //Mostrar cuerpo de artículo
        if (isset($_GET["idArticulo"]) || isset($_POST["idArticulo"])) {

            $db = mysqli_connect($servidor, $usuarioBD, $pwdBD, $nomBD);

            if(isset($_GET["idArticulo"])){
                $idArticulo = $_GET["idArticulo"];
            }else{
                $idArticulo = $_POST["idArticulo"];
            }

            $idArticulo = mysqli_real_escape_string($db,  $idArticulo);
            $queryArticulo = "SELECT a.imagen, a.titulo, a.contenido, dp.nombre, a.fecha_creacion
                        FROM articulos a
                        JOIN usuarios u ON a.id_escritor = u.id
                        JOIN datos_personales dp ON u.id = dp.id_usuario
                        WHERE a.id= '$idArticulo'"; //cambiar por id de artículo
            $resultado = mysqli_query($db, $queryArticulo);
            while ($mostrar = mysqli_fetch_array($resultado)) {

        ?>
                <div class="container" style="padding-top:40px; padding-bottom: 40px; height:100%;">
                    <div class="row">
                        <div class="col-md-12">
                            <div style="width:100%; height: 300px;">
                                <img src="<?php echo 'data:image/jpeg;base64,' . $mostrar['imagen']; ?>" style="object-fit:fill;width:100%;height:100%;">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <br>
                            <h1><?php echo $mostrar['titulo'] ?></h1>
                            <hr>
                        </div>
                        <div class="col-md-6" align="left" style="vertical-align: middle;">
                            <h4>Escrito por: <?php echo $mostrar['nombre'] ?></h4>
                        </div>
                        <div class="col-md-6" align="right" style="vertical-align: middle;">
                            <p>Fecha de publicación: <?php echo $mostrar['fecha_creacion'] ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="contenidoArticulo" style="height:100%; margin-top:40px; margin-bottom: 40px; text-align:justify">
                                <?php echo $mostrar['contenido']; ?>
                            </div>
                        </div>
                    </div>
                <?php
            }
                ?>
                <?php
                //Mostrar comentarios de artículo
                if (isset($_GET["idArticulo"]) || isset($_POST["idArticulo"])) {
                    $servidor = "localhost";
                    $usuarioBD = "root";
                    $pwdBD = "";
                    $nomBD = "vibraniumblogdb";
                    $db = mysqli_connect($servidor, $usuarioBD, $pwdBD, $nomBD);
                    
            if(isset($_GET["idArticulo"])){
                $idArticulo = $_GET["idArticulo"];
            }else{
                $idArticulo = $_POST["idArticulo"];
            }
                    $idArticulo = mysqli_real_escape_string($db,  $idArticulo);
                    $queryComentarios = "SELECT dp.nombre, c.texto, c.fecha_creacion
                    FROM comentarios c
                    JOIN usuarios l ON c.id_lector = l.id 
                    JOIN datos_personales dp ON l.id = dp.id_usuario
                    WHERE c.id_articulo = '$idArticulo'
                    ORDER BY c.fecha_creacion DESC";
                    $resultado = mysqli_query($db, $queryComentarios);
                    $totalComentarios = mysqli_num_rows($resultado);
                ?>
                    <div class="col-md-12">
                        <hr>
                        <h4 class="card-title">DEJA TU COMENTARIO</h4>
                        <div class="card border-info">
                            <div class="card-header text-info">
                                <h5 class="card-title"><?php echo $totalComentarios ?> comentarios</h5>
                            </div>
                            <div class="card-body">
                                <div class="row" style="margin-bottom:40px">
                                    <div class="col-md-1">
                                        <img src="../../../img/profileImg.png" class="img-responsive img-rounded" style="height:70px; width:70px">
                                    </div>
                                    <div class="col-md-11">
                                        <div class="card" style="border-radius: 0px 40px 5px 5px !important;">
                                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" type="submit" id="formComentario">
                                                <div class="card-body">
                                                    <textarea id="comentarioNuevo" name="comentarioNuevo" style="width:100%; height:100%; min-height:100px; max-height:180px" placeholder="Cuéntanos qué te pareció el artículo"></textarea>
                                                    <input hidden value="<?php echo $idUsuario ?>" name="idUsuario" />
                                                    <input hidden value="<?php echo $idArticulo ?>" name="idArticulo" />
                                                </div>
                                                <div class="card-footer">
                                                    <button id="btnPublicar" class="btn btn-info" style="width:100%" type="submit">
                                                        Publicar
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!--CARDS DINÁMICAS PARA CARGAR COMMENTS-->
                                <div id="dinamycCardsComments">
                                    <?php
                                    if ($totalComentarios == 0) {
                                    ?>
                                        <br>
                                        <div align="center">
                                            <h2>No hay comentarios aún, ¡Sé el primero en comentar!</h2>
                                        </div>
                                        <br>
                                    <?php
                                    }
                                    while ($mostrar = mysqli_fetch_array($resultado)) {
                                    ?>
                                        <hr>
                                        <div class="row" style="margin-top:20px; margin-bottom:20px">
                                            <div class="col-md-1">
                                                <img src="../../../img/profileImg.png" class="img-responsive img-rounded" style="height:70px; width:70px">
                                            </div>
                                            <div class="col-md-11">
                                                <div id="Comment" style="width:100%; height:100%; min-height:100px; max-height:180px;">
                                                    <div id="HeaderComment">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <h4><?php echo $mostrar['nombre'] ?></h4>
                                                            </div>
                                                            <div class="col-md-8" align="right">
                                                                <?php
                                                                date_default_timezone_set("America/Mexico_City");
                                                                $date = new DateTime(date("Y-m-d H:i:s"));
                                                                $date1 = new DateTime($mostrar['fecha_creacion']);
                                                                $diff = $date1->diff($date);
                                                                if ($diff->days < 1) {
                                                                    if ($diff->h < 1) {
                                                                        if ($diff->i < 1) {
                                                                            echo "hace unos instantes";
                                                                        } else {
                                                                            echo "hace " . $diff->format('%i minutos');
                                                                        }
                                                                    } else {
                                                                        echo "hace " . $diff->format('%H horas');
                                                                    }
                                                                } else {
                                                                    echo "hace " . $diff->format('%d') . ' días';
                                                                }
                                                                ?>
                                                            </div>
                                                            <div class="col-md-4" style="text-align:right" hidden>
                                                                10
                                                                <a>
                                                                    <img src="../../../img/like.png" style="width:20px; height:20px">
                                                                </a>
                                                                10
                                                                <a>
                                                                    <img src="../../../img/dislike.png" style="width:20px; height:20px">
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="textoComment" style="text-align: justify;">
                                                        <?php echo $mostrar['texto'] ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            <?php
                                    }
                                }
                            }
                            ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

    </div>

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
    <script src="../../../js/articulo/individualFunciones.js"></script>
    <script>
        var usuarioLoggeado = "<?php echo $idUsuario ?>";
    </script>

</body>

</html>