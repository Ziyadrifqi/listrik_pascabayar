<?php  
include '../config/koneksi.php';
include '../library/fungsi.php';
date_default_timezone_set("Asia/Jakarta");
session_start();

// Make sure to pass the $conn object when creating the oop instance
$aksi = new oop($conn);

$table = "qw_pembayaran";
$bulanini = $_GET['bulan'] ?? '';
$tahunini = $_GET['tahun'] ?? '';
$cari = "WHERE MONTH(tgl_bayar) = '$bulanini' AND YEAR(tgl_bayar) ='$tahunini' AND id_agen = '$_SESSION[id_agen]'";
$filename = "Laporan Riwayat Pembayaran Bulan $bulanini TAHUN $tahunini";

// Fetch agen details
$agen = $aksi->caridata("agen WHERE id_agen = '$_SESSION[id_agen]'");

// Handle Excel export
if (isset($_GET['excel'])) {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename.xls\"");
    exit(); // Exit to prevent any further output
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>PRINT LAPORAN</title>
    <style type="text/css">
        #footer {
            position: absolute;
            bottom: 1px;
            padding-right: 100px;
            padding-left: 20px;
            width: 100%;
            font-weight: bold;
            color: black;
            font: 13px Arial;
        }
    </style>
</head>
<body onload="window.print()" style="font-family: 'Arial', 'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', Tahoma, sans-serif; padding: 10px;">
<!-- HEADER LAPORAN -->
    <table width="100%" border="0" cellspacing="0">
        <tr>
            <?php if (isset($_GET['excel'])) { ?>
                <td>&nbsp;</td>
            <?php } else { ?>
                <td style="margin-top: -20px;" width="15%" valign="top">
                    <img src="../images/lg.png" width="90px" height="90px">
                </td>
            <?php } ?>
            <td colspan="10" align="left">
            <h4 style="margin-top: 10px;margin-left: -10px;">Pembayaran PascaBayar Listrik</h4>
				<h1 style="margin-top: -20px;margin-left: -10px;" >BRIGHT POWER</h1>
				<h5 style="margin-top: -20px;margin-left: -10px;">Jl. Haji Dimun, Cilodong, Depok, Jawa Barat</h5>
            </td>
        </tr>
        <tr><td colspan="10"><hr style="border: 2px solid black;"></td></tr>
        <tr>
            <td colspan="10">
                <center>
                    <strong>
                        <h3>
                            <?php echo "LAPORAN RIWAYAT PEMBAYARAN BULAN "; $aksi->bulan($bulanini); echo " TAHUN $tahunini"; ?>
                        </h3>
                    </strong>
                </center>
            </td>
        </tr>
    </table>
<!-- END HEADER LAPORAN -->

<!-- ISI LAPORAN -->
    <table width="100%" border="1" cellspacing="0" cellpadding="3">
        <thead>
            <tr>
                <th>No.</th>
                <th>ID Pelanggan</th>
                <th>Nama Pelanggan</th>
                <th>Waktu</th>
                <th>Bulan Bayar</th>
                <th><center>Jumlah Bayar</center></th>
                <th><center>Biaya Admin</center></th>
                <th><center>Total Akhir</center></th>
                <th><center>Bayar</center></th>
                <th><center>Kembali</center></th>
                <th><center>Petugas</center></th>
            </tr>
        </thead>
        <tbody>
            <?php  
                $no = 0;
                $data = $aksi->tampil($table, $cari, "ORDER BY id_pembayaran DESC");
                if (empty($data)) {
                    $aksi->no_record(11);
                } else {
                    foreach ($data as $r) {
                        $no++;
            ?>
                <tr>
                    <td align="center"><?php echo $no; ?>.</td>
                    <td><?php echo htmlspecialchars($r['id_pelanggan']); ?></td>
                    <td><?php echo htmlspecialchars($r['nama_pelanggan']); ?></td>
                    <td><?php echo htmlspecialchars($r['waktu_bayar']); ?></td>
                    <td><?php $aksi->bulan($r['bulan_bayar']); echo " ".$r['tahun_bayar']; ?></td>
                    <td><?php $aksi->rupiah($r['jumlah_bayar']); ?></td>
                    <td><?php $aksi->rupiah($r['biaya_admin']); ?></td>
                    <td><?php $aksi->rupiah($r['total_akhir']); ?></td>
                    <td><?php $aksi->rupiah($r['bayar']); ?></td>
                    <td><?php $aksi->rupiah($r['kembali']); ?></td>
                    <td><?php echo htmlspecialchars($r['nama_agen']); ?></td>
                </tr>
            <?php
                    }
                }
            ?>
        </tbody>
    </table>
<!-- END ISI LAPORAN -->

<!-- FOOTER LAPORAN -->
    <div id="footer">
        <table align="right" style="margin-right: 100px;">
            <tr><td rowspan="10" width="50px"></td><td>&nbsp;</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td align="center"><?php $aksi->hari(date("N")); echo ", "; $aksi->format_tanggal(date("Y-m-d")); ?></td>
            </tr>
            <tr>
                <td align="center">Hormat Saya,</td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td align="center"><?php echo htmlspecialchars($_SESSION['nama_petugas']); ?></td>
            </tr>
            <tr><td>&nbsp;</td></tr>
        </table>
    </div>
<!-- END FOOTER LAPORAN -->
</body>
</html>
