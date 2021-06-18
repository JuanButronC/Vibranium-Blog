$(document).ready(function() {
    $("#btnPublicar").on("click", function(e) {
        if (usuarioLoggeado === "") {
            var dialog = bootbox.dialog({
                title: '<h3><span class="fa fa-exclamation-triangle" style="color:#fca113"></span> Advertencia</h3>',
                message: "<h5>Por favor, inicie sesión o regístrese para poder comentar.</h5>",
                size: 'large',
                buttons: {
                    ok: {
                        label: "Aceptar",
                        className: 'btn-info',
                        callback: function() {}
                    },
                    register: {
                        label: "Registrarse o iniciar sesión",
                        className: 'btn-info',
                        callback: function(e) {
                            window.location = "../../../../../modulos/login/login.php";
                        }
                    }
                }
            });
            e.preventDefault();
        } else {
            if ($("#comentarioNuevo").val() == "") {
                //Método para cambiar texto de bootbox
                var dialog = bootbox.dialog({
                    title: '<h3><span class="fa fa-exclamation-triangle" style="color:#fca113"></span> Advertencia</h3>',
                    message: "<h5>Su comentario no puede estar vacío, intente nuevamente.</h5>",
                    size: 'large',
                    buttons: {
                        ok: {
                            label: "Aceptar",
                            className: 'btn-info',
                            callback: function() {}
                        }
                    }
                });
                e.preventDefault();
            } else {
                $("#formComentario").submit();
            }
        }
    });
});