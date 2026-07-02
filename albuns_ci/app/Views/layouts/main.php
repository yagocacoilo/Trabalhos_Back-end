<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Minha Coleção' ?> - VinylBox</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #14121a; color: #eae6f0; min-height: 100vh; }

        .navbar {
            background: #1e1a29;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #2c2740;
        }
        .navbar .brand { display: flex; align-items: center; gap: 10px; }
        .navbar .brand .disco {
            width: 26px; height: 26px; border-radius: 50%;
            background: radial-gradient(circle at center, #14121a 0 4px, #d64bff 5px 6px, #14121a 7px);
        }
        .navbar h1 { color: #fff; font-size: 19px; letter-spacing: 0.5px; }
        .navbar .user-info { color: #a89bc9; font-size: 13px; }

        .menu {
            background: #1a1724;
            border-bottom: 1px solid #2c2740;
            padding: 0 24px;
            display: flex;
            gap: 5px;
        }
        .menu a {
            display: inline-block;
            padding: 12px 16px;
            color: #b7a9d9;
            text-decoration: none;
            font-size: 14px;
            border-bottom: 3px solid transparent;
            transition: 0.15s;
        }
        .menu a:hover, .menu a.active { color: #fff; border-bottom-color: #d64bff; }
        .menu .logout { color: #ff6b81; margin-left: auto; }

        .container { padding: 28px 24px; max-width: 1100px; margin: 0 auto; }

        .alert { padding: 12px 16px; margin-bottom: 18px; border-radius: 6px; font-size: 14px; }
        .alert-success { background: #16321f; border: 1px solid #34a853; color: #7fe0a0; }
        .alert-error   { background: #3a1620; border: 1px solid #d93025; color: #ff8a8a; }

        h2 { font-size: 20px; margin-bottom: 18px; color: #fff; font-weight: 600; }

        .card { background: #1e1a29; border: 1px solid #2c2740; border-radius: 10px; padding: 22px; margin-bottom: 18px; }

        .label { display: block; font-size: 13px; color: #b7a9d9; margin-bottom: 6px; font-weight: 500; }
        input[type=text], input[type=password], input[type=number], input[type=file], select, textarea {
            width: 100%; padding: 10px 12px; background: #14121a; border: 1px solid #33304a;
            border-radius: 6px; font-size: 14px; margin-bottom: 4px; color: #eae6f0;
        }
        input::placeholder { color: #675f80; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #d64bff; }
        .campo { margin-bottom: 16px; }
        .campo-erro { font-size: 12px; color: #ff8a8a; margin-top: 4px; }

        .btn { padding: 10px 22px; background: #d64bff; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 600; }
        .btn:hover { background: #b829e0; }
        .btn-secundario { background: #33304a; }
        .btn-secundario:hover { background: #423d5c; }
        .btn-perigo { background: #d93025; }
        .btn-perigo:hover { background: #b0261c; }
        .btn-small { padding: 6px 14px; font-size: 13px; }

        .grid-albuns {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }
        .album-card {
            background: #1e1a29; border: 1px solid #2c2740; border-radius: 10px;
            overflow: hidden; transition: transform 0.15s, border-color 0.15s;
        }
        .album-card:hover { transform: translateY(-3px); border-color: #d64bff; }
        .album-capa { width: 100%; aspect-ratio: 1 / 1; object-fit: cover; display: block; background: #14121a; }
        .album-info { padding: 12px 14px; }
        .album-nome { font-size: 15px; font-weight: 600; color: #fff; margin-bottom: 3px; }
        .album-ano { font-size: 13px; color: #a89bc9; }
        .album-acoes { display: flex; gap: 6px; padding: 0 14px 14px; }
        .album-acoes a, .album-acoes button { flex: 1; text-align: center; text-decoration: none; }

        .empty-state { text-align: center; padding: 60px 20px; color: #675f80; }
        .empty-state .disco-grande {
            width: 90px; height: 90px; margin: 0 auto 18px;
            border-radius: 50%; background: radial-gradient(circle at center, #1e1a29 0 14px, #33304a 15px 20px, #1e1a29 21px);
        }

        .musicas-lista { list-style: none; margin-top: 6px; }
        .musicas-lista li {
            display: flex; align-items: center; gap: 10px; padding: 10px 12px;
            border-bottom: 1px solid #2c2740; font-size: 14px;
        }
        .musicas-lista li:last-child { border-bottom: none; }
        .musicas-lista .numero { color: #675f80; width: 24px; }

        .detalhe-topo { display: flex; gap: 24px; flex-wrap: wrap; margin-bottom: 24px; }
        .detalhe-capa { width: 220px; height: 220px; object-fit: cover; border-radius: 10px; border: 1px solid #2c2740; }
        .detalhe-info h1 { font-size: 24px; color: #fff; margin-bottom: 6px; }
        .detalhe-info .ano-badge {
            display: inline-block; background: #33304a; color: #d3c6f5; font-size: 13px;
            padding: 4px 12px; border-radius: 20px; margin-top: 6px;
        }

        .musica-input-row { display: flex; gap: 8px; margin-bottom: 8px; align-items: center; }
        .musica-input-row input { margin-bottom: 0; }
        .btn-remover-musica {
            background: #3a1620; color: #ff8a8a; border: 1px solid #5c2530; border-radius: 6px;
            padding: 9px 12px; cursor: pointer; font-size: 13px; flex-shrink: 0;
        }
        .btn-remover-musica:hover { background: #5c2530; }
        .btn-add-musica {
            background: transparent; border: 1px dashed #45405e; color: #b7a9d9;
            padding: 9px 14px; border-radius: 6px; cursor: pointer; font-size: 13px; margin-top: 4px;
        }
        .btn-add-musica:hover { border-color: #d64bff; color: #d64bff; }

        .preview-capa { margin-top: 10px; max-width: 150px; border-radius: 8px; border: 1px solid #2c2740; display: none; }
        .info-texto { font-size: 12px; color: #675f80; margin-bottom: 10px; }

        .top-actions { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="navbar">
    <div class="brand">
        <div class="disco"></div>
        <h1>VinylBox</h1>
    </div>
    <span class="user-info">Olá, <?= esc(session()->get('user_nome')) ?> (@<?= esc(session()->get('user_username')) ?>)</span>
</div>

<div class="menu">
    <a href="/albuns" class="active">Meus Álbuns</a>
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
