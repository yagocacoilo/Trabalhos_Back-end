<?php

    include("config.php");

    $id = (int) $_POST["id"];
    $tipo = $_POST["tipo"];

    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {   if ($tipo == "cliente") 
        {   $nome = $_POST["nome"];
            $query = "UPDATE cliente SET nome='$nome' WHERE id=$id";

            if (mysqli_query($conexao, $query)) 
            {   echo "Produto atualizado com sucesso!";
            } 
            else
            {   echo "Erro ao atualizar produto: " . mysqli_error($conexao);
            } 
        mysqli_close($conexao);
        header('Location: home.php');
        }

        if($tipo == "pedido") 
        {   $produto = $_POST["produto"];
            $valor = $_POST["valor"];
            $data_pedido = $_POST["data_pedido"];
            $query = "UPDATE pedido SET produto='$produto', valor='$valor', data_pedido='$data_pedido' WHERE id=$id";

            if (mysqli_query($conexao, $query)) 
            {   echo "Produto atualizado com sucesso!";
            } 
            else 
            {   echo "Erro ao atualizar produto: " . mysqli_error($conexao);
            }            
        mysqli_close($conexao);
        header('Location: home.php');
        }
    }
?>