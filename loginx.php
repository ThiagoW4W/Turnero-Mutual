<?php
include("conexion.php");
session_start(); 

$conexion = new BaseDatos();


if ($conexion->conectar()) {
    echo "Conecto a la BD, vamo bien *-*-*-*-*-*-*-*-*-*-*      " ;

    if (!empty($_POST["nombre"]) && !empty($_POST["password"])) {

        $nombreIngresado = strtolower(trim($_POST["nombre"]));
        $contraIngresado = $_POST["password"];

        $conn = $conexion->getConexion();
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE LOWER(nombre) = ? ");
            $stmt->bind_param("s", $nombreIngresado); //Vinculo parámetro a la consulta preparada. "s": string (cadena de texto)
            $stmt->execute();
            $resultado = $stmt->get_result();
            
        if ($usuario = $resultado -> FETCH_ASSOC()) {
            echo "El user existe wiii *-*-*-*-*-*-*-*-*-*-*";



            if ("$contraIngresado" ===  $usuario["password"]) {
                echo "verifica bien la contra UwU";
                $_SESSION['usuario'] = $usuario;
                
                header("location: menu.php");
                
            }
        }
        
    }

} else {
    echo "Error al conectar a la BD";
}
