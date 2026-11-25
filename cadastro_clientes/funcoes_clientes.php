<?php
function getConexao() {
    $servidor = 'localhost';
    $usuario  = 'root';
    $senha    = 'Home@spSENAI2025!'; // Altere para a sua senha
    $banco    = 'bloobloo';
    
    $conexao = new mysqli($servidor, $usuario, $senha, $banco);
    if ($conexao->connect_error) {
        die("Falha na conexão: " . $conexao->connect_error);
    }
    return $conexao;
}
?>