<?php include 'conexao.php'; ?>

<?php
session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel Administrativo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 20px;
            background-color: #f8f9fa;
            color: #333;
        }

        h2, h3 {
            color: #1a73e8;
            margin-top: 30px;
        }

        form {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            margin-top: 15px;
            font-weight: 600;
        }

        input[type="text"], select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        button, .btn-azul {
            background-color: #1a73e8;
            color: white;
            padding: 10px 16px;
            margin-top: 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            display: inline-block;
            width: 100%;
            text-align: center; width: auto;
            min-width: 100px;
            margin-right: 10px;
   
}
        

        button:hover, .btn-azul:hover {
            background-color: #0f5bd8;
        }

        .tabela-container {
            overflow-x: auto;
            max-height: 300px; 
            overflow-y: auto;
            border-radius: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            margin-top: 20px;
            min-width: 600px;
        }

        th, td {
            padding: 12px 16px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f1f3f4;
            font-weight: 600;
        }

        tr:hover {
            background-color: #f9fafb;
        }

        a {
            color: #1a73e8;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .filtros {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 10px;
        }

        .filtros input[type="text"],
        .filtros select {
            flex: 1 1 100%;
        }

        .export-link {
            display: inline-block;
            margin-top: 15px;
            background-color: #28a745;
            color: white;
            padding: 8px 14px;
            border-radius: 8px;
            text-decoration: none;
        }

        .export-link:hover {
            background-color: #218838;
        }

        @media (max-width: 600px) {
            body {
                margin: 10px;
                font-size: 16px;
            }

            h2, h3 {
                font-size: 18px;
            }

            .filtros {
                flex-direction: column;
            }

            input, select, button {
                font-size: 16px;
            }

            table {
                font-size: 14px;
            }

            .export-link {
                width: 100%;
                text-align: center;
            }
            button[type="submit"],
            .btn-azul {
            width: 100%;
            margin-right: 0;
            margin-top: 10px;
    }
        }
    </style>
</head>

<script>
function confirmarExclusao(id, elemento) {
    if (confirm('Tem certeza que deseja excluir este item?')) {
        fetch(`excluir_item.php?id=${id}`)
            .then(response => response.text())
            .then(data => {
                if (data.trim() === 'OK') {
                    alert('Item excluído com sucesso!');
                    const linha = elemento.closest('tr');
                    linha.remove();
                } else {
                    alert(data);
                }
            })
            .catch(error => {
                alert('Erro ao excluir o item.');
                console.error(error);
            });
    }
}
</script>

<body>

<h2>Painel Administrativo</h2>

<h3>Adicionar novo item</h3>
<form action="adicionar_item.php" method="POST">
    <label for="nome">Nome do item:</label>
    <input type="text" name="nome" required>

    <label for="limite">Limite:</label>
    <select name="limite" id="limite">
        <?php for ($i = 1; $i <= 10; $i++) {
            echo "<option value=\"$i\">$i</option>";
        } ?>
    </select>

    <button type="submit">Adicionar</button>
</form>

<h3>Itens da lista</h3>
<div class="tabela-container">
    <table>
        <tr><th>Item</th><th>Limite</th><th>Total Doações</th><th>Ações</th></tr>
        <?php
        $sql = "SELECT i.id, i.nome, i.limite, COUNT(d.id) AS total 
                FROM itens i 
                LEFT JOIN doacoes d ON i.id = d.item_id 
                GROUP BY i.id";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['nome']}</td>
                <td>{$row['limite']}</td>
                <td>{$row['total']}</td>
                <td>
                    <a href='editar_item.php?id={$row['id']}'>Editar</a> | 
                    <a href='#' onclick='confirmarExclusao({$row['id']}, this)'>Excluir</a>
                </td>
            </tr>";
        }
        ?>
    </table>
</div>

<h3>Filtrar doações</h3>
<form method="GET" class="filtros">
    <input type="text" name="busca" placeholder="Buscar por nome ou email" value="<?php echo htmlspecialchars($_GET['busca'] ?? '') ?>">

    <select name="item_filtro">
        <option value="">-- Filtrar por item --</option>
        <?php
        $itens = $conn->query("SELECT * FROM itens ORDER BY nome");
        while ($item = $itens->fetch_assoc()) {
            $selected = ($_GET['item_filtro'] ?? '') == $item['id'] ? 'selected' : '';
            echo "<option value='{$item['id']}' $selected>{$item['nome']}</option>";
        }
        ?>
    </select>

    <button type="submit">Buscar</button>
    <a href="admin.php" class="btn-azul">Remover Filtro</a>
</form>

<h3>Lista de Doadores</h3>
<div class="tabela-container">
    <table>
         <th>Nome</th>
            <th>Email</th>
            <th>Item</th>
            <th>Ações</th>
        <?php
        $busca = $_GET['busca'] ?? '';
        $item_filtro = $_GET['item_filtro'] ?? '';

        $where = "WHERE 1=1";
        $params = [];
        $tipos = "";

        if (!empty($busca)) {
            $where .= " AND (d.nome_pessoa LIKE ? OR d.email LIKE ?)";
            $params[] = "%$busca%";
            $params[] = "%$busca%";
            $tipos .= "ss";
        }

        if (!empty($item_filtro)) {
            $where .= " AND d.item_id = ?";
            $params[] = $item_filtro;
            $tipos .= "i";
        }

        $query = "SELECT d.nome_pessoa, d.email, i.nome AS item_nome 
                FROM doacoes d 
                JOIN itens i ON d.item_id = i.id 
                $where 
                ORDER BY d.nome_pessoa ASC";

        $stmt = $conn->prepare($query);
        if (!empty($params)) {
            $stmt->bind_param($tipos, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
        <td>" . htmlspecialchars($row['nome_pessoa']) . "</td>
        <td>" . htmlspecialchars($row['email']) . "</td>
        <td>" . htmlspecialchars($row['item_nome']) . "</td>
        <td>
            <a href='editar_doacao.php?email=" . urlencode($row['email']) . "'>Editar</a> | 
            <a href='#' onclick='confirmarExclusaoDoacao(\"" . addslashes($row['email']) . "\", this)'>Excluir</a>
        </td>
    </tr>";
        }
        ?>
    </table>
</div>

<script>
function confirmarExclusaoDoacao(email, elemento) {
    if (confirm('Tem certeza que deseja excluir esta doação?')) {
        fetch(`excluir_doacao.php?email=${encodeURIComponent(email)}`)
            .then(response => response.text())
            .then(data => {
                if (data.trim() === 'OK') {
                    alert('Doação excluída com sucesso!');
                    const linha = elemento.closest('tr');
                    linha.remove();
                } else {
                    alert(data);
                }
            })
            .catch(error => {
                alert('Erro ao excluir a doação.');
                console.error(error);
            });
    }
}
</script>

<a class="export-link" href="exportar_excel.php" target="_blank">📁 Exportar doações para Excel</a>


</body>
</html>

