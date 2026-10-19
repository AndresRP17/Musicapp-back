<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTeachersTable extends Migration
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
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'surname' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'dni' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
            'birth_date' => [
                'type' => 'DATE',
                'null' => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('teachers');
    }

    public function down(): void
    {
        $this->forge->dropTable('teachers', true);
    }
}
