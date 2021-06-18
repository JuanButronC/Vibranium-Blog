$(document).ready(function () {
    getArticulo();
    $("#btn-publicar").click(function () {
        publicar();
    });

});

function publicar() {

    bootBoxConfirm("Atención",
        "Estima escritor, una vez publicado su articulo no podrá editarlo ni eliminarlo <br> ¿Desea continuar?",
        function (resultado) {
            if (resultado) {
                publicarArticulo();                       
            }
        }
    );

}

function publicarArticulo(){
    $.ajax({
        type: "GET",
        url: "../funciones/publicarArticulo.php",
        dataType: "html",
        success: function (response) {
            bootBoxAlert("Atención", response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            bootBoxAlert("Error", errorThrown);

        }
    });
}

function getArticulo() {    
            $.ajax({
                type: "GET",
                url: "../funciones/getPreviewResumida.php",
                dataType: "html",
                success: function (response) {
                    $("#div-preview-resum").html(response);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    bootBoxAlert("Error", errorThrown);
        
                }
            });
            $.ajax({
                type: "GET",
                url: "../funciones/getPreviewCompleta.php",
                dataType: "html",
                success: function (response) {
                    $("#div-preview-content").html(response);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    bootBoxAlert("Error", errorThrown);
        
                }
            });
    
}


function bootBoxAlert(titulo, mensaje) {
    bootbox.dialog({
        title: titulo,
        message: '<div class="row" >' +
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

function bootBoxConfirm(titulo, mensaje, callbackFunc) {

    bootbox.dialog({
        title: titulo,
        message: '<div class="row ">' +
            '<div class=col-md-12>' +
            '<p>' + mensaje + '</p>' +
            '</div>' +
            '</div>',
        onEscape: function () {
            callbackFunc(false);
        },
        buttons: {
            danger: {
                label: "Cancelar",
                class: "bg-second",
                callback: function () {
                    callbackFunc(false);
                }
            },
            main: {
                label: "Aceptar",
                className: "bg-prim",
                callback: function () {
                    callbackFunc(true);
                }

            }
        }
    });


}