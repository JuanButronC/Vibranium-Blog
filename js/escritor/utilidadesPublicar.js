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
                var data_get = $("#div-data-get").attr("get-data-id-articulo");
                data_get = data_get.trim();
                const FORMAT = /^([0-9]){1,2}$/;
                if (data_get !== "") {
                    if (FORMAT.test(data_get)) {
                        $.ajax({
                            type: "GET",
                            url: "modulos/escritor/funciones/publicarArticulo.php",
                            dataType: "html",
                            data:{idArticulo:data_get},
                            success: function (response) {
                                bootBoxAlert("Atención", response);
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                bootBoxAlert("Error", errorThrown);

                            }
                        });
                    }
                }
            }
        }
    );

}



function getArticulo() {
    var data_get = $("#div-data-get").attr("get-data-id-articulo");
    data_get = data_get.trim();
    const FORMAT = /^([0-9]){1,2}$/;
    if (data_get !== "") {
        if (FORMAT.test(data_get)) {
            $.ajax({
                type: "GET",
                url: "modulos/escritor/funciones/getPreviewResumida.php",
                dataType: "html",
                data:{idArticulo:data_get},
                success: function (response) {
                    $("#div-preview-resum").html(response);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    bootBoxAlert("Error", errorThrown);
        
                }
            });
            $.ajax({
                type: "GET",
                url: "modulos/escritor/funciones/getPreviewCompleta.php",
                dataType: "html",
                data:{idArticulo:data_get},
                success: function (response) {
                    $("#div-preview-content").html(response);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    bootBoxAlert("Error", errorThrown);
        
                }
            });
        }
    }
    
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