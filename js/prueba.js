$(document).ready(function () {
    main();
});

function main(){
$.ajax({
    type: "GET",
    url: "modulos/escritor/vistas/publicar.php",
    data:{idArticulo:1},
    dataType: "html",
    success: function (response) {
            $("#div-prueba").html(response);  
    },
    error:function(jqXHR,  textStatus, errorThrown){
        bootBoxAlert("Error", errorThrown);

    }
});
}