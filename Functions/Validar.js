function validarFormulario() {

            const validaEmail = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
            var validnum = /^[0-9]+$/;
            if ($("#nombre").val() == "") {
                return mensajeError("Debe ingresar un Nombre");
                $("#nombre").focus();
                return false;
            }
            if ($("#apellido").val() == "") {
                return mensajeError("Debe ingresar un Apellido");
                $("#apellido").focus();
                return false;
            }
            if ($("#dni").val() == "") {
                return mensajeError("Debe ingresar un dni");
                $("#dni").focus();
                return false;
            } else {
                if (!validnum.test($('#dni').val())) {
                    return mensajeError("El dni solo debe contener números (sin puntos)");
                }

            }
            if ($("#numTelf").val() == "") {
                return mensajeError("Debe ingresar un Número de telefono");
                $("#numTelf").focus();
                return false;
            } else {
                if (!validnum.test($('#numTelf').val())) {
                    return mensajeError("El numero de telefono solo debe contener números");
                }
            }
            if ($("#email").val() == "") {
                return mensajeError("Debe ingresar un Mail");
                $("#email").focus();
                return false;
            } else {
                if (!validaEmail.test($('#email').val())) {
                    return mensajeError("Debe ingresar un formato de Mail valido");
                }
            }
            if ($("#fecha").val() == 0) {
                return mensajeError("Debe ingresar una fecha");
                $("#numTelf").focus();
                return false;
            }
            return true;
        }