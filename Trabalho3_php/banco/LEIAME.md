# BancoCI — Sistema Bancário em CodeIgniter 4

Sistema bancário desenvolvido em CodeIgniter 4 com as funcionalidades:
- Cadastro de usuários com geração automática de username e número de conta
- Login e logout com sessões
- Extrato completo de transações
- Pagamentos via PIX, Boleto e Débito
- Transferências entre contas

---

## 📋 Pré-requisitos

- PHP 8.1+
- MySQL / MariaDB
- Composer (se precisar das dependências do CI4)
- Servidor web (Apache, Nginx) **ou** usar o servidor embutido do PHP

---

## ⚙️ Instalação passo a passo

### 1. Configurar o banco de dados

Abra o MySQL e execute o arquivo `banco_ci.sql`:

```sql
mysql -u root -p < banco_ci.sql
```

Ou copie e cole o conteúdo do arquivo no seu gerenciador (phpMyAdmin, DBeaver, etc.).

---

### 2. Configurar o arquivo `.env`

Renomeie o arquivo `env` para `.env`:

```bash
cp env .env
```

Edite o `.env` e preencha os dados do seu banco:

```
database.default.hostname = localhost
database.default.database = banco_ci
database.default.username = SEU_USUARIO_MYSQL
database.default.password = SUA_SENHA_MYSQL
```

---

### 3. Executar as migrations (alternativa ao SQL manual)

Se preferir usar as migrations do CI4 em vez do `.sql`:

```bash
php spark migrate
```

---

### 4. Iniciar o servidor

```bash
php spark serve
```

Acesse: **http://localhost:8080**

---

## 🗂️ Estrutura dos Arquivos Modificados/Criados

```
app/
├── Config/
│   ├── Filters.php          ← Filtro de autenticação configurado
│   └── Routes.php           ← Todas as rotas do sistema
├── Controllers/
│   ├── AuthController.php   ← Login, cadastro, logout
│   ├── DashboardController.php
│   ├── ExtratoController.php
│   ├── PagamentosController.php
│   └── TransferenciasController.php
├── Filters/
│   └── AuthFilter.php       ← Proteção de rotas autenticadas
├── Models/
│   ├── UserModel.php        ← Modelo de usuários
│   └── TransacaoModel.php   ← Modelo de transações
├── Database/
│   └── Migrations/
│       ├── ..._CreateUsersTable.php
│       └── ..._CreateTransacoesTable.php
└── Views/
    ├── layouts/main.php     ← Layout base com sidebar
    ├── auth/
    │   ├── login.php
    │   └── register.php
    ├── dashboard/index.php
    ├── extrato/index.php
    ├── pagamentos/index.php
    └── transferencias/index.php
```

---

## 🔐 Segurança implementada

| Recurso | Implementação |
|---|---|
| Senhas | `password_hash()` com BCRYPT + verificação via `password_verify()` |
| Sessões | CI4 Session nativa |
| Rotas protegidas | `AuthFilter` verifica sessão antes de cada request |
| Saldo insuficiente | Validação no `TransacaoModel::registrar()` |
| Conta inexistente | Verificação no controller de transferências |
| Auto-transferência | Bloqueada no controller |

---

## 💡 Como usar

1. Acesse `/register` e crie uma conta
2. Anote o **username** e **número de conta** exibidos após o cadastro
3. Faça login com o username e senha
4. Use o menu lateral para navegar entre Extrato, Pagamentos e Transferências

---

## 🗄️ Banco de Dados (Tabelas)

### `users`
| Campo | Tipo | Descrição |
|---|---|---|
| id | INT | Chave primária |
| nome | VARCHAR(100) | Nome completo |
| username | VARCHAR(50) | Login único gerado automaticamente |
| senha | VARCHAR(255) | Hash bcrypt da senha |
| numero_conta | VARCHAR(20) | Conta no formato XXXXX-X |
| saldo | DECIMAL(15,2) | Saldo atual |

### `transacoes` (relacionamento 1:N com users)
| Campo | Tipo | Descrição |
|---|---|---|
| id | INT | Chave primária |
| user_id | INT | FK para users |
| tipo | ENUM | 'debito' ou 'credito' |
| descricao | VARCHAR(255) | Ex: "Pag. PIX - Conta de luz" |
| valor | DECIMAL(15,2) | Valor da transação |
| saldo_apos | DECIMAL(15,2) | Saldo após a transação |
| created_at | DATETIME | Data/hora da transação |
