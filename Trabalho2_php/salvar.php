<?php

    include("config.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {   $tipo = $_GET['tipo'];
        
        if($tipo == 'cliente')
        {   $nome = $_POST["nome"];
            $query = "INSERT INTO cliente (nome) VALUES ('$nome')";
            if (mysqli_query($conexao, $query)) 
            {   echo "Cliente cadastrado com sucesso!";
            } 
            else
            {   echo "Erro ao atualizar produto: " . mysqli_error($conexao);
            }
            mysqli_close($conexao);
            header('Location: home.php');
        }

        if($tipo == 'pedido')
        {   $cliente_nome = $_POST["cliente_nome"];

            $query = "SELECT id FROM cliente WHERE nome = '$cliente_nome'";
            $resultado = mysqli_query($conexao, $query);
            if (mysqli_num_rows($resultado) == 0)
            {   die("Cliente não existe!");
            }
            $row = mysqli_fetch_assoc($resultado);
            $cliente_id = $row['id'];
            
            $produto = $_POST["produto"];
            $valor = $_POST["valor"];
            $data_pedido = $_POST["data_pedido"];
            $hoje = date('Y-m-d');
            if ($data_pedido > $hoje)
            {   die("Data não pode ser futura!");
            }
            $query = "INSERT INTO pedido (cliente_id, produto, valor, data_pedido) VALUES ('$cliente_id','$produto','$valor','$data_pedido')";
            if (mysqli_query($conexao, $query))
            {   echo "Cliente cadastrado com sucesso!";
            } 
            else
            {   echo "Erro ao atualizar produto: " . mysqli_error($conexao);
            }
            mysqli_close($conexao);
            header('Location: home.php');
        }
    }
?>