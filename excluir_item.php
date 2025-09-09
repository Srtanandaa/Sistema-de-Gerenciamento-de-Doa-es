<?php
include 'conexao.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    
    $verifica = $conn->prepare("SELECT COUNT(*) AS total FROM doacoes WHERE item_id = ?");
    $verifica->bind_param("i", $id);
    $verifica->execute();
    $res = $verifica->get_result();
    $dados = $res->fetch_assoc();

    if ($dados['total'] > 0) {
        
        echo "Não é possível excluir este item porque já existem doações vinculadas.";
    } else {
      
        $stmt = $conn->prepare("DELETE FROM itens WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Item excluído com sucesso!";
        } else {
            echo "Ocorreu um erro ao excluir o item.";
        }
       
    }
} else {
    echo "Nenhum item foi selecionado para exclusão.";
    
}
?>
