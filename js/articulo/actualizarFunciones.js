$(document).ready(function() {
    //generación de textarea editor
    var editor = new Jodit('#editor');
    //Guardar cambios
    $("#save").on('click', function(e) {
        var arregloDatos = $("#formActualizar").serializeArray();
        var campoVacío;
        $.each(arregloDatos, function(index, value) {
            console.log(value);
            if (value.value === "") {
                campoVacío = true;
            }
        });

        if (campoVacío) {
            //Método para cambiar texto de bootbox
            var dialog = bootbox.dialog({
                title: 'Advertencia',
                message: "<p>Debe llenar todos los campos para poder actualizar.</p>",
                size: 'large',
                buttons: {
                    ok: {
                        label: "Aceptar",
                        className: 'btn-info',
                        callback: function() {}
                    }
                }
            });
        } else {
            $("#contenido").val(editor.value);
            //Método para cambiar texto de bootbox
            var dialog = bootbox.dialog({
                title: 'Advertencia',
                message: "<p>¿Desea guardar los cambios realizados?</p>",
                size: 'large',
                buttons: {
                    cancel: {
                        label: "Cancelar",
                        className: 'btn-danger',
                        callback: function() {
                            //permanecer en la vista actual (actualizar)
                        }
                    },
                    ok: {
                        label: "Aceptar",
                        className: 'btn-info',
                        callback: function() {
                            //guardar info en bd
                            //redireccionar a listado de artículos
                            $("#formActualizar").submit();
                        }
                    }
                }
            });
        }
    });
    //Descartar cambios
    $("#discard").on('click', function(e) {
        //Método para cambiar texto de bootbox
        var dialog = bootbox.dialog({
            title: 'Advertencia',
            message: "<p>¿Desea descartar los cambios realizados?</p>",
            size: 'large',
            buttons: {
                cancel: {
                    label: "Cancelar",
                    className: 'btn-danger',
                    callback: function() {
                        //no redireccionar
                    }
                },
                ok: {
                    label: "Aceptar",
                    className: 'btn-info',
                    callback: function() {
                        //redireccionar a listado de artículos
                    }
                }
            }
        });
    });
    //Cambiar imagen de cover
    $("#cargaImagen").on('change', function() {
        var input = this;
        var url = $("#cargaImagen").val();
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imgCover').attr('src', e.target.result);
            }
            var img = new Object();
            img = input.files[0];
            reader.readAsDataURL(img);
        } else {
            $('#imgCover').attr('src', '/assets/no_preview.png');
        }
    });
});
//Switches para recuperar datos en inputs
switch (opcionDecada) {
    case 0:
        $("#selectDecada").val("-1");
        break;
    case 1:
        $("#selectDecada").val("1");
        break;
    case 2:
        $("#selectDecada").val("2");
        break;
    case 3:
        $("#selectDecada").val("3");
        break;
    case 4:
        $("#selectDecada").val("4");
        break;
    case 5:
        $("#selectDecada").val("5");
        break;
    case 6:
        $("#selectDecada").val("6");
        break;
    case 7:
        $("#selectDecada").val("7");
        break;
    case 8:
        $("#selectDecada").val("8");
        break;
    case 9:
        $("#selectDecada").val("9");
        break;
    default:
        break;
}
switch (opcionSiglo) {
    case 0:
        $("#selectSiglo").val("-1");
        break;
    case 20:
        $("#selectSiglo").val("20");
        break;
    case 21:
        $("#selectSiglo").val("21");
        break;
    default:
        break;
}