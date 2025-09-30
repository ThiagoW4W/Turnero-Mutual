<?php
function traerTurnos() {

    $conexion = new BaseDatos();
    if ($conexion->conectar()) {
        $conn = $conexion->getConexion();
        //Traemos la configuracion 
        $resultado = $conn->query("SELECT * FROM config_turnos LIMIT 1");
        $config = $resultado->fetch_assoc();
        $inicioFecha = new DateTime($config['fecha_inicio']);
        $finFecha    = new DateTime($config['fecha_fin']);
        $cupoFecha   = $config['cupo_fecha'];

        $fechas_disponibles = [];

        while ($inicioFecha <= $finFecha) {
            $fechaActual = $inicioFecha->format('Y-m-d');

            $stmt = $conn->prepare("SELECT COUNT(*) FROM turnos WHERE fecha = ?");
            $stmt->bind_param("s", $fechaActual);
            $stmt->execute();
            $stmt->bind_result($cupoActual);
            $stmt->fetch();
            $stmt->close();

            if ($cupoActual < $cupoFecha) {
                $fechas_disponibles[] = $inicioFecha->format('d-m-Y');
            }
            $inicioFecha->modify('+1 day');
        }
        return $fechas_disponibles;  
    }
    
}

