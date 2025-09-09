<?php
include 'conexao.php';

$nome = $_POST['nome'];
$limite = $_POST['limite'];

$stmt = $conn->prepare("INSERT INTO itens (nome, limite) VALUES (?, ?)");
$stmt->bind_param("si", $nome, $limite);
$stmt->execute();

header("Location: admin.php");
exit();
?>
