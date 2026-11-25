<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: form_cad_cliente.php"); exit; }
require_once 'funcoes_clientes.php';

$nome_completo  = $_POST['nome_completo'] ?? '';
$email          = $_POST['email'] ?? '';
$telefone       = $_POST['telefone'] ?? '';
$cpf_cnpj       = $_POST['cpf_cnpj'] ?? '';
$data_cadastro  = $_POST['data_cadastro'] ?? date('Y-m-d');
$ativo          = $_POST['ativo'] ?? '1';
$motivo_inativo = ($ativo === '0') ? ($_POST['motivo_inativo'] ?? NULL) : NULL;

$conexao = getConexao();
$stmt = $conexao->prepare("INSERT INTO clientes (nome_completo, email, telefone, cpf_cnpj, data_cadastro, ativo, motivo_inativo) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssis", $nome_completo, $email, $telefone, $cpf_cnpj, $data_cadastro, $ativo, $motivo_inativo);

if ($stmt->execute()) {
    header("Location: form_cad_cliente.php");
} else {
    echo "Erro ao cadastrar cliente: " . $stmt->error;
}
$stmt->close();
$conexao->close();
?>