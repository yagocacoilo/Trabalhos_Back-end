<?php

namespace App\Controllers;

use App\Models\AlbumModel;
use App\Models\MusicaModel;
use CodeIgniter\Controller;
use Config\Services;

class AlbumController extends Controller
{
    protected AlbumModel $albumModel;
    protected MusicaModel $musicaModel;

    // Pasta pública onde as capas ficam salvas
    protected string $pastaUpload = FCPATH . 'uploads/albuns/';

    public function __construct()
    {
        $this->albumModel  = new AlbumModel();
        $this->musicaModel = new MusicaModel();
    }

    /**
     * Lista os álbuns do usuário logado
     */
    public function index()
    {
        $userId = session()->get('user_id');
        $albuns = $this->albumModel->albunsDoUsuario($userId);

        return view('albuns/index', [
            'titulo' => 'Meus Álbuns',
            'albuns' => $albuns,
        ]);
    }

    /**
     * Formulário de criação
     */
    public function new()
    {
        return view('albuns/form', [
            'titulo'  => 'Novo Álbum',
            'album'   => null,
            'musicas' => [],
        ]);
    }

    /**
     * Salva um novo álbum
     */
    public function create()
    {
        $userId = session()->get('user_id');

        $rules = [
            'nome_album' => 'required|min_length[2]|max_length[150]',
            'ano'        => 'required|is_natural_no_zero|greater_than[1900]|less_than_equal_to[2100]',
            'musicas'    => 'required',
            'capa'       => 'uploaded[capa]|is_image[capa]|max_size[capa,4096]|mime_in[capa,image/jpg,image/jpeg,image/png,image/webp]',
        ];

        $messages = [
            'nome_album' => [
                'required'   => 'Informe o nome do álbum.',
                'min_length' => 'O nome do álbum deve ter pelo menos 2 caracteres.',
                'max_length' => 'O nome do álbum deve ter no máximo 150 caracteres.',
            ],
            'ano' => [
                'required'           => 'Informe o ano de lançamento.',
                'is_natural_no_zero' => 'O ano deve ser um número válido.',
                'greater_than'       => 'O ano deve ser maior que 1900.',
                'less_than_equal_to' => 'O ano não pode ser maior que 2100.',
            ],
            'musicas' => [
                'required' => 'Cadastre pelo menos uma música.',
            ],
            'capa' => [
                'uploaded' => 'Selecione uma imagem de capa para o álbum.',
                'is_image' => 'O arquivo enviado precisa ser uma imagem.',
                'max_size' => 'A imagem deve ter no máximo 4MB.',
                'mime_in'  => 'Formatos aceitos: JPG, JPEG, PNG ou WEBP.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->to('/albuns/novo')
                ->withInput()
                ->with('error', implode(' ', $this->validator->getErrors()));
        }

        // Lista de músicas vinda do formulário (um input[] por música)
        $nomesMusicas = array_filter(array_map('trim', (array) $this->request->getPost('musicas')));
        if (empty($nomesMusicas)) {
            return redirect()->to('/albuns/novo')
                ->withInput()
                ->with('error', 'Cadastre pelo menos uma música com nome válido.');
        }

        // Upload da capa com nome aleatório
        $nomeArquivo = $this->salvarCapa();
        if ($nomeArquivo === null) {
            return redirect()->to('/albuns/novo')
                ->withInput()
                ->with('error', 'Não foi possível enviar a imagem. Tente novamente.');
        }

        $albumId = $this->albumModel->insert([
            'user_id'    => $userId,
            'nome_album' => $this->request->getPost('nome_album'),
            'ano'        => (int) $this->request->getPost('ano'),
            'capa'       => $nomeArquivo,
        ]);

        $this->musicaModel->salvarLista($albumId, $nomesMusicas);

        return redirect()->to('/albuns')->with('success', 'Álbum cadastrado com sucesso!');
    }

    /**
     * Exibe os detalhes de um álbum (capa, ano, lista de músicas)
     */
    public function show($id)
    {
        $userId = session()->get('user_id');
        $album  = $this->albumModel->buscarDoUsuario((int) $id, $userId);

        if (!$album) {
            return redirect()->to('/albuns')->with('error', 'Álbum não encontrado.');
        }

        $musicas = $this->musicaModel->musicasDoAlbum($album['id']);

        return view('albuns/show', [
            'titulo'  => $album['nome_album'],
            'album'   => $album,
            'musicas' => $musicas,
        ]);
    }

    /**
     * Formulário de edição
     */
    public function edit($id)
    {
        $userId = session()->get('user_id');
        $album  = $this->albumModel->buscarDoUsuario((int) $id, $userId);

        if (!$album) {
            return redirect()->to('/albuns')->with('error', 'Álbum não encontrado.');
        }

        $musicas = $this->musicaModel->musicasDoAlbum($album['id']);

        return view('albuns/form', [
            'titulo'  => 'Editar Álbum',
            'album'   => $album,
            'musicas' => $musicas,
        ]);
    }

    /**
     * Atualiza um álbum existente
     */
    public function update($id)
    {
        $userId = session()->get('user_id');
        $album  = $this->albumModel->buscarDoUsuario((int) $id, $userId);

        if (!$album) {
            return redirect()->to('/albuns')->with('error', 'Álbum não encontrado.');
        }

        $rules = [
            'nome_album' => 'required|min_length[2]|max_length[150]',
            'ano'        => 'required|is_natural_no_zero|greater_than[1900]|less_than_equal_to[2100]',
        ];

        $messages = [
            'nome_album' => [
                'required'   => 'Informe o nome do álbum.',
                'min_length' => 'O nome do álbum deve ter pelo menos 2 caracteres.',
                'max_length' => 'O nome do álbum deve ter no máximo 150 caracteres.',
            ],
            'ano' => [
                'required'           => 'Informe o ano de lançamento.',
                'is_natural_no_zero' => 'O ano deve ser um número válido.',
                'greater_than'       => 'O ano deve ser maior que 1900.',
                'less_than_equal_to' => 'O ano não pode ser maior que 2100.',
            ],
        ];

        // Se uma nova imagem foi enviada, valida o arquivo também
        $imagem = $this->request->getFile('capa');
        if ($imagem && $imagem->isValid() && !$imagem->hasMoved()) {
            $rules['capa'] = 'is_image[capa]|max_size[capa,4096]|mime_in[capa,image/jpg,image/jpeg,image/png,image/webp]';
            $messages['capa'] = [
                'is_image' => 'O arquivo enviado precisa ser uma imagem.',
                'max_size' => 'A imagem deve ter no máximo 4MB.',
                'mime_in'  => 'Formatos aceitos: JPG, JPEG, PNG ou WEBP.',
            ];
        }

        if (!$this->validate($rules, $messages)) {
            return redirect()->to('/albuns/' . $id . '/editar')
                ->withInput()
                ->with('error', implode(' ', $this->validator->getErrors()));
        }

        $nomesMusicas = array_filter(array_map('trim', (array) $this->request->getPost('musicas')));
        if (empty($nomesMusicas)) {
            return redirect()->to('/albuns/' . $id . '/editar')
                ->withInput()
                ->with('error', 'Cadastre pelo menos uma música com nome válido.');
        }

        $dados = [
            'nome_album' => $this->request->getPost('nome_album'),
            'ano'        => (int) $this->request->getPost('ano'),
        ];

        // Só troca a imagem se uma nova foi enviada
        if ($imagem && $imagem->isValid() && !$imagem->hasMoved()) {
            $novoArquivo = $this->salvarCapa();
            if ($novoArquivo !== null) {
                $this->removerArquivoCapa($album['capa']);
                $dados['capa'] = $novoArquivo;
            }
        }

        $this->albumModel->update($id, $dados);
        $this->musicaModel->salvarLista((int) $id, $nomesMusicas);

        return redirect()->to('/albuns')->with('success', 'Álbum atualizado com sucesso!');
    }

    /**
     * Remove um álbum, suas músicas e a imagem de capa
     */
    public function delete($id)
    {
        $userId = session()->get('user_id');
        $album  = $this->albumModel->buscarDoUsuario((int) $id, $userId);

        if (!$album) {
            return redirect()->to('/albuns')->with('error', 'Álbum não encontrado.');
        }

        $this->musicaModel->removerDoAlbum((int) $id);
        $this->albumModel->delete($id);
        $this->removerArquivoCapa($album['capa']);

        return redirect()->to('/albuns')->with('success', 'Álbum removido com sucesso.');
    }

    /**
     * Faz o upload da capa gerando um nome aleatório para o arquivo,
     * salvando o arquivo em public/uploads/albuns e retornando o nome gerado.
     */
    private function salvarCapa(): ?string
    {
        $imagem = $this->request->getFile('capa');

        if (!$imagem || !$imagem->isValid() || $imagem->hasMoved()) {
            return null;
        }

        if (!is_dir($this->pastaUpload)) {
            mkdir($this->pastaUpload, 0755, true);
        }

        // Nome aleatório gerado pelo próprio CodeIgniter (evita colisão e não expõe nome original)
        $novoNome = $imagem->getRandomName();
        $imagem->move($this->pastaUpload, $novoNome);

        return $novoNome;
    }

    /**
     * Remove o arquivo físico da capa antiga, se existir
     */
    private function removerArquivoCapa(?string $nomeArquivo): void
    {
        if (!$nomeArquivo) {
            return;
        }
        $caminho = $this->pastaUpload . $nomeArquivo;
        if (is_file($caminho)) {
            unlink($caminho);
        }
    }
}
