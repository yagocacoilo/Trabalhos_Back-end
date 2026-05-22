<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TransacaoModel;
use CodeIgniter\Controller;

class PagamentosController extends Controller
{
    public function index()
    {
        $userId = session()->get('user_id');
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        return view('pagamentos/index', ['user' => $user]);
    }

    public function realizar()
    {
        $userId = session()->get('user_id');

        $tipo_pagamento = $this->request->getPost('tipo_pagamento'); // pix, boleto, debito
        $valor          = (float) $this->request->getPost('valor');
        $descricao_extra = trim($this->request->getPost('descricao') ?? '');

        // Validações básicas
        if (empty($tipo_pagamento) || $valor <= 0) {
            return redirect()->to('/pagamentos')->with('error', 'Preencha todos os campos corretamente.');
        }

        $tiposValidos = ['pix', 'boleto', 'debito'];
        if (!in_array($tipo_pagamento, $tiposValidos)) {
            return redirect()->to('/pagamentos')->with('error', 'Tipo de pagamento inválido.');
        }

        // Monta descrição
        $labels = ['pix' => 'Pag. PIX', 'boleto' => 'Pag. Boleto', 'debito' => 'Pag. Débito'];
        $descricao = $labels[$tipo_pagamento];
        if (!empty($descricao_extra)) {
            $descricao .= ' - ' . $descricao_extra;
        }

        $transacaoModel = new TransacaoModel();
        $resultado = $transacaoModel->registrar($userId, 'debito', $descricao, $valor);

        if (!$resultado['ok']) {
            return redirect()->to('/pagamentos')->with('error', $resultado['msg']);
        }

        return redirect()->to('/pagamentos')->with('success',
            'Pagamento realizado! Novo saldo: R$ ' . number_format($resultado['saldo'], 2, ',', '.')
        );
    }
}
