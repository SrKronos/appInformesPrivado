<?php
class ConexionPostgresql {
    private $conexion;

    private $host = "192.168.20.246";  // Cambia la dirección IP del servidor PostgreSQL
    private $usuario = "postgres";  // Cambia a tu usuario de PostgreSQL
    private $clave = "UIO_Base-hbo2023";  // Cambia a tu contraseña de PostgreSQL
    private $base_de_datos = "uio_db_hbo";  // Cambia a tu nombre de base de datos PostgreSQL

    public function __construct() {
        $dsn = "pgsql:host=$this->host;dbname=$this->base_de_datos";

        try {
            $this->conexion = new PDO($dsn, $this->usuario, $this->clave);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Error de conexión a la base de datos: ' . $e->getMessage());
        }
    }

    public function obtenerConexion() {
        return $this->conexion;
    }

    public function cerrarConexion() {
        $this->conexion = null;
    }
}
?>
