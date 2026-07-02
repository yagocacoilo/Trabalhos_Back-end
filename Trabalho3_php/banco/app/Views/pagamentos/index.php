<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Pagamentos</h2>

<div class="info">Saldo disponível: <strong>R$ <?= number_format($user['saldo'], 2, ',', '.') ?></strong></div>

<div class="card" style="max-width: 480px;">
    <form action="/pagamentos/realizar" method="post">
        <?= csrf_field() ?>

        <label class="label">Tipo de pagamento</label>
        <select name="tipo_pagamento">
            <option value="pix">PIX</option>
            <option value="boleto">Boleto</option>
            <option value="debito">Débito</option>
        </select>

        <label class="label">Valor (R$)</label>
        <input type="number" name="valor" min="0.01" step="0.01" placeholder="0,00" required>

        <label class="label">Descrição (opcional)</label>
        <input type="text" name="descricao" placeholder="Ex: conta de luz" maxlength="100">

        <button type="submit" class="btn">Confirmar pagamento</button>
    </form>
</div>

<?= $this->endSection() ?>
