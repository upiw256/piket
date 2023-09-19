<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelSiswa extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'students';
    protected $primaryKey       = 'registrasi_id';

    protected $allowedFields = [
        'registrasi_id',
        'nama',
        'nisn',
        'jenis_kelamin',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'agama_id_str',
        'alamat_jalan',
        'nama_ayah',
        'email',
        'tingkat_pendidikan_id',
        'nama_rombel',
    ];
}
