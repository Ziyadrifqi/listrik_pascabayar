<?php  
if (!isset($_GET['menu'])) {
    header("location:hal_utama.php?menu=agen");
    exit;
}

$table = "agen";
$id = isset($_GET['id']) ? $_GET['id'] : null;
$where = $id ? "md5(sha1(id_agen)) = '$id'" : null;
$redirect = "?menu=agen";

// Autocode
$today = date("Ymd");
$agen = $aksi->caridata("agen WHERE id_agen LIKE '%$today%' ORDER BY id_agen DESC");
if (empty($agen)) {
    $id_agen = "A" . $today . "001";
} else {
    $kode = substr($agen['id_agen'], 9, 3) + 1;
    $id_agen = sprintf("A" . $today . '%03s', $kode);
}

// Cek username
$cek_user = isset($_POST['username']) ? $aksi->cekdata("agen WHERE username = '$_POST[username]'") : 0;

$field = array(
    'id_agen' => isset($_POST['id']) ? $_POST['id'] : null,
    'username' => isset($_POST['username']) ? $_POST['username'] : null,
    'password' => isset($_POST['password']) ? $_POST['password'] : null,
    'akses' => 'agen',
    'nama' => isset($_POST['nama']) ? $_POST['nama'] : null,
    'alamat' => isset($_POST['alamat']) ? $_POST['alamat'] : null,
    'no_telepon' => isset($_POST['no']) ? $_POST['no'] : null,
    'biaya_admin' => isset($_POST['admin']) ? $_POST['admin'] : null,
);

$field_ubah = array(
    'username' => isset($_POST['username']) ? $_POST['username'] : null,
    'password' => isset($_POST['password']) ? $_POST['password'] : null,
    'nama' => isset($_POST['nama']) ? $_POST['nama'] : null,
    'alamat' => isset($_POST['alamat']) ? $_POST['alamat'] : null,
    'no_telepon' => isset($_POST['no']) ? $_POST['no'] : null,
    'biaya_admin' => isset($_POST['admin']) ? $_POST['admin'] : null,
);

// CRUD Operations
if (isset($_POST['simpan'])) {
    if ($cek_user > 0) {
        $aksi->pesan("Username sudah ada !!!");
    } else {
        $aksi->simpan($table, $field);
        $aksi->alert("Data berhasil disimpan", $redirect);
    }
}

if (isset($_GET['edit'])) {
    if ($where) {
        $edit = $aksi->edit($table, $where);
    } else {
        $edit = array(); // or handle case where $where is not valid
    }
}

if (isset($_POST['ubah'])) {
	$aksi->update($table, $field_ubah, $where);
	$aksi->alert("Data Berhasil Diubah", $redirect);
	exit();
}

if (isset($_GET['hapus'])) {
    if ($where) {
        $aksi->hapus($table, $where);
        $aksi->alert("Data berhasil dihapus", $redirect);
    } else {
        $aksi->pesan("Data tidak ditemukan!");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>AGEN</title>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php 
                            if (empty($id)) {
                                echo "INPUT AGEN";
                            } else {
                                echo "UBAH AGEN";
                            } 
                        ?>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <form method="post">
                                <div class="form-group">
                                    <label>ID AGEN</label>
                                    <input type="text" name="id" class="form-control" value="<?php echo empty($id) ? $id_agen : $edit['id_agen']; ?>" readonly required>
                                </div>
                                <div class="form-group">
                                    <label>USERNAME</label>
                                    <input type="text" name="username" class="form-control" value="<?php echo isset($edit['username']) ? $edit['username'] : ''; ?>" required placeholder="Masukan username Agen" maxlength="30"> 
                                </div>
                                <div class="form-group">
                                    <label>PASSWORD</label>
                                    <input type="password" name="password" class="form-control" value="<?php echo isset($edit['password']) ? $edit['password'] : ''; ?>" required placeholder="Masukan password Agen" maxlength="30"> 
                                </div>
                                <div class="form-group">
                                    <label>BIAYA ADMIN</label>
                                    <input type="text" name="admin" class="form-control" value="<?php echo isset($edit['biaya_admin']) ? $edit['biaya_admin'] : ''; ?>" placeholder="Masukan Biaya Admin" required onkeypress="return event.charCode >=48 && event.charCode <= 57" maxlength="5">
                                </div>
                                <div class="form-group">
                                    <label>NAMA</label>
                                    <input type="text" name="nama" class="form-control" value="<?php echo isset($edit['nama']) ? $edit['nama'] : ''; ?>" required placeholder="Masukan nama Agen" maxlength="50"> 
                                </div>
                                <div class="form-group">
                                    <label>ALAMAT</label>
                                    <textarea class="form-control" name="alamat" rows="3" required><?php echo isset($edit['alamat']) ? $edit['alamat'] : ''; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>NO.TELEPON</label>
                                    <input type="text" name="no" class="form-control" value="<?php echo isset($edit['no_telepon']) ? $edit['no_telepon'] : ''; ?>" required placeholder="Masukan No.Telepon Agen" onkeypress="return event.charCode >=48 && event.charCode <= 57" maxlength="15">
                                </div>
                                <div class="form-group">
                                    <?php 
                                    if (empty($id)) {?>
                                        <input type="submit" name="simpan" class="btn btn-primary btn-block btn-lg" value="SIMPAN">
                                    <?php } else {?>
                                        <input type="submit" name="ubah" class="btn btn-success btn-block btn-lg" value="UBAH">
                                    <?php } ?>
                                    <a href="?menu=agen" class="btn btn-danger btn-lg btn-block">RESET</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="panel-footer">&nbsp;</div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">DAFTAR AGEN</div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <?php  
                                if (isset($_POST['bcari'])) {
                                    $text = isset($_POST['tcari']) ? $_POST['tcari'] : '';
                                    $cari = "WHERE id_agen LIKE '%$text%' OR nama LIKE '%$text%' OR alamat LIKE '%$text%' OR no_telepon LIKE '%$text%' OR biaya_admin LIKE '%$text%' OR username LIKE '%$text%'";
                                } else {
                                    $cari = "";
                                }
                            ?>
                            <form method="post">
                                <div class="input-group">
                                    <input type="text" name="tcari" class="form-control" value="<?php echo isset($text) ? $text : ''; ?>" placeholder="Masukan Keyword Pencarian ...">
                                    <div class="input-group-btn">
                                        <button type="submit" name="bcari" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span>&nbsp;CARI</button>
                                        <button type="submit" name="refresh" class="btn btn-success"><span class="glyphicon glyphicon-refresh"></span>&nbsp;REFRESH</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <th>No.</th>
                                        <th>ID Agen</th>
                                        <th>Nama</th>
                                        <th>No.Telepon</th>
                                        <th>Alamat</th>
                                        <th>Biaya<br>Admin</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>Akses</th>
                                        <th colspan="2">Aksi</th>
                                    </thead>
                                    <tbody>
                                        <?php  
                                            $no = 0;
                                            $a = $aksi->tampil($table, $cari, "ORDER BY id_agen DESC");
                                            if (empty($a)) {
                                                $aksi->no_record(11);
                                            } else {
                                                foreach ($a as $r) {
                                                    $cek = $aksi->cekdata("pembayaran WHERE id_agen = '$r[id_agen]'");
                                                    $no++;
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $no; ?>.</td>
                                            <td><?php echo $r['id_agen']; ?></td>
                                            <td><?php echo $r['nama']; ?></td>
                                            <td><?php echo $r['no_telepon']; ?></td>
                                            <td><?php echo $r['alamat']; ?></td>
                                            <td><?php $aksi->rupiah($r['biaya_admin']); ?></td>
                                            <td><?php echo $r['username']; ?></td>
                                            <td><?php echo substr(md5($r['password']), 0, 10); ?></td>
                                            <td><?php echo $r['akses']; ?></td>
                                            <?php  
                                                if ($cek == 0) { ?>
                                                    <td align="center">
                                                        <a href="?menu=agen&hapus&id=<?php echo md5(sha1($r['id_agen'])); ?>" onclick="return confirm('Yakin Akan hapus data ini ?')">
                                                            <span class="glyphicon glyphicon-trash"></span>
                                                        </a>
                                                    </td>
                                            <?php } else { ?>
                                                <td>&nbsp;</td>
                                            <?php } ?>
                                            <td align="center">
                                                <a href="?menu=agen&edit&id=<?php echo md5(sha1($r['id_agen'])); ?>">
                                                    <span class="glyphicon glyphicon-edit"></span>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php } } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">&nbsp;</div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
