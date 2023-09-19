<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta property="og:title" content="Aplikasi Piket">

    <meta property="og:description" content="APlikasi yang digunakan untuk mendata siswa yang terlambat">

    <!-- jQuery -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables CSS -->

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

    <!-- DataTables Responsive CSS -->

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.css">

    <!-- DataTables JS -->

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <!-- DataTables Responsive JS -->

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
        .loading-spinner {

            display: none;

        }
    </style>

    <title>Aplikasi Piket</title>

</head>

<body>

    <div class="container mt-4">

        <h1>Daftar Siswa seluruh</h1>

        <button id="syncButton" class="btn btn-primary mb-4 btn-block">Sync Data dapodik</button>
        <div class="text-center mt-3">

            <div class="spinner-border text-primary loading-spinner" role="status">

                <span class="sr-only">Loading...</span>

            </div>

        </div>
        <a href="<?= base_url() ?>/terlambat" class="btn btn-warning mb-4 btn-block">Data siswa terlambat</a>

        <div class="table-responsive">

            <table id="example" class="display table table-striped" style="width:100%">

                <thead>

                    <tr>

                        <th>NIPD</th>

                        <th>Nama</th>

                        <th>NISN</th>

                        <th>Jenis Kelamin</th>

                        <th>Tempat Lahir</th>

                        <th>Tanggal Lahir</th>

                        <th>Agama</th>

                        <th>Alamat</th>

                        <th>Nama Ayah</th>

                        <th>Nama Rombel</th>

                        <th>Aksi</th>



                    </tr>

                </thead>

                <tbody>

                    <?php

                    foreach ($students as $student) : ?>

                        <tr>

                            <td><?= $student['nipd'] ?? '-' ?></td>

                            <td><?= $student['nama'] ?? '-' ?></td>

                            <td><?= $student['nisn'] ?? '-' ?></td>

                            <td><?= $student['jenis_kelamin'] ?? '-' ?></td>

                            <td><?= $student['tempat_lahir'] ?? '-' ?></td>

                            <td><?= $student['tanggal_lahir'] ?? '-' ?></td>

                            <td><?= $student['agama_id_str'] ?? '-' ?></td>

                            <td><?= $student['alamat_jalan'] ?? '-' ?></td>

                            <td><?= $student['nama_ayah'] ?? '-' ?></td>

                            <td><?= $student['nama_rombel'] ?? '-' ?></td>

                            <td><button type="button" class="btn btn-danger">Terlambat</button></td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

    <script>
        $(document).ready(function() {

            $('#example').DataTable({

                responsive: false,

                order: [
                    [1, 'asc']
                ]

            });

            handleTerlambatButtonClick();

        });



        $(document).ready(function() {
            $("#syncButton").click(function() {
                // Melakukan AJAX request ke controller
                $.ajax({
                    url: "<?= base_url('/sync') ?>",
                    type: "GET"
                });
            });
        });

        // function syncData() {

        //     fetch('/sync')

        //         .then(response => {

        //             if (!response.ok) {

        //                 throw new Error('Data Berhasil syncron');

        //             }

        //             return response.text();

        //         })

        //         .then(message => {

        //             alert(message);

        //         })

        //         .catch(error => {

        //             alert(error.message);

        //         });

        // }

        $(document).ready(function() {

            // Mendapatkan elemen tombol dan indikator loading

            var syncButton = $('#syncButton');

            var loadingSpinner = $('.loading-spinner');



            // Mengubah tampilan tombol saat tombol ditekan

            syncButton.click(function() {

                syncButton.prop('disabled', true); // Menonaktifkan tombol

                syncButton.html('Syncing...'); // Mengubah teks tombol

                loadingSpinner.show(); // Menampilkan indikator loading



                // Simulasi permintaan asinkron (Anda dapat menggantinya dengan pengambilan data dari API)

                setTimeout(function() {

                    // Menjalankan tugas sinkronisasi di sini (contohnya, mengambil data dari API)

                    // Setelah tugas selesai, aktifkan kembali tombol dan sembunyikan indikator loading

                    syncButton.prop('disabled', false);

                    syncButton.html('Sync Data dapodik');

                    loadingSpinner.hide();
                    alert("sukses sync")

                    // alert('Data berhasil disinkronisasi.');

                }, 5000); // Contoh: Menunggu 3 detik sebelum menyelesaikan sinkronisasi

            });

        });



        function handleTerlambatButtonClick() {

            $(document).on('click', 'button.btn-danger', function() {

                var rowData = $(this).closest('tr').find('td');

                var nama = rowData.eq(1).text(); // Ambil Nama dari kolom kedua

                var nisn = rowData.eq(2).text(); // Ambil NISN dari kolom ketiga

                var nama_rombel = rowData.eq(9).text(); // Ambil Nama Rombel dari kolom kesepuluh

                var terlambatData = {

                    nama: nama,

                    nisn: nisn,

                    nama_rombel: nama_rombel,

                    terlambat: 1 // Bertambah 1 setiap kali tombol ditekan

                };



                // Kirim data ke server atau simpan ke file terlambat.json

                $.ajax({

                    type: 'POST', // Anda bisa mengganti metode sesuai dengan kebutuhan Anda

                    url: '<?= base_url() ?>/update-terlambat', // Gantilah dengan endpoint yang sesuai di server Anda

                    data: JSON.stringify(terlambatData),

                    contentType: 'application/json',

                    success: function(response) {

                        // Tampilkan pesan atau lakukan tindakan lain jika berhasil

                        alert(response.message);

                    },

                    error: function(error) {

                        // Tangani kesalahan jika terjadi

                        alert('Terjadi kesalahan: ' + error.responseText);

                    }

                });

            });

        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>