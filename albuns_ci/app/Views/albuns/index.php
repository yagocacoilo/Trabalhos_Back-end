<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="top-actions">
    <h2>Meus Álbuns</h2>
    <a href="/albuns/novo" class="btn">+ Novo Álbum</a>
</div>

<?php if (empty($albuns)): ?>
    <div class="empty-state">
        <div class="disco-grande"></div>
        <p>Sua coleção ainda está vazia.</p>
        <p style="margin-top:6px;"><a href="/albuns/novo" style="color:#d64bff;">Cadastre seu primeiro álbum</a></p>
    </div>
<?php else: ?>
    <div class="grid-albuns">
        <?php foreach ($albuns as $album): ?>
            <div class="album-card">
                <a href="/albuns/<?= $album['id'] ?>">
                    <img class="album-capa"
                         src="/uploads/albuns/<?= esc($album['capa']) ?>"
                         alt="Capa do álbum <?= esc($album['nome_album']) ?>">
                </a>
                <div class="album-info">
                    <div class="album-nome"><?= esc($album['nome_album']) ?></div>
                    <div class="album-ano"><?= esc($album['ano']) ?></div>
                </div>
                <div class="album-acoes">
                    <a href="/albuns/<?= $album['id'] ?>/editar" class="btn btn-secundario btn-small">Editar</a>
                    <form action="/albuns/<?= $album['id'] ?>/excluir" method="post"
                          onsubmit="return confirm('Excluir este álbum? Essa ação não pode ser desfeita.');">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-perigo btn-small">Excluir</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
