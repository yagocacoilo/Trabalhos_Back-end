<?php
    $conexao = mysqli_connect("localhost", "root", "", "loja");

    if (!$conexao) 
    {   die("Falha na conexão: " . mysqli_connect_error());
    }
?>