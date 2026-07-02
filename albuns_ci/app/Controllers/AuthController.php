<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function login()
    {
        if (session()->get('user_id')) {
            return redirect()->to('/albuns');
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
            'user_id'       => $user['id'],
            'user_nome'     => $user['nome'],
            'user_username' => $user['username'],
        ]);

        return redirect()->to('/albuns');
    }

    public function register()
    {
        if (session()->get('user_id')) {
            return redirect()->to('/albuns');
        }
        return view('auth/register');
    }

    public function doRegister()
    {
        $rules = [
            'nome'           => 'required|min_length[3]|max_length[100]',
            'senha'          => 'required|min_length[6]',
            'confirma_senha' => 'required|matches[senha]',
        ];

        $messages = [
            'nome' => [
                'required'   => 'Informe seu nome completo.',
                'min_length' => 'O nome deve ter pelo menos 3 caracteres.',
            ],
            'senha' => [
                'required'   => 'Informe uma senha.',
                'min_length' => 'A senha deve ter pelo menos 6 caracteres.',
            ],
            'confirma_senha' => [
                'required' => 'Confirme a senha.',
                'matches'  => 'As senhas não conferem.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->to('/register')
                ->withInput()
                ->with('error', implode(' ', $this->validator->getErrors()));
        }

        $nome  = trim($this->request->getPost('nome'));
        $senha = $this->request->getPost('senha');

        $userModel = new UserModel();
        $username  = $userModel->gerarUsername($nome);
        $hash      = password_hash($senha, PASSWORD_BCRYPT);

        $userModel->insert([
            'nome'     => $nome,
            'username' => $username,
            'senha'    => $hash,
        ]);

        return redirect()->to('/login')->with('success',
            "Conta criada com sucesso! Seu usuário é: <strong>{$username}</strong>"
        );
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Você saiu com sucesso.');
    }
}
