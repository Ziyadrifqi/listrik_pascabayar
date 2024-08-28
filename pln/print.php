<?php  
include '../config/koneksi.php';
include '../library/fungsi.php';
date_default_timezone_set("Asia/Jakarta");
session_start();

$aksi = new oop($conn);

if (isset($_GET['tarif'])) {
    $table = "tarif";
    $cari = "";
    $judul = "LAPORAN DAFTAR TARIF";
    $filename = $judul;

    if (isset($_GET['excel'])) {
        header("Content-type: application/vnd-ms-excel");
        header("Content-disposition: attachment; filename=".$filename.".xls");
    }

} elseif (isset($_GET['pelanggan'])) {
    $table = "pelanggan";
    $cari = "";
    $judul = "LAPORAN DAFTAR PELANGGAN";
    $filename = $judul;

    if (isset($_GET['excel'])) {
        header("Content-type: application/vnd-ms-excel");
        header("Content-disposition: attachment; filename=".$filename.".xls");
    }

} elseif (isset($_GET['agen'])) {
    $table = "agen";
    $cari = "";
    $judul = "LAPORAN DAFTAR AGEN";
    $filename = $judul;

    if (isset($_GET['excel'])) {
        header("Content-type: application/vnd-ms-excel");
        header("Content-disposition: attachment; filename=".$filename.".xls");
    }

} elseif (isset($_GET['tagihan_bulan'])) {
    $status = $_GET['status'];
    $bulan = $_GET['bulan'];
    $tahun = $_GET['tahun'];
    $table = "qw_tagihan";
    $cari = "WHERE status = '$status' AND bulan = '$bulan' AND tahun ='$tahun'";
    $judul = "LAPORAN TAGIHAN ".strtoupper($status)." BULAN $bulan TAHUN $tahun";
    $filename = $judul;

    if (isset($_GET['excel'])) {
        header("Content-type: application/vnd-ms-excel");
        header("Content-disposition: attachment; filename=".$filename.".xls");
    }

} elseif (isset($_GET['tunggakan'])) {
    $table = "pelanggan";
    $cari = "";
    $judul = "LAPORAN PELANGGAN YANG MEMILIKI TUNGGAKAN LEBIH DARI 3 BULAN";
    $filename = $judul;

    if (isset($_GET['excel'])) {
        header("Content-type: application/vnd-ms-excel");
        header("Content-disposition: attachment; filename=".$filename.".xls");
    }

} elseif (isset($_GET['riwayat_penggunaan'])) {
    $table = "qw_tagihan";
    $id_pelanggan = $_GET['id_pelanggan'];
    $tahun = $_GET['tahun'];
    $pelanggan = $aksi->caridata("pelanggan WHERE id_pelanggan = '$id_pelanggan'");
    $cari = "WHERE id_pelanggan = '$id_pelanggan' AND tahun = '$tahun'";
    $judul = "LAPORAN RIWAYAT PENGGUNAAN ".strtoupper($pelanggan['nama'])." ($id_pelanggan) PADA TAHUN $tahun";
    $filename = $judul;

    if (isset($_GET['excel'])) {
        header("Content-type: application/vnd-ms-excel");
        header("Content-disposition: attachment; filename=".$filename.".xls");
    }
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
<!-- INI BAGIAN HEADER LAPORAN -->
    <table width="100%" border="0" cellspacing="0">
        <tr>
            <?php if (!isset($_GET['excel'])) { ?>
                <td style="margin-top: -20px;" width="15%" valign="top">
                    <img src="../images/lg.png" width="90px" height="90px">
                </td>
            <?php } ?>
            <td>
            <h4 style="margin-top: 10px;margin-left: -10px;">Pembayaran PascaBayar Listrik</h4>
				<h1 style="margin-top: -20px;margin-left: -10px;" >BRIGHT POWER</h1>
				<h5 style="margin-top: -20px;margin-left: -10px;">Jl. Haji Dimun, Cilodong, Depok, Jawa Barat</h5>
            </td>
        </tr>
        <tr><td colspan="3"><hr style="border: 2px solid black;"></td></tr>
        <tr><td colspan="3"><center><strong><h3><?php echo @$judul; ?></h3></strong></center></td></tr>
    </table>
<!-- INI END BAGIAN HEADER LAPORAN -->

<!-- INI ISI LAPORAN -->
    <?php if (isset($_GET['tarif'])) { ?>
        <table width="100%" border="1" cellspacing="0" cellpadding="3">
            <thead>
                <tr>
                    <th><center>No.</center></th>
                    <th><center>Kode Tarif</center></th>
                    <th><center>Golongan</center></th>
                    <th><center>Daya</center></th>
                    <th><center>Tarif/KWh</center></th>
                </tr>
            </thead>
            <tbody>
                <?php  
                    $no = 0;
                    $data = $aksi->tampil($table, $cari, "ORDER BY golongan ASC");
                    if ($data == "") {
                        $aksi->no_record(5);
                    } else {
                        foreach ($data as $r) {
                            $no++; ?>
                            <tr>
                                <td align="center"><?php echo $no; ?>.</td>
                                <td align="center"><?php echo $r['kode_tarif']; ?></td>
                                <td align="center"><?php echo $r['golongan']; ?></td>
                                <td align="center"><?php echo $r['daya']; ?></td>
                                <td align="right"><?php $aksi->rupiah($r['tarif_perkwh']); ?></td>
                            </tr>
                <?php } } ?>
            </tbody>
        </table>

    <?php } elseif (isset($_GET['pelanggan'])) { ?>
        <table width="100%" border="1" cellspacing="0" cellpadding="3">
            <thead>
                <tr>
                    <th><center>No.</center></th>
                    <th><center>ID Pelanggan</center></th>
                    <th><center>No.Meter</center></th>
                    <th><center>Nama</center></th>
                    <th><center>Alamat</center></th>
                    <th><center>Tenggang</center></th>
                    <th><center>Kode Tarif</center></th>
                </tr>
            </thead>
            <tbody>
                <?php  
                    $no = 0;
                    $data = $aksi->tampil($table, $cari, "ORDER BY id_pelanggan");
                    if ($data == "") {
                        $aksi->no_record(7);
                    } else {
                        foreach ($data as $r) {
                            $a = $aksi->caridata("tarif WHERE id_tarif = '$r[id_tarif]'");
                            $no++; ?>
                            <tr>
                                <td align="center"><?php echo $no; ?>.</td>
                                <td align="center"><?php echo $r['id_pelanggan']; ?></td>
                                <td align="center"><?php echo $r['no_meter']; ?></td>
                                <td><?php echo $r['nama']; ?></td>
                                <td><?php echo $r['alamat']; ?></td>
                                <td align="center"><?php echo $r['tenggang']; ?></td>
                                <td align="center"><?php echo $a['kode_tarif']; ?></td>
                            </tr>
                <?php } } ?>
            </tbody>
        </table>

    <?php } elseif (isset($_GET['agen'])) { ?>
        <table width="100%" border="1" cellspacing="0" cellpadding="3">
            <thead>
                <tr>
                    <th width="5%"><center>No.</center></th>
                    <th width="13%"><center>ID Agen</center></th>
                    <th width="20%"><center>Nama</center></th>
                    <th width="12%"><center>No.Telepon</center></th>
                    <th><center>Alamat</center></th>
                    <th width="12%"><center>Biaya Admin</center></th>
                </tr>
            </thead>
            <tbody>
                <?php  
                    $no = 0;
                    $data = $aksi->tampil($table, $cari, "ORDER BY id_agen");
                    if ($data == "") {
                        $aksi->no_record(6);
                    } else {
                        foreach ($data as $r) {
                            $no++; ?>
                            <tr>
                                <td align="center"><?php echo $no; ?>.</td>
                                <td align="center"><?php echo $r['id_agen']; ?></td>
                                <td><?php echo $r['nama']; ?></td>
                                <td align="center"><?php echo $r['no_telepon']; ?></td>
                                <td><?php echo $r['alamat']; ?></td>
                                <td align="right"><?php $aksi->rupiah($r['biaya_admin']); ?></td>
                            </tr>
                <?php } } ?>
            </tbody>
        </table>

    <?php } elseif (isset($_GET['tagihan_bulan'])) { ?>
        <table width="100%" border="1" cellspacing="0" cellpadding="3">
            <thead>
                <tr>
                    <th width="5%"><center>No.</center></th>
                    <th width="15%"><center>ID Pelanggan</center></th>
                    <th width="20%"><center>Nama</center></th>
                    <th width="15%"><center>Bulan</center></th>
                    <th width="10%"><center>Tahun</center></th>
                    <th width="15%"><center>Status</center></th>
                </tr>
            </thead>
            <tbody>
                <?php  
                    $no = 0;
                    $data = $aksi->tampil($table, $cari, "ORDER BY id_tagihan");
                    if ($data == "") {
                        $aksi->no_record(7);
                    } else {
                        foreach ($data as $r) {
                            $no++; ?>
                            <tr>
                                <td align="center"><?php echo $no; ?>.</td>
                                <td align="center"><?php echo $r['id_pelanggan']; ?></td>
                                <td align="center"><?php echo $r['nama_pelanggan']; ?></td>
                                <td align="center"><?php echo $r['bulan']; ?></td>
                                <td align="center"><?php echo $r['tahun']; ?></td>
                                <td align="center"><?php echo strtoupper($r['status']); ?></td>
                            </tr>
                <?php } } ?>
            </tbody>
        </table>

    <?php } elseif (isset($_GET['tunggakan'])) { ?>
        <table width="100%" border="1" cellspacing="0" cellpadding="3">
            <thead>
                <tr>
                    <th width="5%"><center>No.</center></th>
                    <th width="15%"><center>ID Pelanggan</center></th>
                    <th width="20%"><center>Nama</center></th>
                    <th width="25%"><center>Alamat</center></th>
                    <th width="35%"><center>Banyak Tunggakan</center></th>
                    <th width="35%"><center>Bulan</center></th>
                    <th width="35%"><center>Total Meter</center></th>
                    <th width="35%"><center>Tarif/Kwh</center></th>
                    <th width="35%"><center>Total Tunggakan</center></th>
                </tr>
            </thead>
            <tbody>
            <?php
$no = 0;
$data = $aksi->tampil("pelanggan", "", "ORDER BY nama ASC");
if (empty($data)) {
    $aksi->no_record(8);
} else {
    foreach ($data as $r) {
        $cek = $aksi->cekdata("tagihan WHERE id_pelanggan = '{$r['id_pelanggan']}' AND status = 'Belum Bayar'");
        if ($cek >= 3) {
            $no++;
            $sum = $conn->query("SELECT id_pelanggan, COUNT(bulan) as bln_tunggak, SUM(jumlah_bayar) as jml_bayar, SUM(jumlah_meter) as jml_meter, tarif_perkwh FROM tagihan WHERE id_pelanggan = '{$r['id_pelanggan']}' AND status = 'Belum Bayar'")->fetch_assoc();
            $bulan = $conn->query("SELECT * FROM tagihan WHERE id_pelanggan = '{$r['id_pelanggan']}' AND status = 'Belum Bayar'");
            ?>
            <tr>
                <td align="center"><?php echo $no; ?>.</td>
                <td align="center"><?php echo $r['id_pelanggan']; ?></td>
                <td><?php echo $r['nama']; ?></td>
                <td align="left"><?php echo $r['alamat']; ?></td>
                <td align="center"><?php echo $sum['bln_tunggak']; ?>&nbsp;Bulan</td>
                <td align="center">
                    <?php
                    while ($bln = $bulan->fetch_assoc()) {
                        $aksi->bulan_substr($bln['bulan']);
                        echo substr($bln['tahun'], 2, 2) . ",";
                    }
                    ?>
                </td>
                <td align="center"><?php echo $sum['jml_meter']; ?></td>
                <td align="right"><?php $aksi->rupiah($sum['tarif_perkwh']); ?></td>
                <td align="right"><?php $aksi->rupiah($sum['jml_bayar']); ?></td>
            </tr>
            <?php } } } ?>
            </tbody>
        </table>

    <?php } elseif (isset($_GET['riwayat_penggunaan'])) { ?>
        <table width="100%" border="1" cellspacing="0" cellpadding="3">
            <thead>
                <tr>
                    <th><center>No.</center></th>
                    <th><center>ID Tagihan</center></th>
                    <th><center>Bulan</center></th>
                    <th><center>Tahun</center></th>
                    <th><center>Meter Awal</center></th>
                    <th><center>Meter Akhir</center></th>
                    <th><center>Pemakaian</center></th>
                    <th><center>Tarif/KWh</center></th>
                    <th><center>Tagihan</center></th>
                    <th><center>Status</center></th>
                </tr>
            </thead>
            <tbody>
                <?php  
                    $no = 0;
                    $data = $aksi->tampil($table, $cari, "ORDER BY bulan ASC");
                    if ($data == "") {
                        $aksi->no_record(10);
                    } else {
                        foreach ($data as $r) {
                            $tarif = $aksi->caridata("tarif WHERE id_tarif = '$r[id_tarif]'");
                            $tagihan = $r['pemakaian'] * $tarif['tarif_perkwh'];
                            $no++; ?>
                            <tr>
                                <td align="center"><?php echo $no; ?>.</td>
                                <td align="center"><?php echo $r['id_tagihan']; ?></td>
                                <td align="center"><?php echo $r['bulan']; ?></td>
                                <td align="center"><?php echo $r['tahun']; ?></td>
                                <td align="center"><?php echo $r['meter_awal']; ?></td>
                                <td align="center"><?php echo $r['meter_akhir']; ?></td>
                                <td align="center"><?php echo $r['pemakaian']; ?></td>
                                <td align="right"><?php $aksi->rupiah($tarif['tarif_perkwh']); ?></td>
                                <td align="right"><?php $aksi->rupiah($tagihan); ?></td>
                                <td align="center"><?php echo strtoupper($r['status']); ?></td>
                            </tr>
                <?php } } ?>
            </tbody>
        </table>
    <?php } ?>

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
