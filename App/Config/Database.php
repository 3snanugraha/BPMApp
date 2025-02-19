<?php
class Database
{
    private $host = 'localhost';
    private $db_name = 'blood_pressure_monitoring';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        try {
            $this->conn = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }
    }

    public function query($query, $params = [])
    {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    public function lastInsertId()
    {
        return $this->conn->lastInsertId();
    }
}

