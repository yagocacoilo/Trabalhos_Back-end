<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Transferências</h2>

<div class="info">
    Sua conta: <strong><?= esc($user['numero_conta']) ?></strong> &nbsp;|&nbsp;
    Saldo: <strong>R$ <?= number_format($user['saldo'], 2, ',', '.') ?></strong>
</div>

<div class="card" style="max-width: 480px;">
    <form action="/transferencias/realizar" method="post">
        <?= csrf_field() ?>

        <label class="label">Conta destino</label>
        <input type="text" name="conta_destino" placeholder="Ex: 34567-8" required>

        <label class="label">Valor (R$)</label>
        <input type="number" name="valor" min="0.01" step="0.01" placeholder="0,00" required>

        <p style="font-size:12px; color:#d93025; margin-bottom:12px;">Atenção: verifique o número da conta antes de confirmar.</p>

        <button type="submit" class="btn">Transferir</button>
    </form>
</div>

<?= $this->endSection() ?>
