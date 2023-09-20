<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelRekap extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'late';
    protected $primaryKey       = 'late_id';

    protected $allowedFields = [
        'late_id',
        'registrasi_id',
        'date_late',
        'count_late',
    ];
    public function count_late()
    {
        $db = \Config\Database::connect();
        $sql = "SELECT s.registrasi_id, s.nisn, s.nama, s.nama_rombel,MAX(l.date_late) as date_late ,COUNT(l.registrasi_id) as jumlah_terlambat
        FROM students s
        LEFT JOIN late l ON s.registrasi_id = l.registrasi_id
        GROUP BY s.registrasi_id, s.nisn, s.nama, s.nama_rombel
        HAVING jumlah_terlambat > 0
        ORDER BY jumlah_terlambat DESC;
        "; // Query SQL dengan parameter

        $query = $db->query($sql); // Menjalankan query dengan parameter


        return $query->getResult();
    }
}
