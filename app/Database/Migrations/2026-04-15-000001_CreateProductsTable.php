<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductsTable extends Migration
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
            'description' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'price' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('products');
    }

    public function down(): void
    {
        $this->forge->dropTable('products', true);
    }
}
