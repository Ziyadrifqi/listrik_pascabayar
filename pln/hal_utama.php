<br> <br> <br><br>
<?php  
	include '../config/koneksi.php';
	include '../library/fungsi.php';

	session_start();
	date_default_timezone_set("Asia/Jakarta");

	$aksi = new oop($conn);
	if (empty($_SESSION['username_petugas'])) {
		$aksi->alert("Harap Login Dulu !!!","index.php");
	}

	if (isset($_GET['logout'])) {
		unset($_SESSION['username_petugas']);
		unset($_SESSION['id_petugas']);
		unset($_SESSION['nama_petugas']);
		unset($_SESSION['akses_petugas']);
		$aksi->alert("logout Berhasil !!!","index.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>BRIGHT POWER - ADMIN</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
 </head>
 <style>
        .navbar-custom {
            background-color: #abc270 !important;
        }
		.footer {
			left: 0;
			bottom: 0;
			width: 100%;
			background-color: #abc270;
			color: white;
			text-align: center;
			margin-top: -40px;
			padding: 10px
		}
    </style>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
			<div class="navbar navbar-fixed-top navbar-custom">
			<a href="?home" class="navbar-brand" style="
    					display: flex; 
    					align-items: center;
   						text-decoration: none;">
    					<img src="../images/lg2.png" alt="logo" style="
        					width: 80px;
        					height: auto;">
					</a>
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="kelola">
								<div class="glyphicon glyphicon-edit" style="color: black"></div>&nbsp;
								<strong style="color: #210440;">DATA DASAR</strong>&nbsp;
								<span class="caret" style="color: black"></span>
							</a>
							<ul class="dropdown-menu" aria-labelledby="kelola">
								<li>
									<a href="?menu=tarif"><strong>KELOLA TARIF</strong></a>
								</li>
								<li>
									<a href="?menu=pelanggan"><strong>KELOLA PELANGGAN</strong></a>
								</li>
								<li>
									<a href="?menu=agen"><strong>KELOLA AGEN</strong></a>
								</li>
								<li>
									<a href="?menu=petugas"><strong>KELOLA PETUGAS</strong></a>
								</li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="transaksi">
								<div class="glyphicon glyphicon-refresh" style="color: black"></div>&nbsp;
								<strong style="color: #210440;">TRANSAKSI</strong>&nbsp;
								<span class="caret" style="color: black"></span>
							</a>
							<ul class="dropdown-menu" aria-labelledby="transaksi">
								<li>
									<a href="?menu=tagihan"><strong>DAFTAR TAGIHAN</strong></a>
								</li>
								<li>
									<a href="?menu=penggunaan"><strong>KELOLA PENGGUNAAN</strong></a>
								</li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="laporan">
								<div class="glyphicon glyphicon-duplicate" style="color: black"></div>&nbsp;
								<strong style="color: black">LAPORAN</strong>&nbsp;
								<span class="caret" style="color: black"></span>
							</a>
							<ul class="dropdown-menu" aria-labelledby="laporan">
								<li>
									<a href="?menu=laporan&tarif"><strong>LAPORAN DATA TARIF</strong></a>
								</li>
								<li>
									<a href="?menu=laporan&pelanggan"><strong>LAPORAN DATA PELANGGAN</strong></a>
								</li>
								<li>
									<a href="?menu=laporan&agen"><strong>LAPORAN DATA AGEN</strong></a>
								</li>
								<li><div class="divider"></div></li>
								<li>
									<a href="?menu=laporan&tagihan_bulan"><strong>LAPORAN TAGIHAN(PERBULAN)</strong></a>
								</li>
								<li>
									<a href="?menu=laporan&tunggakan"><strong>LAPORAN TUNGGAKAN</strong></a>
								</li>
								/
							</ul>
						</li>
					</ul>

					<ul class="nav navbar-nav navbar-right" style="margin-right: 50px;">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="akun">
								<div class="glyphicon glyphicon-user" style="color: black"></div>&nbsp;
								<strong style="color: black"><?php echo $_SESSION['nama_petugas']; ?></strong>&nbsp;
								<span class="caret" style="color: black"></span>
							</a>
							<ul class="dropdown-menu" aria-labelledby="akun">
								<li>
									<a href="?menu=profil">
										<div class="glyphicon glyphicon-cog"style="color: black"></div>&nbsp;
										<strong style="color: black">PROFIL</strong>
									</a>
								</li>
								<li>
									<a href="?logout" onclick="return confirm('Yakin akan keluar dari aplikasi ini ?')">
										<div class="glyphicon glyphicon-log-out" style="color: black"></div>&nbsp;
										<strong style="color: black">KELUAR</strong>
									</a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<?php  
		switch (@$_GET['menu']) {
			case 'home':include'home.php'; break;
			case 'tarif':include'tarif.php'; break;
			case 'pelanggan':include'pelanggan.php'; break;
			case 'petugas':include'petugas.php'; break;
			case 'agen':include'agen.php'; break;
			case 'penggunaan':include'penggunaan.php'; break;
			case 'tagihan':include'tagihan.php'; break;
			case 'laporan':include'laporan.php'; break;
			case 'profil':include'profil.php'; break;
			default:$aksi->redirect("?menu=home");break;
		}
	?>

	<br><br>
	<div class="footer">
		<p>
		  	<strong style="color: #210440;font-family: Myriad Pro Light">Copyright&nbsp;&copy;&nbsp;2024 | ZiyadRifqi Permana</a>
			  
		</p>
	</div>
	
	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript" src="../js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../js/jquery-ui.min.js"></script>
</body>
</html>