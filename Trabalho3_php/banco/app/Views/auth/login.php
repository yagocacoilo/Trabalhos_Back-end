<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login - BancoCI</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f0f0; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .box { background: white; padding: 30px; border: 1px solid #ddd; border-radius: 6px; width: 320px; }
        h2 { margin-bottom: 20px; font-size: 20px; color: #1a73e8; }
        label { display: block; font-size: 13px; color: #555; margin-bottom: 4px; }
        input { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; margin-bottom: 12px; }
        .btn { width: 100%; padding: 9px; background: #1a73e8; color: white; border: none; border-radius: 4px; font-size: 14px; cursor: pointer; }
        .btn:hover { background: #1558b0; }
        .link { text-align: center; margin-top: 12px; font-size: 13px; }
        .link a { color: #1a73e8; }
        .alert { padding: 8px 12px; border-radius: 4px; margin-bottom: 12px; font-size: 13px; }
        .alert-error   { background: #fce8e6; border: 1px solid #d93025; color: #d93025; }
        .alert-success { background: #e6f4ea; border: 1px solid #34a853; color: #1e7e34; }
    </style>
</head>
<body>
<div class="box">
    <h2>BancoCI — Login</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <form action="/login" method="post">
        <?= csrf_field() ?>
        <label>Usuário</label>
        <input type="text" name="username" placeholder="seu username" required>
        <label>Senha</label>
        <input type="password" name="senha" placeholder="sua senha" required>
        <button type="submit" class="btn">Entrar</button>
    </form>
    <div class="link"><a href="/register">Criar conta</a></div>
</div>
</body>
</html>
