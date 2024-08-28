<br>
<?php 
	if (!isset($_GET['menu'])) {
	 	header('location:hal_utama.php?menu=home');
	}
    
?>
<!DOCTYPE html>
<html>
<head>
	<title>HOME</title>
</head>
<link rel="stylesheet" type="text/css"	href="css/style.css">
<style type="text/css">
  .middle {
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
	text-align: center;
  }
</style>
<body>
<div style="position: relative; text-align: center;">
<img src="../images/bg.jpg" width="90%" style="display: block; margin: auto; margin-top: -50px;" alt="Background Image">
    <div style="
    position: absolute;
    top: 35%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(255, 255, 255, 0.8); /* Latar belakang putih dengan transparansi */
    border: 1px solid rgba(0, 0, 0, 0.2); /* Border hitam dengan transparansi */
    padding: 30px; /* Ruang di sekitar konten */
    border-radius: 15px; /* Sudut card melengkung lebih besar */
    max-width: 80%; /* Lebar maksimum card */
    color: black; /* Warna teks */
    font-family: 'Myriad Pro Light', sans-serif; /* Font untuk teks */
    text-align: center; /* Menyelaraskan teks di tengah card */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Bayangan card */
    transition: transform 0.3s ease, box-shadow 0.3s ease; /* Animasi saat card di-hover */
    padding-top: 20px; /* Jarak vertikal di atas card */
    padding-bottom: 20px; /* Jarak vertikal di bawah card */
">
    <h1 style="
		font-family: Monaco, monospace;
        font-size: 60px; /* Ukuran font untuk judul */
        margin: 0; /* Menghapus margin default */
        color: #333; /* Warna teks judul */
    ">Selamat Datang <div style="
		font-family: 'Copperplate', sans-serif;
        font-size: 40px; /* Ukuran font untuk judul */
        margin: 0; /* Menghapus margin default */
        color: #142d73; /* Warna teks judul */
    ">
        <?php echo $_SESSION['nama_petugas']; ?>
    </div> di BrightPower!</h1>
	
    <hr style="
        margin: 20px 0; /* Jarak vertikal di atas dan bawah garis */
        border: 0; /* Menghapus border default */
        border-top: 2px solid black; /* Garis pemisah */
    ">
    <p style="
        font-size: 30px; /* Ukuran font untuk paragraf */
		font-family: 'Perpetua', serif;
        margin: 0; /* Menghapus margin default */
        color: #333; /* Warna teks paragraf */
    ">Pembayaran Pascabayar Listrik</p>
</div>

</body>
</html>