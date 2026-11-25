<?php
// Ativa o relatório de erros para evitar telas brancas
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function getConexao() {
    $servidor = 'localhost';
    $usuario  = 'root';
    $senha    = 'Home@spSENAI2025!'; // Altere para a sua senha do MySQL local (ex: '' no XAMPP)
    $banco    = 'bloobloo';
    
    $conexao = new mysqli($servidor, $usuario, $senha, $banco);
    
    if ($conexao->connect_error) {
        die("Falha na conexão com a base de dados: " . $conexao->connect_error);
    }
    
    return $conexao;
}

function listarCategorias() {
    $conexao = getConexao();
    $sql = "SELECT id_categoria, nome_categoria FROM categorias_produtos ORDER BY nome_categoria ASC";
    $resultado = $conexao->query($sql);
    
    $options = "";
    if ($resultado && $resultado->num_rows > 0) {
        while ($linha = $resultado->fetch_assoc()) {
            $options .= "<option value='" . $linha['id_categoria'] . "'>" . htmlspecialchars($linha['nome_categoria']) . "</option>";
        }
    } else {
        $options = "<option value=''>Nenhuma categoria cadastrada</option>";
    }
    
    $conexao->close();
    return $options;
}
?>