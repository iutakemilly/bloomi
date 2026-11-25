<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: form_cad_vendedor.php");
    exit;
}

require_once 'funcoes_vendedores.php';

// Captura e sanitização dos dados do formulário
$nome_empresa     = trim($_POST['nome_empresa'] ?? '');
$cnpj             = trim($_POST['cnpj'] ?? '');
$nome_responsavel = trim($_POST['nome_responsavel'] ?? '');
$email            = trim($_POST['email'] ?? '');
$telefone         = trim($_POST['telefone'] ?? '');
$id_categoria     = (int)($_POST['id_categoria'] ?? 0);
$ativo            = (int)($_POST['ativo'] ?? 1);
$motivo_inativo   = ($ativo === 0) ? trim($_POST['motivo_inativo'] ?? '') : NULL;

$conexao = getConexao();

// Usamos NOW() no SQL para que o MySQL defina a data correta automaticamente (8 parâmetros `?`)
$sql = "INSERT INTO vendedores 
        (nome_empresa, cnpj, nome_responsavel, email, telefone, id_categoria, data_cadastro, ativo, motivo_inativo) 
        VALUES (?, ?, ?, ?, ?, ?, NOW(), ?, ?)";

$stmt = $conexao->prepare($sql);

if (!$stmt) {
    die("Erro na preparação SQL: " . $conexao->error);
}

// Tipos ajustados para os 8 parâmetros: sssssiis (5 strings, 2 inteiros, 1 string)
$stmt->bind_param("sssssiis", $nome_empresa, $cnpj, $nome_responsavel, $email, $telefone, $id_categoria, $ativo, $motivo_inativo);

if ($stmt->execute()) {
    header("Location: form_cad_vendedor.php");
    exit;
} else {
    if ($conexao->errno === 1062) {
        echo "<script>alert('Erro: Este CNPJ ou E-mail já está cadastrado no sistema.'); window.history.back();</script>";
    } else {
        echo "Erro ao cadastrar vendedor: " . $stmt->error;
    }
}

$stmt->close();
$conexao->close();
?>