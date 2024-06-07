<?php
// Memanggil file koneksi.php untuk menghubungkan dengan database
require_once "koneksi.php";
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pakar Diagnosa DBD</title>
    <!-- Bootstrap 5 CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top mask-custom shadow-0">
        <div class="container">
            <a class="navbar-brand" href="#landing-section"><span style="color: #B15EFF;">Diagnose</span><span style="color: #eaeab1;">Here</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" id="home" href="#landing-section">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="about" href="#about-section">About</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Navbar -->



    <section id="landing-section" style="background-color: #BEADFA; padding-top: 100px;">
        <div class="header-hero bg-fixed">
            <div class="container">
                <div class="row align-items-center justify-content-center justify-content-lg-between">
                    <div class="col-lg-5 col-md-10 d-flex">
                        <div class="header-hero-content">
                            <h1 class="header-title text-white"><span style="font-size: 50px;">Selamat Datang</span> <br> Pengguna!</h1>
                            <p class="lead text-white mb-0">Website ini dapat kamu gunakan untuk mendeteksi apakah kamu sedang mengalami DBD atau tidak.</p>
                            <br>
                            <a class="btn btn-landing" href="#content-section">Klik Disini Untuk Diagnosa</a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 d-none d-md-block text-end">
                        <div class="header-image">
                            <img src="image/nyamuk-3d.png" width="500px" height="500px" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <svg class="bg-light" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#BEADFA" fill-opacity="1" d="M0,192L48,202.7C96,213,192,235,288,213.3C384,192,480,128,576,112C672,96,768,128,864,122.7C960,117,1056,75,1152,74.7C1248,75,1344,117,1392,138.7L1440,160L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path>
    </svg>
    <section id="content-section" class="bg-light pb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-7 mb-4">
                    <h1 class="text-center" style="color: #B15EFF;">Diagnosa Dengan Gejala-Gejala Yang Kamu Alami Disini</h1>
                </div>
            </div>
            <div class="row justify-content-between p-4">
                <div class="col-md-6 p-4">
                    <h2 style="color: #B15EFF;">Diagnosa</h2>
                    <p>Silakan pilih gejala yang kamu alami dari daftar berikut:</p>
                    <form id="form-diagnosa" method="POST" action="proses.php">
                        <?php
                        // Membuat query untuk mengambil data gejala dari database
                        $query = "SELECT * FROM gejala ORDER BY kode_gejala ASC";
                        // Menjalankan query dan menyimpan hasilnya dalam variabel $result
                        $result = mysqli_query($koneksi, $query);
                        // Memeriksa apakah query berhasil atau gagal
                        if (!$result) {
                            die("Query gagal: " . mysqli_error($koneksi));
                        }
                        // Menggunakan perulangan while untuk menampilkan data gejala dalam bentuk checkbox
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Menyimpan kode gejala, nama gejala, dan bobot gejala dalam variabel
                            $kode_gejala = $row['kode_gejala'];
                            $nama_gejala = $row['nama_gejala'];
                            $bobot_gejala = $row['bobot_gejala'];
                            // Menampilkan checkbox dengan value kode gejala dan label nama gejala
                            echo "<div class='form-check'>";
                            echo "<input class='form-check-input' type='checkbox' name='gejala[]' value='$kode_gejala' id='$kode_gejala'>";
                            echo "<label class='form-check-label' for='$kode_gejala'>$nama_gejala</label>";
                            echo "</div>";
                        }
                        ?>
                        <br>
                        <button type="submit" class="btn btn-diagnosa">Diagnosa</button>
                    </form>
                </div>
                <div class="col-md-6 p-4">
                    <h2 style="color: #B15EFF;">Hasil</h2>
                    <p>Hasil diagnosa kamu akan ditampilkan di sini setelah kamu mengisi dan mengirimkan form di sebelah kiri.</p>
                    <div id="hasil-diagnosa"></div>
                </div>
            </div>
        </div>
    </section>
    <section id="about-section" style="padding: 50px;">
        <div class="container">
            <div class="row h-100 align-items-center py-5">
                <div class="col-lg-6">
                    <h1 class="display-4">About us</h1>
                    <p class="lead text-muted mb-0">Kami adalah mahasiswa dari Universitas Bina Insani yang memiliki latar belakang beragam, tetapi satu tujuan bersama: meningkatkan kesadaran dan pemahaman tentang DBD. Dengan pengetahuan kami dalam teknologi dan kesehatan, kami berupaya memberikan kontribusi positif bagi masyarakat.</p>
                </div>
                <div class="col-lg-6 d-none d-lg-block"><img src="https://bootstrapious.com/i/snippets/sn-about/illus.png" alt="" class="img-fluid"></div>
            </div>
        </div>
    </section>
    <section class="bg-light py-5">
        <div class="container py-5">
            <div class="row mb-4">
                <div class="col-lg-5">
                    <h2 class="display-4 font-weight-light">Our team</h2>
                    <p class="font-italic text-muted">Team kami terdiri dari beberapa nama di bawah ini.</p>
                </div>
            </div>

            <div class="row justify-content-center text-center">
                <!-- Team item-->
                <div class="col-xl-6 col-sm-6 mb-5">
                    <div class="bg-white rounded shadow-sm py-5 px-4"><img src="https://bootstrapious.com/i/snippets/sn-about/avatar-1.png" alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                        <h5 class="mb-0">Naufal Yusuf Fauzan</h5><span class="small text-uppercase text-muted">Mahasiswa</span>
                        <ul class="social mb-0 list-inline mt-3">
                            <li class="list-inline-item"><a href="#" class="social-link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951" />
                                    </svg></i></a></li>
                            <li class="list-inline-item"><a href="#" class="social-link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                                        <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865l8.875 11.633Z" />
                                    </svg></a></li>
                            <li class="list-inline-item"><a href="#" class="social-link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334" />
                                    </svg></i></a></li>
                            <li class="list-inline-item"><a href="#" class="social-link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                                        <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401m-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4" />
                                    </svg></i></a></li>
                        </ul>
                    </div>
                </div>
                <!-- End-->

                <!-- Team item-->
                <div class="col-xl-6 col-sm-6 mb-5">
                    <div class="bg-white rounded shadow-sm py-5 px-4"><img src="https://bootstrapious.com/i/snippets/sn-about/avatar-3.png" alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                        <h5 class="mb-0">Pajri Nur Iqrom</h5><span class="small text-uppercase text-muted">Mahasiswa</span>
                        <ul class="social mb-0 list-inline mt-3">
                            <li class="list-inline-item"><a href="#" class="social-link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951" />
                                    </svg></i></a></li>
                            <li class="list-inline-item"><a href="#" class="social-link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                                        <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865l8.875 11.633Z" />
                                    </svg></a></li>
                            <li class="list-inline-item"><a href="#" class="social-link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334" />
                                    </svg></i></a></li>
                            <li class="list-inline-item"><a href="#" class="social-link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                                        <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401m-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4" />
                                    </svg></i></a></li>
                        </ul>
                    </div>
                </div>
                <!-- End-->

                <!-- Team item-->
                <div class="col-xl-6 col-sm-6 mb-5">
                    <div class="bg-white rounded shadow-sm py-5 px-4"><img src="https://bootstrapious.com/i/snippets/sn-about/avatar-2.png" alt="" width="100" class="img-fluid rounded-circle mb-3 img-thumbnail shadow-sm">
                        <h5 class="mb-0">Arya Bima Aditya</h5><span class="small text-uppercase text-muted">Mahasiswa</span>
                        <ul class="social mb-0 list-inline mt-3">
                            <li class="list-inline-item"><a href="#" class="social-link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951" />
                                    </svg></i></a></li>
                            <li class="list-inline-item"><a href="#" class="social-link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                                        <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865l8.875 11.633Z" />
                                    </svg></a></li>
                            <li class="list-inline-item"><a href="#" class="social-link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334" />
                                    </svg></i></a></li>
                            <li class="list-inline-item"><a href="#" class="social-link"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                                        <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401m-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4" />
                                    </svg></i></a></li>
                        </ul>
                    </div>
                </div>
                <!-- End-->
            </div>
        </div>
        </div>
    </section>
    <section style="background-color: #BEADFA" id="section-footer">
        <div class="container">
            <div class="row p-5">
                <h5 class="text-center text-white">Made With Love by Students of Bina Insani University</h5>
            </div>
        </div>
    </section>
    <section style="background-color: #B15EFF;">
        <div class="container">
            <div class="row justify-content-center pt-3">
                <p class="text-center">© 2023 Copyright: Bina Insani University</p>
            </div>
        </div>
    </section>
    <!-- Bootstrap 5 CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-cs/R21mBHCph1c14Ly2uG0L6z6O/uwr4K6Ka4dMByv2WTva4eQvIKtfhCbl6PUU5" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-rHyoN1iRsVXV4nDMyEP0gHfFfe7WvqZ9s5YFvsiznnA06ujKtwz3E+8GnBE3S+g" crossorigin="anonymous"></script>
    
    <!-- Custom JavaScript -->
    <script>

            // Get the form element
            var form = document.getElementById("form-diagnosa");

            // Add an event listener to the form submit
            form.addEventListener("submit", function(event) {
                // Prevent the default form submit action
                event.preventDefault();

                // Get the form data as an array of key-value pairs
                var formData = new FormData(form);

                // Create an XMLHttpRequest object
                var xhr = new XMLHttpRequest();

                // Set the request method, URL, and asynchronous flag
                xhr.open("POST", "proses.php", true);

                // Add an event listener for when the request state changes
                xhr.onreadystatechange = function() {
                    // Check if the request is completed and successful
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Get the response text from the server
                        var response = xhr.responseText;

                        // Get the element to display the result
                        var hasil = document.getElementById("hasil-diagnosa");

                        // Set the inner HTML of the result element to the response text
                        hasil.innerHTML = response;
                    }
                };

                // Send the request with the form data
                xhr.send(formData);
            });
        
    </script>
</body>

</html>