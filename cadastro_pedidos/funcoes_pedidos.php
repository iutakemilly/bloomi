<?php
require_once __DIR__ . '/../conexao.php';

function criarPedido($pdo, $dados) {
    try {
        $pdo->beginTransaction();

        // 1. Busca dados e preço do produto
        $stmtP = $pdo->prepare("SELECT preco, estoque FROM produtos WHERE id_produto = ?");
        $stmtP->execute([$dados['id_produto']]);
        $prod = $stmtP->fetch();

        if (!$prod) {
            throw new Exception("Produto não encontrado.");
        }

        $quantidade = (int)$dados['quantidade'];
        if ($prod['estoque'] < $quantidade) {
            throw new Exception("Estoque insuficiente. Disponível: " . $prod['estoque']);
        }

        $preco_unitario = !empty($dados['preco_unitario']) ? (float)$dados['preco_unitario'] : (float)$prod['preco'];
        $valor_total = $preco_unitario * $quantidade;

        // 2. Insere o Pedido Principal
        $sql = "INSERT INTO pedidos (id_cliente, id_vendedor, data_pedido, data_producao, data_entrega, status, forma_pagamento, valor_total, observacoes) 
                VALUES (?, ?, NOW(), ?, ?, 'em_producao', ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $dados['id_cliente'],
            $dados['id_vendedor'],
            $dados['data_producao'],
            $dados['data_entrega'],
            $dados['forma_pagamento'],
            $valor_total,
            $dados['observacoes'] ?? null
        ]);
        
        $id_pedido = $pdo->lastInsertId();

        // 3. Insere os Itens do Pedido
        $stmtItem = $pdo->prepare("INSERT INTO itens_pedido (id_pedido, id_produto, quantidade, preco_unitario) VALUES (?, ?, ?, ?)");
        $stmtItem->execute([$id_pedido, $dados['id_produto'], $quantidade, $preco_unitario]);

        // 4. Dá baixa no Estoque
        $stmtEst = $pdo->prepare("UPDATE produtos SET estoque = estoque - ? WHERE id_produto = ?");
        $stmtEst->execute([$quantidade, $dados['id_produto']]);

        // 5. Registra a Entrada no Fluxo de Caixa
        $stmtCaixa = $pdo->prepare("INSERT INTO fluxo_caixa (descricao, tipo, categoria_custo, valor) VALUES (?, 'entrada', 'venda', ?)");
        $stmtCaixa->execute(["Venda Pedido #$id_pedido", $valor_total]);

        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}