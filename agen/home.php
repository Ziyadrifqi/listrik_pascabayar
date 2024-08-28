<?php  
// Ensure the menu parameter is set; otherwise, redirect
if (!isset($_GET['menu'])) {
    header('Location: hal_utama.php?menu=home');
    exit(); // Make sure no further script is executed
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
<video autoplay loop muted width="100%">
                <source src="../images/bg.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
    <div style="
    position: absolute;
    top: 33%;
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
        color: #e5383b; /* Warna teks judul */
    ">
        <?php echo $_SESSION['nama_agen']; ?>
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
<div class="visi-misi" style="
    background-color: #f7f7f7; /* Latar belakang abu-abu muda */
    padding: 40px; /* Ruang di sekitar konten */
    text-align: center; /* Menyelaraskan teks di tengah */
    display: flex;
    justify-content: space-between;
">
    <div style="
        width: 45%;
        background-color: #2f3ca1;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    ">
        <h2 style="
            font-size: 25px;
            margin: 0;
            color: white;
            font-family: Monaco, monospace;
        ">Visi Kami</h2>
        <p style="
        font-family: Monaco, monospace;
            font-size: 18px;
            margin: 0;
            color: white;
            text-align: justify;
        ">Menjadi penyedia jasa pembayaran pascabayar listrik yang terpercaya dan terkemuka di Indonesia.</p>
    </div>
    <div style="
        width: 45%;
        background-color: #2f3ca1;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    ">
        <h2 style="
            font-size: 25px;
            margin: 0;
            color: white;
            font-family: Monaco, monospace;
        ">Misi Kami</h2>
        <p style="
            font-size: 18px;
            margin: 0;
            color: white;
            text-align: justify;
            font-family: Monaco, monospace;
        ">Memberikan pelayanan yang cepat, aman, dan mudah dalam melakukan pembayaran pascabayar listrik.</p>
    </div>
</div>
</body>
</html>