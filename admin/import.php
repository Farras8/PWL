<?php
// Load file koneksi.php
include "../config/db.php";

// Load file autoload.php
require '../vendor/autoload.php';

// Include librari PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

if(isset($_POST['import'])){ // Jika user mengklik tombol Import
	$nama_file_baru = $_POST['namafile'];
    $path = 'tmp/' . $nama_file_baru; // Set tempat menyimpan file tersebut dimana

    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    $spreadsheet = $reader->load($path); // Load file yang tadi diupload ke folder tmp
    $sheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

	$numrow = 1;
	foreach($sheet as $row){
		// Ambil data pada excel sesuai Kolom
		$category_id = $row['A']; // Ambil data nama
		$name = $row['B']; // Ambil data jenis kelamin
		$description = $row['C'];
		$price = $row['D']; // Ambil data telepon
		$quantity = $row['E']; // Ambil data alamat

		// Cek jika semua data tidak diisi
		if($category_id == "" && $name == "" && $description == "" && $price == "" && $quantity == "")
			continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)

		// Cek $numrow apakah lebih dari 1
		// Artinya karena baris pertama adalah nama-nama kolom
		// Jadi dilewat saja, tidak usah diimport
		if($numrow > 1){
			// Buat query Insert
			$query = "INSERT INTO products (category_id, name, description, price, quantity) VALUES('" . $category_id . "','" . $name . "','" . $description . "','" . $price . "','" . $quantity . "')";

			// Eksekusi $query
			mysqli_query($conn, $query);
		}

		$numrow++; // Tambah 1 setiap kali looping
	}

    unlink($path); // Hapus file excel yg telah diupload, ini agar tidak terjadi penumpukan file
}

header('location: products.php'); // Redirect ke halaman awal