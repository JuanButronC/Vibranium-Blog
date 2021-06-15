function redirigirAjax(ruta, metodo) {
    $.ajax({
        type: metodo,
        url: ruta,
        dataType: "html",
        success: function(response) {
            $("#containerPrincipal").html(response);
        }
    });
}