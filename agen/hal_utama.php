<?php  
    require_once '../config/koneksi.php';
    require_once '../library/fungsi.php';

    session_start();
    date_default_timezone_set("Asia/Jakarta");

    $aksi = new oop($conn);
    if (empty($_SESSION['username_agen'])) {
        $aksi->alert("Harap Login Dulu !!!","index.php");
    }

    if (isset($_GET['logout'])) {
        session_unset();
        session_destroy();
        $aksi->alert("Logout Berhasil !!!","index.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>BRIGHT POWER - User</title>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
    <style type="text/css">
        .navbar-collapse {
            background-color: #eeeeee;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="navbar navbar-fixed-top navbar-custom">
                    <div class="navbar-header">
                        <a href="?menu=home" class="navbar-brand" style="
    					display: flex; 
    					align-items: center;
   						text-decoration: none;">
                            <img alt="Brand" src="../images/lg2.png" style="
        					width: 80px;
        					height: auto;">
                        </a>
                    </div>
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="transaksi">
                                    <div class="glyphicon glyphicon-shopping-cart"></div>&nbsp;
                                    <strong style="font-family: Monaco, monospace; font-size: 15px">TRANSAKSI</strong>&nbsp;
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="transaksi">
                                    <li><a href="?menu=riwayat" style="font-family: Monaco, monospace; font-size: 15px"><strong>RIWAYAT PEMBAYARAN</strong></a></li>
                                    <li><a href="?menu=pembayaran" style="font-family: Monaco, monospace; font-size: 15px"><strong>KELOLA PEMBAYARAN</strong></a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="laporan">
                                    <div class="glyphicon glyphicon-duplicate"></div>&nbsp;
                                    <strong style="font-family: Monaco, monospace; font-size: 15px">LAPORAN</strong>&nbsp;
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="laporan">
                                    <li><a href="?menu=laporan" style="font-family: Monaco, monospace; font-size: 15px"><strong>RIWAYAT PEMBAYARAN</strong></a></li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right" style="margin-right: 50px;">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="akun">
                                    <div class="glyphicon glyphicon-user"></div>&nbsp;
                                    <strong style="font-family: Monaco, monospace; font-size: 15px"><?php echo htmlspecialchars($_SESSION['nama_agen']); ?></strong>&nbsp;
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="akun">
                                    <li><a href="?menu=profil" style="font-family: Monaco, monospace; font-size: 15px"><div class="glyphicon glyphicon-cog" ></div>&nbsp;<strong style="font-family: Monaco, monospace; font-size: 15px">PROFIL</strong></a></li>
                                    <li><a href="?logout" style="font-family: Monaco, monospace; font-size: 15px"onclick="return confirm('Apakah Anda yakin ingin keluar?')"><div class="glyphicon glyphicon-log-out"></div>&nbsp;&nbsp;<strong style="font-family: Monaco, monospace; font-size: 15px">KELUAR</strong></a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php  
        $menu = $_GET['menu'] ?? 'home';
        switch ($menu) {
            case 'home': include 'home.php'; break;
            case 'riwayat': echo "<br> <br>"; include 'riwayat.php'; break;
            case 'pembayaran': echo "<br> <br>"; include 'pembayaran.php'; break;
            case 'laporan': echo "<br> <br>"; include 'laporan.php'; break;
            case 'profil': echo "<br> <br>"; include 'profil.php'; break;
            default: $aksi->redirect("?menu=home"); break;
        }
    ?>
    <br><br>
    <footer class="container-fluid bg-4 text-center">
        <p>
            <strong>Copyright&nbsp;&copy;&nbsp;2024 | ZiyadRifqi Permana</a>
        </p>
    </footer>
    <script type="text/javascript" src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $("#tbayar").keyup(function(){
            var totalakhir = parseInt($("#ttotalakhir").val());
            var bayar = parseInt($("#tbayar").val());
            var kembalian = bayar > totalakhir ? bayar - totalakhir : '';
            $("#tkembalian").val(kembalian);
        });
    </script>
</body>
</html>
