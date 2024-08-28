<?php
// Pastikan koneksi database sudah terhubung
include('../config/koneksi.php');

if (isset($_POST['btnBayar'])) {
    // Ambil data dari form
    $id_pembayaran = $_POST['id_pembayaran'];
    $id_tagihan = $_POST['id_tagihan'];
    $biaya_admin = floatval($_POST['biaya_admin']);
    $total_bayar = floatval($_POST['total_bayar']);
    $tgl_bayar = $_POST['tgl_bayar'];
    $bulan_bayar = $_POST['bulan_bayar'];

    // Hitung kembali
    $bayar = isset($_POST['bayar']) ? floatval($_POST['bayar']) : 0;
    $kembali = $bayar - $total_bayar;

    // Periksa apakah bayar mencukupi
    if ($bayar < $total_bayar) {
        echo "<script>alert('Maaf Uang Tidak Mencukupi'); window.location.href='hal_utama.php?menu=pembayaran';</script>";
    } else {
        // Update status tagihan
        $updateQuery = "UPDATE tagihan SET status = 'Terbayar' WHERE id_tagihan = ? AND status = 'Belum Bayar'";
        $stmtUpdate = $conn->prepare($updateQuery);
        $stmtUpdate->bind_param('s', $id_tagihan);
        $stmtUpdate->execute();
        $stmtUpdate->close();

        // Simpan data pembayaran
        $insertQuery = "INSERT INTO pembayaran (id_pembayaran, id_tagihan, bayar, kembali, biaya_admin, total_bayar, tgl_bayar, bulan_bayar) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtInsert = $conn->prepare($insertQuery);
        $stmtInsert->bind_param('ssddssss', $id_pembayaran, $id_tagihan, $bayar, $kembali, $biaya_admin, $total_bayar, $tgl_bayar, $bulan_bayar);
        $stmtInsert->execute();
        $stmtInsert->close();

        echo "<script>alert('Data Berhasil Disimpan'); window.location.href='struk.php?id_pembayaran=" . urlencode($id_pembayaran) . "&id_tagihan=" . urlencode($id_tagihan) . "';</script>";
    }
}
?>
