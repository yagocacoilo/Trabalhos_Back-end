<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMusicasTable extends Migration
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
            'album_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'nome_musica' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'ordem' => [
                'type'       => 'INT',
                'constraint' => 5,
                'default'    => 0,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('album_id', 'albuns', 'id', false, 'CASCADE');
        $this->forge->createTable('musicas');
    }

    public function down(): void
    {
        $this->forge->dropTable('musicas');
    }
}
