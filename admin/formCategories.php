<?php
// Load file autoload.php
require '../vendor/autoload.php';

// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <title>Import Data Excel dengan PhpSpreadsheet</title>

    <!-- Load File jquery.min.js yang ada difolder js -->
    <script src="js/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            // Sembunyikan alert validasi kosong
            $("#kosong").hide();
        });
    </script>
</head>

<body>
    <div class="container mt-5" style="background-color: white;     border: 20px solid white;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    border-radius: 10px;">
        <h3 class="text-center">Form Import Data Categories</h3>

        <form method="post" action="formCategories.php" enctype="multipart/form-data">
            <a href="categories.php" class="btn btn-danger">Kembali</a>
            <a href="formatExc/format-categories.xlsx" class="btn btn-primary" >Download format excel</a>
            <br><br>

            <div class="mb-3">
                <input type="file" name="file" class="form-control">
            </div>
            <button type="submit" name="preview" class="btn btn-success">Preview</button>
        </form>
        <hr>

        <?php
        // Jika user telah mengklik tombol Preview
        if (isset($_POST['preview'])) {
            $tgl_sekarang = date('YmdHis'); // Ini akan mengambil waktu sekarang dengan format yyyymmddHHiiss
            $nama_file_baru = 'data' . $tgl_sekarang . '.xlsx';

            // Cek apakah terdapat file data.xlsx pada folder tmp
            if (is_file('tmp/' . $nama_file_baru)) // Jika file tersebut ada
                unlink('tmp/' . $nama_file_baru); // Hapus file tersebut

            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION); // Ambil ekstensi filenya apa
            $tmp_file = $_FILES['file']['tmp_name'];


            if ($ext == "xlsx") {

                move_uploaded_file($tmp_file, 'tmp/' . $nama_file_baru);

                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                $spreadsheet = $reader->load('tmp/' . $nama_file_baru); // Load file yang tadi diupload ke folder tmp
                $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

                // Buat sebuah tag form untuk proses import data ke database
                echo "<form method='post' action='importCategories.php' class='mt-4'>";
                echo "<input type='hidden' name='namafile' value='" . $nama_file_baru . "'>";

                echo "<table class='table table-bordered mt-4'>
                        <thead>
                            <tr>
                                <th colspan='5' class='text-center'>Preview Data</th>
                            </tr>
                            <tr>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>";

                $numrow = 1;
                $kosong = 0;
                foreach ($sheet as $row) { // Lakukan perulangan dari data yang ada di excel
                    $name = $row['A']; // Ambil data nama


                    // Cek jika semua data tidak diisi
                    if ($name == "")
                        continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

                    // Cek $numrow apakah lebih dari 1
                    // Artinya karena baris pertama adalah nama-nama kolom
                    // Jadi dilewat saja, tidak usah diimport
                    if ($numrow > 1) {
                        // Validasi apakah semua data telah diisi
                        $name_td = (!empty($name)) ? "" : " style='background: #E07171;'";


                        // Jika salah satu data ada yang kosong
                        if ($name == "") {
                            $kosong++; // Tambah 1 variabel $kosong
                        }

                        echo "<tr>";
                        echo "<td" . $name_td . ">" . $name . "</td>";
                        echo "</tr>";
                    }

                    $numrow++; // Tambah 1 setiap kali looping
                }

                echo "</table>";

                // Cek apakah variabel kosong lebih dari 0
                // Jika lebih dari 0, berarti ada data yang masih kosong
                if ($kosong > 0) {
        ?>
                    <script>
                        $(document).ready(function() {
                            // Ubah isi dari tag span dengan id jumlah_kosong dengan isi dari variabel kosong
                            $("#jumlah_kosong").html('<?php echo $kosong; ?>');

                            $("#kosong").show(); // Munculkan alert validasi kosong
                        });
                    </script>
        <?php
                } else { // Jika semua data sudah diisi
                    echo "<hr>";

                    // Buat sebuah tombol untuk mengimport data ke database
                    echo "<button class='btn btn-warning' type='submit' name='importCategories'>Import</button>";
                }

                echo "</form>";
            } else { // Jika file yang diupload bukan File Excel 2007 (.xlsx)
                // Munculkan pesan validasi
                echo "<div style='color: red;margin-bottom: 10px;'>
					Hanya File Excel 2007 (.xlsx) yang diperbolehkan
                </div>";
            }
        }
        ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </div>
</body>

</html>