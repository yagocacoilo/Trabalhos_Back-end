<?php

namespace App\Models;

use CodeIgniter\Model;

class AlbumModel extends Model
{
    protected $table      = 'albuns';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'nome_album',
        'ano',
        'capa',
    ];

    protected $useTimestamps = true;

    // Regras de validação usadas pelo controller
    protected $validationRules = [
        'nome_album' => 'required|min_length[2]|max_length[150]',
        'ano'        => 'required|is_natural_no_zero|greater_than[1900]|less_than_equal_to[2100]',
    ];

    protected $validationMessages = [
        'nome_album' => [
            'required'   => 'Informe o nome do álbum.',
            'min_length' => 'O nome do álbum deve ter pelo menos 2 caracteres.',
            'max_length' => 'O nome do álbum deve ter no máximo 150 caracteres.',
        ],
        'ano' => [
            'required'             => 'Informe o ano de lançamento.',
            'is_natural_no_zero'   => 'O ano deve ser um número válido.',
            'greater_than'         => 'O ano deve ser maior que 1900.',
            'less_than_equal_to'   => 'O ano não pode ser maior que 2100.',
        ],
    ];

    /**
     * Retorna os álbuns de um usuário, mais recentes primeiro
     */
    public function albunsDoUsuario(int $userId)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    /**
     * Garante que o álbum pertence ao usuário logado (evita acesso indevido)
     */
    public function buscarDoUsuario(int $albumId, int $userId)
    {
        return $this->where('id', $albumId)
                    ->where('user_id', $userId)
                    ->first();
    }
}
