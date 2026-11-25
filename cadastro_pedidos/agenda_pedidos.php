<?php
require_once __DIR__ . '/../conexao.php';
require_once __DIR__ . '/funcoes_pedidos.php';

$pedidos = $pdo->query("SELECT p.*, c.nome_completo AS cliente 
                        FROM pedidos p 
                        JOIN clientes c ON p.id_cliente = c.id_cliente 
                        ORDER BY p.data_entrega ASC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Agenda de Pedidos - Bloomi</title>
    <link rel="stylesheet" href="../estilo.css">
</head>
<body>

<div class="page-wrapper">
    <div class="header-banner">
        <div class="logo-box">
            <h2>BLOOMI</h2>
            <span>Agenda Digital</span>
        </div>
        <div class="title-box">
            <h1>Acompanhamento de Encomendas</h1>
            <h2>Agenda de Pedidos</h2>
        </div>
    </div>

    <div class="table-section">
        <div style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
            <a href="form_cad_pedido.php" class="btn-submit" style="width: auto; text-decoration: none; padding: 10px 20px;">+ Novo Pedido</a>
        </div>

        <div class="section-header">Lista de Encomendas e Prazos</div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nº PEDIDO</th>
                        <th>CLIENTE</th>
                        <th>PRODUÇÃO</th>
                        <th>ENTREGA</th>
                        <th>STATUS</th>
                        <th>VALOR TOTAL</th>
                        <th>AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pedidos)): ?>
                        <tr>
                            <td colspan="7" style="text-align: center; color: #777;">Nenhum pedido registrado.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($pedidos as $p): ?>
                            <tr>
                                <td><strong>#<?= $p['id_pedido'] ?></strong></td>
                                <td><?= htmlspecialchars($p['cliente']) ?></td>
                                <td><?= date('d/m/Y', strtotime($p['data_producao'])) ?></td>
                                <td><?= date('d/m/Y', strtotime($p['data_entrega'])) ?></td>
                                <td>
                                    <span class="<?= $p['status'] === 'cancelado' ? 'status-inativo' : 'status-ativo' ?>">
                                        <?= strtoupper($p['status']) ?>
                                    </span>
                                </td>
                                <td>R$ <?= number_format($p['valor_total'], 2, ',', '.') ?></td>
                                <td>
                                    <?php if ($p['status'] !== 'cancelado'): ?>
                                        <a href="cancelar_pedido.php?id=<?= $p['id_pedido'] ?>" class="btn-inativar">Cancelar</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>