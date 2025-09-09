<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['email'])) {
    $email = $_GET['email'];
    $stmt = $conn->prepare("SELECT * FROM doacoes WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $doacao = $result->fetch_assoc();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email_antigo'])) {
    $nome = $_POST['nome'];
    $email_novo = $_POST['email'];
    $item_id = $_POST['item_id'];
    $email_antigo = $_POST['email_antigo'];

    $stmt = $conn->prepare("UPDATE doacoes SET nome_pessoa = ?, email = ?, item_id = ? WHERE email = ?");
    $stmt->bind_param("ssis", $nome, $email_novo, $item_id, $email_antigo);

    if ($stmt->execute()) {
        header("Location: admin.php");
        exit;
    } else {
        echo "Erro ao atualizar a doação.";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Editar Doação</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f4f8;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
            margin-top: 10%;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
        max-width: 400px;
        margin: 0 auto;
    }
    input[type="text"],
    select,
    button {
        width: 100%;
        padding: 12px 15px;
        margin-top: 8px;
        margin-bottom: 15px;
        box-sizing: border-box;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 16px;
    }
    button {
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
        font-weight: bold;
    }
    button:hover {
        background-color: #0056b3;
    }
        @media (max-width: 600px) {
            .container {
                margin: 20px;
                padding: 20px;
                margin-top: 30%;
            }

            h2 {
                font-size: 20px;
            }

            button {
                font-size: 14px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Editar Doação</h2>
    <form method="POST">
        <input type="hidden" name="email_antigo" value="<?php echo htmlspecialchars($doacao['email']); ?>">

        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($doacao['nome_pessoa']); ?>" required>

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($doacao['email']); ?>" required>

        <label for="item_id">Item:</label>
        <select id="item_id" name="item_id" required>
            <?php
            $itens = $conn->query("SELECT * FROM itens");
            while ($item = $itens->fetch_assoc()) {
                $selected = ($item['id'] == $doacao['item_id']) ? "selected" : "";
                echo "<option value='{$item['id']}' $selected>{$item['nome']}</option>";
            }
            ?>
        </select>

        <button type="submit">Salvar Alterações</button>
    </form>
</div>

</body>
</html>
