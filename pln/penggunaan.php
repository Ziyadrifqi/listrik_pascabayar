<?php
// Redirect to 'hal_utama.php?menu=penggunaan' if 'menu' parameter is not set
if (!isset($_GET['menu'])) {
    header('Location: hal_utama.php?menu=penggunaan');
    exit();
}

// Initialize variables
$table = "penggunaan";
$id = $_GET['id'] ?? '';
$where = "id_penggunaan = '$id'";
$redirect = "?menu=penggunaan";

// Initialize POST and GET variables
$id_pel = $_POST['id_pelanggan'] ?? $_GET['id_pelanggan'] ?? '';
$penggunaan = [];

// Fetch data based on GET and POST parameters
if (isset($_POST['id_pelanggan'])) {
    $id_pel = $_POST['id_pelanggan'];
    $penggunaan = $aksi->caridata("penggunaan WHERE id_pelanggan = '$id_pel' AND meter_akhir = '0'");
    if (empty($penggunaan)) {
        $aksi->pesan('Data Bulan ini sudah diinput');
    }
} elseif (isset($_GET['hapus']) || isset($_GET['edit'])) {
    $penggunaan = $aksi->caridata("penggunaan WHERE id_penggunaan = '$id'");
    $id_pel = $penggunaan['id_pelanggan'] ?? '';
}

$pelanggan = $aksi->caridata("pelanggan WHERE id_pelanggan = '$id_pel'");
if ($pelanggan) {
    $tarif = $aksi->caridata("tarif WHERE id_tarif = '{$pelanggan['id_tarif']}'");
    $tarif_perkwh = $tarif['tarif_perkwh'] ?? 0;
} else {
    $tarif_perkwh = 0; // Default value or handle error
}
$id_guna = $penggunaan['id_penggunaan'] ?? '';
$mawal = $penggunaan['meter_awal'] ?? 0;
$bulan = $penggunaan['bulan'] ?? '';
$tahun = $penggunaan['tahun'] ?? '';

// Ensure $bulan is an integer
$bulan = (int) $bulan;
$next_bulan = ($bulan == 12) ? '01' : str_pad($bulan + 1, 2, '0', STR_PAD_LEFT);
$next_tahun = ($bulan == 12) ? $tahun + 1 : $tahun;

// Initialize form variables
$id_pelanggan = $_POST['id_pelanggan'] ?? '';
$meter_akhir = $_POST['meter_akhir'] ?? 0;
$meter_awal = $_POST['meter_awal'] ?? 0;
$tgl_cek = $_POST['tgl_cek'] ?? '';
$jumlah_meter = $meter_akhir - $mawal;
$id_penggunaan_next = $id_pelanggan . $next_bulan . $next_tahun;
//hitung jumlah bayar 
$jumlah_bayar = $jumlah_meter * $tarif_perkwh;


// Prepare data for saving and updating
$field_next = [
    'id_penggunaan' => $id_penggunaan_next,
    'id_pelanggan' => $id_pelanggan,
    'bulan' => $next_bulan,
    'tahun' => $next_tahun,
    'meter_awal' => $meter_akhir,
];

$field = [
    'meter_akhir' => $meter_akhir,
    'tgl_cek' => $tgl_cek,
    'id_petugas' => $_SESSION['id_petugas'] ?? '',
];

$field_update = [
    'meter_awal' => $meter_akhir,
];

$field_tagihan = [
    'id_pelanggan' => $id_pelanggan,
    'bulan' => $bulan,
    'tahun' => $tahun,
    'jumlah_meter' => $jumlah_meter,
    'tarif_perkwh' => $tarif_perkwh,
    'jumlah_bayar' => $jumlah_bayar,
    'status' => "Belum Bayar",
    'id_petugas' => $_SESSION['id_petugas'] ?? '',
];

$field_tagihan_update = [
    'jumlah_meter' => $jumlah_meter,
    'tarif_perkwh' => $tarif_perkwh,
    'jumlah_bayar' => $jumlah_bayar,
    'status' => "Belum Bayar",
    'id_petugas' => $_SESSION['id_petugas'] ?? '',
];

// Handle form submissions
if (isset($_POST['bsimpan'])) {
    // Debug: Display the posted data
    var_dump($_POST);
    
    if ($meter_akhir <= $meter_awal) {
        $aksi->pesan("Meter Akhir Tidak Mungkin Kurang dari Meter Awal");
    } else {
        // Use try-catch for error handling
        try {
            // Debug: Menampilkan field_tagihan dan bidang lainnya
            var_dump($field_tagihan);
            var_dump($field);
            var_dump($field_next);
            
            // Insert into tagihan table
            $aksi->simpan("tagihan", $field_tagihan);

            // Update penggunaan table
            $aksi->update($table, $field, "id_penggunaan = '$id_guna'");

            // Insert next penggunaan record
            $aksi->simpan($table, $field_next);

            // Confirm success
            $aksi->alert("Data Berhasil Disimpan", $redirect);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

if (isset($_POST['bubah'])) {
    try {
        $aksi->update($table, $field_update, "id_penggunaan = '$id_penggunaan_next'");
        $aksi->update("tagihan", $field_tagihan_update, "id_pelanggan = '$id_pelanggan' AND bulan = '$bulan' AND tahun = '$tahun'");
        $aksi->update($table, $field, $where);
        $aksi->alert("Data Berhasil Diubah", $redirect);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

if (isset($_GET['edit'])) {
    $edit = $aksi->edit($table, $where);
}

if (isset($_GET['hapus'])) {
    try {
        $aksi->update($table, [
            'meter_akhir' => 0,
            'tgl_cek' => "",
            'id_petugas' => "",
        ], $where);
        $aksi->hapus($table, "id_penggunaan = '$id_penggunaan_next'");
        $aksi->hapus("tagihan", "id_pelanggan = '$id_pelanggan' AND bulan = '$bulan' AND tahun = '$tahun'");
        $aksi->alert("Data Berhasil Dihapus", $redirect);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Handle search functionality
$cari = "";
if (isset($_POST['bcari'])) {
    $text = $_POST['tcari'];
    $cari = "WHERE id_pelanggan LIKE '%$text%' OR id_penggunaan LIKE '%$text%' OR meter_awal LIKE '%$text%' OR meter_akhir LIKE '%$text%' OR tahun LIKE '%$text%' OR nama_pelanggan LIKE '%$text%' OR nama_petugas LIKE '%$text%'";
} else {
    $cari = "WHERE meter_akhir != 0";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>PELANGGAN</title>
    <!-- Include Bootstrap CSS if needed -->
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo !isset($_GET['id']) ? 'INPUT PENGGUNAAN' : 'UBAH PENGGUNAAN - ' . htmlspecialchars($id); ?>
                        </div>
                        <div class="panel-body">
                            <form method="post">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>ID PELANGGAN</label>&nbsp;&nbsp;<span style="color:blue;font-size: 10px;">[TEKAN TAB]</span>
                                        <input type="text" name="id_pelanggan" class="form-control" placeholder="Masukan ID Pelanggan" onchange="submit()" required value="<?php echo htmlspecialchars($id_pelanggan, ENT_QUOTES); ?>" list="id_pel" onkeypress='return event.charCode >=48 && event.charCode <=57' <?php echo isset($_GET['id']) ? 'readonly' : ''; ?>>
                                        <datalist id="id_pel">
                                            <?php  
                                            $result = $conn->query("SELECT * FROM pelanggan");
                                            while ($b = $result->fetch_assoc()) { ?>
                                                <option value="<?php echo htmlspecialchars($b['id_pelanggan']); ?>">
                                                    <?php echo htmlspecialchars($b['nama']); ?></option>
                                            <?php } ?>
                                        </datalist>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Petugas</label>
                                        <input type="text" class="form-control" placeholder="Nama Petugas" required readonly value="<?php echo htmlspecialchars($_SESSION['nama_petugas'] ?? '', ENT_QUOTES); ?>">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Bulan</label>
                                        <input type="text" name="bulan" class="form-control" placeholder="Bulan" required readonly value="<?php echo $aksi->bulan($bulan); echo " " . htmlspecialchars($tahun); ?>">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Meter Awal</label>
                                        <input type="text" name="meter_awal" class="form-control" placeholder="Meter Awal" required readonly value="<?php echo htmlspecialchars($mawal, ENT_QUOTES); ?>">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Meter Akhir</label>
                                        <input type="text" name="meter_akhir" class="form-control" placeholder="Meter Akhir" required value="<?php echo htmlspecialchars($meter_akhir ?? '', ENT_QUOTES); ?>">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Tanggal Cek</label>
                                        <input type="date" name="tgl_cek" class="form-control" placeholder="Tanggal Cek" required value="<?php echo htmlspecialchars($tgl_cek ?? '', ENT_QUOTES); ?>">
                                    </div>
                                    
                                    <div class="form-group">
                                        <?php if (!isset($_GET['id'])) { ?>
                                            <input type="submit" name="bsimpan" class="btn btn-primary btn-lg btn-block" value="SIMPAN">
                                        <?php } else { ?>
                                            <input type="submit" name="bubah" class="btn btn-success btn-lg btn-block" value="UBAH">
                                        <?php } ?>
                                        <a href="?menu=penggunaan" class="btn btn-danger btn-lg btn-block">RESET</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="panel-footer">&nbsp;</div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">DAFTAR PENGGUNAAN</div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <form method="post">
                                <div class="input-group">
                                    <input type="text" name="tcari" class="form-control" value="<?php echo htmlspecialchars($text ?? ''); ?>" placeholder="Masukan Keyword Pencarian (Kode Penggunaan, ID Pelanggan, Bulan[contoh : 01,09,12], Tahun, Nama Pelanggan, Nama Petugas) ......">
                                    <div class="input-group-btn">
                                        <button type="submit" name="bcari" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span>&nbsp;CARI</button>
                                        <button type="submit" name="brefresh" class="btn btn-success"><span class="glyphicon glyphicon-refresh"></span>&nbsp;REFRESH</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th><center>No.</center></th>
                                            <th>Kode Penggunaan</th>
                                            <th>ID Pelanggan</th>
                                            <th>Nama</th>
                                            <th>Bulan</th>
                                            <th>Meter Awal</th>
                                            <th>Meter Akhir</th>
                                            <th>Tanggal Cek</th>
                                            <th>Petugas</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php  
                                            $no=0;
                                            $data = $aksi->tampil("qw_penggunaan",$cari,"ORDER BY tgl_cek DESC");
                                            if ($data=="") {
                                                $aksi->no_record(8);
                                            } else {
                                                foreach ($data as $r) {
                                                    $cek = $aksi->cekdata("tagihan WHERE id_pelanggan = '$r[id_pelanggan]' AND bulan = '$r[bulan]' AND tahun = '$r[tahun]' AND status = 'Belum Bayar'");
                                                $no++; ?>

                                                    <tr>
                                                        <td align="center"><?php echo $no; ?>.</td>
                                                        <td><?php echo htmlspecialchars($r['id_penggunaan']); ?></td>
                                                        <td><?php echo htmlspecialchars($r['id_pelanggan']); ?></td>
                                                        <td><?php echo htmlspecialchars($r['nama_pelanggan']); ?></td>
                                                        <td><?php $aksi->bulan($r['bulan']); echo " " . htmlspecialchars($r['tahun']); ?></td>
                                                        <td><?php echo htmlspecialchars($r['meter_awal']); ?></td>
                                                        <td><?php echo htmlspecialchars($r['meter_akhir']); ?></td>
                                                        <td><?php $aksi->format_tanggal($r['tgl_cek']); ?></td>
                                                        <td><?php echo htmlspecialchars($r['nama_petugas']); ?></td>
                                                        
                                                    </tr>
                                                <?php } 
                                            } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <div class="panel-footer">&nbsp;</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
