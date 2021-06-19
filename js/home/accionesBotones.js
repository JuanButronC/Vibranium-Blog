$(document).ready(function() {

    //opciones navbar generales (anónimo)
    $("#btnInicio").on("click", function(e) {
        redirigirAjax('modulos/home/home.php', "get");
    });
    $("#btnArticulos").on("click", function(e) {
        redirigirAjax('modulos/home/articulos.php', "get");
    });
    $("#btnLogin").on("click", function(e) {
        redirigirAjax('modulos/login/login.php', "get");
    });
    $("#btnSignUp").on("click", function(e) {
        redirigirAjax('modulos/login/registro.php', "get");
    });

    //opciones navbar (loggeado)
    $("#btnLogOut").on("click", function(e) {
        redirigirAjax('modulos/login/logout.php', "get");
    });
    $("#btnDatosPersonales").on("click", function(e) {
        redirigirAjax('modulos/login/datosPersonales.php', "get");
    });
    $("#btnMisArticulos").on("click", function(e) {
        redirigirAjax('modulos/escritor/misArticulos.php', "get");
    });
});