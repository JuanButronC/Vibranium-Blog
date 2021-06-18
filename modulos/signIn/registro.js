$(document).ready(function () {
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

   $("#formRegistro").validate(validaDatos());
});

function validaDatos () {
   return {
      rules: reglasValidacion(),

      messages: msjsErrorValidacion(),

      errorPlacement: function (error, element) {
         $(element).parent().parent().append(error);
      },

      submitHandler: function (form) {
         let datosEnURL = $(form).serialize() + "&nombreSexo=" + $("#sexo option:selected").html().toUpperCase();
         peticionRegistro(datosEnURL);
      }
   };
}

function reglasValidacion () {
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

      correo: {
         required: true,
         correoValido: true
      },

      contrasenia: {
         required: true,
         contraseniaValida: true
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

function msjsErrorValidacion () {
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

      correo: {
         required: "<span style='color: red;'>El correo no puede estar vacío</span>",
         correoValido: "<span style='color: red;'>El correo no es válido</span>"
      },

      contrasenia: {
         required: "<span style='color: red;'>La contraseña no puede estar vacía</span>",
         contraseniaValida: "<span style='color: red;'>La contraseña debe de tener mínimo 6 caracteres, al menos 1 letra minúscula, 1 letra mayúscula y 1 número</span>"
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

function peticionRegistro (datosEnURL) {
   $.ajax({
      type: "POST",
      url: "modulos/general/registrar.php",
      data: datosEnURL,
      success: function (response) {
         response = $.parseJSON(response);
         
         if (response.codError == 0) {
            $("#nombre").val("");
            $("#apPat").val("");
            $("#apMat").val("");
            $("#correo").val("");
            $("#contrasenia").val("");
            $("#fecNac").val("");
            $("#sexo").val("-1");

            bootbox.alert({
               title: "Éxito",
               message: "Registro exitoso"
            });
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

$.validator.addMethod("nombreValido", function (value, element) {
   return /^[A-ZÁEÍÓÚÑ]{2,}(\s[A-ZÁEÍÓÚÑ]{2,})?$/.test(value.toUpperCase());
});

$.validator.addMethod("correoValido", function (value, element) {
   return /^[a-z0-9]+([\-_\.][a-z0-9]+)*@[a-z0-9]+[\.\-][a-z0-9]+([\.\-][a-z]+)*$/.test(value);
});

$.validator.addMethod("contraseniaValida", function (value, element) {
   return /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])[a-zA-Z0-9\.]{6,}$/.test(value);
});

$.validator.addMethod("fechaValida", function (value, element) {
   return moment(value, "DD/MM/YYYY", true).isValid();
});

$.validator.addMethod("sexoValido", function (value, element) {
   let text = $("#" + element.id + " option:selected").html().toUpperCase();

   return (value === "0" || value === "1") && (text === "FEMENINO" || text === "MASCULINO");
});