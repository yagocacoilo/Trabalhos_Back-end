<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Início</h2>

<div class="card">
    <div class="saldo-label">Saldo disponível</div>
    <div class="saldo">R$ <?= number_format($user['saldo'], 2, ',', '.') ?></div>
    <div style="font-size:13px; color:#888; margin-top:6px;">
        Conta: <?= esc($user['numero_conta']) ?> &nbsp;|&nbsp; @<?= esc($user['username']) ?>
    </div>
</div>

<div class="card">
    <h2 style="margin-bottom:12px;">Últimas movimentações</h2>
    <?php if (empty($ultimas)): ?>
        <p class="info">Nenhuma movimentação ainda.</p>
    <?php else: ?>
    <table>
        <thead>
            <tr><th>Data</th><th>Descrição</th><th>Valor</th></tr>
        </thead>
        <tbody>
        <?php foreach ($ultimas as $t): ?>
            <tr>
                <td style="color:#888; font-size:13px;"><?= date('d/m/Y H:i', strtotime($t['created_at'])) ?></td>
                <td><?= esc($t['descricao']) ?></td>
                <td class="<?= $t['tipo'] === 'credito' ? 'verde' : 'vermelho' ?>">
                    <?= $t['tipo'] === 'credito' ? '+' : '-' ?>R$ <?= number_format($t['valor'], 2, ',', '.') ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div style="margin-top:10px;"><a href="/extrato" style="font-size:13px; color:#1a73e8;">Ver extrato completo</a></div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
