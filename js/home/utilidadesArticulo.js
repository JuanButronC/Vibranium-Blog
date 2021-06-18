var isFilter = false;

$(document).ready(function () {
    hide_search_heading();
    getAreas();
    setDataGet()
    getAutores();

    $("#form-busqueda").submit(function (e) {
        e.preventDefault();
        if (validate_busqueda()) {
            getCoincidencias();
        }

    });

    $("#div-main-articulos").on("click", "#nav-todas", function (e) {
        getArticulos();
    });

    $("#div-main-articulos").on("click", ".card-articulo-img ", function (e) {
        
        var id = $(this).parent().attr("id-articulo");
        var url = "/Pruebas//Vibranium-Blog/modulos/escritor/articulo/individual.php?idArticulo="+id;    
        $(location).attr('href',url);

    });

    $("#div-main-articulos").on("click", ".card-articulo-body", function (e) {
        
        var id = $(this).parent().attr("id-articulo");
        var url = "/Pruebas//Vibranium-Blog/modulos/escritor/articulo/individual.php?idArticulo="+id;    
        $(location).attr('href',url);

    });

    $("#div-main-articulos").on("mouseleave", " .card-articulo-img", function (e) {
        $(this).css("cursor", "auto");


    });

    $("#div-main-articulos").on("mouseenter", ".card-articulo-img", function (e) {
        $(this).css("cursor", "pointer");


    });



    $("#div-main-articulos").on("mouseleave", ".card-articulo-body", function (e) {
        $(this).css("cursor", "auto");


    });

    $("#div-main-articulos").on("mouseenter", ".card-articulo-body", function (e) {
        $(this).css("cursor", "pointer");


    });

    $(".form-check-input").click(function (e) {
        if (!isFilter) {
            hideAllArticles();
            isFilter = true;
        }


        var value = $(this).val();
        if ($(this).prop('checked')) {
            if (value >= 20) {
                showArticlesCentury(value);
            } else {
                showArticlesDecade(value);
            }

        } else {
            if (value >= 20) {
                hideArticlesCentury(value);
            } else {
                hideArticlesDecade(value);
            }

        }
        if (!articlesSelected()) {
            $("#div-filter-warning").html("<div class='row' style='margin-bottom: 20px;'>" +
                "<div class= 'col ' >" +
                "<div class= 'card bg-prim  text-center'>" +
                "<div class= 'card-body '>" +
                "<h3 class= 'card-title'> <span class='fa fa-exclamation-triangle'></span></h3>" +
                "<p>Sin coincidencias</p>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>");
        } else {
            $("#div-filter-warning").html("");

        }

        var selected = $("input:checkbox:checked");
        if (selected.length == 0) {
            showAllArticles();
            isFilter = false;
            $("#div-filter-warning").html("");

        }

    });

    $("#div-main-articulos").on("click", ".navArea", function (e) {
        var idLink = $(this).attr("id");
        var res = idLink.split("-");
        getArea(res[1], res[0]);

    });

    $("#div-main-articulos").on("click", ".btn-autores", function (e) {
        e.preventDefault();
        var idLink = $(this).attr("id");
        var res = idLink.split("-");
        getAutor(res[1], res[0]);

    });

    $("#div-main-articulos").on("click", ".a-decada", function (e) {
        e.preventDefault();
        var idLink = $(this).attr("id");
        var res = idLink.split("-");
        getDecada(res[1]);

    });

    $("#div-main-articulos").on("click", ".a-area", function (e) {
        e.preventDefault();
        var idLink = $(this).attr("id");
        var res = idLink.split("-");
        var area = $(this).html();
        getArea(res[1], area);

    });
    $("#div-main-articulos").on("click", ".a-cientificos", function (e) {
        e.preventDefault();
        var idLink = $(this).attr("id");
        var res = idLink.split("-");
        getCientificos(res[1]);

    });
    $("#div-main-articulos").on("click", ".a-siglo", function (e) {
        e.preventDefault();
        var idLink = $(this).attr("id");
        var res = idLink.split("-");
        getSiglo(res[1]);

    });
});

function getCientificos(cientificos) {
    $.ajax({
        type: "GET",
        url: "../funciones/getConcidenciasCientifico.php",
        data: { cientificos: cientificos },
        dataType: "html",
        success: function (response) {
            $("#div-articulos").html(response);
            var msg = "Aportaciones de <strong>" + cientificos + "</strong>";
            set_search_heading(msg);
            clearFilter();
            $("#div-filter-warning").html("");
            $("#inputBusqueda").val("");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            bootBoxAlert("Error", errorThrown);

        }
    });
}
function setDataGet() {
    var data_get = $("#div-data-get").attr("get-data-decada");
    data_get = data_get.trim();
    const FORMAT = /^([0-9]){1,2}$/;
    if (data_get !== "") {
        if (FORMAT.test(data_get)) {
            getDecada(data_get);
        }
    } else {
        data_get = $("#div-data-get").attr("get-data-siglo");
        data_get = data_get.trim();
        if (data_get !== "") {
            if (FORMAT.test(data_get)) {
                getSiglo(data_get);
            }
        }else{
            getArticulos();
        }
    }
}

function getDecada(decada) {
    $.ajax({
        type: "GET",
        url: "../funciones/getCoincidenciasDecada.php",
        data: { decada: decada },
        dataType: "html",
        success: function (response) {
            $("#div-articulos").html(response);
            var msg = "Descubrimientos de los <strong>" + get_decada_label(decada) + "</strong>";
            set_search_heading(msg);
            clearFilter();
            $("#div-filter-warning").html("");
            $("#inputBusqueda").val("");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            bootBoxAlert("Error", errorThrown);

        }
    });
}
function getSiglo(siglo) {
    $.ajax({
        type: "GET",
        url: "../funciones/getCoincidenciasSiglo.php",
        data: { siglo: siglo },
        dataType: "html",
        success: function (response) {
            $("#div-articulos").html(response);
            var msg = "Descubrimientos del siglo <strong>" + siglo + "</strong>";
            set_search_heading(msg);
            clearFilter();
            $("#div-filter-warning").html("");
            $("#inputBusqueda").val("");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            bootBoxAlert("Error", errorThrown);

        }
    });
}
function getAutor(id, autor) {
    $.ajax({
        type: "GET",
        url: "../funciones/getConcidenciasAutor.php",
        data: { idAutor: id },
        dataType: "html",
        success: function (response) {
            $("#div-articulos").html(response);
            var msg = "Articulos escritos por <strong>" + autor + "</strong>";
            set_search_heading(msg);
            clearFilter();
            $("#div-filter-warning").html("");
            $("#inputBusqueda").val("");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            bootBoxAlert("Error", errorThrown);

        }
    });
}
function getArea(id, area) {
    $.ajax({
        type: "GET",
        url: "../funciones/getConcidenciasArea.php",
        data: { idArea: id },
        dataType: "html",
        success: function (response) {
            $("#div-articulos").html(response);
            var msg = "Descubrimientos en el area de <strong>" + area + "</strong>";
            set_search_heading(msg);
            clearFilter();
            $("#div-filter-warning").html("");
            $("#inputBusqueda").val("");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            bootBoxAlert("Error", errorThrown);

        }
    });
}
function getFiltros(inputs) {
    $.ajax({
        type: "GET",
        url: "../funciones/getConcidenciasFiltros.php",
        data: inputs,
        dataType: "html",
        success: function (response) {
            $("#div-articulos").html(response);
            var msg = "Articulos filtrados por <strong> siglo y decada</strong>";
            set_search_heading(msg);
            clearFilter();
            $("#div-filter-warning").html("");
            $("#inputBusqueda").val("");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            bootBoxAlert("Error", errorThrown);

        }
    });
}

function getCoincidencias() {
    $.ajax({
        type: "GET",
        url: "../funciones/getConcidencias.php",
        data: $("#form-busqueda").serialize(),
        dataType: "html",
        success: function (response) {
            $("#div-articulos").html(response);
            var cadena = $("#inputBusqueda").val();
            var msg = "Articulos con el nombre <strong>" + cadena + "</strong>";
            set_search_heading(msg);
            clearFilter();
            $("#div-filter-warning").html("");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            bootBoxAlert("Error", errorThrown);

        }
    });
}

function getArticulos() {
    $.ajax({
        type: "GET",
        url: "../funciones/getArticulos.php",
        dataType: "html",
        success: function (response) {
            hide_search_heading();
            $("#div-articulos").html(response);
            hide_search_heading();
            clearFilter();
            $("#div-filter-warning").html("");
            $("#inputBusqueda").val("");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            bootBoxAlert("Error", errorThrown);

        }
    });
}
function getAreas() {
    $.ajax({
        type: "GET",
        url: "../funciones/getAreas.php",
        dataType: "html",
        success: function (response) {
            $("#areaNav").html(response);

        },
        error: function (jqXHR, textStatus, errorThrown) {
            bootBoxAlert("Error", errorThrown);

        }
    });
}

function getAutores() {
    $.ajax({
        type: "GET",
        url: "../funciones/getAutoresDestacados.php",
        dataType: "html",
        success: function (response) {
            $("#div-autores-destacados").html(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            bootBoxAlert("Error", errorThrown);

        }
    });
}

function validate_busqueda() {
    $("#helpbsq").html("");
    var estado = true;
    var cadena = $("#inputBusqueda").val();
    const FORMAT = /^([a-zA-Z0-9]+){1,30}$/;

    if (!FORMAT.test(cadena)) {
        estado = false;
        bootBoxAlert("Atención", "La busqueda no cumple con el formato.");
    }
    return estado;

}
function hideArticlesCentury(century) {
    $(".card-articulo").each(function () {
        var decada = $(this).attr("decada-articulo");
        var siglo = $(this).attr("siglo-articulo");
        if (siglo === century && !isDecadeSelected(decada)) {
            $(this).prop("hidden", true);
        }
    });
}


function hideArticlesDecade(decade) {
    $(".card-articulo").each(function () {
        var decada = $(this).attr("decada-articulo");
        var siglo = $(this).attr("siglo-articulo");
        if (decada === decade && !isCenturySelected(siglo)) {
            $(this).prop("hidden", true);
        }
    });
}
function isDecadeSelected(decade) {
    var result = false;
    $(".decade-check").each(function () {
        var c = $(this).prop('checked');
        var v = ($(this).val() === decade);
        if (c && v) {
            result = true;
        }
    });
    return result;
}
function isCenturySelected(century) {
    var result = false;
    $(".century-check").each(function () {
        var c = $(this).prop('checked');
        var v = ($(this).val() === century);
        if (c && v) {
            result = true;
        }
    });
    return result;
}
function clearFilter() {
    $(".form-check-input").each(function () {
        $(this).prop('checked', false);
    });
}
function showArticlesCentury(century) {
    $(".card-articulo").each(function () {
        var siglo = $(this).attr("siglo-articulo");
        if (siglo === century) {
            $(this).prop("hidden", false);
        }
    });
}

function articlesSelected() {
    var result = false;
    $(".card-articulo").each(function () {
        if (!$(this).prop("hidden")) {
            result = true;
        }

    });
    return result;
}


function showArticlesDecade(decade) {
    $(".card-articulo").each(function () {
        var decada = $(this).attr("decada-articulo");
        if (decada === decade) {
            $(this).prop("hidden", false);
        }
    });
}

function hideAllArticles() {
    $(".card-articulo").each(function () {
        $(this).prop("hidden", true);
    });
}

function showAllArticles() {
    $(".card-articulo").each(function () {
        $(this).prop("hidden", false);
    });
}

function set_search_heading(msg) {
    $("#card-busqueda").prop("hidden", false);
    $("#card-busqueda-titulo").html(msg);

}

function hide_search_heading() {
    $("#card-busqueda").prop("hidden", true);

}


function bootBoxAlert(titulo, mensaje) {
    bootbox.dialog({
        title: titulo,
        message: '<div class="row" style="text-align: justify">' +
            '<div class=col-md-12>' +
            '<p>' + mensaje + '</p>' +
            '</div>' +
            '</div>',
        buttons: {
            main: {
                label: '<i class="fa fa-check-circle"></i> Aceptar',
                className: "bg-prim"
            }
        }
    });
}

function get_decada_label(decada) {
    var decadaLabel = "";
    switch (decada) {
        case "1":
            decadaLabel = "10's";
            break;
        case "2":
            decadaLabel = "20's";
            break;
        case "3":
            decadaLabel = "30's";
            break;
        case "4":
            decadaLabel = "40's";
            break;
        case "5":
            decadaLabel = "50's";
            break;
        case "6":
            decadaLabel = "60's";
            break;
        case "7":
            decadaLabel = "70's";
            break;
        case "8":
            decadaLabel = "80's";
            break;
        case "9":
            decadaLabel = "90's";
            break;
        default:
            decadaLabel = "";
            break;
    }

    return decadaLabel;

}
