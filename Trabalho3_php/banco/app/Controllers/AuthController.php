<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\TransacaoModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function login()
    {
        if (session()->get('user_id')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

    public function doLogin()
    {
        $username = $this->request->getPost('username');
        $senha    = $this->request->getPost('senha');

        if (empty($username) || empty($senha)) {
            return redirect()->to('/login')->with('error', 'Preencha todos os campos.');
        }

        $userModel = new UserModel();
        $user      = $userModel->where('username', $username)->first();

        if (!$user || !password_verify($senha, $user['senha'])) {
            return redirect()->to('/login')->with('error', 'Usuário ou senha inválidos.');
        }

        $session = session();
        $session->set([
            'user_id'      => $user['id'],
            'user_nome'    => $user['nome'],
            'user_username'=> $user['username'],
            'user_conta'   => $user['numero_conta'],
        ]);

        return redirect()->to('/dashboard');
    }

    public function register()
    {
        if (session()->get('user_id')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/register');
    }

    public function doRegister()
    {
        $nome            = trim($this->request->getPost('nome'));
        $senha           = $this->request->getPost('senha');
        $confirma_senha  = $this->request->getPost('confirma_senha');
        $deposito_inicial= (float) $this->request->getPost('deposito_inicial');

        // Validações
        if (empty($nome) || empty($senha) || empty($confirma_senha)) {
            return redirect()->to('/register')->with('error', 'Preencha todos os campos.');
        }

        if ($senha !== $confirma_senha) {
            return redirect()->to('/register')->with('error', 'As senhas não conferem.');
        }

        if (strlen($senha) < 6) {
            return redirect()->to('/register')->with('error', 'A senha deve ter pelo menos 6 caracteres.');
        }

        if ($deposito_inicial < 0) {
            return redirect()->to('/register')->with('error', 'O depósito inicial não pode ser negativo.');
        }

        $userModel   = new UserModel();
        $username    = $userModel->gerarUsername($nome);
        $numeroConta = $userModel->gerarNumeroConta();
        $hash        = password_hash($senha, PASSWORD_BCRYPT);

        $userId = $userModel->insert([
            'nome'         => $nome,
            'username'     => $username,
            'senha'        => $hash,
            'numero_conta' => $numeroConta,
            'saldo'        => $deposito_inicial,
        ]);

        // Registra depósito inicial no extrato (se houver)
        if ($deposito_inicial > 0) {
            $transacaoModel = new TransacaoModel();
            $transacaoModel->insert([
                'user_id'    => $userId,
                'tipo'       => 'credito',
                'descricao'  => 'Depósito inicial',
                'valor'      => $deposito_inicial,
                'saldo_apos' => $deposito_inicial,
            ]);
        }

        return redirect()->to('/login')->with('success',
            "Conta criada! Seu usuário é: <strong>{$username}</strong> e sua conta: <strong>{$numeroConta}</strong>"
        );
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Você saiu com sucesso.');
    }
}
