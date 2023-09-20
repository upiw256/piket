<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Late extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'late_id' => [
                'type' => 'VARCHAR',
                'constraint' => 36, // UUID as a string
            ],
            'registrasi_id' => [
                'type' => 'VARCHAR',
                'constraint' => 36, // UUID as a string
            ],
            'date_late'=>[
                'type' => 'VARCHAR',
                'constraint' => 255,
            ]
        ]);

        $this->forge->addKey('late_id', true);
        $this->forge->addForeignKey('registrasi_id', 'students', 'registrasi_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('late');
    }

    public function down()
    {
        $this->forge->dropTable('late');
    }
}
