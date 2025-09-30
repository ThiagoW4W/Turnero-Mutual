<?php
/*try{
    $pdo = new PDO('mysql:host=localhost;dbname=turnero; charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e){
    die("Error de conexion ". $e->getMessage());
} */


class BaseDatos {
    private $host = "localhost";
    private $db = "turnero";
    private $user = "root";
    private $pass = "sincontrasena";
    private $conn;
    private $query;

    public function conectar() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);

        if ($this->conn->connect_error) {
            die("Error de conexión: " . $this->conn->connect_error);
        }

        $this->conn->set_charset("utf8");
        return true;
    }

    public function cerrar() {
        return $this->conn->close();
    }

    public function select($sql) {
        $this->query = $this->conn->query($sql);
        return $this->query;
    }

    public function fetch() {
        return $this->query ? $this->query->fetch_assoc() : false;
    }

    public function ejecutar($sql) {
        return $this->conn->query($sql);
    }

    public function insertar($sql) {
        if ($this->conn->query($sql)) {
            return $this->conn->insert_id;
        }
        return false;
    }

    public function iniciarTransaccion() {
        return $this->conn->begin_transaction();
    }

    public function commit() {
        return $this->conn->commit();
    }

    public function rollback() {
        return $this->conn->rollback();
    }

    public function escape($str) {
        return $this->conn->real_escape_string($str);
    }

    public function getConexion() {
        return $this->conn;
    }


    public function preparar($sql) {
        return $this->conn->prepare($sql);
    }

    public function getResult($stmt) {
        return $stmt->get_result();
    }
}

?>



