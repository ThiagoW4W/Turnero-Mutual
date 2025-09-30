<?php
session_start();
require('conexion.php');
$conexion = new BaseDatos();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require('Mail/PHPMailer.php');
require('Mail/Exception.php');
require('Mail/SMTP.php');

if ($conexion->conectar()) {
    
    date_default_timezone_set("America/Argentina/Buenos_Aires");

    if (!isset($_SESSION['usuario'])) exit;

    $usuario = $_SESSION['usuario'];
    $id_usuario = $usuario['id'] ?? null;
    $benficio_turno = $usuario['beneficioTurno'] ?? null;

    // Captura de datos
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $dni = trim($_POST['DNI'] ?? '');
    $numTelf = trim($_POST['numTelf'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $fecha = trim($_POST['fecha'] ?? '');

    // Validación básica
    if (!$nombre || !$apellido || !$numTelf || !$fecha) {
        echo json_encode(['salida' => 1, 'mensaje' => 'Faltan datos obligatorios']);
        exit;
    }

    // Validar formato de fecha (YYYY-MM-DD)

    $fechaObj = DateTime::createFromFormat('d-m-Y', $fecha);
    $fechaBD = $fechaObj->format('Y-m-d');

    // Configuración de turnos
    $conn = $conexion->getConexion();
    $resultado = $conn->query("SELECT * FROM config_turnos LIMIT 1");
    $config = $resultado -> FETCH_ASSOC();       
                

    $inicio = new DateTime($config['hora_inicio']);
    $fin = new DateTime($config['hora_fin']);
    $intervalo = $config['intervalo'];

    //Asignación de hora al truno
    $horarios_disponibles = [];
    while ($inicio < $fin) {
        $horario_actual = $inicio->format('H:i');

        $stmt = $conn->prepare("SELECT COUNT(*) FROM turnos WHERE horario = ? AND fecha = ?");
        $stmt->bind_param("ss", $horario_actual, $fechaBD);
        $stmt->execute();
        $stmt->bind_result($cupoActual);
        $stmt->fetch();
        $stmt->close();

        if ($cupoActual < $config['cupo']) {
            $horarios_disponibles[] = $horario_actual;
        }

        $inicio->modify("+{$intervalo} minutes");
    }

    // Verificar si hay horario disponible
    if (empty($horarios_disponibles)) {
        echo json_encode(['salida' => 1, 'mensaje' => 'No hay horarios disponibles para la fecha seleccionada']);
        exit;
    }

    $horario = $horarios_disponibles[0];

    // Insertar turno
try {
    
    $stmt = $conn->prepare("INSERT INTO turnos (fecha, horario, nombre, apellido, dni, numtelf, email, id_usuario)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    
    $stmt->bind_param("ssssiisi", $fechaBD, $horario, $nombre, $apellido, $dni, $numTelf, $email, $id_usuario);

    // Ejecutar
    if ($stmt->execute()) {
        $stmt->close();

        // Actualizar beneficioTurno del usuario
        $stmtUpdate = $conn->prepare("UPDATE usuarios SET beneficioTurno = 1 WHERE id = ?");
        $stmtUpdate->bind_param("i", $id_usuario);
        $stmtUpdate->execute();
        $stmtUpdate->close();

        
        $fechaCorreo = $fechaObj->format('d-m-Y');
    

        echo json_encode(['salida' => 0, 'mensaje' => 'Turno cargado correctamente']);

    } else {
        throw new Exception("Error al insertar en la base de datos.");
    }

} catch (Exception $e) {
    echo json_encode([
        'salida' => 1,
        'mensaje' => 'ERROR al cargar: ' . $e->getMessage()
    ]);
    exit;
} 
        enviarCorreo($email, $nombre, $apellido, $fechaCorreo, $horario);



}
    // Función para enviar correo
    function enviarCorreo($destinatario, $nombre, $apellido, $fecha, $hora)
    {
        
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Host = '...';
            $mail->SMTPAuth = true;
            $mail->Username = '...;
            $mail->Password = '...';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('...', 'Mutual Policial');
            $mail->addAddress($destinatario);

            $mail->isHTML(true);
            $mail->Subject = 'Confirmación de Turno';
            $mail->Body = generarMensajeMail($apellido, $nombre, $fecha, $hora);

            $mail->send();
        } catch (Exception $e) {
            echo $e;
        }
    }

    // Función para generar el mensaje HTML
    function generarMensajeMail($apellido, $nombre, $fecha, $hora)
    {
        return '
        <html><head><meta charset="utf-8" /></head><body>
        <div style="background: #003366; width: 800px; margin: auto; padding: 20px;">
            <img src="https://tramitesonline.mppneuquen.com.ar/imagenes/logoRecuperacion2.jpg" style="display: block; margin: auto;">
            <p style="color:#0072BC; text-align: center; font-size: 22px;">CONFIRMACIÓN DE TURNO</p>
            <p style="color:white; text-align: center; font-size: 20px;">Hola ' . $apellido . ' ' . $nombre . ',</p>
            <p style="color:white; text-align: center; font-size: 18px;">Tu turno fue registrado con éxito para el día ' . $fecha . ' a las ' . $hora . ' hs.</p>        
            <p style="color:white; text-align: center; font-size: 18px;">Ante cualquier consulta escribinos:</p>
            <p style="text-align: center;"><a href="mailto:soporte@mppneuquen.com.ar" style="color:#85C1E9;">soporte@mppneuquen.com.ar</a></p>
            <p style="color:white; text-align: center; font-size: 16px;">Por favor, no responder este email.</p>
        </div>
        </body></html>';
    }