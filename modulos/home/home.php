<?php
session_start();
$servidor = "localhost";
$usuario = "root";
$pwd = "";
$nombreBD = "vibraniumblogdb";
$conn = mysqli_connect($servidor, $usuario, $pwd, $nombreBD);

if (!$conn) {
    echo 'Error de conexión: ' . mysqli_connect_error();
}

$sql = "SELECT articulos.id,articulos.titulo, articulos.siglo, 
  articulos.lugar, articulos.cientificos, articulos.premios,areas.nombre, articulos.decada, 
  articulos.contenido, datos_personales.nombre || ' ' || datos_personales.ape_pat || ' ' || datos_personales.ape_mat as ESCRITOR, articulos.imagen
  FROM articulos INNER JOIN areas ON articulos.id_area=areas.id
  JOIN usuarios ON articulos.id_escritor=usuarios.id
  JOIN datos_personales ON usuarios.id = datos_personales.id_usuario
  WHERE articulos.estatus = 1
   LIMIT 4";

$resultado = mysqli_query($conn, $sql);

function decada($decada)
{
    switch ($decada) {
        case 0:
            $decada = "00's";
            break;
        case 1:
            $decada = "10's";
            break;
        case 2:
            $decada = "20's";
            break;
        case 3:
            $decada = "30's";
            break;
        case 4:
            $decada = "40's";
            break;
        case 5:
            $decada = "50's";
            break;
        case 6:
            $decada = "60's";
            break;
        case 7:
            $decada = "70's";
            break;
        case 8:
            $decada = "80's";
            break;
        case 9:
            $decada = "90's";
            break;
    }
    return ' de los ' . $decada . ' ';
}

$queryArticulos = "SELECT articulos.id,articulos.titulo, articulos.resumen
  FROM articulos  WHERE articulos.estatus = 1 order by 1 desc LIMIT 2";

$resultadoArticulos = mysqli_query($conn, $queryArticulos);

$queryArticulos2 = "SELECT articulos.id,articulos.titulo, articulos.resumen
  FROM articulos WHERE articulos.estatus = 1 order by 1 desc LIMIT 2,2";
$resultadoArticulos2 = mysqli_query($conn, $queryArticulos2);


$areas = "SELECT areas.id,areas.nombre FROM areas order by 1 desc LIMIT 4";
$resultadoAreas = mysqli_query($conn, $areas);
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
    <link rel="stylesheet" href="../../css/home.css">
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
        <hr style="background-color:white; margin-bottom: 2px;">
        <nav class="navbar navbar-expand-lg navbar-dark" style="padding-top:0px;">

            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="vistas/articulos.php">Artículos</a>
                    </li>

                    <?php
                    if (isset($_SESSION["aut"]) && isset($_SESSION["nombreUsuario"]) && isset($_SESSION["rol"]) && $_SESSION["rol"] == 1) {
                        echo "
                            <li class='nav-item'>
                                <a class='nav-link' href='../escritor/misArticulos.php'>Mis artículos</a>
                            </li>";
                    }
                    ?>
                </ul>
            </div>
        </nav>
    </header>
    <div id="contenedorPrincipal">
        <div class="text-center">
            <h1 aling="center"><b><i>B I E N V E N I D O</i></b></h1>
            <hr class="border-primary">

        </div>
        <br>
        <div id="intro">
            <h3><b>¿Qué es la física?</b></h3>
            <p id="descripcion">Es una ciencia fundamental que estudia y describe el
                comportamiento
                de los fenómenos naturales que
                ocurren en nuestro universo. Es una ciencia basada en observaciones experimentales y en mediciones. Su
                objetivo es desarrollar teorías físicas basadas en leyes fundamentales, que permitan describir el mayor
                número posible de fenómenos naturales con el menor número posible de leyes físicas. Estas leyes físicas se
                expresan en lenguaje matemático, por lo que para entender sin inconvenientes el tratamiento del formalismo
                teórico de los fenómenos físicos se debe tener una apropiada formación en matemáticas, en este curso basta
                un nivel básico de matemáticas.</p>
        </div>
        <br>
        <?php
        $contador = 1;
        $row_num = mysqli_num_rows($resultado);

        if ($row_num > 0) {

        ?>
            <div id="resultado" class="carousel slide pad-5" data-ride="carousel">
                <ul class="carousel-indicators">
                    <li data-target="#resultado" data-slide-to="0" class="active"></li>
                    <li data-target="#resultado" data-slide-to="1"></li>
                    <li data-target="#resultado" data-slide-to="2"></li>
                    <li data-target="#resultado" data-slide-to="3"></li>
                </ul>

                <div class="carousel-inner  border border-info rounded pt-3 pl-3 pr-3 pb-3">
                    <?php
                    $contador = 1;
                    while ($mostrar = mysqli_fetch_array($resultado)) {
                        if ($contador == 1) {
                    ?>
                            <div class="carousel-item active">
                                <?php echo '<a href="../escritor/articulo/individual.php?idArticulo=' . $mostrar["id"] . '" style="color: black;text-decoration: none;">'; ?>
                                <?php echo      '<div class="card mb-3">'; ?>
                                <?php echo          '<img class="card-img-top" src="' . 'data:image/jpeg;base64,' . $mostrar['imagen'] . '" alt="Card image cap" height="300px" width="100%">'; ?>
                                <?php echo          '<div class="card-body">'; ?>
                                <?php echo          '<h3 class="card-title">' . $mostrar["titulo"] . '</h3>'; ?>
                                <?php echo          '<p class="resumen card-text text-align">El presente artículo del siglo ' . $mostrar["siglo"] . ' está enfocado en el área de ' . $mostrar["nombre"] . '. Siendo un artículo realizado por el autor '; ?>
                                <?php echo              $mostrar["ESCRITOR"] . ', llevado a cabo en ' . $mostrar["lugar"] . ' en la decada' . decada($mostrar["decada"]) . 'con la obtención de los premios ' . $mostrar["premios"] . '.</p>'; ?>
                                <?php echo          '<p class="card-text"><small class="text-muted">Para saber más sobre esté artículo de clic.</small></p>'; ?>
                                <?php echo          '</div>'; ?>
                                <?php echo      '</div>'; ?>
                                <?php echo '</a>'; ?>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="carousel-item">
                                <?php echo '<a href="../escritor/articulo/individual.php?idArticulo=' . $mostrar["id"] . '" style="color: black;text-decoration: none;">'; ?>
                                <?php echo      '<div class="card mb-3">'; ?>
                                <?php echo          '<img class="card-img-top" src="' . 'data:image/jpeg;base64,' . $mostrar['imagen'] . '" alt="Card image cap" height="300px" width="100%">'; ?>
                                <?php echo          '<div class="card-body">'; ?>
                                <?php echo          '<h3 class="card-title">' . $mostrar["titulo"] . '</h3>'; ?>
                                <?php echo          '<p class="resumen card-text text-align">El presente artículo del siglo ' . $mostrar["siglo"] . ' está enfocado en el área de ' . $mostrar["nombre"] . '. Siendo un artículo realizado por el autor '; ?>
                                <?php echo              $mostrar["ESCRITOR"] . ', llevado a cabo en ' . $mostrar["lugar"] . ' en la decada' . decada($mostrar["decada"]) . 'con la obtención de los premios ' . $mostrar["premios"] . '.</p>'; ?>
                                <?php echo          '<p class="card-text"><small class="text-muted">Para saber más sobre esté artículo de clic.</small></p>'; ?>
                                <?php echo          '</div>'; ?>
                                <?php echo      '</div>'; ?>
                                <?php echo '</a>'; ?>
                            </div>

                    <?php
                        }
                        $contador++;
                    }
                    ?>

                </div>

                <a class="carousel-control-prev" href="#resultado" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="carousel-control-next" href="#resultado" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </a>
            </div>
        <?php
        } else {
        ?>
            <div id="demo2" class="carousel slide pad-5" data-ride="carousel">
                <ul class="carousel-indicators">
                    <li data-target="#demo2" data-slide-to="0" class="active"></li>
                    <li data-target="#demo2" data-slide-to="1"></li>
                    <li data-target="#demo2" data-slide-to="2"></li>
                </ul>

                <div class="carousel-inner  border border-info rounded pt-3 pl-3 pr-3 pb-3">
                    <div class="carousel-item active">
                        <img src="../../img/img.jpg" alt="Imagen 1" height="500" width="100%">
                    </div>
                    <div class="carousel-item">
                        <img src="../../img/img2.jpg" alt="Imagen 2" height="500" width="100%">
                    </div>
                    <div class="carousel-item">
                        <img src="../../img/img3.jpg" alt="Imagen 3" height="500" width="100%">
                    </div>
                </div>

                <a class="carousel-control-prev" href="#demo2" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="carousel-control-next" href="#demo2" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </a>
            </div>

        <?php
        }
        ?>


        <br><br>
        <div id="intro" style="padding-left: 3%; padding-right: 3%;">
            <div class="row ">
                <div class="col-md-6 border-right border-info text-center">
                    <h3><b>Décadas más populares</b></h3>
                    <a href="vistas/articulos.php?decada=9" class="btn btn-outline-primary btn-lg w-75 mb-3 mt-3" type="submit">Década de los 90's </a>
                    <br>
                    <a href="vistas/articulos.php?decada=8" class="btn btn-outline-primary btn-lg w-75 mb-3" type="submit">Década de los 80's </a>
                    <br>
                    <a href="vistas/articulos.php?decada=7" class="btn btn-outline-primary btn-lg w-75 mb-3" type="submit">Década de los 70's </a>
                    <br>
                    <a href="vistas/articulos.php?decada=6" class="btn btn-outline-primary btn-lg w-75 mb-3" type="submit">Década de los 60's </a>
                </div>
                <div class="col-md-6 text-center">
                    <h3><b>Artículos por Siglo</b></h3>
                    <a href="vistas/articulos.php?siglo=20" class="btn btn-outline-primary btn-lg w-75 mb-3 mt-3" type="submit">
                        Siglo XX
                    </a>
                    <br>
                    <a href="vistas/articulos.php?siglo=21" class="btn btn-outline-primary btn-lg w-75 mb-3 mt-3" type="submit">
                        Siglo XXI
                    </a>
                </div>
            </div>
        </div>
        <br>

        <?php
        $row_num_destacados = mysqli_num_rows($resultadoArticulos);

        if ($row_num_destacados > 0) {

        ?>
            <div id="intro" class="mb-5">
                <div class="text-center mt-3 mb-4">
                    <h2><b>Artículos Destacados</b></h2>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6 text-justify pad-5">
                        <?php
                        while ($mostrarDestacados = mysqli_fetch_array($resultadoArticulos)) {
                            echo '<a href="../escritor/articulo/individual.php?idArticulo=' . $mostrarDestacados["id"] . '" style="color: black;text-decoration: none;">';
                            echo '<h3><i class="fa fa-book mr-2"></i> ' . $mostrarDestacados['titulo'] . '</h3>
                                 <p>' . $mostrarDestacados['resumen'] . '</p>';
                            echo '</a>';
                            echo '<br>';
                        }
                        ?>
                    </div>
                    <div class="col-md-6 text-justify pad-5">
                        <?php
                        while ($mostrarDestacados2 = mysqli_fetch_array($resultadoArticulos2)) {
                            echo '<a href="../escritor/articulo/individual.php?idArticulo=' . $mostrarDestacados2["id"] . '" style="color: black;text-decoration: none;">';
                            echo '<h3><i class="fa fa-book mr-2"></i> ' . $mostrarDestacados2['titulo'] . '</h3>
                                 <p>' . $mostrarDestacados2['resumen'] . '</p>';
                            echo '</a>';
                            echo '<br>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js" integrity="sha512-RdSPYh1WA6BF0RhpisYJVYkOyTzK4HwofJ3Q7ivt/jkpW6Vc8AurL1R+4AUcvn9IwEKAPm/fk7qFZW3OuiUDeg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</body>

</html>