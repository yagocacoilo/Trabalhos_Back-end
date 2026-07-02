<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nome',
        'username',
        'senha',
        'numero_conta',
        'saldo',
    ];

    protected $useTimestamps = true;

    /**
     * Gera número de conta único: XXXXX-X
     */
    public function gerarNumeroConta(): string
    {
        do {
            $numero = rand(10000, 99999) . '-' . rand(0, 9);
        } while ($this->where('numero_conta', $numero)->first());

        return $numero;
    }

    /**
     * Gera username único baseado no nome
     */
    public function gerarUsername(string $nome): string
    {
        // Pega primeira palavra, minúsculo, sem acentos
        $base = strtolower(explode(' ', $nome)[0]);
        $base = preg_replace('/[^a-z0-9]/', '', $this->removerAcentos($base));

        $username = $base . rand(100, 9999);
        while ($this->where('username', $username)->first()) {
            $username = $base . rand(100, 9999);
        }
        return $username;
    }

    private function removerAcentos(string $str): string
    {
        $search  = ['á','à','ã','â','é','è','ê','í','ì','ó','ò','õ','ô','ú','ù','ü','ç','ñ'];
        $replace = ['a','a','a','a','e','e','e','i','i','o','o','o','o','u','u','u','c','n'];
        return str_replace($search, $replace, $str);
    }

    /**
     * Atualiza saldo do usuário
     */
    public function atualizarSaldo(int $userId, float $novoSaldo): bool
    {
        return $this->update($userId, ['saldo' => $novoSaldo]);
    }
}
