<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<a href="/albuns" style="color:#b7a9d9; text-decoration:none; font-size:13px;">&larr; Voltar para meus álbuns</a>

<div class="detalhe-topo" style="margin-top:16px;">
    <img class="detalhe-capa"
         src="/uploads/albuns/<?= esc($album['capa']) ?>"
         alt="Capa do álbum <?= esc($album['nome_album']) ?>">
    <div class="detalhe-info">
        <h1><?= esc($album['nome_album']) ?></h1>
        <span class="ano-badge">Lançado em <?= esc($album['ano']) ?></span>
        <div style="margin-top:18px; display:flex; gap:10px;">
            <a href="/albuns/<?= $album['id'] ?>/editar" class="btn btn-secundario btn-small">Editar</a>
            <form action="/albuns/<?= $album['id'] ?>/excluir" method="post"
                  onsubmit="return confirm('Excluir este álbum? Essa ação não pode ser desfeita.');">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-perigo btn-small">Excluir</button>
            </form>
        </div>
    </div>
</div>

<div class="card">
    <h2 style="font-size:16px;">Faixas (<?= count($musicas) ?>)</h2>
    <?php if (empty($musicas)): ?>
        <p style="color:#675f80; font-size:14px;">Nenhuma música cadastrada.</p>
    <?php else: ?>
        <ul class="musicas-lista">
            <?php foreach ($musicas as $i => $musica): ?>
                <li>
                    <span class="numero"><?= $i + 1 ?>.</span>
                    <span><?= esc($musica['nome_musica']) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
