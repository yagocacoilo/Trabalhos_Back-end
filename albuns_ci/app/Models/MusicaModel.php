<?php

namespace App\Models;

use CodeIgniter\Model;

class MusicaModel extends Model
{
    protected $table      = 'musicas';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'album_id',
        'nome_musica',
        'ordem',
    ];

    protected $useTimestamps = false;

    /**
     * Retorna as músicas de um álbum, na ordem cadastrada
     */
    public function musicasDoAlbum(int $albumId)
    {
        return $this->where('album_id', $albumId)
                    ->orderBy('ordem', 'ASC')
                    ->findAll();
    }

    /**
     * Remove todas as músicas de um álbum (usado antes de recadastrar na edição)
     */
    public function removerDoAlbum(int $albumId): bool
    {
        return $this->where('album_id', $albumId)->delete();
    }

    /**
     * Salva uma lista de nomes de músicas para um álbum, em ordem
     */
    public function salvarLista(int $albumId, array $nomes): void
    {
        $this->removerDoAlbum($albumId);

        $ordem = 1;
        foreach ($nomes as $nome) {
            $nome = trim($nome);
            if ($nome === '') {
                continue;
            }
            $this->insert([
                'album_id'    => $albumId,
                'nome_musica' => $nome,
                'ordem'       => $ordem,
            ]);
            $ordem++;
        }
    }
}
