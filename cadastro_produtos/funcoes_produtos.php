<?php
require_once __DIR__ . '/../conexao.php';

function listarProdutosComAlerta($pdo) {
    $sql = "SELECT p.*, v.nome_empresa, c.nome_categoria,
                   (p.estoque <= p.estoque_minimo) AS estoque_baixo
            FROM produtos p
            INNER JOIN vendedores v ON p.id_vendedor = v.id_vendedor
            INNER JOIN categorias_produtos c ON p.id_categoria = c.id_categoria
            ORDER BY p.id_produto DESC";
    return $pdo->query($sql)->fetchAll();
}

function salvarProdutoAtualizado($pdo, $dados) {
    if (!empty($dados['id_produto'])) {
        $sql = "UPDATE produtos 
                SET nome_produto = ?, descricao = ?, preco = ?, custo_unitario = ?, 
                    estoque = ?, estoque_minimo = ?, id_vendedor = ?, id_categoria = ?
                WHERE id_produto = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            $dados['nome_produto'], 
            $dados['descricao'], 
            $dados['preco'], 
            $dados['custo_unitario'],
            $dados['estoque'], 
            $dados['estoque_minimo'], 
            $dados['id_vendedor'], 
            $dados['id_categoria'], 
            $dados['id_produto']
        ]);
    } else {
        $sql = "INSERT INTO produtos (nome_produto, descricao, preco, custo_unitario, estoque, estoque_minimo, id_vendedor, id_categoria, data_cadastro, ativo) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, CURDATE(), 1)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            $dados['nome_produto'], 
            $dados['descricao'], 
            $dados['preco'], 
            $dados['custo_unitario'],
            $dados['estoque'], 
            $dados['estoque_minimo'], 
            $dados['id_vendedor'], 
            $dados['id_categoria']
        ]);
    }
}