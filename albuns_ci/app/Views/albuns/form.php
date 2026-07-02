<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<a href="/albuns" style="color:#b7a9d9; text-decoration:none; font-size:13px;">&larr; Voltar</a>

<h2 style="margin-top:16px;"><?= esc($titulo) ?></h2>

<div class="card">
    <form action="<?= $album ? '/albuns/' . $album['id'] : '/albuns' ?>" method="post" enctype="multipart/form-data" id="form-album">
        <?= csrf_field() ?>

        <div class="campo">
            <label>Nome do álbum</label>
            <input type="text" name="nome_album" placeholder="Ex: The Dark Side of the Moon"
                   value="<?= esc(old('nome_album', $album['nome_album'] ?? '')) ?>" required maxlength="150">
        </div>

        <div class="campo">
            <label>Ano de lançamento</label>
            <input type="number" name="ano" placeholder="Ex: 1973" min="1901" max="2100"
                   value="<?= esc(old('ano', $album['ano'] ?? '')) ?>" required>
        </div>

        <div class="campo">
            <label>Capa do álbum</label>
            <?php if (!empty($album['capa'])): ?>
                <p class="info-texto">Deixe em branco para manter a capa atual.</p>
                <img src="/uploads/albuns/<?= esc($album['capa']) ?>" class="preview-capa" style="display:block; margin-bottom:10px;" alt="Capa atual">
            <?php endif; ?>
            <input type="file" name="capa" id="input-capa" accept="image/png, image/jpeg, image/webp" <?= $album ? '' : 'required' ?>>
            <img id="preview-nova-capa" class="preview-capa" alt="Pré-visualização">
        </div>

        <div class="campo">
            <label>Faixas do álbum</label>
            <div id="lista-musicas">
                <?php if (!empty($musicas)): ?>
                    <?php foreach ($musicas as $musica): ?>
                        <div class="musica-input-row">
                            <input type="text" name="musicas[]" placeholder="Nome da música"
                                   value="<?= esc($musica['nome_musica']) ?>" maxlength="150">
                            <button type="button" class="btn-remover-musica" onclick="removerMusica(this)">Remover</button>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="musica-input-row">
                        <input type="text" name="musicas[]" placeholder="Nome da música" maxlength="150">
                        <button type="button" class="btn-remover-musica" onclick="removerMusica(this)">Remover</button>
                    </div>
                <?php endif; ?>
            </div>
            <button type="button" class="btn-add-musica" onclick="adicionarMusica()">+ Adicionar música</button>
        </div>

        <div style="margin-top:22px; display:flex; gap:10px;">
            <button type="submit" class="btn"><?= $album ? 'Salvar alterações' : 'Cadastrar álbum' ?></button>
            <a href="/albuns" class="btn btn-secundario" style="text-decoration:none; display:inline-flex; align-items:center;">Cancelar</a>
        </div>
    </form>
</div>

<script>
    function adicionarMusica() {
        const lista = document.getElementById('lista-musicas');
        const row = document.createElement('div');
        row.className = 'musica-input-row';
        row.innerHTML = `
            <input type="text" name="musicas[]" placeholder="Nome da música" maxlength="150">
            <button type="button" class="btn-remover-musica" onclick="removerMusica(this)">Remover</button>
        `;
        lista.appendChild(row);
        row.querySelector('input').focus();
    }

    function removerMusica(botao) {
        const lista = document.getElementById('lista-musicas');
        if (lista.children.length > 1) {
            botao.closest('.musica-input-row').remove();
        } else {
            botao.previousElementSibling.value = '';
        }
    }

    // Pré-visualização da nova imagem antes do envio
    document.getElementById('input-capa').addEventListener('change', function (e) {
        const preview = document.getElementById('preview-nova-capa');
        const arquivo = e.target.files[0];
        if (arquivo) {
            const leitor = new FileReader();
            leitor.onload = function (ev) {
                preview.src = ev.target.result;
                preview.style.display = 'block';
            };
            leitor.readAsDataURL(arquivo);
        } else {
            preview.style.display = 'none';
        }
    });

    // Validação simples no cliente: exige ao menos uma música preenchida
    document.getElementById('form-album').addEventListener('submit', function (e) {
        const inputs = document.querySelectorAll('#lista-musicas input');
        const preenchidas = Array.from(inputs).some(i => i.value.trim() !== '');
        if (!preenchidas) {
            e.preventDefault();
            alert('Cadastre pelo menos uma música com nome válido.');
        }
    });
</script>

<?= $this->endSection() ?>
