<?php
abstract class Conexao {
    protected $conexao;
    public function __construct(){
        try {
            $this->conexao = new PDO('mysql:host=localhost;port=3306;dbname=snotes', 'root', '');
            $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Erro na conexão: ' . $e->getMessage());
        }
    }
    public function getConexao(){return $this->conexao;}
}
?>