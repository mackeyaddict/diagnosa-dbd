<?php
// Memanggil file koneksi.php untuk menghubungkan dengan database
require_once "koneksi.php";

// Memeriksa apakah data gejala ada atau tidak
if (isset($_POST['gejala'])) {
    // Menyimpan data gejala dalam variabel $gejala
    $gejala = $_POST['gejala'];
    // Menghitung jumlah gejala yang dipilih
    $jumlah_gejala = count($gejala);

    // Membuat variabel untuk menyimpan bobot gejala total
    $bobot_gejala_total = 0;
    // Menggunakan perulangan for untuk menambahkan bobot gejala dari setiap gejala yang dipilih
    for ($i = 0; $i < $jumlah_gejala; $i++) {
        // Menyimpan kode gejala dalam variabel $kode_gejala
        $kode_gejala = $gejala[$i];
        // Membuat query untuk mengambil data gejala dari database
        $query = "SELECT * FROM gejala WHERE kode_gejala = '$kode_gejala'";
        // Menjalankan query dan menyimpan hasilnya dalam variabel $result
        $result = mysqli_query($koneksi, $query);
        // Memeriksa apakah query berhasil atau gagal
        if (!$result) {
            die("Query gagal: " . mysqli_error($koneksi));
        }
        // Menggunakan perulangan while untuk menelusuri data gejala
        while ($row = mysqli_fetch_assoc($result)) {
            // Menyimpan bobot gejala dalam variabel $bobot_gejala
            $bobot_gejala = $row['bobot_gejala'];
            // Menambahkan bobot gejala ke variabel $bobot_gejala_total
            $bobot_gejala_total = $bobot_gejala_total + $bobot_gejala;
        }
    }

    // Membuat variabel untuk menyimpan hasil diagnosa
    $hasil_diagnosa = "";
    // Menggunakan perulangan for untuk menentukan hasil diagnosa berdasarkan aturan yang sesuai dengan bobot gejala total
    for ($i = 1; $i <= 4; $i++) {
        // Menyimpan kode aturan dalam variabel $kode_aturan
        $kode_aturan = "A00" . $i;
        // Membuat query untuk mengambil data aturan dari database
        $query = "SELECT * FROM aturan WHERE kode_aturan = '$kode_aturan'";
        // Menjalankan query dan menyimpan hasilnya dalam variabel $result
        $result = mysqli_query($koneksi, $query);
        // Memeriksa apakah query berhasil atau gagal
        if (!$result) {
            die("Query gagal: " . mysqli_error($koneksi));
        }
        // Menggunakan perulangan while untuk menelusuri data aturan
        while ($row = mysqli_fetch_assoc($result)) {
            // Menyimpan kondisi dan konsekuensi aturan dalam variabel
            $kondisi = $row['kondisi'];
            $konsekuensi = $row['konsekuensi'];
            // Memeriksa apakah bobot gejala total sesuai dengan kondisi aturan
            if (eval("return $bobot_gejala_total $kondisi;")) {
                // Menyimpan konsekuensi aturan sebagai hasil diagnosa
                $hasil_diagnosa = $konsekuensi;
            }
        }
    }

    // Menampilkan hasil diagnosa dalam bentuk paragraf
    echo "<p>Hasil diagnosa kamu adalah:</p>";
    // Membuat query untuk mengambil data penyakit dari database
    $query = "SELECT * FROM penyakit WHERE kode_penyakit = '$hasil_diagnosa'";
    // Menjalankan query dan menyimpan hasilnya dalam variabel $result
    $result = mysqli_query($koneksi, $query);
    // Memeriksa apakah query berhasil atau gagal
    if (!$result) {
        die("Query gagal: " . mysqli_error($koneksi));
    }
    // Menggunakan perulangan while untuk menelusuri data penyakit
    while ($row = mysqli_fetch_assoc($result)) {
        // Menyimpan nama penyakit dan deskripsi penyakit dalam variabel
        $nama_penyakit = $row['nama_penyakit'];
        $deskripsi_penyakit = $row['deskripsi_penyakit'];
        // Menampilkan nama penyakit dan deskripsi penyakit dalam bentuk paragraf
        echo "<p class='text-success'><span><strong>$nama_penyakit:</strong></span> $deskripsi_penyakit</p>";
    }
} else {
    // Menampilkan pesan jika data gejala tidak ada
    echo "<p class='text-danger'>Kamu belum memilih gejala apapun. Silakan pilih gejala yang kamu alami dari daftar di sebelah kiri.</p>";
}
