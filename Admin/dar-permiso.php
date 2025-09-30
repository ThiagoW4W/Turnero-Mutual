<?php
session_start();
include("../conexion.php");
$permiso = 0;
$conexion = new BaseDatos();

if ($conexion -> conectar()) {
	$conn = $conexion -> getConexion();


	$usuario = $_SESSION['usuario'];
	$idUser = $usuario['id'];
	$beneficio = $usuario['beneficioTurno'];

	try {
		if ($beneficio == 1) {
		$stmt= $conn->prepare("UPDATE usuarios SET beneficioTurno = ? WHERE id = ?");
		$stmt->bind_param( "ii", $permiso, $idUser);
		$stmt -> execute();
		echo json_encode(['salida' => 0, 'mensaje' => 'Permiso de turno otorgado']);
	} else {
		echo json_encode(['salida' => 1, 'mensaje' => 'Este usuario ya tiene el permiso']);
	}
	} catch (PDOException $e) {
		echo json_encode([
			'salida' => 2,
			'mensaje' => 'Error al ejecutar la consulta',
			// 'error' => $e->getMessage() 
		]);
	}
}