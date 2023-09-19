<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelSiswa;

class ControllerTerlambat extends BaseController
{
    public function index()
    {
        // // URL API yang berisi data mahasiswa
        // $apiUrl = 'http://192.168.5.191:8080/siswa';

        // // Mengambil data dari API menggunakan cURL atau library lainnya
        // $ch = curl_init($apiUrl);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $response = curl_exec($ch);
        // curl_close($ch);

        // // Mengubah respons JSON menjadi array
        // $data['students'] = json_decode($response, true);

        // // Menampilkan view dengan data
        // $filePath = WRITEPATH . 'data.json';
        // $jsonData = file_get_contents($filePath);
        // $data['students'] = json_decode($jsonData, true);
        $model = new ModelSiswa();
        $data['students'] = $model->findAll();
        return view('students/index', $data);
    }

    public function syncData()
    {
        // URL API yang akan digunakan untuk mengambil data
        $apiUrl = 'http://103.229.14.238:8080/siswa';
        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if ($response === false) {
            return "Gagal mengambil data dari API.";
        }
        curl_close($ch);
        $data = json_decode($response, true);
        $insertData = [];
        $model = new ModelSiswa();

        foreach ($data['rows'] as $row) {
            $insertData[] = [
                'registrasi_id' => $row['registrasi_id'],
                'NIPD' => $row['nipd'],
                'nama' => $row['nama'],
                'nisn' => $row['nisn'],
                'jenis_kelamin' => $row['jenis_kelamin'],
                'nik' => $row['nik'],
                'tempat_lahir' => $row['tempat_lahir'],
                'tanggal_lahir' => $row['tanggal_lahir'],
                'agama_id_str' => $row['agama_id_str'],
                'alamat_jalan' => $row['alamat_jalan'],
                'nama_ayah' => $row['nama_ayah'],
                'email' => $row['email'],
                'tingkat_pendidikan_id' => $row['tingkat_pendidikan_id'],
                'nama_rombel' => $row['nama_rombel'],
            ];
        }

        // Gunakan insertBatch untuk memasukkan semua data sekaligus
        $model->insertBatch($insertData);

        session()->setFlashdata('success', 'Data berhasil diambil dari API dan disimpan ke database.');

        return view('students/index');

        // Mendapatkan data dari API
        // $response = file_get_contents($apiUrl);

        // // Cek apakah ada data yang diterima dari API
        // if ($response === false) {
        //     return $this->fail('Gagal mengambil data dari API.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        // }

        // // Menyimpan data ke file JSON
        // $filePath = WRITEPATH . 'data.json';
        // if (file_put_contents($filePath, $response) === false) {
        //     return $this->fail('Data berhasil disinkronisasi.', ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        // }

        // return $this->respond('Data berhasil disinkronisasi.', ResponseInterface::HTTP_OK);
    }

    public function updateTerlambat()
    { {
            // Mendapatkan data yang dikirim dari JavaScript
            $inputData = json_decode($this->request->getBody(), true);

            // Baca file terlambat.json (pastikan file tersebut ada di folder yang benar)
            $terlambatFile = WRITEPATH . 'terlambat.json';
            $terlambatData = file_exists($terlambatFile) ? json_decode(file_get_contents($terlambatFile), true) : [];

            // Cek apakah NISN sudah ada dalam data terlambat
            if (isset($terlambatData[$inputData['nisn']])) {
                // Jika sudah ada, tambahkan jumlah terlambat
                $terlambatData[$inputData['nisn']]['terlambat'] += 1;
            } else {
                // Jika belum ada, tambahkan NISN ke data terlambat
                $terlambatData[$inputData['nisn']] = [
                    'nama' => $inputData['nama'],
                    'nisn' => $inputData['nisn'],
                    'nama_rombel' => $inputData['nama_rombel'],
                    'tanggal' => date("Y-m-d"),
                    'terlambat' => 1
                ];
            }

            // Simpan data terlambat ke file terlambat.json
            if (file_put_contents($terlambatFile, json_encode($terlambatData, JSON_PRETTY_PRINT)) === false) {
                return $this->fail('Gagal menyimpan data terlambat.');
            }
            // return $this->respond(['message' => 'Data terlambat berhasil diperbarui.']);
        }
    }
    function terlambat()
    {
        return view('students/terlambat');
    }
}
