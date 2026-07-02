<?php

    include("config.php");

    $id = (int) $_POST["id_para_ser_removido"];
    $tipo = $_POST["tipo"];

    if ($tipo == "cliente")
    {   mysqli_query($conexao, "DELETE FROM cliente WHERE id = $id");
        mysqli_close($conexao);
        header('Location: clientes.php');
    }

    if ($tipo == "pedido") 
    {   mysqli_query($conexao, "DELETE FROM pedido WHERE id = $id");
        mysqli_close($conexao);
        header('Location: pedidos.php');
    }
?>