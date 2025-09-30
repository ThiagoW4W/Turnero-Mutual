<?php
require "../conexion.php";
$conexion = new BaseDatos();

if ($conexion -> conectar()) {
    $conn = $conexion -> getConexion(); 

    $ape = $_POST['apellido'] ?? null;
    $nom = $_POST['nombre'] ?? null;
    $dni = $_POST['dni'] ?? null;
    $email = $_POST['email'] ?? null;
    $fecha = $_POST['fecha'] ?? null;
    $hora = $_POST['horario'] ?? null;

    $idTurno = $_POST['idTurno'] ?? null;

    try {
        $stmt = $conn->prepare("UPDATE turnos SET nombre = ?,apellido = ?,dni = ?,email = ?,fecha = ? , horario = ? WHERE id_turno = ? ");
        $stmt->bind_param("ssisssi", $nom,$ape,$dni,$email,$fecha,$hora, $idTurno);
        $ok = $stmt -> execute();
        if ($ok) {
            echo json_encode(['salida' => 0, 'mensaje' => 'Turno editado correctamente']);
        } else {
            echo json_encode(['salida' => 1, 'mensaje' => 'No se pudo editar el turno']);
        }
    } catch(PDOException $e) {
        echo json_encode([
            'salida' => 2,
            'mensaje' => 'Error al editar turno',
            // 'error' => $e->getMessage() 
        ]);
    }
}