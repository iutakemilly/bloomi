<?php
require_once __DIR__ . '/../conexao.php';
require_once __DIR__ . '/funcoes_produtos.php';

$categorias = $pdo->query("SELECT * FROM categorias_produtos ORDER BY nome_categoria")->fetchAll();
$vendedores = $pdo->query("SELECT * FROM vendedores WHERE ativo = 1 ORDER BY nome_empresa")->fetchAll();

$produto = [
    'id_produto' => '',
    'nome_produto' => '',
    'descricao' => '',
    'preco' => '',
    'custo_unitario' => '',
    'estoque' => '',
    'estoque_minimo' => 5,
    'id_vendedor' => '',
    'id_categoria' => ''
];

if (!empty($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id_produto = ?");
    $stmt->execute([$_GET['id']]);
    $dados = $stmt->fetch();
    if ($dados) {
        $produto = $dados;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Produto - Bloomi</title>
    <link rel="stylesheet" href="../estilo.css">
</head>
<body>

<div class="page-wrapper">
    <!-- Header Padrão -->
    <div class="header-banner">
        <div class="logo-box">
            <h2>BLOOMI</h2>
            <span>Gestão de Estoque</span>
        </div>
        <div class="title-box">
            <h1>Controle de Produtos</h1>
            <h2><?= !empty($produto['id_produto']) ? 'Editar Produto' : 'Novo Produto' ?></h2>
        </div>
    </div>

    <div class="form-container">
        <?php if (empty($vendedores)): ?>
            <div class="msg-erro">
                <strong>Atenção:</strong> Cadastre pelo menos um vendedor antes de cadastrar produtos.
            </div>
        <?php else: ?>
            <form action="cadastro_produto.php" method="POST">
                <input type="hidden" name="id_produto" value="<?= htmlspecialchars($produto['id_produto']) ?>">

                <div class="section-header">Informações do Produto</div>

                <div class="form-grid">
                    <div class="col-12 form-group">
                        <label>Nome do Produto:</label>
                        <input type="text" name="nome_produto" value="<?= htmlspecialchars($produto['nome_produto']) ?>" placeholder="Ex: Vela Aromática de Baunilha" required>
                    </div>

                    <div class="col-12 form-group">
                        <label>Descrição:</label>
                        <textarea name="descricao" rows="3" placeholder="Detalhes do produto..."><?= htmlspecialchars($produto['descricao']) ?></textarea>
                    </div>

                    <div class="col-6 form-group">
                        <label>Preço de Venda (R$):</label>
                        <input type="number" step="0.01" name="preco" value="<?= htmlspecialchars($produto['preco']) ?>" placeholder="0.00" required>
                    </div>

                    <div class="col-6 form-group">
                        <label>Custo Unitário (R$):</label>
                        <input type="number" step="0.01" name="custo_unitario" value="<?= htmlspecialchars($produto['custo_unitario']) ?>" placeholder="0.00">
                    </div>

                    <div class="col-6 form-group">
                        <label>Estoque Atual:</label>
                        <input type="number" name="estoque" value="<?= htmlspecialchars($produto['estoque']) ?>" placeholder="0" required>
                    </div>

                    <div class="col-6 form-group">
                        <label>Estoque Mínimo (Alerta):</label>
                        <input type="number" name="estoque_minimo" value="<?= htmlspecialchars($produto['estoque_minimo'] ?: 5) ?>">
                    </div>

                    <div class="col-6 form-group">
                        <label>Vendedor (Loja):</label>
                        <select name="id_vendedor" required>
                            <option value="">Selecione um vendedor</option>
                            <?php foreach ($vendedores as $v): ?>
                                <option value="<?= $v['id_vendedor'] ?>" <?= $produto['id_vendedor'] == $v['id_vendedor'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($v['nome_empresa']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-6 form-group">
                        <label>Categoria:</label>
                        <select name="id_categoria" required>
                            <option value="">Selecione uma categoria</option>
                            <?php foreach ($categorias as $c): ?>
                                <option value="<?= $c['id_categoria'] ?>" <?= $produto['id_categoria'] == $c['id_categoria'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($c['nome_categoria']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Salvar Produto</button>
                
                <div style="margin-top: 15px; text-align: center;">
                    <a href="cadastro_produto.php" class="btn-secondary" style="display: inline-block; padding: 10px 20px; border-radius: 12px; text-decoration: none;">Voltar à Lista</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

</body>
</html>