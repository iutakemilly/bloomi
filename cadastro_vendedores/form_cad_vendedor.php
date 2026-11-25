<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'funcoes_vendedores.php'; 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bloomi - Cadastro de Vendedor</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #fcf8f6;
            color: #333333;
            padding-bottom: 50px;
        }

        .page-wrapper {
            max-width: 950px;
            margin: 30px auto;
            background: #ffffff;
            box-shadow: 0 5px 20px rgba(125, 50, 140, 0.15);
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
            overflow: hidden;
            border: 1px solid #f2e6ee;
        }

        .header-banner {
            display: flex;
            align-items: stretch;
            height: 140px;
            margin-bottom: 30px;
        }

        .logo-box {
            background-color: #7d328c;
            width: 30%;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #ffffff;
            border-bottom-right-radius: 35px;
            text-align: center;
        }

        .logo-box h3 {
            font-size: 1.4rem;
            font-weight: bold;
            letter-spacing: 1px;
            color: #ffffff;
        }

        .logo-box small {
            font-size: 0.8rem;
            color: #f5efe9;
        }

        .title-box {
            background-color: #f5efe9;
            width: 70%;
            padding: 20px 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-bottom-left-radius: 35px;
        }

        .title-box h1 {
            font-size: 1.5rem;
            font-weight: 400;
            color: #521e5e;
        }

        .title-box h2 {
            font-size: 2rem;
            font-weight: 800;
            border: none;
            color: #7d328c;
            margin: 0;
        }

        .form-container {
            padding: 0 40px 30px 40px;
        }

        .section-header {
            background-color: #7d328c;
            color: #ffffff;
            text-align: center;
            padding: 10px;
            font-size: 1.15rem;
            font-weight: bold;
            border-radius: 12px;
            margin: 25px 0 20px 0;
            letter-spacing: 0.5px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 15px;
        }

        .col-12 { grid-column: span 12; }
        .col-6  { grid-column: span 6; }

        @media (max-width: 768px) {
            .col-6 { grid-column: span 12; }
            .header-banner { flex-direction: column; height: auto; }
            .logo-box, .title-box { width: 100%; border-radius: 0; }
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 0.9rem;
            font-weight: bold;
            color: #7d328c;
            margin-bottom: 6px;
        }

        input[type="text"], 
        input[type="email"], 
        select {
            width: 100%;
            padding: 10px 15px;
            border: 1.5px solid #e5d5e2;
            border-radius: 12px;
            background-color: #ffffff;
            font-size: 0.95rem;
            color: #333333;
            outline: none;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus, 
        input[type="email"]:focus, 
        select:focus {
            border-color: #7d328c;
            box-shadow: 0 0 8px rgba(125, 50, 140, 0.25);
        }

        .btn-submit {
            background-color: #7d328c;
            color: #ffffff;
            font-size: 1.1rem;
            font-weight: bold;
            padding: 14px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 10px rgba(125, 50, 140, 0.3);
        }

        .btn-submit:hover {
            background-color: #6a2a77;
            transform: translateY(-2px);
        }

        .table-section {
            padding: 0 40px 40px 40px;
        }

        .table-responsive {
            overflow-x: auto;
            border-radius: 12px;
            border: 1px solid #f2e6ee;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background-color: #7d328c;
            color: #ffffff;
            padding: 12px 14px;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 12px 14px;
            border-bottom: 1px solid #f5efe9;
            font-size: 0.9rem;
            color: #444444;
        }

        tr:hover {
            background-color: #fcf8f6;
        }

        .btn-inativar {
            background-color: #ffffff;
            color: #dc2626;
            border: 1.5px solid #dc2626;
            padding: 4px 10px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: bold;
            transition: all 0.2s ease;
        }

        .btn-inativar:hover {
            background-color: #dc2626;
            color: #ffffff;
        }

        .footer-bar {
            height: 15px;
            background-color: #7d328c;
            margin-top: 30px;
        }
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
        <div class="logo-box">
            <h3>BLOOMI</h3>
            <small>Área do Vendedor</small>
        </div>
        <div class="title-box">
            <h1>Cadastre sua Loja no Bloomi</h1>
            <h2>Cadastro de Vendedor</h2>
        </div>
    </div>

    <div class="form-container">
        <form action="cadastro_vendedor.php" method="POST">
            
            <div class="section-header">
                Informações da Empresa / Loja
            </div>

            <div class="form-grid">
                <div class="form-group col-12">
                    <label for="nome_empresa">Nome da Empresa / Razão Social:</label>
                    <input type="text" id="nome_empresa" name="nome_empresa" placeholder="Ex - Bloomi Modas LTDA" required>
                </div>

                <div class="form-group col-6">
                    <label for="cnpj">CNPJ:</label>
                    <input type="text" id="cnpj" name="cnpj" placeholder="00.000.000/0001-00" required>
                </div>

                <div class="form-group col-6">
                    <label for="nome_responsavel">Nome do Responsável:</label>
                    <input type="text" id="nome_responsavel" name="nome_responsavel" placeholder="Ex - Carlos Silva" required>
                </div>
            </div>

            <div class="section-header">
                Produtos e Contato
            </div>

            <div class="form-grid">
                <div class="form-group col-6">
                    <label for="email">E-mail Comercial:</label>
                    <input type="email" id="email" name="email" placeholder="loja@bloomi.com.br" required>
                </div>

                <div class="form-group col-6">
                    <label for="telefone">Telefone / WhatsApp:</label>
                    <input type="text" id="telefone" name="telefone" placeholder="(00) 00000-0000" required>
                </div>

                <div class="form-group col-6">
                    <label for="id_categoria">Tipo de Produto Vendido:</label>
                    <select id="id_categoria" name="id_categoria" required>
                        <option value="">Selecione a Categoria Principal</option>
                        <?php echo listarCategorias(); ?>
                    </select>
                </div>

                <div class="form-group col-6">
                    <label for="ativo">Status da Conta:</label>
                    <select id="ativo" name="ativo" onchange="alternarMotivo()" required>
                        <option value="1">Ativo</option>
                        <option value="0">Não Ativo</option>
                    </select>
                </div>

                <div class="form-group col-12" id="campo_motivo" style="display: none;">
                    <label for="motivo_inativo">Motivo da Inativação:</label>
                    <input type="text" id="motivo_inativo" name="motivo_inativo" placeholder="Informe o motivo da inativação">
                </div>
            </div>

            <button type="submit" class="btn-submit">Cadastrar Vendedor</button>
        </form>
    </div>

    <div class="table-section">
        <div class="section-header">
            Vendedores Cadastrados no Bloomi
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID Único</th>
                        <th>Empresa</th>
                        <th>CNPJ</th>
                        <th>Responsável</th>
                        <th>Categoria do Produto</th>
                        <th>Contato</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $conexao = getConexao();
                    $sql = "SELECT v.id_vendedor, v.nome_empresa, v.cnpj, v.nome_responsavel, v.email, v.telefone, 
                                   v.ativo, v.motivo_inativo, c.nome_categoria
                            FROM vendedores v
                            INNER JOIN categorias_produtos c ON v.id_categoria = c.id_categoria
                            ORDER BY v.id_vendedor DESC";
                    
                    $resultado = $conexao->query($sql);

                    if ($resultado && $resultado->num_rows > 0) {
                        while ($linha = $resultado->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td><strong>#" . $linha['id_vendedor'] . "</strong></td>";
                            echo "<td>" . htmlspecialchars($linha['nome_empresa']) . "</td>";
                            echo "<td>" . htmlspecialchars($linha['cnpj']) . "</td>";
                            echo "<td>" . htmlspecialchars($linha['nome_responsavel']) . "</td>";
                            echo "<td>" . htmlspecialchars($linha['nome_categoria']) . "</td>";
                            echo "<td>" . htmlspecialchars($linha['email']) . "<br><small>" . htmlspecialchars($linha['telefone']) . "</small></td>";
                            
                            if ($linha['ativo'] == 1) {
                                echo "<td><span style='color: #16a34a; font-weight: bold;'>Ativo</span></td>";
                                echo "<td><a class='btn-inativar' href='inativar_vendedor.php?id=" . $linha['id_vendedor'] . "'>Inativar</a></td>";
                            } else {
                                echo "<td><span style='color: #dc2626; font-weight: bold;'>Não Ativo</span><br><small>(" . htmlspecialchars($linha['motivo_inativo']) . ")</small></td>";
                                echo "<td>-</td>";
                            }
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' style='text-align: center;'>Nenhum vendedor cadastrado.</td></tr>";
                    }
                    $conexao->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="footer-bar"></div>
</div>

</body>
</html>