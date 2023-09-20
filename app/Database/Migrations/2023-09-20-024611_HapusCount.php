<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HapusCount extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('late', 'count_late');
    }

    public function down()
    {
        $fields = [
            'count_late' => [
                'type' => 'INT',
                'constraint' => 12,
            ],
        ];

        $this->forge->addColumn('late', $fields);
    }
}
