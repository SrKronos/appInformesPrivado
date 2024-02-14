<?php
require_once 'ConexionPostgresql.php';
require_once 'vendor/autoload.php'; // Asegúrate de que la ruta sea correcta

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_POST["desde"]) && isset($_POST["hasta"])) {
    obtenerReporteEmergencia($_POST["desde"], $_POST["hasta"]);
}

function obtenerReporteEmergencia($desde, $hasta) {
    // Crear la conexión a la base de datos
    $conexion = new ConexionPostgresql();
    $pdo = $conexion->obtenerConexion();

    // Consultar los datos de la cabecera desde vatencionespacientes
    $query = "SELECT * 
    FROM vatencionesemergencia v 
    INNER JOIN vdetalleatencionemergencia v1 
        ON v.id_paciente = v1.id_paciente 
        AND v.id_secuencial = v1.id_secuencial
    WHERE fecha_atencion >= :desde 
    AND fecha_atencion <= :hasta;";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':desde', $desde, PDO::PARAM_STR); 
    $stmt->bindParam(':hasta', $hasta, PDO::PARAM_STR); 

    if ($stmt->execute()) {
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Si no hay datos, entonces termina la ejecución y muestra un mensaje
        if (count($resultados) == 0) {
            echo "No se encontraron datos para exportar.";
            return;
        }

        // Crear un nuevo objeto Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Agregar las cabeceras de las columnas
        $columnas = array_keys($resultados[0]);
        $col = 1;
        foreach ($columnas as $columna) {
            $sheet->setCellValueByColumnAndRow($col, 1, $columna);
            $col++;
        }

        // Agregar datos a las filas correspondientes
        $row = 2; // Ya que la fila 1 son las cabeceras
        foreach ($resultados as $registro) {
            $col = 1;
            foreach ($registro as $campo) {
                $sheet->setCellValueByColumnAndRow($col, $row, $campo);
                $col++;
            }
            $row++;
        }

        // Establecer cabeceras para la descarga del archivo Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="reporte_emergencias.xlsx"');
        header('Cache-Control: max-age=0');

        // Guardar el archivo y enviarlo al navegador
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        // Cerrar la conexión (opcional, PHP cerrará la conexión automáticamente al finalizar el script)
        $conexion->cerrarConexion();
        
        // No es necesario enviar una respuesta ya que hemos enviado el contenido del archivo Excel directamente
        exit;
    } else {
        echo json_encode(array('error' => 'Error al obtener los datos desde la base de datos.'));
    }
}
?>
