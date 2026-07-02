<?php
    include('config.php');

    $ordem = "";
    $pesquisa = "";
    $valor_min = null;

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {   if (isset($_POST["opcoes"])) 
        {   $ordem = $_POST["opcoes"];
        }

        if (isset($_POST["pesquisa"]))
        {   $pesquisa = $_POST["pesquisa"];
        }

        if (isset($_POST["valor_min"]) && $_POST["valor_min"] !== "")
        {   $valor_min = floatval($_POST["valor_min"]);
        }
    }

    $query = "
    SELECT * 
    FROM cliente 
    LEFT JOIN pedido ON cliente.id = pedido.cliente_id
    WHERE 1=1
    ";

    if (!empty($pesquisa)) 
    {   $query .= "
        AND (
            cliente.nome LIKE '%$pesquisa%' OR
            pedido.produto LIKE '%$pesquisa%' OR
            pedido.valor LIKE '%$pesquisa%' OR
            pedido.data_pedido LIKE '%$pesquisa%'
        )
        ";
    }

    if (!is_null($valor_min)) 
    {   $query .= " AND (pedido.valor >= $valor_min OR pedido.valor IS NULL)";
    }

    $colunas = ["nome", "produto", "valor", "data_pedido"];

    if (in_array($ordem, $colunas)) 
    {   $query .= " ORDER BY $ordem";
    }
?>

<!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body class="home">
        <form method="POST">
            <input type="hidden" name="pesquisa" value="<?php echo $pesquisa; ?>">
            <input type="hidden" name="valor_min" value="<?php echo $valor_min; ?>">
            <select name="opcoes">
                <option value="nome">Nome</option>
                <option value="produto">Produto</option>
                <option value="valor">Valor</option>
                <option value="data_pedido">Data</option>
            </select>
            <button type="submit">Ordenar</button>
        </form>

        <form method="POST">
            <input type="hidden" name="opcoes" value="<?php echo $ordem; ?>">
            <input type="hidden" name="valor_min" value="<?php echo $valor_min; ?>">
            <input type="text" name="pesquisa" placeholder="Pesquisar...">
            <button type="submit">Pesquisar</button>
        </form>

        <form method="POST">
            <input type="hidden" name="opcoes" value="<?php echo $ordem; ?>">
            <input type="hidden" name="pesquisa" value="<?php echo $pesquisa; ?>">
            <label>Valor mínimo do pedido:</label>
            <input type="number" name="valor_min" step="0.01" placeholder="Ex: R$ 100,00">
            <button type="submit">Pesquisar</button>
        </form>

        <form method="POST">
            <input type="hidden" name="nome" value="">
            <input type="hidden" name="opcoes" value="">
            <input type="hidden" name="valor_min" value="">
            <button type="submit">Limpar</button>
        </form>

        <a href="clientes.php">Clientes</a>
        <a href="pedidos.php">Pedidos</a>
        <a href="adicionar.php?tipo=cliente">Adicionar cliente</a>
        <a href="adicionar.php?tipo=pedido">Adicionar pedido</a>

        <table border='1'>
            <tr>
            <th>Nome</th>
            <th>Produto</th>
            <th>Valor</th>
            <th>Data</th>
            </tr>
            <?php

                $resultado = mysqli_query($conexao, $query);

                while ($row = mysqli_fetch_assoc($resultado)) 
                {   $data = !empty($row["data_pedido"])
                    ? (new DateTime($row["data_pedido"]))->format("d/m/Y")
                    : '';

                    $valor = isset($row["valor"])
                    ? "R$ " . number_format((float)$row["valor"], 2, ',', '.')
                    : '';
                    echo     
                    "<tr>
                        <td>" . $row["nome"] . "</td>  
                        <td>" . $row["produto"] . "</td>  
                        <td>" . $valor . "</td>  
                        <td>" . $data . "</td>" .  
                    "</tr>";
                }
                echo "<br>";
            ?>
        </table>
    </body>
</html>