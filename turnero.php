<?php
session_start();
include("conexion.php");

include("Functions/turnos-disponibles.php");
$fechas_disponibles = traerTurnos();

$conexion = new BaseDatos();

date_default_timezone_set("America/Argentina/Buenos_Aires");
$fechaActual = date('Y-m-d');
// Verficar sesion
$usuario = $_SESSION['usuario'];
// Traemos datos del user conectado
//$nombre = $usuario['nombre'];
$id_usuario = $usuario['id'];

if ($conexion->conectar()) {

    
    $conn = $conexion->getConexion();
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id_usuario); 
    $stmt->execute();

    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc(); 
    
    ?>
    <!-- Esctructura html -->
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
        <title>Turnos</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="Functions/Mensajes.js"></script> <!-- Mensajes Sweatalert -->
        <script src="Functions/Validar.js"></script> <!-- Validacion de inputs -->
        <link rel="stylesheet" href="Style/turnero.css?v=<?= time() ?>">
        
    </head>

    <body>
        <div id="textoFondo">
            <span class="texto-blur">VERANO 2025</span>
            <span class="texto-borde">VERANO 2025</span>
        </div>
        <a href="menu.php"><img id="botonVolver" src="https://mppneuquen.com.ar/wp-content/uploads/2025/07/back-1.webp" alt=""></a>
        <?php if ($usuario['beneficioTurno'] > 0){ 
            

            require("mensajeTurno.php");
            ?>
            <!-- Esto es el SVG del diseño azul de la pag SI TOCAS UN NUMERO CAMBIA LA FORMA (no lo hagan porfa) -->
            <div class="blur-overlay">
                <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,
                            82.39-16.72,168.19-17.73,250.45-.39C823.78,31,
                            906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,
                            214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" />
                </svg>
            </div>
        <?php } else { ?>
            <!-- Si no saco turno: -->


            <!-- Esto es el SVG del diseño azul de la pag SI TOCAS UN NUMERO CAMBIA LA FORMA (no lo hagan porfa) -->
            <div class="blur-overlay">
                <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,
                            82.39-16.72,168.19-17.73,250.45-.39C823.78,31,
                            906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,
                            214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" />
                </svg>
            </div>
            <!-- Formulario -->
            <div id="cajaPrincipal">
                <div id="cajaTurnero">
                    <p id="tituloForm">Solicite su Turno</p>
                    <form method="POST" id="formTurnos">
                        <div class="fila">
                            <div class="campo">
                                <label for="nombre">Nombre:</label>
                                <input type="text" name="nombre" id="nombre" 
                                placeholder="Ej: Juan" autocomplete="off" maxlength="20"/>
                            </div>
                            <div class="campo">
                                <label for="apellido">Apellido:</label>
                                <input type="text" name="apellido" id="apellido" 
                                placeholder="Ej: Pérez" autocomplete="no" maxlength="20"/>
                            </div>
                        </div>
                        <div class="fila">
                            <div class="campo">
                                <label for="dni">DNI:</label>
                                <input type="number" id="dni" name="DNI" 
                                placeholder="Ej: 30123456"autocomplete="no" maxlength="8"
                                pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==8) return false;" />
                            </div>
                            <div class="campo">
                                <label for="numTelf">Teléfono:</label>
                                <input type="number" name="numTelf" id="numTelf" 
                                placeholder="Ej: 2994123456"autocomplete="no" maxlength="12" 
                                pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==12) return false;" />
                            </div>
                        </div>
                        <div class="campo">
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" 
                            placeholder="Ej: mail@ejemplo.com "autocomplete="no" maxlength="40" />
                        </div>
                        <!-- El select de las fechas, recorre el array fechas disponible y lo va agg. a los options -->
                        <div id="campo">
                            <label for="fecha">Fecha:</label><br>
                            <select name="fecha" id="fecha" required>
                                <option value="0">--Seleccione una fecha--</option>
                                <?php foreach ($fechas_disponibles as $fecha): ?>
                                    <option value="<?= $fecha ?>"><?= $fecha ?></option>
                                <?php endforeach; ?>
                        </div>
                        </select><br><br>
                        <div id="cajaBoton">
                            <button type="submit" id="enviarTurno">Enviar</button>
                        </div>
                    </form>
                </div>
            </div>

        <?php } ?>
    <?php } ?>

    <script type="text/javascript">
        $('#enviarTurno').click(function(evento) {
            $('#enviarTurno').prop('disabled', true); //Descativa el boton
            evento.preventDefault();
            if (validarFormulario()) {
                var datos = new FormData($('#formTurnos')[0]); //aca se guardan los datos del form
                Swal.fire({
                    title: "¿Desea solicitar el turno?",
                    width: '500px',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#148F77',
                    cancelButtonColor: 'red',
                    allowOutsideClick: false,
                }).then((result) => {
                    if (result.isConfirmed) { 
                        Swal.fire({ //Loading
                            title: 'Cargando turno...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        $.ajax({ //Con ajax enviamos los datos del form
                            url: 'cargar-turno.php', //a este archivo se le pasan los datos
                            type: 'POST',
                            data: datos,
                            processData: false,
                            contentType: false,
                            success: function(data) { //Dependiento de la respuesta mostramos mensaje
                                console.log("Respuesta debug:", data) 
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