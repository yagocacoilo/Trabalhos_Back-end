<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>login</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<form action="process.php" method="POST">
<label> Nome do funcionário:
<input type="text" name="nome" required>
</label>
<p>Cargo:</p>
<label><input type="radio" name="cargo" value="0.3" required> Engenheiro</label>
<label><input type="radio" name="cargo" value="0.2" > Gerente</label>
<label><input type="radio" name="cargo" value="0.1" > Diretor</label>


<label> Salário bruto:
<input type="number" step="0.01" min="0" name="salario" required>
</label>

<input type="submit" name="calcular" value="Calcular!">
</form>
</body>
<?php

?>

</body>
</html>

