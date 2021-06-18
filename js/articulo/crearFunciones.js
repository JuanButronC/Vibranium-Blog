$(document).ready(function() {
    //generación de textarea editor
    var editor = new Jodit('#editor', {
        height: 1000
    });
    
    $("#save").on('click', function(e) {
        //obtención de datos y variables de control
        var campos = $("#formCrear").serializeArray();
        var vacio = false;

        //Verificación de campos vacios
        $.each(campos, function(indice, elemento) {
            if (elemento.value === "" || elemento.value === "-1") {
                vacio = true;
            }
        });

        console.log(campos[4]);//decada
        console.log(campos[5]);//siglo
        console.log(campos[7]);//area
        console.log(vacio); // campos vacios?


        if(vacio){
            e.preventDefault();
            //Decir que hay campos vacios
            var dialog = bootbox.dialog({
                title: 'Atención',
                message: "<p>Debe llenar todos los campos para poder crear un artículo.</p>",
                size: 'large',
                buttons: {
                    ok: {
                        label: "Aceptar",
                        className: 'btn-info',
                        callback: function() {}
                    }
                }
            });
        }else{
            //Guardar en base de datos el artículo creado.
            $("#contenido").val(editor.value);
            $("#formCrear").submit();
        }
    });
});
