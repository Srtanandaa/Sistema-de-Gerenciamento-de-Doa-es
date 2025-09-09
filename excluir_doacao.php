<?php
include 'conexao.php';

if (isset($_GET['email'])) {
    $email = $_GET['email'];

    $stmt = $conn->prepare("DELETE FROM doacoes WHERE email = ?");
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        echo "OK";
    } else {
        echo "Erro ao excluir a doação.";
    }

    $stmt->close();
} else {
    echo "Parâmetro inválido.";
}
?>
