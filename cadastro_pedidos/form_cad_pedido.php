<?php
require_once __DIR__ . '/../conexao.php';
require_once __DIR__ . '/funcoes_pedidos.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        criarPedido($pdo, $_POST);
        header("Location: agenda_pedidos.php");
        exit;
    } catch (Exception $e) {
        $erro = "Erro ao registrar pedido: " . $e->getMessage();
    }
}

$clientes = $pdo->query("SELECT * FROM clientes WHERE ativo = 1 ORDER BY nome_completo")->fetchAll();
$vendedores = $pdo->query("SELECT * FROM vendedores WHERE ativo = 1 ORDER BY nome_empresa")->fetchAll();
$produtos = $pdo->query("SELECT * FROM produtos WHERE ativo = 1 AND estoque > 0 ORDER BY nome_produto")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Novo Pedido - Bloomi</title>
    <link rel="stylesheet" href="../estilo.css">
</head>
<body>

<div class="page-wrapper">
    <!-- Header Padrão -->
    <div class="header-banner">
        <div class="logo-box">
            <h2>BLOOMI</h2>
            <span>Agenda Digital</span>
        </div>
        <div class="title-box">
            <h1>Vendas e Encomendas</h1>
            <h2>Registrar Novo Pedido</h2>
        </div>
    </div>

    <div class="form-container">
        <?php if (!empty($erro)): ?>
            <div class="msg-erro"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <form action="form_cad_pedido.php" method="POST">
            <div class="section-header">Dados da Compra e Agendamento</div>

            <div class="form-grid">
                <div class="col-6 form-group">
                    <label>Cliente:</label>
                    <select name="id_cliente" required>
                        <option value="">Selecione o Cliente</option>
                        <?php foreach ($clientes as $c): ?>
                            <option value="<?= $c['id_cliente'] ?>"><?= htmlspecialchars($c['nome_completo']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-6 form-group">
                    <label>Vendedor / Loja:</label>
                    <select name="id_vendedor" required>
                        <option value="">Selecione o Vendedor</option>
                        <?php foreach ($vendedores as $v): ?>
                            <option value="<?= $v['id_vendedor'] ?>"><?= htmlspecialchars($v['nome_empresa']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-12 form-group">
                    <label>Produto:</label>
                    <select name="id_produto" required>
                        <option value="">Selecione o Produto</option>
                        <?php foreach ($produtos as $p): ?>
                            <option value="<?= $p['id_produto'] ?>">
                                <?= htmlspecialchars($p['nome_produto']) ?> (Estoque: <?= $p['estoque'] ?> - R$ <?= number_format($p['preco'], 2, ',', '.') ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-6 form-group">
                    <label>Quantidade:</label>
                    <input type="number" name="quantidade" min="1" value="1" required>
                </div>

                <div class="col-6 form-group">
                    <label>Preço Unitário (R$):</label>
                    <input type="number" step="0.01" name="preco_unitario" placeholder="Opcional (Usa preço padrão se vazio)">
                </div>

                <div class="col-6 form-group">
                    <label>Data de Produção:</label>
                    <input type="date" name="data_producao" value="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="col-6 form-group">
                    <label>Data de Entrega:</label>
                    <input type="date" name="data_entrega" required>
                </div>

                <div class="col-12 form-group">
                    <label>Forma de Pagamento:</label>
                    <select name="forma_pagamento" required>
                        <option value="Pix">Pix</option>
                        <option value="Cartão de Crédito">Cartão de Crédito</option>
                        <option value="Boleto">Boleto</option>
                        <option value="Dinheiro">Dinheiro</option>
                    </select>
                </div>

                <div class="col-12 form-group">
                    <label>Observações:</label>
                    <textarea name="observacoes" rows="3" placeholder="Observações sobre personalização ou entrega..."></textarea>
                </div>
            </div>

            <button type="submit" class="btn-submit">Finalizar Pedido</button>

            <div style="margin-top: 15px; text-align: center;">
                <a href="agenda_pedidos.php" class="btn-secondary" style="display: inline-block; padding: 10px 20px; border-radius: 12px; text-decoration: none;">Voltar à Agenda</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>