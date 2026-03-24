<?php 

    include('config.php');

    $ordem = "";
    $pesquisa = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {   if (isset($_POST["opcoes"]))
        {   $ordem = $_POST["opcoes"];
        }

        if (isset($_POST["pesquisa"])) 
        {   $pesquisa = $_POST["pesquisa"];
        }
    }

    $query = "
    SELECT * 
    FROM pedido
    WHERE 1=1
    ";

    if (!empty($pesquisa))
    {   $query .= "
        AND (
            pedido.produto LIKE '%$pesquisa%' OR
            pedido.valor LIKE '%$pesquisa%' OR
            pedido.data_pedido LIKE '%$pesquisa%'
        )
        ";
    }

    $colunas = ["produto", "valor", "data_pedido"];

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
    <body class="pedidos">
        <form method="POST">
            <input type="hidden" name="pesquisa" value="<?php echo $pesquisa; ?>">
            <select name="opcoes">
                <option value="produto">Produto</option>
                <option value="valor">Valor</option>
                <option value="data_pedido">Data</option>
            </select>
            <button type="submit">Ordenar</button>
        </form>

        <br>

        <form method="POST">
            <input type="hidden" name="opcoes" value="<?php echo $ordem; ?>">
            <input type="text" name="pesquisa" placeholder="Pesquisar...">
            <button type="submit">Pesquisar</button>
        </form>

        <form method="POST">
            <input type="hidden" name="nome" value="">
            <input type="hidden" name="opcoes" value="">
            <button type="submit">Limpar</button>
        </form>

        <a href="home.php">Home</a>

        <table border='1'>
            <tr>
            <th>Produto</th>
            <th>Valor</th>
            <th>Data</th>
            <th>Editar</th>
            <th>Excluir</th>
            </tr>
            <?php
                $resultado = mysqli_query($conexao, $query);

                while ($row = mysqli_fetch_assoc($resultado)) {
                $data = new DateTime($row["data_pedido"])->format("d/m/Y");
                $valor = "R$ " . number_format($row["valor"], 2, ',', '.');
                echo     
                "<tr>
                        <td>" . $row["produto"] . "</td>  
                        <td>" . $valor . "</td>  
                        <td>" . $data . "</td>" .
                        "<td> 
                            <form action='remover.php' method='POST'>
                                <input type='hidden' name='tipo' value='pedido'>
                                <input type='hidden' name='id_para_ser_removido' value='" . $row["id"] . "'>
                                <input type='submit' value='Remover'>
                            </form>      
                        </td>" .
                        "<td>            
                            <form action='form_edit.php' method='POST'>
                                <input type='hidden' name='tipo' value='pedido'>
                                <input type='hidden' name='id_para_ser_editado' value='" . $row["id"] . "'>
                                <input type='submit' value='Editar'>
                            </form>
                        </td>" .     
                "</tr>";
                }
                echo "<br>";
            ?>
        </table>
    </body>
</html>