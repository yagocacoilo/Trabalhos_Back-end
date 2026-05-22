<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TransacaoModel;
use CodeIgniter\Controller;

class TransferenciasController extends Controller
{
    public function index()
    {
        $userId = session()->get('user_id');
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        return view('transferencias/index', ['user' => $user]);
    }

    public function realizar()
    {
        $userId         = session()->get('user_id');
        $conta_destino  = trim($this->request->getPost('conta_destino'));
        $valor          = (float) $this->request->getPost('valor');

        // Validações
        if (empty($conta_destino) || $valor <= 0) {
            return redirect()->to('/transferencias')->with('error', 'Preencha todos os campos corretamente.');
        }

        $userModel = new UserModel();
        $remetente = $userModel->find($userId);

        // Não pode transferir para si mesmo
        if ($remetente['numero_conta'] === $conta_destino) {
            return redirect()->to('/transferencias')->with('error', 'Você não pode transferir para sua própria conta.');
        }

        // Verificar conta destino
        $destinatario = $userModel->where('numero_conta', $conta_destino)->first();
        if (!$destinatario) {
            return redirect()->to('/transferencias')->with('error', 'Conta destino não encontrada.');
        }

        // Verificar saldo
        if ($valor > (float) $remetente['saldo']) {
            return redirect()->to('/transferencias')->with('error',
                'Saldo insuficiente. Saldo atual: R$ ' . number_format($remetente['saldo'], 2, ',', '.')
            );
        }

        $transacaoModel = new TransacaoModel();

        // Débito no remetente
        $novoSaldoRemetente = (float) $remetente['saldo'] - $valor;
        $transacaoModel->insert([
            'user_id'    => $userId,
            'tipo'       => 'debito',
            'descricao'  => 'Transferência enviada para conta ' . $conta_destino . ' (' . $destinatario['nome'] . ')',
            'valor'      => $valor,
            'saldo_apos' => $novoSaldoRemetente,
        ]);
        $userModel->atualizarSaldo($userId, $novoSaldoRemetente);

        // Crédito no destinatário
        $novoSaldoDestinatario = (float) $destinatario['saldo'] + $valor;
        $transacaoModel->insert([
            'user_id'    => $destinatario['id'],
            'tipo'       => 'credito',
            'descricao'  => 'Transferência recebida de ' . $remetente['nome'] . ' (conta ' . $remetente['numero_conta'] . ')',
            'valor'      => $valor,
            'saldo_apos' => $novoSaldoDestinatario,
        ]);
        $userModel->atualizarSaldo($destinatario['id'], $novoSaldoDestinatario);

        return redirect()->to('/transferencias')->with('success',
            'Transferência realizada! Enviado R$ ' . number_format($valor, 2, ',', '.') .
            ' para ' . $destinatario['nome'] . '. Novo saldo: R$ ' . number_format($novoSaldoRemetente, 2, ',', '.')
        );
    }
}
