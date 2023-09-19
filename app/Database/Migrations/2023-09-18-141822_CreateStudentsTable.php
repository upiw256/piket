<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'registrasi_id' => [
                'type' => 'VARCHAR',
                'constraint' => 36, // UUID as a string
                'default' => '7a5f8a9a-ab17-400a-aee9-3e13be170d57',
            ],
            'NIPD' => [
                'type' => 'VARCHAR',
                'constraint' => 255, // Sesuaikan dengan kebutuhan
                'null' => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'nisn' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'jenis_kelamin' => [
                'type' => 'ENUM',
                'constraint' => ['P', 'L'], // Pilihan jenis kelamin
            ],
            'nik' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'tempat_lahir' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
            ],
            'agama_id_str' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'alamat_jalan' => [
                'type' => 'TEXT',
            ],
            'nama_ayah' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'tingkat_pendidikan_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'nama_rombel' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
        ]);

        $this->forge->addKey('registrasi_id', true);
        $this->forge->createTable('students');
    }

    public function down()
    {
        $this->forge->dropTable('students');
    }
}
