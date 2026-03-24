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
    FROM cliente 
    WHERE 1=1
    ";

    if (!empty($pesquisa))
    {   $query .= "
        AND cliente.nome LIKE '%$pesquisa%' 
        ";
    }

    $colunas = ["id", "nome"];

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
    <body>
        <form method="POST">
            <input type="hidden" name="pesquisa" value="<?php echo $pesquisa; ?>">
            <select name="opcoes">
                <option value="id">Id</option>
                <option value="nome">Nome</option>
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
            <input type="hidden" name="pesquisa" value="">
            <input type="hidden" name="opcoes" value="">
            <button type="submit">Limpar</button>
        </form>

        <a href="home.php">Home</a>

        <table border='1'>
            <tr>
            <th>id</th>
            <th>Nome</th>
            <th>Editar</th>
            <th>Excluir</th>
            </tr>
            <?php
            
                $resultado = mysqli_query($conexao, $query);

                while ($row = mysqli_fetch_assoc($resultado))
                {   echo     
                    "<tr>
                        <td>" . $row["id"] . "</td>  
                        <td>" . $row["nome"] . "</td>" .
                        "<td> 
                            <form action='remover.php' method='POST'>
                                <input type='hidden' name='tipo' value='cliente'>
                                <input type='hidden' name='id_para_ser_removido' value='" . $row["id"] . "'>
                                <input type='submit' value='Remover'>
                            </form>      
                        </td>" .
                        "<td>            
                            <form action='form_edit.php' method='POST'>
                                <input type='hidden' name='tipo' value='cliente'>
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