$(document).ready(function () {
    if (estatus) {
        bootbox.dialog({
            title: '<h3><i class="fa fa-exclamation-circle" style="color:red;"></i> Importante</h3>',
            message: "<h5>¡Eliminación no realizada! <br> La eliminación no se pudo llevar a cabo debido a que es un artículo publicado.</h5>",
            buttons: {
                cancel: {
                    label: "Aceptar",
                    className: 'btn-info',
                    callback: function () { }
                }
            }
        });
    }

    if (id) {
        bootbox.dialog({
            title: '<h3><i class="fa fa-exclamation-circle" style="color:red;"></i> Importante</h3>',
            message: "<h5>¡Eliminación realizada! <br> La eliminación se realizó de manera satisfactoria.</h5>",
            buttons: {
                cancel: {
                    label: "Aceptar",
                    className: 'btn-info',
                    callback: function () {
                        window.location = "Vibranium-Blog/modulos/escritor/misArticulos.php";
                    }
                }
            }
        });
    }
});