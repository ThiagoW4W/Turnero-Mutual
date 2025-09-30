<?php



include('../navegacion2.php');
include("../conexion.php");
include("../Functions/turnos-disponibles.php");
$fechas_disponibles = traerTurnos();
$conexion = new BaseDatos();


if ($conexion->conectar()) {
    $conn = $conexion->getConexion();
    ?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="../Functions/Mensajes.js"></script>
        <script src="../Functions/Validar.js"></script>

        <link rel="stylesheet" href="../Style/turnero-especial.css?v=<?= time() ?>">
        <link rel="stylesheet" href="../Style/nav.css?v=<?= time() ?>">
        <title>Turnos Especiales</title>
    </head>

    <body>
        </div>
        <div id="separador">
            <a href="/Admin/admin.php"><img id="botonVolver" src="https://mppneuquen.com.ar/wp-content/uploads/2025/07/back-1.webp" alt=""></a>
            <h4 class="titulo">CARGAR TURNO</h4>
        </div>
        <div id="cajaTurnero">
            <form method="POST" id="formTurnos">
                <div class="izquierda">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" id="nombre" placeholder="Ej: Juan" autocomplete="off" />

                    <label for="apellido">Apellido:</label>
                    <input type="text" name="apellido" id="apellido" placeholder="Ej: Pérez" autocomplete="off" />

                    <label for="dni">DNI:</label>
                                <input type="number" id="dni" name="DNI" 
                                placeholder="Ej: 30123456"autocomplete="no" maxlength="8"
                                pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==8) return false;" />
                </div>

                <div class="derecha">
                    <label for="numTelf">Teléfono:</label>
                    <input type="number" name="numTelf" id="numTelf" placeholder="Ej: 2994123456" autocomplete="off" maxlength="12" 
                    pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==8) return false;" />

                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" placeholder="Ej: mail@ejemplo.com" autocomplete="off" />
                    <!-- El select de las fechas, recorre el array fechas disponible y lo va agg. a los options -->
                    <label for="fecha">Fecha:</label>
                    <select name="fecha" id="fecha" required>
                        <option value="0">--Seleccione una fecha--</option>
                        <?php foreach ($fechas_disponibles as $fecha): ?>
                            <option value="<?= $fecha ?>"><?= $fecha ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
        </div>
        <div class="botonEnviar">
            <button type="submit" id="enviarTurno">Enviar</button>
        </div>
        </form>
<?php } ?>
    <script type="text/javascript">
        $('#enviarTurno').click(function(evento) {

            $('#enviarTurno').prop('disabled', true); //Descativa el boton

            if (validarFormulario()) {
                var datos = new FormData($('#formTurnos')[0]); //aca se guardan los datos del form
                Swal.fire({
                    title: "¿Desea solicitar el turno?",
                    width: '500px',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#148F77',
                    confirmButtonText: 'Aceptar',
                    cancelButtonColor: 'red',
                    allowOutsideClick: false,
                    showLoaderOnConfirm: true,

                }).then((result) => {

                    if (result.isConfirmed) { //result
                        //el ajax se encarga de tomar y enviar los datos del formulario
                        Swal.fire({
                            title: 'Cargando turno...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        $.ajax({
                            url: '../cargar-turno.php', //a este archivo se le pasan los datos
                            type: 'POST',
                            data: datos,
                            processData: false,
                            contentType: false,
                            success: function(data) {
                                console.log("Respuesta cruda:", data)
                                var jsonData = JSON.parse(data);

                                if (jsonData.salida == 0) {
                                    return mensajeExito(jsonData.mensaje);
                                } else {
                                    return mensajeError(jsonData.mensaje);

                                }

                                $('#enviarTurno').prop('disabled', false);

                            },

                        });
                    }
                });
            }
        });

        
    </script>
</body>

</html>