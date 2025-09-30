<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

require '../excel/vendor/autoload.php';
require("../conexion.php");
$conexion = new BaseDatos();

if ($conexion -> conectar()) {  
    $conn = $conexion -> getConexion();    



    $excel = new Spreadsheet();
    $hoja = $excel->getActiveSheet();
    $hoja->setTitle("Turnos");

    // Traer configuración
    $stmt = $conn->query("SELECT * FROM config_turnos LIMIT 1");
    $config = $stmt->fetch_assoc();

    $inicioFecha = new DateTime($config['fecha_inicio']);
    $finFecha = new DateTime($config['fecha_fin']);
    $cupoFecha = $config['cupo_fecha'];

    // Calcular fechas disponibles
    $fechas_disponibles = [];
    while ($inicioFecha <= $finFecha) {
        $fechaBD = $inicioFecha->format('Y-m-d');


        $stmt = $conn->prepare("SELECT COUNT(*) FROM turnos WHERE fecha = ?");
        $stmt->bind_param("s",$fechaBD);
        $stmt-> execute();
        $stmt->bind_result($cupoActual);
        $stmt->fetch();
        $stmt->close();
        

        
        if ($cupoActual < $cupoFecha) {
            $fechas_disponibles[] = $inicioFecha->format('d-m-Y');
        }
        
        $inicioFecha->modify('+1 day'); 
    }

    // Calcular horarios disponibles
    $horarios_disponibles = [];
    $inicioHora = new DateTime($config['hora_inicio']);
    $finHora = new DateTime($config['hora_fin']);
    while ($inicioHora < $finHora) {
        $horarios_disponibles[] = $inicioHora->format('H:i');
        $inicioHora->modify("+{$config['intervalo']} minutes");
    }


    $filaExcel = 1;

    foreach ($fechas_disponibles as $fecha) {
        $fechaObj = DateTime::createFromFormat('d-m-Y', $fecha);
        $fechaBD = $fechaObj->format('Y-m-d'); //la pasamos para q la Bd lo entienda

        // Título de fecha
        $hoja->mergeCells("A$filaExcel:G$filaExcel"); //unimos celdas
        $hoja->setCellValue("A$filaExcel", "Turnos para el día: $fecha"); //ponemos titulo
        //Estilos del titulo
        $hoja->getStyle("A$filaExcel")->getFont()->setBold(true)->setSize(14);
        $hoja->getStyle("A$filaExcel")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $hoja->getStyle("A$filaExcel")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('C9DAF8');

        $filaExcel++;

        // Encabezados todos juntos en un array
        $encabezados = ['Horario', 'ID', 'Nombre', 'Apellido', 'DNI', 'Email'];
        $columna = 'A';
        // Recorremos y colocamos los encabezados sumando de a una columna
        foreach ($encabezados as $encabezado) {
            $hoja->setCellValue($columna . $filaExcel, $encabezado);
            $columna++;
        }
        //Estilos encabezados
        $hoja->getStyle("A$filaExcel:F$filaExcel")->getFont()->setBold(true);
        $hoja->getStyle("A$filaExcel:F$filaExcel")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('D9EAD3');

        $filaExcel++;

        // Datos por horario
        foreach ($horarios_disponibles as $horario) {

        $stmt = $conn->prepare("SELECT * FROM turnos WHERE fecha = ? AND horario = ?");
        $stmt->bind_param("ss", $fechaBD, $horario);
        $stmt->execute();
        $result = $stmt->get_result();
        $turno = $result->fetch_assoc();
        
            //Traemos los turnos q coincidan con los datos

            $hoja->setCellValue("A$filaExcel", $horario);

            if ($turno) { //si concide completamos el excel con los datos de la bd
                $hoja->setCellValue("B$filaExcel", $turno['id_turno']);
                $hoja->setCellValue("C$filaExcel", $turno['nombre']);
                $hoja->setCellValue("D$filaExcel", $turno['apellido']);
                $hoja->setCellValue("E$filaExcel", $turno['DNI']);
                $hoja->setCellValue("F$filaExcel", $turno['email']);
            } else { //si no le ponemos un texto 
                $hoja->setCellValue("B$filaExcel", "DISPONIBLE");
                $hoja->getStyle("B$filaExcel")->getFont()->getColor()->setRGB('00AA00');
            }

            $filaExcel++;
        }

        // Espacio entre titulos
        $filaExcel++;
    }


    //Descargar Excel
    ob_clean();
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="Turnos.xlsx"');
    header('Cache-Control: max-age=0');

    $writer = IOFactory::createWriter($excel, 'Xlsx');
    $writer->save('php://output');
    exit; 
}