<?php
session_start();
include("../conexion.php");
$conexion = new BaseDatos();

$tienePermiso  = 1; //CAMBIAR EN PRODUCCION, SE TIENE QUE CONSULTAR LOS PERMISOS DEL USUARIO_X 
if ($conexion->conectar()) {

    $conn = $conexion->getConexion();

    $entrada = '%' . strtoupper(trim($_POST['buscar'] ?? '')) . '%';
    $ordenar = $_POST['filtro'] ?? 'fecha_asc'; 
    $fecha =  $_POST['fecha'] ?? null;


    //Valores del select "Ordenar por" 
    switch ($ordenar) {
        case 1:
            $campoOrden = 'ORDER BY fecha ASC, horario ASC';
            break;
        case 2:
            $campoOrden = 'ORDER BY fecha DESC, horario DESC';
            break;

        default:
            $campoOrden = ' ';
    }

    //Valores del select "Filtro" 

    switch ($fecha) {
        case null:
        case 0:
        case '':
            $WHERE = " ";
            $FECHA = " ";
            break;
        default:
            $timestamp = strtotime($fecha);
            $fechaFormat = date("Y/m/d", $timestamp);

            $FECHA = "WHERE fecha = '$fecha'";
            $WHERE = "AND fecha = '$fechaFormat'";
            break;
    }


    $countFecha = $conn->query("SELECT count(*) FROM turnos $FECHA ")->fetch_row(); //Contamos cant. de turnos para mostrar



    

    $query = "SELECT id_turno, DNI, nombre, apellido, email, 
            DATE_FORMAT(fecha, '%d/%m/%y') AS fecha,
            DATE_FORMAT(horario, '%H:%i') AS horario
            FROM turnos
            WHERE (
                UPPER(DNI) LIKE ? OR
                UPPER(fecha) LIKE ? OR
                UPPER(nombre) LIKE ? OR
                UPPER(apellido) LIKE ? OR
                UPPER(CONCAT(nombre, ' ', apellido)) LIKE ? OR
                UPPER(CONCAT(apellido, ' ', nombre)) LIKE ?
            ) $WHERE $campoOrden";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssss", $entrada, $entrada, $entrada, $entrada, $entrada, $entrada);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if (isset($_POST["buscar"])) {
        $entrada = mb_strtoupper($_POST["buscar"]); //Aca llega el valor del buscador (en mayus)
?>
        <h3>Cantidad de turnos: <?= $countFecha[0] ?></h3>
        <!-- Tabla con los turnos -->
        <div class="cajaTabla">
            <table id="tabla">
                <thead>
                    <tr class="p-3 mb-2 bg-secondary text-white">
                        <th>ID</th>
                        <th>DNI</th>
                        <th>NOMBRE Y APELLIDO</th>
                        <th>MAIL</th>
                        <th>FECHA</th>
                        <th>HORA</th>
                        <?php if ($tienePermiso == 1) { ?>
                            <th>ACCIONES</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultado as $fila) { ?>
                        <tr>
                            <td><?= $fila['id_turno'] ?></td>
                            <td><?= $fila['DNI'] ?></td>
                            <td><?= $fila['nombre'] . " " . $fila['apellido'] ?></td>
                            <td><?= $fila['email'] ?></td>
                            <td><?= $fila['fecha'] ?></td>
                            <td><?= $fila['horario'] ?></td>
                            <?php if ($tienePermiso == 1) { ?>
                                <td>
                                    <div class="botonAccion">
                                        <p id="botonBorrar">
                                            <a href="#" class="btn" title="Borrar" onclick="borrar(<?= $fila['id_turno'] ?>); return false;">
                                                🗑️ Borrar
                                            </a>
                                        </p>
                                        <p id="botonPermiso">
                                            <a href="#" class="btn" title="Permiso" onclick="darPermiso(<?= $fila['id_turno'] ?>); return false;">
                                                🎫 Permiso
                                            </a>
                                        </p>
                                        <p id="botonEditar">
                                            <a href="#" class="btn" title="Editar" onclick="editar('<?= $fila['id_turno'] ?>', '<?= $fila['DNI'] ?>', 
                                                '<?= $fila['apellido'] ?>', '<?= $fila['nombre'] ?>' , '<?= $fila['email'] ?>'
                                                , '<?= $fila['fecha'] ?>', '<?= $fila['horario'] ?>'); return false;">
                                                📑 Editar
                                            </a>
                                        </p>
                                    </div>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php
    }
    ?>
<?php  } ?>
<!-- Treamos los funciones necesarioas -->
<script src="../Functions/Mensajes.js"></script>
<script src="../Functions/Validar.js"></script>
<script type="text/javascript">
    function borrar(idTurno) {
        Swal.fire({
            title: "¿Desea borrar el turno?",
            width: '500px',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#148F77',
            confirmButtonText: 'Aceptar',
            cancelButtonColor: 'red',
            allowOutsideClick: false,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'borrar-turno.php',
                    type: 'POST',
                    data: {
                        id: idTurno
                    },
                    success: function(respuesta) {
                        var jsonData = JSON.parse(respuesta);
                        if (jsonData.salida == 0) {
                            return mensajeExito(jsonData.mensaje);
                        } else {
                            return mensajeError(jsonData.mensaje);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la solicitud AJAX:', error);
                    }
                });
            }
        })
    }

    function darPermiso(idTurno) {
        Swal.fire({
            title: "¿Desea otorgar permiso?",
            width: '500px',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#148F77',
            confirmButtonText: 'Aceptar',
            cancelButtonColor: 'red',
            allowOutsideClick: false,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'dar-permiso.php',
                    type: 'POST',
                    data: {
                        id: idTurno
                    },
                    success: function(respuesta) {
                        console.log(respuesta);

                        var jsonData = JSON.parse(respuesta);
                        if (jsonData.salida == 0) {
                            return mensajeExito(jsonData.mensaje);
                        }
                        if (jsonData.salida == 2) {
                            return mensajeAviso(jsonData.mensaje);
                        } else {
                            return mensajeError(jsonData.mensaje);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la solicitud AJAX:', error);
                    }
                });
            }
        })
    }

    function editar(idTurno, dni, apellido, nombre, email, fecha, horario) {

        var idTurno = idTurno
        //Tenemos que formatear la fecha elegida de esta forma para que la BD lo entienda
        const partes = fecha.split('/');
        const dia = partes[0];
        const mes = partes[1];
        const anio = '20' + partes[2];
        var fechaFormat = `${anio}-${mes}-${dia}`; //Basicamente le agreamos un 20 al principio del año: 25 -> 20+25 = 2025

        Swal.fire({
            title: 'Editar turno',
            html: `
        <input id="swal-nombre" class="swal2-input" placeholder="Nombre"  value= "${nombre}"required autocomplete="off"> </br>
        <input id="swal-apellido" class="swal2-input" placeholder="Apellido" value="${apellido}" required" autocomplete="off">
        <input id="swal-dni" class="swal2-input" placeholder="DNI" value="${dni}" required autocomplete="off">
        <input id="swal-email" class="swal2-input" placeholder="Email" value="${email}" required autocomplete="off">
        <input id="swal-fecha" type="date" class="swal2-input" value="${fechaFormat}" required autocomplete="off">
        <input id="swal-hora" type="time" class="swal2-input"value="${horario}" required autocomplete="off">`, //Esto es la ventana emergente de editar

            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Guardar',
            preConfirm: () => {
                return {
                    idTurno: idTurno,
                    nombre: document.getElementById('swal-nombre').value,
                    apellido: document.getElementById('swal-apellido').value,
                    dni: document.getElementById('swal-dni').value,
                    email: document.getElementById('swal-email').value,
                    fecha: document.getElementById('swal-fecha').value,
                    horario: document.getElementById('swal-hora').value
                } //Aca tenemos todos los valores de los inputs
            }

        }).then((result) => {
            if (result.isConfirmed) {
                const datos = result.value;
                console.log("Datos:", result.value); // Acceder con result.value.nombre, etc.
                if (!result.value.nombre || !result.value.apellido || //Validacion de todos los campos para que no queden vacios
                    !result.value.dni || !result.value.email) {
                    Swal.fire({
                        icon: 'error',
                        width: '550px',
                        title: "Complete todos los campos",
                        allowOutsideClick: false,
                    })
                } else {
                    $.ajax({
                        url: 'editar-turno.php',
                        type: 'POST',
                        data: datos,
                        success: function(respuesta) {
                            console.log("Respuesta cruda:", respuesta)
                            var jsonData = JSON.parse(respuesta);
                            if (jsonData.salida == 0) {
                                return mensajeExito(jsonData.mensaje);
                            } else {
                                return mensajeError(jsonData.mensaje);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error en la solicitud AJAX:', error);
                        }
                    });
                }
            }
        });
    }
</script>