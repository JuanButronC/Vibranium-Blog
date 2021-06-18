$(document).ready(function() {
    $("#btnIni").on('click', function(e) {
        var pass = $("#pass").val();
        var email = $("#email").val();

        if(!pass || !email){
            e.preventDefault();
            //mensaje de campos vacios
            var dialog = bootbox.dialog({
                title: 'Atención',
                message: "<p>Ambos campos deben estar llenos para iniciar.</p>",
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
            $("#formLogin").submit();
        }
    });
})