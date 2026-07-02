<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransacoesTable extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'     => 'INT',
                'constraint' => 11,
                'unsigned'  => true,
            ],
            'tipo' => [
                // debito, credito
                'type'       => 'ENUM',
                'constraint' => ['debito', 'credito'],
            ],
            'descricao' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'valor' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'saldo_apos' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('transacoes');
    }

    public function down(): void
    {
        $this->forge->dropTable('transacoes');
    }
}
