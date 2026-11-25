<?php
require_once __DIR__ . '/../conexao.php';
require_once __DIR__ . '/funcoes_clientes.php';

$id_cliente = $_GET['id'] ?? null;
$cliente = null;
$mensagem_erro = '';

if ($id_cliente) {
    try {
        // Busca os dados do cliente na base de dados bloobloo
        $stmt = $pdo->prepare("SELECT * FROM clientes WHERE id_cliente = ?");
        $stmt->execute([$id_cliente]);
        $cliente = $stmt->fetch();
    } catch (Exception $e) {
        $mensagem_erro = "Erro ao procurar cliente: " . $e->getMessage();
    }
}

// Processa a inativação após clicar no botão de confirmação
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar_inativacao'])) {
    try {
        $stmt = $pdo->prepare("UPDATE clientes SET ativo = 0 WHERE id_cliente = ?");
        $stmt->execute([$_POST['id_cliente']]);
        header("Location: cadastro_cliente.php");
        exit;
    } catch (Exception $e) {
        $mensagem_erro = "Erro ao inativar cliente: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Inativar Cliente - Bloomi</title>
    <link rel="stylesheet" href="../estilo.css">
</head>
<body>

<div class="page-wrapper">
    <!-- Header Padrão -->
    <div class="header-banner">
        <div class="logo-box">
            <h2>BLOOMI</h2>
            <span>Área do Cliente</span>
        </div>
        <div class="title-box">
            <h1>Gestão de Compradores</h1>
            <h2>Inativar Cliente</h2>
        </div>
    </div>

    <div class="form-container">
        <?php if (!empty($mensagem_erro)): ?>
            <div class="msg-erro"><?= htmlspecialchars($mensagem_erro) ?></div>
        <?php endif; ?>

        <?php if ($cliente): ?>
            <div class="section-header" style="background-color: #d93838;">Confirmação de Inativação</div>

            <div style="text-align: center; margin: 25px 0;">
                <p style="font-size: 1.1rem; color: #333; margin-bottom: 15px;">
                    Tem a certeza de que deseja inativar o cliente abaixo?
                </p>
                <div style="background-color: #fbf7f5; padding: 20px; border-radius: 12px; border: 1.5px solid #e0d0e3; display: inline-block; text-align: left; max-width: 450px; width: 100%;">
                    <p style="margin-bottom: 8px;"><strong>ID:</strong> #<?= $cliente['id_cliente'] ?></p>
                    <p style="margin-bottom: 8px;"><strong>Nome:</strong> <?= htmlspecialchars($cliente['nome_completo']) ?></p>
                    <p style="margin-bottom: 8px;"><strong>E-mail:</strong> <?= htmlspecialchars($cliente['email']) ?></p>
                    <p><strong>CPF/CNPJ:</strong> <?= htmlspecialchars($cliente['cpf_cnpj']) ?></p>
                </div>
            </div>

            <form action="inativar_cliente.php" method="POST">
                <input type="hidden" name="id_cliente" value="<?= $cliente['id_cliente'] ?>">

                <button type="submit" name="confirmar_inativacao" class="btn-submit" style="background-color: #d93838;">
                    Sim, Inativar Cliente
                </button>

                <div style="margin-top: 15px; text-align: center;">
                    <a href="cadastro_cliente.php" class="btn-secondary" style="display: inline-block; padding: 10px 20px; border-radius: 12px; text-decoration: none;">
                        Cancelar e Voltar
                    </a>
                </div>
            </form>
        <?php else: ?>
            <div class="msg-erro">Cliente não encontrado.</div>
            <div style="text-align: center; margin-top: 20px;">
                <a href="cadastro_cliente.php" class="btn-submit" style="text-decoration: none; display: inline-block; width: auto; padding: 10px 20px;">Voltar à Lista</a>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>