<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

    <title>Document</title>

</head>

<body>

    <div class="container">

        <h1>Daftar Siswa Terlambat</h1>

        <a href="<?= base_url() ?>" class="btn btn-primary mb-4 btn-block">Data siswa</a>

        <table class="table" id="example">

            <thead>

                <tr>

                    <th>No</th>

                    <th>Nama</th>

                    <th>NISN</th>

                    <th>Nama Rombel</th>

                    <th>Terakhir kali terlambat</th>

                    <th>Jumlah Terlambat</th>

                </tr>

            </thead>

            <tbody>

                <?php

                // Baca data dari file terlambat.json

                $terlambatData = json_decode(file_get_contents(WRITEPATH . 'terlambat.json'), true);



                // Loop untuk menampilkan siswa yang terlambat

                $n = 1;

                foreach ($terlambatData as $siswa) : ?>

                    <tr>

                        <td><?= $n++ ?></td>

                        <td><?= $siswa['nama'] ?></td>

                        <td><?= $siswa['nisn'] ?></td>

                        <td><?= $siswa['nama_rombel'] ?></td>

                        <td><?= $siswa['tanggal'] ?></td>

                        <td><?= $siswa['terlambat'] ?> X</td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

    <script>
        $(document).ready(function() {

            $('#example').DataTable({

                responsive: true,

                order: [
                    [4, 'desc']
                ]

            });

        });
    </script>

</body>

</html>