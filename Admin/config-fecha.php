<?php
require "../conexion.php";
$conexion = new BaseDatos();
if ($conexion->conectar()) {
    $conn = $conexion->getConexion();

    $fechaInicio = $_POST['fechaInicio'] ?? null;
    $fechaFin = $_POST['fechaFin'] ?? null;
    $horaInicio = $_POST['horaInicio'] ?? null;
    $horaFin = $_POST['horaFin'] ?? null;


    try {
        $stmt = $conn->prepare("UPDATE config_turnos SET fecha_inicio = ?, fecha_fin = ?, hora_inicio = ?, hora_fin = ?");
        $stmt -> bind_param("ssss",$fechaInicio, $fechaFin, $horaInicio, $horaFin );
        $ok = $stmt->execute();

        if ($ok) {
            echo json_encode(['salida' => 0, 'mensaje' => 'Fechas definidas correctamente']);
        } else {
            echo json_encode(['salida' => 1, 'mensaje' => 'No se pudo actualizar la configuración']);
        }
    } catch(PDOException $e) {
        echo json_encode([
            'salida' => 2,
            'mensaje' => 'Error al definir plazos',
            // 'error' => $e->getMessage() 
        ]);
    }
}
?>