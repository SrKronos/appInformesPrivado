<?php
require_once 'ConexionPostgresql.php';

if (isset($_POST["desde"]) && isset($_POST["hasta"])) {
    obtenerReporteEmergencia($_POST["desde"], $_POST["hasta"]); // Aquí había un error, debería ser $_POST["hasta"] y no $_POST["desde"] nuevamente
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

        // Establecer cabeceras para la descarga del archivo CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=reporte_emergencias_'.$desde.'_'.$hasta.'.csv');

        // Abrir el archivo en memoria para escritura
        $output = fopen('php://output', 'w');

        // Obtener los nombres de las columnas y escribir en el archivo
        $cabecerasColumnas = array_keys($resultados[0]);
        fputcsv($output, $cabecerasColumnas); // Aquí se colocan las cabeceras

        // Iterar sobre las filas y escribirlas en el archivo CSV
        foreach ($resultados as $fila) {
            fputcsv($output, $fila);
        }

        // Cerrar el "archivo" en memoria
        fclose($output);

        // Cerrar la conexión (esto es opcional, ya que PHP cerrará la conexión cuando el script termine)
        $conexion->cerrarConexion();
        
        // No es necesario enviar una respuesta ya que hemos enviado el contenido del CSV directamente
        exit;
    } else {
        echo json_encode(array('error' => 'Error al obtener los datos desde la base de datos.'));
    }
}
?>
