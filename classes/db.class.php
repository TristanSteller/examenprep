<?php
class DbConnection{
 
    private $db_host = 'localhost';
    private $db_username = 'root';
    private $db_password = '';
    private $db_name = 'examending';
 
    public $connection;
 
    public function __construct(){
 
        if (!isset($this->connection)) {
 
            $this->connection =  new PDO("mysql:host={$this->db_host};dbname={$this->db_name}", $this->db_username, $this->db_password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if (!$this->connection) {
                echo 'Cannot connect to database server';
                exit;
            }            
        }    
 
        return $this->connection;
    }
}
?>