<?php

namespace App\Models;

use CodeIgniter\Model;

class TransacaoModel extends Model
{
    protected $table      = 'transacoes';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'tipo',
        'descricao',
        'valor',
        'saldo_apos',
    ];

    protected $useTimestamps = true;

    /**
     * Registra uma transação e atualiza o saldo do usuário.
     * Retorna ['ok' => bool, 'msg' => string]
     */
    public function registrar(int $userId, string $tipo, string $descricao, float $valor): array
    {
        $userModel = new UserModel();
        $user      = $userModel->find($userId);

        if (!$user) {
            return ['ok' => false, 'msg' => 'Usuário não encontrado.'];
        }

        $saldoAtual = (float) $user['saldo'];

        if ($tipo === 'debito') {
            if ($valor <= 0) {
                return ['ok' => false, 'msg' => 'Valor inválido.'];
            }
            if ($valor > $saldoAtual) {
                return ['ok' => false, 'msg' => 'Saldo insuficiente. Saldo atual: R$ ' . number_format($saldoAtual, 2, ',', '.')];
            }
            $novoSaldo = $saldoAtual - $valor;
        } else {
            // credito
            if ($valor <= 0) {
                return ['ok' => false, 'msg' => 'Valor inválido.'];
            }
            $novoSaldo = $saldoAtual + $valor;
        }

        // Registra transação
        $this->insert([
            'user_id'    => $userId,
            'tipo'       => $tipo,
            'descricao'  => $descricao,
            'valor'      => $valor,
            'saldo_apos' => $novoSaldo,
        ]);

        // Atualiza saldo
        $userModel->atualizarSaldo($userId, $novoSaldo);

        return ['ok' => true, 'msg' => 'Transação realizada com sucesso.', 'saldo' => $novoSaldo];
    }

    /**
     * Retorna extrato do usuário (ordem decrescente)
     */
    public function extrato(int $userId): array
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}
