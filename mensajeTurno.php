<?php

    $usuario = $_SESSION['usuario'];
    $id_usuario = $usuario['id'];
    $conn = $conexion->getConexion();

    $stmt = $conn->prepare("SELECT nombre, apellido, horario, DATE_FORMAT(fecha, '%d/%m/%y') AS fecha 
    FROM turnos WHERE id_usuario = ? ORDER BY id_turno DESC LIMIT 1");
    $stmt->bind_param("i", $id_usuario); 
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado && $resultado->num_rows > 0) {
        $turno = $resultado->fetch_assoc(); 
        $nombre = $turno['nombre'];
        $apellido = $turno['apellido'];
        $fecha = $turno['fecha'];
        $horario = (new DateTime($turno['horario']))->format('H:i'); // Formato sin segundos
        ?>
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="utf-8" />
            <title>Confirmación de Turno</title>
        </head>
        <body>
            <div id="cajaMensaje">
                <img draggable="false" src="https://mppneuquen.com.ar/wp-content/uploads/2025/07/logo-sinFondo.webp" width="367" style="display: block; margin: auto;">
                <p style="color:black; text-align: center; font-size: 20px;">CONFIRMACIÓN DE TURNO</p>
                <p style="color:black; text-align: center; font-size: 20px;">Hola <?= htmlspecialchars($apellido) ?> <?= htmlspecialchars($nombre) ?></p>
                <p style="color:black; text-align: center; font-size: 18px;">
                    Tu turno fue registrado con éxito para el día <?= htmlspecialchars($fecha) ?> a las <?= $horario ?> hs.
                </p>
                <p style="color:black; text-align: center; font-size: 18px;">Ante cualquier consulta escribinos:</p>
                <p style="text-align: center;">
                    <a href="mailto:soporte@mppneuquen.com.ar" style="color:#003466;">soporte@mppneuquen.com.ar</a>
                </p>
            </div>
        </body>
        </html>
        <?php
    } 

?>
