<?php

require "conexion.php";

$usuario = $_SESSION['usuario'];
$ID = $usuario['id'];


$stmt = $pdo->prepare("SELECT nombre, apellido, horario, DATE_FORMAT(fecha, '%d/%m/%y') AS fecha FROM turnos WHERE id_usuario = ?");
$stmt->execute([$ID]);
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);



foreach ($resultado as $fila) {
    $nombre = $fila['nombre'];
    $apellido = $fila['apellido'];
    $horario = $fila['horario'];
    $fecha = $fila['fecha'];
}


if ($resultado): ?>
    <?php
    // Asegurar formato sin segundos
    $horario = (new DateTime($horario))->format('H:i');
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
<?php else: ?>
    <div id="cajaMensaje">
        <div id="error" style="background-color:yellow">
            <p style="color:red; background-color:black; text-align: center; font-size: 20px;">ERROR</p>
            <p style="color:red; background-color:black; text-align: center; font-size: 20px;">POR FAVOR ESCRIBA A: </p>
            <p style="color:red; background-color:black; text-align: center; font-size: 20px;">
                <a href="mailto:soporte@mppneuquen.com.ar" style="color:#003466;">soporte@mppneuquen.com.ar</a>
            </p>
        </div>
    <?php endif; ?>