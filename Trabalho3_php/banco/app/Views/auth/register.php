<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - BancoCI</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f0f0; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; }
        .box { background: white; padding: 30px; border: 1px solid #ddd; border-radius: 6px; width: 340px; }
        h2 { margin-bottom: 6px; font-size: 20px; color: #1a73e8; }
        .info { font-size: 12px; color: #888; margin-bottom: 18px; }
        label { display: block; font-size: 13px; color: #555; margin-bottom: 4px; }
        input { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; margin-bottom: 12px; }
        .btn { width: 100%; padding: 9px; background: #34a853; color: white; border: none; border-radius: 4px; font-size: 14px; cursor: pointer; }
        .btn:hover { background: #2d8f46; }
        .link { text-align: center; margin-top: 12px; font-size: 13px; }
        .link a { color: #1a73e8; }
        .alert-error { background: #fce8e6; border: 1px solid #d93025; color: #d93025; padding: 8px 12px; border-radius: 4px; margin-bottom: 12px; font-size: 13px; }
    </style>
</head>
<body>
<div class="box">
    <h2>Criar Conta</h2>
    <p class="info">Usuário e número de conta gerados automaticamente.</p>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert-error"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="/register" method="post">
        <?= csrf_field() ?>
        <label>Nome completo</label>
        <input type="text" name="nome" placeholder="Ex: João da Silva" required>
        <label>Senha</label>
        <input type="password" name="senha" placeholder="mínimo 6 caracteres" required>
        <label>Confirmar senha</label>
        <input type="password" name="confirma_senha" required>
        <label>Depósito inicial (R$)</label>
        <input type="number" name="deposito_inicial" value="0" min="0" step="0.01" required>
        <button type="submit" class="btn">Cadastrar</button>
    </form>
    <div class="link"><a href="/login">Já tenho conta</a></div>
</div>
</body>
</html>
