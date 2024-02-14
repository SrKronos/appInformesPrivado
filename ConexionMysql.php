<?php
class ConexionMysql {
    private $conexion;

    private $host = "localhost";
    private $usuario = "root";
    private $clave = "123";  // Cambia esto a tu contraseña
    private $base_de_datos = "farmaciadb";

    public function __construct() {
        $dsn = "mysql:host=$this->host;dbname=$this->base_de_datos;charset=utf8mb4";

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
