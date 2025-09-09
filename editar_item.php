<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];
    $sql = "SELECT * FROM itens WHERE id = $id";
    $res = $conn->query($sql);
    $item = $res->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Item</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f4f8;
            margin: 0;
            padding: 0 15px;
            box-sizing: border-box;
        }

        .container {
            max-width: 500px;
            margin: 40px auto;
            background-color: #fff;
            padding: 25px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
            color: #022f5c;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.2s ease;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: #007bff;
            outline: none;
        }

        .botoes {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        button,
        .voltar-link {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            flex: 1;
            transition: background-color 0.2s ease;
        }

        button:hover,
        .voltar-link:hover {
            background-color: #0056b3;
        }

        @media (max-width: 600px) {
            body {
                padding: 0 10px;
            }

            .container {
                width: 100%;
                margin: 20px auto;
                padding: 20px;
            }

            .botoes {
                flex-direction: column;
            }

            button,
            .voltar-link {
                width: 100%;
                flex: none;
                padding: 14px 0;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Editar Item</h2>
    <form action="editar_item.php" method="POST">
        <input type="hidden" name="id" value="<?= $item['id'] ?>">

        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($item['nome']) ?>" required>

        <label for="limite">Limite:</label>
        <input type="number" name="limite" id="limite" value="<?= $item['limite'] ?>" required>

        <div class="botoes">
            <button type="submit">Salvar</button>
            <a href="admin.php" class="voltar-link">Voltar</a>
        </div>
    </form>
</div>

</body>
</html>

<?php
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $limite = $_POST['limite'];

    $stmt = $conn->prepare("UPDATE itens SET nome = ?, limite = ? WHERE id = ?");
    $stmt->bind_param("sii", $nome, $limite, $id);
    $stmt->execute();

    header("Location: admin.php");
    exit();
}
?>
