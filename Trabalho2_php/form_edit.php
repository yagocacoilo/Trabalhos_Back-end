<!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Editar</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php

        include("config.php");

        $id = (int) $_POST["id_para_ser_editado"];
        $tipo = $_POST["tipo"];

        if ($tipo == "cliente")
        {   $query = "SELECT id, nome FROM cliente WHERE id = $id";
            $resultado = mysqli_query($conexao, $query); 
            $row = mysqli_fetch_assoc($resultado); ?>
            <form action="atualizar_BD.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <input type='hidden' name='tipo' value='cliente'>
                
                <label>Nome:</label>
                <input type="text" name="nome" value="<?php echo $row['nome']; ?>" required><br><br>

                <input type="submit" value="Atualizar cliente">
            </form>
        <?php } ?>

        <?php
        if ($tipo == "pedido")
        {   $query = "SELECT id,produto, valor, data_pedido FROM pedido WHERE id = $id";
            $resultado = mysqli_query($conexao, $query);
            $row = mysqli_fetch_assoc($resultado); ?>
            <form action="atualizar_BD.php" method="POST">  
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <input type='hidden' name='tipo' value='pedido'>
                
                <label>Produto:</label>
                <input type="text" name="produto" value="<?php echo $row['produto']; ?>" required><br><br>

                <label>Preço:</label>
                <input type="number" name="valor" value="<?php echo $row['valor']; ?>" step="0.01" required><br><br>
                        
                <label>Data:</label>
                <input type="date" name="data_pedido" value="<?php echo $row['data_pedido']; ?>" required><br><br>

                <input type="submit" value="Atualizar pedido">
            </form>
        <?php } ?>
    </body>
</html>

