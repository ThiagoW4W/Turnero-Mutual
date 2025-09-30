<?php
include("../conexion.php");
$conexion = new BaseDatos();

if ($conexion -> conectar()) {
	$conn = $conexion -> getConexion();

	$id = $_POST['id'] ?? null;



	try {
		$stmt = $conn->prepare("DELETE FROM turnos WHERE id_turno = ?");
		$stmt->bind_param("i",$id);
		$ok = $stmt->execute();
		if ($ok) {
			echo json_encode(['salida' => 0, 'mensaje' => 'Turno borrado correctamente']);
		} else {
			echo json_encode(['salida' => 1, 'mensaje' => '  ']);
		}
	} catch (\Throwable $th) {
		echo json_encode([
			'salida' => 2,
			'mensaje' => 'Error al borrar turno',
			// 'error' => $e->getMessage() 
		]);
	}
}