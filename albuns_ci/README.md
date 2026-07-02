# VinylBox — Sistema de Coleção de Álbuns (CodeIgniter 4)

Sistema CRUD desenvolvido em CodeIgniter 4, com login, cadastro de usuários e
gerenciamento de uma coleção pessoal de álbuns musicais (LPs, CDs, DVDs).

Cada usuário só enxerga e gerencia os **seus próprios** álbuns.

## Funcionalidades

- Login e cadastro de usuário (senha com hash `password_hash`, usuário gerado
  automaticamente a partir do nome).
- Rotas de álbum protegidas por filtro de autenticação (`AuthFilter`).
- CRUD completo de álbuns:
  - Nome do álbum
  - Ano de lançamento
  - Capa (upload de imagem)
  - Lista de músicas (quantidade dinâmica, adicionar/remover no formulário)
- Upload de imagem seguindo o padrão do exemplo do professor: o arquivo é
  salvo em `public/uploads/albuns` com **nome aleatório** (gerado por
  `$file->getRandomName()`), e apenas esse nome aleatório é gravado no banco
  — o nome original do arquivo enviado pelo usuário nunca é usado.
- Validações de servidor (nome, ano, imagem obrigatória/tipo/tamanho, pelo
  menos uma música) e validação simples no cliente (JS).
- Interface com CSS próprio (tema escuro "VinylBox"), responsiva em grid.

## Estrutura relevante

```
app/Controllers/AuthController.php   -> login/cadastro/logout
app/Controllers/AlbumController.php  -> CRUD de álbuns + upload de imagem
app/Models/UserModel.php
app/Models/AlbumModel.php
app/Models/MusicaModel.php
app/Database/Migrations/             -> users, albuns, musicas
app/Views/auth/                      -> login.php, register.php
app/Views/albuns/                    -> index.php, form.php, show.php
app/Views/layouts/main.php           -> layout com CSS
public/uploads/albuns/               -> onde as capas ficam salvas
```

## Como rodar

1. **Banco de dados**: crie um banco MySQL vazio, por exemplo `albuns_ci`.

2. **Configuração**: edite o arquivo `.env` na raiz do projeto (já vem
   pronto, só ajuste usuário/senha do seu MySQL se precisar):

   ```
   CI_ENVIRONMENT = development
   database.default.hostname = localhost
   database.default.database = albuns_ci
   database.default.username = root
   database.default.password =
   database.default.DBDriver = MySQLi
   database.default.DBPrefix =
   database.default.port = 3306
   ```

3. **Rodar as migrations** (cria as tabelas `users`, `albuns` e `musicas`):

   ```bash
   php spark migrate --all
   ```

4. **Subir o servidor embutido do CodeIgniter**:

   ```bash
   php spark serve
   ```

   Ou aponte o DocumentRoot do Apache/XAMPP para a pasta `public/`.

5. Acesse `http://localhost:8080` (ou a porta que aparecer), clique em
   "Cadastre-se", crie sua conta e comece a cadastrar álbuns.

## Sobre o upload de imagens

O upload segue o padrão pedido no enunciado (baseado no exemplo do
professor): em `AlbumController::salvarCapa()`, o arquivo enviado é validado
(`is_image`, `mime_in`, `max_size`) e movido para `public/uploads/albuns`
usando um nome gerado automaticamente pelo CodeIgniter
(`$file->getRandomName()`), evitando colisão de nomes e não expondo o nome
original do arquivo do usuário. Apenas esse nome aleatório é salvo na coluna
`capa` da tabela `albuns`.

Ao editar um álbum, se nenhuma nova imagem for enviada, a capa atual é
mantida; se uma nova for enviada, a antiga é apagada do disco e substituída.
Ao excluir um álbum, o arquivo de imagem correspondente também é removido.

## Observação sobre o projeto original

O projeto que serviu de base (sistema bancário) tinha um arquivo de
configuração chamado `env` (sem o ponto no início), que por isso nunca era
lido pelo CodeIgniter — o sistema rodava só com os valores padrão do
`Config/Database.php`. Nesta versão o arquivo foi renomeado para `.env`
corretamente.

## Testes realizados

O fluxo completo foi validado localmente (servidor embutido + SQLite) antes
da entrega: cadastro, login, proteção de rota sem login, criação de álbum
com upload real de imagem (nome aleatório confirmado no disco e no banco),
edição (troca de nome/ano/músicas mantendo a imagem), validação de campos
obrigatórios (ex.: capa ausente é rejeitada) e exclusão em cascata
(álbum + músicas + arquivo de imagem).
