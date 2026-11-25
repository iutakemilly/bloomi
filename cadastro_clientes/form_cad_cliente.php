<?php require_once 'funcoes_clientes.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloomi - Cadastro de Clientes</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', sans-serif; }
        body { background-color: #fcf8f6; color: #333333; padding-bottom: 50px; }
        .page-wrapper { max-width: 950px; margin: 30px auto; background: #ffffff; box-shadow: 0 5px 20px rgba(125, 50, 140, 0.15); border-radius: 12px; overflow: hidden; border: 1px solid #f2e6ee; }
        .header-banner { display: flex; height: 140px; margin-bottom: 30px; }
        .logo-box { background-color: #7d328c; width: 30%; padding: 20px; display: flex; flex-direction: column; justify-content: center; align-items: center; color: white; border-bottom-right-radius: 35px; text-align: center; }
        .title-box { background-color: #f5efe9; width: 70%; padding: 20px 30px; display: flex; flex-direction: column; justify-content: center; border-bottom-left-radius: 35px; }
        .title-box h1 { font-size: 1.5rem; color: #521e5e; }
        .title-box h2 { font-size: 2rem; color: #7d328c; }
        .form-container { padding: 0 40px 30px 40px; }
        .section-header { background-color: #7d328c; color: white; text-align: center; padding: 10px; font-size: 1.15rem; font-weight: bold; border-radius: 12px; margin: 25px 0 20px 0; }
        .form-grid { display: grid; grid-template-columns: repeat(12, 1fr); gap: 15px; }
        .col-12 { grid-column: span 12; }
        .col-6 { grid-column: span 6; }
        .form-group { display: flex; flex-direction: column; }
        label { font-size: 0.9rem; font-weight: bold; color: #7d328c; margin-bottom: 6px; }
        input[type="text"], input[type="email"], input[type="date"], select { width: 100%; padding: 10px 15px; border: 1.5px solid #e5d5e2; border-radius: 12px; font-size: 0.95rem; outline: none; }
        input:focus, select:focus { border-color: #7d328c; box-shadow: 0 0 8px rgba(125, 50, 140, 0.25); }
        .btn-submit { background-color: #7d328c; color: white; font-size: 1.1rem; font-weight: bold; padding: 14px; border: none; border-radius: 12px; cursor: pointer; width: 100%; margin-top: 20px; }
        .btn-submit:hover { background-color: #6a2a77; }
        .table-section { padding: 0 40px 40px 40px; }
        .table-responsive { overflow-x: auto; border-radius: 12px; border: 1px solid #f2e6ee; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { background-color: #7d328c; color: white; padding: 12px 14px; font-size: 0.85rem; text-transform: uppercase; }
        td { padding: 12px 14px; border-bottom: 1px solid #f5efe9; font-size: 0.9rem; }
        tr:hover { background-color: #fcf8f6; }
        .btn-inativar { background-color: #ffffff; color: #dc2626; border: 1.5px solid #dc2626; padding: 4px 10px; text-decoration: none; border-radius: 6px; font-size: 0.8rem; font-weight: bold; }
        .btn-inativar:hover { background-color: #dc2626; color: white; }
    </style>
    <script>
        function alternarMotivo() {
            var statusSelect = document.getElementById("ativo");
            var campoMotivo = document.getElementById("campo_motivo");
            var inputMotivo = document.getElementById("motivo_inativo");
            if (statusSelect.value === "0") {
                campoMotivo.style.display = "block";
                inputMotivo.setAttribute("required", "required");
            } else {
                campoMotivo.style.display = "none";
                inputMotivo.removeAttribute("required");
                inputMotivo.value = "";
            }
        }
    </script>
</head>
<body>

<div class="page-wrapper">
    <div class="header-banner">
        <div class="logo-box"><h3>BLOOMI</h3><small>Área do Cliente</small></div>
        <div class="title-box"><h1>Gestão de Compradores</h1><h2>Cadastro de Cliente</h2></div>
    </div>

    <div class="form-container">
        <form action="cadastro_cliente.php" method="POST">
            <div class="section-header">Dados Pessoais e Contato</div>
            <div class="form-grid">
                <div class="form-group col-12">
                    <label for="nome_completo">Nome Completo:</label>
                    <input type="text" id="nome_completo" name="nome_completo" placeholder="Ex - Ana Maria Souza" required>
                </div>
                <div class="form-group col-6">
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" placeholder="ana@email.com" required>
                </div>
                <div class="form-group col-6">
                    <label for="telefone">Telefone / Celular:</label>
                    <input type="text" id="telefone" name="telefone" placeholder="(00) 00000-0000" required>
                </div>
                <div class="form-group col-6">
                    <label for="cpf_cnpj">CPF ou CNPJ:</label>
                    <input type="text" id="cpf_cnpj" name="cpf_cnpj" placeholder="000.000.000-00" required>
                </div>
                <div class="form-group col-6">
                    <label for="data_cadastro">Data do Cadastro:</label>
                    <input type="date" id="data_cadastro" name="data_cadastro" value="<?php echo date('Y-m-d'); ?>" required>
                </div>
                <div class="form-group col-12">
                    <label for="ativo">Status da Conta:</label>
                    <select id="ativo" name="ativo" onchange="alternarMotivo()" required>
                        <option value="1">Ativo</option>
                        <option value="0">Não Ativo</option>
                    </select>
                </div>
                <div class="form-group col-12" id="campo_motivo" style="display: none;">
                    <label for="motivo_inativo">Motivo da Inativação:</label>
                    <input type="text" id="motivo_inativo" name="motivo_inativo" placeholder="Informe o motivo do bloqueio ou inativação do cliente">
                </div>
            </div>
            <button type="submit" class="btn-submit">Cadastrar Cliente</button>
        </form>
    </div>

    <div class="table-section">
        <div class="section-header">Clientes Cadastrados</div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr><th>ID</th><th>Nome</th><th>E-mail</th><th>Telefone</th><th>CPF/CNPJ</th><th>Data</th><th>Status</th><th>Ações</th></tr>
                </thead>
                <tbody>
                    <?php
                    $conexao = getConexao();
                    $resultado = $conexao->query("SELECT * FROM clientes ORDER BY id_cliente DESC");
                    if ($resultado && $resultado->num_rows > 0) {
                        while ($linha = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td><strong>#" . $linha['id_cliente'] . "</strong></td>";
                            echo "<td>" . htmlspecialchars($linha['nome_completo']) . "</td>";
                            echo "<td>" . htmlspecialchars($linha['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($linha['telefone']) . "</td>";
                            echo "<td>" . htmlspecialchars($linha['cpf_cnpj']) . "</td>";
                            echo "<td>" . date('d/m/Y', strtotime($linha['data_cadastro'])) . "</td>";
                            if ($linha['ativo'] == 1) {
                                echo "<td><span style='color: #16a34a; font-weight: bold;'>Ativo</span></td>";
                                echo "<td><a class='btn-inativar' href='inativar_cliente.php?id=" . $linha['id_cliente'] . "'>Inativar</a></td>";
                            } else {
                                echo "<td><span style='color: #dc2626; font-weight: bold;'>Não Ativo</span><br><small>(" . htmlspecialchars($linha['motivo_inativo']) . ")</small></td>";
                                echo "<td>-</td>";
                            }
                            echo "</tr>";
                        }
                    } else { echo "<tr><td colspan='8' style='text-align: center;'>Nenhum cliente cadastrado.</td></tr>"; }
                    $conexao->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>