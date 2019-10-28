<?php

class Conexao {

    private $db_user = "root";
    private $db_password = "";
    private $db_name = "sistema_enade";
    private static $instance = null;
    private $conn;

    private function __construct() {
        $this->conn = new PDO('mysql:host=localhost;port=3308;dbname='.$this->db_name.";charset=utf8", $this->db_user, $this->db_password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
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