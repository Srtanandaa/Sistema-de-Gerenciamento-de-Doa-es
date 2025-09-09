<?php
include 'conexao.php';


header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=doacoes_festa_junina.xls");
header("Pragma: no-cache");
header("Expires: 0");


$sql = "SELECT d.nome_pessoa, d.email, i.nome AS item 
        FROM doacoes d
        JOIN itens i ON d.item_id = i.id";
$result = $conn->query($sql);


echo "<table border='1'>";
echo "<tr>
        <th>Nome</th>
        <th>Email</th>
        <th>Item doado</th>
      </tr>";


while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>" . htmlspecialchars($row['nome_pessoa']) . "</td>
            <td>" . htmlspecialchars($row['email']) . "</td>
            <td>" . htmlspecialchars($row['item']) . "</td>
          </tr>";
}
echo "</table>";
?>
