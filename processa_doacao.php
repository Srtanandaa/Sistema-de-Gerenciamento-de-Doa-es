<?php 
include 'conexao.php';

$nome = trim($_POST['nome']);
$sobrenome = trim($_POST['sobrenome']);
$email = trim($_POST['email']);
$item_id = $_POST['item_id'];

$nomeCompleto = trim($nome . ' ' . $sobrenome);


$verifica = $conn->prepare("SELECT * FROM doacoes WHERE email = ?");
$verifica->bind_param("s", $email);
$verifica->execute();
$resultado = $verifica->get_result();

if ($resultado->num_rows > 0) {
    header("Location: index.php?erro=email&email=" . urlencode($email));
    exit();
}


$verificaItem = $conn->prepare("SELECT COUNT(*) as total FROM doacoes WHERE item_id = ?");
$verificaItem->bind_param("i", $item_id);
$verificaItem->execute();
$res = $verificaItem->get_result();
$dados = $res->fetch_assoc();

$limite = $conn->prepare("SELECT limite, nome FROM itens WHERE id = ?");
$limite->bind_param("i", $item_id);
$limite->execute();
$resLimite = $limite->get_result();
$info = $resLimite->fetch_assoc();

if ($dados['total'] >= $info['limite']) {
    header("Location: index.php?erro=limite&item=" . urlencode($info['nome']));
    exit();
}


$stmt = $conn->prepare("INSERT INTO doacoes (nome_pessoa, email, item_id) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $nomeCompleto, $email, $item_id);
$stmt->execute();


$item_nome = $info['nome']; 

$assunto = "Confirmação da sua doação para a Festa Junina - Inove";
$mensagem = "Olá $nomeCompleto,\n\nMuito obrigado pela sua doação para a Festa Junina da INOVE!\n\nItem doado: $item_nome\n\nEquipe INOVE";

$headers = "From: teste.com.br\r\n";
$headers .= "Reply-To: teste.com.br\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

@mail($email, $assunto, $mensagem, $headers);


header("Location: index.php?sucesso=1");
exit();
?>
