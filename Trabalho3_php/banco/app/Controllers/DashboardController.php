<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TransacaoModel;
use CodeIgniter\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = session()->get('user_id');
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        // Últimas 5 transações para o dashboard
        $transacaoModel = new TransacaoModel();
        $ultimas = $transacaoModel->where('user_id', $userId)
                                  ->orderBy('created_at', 'DESC')
                                  ->limit(5)
                                  ->findAll();

        return view('dashboard/index', [
            'user'   => $user,
            'ultimas'=> $ultimas,
        ]);
    }
}
