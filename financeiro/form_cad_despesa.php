<?php
require_once __DIR__ . '/../conexao.php';

$mensagem = '';$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao =$_POST['descricao'] ?? '';
    $categoria_custo =$_POST['categoria_custo'] ?? 'variavel';
    $valor = (float)($_POST['valor'] ?? 0);

    if (!empty($descricao) &&$valor > 0) {
        try {
            $stmt =$pdo->prepare("INSERT INTO fluxo_caixa (descricao, tipo, categoria_custo, valor, data_movimentacao) VALUES (?, 'saida', ?, ?, NOW())");
            $stmt->execute([$descricao,$categoria_custo, $valor]);$mensagem = "Despesa registrada com sucesso!";
        } catch (Exception $e) {$erro = "Erro ao registrar despesa: " . $e->getMessage();
        }
    } else {
        $erro = "Preencha todos os campos corretamente com um valor maior que zero.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Registrar Nova Despesa - Bloomi</title>
    <link rel="stylesheet" href="../estilo.css">
</head>
<body>

<div class="page-wrapper">
    <!-- Header Padrão -->
    <div class="header-banner">
        <div class="logo-box">
            <h2>BLOOMI</h2>
            <span>Área Financeira</span>
        </div>
        <div class="title-box">
            <h1>Gestão de Caixa</h1>
            <h2>Registrar Nova Saída</h2>
        </div>
    </div>

    <div class="form-container">
        <?php if (!empty($mensagem)): ?>
            <div class="msg-sucesso"><?= htmlspecialchars($mensagem) ?></div>
        <?php endif; ?>

        <?php if (!empty($erro)): ?>
            <div class="msg-erro"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <form action="form_cad_despesa.php" method="POST">
            <div class="section-header">Dados da Despesa / Custo</div>

            <div class="form-grid">
                <div class="col-12 form-group">
                    <label>Descrição da Despesa:</label>
                    <input type="text" name="descricao" placeholder="Ex: Compra de Embalagens, Aluguel, Energia" required>
                </div>

                <div class="col-6 form-group">
                    <label>Tipo de Custo:</label>
                    <select name="categoria_custo" required>
                        <option value="fixo">Custo Fixo (Aluguel, Luz, Internet)</option>
                        <option value="variavel" selected>Custo Variável (Matéria-prima, Embalagem)</option>
                    </select>
                </div>

                <div class="col-6 form-group">
                    <label>Valor (R$):</label>
                    <input type="number" step="0.01" name="valor" placeholder="0.00" required>
                </div>
            </div>

            <button type="submit" class="btn-submit">Salvar Saída</button>
            
            <div style="margin-top: 15px; text-align: center;">
                <a href="fluxo_caixa.php" class="btn-secondary" style="display: inline-block; padding: 10px 20px; border-radius: 12px; text-decoration: none;">Voltar ao Resumo Financeiro</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>