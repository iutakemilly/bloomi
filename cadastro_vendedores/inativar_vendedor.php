<?php
require_once 'funcoes_vendedores.php';

if (isset($_GET['id'])) {
    $id_vendedor = $_GET['id'];
} else {
    header("Location: form_cad_vendedor.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_vendedor    = $_POST['id_vendedor'];
    $motivo_inativo = $_POST['motivo_inativo'];

    $conexao = getConexao();
    $stmt = $conexao->prepare("UPDATE vendedores SET ativo = 0, motivo_inativo = ? WHERE id_vendedor = ?");
    $stmt->bind_param("si", $motivo_inativo, $id_vendedor);

    if ($stmt->execute()) {
        header("Location: form_cad_vendedor.php");
        exit;
    } else {
        echo "Erro ao inativar vendedor: " . $stmt->error;
    }

    $stmt->close();
    $conexao->close();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Inativar Vendedor - Bloomi</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #fcf8f6; padding: 40px; }
        .card { background: #ffffff; padding: 30px; border-radius: 12px; border: 1px solid #f2e6ee; max-width: 450px; margin: 0 auto; box-shadow: 0 4px 10px rgba(125, 50, 140, 0.1); }
        h2 { color: #dc2626; margin-bottom: 15px; }
        label { color: #7d328c; font-weight: bold; }
        input[type="text"] { width: 100%; padding: 10px; border: 1.5px solid #e5d5e2; border-radius: 8px; margin-top: 10px; margin-bottom: 20px; box-sizing: border-box; }
        button { background-color: #dc2626; color: white; padding: 10px 15px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; }
        a { color: #7d328c; text-decoration: none; margin-left: 15px; font-weight: bold; }
    </style>
</head>
<body>

<div class="card">
    <h2>Inativar Vendedor #<?php echo htmlspecialchars($id_vendedor); ?></h2>
    <form method="POST">
        <input type="hidden" name="id_vendedor" value="<?php echo htmlspecialchars($id_vendedor); ?>">
        
        <label for="motivo_inativo">Informe o motivo da inativação:</label>
        <input type="text" id="motivo_inativo" name="motivo_inativo" placeholder="Ex: Encerramento de conta, Mudança de ramo" required>

        <button type="submit">Confirmar Inativação</button>
        <a href="form_cad_vendedor.php">Cancelar</a>
    </form>
</div>

</body>
</html>