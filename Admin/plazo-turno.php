<?php
session_start();
include("../conexion.php");
include('../navegacion2.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../Style/plazo-turno.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../Style/nav.css?v=<?= time() ?>">
    <title>Document</title>
</head>

<body>
    <div id="separador">
            <a href="/Admin/admin.php"><img id="botonVolver" src="https://mppneuquen.com.ar/wp-content/uploads/2025/07/back-1.webp" alt=""></a>
        <h4 class="titulo">DEFINIR PLAZO TURNO</h4>
    </div>
    <div id="cajaDefinir">
        <form method="POST" id="formConfigTurnos">
            <h3>Fecha:</h3>
            <label for="fechaInicio">Inicio:</label>
            <input type="date" name="fechaInicio" id="fechaInicio">

            <label for="fechaFin">Fin:</label>
            <input type="date" name="fechaFin" id="fechaFin">
            <h3>Hora:</h3>
            <label for="horaInicio">Inicio:</label>
            <input type="time" name="horaInicio" id="horaInicio">

            <label for="horaFin">Fin:</label>
            <input type="time" name="horaFin" id="horaFin">
    </div>
    <div class="botonEnviar">
        <button id="enviarConfig" type="submit">Definir</button>
    </div>
    </form>

    <script>
        $(function() {
            $('#formConfigTurnos').on('submit', function(evento) {
                evento.preventDefault();

                if (validarFormulario()) {
                    const datos = new FormData(this);
                    const $btn = $('#enviarConfig');
                    $btn.prop('disabled', true);

                    Swal.fire({
                        title: "¿Desea guardar la configuración de fechas?",
                        width: '500px',
                        showCancelButton: true,
                        confirmButtonColor: '#148F77',
                        confirmButtonText: 'Aceptar',
                        cancelButtonColor: 'red',
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: 'config-fecha.php',
                                type: 'POST',
                                data: datos,
                                processData: false,
                                contentType: false,
                                success: function(data) {
                                    var jsonData = JSON.parse(data);

                                    if (jsonData.salida == 0) {
                                        return mensajeExito(jsonData.mensaje);
                                    } else {
                                        return mensajeError(jsonData.mensaje);
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error('Error en la solicitud AJAX:', error);
                                    mensajeError("Error en la solicitud: " + error);
                                    $btn.prop('disabled', false);
                                }
                            });
                        } else {
                            $btn.prop('disabled', false);
                        }
                    });
                }
            });
        });


        function validarFormulario() {
            if ($("#fechaInicio").val() == "") {
                return mensajeError("Debe ingresar un fecha de inicio");
                $("#nombre").focus();
                return false;
            }
            if ($("#fechaFin").val() == "") {
                return mensajeError("Debe ingresar un fecha de fin");
                $("#nombre").focus();
                return false;
            }
            if ($("#horaInicio").val() == "") {
                return mensajeError("Debe ingresar un hora de inicio");
                $("#nombre").focus();
                return false;
            }
            if ($("#horaInicio").val() == "") {
                return mensajeError("Debe ingresar un hora de inicio");
                $("#nombre").focus();
                return false;
            }
            return true;
        }

        function mensajeError($mensaje) {
            swal.fire({
                title: "ERROR",
                text: $mensaje,
                icon: 'error',
                width: '550px',
                allowOutsideClick: false,
                confirmButtonColor: '#0F4C75',
            });
        }

        function mensajeExito($mensaje) {
            Swal.fire({
                icon: 'success',
                width: '550px',
                title: $mensaje,
                allowOutsideClick: false,
            })
        }
    </script>





</body>

</html>