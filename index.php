<?php include 'conexao.php'; ?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Doação Festa Junina - INOVE</title>

    
    <link href="https://fonts.googleapis.com/css2?family=Luckiest+Guy&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #17275b;
            font-family: Arial, sans-serif;
            color: white;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .bandeirinha {
            position: absolute;
            top: -40px;
            width: 55%;
            max-width: 700px;
            height: auto;
            z-index: 1;
        }

        .bandeirinha.esquerda {
            left: 0;
        }

        .bandeirinha.direita {
            right: 0;
            transform: scaleX(-1);
        }

        .fogueira {
            position: absolute;
            bottom: 15px;
            right: 30px;
            width: 120px;
            height: auto;
            z-index: 1;
        }

        .balao-esquerdo{
            position: absolute;
            top: 220px;
            left: 120px;
            width: 120px;
            height: auto;
            z-index: 1;
        }

                .bolinha {
        position: absolute;
        width: 8px;
        height: 8px;
        background-color: #e69500;
        border-radius: 50%;
        opacity: 0.7;
        z-index: 0; 
        pointer-events: none;
        }


        
        .balao-direito {
            position: absolute;
            top: 160px;
            right: 310px;
            width: 120px;;
            height: auto;
            z-index: 1;
        }

                .cacto {
            position: absolute;
            top: 360px;
            left: 300px;
            width: 180px;
            height: auto;
            z-index: 1;
            transform: rotate(20deg);
        }

        .violao {
            position: absolute;
            top: 450px;
            right: 300px;
            width: 110px;
            height: auto;
            z-index: 1;
        }

        .sanfona {
            position: absolute;
            bottom: 10px;
            left: 90px;
            width:220px;
            height: auto;
            z-index: 1;
            transform: rotate(10deg);
        }

        .milho {
            position: absolute;
            top: 280px;
            right: 120px;
            width: 100px;
            height: auto;
            z-index: 1;
        }

        .container {
            background-color: #1f5db4;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            z-index: 2;
            width: 90%;
            max-width: 400px;
            text-align: center;
            margin-top: 85px;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 40px;
            line-height: 1.2;
            font-family: 'Luckiest Guy', cursive;
            font-weight: 200; 
        }

        h2 span {
            display: block;
        }

            .nome-sobrenome {
        display: flex;
        gap: 10px;
    }

    .nome-sobrenome div {
        flex: 1;
    }

    .nome-sobrenome label {
        display: block;
        margin-top: 0;
        margin-bottom: 5px;
    }

    .nome-sobrenome input {
        width: 100%;
    }



        form label {
            display: block;
            text-align: left;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            box-sizing: border-box;
        }

        select {
            margin-top: 5px;
        }

        button {
            margin-top: 20px;
            padding: 12px;
            width: 100%;
            background-color: #f2a900;
            color: white;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #e69500;
        }

        .logo {
   
    width: 150px; 
    z-index: 3; 
    position: relative;
    margin-bottom: -3px;;
}



@media (max-width: 768px) {
    body {
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        overflow-x: hidden; 
        padding: 25px;
    }

    .container {
        
        max-width: 90%;
        width: 90%;
    }

    .bandeirinha{
        max-width: 50%;
        margin-top: 10%;
    }

    .violao {
    max-width: 23%;
    margin-top: 20%;
    }

    .balao-esquerdo, .balao-direito, .cacto, .milho{
        max-width: 25%;
        margin-bottom: 10%;
    }

    .sanfona{
        max-width: 35%; 
        margin-bottom: 20%;
        margin-left: 5%;

    }

    .fogueira {
        max-width: 25%; 
        margin-bottom: 20%;
    }

    .bolinha {
        display: none; 
    }
}

@media (max-width: 480px) {
    h2 {
        font-size: 28px;
    }

    .logo {
        width: 100px;
    }

    input, select, button {
        font-size: 14px;
        padding: 8px;
    }

    .container {
        padding: 20px;
    }
}



    </style>
</head>
<body>

        <?php if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1): ?>
    <script>
        alert("Obrigado pela doação!");
        window.history.replaceState({}, document.title, window.location.pathname);
    </script>
    <?php endif; ?>

    <?php if (isset($_GET['erro']) && $_GET['erro'] == 'email' && isset($_GET['email'])): ?>
    <?php
        $email = $_GET['email'];
        $sql = "SELECT i.nome AS item_nome FROM doacoes d JOIN itens i ON d.item_id = i.id WHERE d.email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        $itens = [];
        while ($row = $result->fetch_assoc()) {
            $itens[] = $row['item_nome'];
        }

        $itensDoacao = implode(", ", $itens);
    ?>
    <script>
        alert("Você já fez uma doação com esse e-mail.\nItens doados: <?php echo addslashes($itensDoacao); ?>");
    </script>
<?php endif; ?>


    <?php if (isset($_GET['erro']) && $_GET['erro'] == 'limite' && isset($_GET['item'])): ?>
    <script>
        alert("O limite de doações para o item '<?php echo urldecode($_GET['item']); ?>' foi atingido.");
    </script>
    <?php endif; ?>


    
    <img src="img/bandeirinhas.png" alt="Bandeirinhas" class="bandeirinha esquerda">
    <img src="img/bandeirinhas.png" alt="Bandeirinhas" class="bandeirinha direita">


    <img src="img/fogueira.png" alt="Fogueira" class="fogueira">
    <img src="img/balao.png" alt="Balão Esquerdo" class="balao-esquerdo">
    <img src="img/balao.png" alt="Balão Direito" class="balao-direito">
    <img src="img/sanfona.png" alt="Sanfona" class="sanfona">
    <img src="img/milho.png" alt="Milho" class="milho">
    <img src="img/cacto.png" alt="Cacto" class="cacto">
    <img src="img/violao.png" alt="Violão" class="violao">

         <!--Bolinhas esquerda-->
        <div class="bolinha" style="top: 50px; left: 100px;"></div>
        <div class="bolinha" style="top: 200px; left: 250px;"></div>
        <div class="bolinha" style="top: 350px; left: 50px;"></div>
        <div class="bolinha" style="top: 100px; left: 400px;"></div>
        <div class="bolinha" style="top: 150px; left: 500px;"></div>
        <div class="bolinha" style="top: 600px; left: 400px;"></div>
        <div class="bolinha" style="top: 800px; left: 650px;"></div>
        <div class="bolinha" style="top: 900px; left: 50px;"></div>
        <div class="bolinha" style="top: 120px; left: 300px;"></div>
        <div class="bolinha" style="top: 420px; left: 700px;"></div>
        <div class="bolinha" style="top: 80px; left: 30px;"></div>
        <div class="bolinha" style="top: 180px; left: 60px;"></div>
        <div class="bolinha" style="top: 300px; left: 90px;"></div>
        <div class="bolinha" style="top: 450px; left: 20px;"></div>
        <div class="bolinha" style="top: 550px; left: 100px;"></div>
        <div class="bolinha" style="top: 670px; left: 150px;"></div>
        <div class="bolinha" style="top: 750px; left: 200px;"></div>
        <div class="bolinha" style="top: 870px; left: 250px;"></div>
        <div class="bolinha" style="top: 920px; left: 50px;"></div>
        <div class="bolinha" style="top: 1000px; left: 140px;"></div>

       

       <div class="bolinha" style="top: 50px; left: 1340px;"></div>
        <div class="bolinha" style="top: 200px; left: 1190px;"></div>
        <div class="bolinha" style="top: 350px; left: 1390px;"></div>
        <div class="bolinha" style="top: 100px; left: 1040px;"></div>
        <div class="bolinha" style="top: 150px; left: 940px;"></div>
        <div class="bolinha" style="top: 600px; left: 1040px;"></div>
        <div class="bolinha" style="top: 800px; left: 790px;"></div>
        <div class="bolinha" style="top: 900px; left: 1390px;"></div>
        <div class="bolinha" style="top: 120px; left: 1140px;"></div>
        <div class="bolinha" style="top: 420px; left: 740px;"></div>
        <div class="bolinha" style="top: 80px; left: 1410px;"></div>
        <div class="bolinha" style="top: 180px; left: 1380px;"></div>
        <div class="bolinha" style="top: 300px; left: 1350px;"></div>
        <div class="bolinha" style="top: 450px; left: 1420px;"></div>
        <div class="bolinha" style="top: 550px; left: 1340px;"></div>
        <div class="bolinha" style="top: 670px; left: 1290px;"></div>
        <div class="bolinha" style="top: 750px; left: 1240px;"></div>
        <div class="bolinha" style="top: 870px; left: 1190px;"></div>
        <div class="bolinha" style="top: 920px; left: 1390px;"></div>
        <div class="bolinha" style="top: 1000px; left: 1300px;"></div>

    

    

    <div class="container">
        <img src="img/logo.png" alt="Logo Festa Julhina" class="logo">
        <h2>
            <span>Doação</span>
            <span>Festa Junina</span>
        </h2>

        <form action="processa_doacao.php" method="POST">

            <div class="nome-sobrenome">
    <div>
        <label>Nome:</label>
        <input type="text" name="nome" required>
    </div>
    <div>
        <label>Sobrenome:</label>
        <input type="text" name="sobrenome" required>
    </div>
</div>


            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Escolha o item para doar:</label>
            <select name="item_id">
                <?php
                $sql = "SELECT i.id, i.nome, i.limite, COUNT(d.id) AS total 
                        FROM itens i 
                        LEFT JOIN doacoes d ON i.id = d.item_id 
                        GROUP BY i.id";
                $result = $conn->query($sql);
                
                while($row = $result->fetch_assoc()) {
                    $disponivel = $row['limite'] - $row['total'];
                    if ($disponivel > 0) {
                        echo "<option value='{$row['id']}'>{$row['nome']} ({$disponivel} restante)</option>";
                    }
                }
                ?>
            </select>

            <button type="submit">Confirmar Doação</button>
        </form>
    </div>



</body>
</html>


