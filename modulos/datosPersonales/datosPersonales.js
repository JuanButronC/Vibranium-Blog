$(document).ready(function () {
   $("#btnCancelar").hide();
   $("#btnActualizar").hide();

   peticionMostrarDatos();
   
   $("#btnEditar").on("click", function () {
      $("#btnEditar").hide();
      $("#btnCancelar").show();
      $("#btnActualizar").show();

      $("#nombre").prop("readonly", false);
      $("#apPat").prop("readonly", false);
      $("#apMat").prop("readonly", false);
      $("#fecNac").prop("disabled", false);
      $("#fecNac").prop("readonly", true);
      $("#sexo").prop("disabled", false);
   });

   $("#btnCancelar").on("click", function () {
      $("#btnCancelar").hide();
      $("#btnActualizar").hide();
      $("#btnEditar").show();

      $("#nombre").prop("readonly", true);
      $("#apPat").prop("readonly", true);
      $("#apMat").prop("readonly", true);
      $("#fecNac").prop("readonly", false);
      $("#fecNac").prop("disabled", true);
      $("#sexo").prop("disabled", true);
   });

   $("#fecNac").datepicker({
      format: "dd/mm/yyyy"
   });

   $("#nombre, #apPat, #apMat").on("input", function () {
      let posCursor = this.selectionStart;
      let texto = $(this).val();
      $(this).val(texto.toUpperCase());
      this.selectionStart = posCursor;
      this.selectionEnd = posCursor;
   });

   $("#nombre, #apPat, #apMat").on("keypress", function (event) {
      let caracter = String.fromCharCode(event.which).toUpperCase();

      if(! /[A-ZÁÉÍÓÚÑ\s]/.test(caracter)) {
         event.preventDefault();
      }
   });

   $("#formActualizar").validate(validarDatos());
});

function peticionMostrarDatos() {
   $.ajax({
      type: "POST",
      url: "mostrarDatosPersonales.php",
      data: {
         idUsuario: idUsuario
      },
      success: function (response) {
         response = $.parseJSON(response);
         
         if (response.codError == 0) {
            $("#nombre").val(response.datos.nombre);
            $("#apPat").val(response.datos.ape_pat);
            $("#apMat").val(response.datos.ape_mat);
            $("#fecNac").val(response.datos.fecha_nac);
            $("#sexo").val(response.datos.sexo);
         }
         else {
            bootbox.alert({
               title: "Error",
               message: response.msjError
            });
         }
      }
   });
}

function validarDatos() {
   return {
      rules: reglasValidacion(),

      messages: msjsErrorValidacion(),

      errorPlacement: function (error, element) {
         $(element).parent().parent().append(error);
      },

      submitHandler: function (form) {
         let datosEnURL = $(form).serialize() + "&nombreSexo=" + $("#sexo option:selected").html().toUpperCase();
         peticionActualizarDatos(datosEnURL);
      }
   };
}

function reglasValidacion() {
   return {
      nombre: {
         required: true,
         nombreValido: true
      },

      apPat: {
         required: true,
         nombreValido: true
      },

      apMat: {
         required: true,
         nombreValido: true
      },

      fecNac: {
         required: true,
         fechaValida: true,
      },

      sexo: {
         required: true,
         sexoValido: true
      }
   };
}

function msjsErrorValidacion() {
   return {
      nombre: {
         required: "<span style='color: red;'>El nombre no puede estar vacío</span>",
         nombreValido: "<span style='color: red;'>El nombre no es válido</span>"
      },

      apPat: {
         required: "<span style='color: red;'>El apellido paterno no puede estar vacío</span>",
         nombreValido: "<span style='color: red;'>El apellido paterno no es válido</span>"
      },

      apMat: {
         required: "<span style='color: red;'>El apellido materno no puede estar vacío</span>",
         nombreValido: "<span style='color: red;'>El apellido materno no es válido</span>"
      },

      fecNac: {
         required: "<span style='color: red;'>La fecha de nacimiento no puede estar vacía</span>",
         fechaValida: "<span style='color: red;'>La fecha de nacimiento no es válida</span>",
      },

      sexo: {
         required: "<span style='color: red;'>No ha seleccionado ningún sexo</span>",
         sexoValido: "<span style='color: red;'>El sexo seleccionado no es válido</span>"
      }
   };
}

function peticionActualizarDatos(datosEnURL) {
   $.ajax({
      type: "POST",
      url: "actualizarDatosPersonales.php",
      data: datosEnURL,
      success: function (response) {
         response = $.parseJSON(response);
         console.log(response);
         console.log(response.msjError);
         if (response.codError == 0) {
            $("#nombre").prop("readonly", true);
            $("#apPat").prop("readonly", true);
            $("#apMat").prop("readonly", true);
            $("#fecNac").prop("readonly", false);
            $("#fecNac").prop("disabled", true);
            $("#sexo").prop("disabled", true);

            $("#btnCancelar").hide();
            $("#btnActualizar").hide();
            $("#btnEditar").show();

            bootbox.alert({
               title: "Éxito",
               message: "Actualización exitosa"
            });
         }
         else {
            bootbox.alert({
               title: "Error",
               message: response.msjError
            });
         }
      },

      error: function(XMLHttpRequest, textStatus, errorThrown) {
         console.log(XMLHttpRequest);
         console.log(textStatus);
         console.log(errorThrown);
      }
   });
}

$.validator.addMethod("nombreValido", function (value, element) {
   return /^[A-ZÁEÍÓÚÑ]{2,}(\s[A-ZÁEÍÓÚÑ]{2,})?$/.test(value.toUpperCase());
});

$.validator.addMethod("fechaValida", function (value, element) {
   return moment(value,  "DD/MM/YYYY", true).isValid();
});

$.validator.addMethod("sexoValido", function (value, element) {
   let text = $("#" + element.id + " option:selected").html().toUpperCase();

   return (value === "0" || value === "1") && (text === "FEMENINO" || text === "MASCULINO");
});