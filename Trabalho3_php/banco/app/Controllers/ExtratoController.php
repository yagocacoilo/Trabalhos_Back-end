<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TransacaoModel;
use CodeIgniter\Controller;

class ExtratoController extends Controller
{
    public function index()
    {
        $userId = session()->get('user_id');
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        $transacaoModel = new TransacaoModel();
        $transacoes = $transacaoModel->extrato($userId);

        return view('extrato/index', [
            'user'      => $user,
            'transacoes'=> $transacoes,
        ]);
    }
}
