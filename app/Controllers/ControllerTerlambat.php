<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Ramsey\Uuid\Uuid;

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
        $model = $this->modelSiswa;
        $data['students'] = $model->findAll();
        return view('students/index', $data);
    }

    public function syncData()
    {
        // URL API
        $apiUrl = 'http://103.229.14.238:8080/siswa';

        // Mendapatkan respons dari API
        $client = \Config\Services::curlrequest();
        $response = $client->request('GET', $apiUrl);

        // Parsing data JSON
        $data = json_decode($response->getBody());

        // Menyimpan data ke dalam database
        if ($data && isset($data->rows) && is_array($data->rows)) {
            foreach ($data->rows as $siswa) {
                // Mencari siswa berdasarkan kolom yang unik, misalnya 'registrasi_id'
                $siswaModel = $this->modelSiswa; // Ganti dengan model yang sesuai
                $existingSiswa = $siswaModel->where('registrasi_id', $siswa->registrasi_id)->first();

                if ($existingSiswa) {
                    // Jika data sudah ada, lakukan update
                    $siswaModel->update($existingSiswa['registrasi_id'], [
                        'nama' => $siswa->nama,
                        'nisn' => $siswa->nisn,
                        'jenis_kelamin' => $siswa->jenis_kelamin,
                        'nik' => $siswa->nik,
                        'tempat_lahir' => $siswa->tempat_lahir,
                        'tanggal_lahir' => $siswa->tanggal_lahir,
                        'agama_id_str' => $siswa->agama_id_str,
                        'alamat_jalan' => $siswa->alamat_jalan,
                        'nama_ayah' => $siswa->nama_ayah,
                        'email' => $siswa->email,
                        'tingkat_pendidikan_id' => $siswa->tingkat_pendidikan_id,
                        'nama_rombel' => $siswa->nama_rombel
                        // Sisipkan kolom lain yang ingin Anda update
                    ]);
                } else {
                    // Jika data belum ada, lakukan insert
                    // dd($siswa->nama);
                    $siswaModel->insert([
                        'registrasi_id' => $siswa->registrasi_id,
                        'nama' => $siswa->nama,
                        'nisn' => $siswa->nisn,
                        'jenis_kelamin' => $siswa->jenis_kelamin,
                        'nik' => $siswa->nik,
                        'tempat_lahir' => $siswa->tempat_lahir,
                        'tanggal_lahir' => $siswa->tanggal_lahir,
                        'agama_id_str' => $siswa->agama_id_str,
                        'alamat_jalan' => $siswa->alamat_jalan,
                        'nama_ayah' => $siswa->nama_ayah,
                        'email' => $siswa->email,
                        'tingkat_pendidikan_id' => $siswa->tingkat_pendidikan_id,
                        'nama_rombel' => $siswa->nama_rombel
                        // Sisipkan kolom lain yang sesuai dengan struktur tabel Anda
                    ]);
                }
            }

            // Berikan respons JSON sukses jika berhasil
            return $this->response->setJSON(['message' => 'Data siswa berhasil diimpor', 'status' => 200])->setStatusCode(200);
        } else {
            // Berikan respons JSON gagal jika terjadi kesalahan
            return $this->response->setJSON(['message' => 'Gagal mengimpor data siswa', 'status' => 500])->setStatusCode(500);
        }
    }

    public function updateTerlambat()
    { 
        $uuid = Uuid::uuid4()->toString();
        $model = $this->modelRekap;
        $siswa = $this->modelSiswa;
        $inputData = json_decode($this->request->getBody(), true);
        $existingSiswa = $siswa->where('nisn', $inputData['nisn'])->first();
            $model->insert([
                'late_id'=> $uuid,
                'registrasi_id' => $existingSiswa['registrasi_id'],
                'date_late'=>date("d-m-Y H:i:s")
                // Sisipkan kolom lain yang sesuai dengan struktur tabel Anda
            ]);
            return $this->response->setJSON(['hasil' => $existingSiswa['nama'], 'status' => 200])->setStatusCode(200);


            // // Mendapatkan data yang dikirim dari JavaScript
            // $inputData = json_decode($this->request->getBody(), true);

            // // Baca file terlambat.json (pastikan file tersebut ada di folder yang benar)
            // $terlambatFile = WRITEPATH . 'terlambat.json';
            // $terlambatData = file_exists($terlambatFile) ? json_decode(file_get_contents($terlambatFile), true) : [];

            // // Cek apakah NISN sudah ada dalam data terlambat
            // if (isset($terlambatData[$inputData['nisn']])) {
            //     // Jika sudah ada, tambahkan jumlah terlambat
            //     $terlambatData[$inputData['nisn']]['terlambat'] += 1;
            // } else {
            //     // Jika belum ada, tambahkan NISN ke data terlambat
            //     $terlambatData[$inputData['nisn']] = [
            //         'nama' => $inputData['nama'],
            //         'nisn' => $inputData['nisn'],
            //         'nama_rombel' => $inputData['nama_rombel'],
            //         'tanggal' => date("Y-m-d"),
            //         'terlambat' => 1
            //     ];
            // }

            // // Simpan data terlambat ke file terlambat.json
            if (file_put_contents($terlambatFile, json_encode($terlambatData, JSON_PRETTY_PRINT)) === false) {
                return $this->fail('Gagal menyimpan data terlambat.');
            }
        
    }
    function terlambat()
    {
        $model = $this->modelRekap;
        $data['terlambatData'] = $model->count_late();
        return view('students/terlambat',$data);
    }
}
