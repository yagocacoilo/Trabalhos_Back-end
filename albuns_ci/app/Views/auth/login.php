<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar - VinylBox</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif; background: #14121a; color: #eae6f0;
            display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px;
        }
        .box { background: #1e1a29; padding: 34px; border: 1px solid #2c2740; border-radius: 12px; width: 360px; }
        .brand { display: flex; align-items: center; gap: 10px; margin-bottom: 22px; }
        .disco {
            width: 30px; height: 30px; border-radius: 50%;
            background: radial-gradient(circle at center, #1e1a29 0 5px, #d64bff 6px 7px, #1e1a29 8px);
        }
        .brand h1 { font-size: 20px; color: #fff; }
        h2 { margin-bottom: 4px; font-size: 18px; color: #fff; }
        .info { font-size: 12px; color: #675f80; margin-bottom: 20px; }
        label { display: block; font-size: 13px; color: #b7a9d9; margin-bottom: 6px; }
        input {
            width: 100%; padding: 10px 12px; background: #14121a; border: 1px solid #33304a;
            border-radius: 6px; font-size: 14px; margin-bottom: 14px; color: #eae6f0;
        }
        input:focus { outline: none; border-color: #d64bff; }
        .btn { width: 100%; padding: 11px; background: #d64bff; color: white; border: none; border-radius: 6px; font-size: 14px; font-weight: 600; cursor: pointer; }
        .btn:hover { background: #b829e0; }
        .link { text-align: center; margin-top: 16px; font-size: 13px; color: #675f80; }
        .link a { color: #d64bff; text-decoration: none; }
        .alert-error   { background: #3a1620; border: 1px solid #d93025; color: #ff8a8a; padding: 10px 12px; border-radius: 6px; margin-bottom: 14px; font-size: 13px; }
        .alert-success { background: #16321f; border: 1px solid #34a853; color: #7fe0a0; padding: 10px 12px; border-radius: 6px; margin-bottom: 14px; font-size: 13px; }
    </style>
</head>
<body>
<div class="box">
    <div class="brand">
        <div class="disco"></div>
        <h1>VinylBox</h1>
    </div>
    <h2>Entrar</h2>
    <p class="info">Acesse sua coleção de álbuns.</p>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert-error"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <form action="/login" method="post">
        <?= csrf_field() ?>
        <label>Usuário</label>
        <input type="text" name="username" placeholder="seu usuário" required autofocus>
        <label>Senha</label>
        <input type="password" name="senha" placeholder="sua senha" required>
        <button type="submit" class="btn">Entrar</button>
    </form>
    <div class="link">Não tem conta? <a href="/register">Cadastre-se</a></div>
</div>
</body>
</html>
