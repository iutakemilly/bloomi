<?php
require_once __DIR__ . '/../conexao.php';

try {
    $stmtEntradas = $pdo->query("SELECT COALESCE(SUM(valor), 0) AS total FROM fluxo_caixa WHERE tipo = 'entrada'");
    $entradas = (float)$stmtEntradas->fetch()['total'];

    $stmtSaidas = $pdo->query("SELECT COALESCE(SUM(valor), 0) AS total FROM fluxo_caixa WHERE tipo = 'saida'");
    $saidas = (float)$stmtSaidas->fetch()['total'];

    $lucro_prejuizo = $entradas - $saidas;
    $movimentacoes = $pdo->query("SELECT * FROM fluxo_caixa ORDER BY data_movimentacao DESC")->fetchAll();
} catch (Exception $e) {
    die("Erro ao carregar o fluxo de caixa: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Resumo Financeiro - Bloomi</title>
    <link rel="stylesheet" href="../estilo.css">
</head>
<body>

<div class="page-wrapper">
    <!-- Header Padrão da Identidade Visual -->
    <div class="header-banner">
        <div class="logo-box">
            <h2>BLOOMI</h2>
            <span>Área Financeira</span>
        </div>
        <div class="title-box">
            <h1>Gestão de Caixa</h1>
            <h2>Resumo Financeiro</h2>
        </div>
    </div>

    <div class="form-container">
        
        <!-- Botão para Cadastrar Nova Saída -->
        <div style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
            <a href="form_cad_despesa.php" class="btn-inativar" style="font-size: 0.95rem; padding: 10px 18px;">
                + Nova Saída (Despesa)
            </a>
        </div>

        <div class="section-header">Balanço Geral</div>

        <!-- Cards dos Totais Financeiros -->
        <div class="cards-financeiros">
            <div class="card-fin card-entrada">
                <span>TOTAL ENTRADAS</span>
                <h3>R$ <?= number_format($entradas, 2, ',', '.') ?></h3>
            </div>
            
            <div class="card-fin card-saida">
                <span>TOTAL SAÍDAS</span>
                <h3>R$ <?= number_format($saidas, 2, ',', '.') ?></h3>
            </div>
            
            <div class="card-fin <?= $lucro_prejuizo >= 0 ? 'card-lucro' : 'card-saida' ?>">
                <span>RESULTADO</span>
                <h3>R$ <?= number_format($lucro_prejuizo, 2, ',', '.') ?></h3>
            </div>
        </div>

        <!-- Tabela do Histórico de Movimentações -->
        <div class="section-header" style="margin-top: 35px;">Histórico de Movimentações</div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>DESCRIÇÃO</th>
                        <th>TIPO</th>
                        <th>CATEGORIA</th>
                        <th>VALOR</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($movimentacoes)): ?>
                        <tr>
                            <td colspan="5" style="text-align: center; color: #777;">Nenhuma movimentação registrada.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($movimentacoes as $m): ?>
                            <tr>
                                <td><strong>#<?= $m['id_movimentacao'] ?></strong></td>
                                <td><?= htmlspecialchars($m['descricao']) ?></td>
                                <td>
                                    <span class="<?= $m['tipo'] === 'entrada' ? 'status-ativo' : 'status-inativo' ?>">
                                        <?= strtoupper($m['tipo']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($m['categoria_custo']) ?></td>
                                <td><strong>R$ <?= number_format($m['valor'], 2, ',', '.') ?></strong></td>
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