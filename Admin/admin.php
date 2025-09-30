<?php



include('../navegacion2.php');
include("../conexion.php");
include("../Functions/turnos-disponibles.php");
$fechas_disponibles = traerTurnos();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Admin</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <link rel="stylesheet" href="../Style/admin.css?v=<?= time() ?>">
    <link rel="stylesheet" href="../Style/nav.css?v=<?= time() ?>">

</head>

<body>

<!-- Menu con las opciones: Definir plazos, Agregar turnos y Descargar excel -->

    <div id="encabezado">
        <div class="bloque izquierda">
            <a id="botones-nav" class="plazoTurno" href="plazo-turno.php">
                <img src="https://mppneuquen.com.ar/wp-content/uploads/2025/07/calendario-icon.webp" alt="Agregar Nuevo" width="40">
                Definir Plazos
            </a>
        </div>

        <div class="bloque centro">
            <a id="botones-nav" class="agregarPersona" href="turnero-especiales.php">
                <img src="https://mppneuquen.com.ar/wp-content/uploads/2025/07/agregar-icon.webp" alt="Agregar Nuevo" width="40">
                Agregar Turno
            </a>
        </div>

        <div class="bloque derecha">
            <a id="botones-nav" class="descargarExcel" href="excel-turnos.php" target="_blank">
                <img src="https://mppneuquen.com.ar/wp-content/uploads/2025/07/excel-Icon-1.webp" width="40" alt="Descargar Excel">
                Descargar Excel
            </a>
        </div>
    </div>

<!-- Seccion titulo -->

    <div id="separador">
        <a href="../menu.php"><img title="Volver" id="botonVolver" src="https://mppneuquen.com.ar/wp-content/uploads/2025/07/back-1.webp" alt=""></a>
        <h4 class="titulo">LISTA DE TURNOS</h4>
    </div>

<!-- Buscador -->

    <div id="cajaBuscador">
        <input type="text" name="busqueda" id="busqueda" class="buscador" placeholder="Ingresar apellido, nombre o DNI" maxlength="30" autocomplete="off">
    </div>

<!-- Ordenar por y filtro -->

    <form method="POST" id="ordenar">
        <div class="campo-select">
            <label for="fecha">Filtrar por fecha</label>
            <select name="fecha" id="fecha">

<!-- Le llegan las fechas disponibles calculadas en buscar-turno.php -->

                <option value="0">Todas las fechas</option>
                <?php foreach ($fechas_disponibles as $fecha): ?>
                    <option value="<?= $fecha ?>"><?= $fecha ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="campo-select">
            <label for="filtro">Ordenar por</label>
            <select name="filtro" id="filtro">
                <option value="1">Fecha Ascendente</option>
                <option value="2">Fecha Descendente</option>
            </select>
        </div>
    </form>

    <section id="tabla_resultado"></section>
<!-- Acá se mostrará la tabla con los turnos y datos -->

    <script>
        $(document).ready(function() {
            function obtener_turnos(termino = '', filtro = '', fecha = '') {
                $.ajax({ //Enviamos los datos del buscador, filtro y fecha
                        url: 'buscar-turno.php',
                        type: 'POST',
                        dataType: 'html',
                        data: {
                            buscar: termino,
                            filtro: filtro,
                            fecha: fecha
                        },
                    })
                    .done(function(resultado) {
                        $("#tabla_resultado").html(resultado); // Cuando tenemos respuesta la mostramos en el ID
                    });
            }

            //Si cambia el option de filtro
            $('select[name="filtro"]').on('change', function() {
                const filtroSeleccionado = $(this).val();
                const terminoBusqueda = $('#busqueda').val();
                const fechaSeleccionada = $('#fecha').val(); //Actualizamos todos los datos
                obtener_turnos(terminoBusqueda, filtroSeleccionado, fechaSeleccionada); // Y se lo pasamos a obtener turnos
            });

            //Si cambia el option de fecha
            $('#fecha').on('change', function() {
                const filtroSeleccionado = $('select[name="filtro"]').val();
                const terminoBusqueda = $('#busqueda').val();
                const fechaSeleccionada = $(this).val(); //Actualizamos todos los datos
                obtener_turnos(terminoBusqueda, filtroSeleccionado, fechaSeleccionada); // Y se lo pasamos a obtener turnos
            });

            //Si se pone una letra en el buscador
            $('#busqueda').on('keyup', function() {
                const terminoBusqueda = $(this).val();
                const filtroSeleccionado = $('select[name="filtro"]').val() || '';
                const fechaSeleccionada = $('#fecha').val(); //Actualizamos todos los datos
                obtener_turnos(terminoBusqueda, filtroSeleccionado, fechaSeleccionada); // Y se lo pasamos a obtener turnos
            });

            obtener_turnos();
        });
    </script>

</body>

</html>