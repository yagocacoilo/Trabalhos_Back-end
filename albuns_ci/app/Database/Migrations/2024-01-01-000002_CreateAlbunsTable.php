<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAlbunsTable extends Migration
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
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'nome_album' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'ano' => [
                'type'       => 'INT',
                'constraint' => 4,
            ],
            'capa' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
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
        $this->forge->addForeignKey('user_id', 'users', 'id', false, 'CASCADE');
        $this->forge->createTable('albuns');
    }

    public function down(): void
    {
        $this->forge->dropTable('albuns');
    }
}
