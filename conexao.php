<?php

class Conexao {

    private $db_user = "root";
    private $db_password = "";
    private $db_name = "sistema_enade";
    private static $instance = null;
    private $conn;

    private function __construct() {
        $this->conn = new PDO('mysql:host=localhost;dbname='.$this->db_name, $this->db_user, $this->db_password);
        $this->conn->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
    }

    public static function get_instance() {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function get_conexao() {
        return $this->conn;
    }
}