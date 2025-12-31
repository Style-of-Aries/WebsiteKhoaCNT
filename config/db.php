<?php 
class Database {
    private $host = 'localhost';
    private $dbname = 'webmusic';
    private $user = 'root';
    private $password = '';
    public $conn;
    public function connect() {
        $dsn = "mysql:host=$this->host;dbname=$this->dbname;charset=utf8";
        
        try {
            //code...
            $pdo = new PDO($dsn,$this->user,$this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Kết nối thất bại" .$e->getMessage());
            //throw $th;
        }
    }
}