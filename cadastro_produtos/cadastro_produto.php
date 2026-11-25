<?php
require_once __DIR__ . '/funcoes_produtos.php';

$mensagem_erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        salvarProdutoAtualizado($pdo,$_POST);
        header("Location: cadastro_produto.php");
        exit;
    } catch (Exception $e) {$mensagem_erro = "Erro ao salvar produto: " . $e->getMessage();
    }
}

$produtos = listarProdutosComAlerta($pdo);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Produtos - Bloomi</title>
    <link rel="stylesheet" href="../estilo.css">
</head>
<body>

<div class="page-wrapper">
    <div class="header-banner">
        <div class="logo-box">
            <h2>BLOOMI</h2>
            <span>Gestão de Estoque</span>
        </div>
        <div class="title-box">
            <h1>Catálogo e Estoque</h1>
            <h2>Produtos Cadastrados</h2>
        </div>
    </div>

    <div class="table-section">
        <?php if (!empty($mensagem_erro)): ?>
            <div class="msg-erro"><?= htmlspecialchars($mensagem_erro) ?></div>
        <?php endif; ?>

        <div style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
            <a href="form_cad_produto.php" class="btn-submit" style="width: auto; text-decoration: none; padding: 10px 20px;">+ Novo Produto</a>
        </div>

        <div class="section-header">Estoque de Produtos</div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NOME</th>
                        <th>PREÇO</th>
                        <th>ESTOQUE</th>
                        <th>VENDEDOR</th>
                        <th>CATEGORIA</th>
                        <th>AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($produtos)): ?>
                        <tr>
                            <td colspan="7" style="text-align: center; color: #777;">Nenhum produto cadastrado.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($produtos as$p): ?>
                            <tr>
                                <td><strong>#<?= $p['id_produto'] ?></strong></td>
                                <td><?= htmlspecialchars($p['nome_produto']) ?></td>
                                <td>R$<?= number_format($p['preco'], 2, ',', '.') ?></td>
                                <td>
                                    <?= $p['estoque'] ?>
                                    <?= $p['estoque_baixo'] ? '<strong style="color: #d93838;">(Alerta!)</strong>' : '' ?>
                                </td>
                                <td><?= htmlspecialchars($p['nome_empresa']) ?></td>
                                <td><?= htmlspecialchars($p['nome_categoria']) ?></td>
                                <td>
                                    <a href="form_cad_produto.php?id=<?= $p['id_produto'] ?>" class="btn-secondary" style="padding: 4px 8px; border-radius: 6px; text-decoration: none; font-size: 0.8rem; font-weight: bold;">Editar</a>
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