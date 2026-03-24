<!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Editar</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php

        include('config.php');

        $tipo = $_GET['tipo'];

        if($tipo == 'cliente')
        {   ?>
            <form action="salvar.php?tipo=cliente" method="POST">
                <label>Nome:</label>
                <input type="text" name="nome" value="" required><br><br>

                <input type="submit" value="Cadastrar cliente">
            </form>
            <?php
        }

        if($tipo == 'pedido')
        {   ?>
            <form action="salvar.php?tipo=pedido" method="POST">
                <label>Cliente:</label>
                <input list="clientes" name="cliente_nome" required>
                <datalist id="clientes">
                    <?php
                    $query = "SELECT * FROM cliente";
                    $resultado = mysqli_query($conexao, $query);
                    while ($row = mysqli_fetch_assoc($resultado)) {
                    echo "<option value='" . $row["nome"] . "'></option>";
                    }
                    ?>
                </datalist> 
                
                <label>Produto:</label>
                <input type="text" name="produto" value="" required><br><br>

                <label>Valor:</label>
                <input type="number" name="valor" value="" step="0.01" required><br><br>
                        
                <label>Data:</label>
                <input type="date" name="data_pedido" value="" required><br><br>

                <input type="submit" value="Cadastrar pedido">
            </form>
            <?php
        }
        ?>
    </body>
</html>