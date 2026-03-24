<?php
    $conexao = mysqli_connect("localhost", "root", "Color@do123", "loja");

    if (!$conexao) 
    {   die("Falha na conexão: " . mysqli_connect_error());
    }
?>