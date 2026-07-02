<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'BancoCI' ?></title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f0f0f0; color: #333; }

        .navbar {
            background: #1a73e8;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .navbar h1 { color: white; font-size: 20px; }
        .navbar span { color: #cce0ff; font-size: 13px; }

        .menu {
            background: #fff;
            border-bottom: 1px solid #ddd;
            padding: 0 20px;
            display: flex;
            gap: 5px;
        }
        .menu a {
            display: inline-block;
            padding: 10px 15px;
            color: #1a73e8;
            text-decoration: none;
            font-size: 14px;
            border-bottom: 3px solid transparent;
        }
        .menu a:hover { border-bottom-color: #1a73e8; }
        .menu .logout { color: #d93025; margin-left: auto; }

        .container { padding: 20px; max-width: 1000px; }

        .alert { padding: 10px 15px; margin-bottom: 15px; border-radius: 4px; font-size: 14px; }
        .alert-success { background: #e6f4ea; border: 1px solid #34a853; color: #1e7e34; }
        .alert-error   { background: #fce8e6; border: 1px solid #d93025; color: #d93025; }

        h2 { font-size: 18px; margin-bottom: 15px; color: #333; }

        .card { background: white; border: 1px solid #ddd; border-radius: 6px; padding: 20px; margin-bottom: 15px; }

        .saldo { font-size: 28px; font-weight: bold; color: #1a73e8; }
        .saldo-label { font-size: 13px; color: #666; margin-bottom: 4px; }

        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th { background: #f8f8f8; text-align: left; padding: 8px 10px; border-bottom: 2px solid #ddd; color: #555; font-size: 13px; }
        td { padding: 8px 10px; border-bottom: 1px solid #eee; }

        .label { display: block; font-size: 13px; color: #555; margin-bottom: 4px; }
        input[type=text], input[type=password], input[type=number], select {
            width: 100%; padding: 8px 10px; border: 1px solid #ccc;
            border-radius: 4px; font-size: 14px; margin-bottom: 12px;
        }
        input:focus, select:focus { outline: none; border-color: #1a73e8; }

        .btn { padding: 8px 20px; background: #1a73e8; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; }
        .btn:hover { background: #1558b0; }

        .verde { color: #1e7e34; font-weight: bold; }
        .vermelho { color: #d93025; font-weight: bold; }

        .info { font-size: 13px; color: #666; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="navbar">
    <h1>BancoCI</h1>
    <span>Olá, <?= esc(session()->get('user_nome')) ?> | Conta: <?= esc(session()->get('user_conta')) ?></span>
</div>

<div class="menu">
    <a href="/dashboard">Início</a>
    <a href="/extrato">Extrato</a>
    <a href="/pagamentos">Pagamentos</a>
    <a href="/transferencias">Transferências</a>
    <a href="/logout" class="logout">Sair</a>
</div>

<div class="container">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
</div>

</body>
</html>
