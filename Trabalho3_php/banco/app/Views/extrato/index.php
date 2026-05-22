<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Extrato</h2>

<div class="info">
    Conta: <?= esc($user['numero_conta']) ?> &nbsp;|&nbsp;
    Saldo atual: <strong style="color:#1a73e8">R$ <?= number_format($user['saldo'], 2, ',', '.') ?></strong>
</div>

<div class="card">
    <?php if (empty($transacoes)): ?>
        <p class="info">Nenhuma transação registrada.</p>
    <?php else: ?>
    <table>
        <thead>
            <tr><th>Data/Hora</th><th>Descrição</th><th>Tipo</th><th>Valor</th><th>Saldo após</th></tr>
        </thead>
        <tbody>
        <?php foreach ($transacoes as $t): ?>
            <tr>
                <td style="color:#888; font-size:13px; white-space:nowrap"><?= date('d/m/Y H:i', strtotime($t['created_at'])) ?></td>
                <td><?= esc($t['descricao']) ?></td>
                <td style="font-size:13px;"><?= $t['tipo'] === 'credito' ? 'Crédito' : 'Débito' ?></td>
                <td class="<?= $t['tipo'] === 'credito' ? 'verde' : 'vermelho' ?>">
                    <?= $t['tipo'] === 'credito' ? '+' : '-' ?>R$ <?= number_format($t['valor'], 2, ',', '.') ?>
                </td>
                <td style="color:#666; font-size:13px;">R$ <?= number_format($t['saldo_apos'], 2, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
