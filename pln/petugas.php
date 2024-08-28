<?php  
    // Redirect jika menu tidak ada
    if (!isset($_GET['menu'])) {
        header("location:hal_utama.php?menu=petugas");
        exit();
    }

    // Setup variabel
    $table = "petugas";
    $id = isset($_GET['id']) ? $_GET['id'] : '';
    $where = "md5(sha1(id_petugas)) = '$id'";
    $redirect = "?menu=petugas";

    // Autocode ID Petugas
    $today = date("Ymd");
    $petugas = $aksi->caridata("petugas WHERE id_petugas LIKE '%$today%' ORDER BY id_petugas DESC");
    $id_petugas = 'P'.$today.'001';
    if (!empty($petugas)) {
        $kode = substr($petugas['id_petugas'], 9, 3) + 1;
        $id_petugas = sprintf("P".$today.'%03s', $kode);
    }

    // Cek username
    $cek_user = 0;
    if (isset($_POST['username'])) {
        $cek_user = $aksi->cekdata("petugas WHERE username = '".$_POST['username']."'");
    }

    $field = array(
        'id_petugas' => isset($_POST['id']) ? $_POST['id'] : '',
        'username'   => isset($_POST['username']) ? $_POST['username'] : '',
        'password'   => isset($_POST['password']) ? $_POST['password'] : '',
        'akses'      => 'petugas',
        'nama'       => isset($_POST['nama']) ? $_POST['nama'] : '',
        'alamat'     => isset($_POST['alamat']) ? $_POST['alamat'] : '',
        'no_telepon' => isset($_POST['no']) ? $_POST['no'] : '',
        'email'      => isset($_POST['email']) ? $_POST['email'] : '',
        'jk'         => isset($_POST['jk']) ? $_POST['jk'] : '',
    );

    $field_ubah = array(
        'username'   => isset($_POST['username']) ? $_POST['username'] : '',
        'password'   => isset($_POST['password']) ? $_POST['password'] : '',
        'nama'       => isset($_POST['nama']) ? $_POST['nama'] : '',
        'alamat'     => isset($_POST['alamat']) ? $_POST['alamat'] : '',
        'no_telepon' => isset($_POST['no']) ? $_POST['no'] : '',
        'email'      => isset($_POST['email']) ? $_POST['email'] : '',
        'jk'         => isset($_POST['jk']) ? $_POST['jk'] : '',
    );

    // Proses Simpan Data
if (isset($_POST['simpan'])) {
    if ($cek_user > 0) {
        $aksi->pesan("Username sudah ada !!!");
    } else {
        if ($aksi->simpan($table, $field)) {
            $aksi->alert("Data berhasil disimpan", $redirect);
        } else {
            $aksi->alert("Data gagal disimpan", $redirect); // Optional: handle failure case
        }
    }
}


    // Ambil data untuk edit
    if (isset($_GET['edit'])) {
        $edit = $aksi->edit($table, $where);
    }

    // Proses Ubah Data
    
	if (isset($_POST['ubah'])) {
		$aksi->update($table, $field_ubah, $where);
		$aksi->alert("Data Berhasil Diubah", $redirect);
		exit();
	}


    // Proses Hapus Data
    if (isset($_GET['hapus'])) {
        if ($aksi->hapus($table, $where)) {
            $aksi->alert("Data berhasil dihapus", $redirect);
        } else {
            $aksi->pesan("Gagal menghapus data");
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>PETUGAS</title>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php 
                            if (empty($_GET['id'])) {
                                echo "INPUT PETUGAS";
                            } else {
                                echo "UBAH PETUGAS";
                            } 
                        ?>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>ID PETUGAS</label>
                                    <input type="text" name="id" class="form-control" value="<?php echo empty($_GET['id']) ? $id_petugas : $edit['id_petugas']; ?>" readonly required>
                                </div>
                                <div class="form-group">
                                    <label>USERNAME</label>
                                    <input type="text" name="username" class="form-control" value="<?php echo isset($edit['username']) ? $edit['username'] : ''; ?>" required placeholder="Masukan username Petugas" maxlength="30"> 
                                </div>
                                <div class="form-group">
                                    <label>PASSWORD</label>
                                    <input type="password" name="password" class="form-control" value="<?php echo isset($edit['password']) ? $edit['password'] : ''; ?>" required placeholder="Masukan password Petugas" maxlength="30"> 
                                </div>
                                <div class="form-group">
                                    <label>JENIS KELAMIN</label>
                                    <select name="jk" class="form-control" required>
                                        <option value="L" <?php echo (isset($edit['jk']) && $edit['jk'] == 'L') ? 'selected' : ''; ?>>Laki-Laki</option>
                                        <option value="P" <?php echo (isset($edit['jk']) && $edit['jk'] == 'P') ? 'selected' : ''; ?>>Perempuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>NAMA</label>
                                    <input type="text" name="nama" class="form-control" value="<?php echo isset($edit['nama']) ? $edit['nama'] : ''; ?>" required placeholder="Masukan nama Petugas" maxlength="50"> 
                                </div>
                                <div class="form-group">
                                    <label>ALAMAT</label>
                                    <textarea class="form-control" name="alamat" rows="3" required><?php echo isset($edit['alamat']) ? $edit['alamat'] : ''; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>EMAIL</label>
                                    <input type="email" name="email" class="form-control" value="<?php echo isset($edit['email']) ? $edit['email'] : ''; ?>" required placeholder="Masukan email Petugas" maxlength="50">
                                </div>
                                <div class="form-group">
                                    <label>NO.TELEPON</label>
                                    <input type="text" name="no" class="form-control" value="<?php echo isset($edit['no_telepon']) ? $edit['no_telepon'] : ''; ?>" required placeholder="Masukan No.Telepon Petugas" onkeypress="return event.charCode >= 48 && event.charCode <= 57" maxlength="15">
                                </div>
                                <div class="form-group">
                                    <?php 
                                    if (empty($_GET['id'])) {?>
                                        <input type="submit" name="simpan" class="btn btn-primary btn-block btn-lg" value="SIMPAN">
                                     <?php } else {?>
                                        <input type="submit" name="ubah" class="btn btn-success btn-block btn-lg" value="UBAH">
                                     <?php } ?>
                                    <a href="?menu=petugas" class="btn btn-danger btn-lg btn-block">RESET</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="panel-footer">&nbsp;</div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">DAFTAR PETUGAS</div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <?php  
                                if (isset($_POST['bcari'])) {
                                    $text = isset($_POST['tcari']) ? $_POST['tcari'] : '';
                                    $cari = "WHERE id_petugas LIKE '%$text%' OR nama LIKE '%$text%' OR alamat LIKE '%$text%' OR no_telepon LIKE '%$text%' OR jk LIKE '%$text%' OR username LIKE '%$text%'";
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
                                        <th>ID Petugas</th>
                                        <th>Nama</th>
                                        <th>No.Telepon</th>
                                        <th>Email</th>
                                        <th>Alamat</th>
                                        <th>JK</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>Akses</th>
                                        <th colspan="2">Aksi</th>
                                    </thead>
                                    <tbody>
                                        <?php  
                                            $no = 0;
                                            $a = $aksi->tampil($table, $cari, "ORDER BY id_petugas DESC");
                                            if (empty($a)) {
                                                $aksi->no_record(11);
                                            } else {
                                                foreach ($a as $r) {
                                                    $cek = $aksi->cekdata("penggunaan WHERE id_petugas = '".$r['id_petugas']."'");
                                                    if ($r['id_petugas'] != $_SESSION['id_petugas']) {
                                                        $no++;
                                        ?>

                                        <tr>
                                            <td align="center"><?php echo $no; ?>.</td>
                                            <td><?php echo $r['id_petugas']; ?></td>
                                            <td><?php echo $r['nama']; ?></td>
                                            <td><?php echo $r['no_telepon']; ?></td>
                                            <td><?php echo $r['email']; ?></td>
                                            <td><?php echo $r['alamat']; ?></td>
                                            <td><?php echo $r['jk'] == 'L' ? 'Laki-Laki' : 'Perempuan'; ?></td>
                                            <td><?php echo $r['username']; ?></td>
                                            <td><?php echo substr(md5($r['password']), 0, 10); ?></td>
                                            <td><?php echo $r['akses']; ?></td>
                                            <?php  
                                                if ($cek == 0) { ?>
                                                    <td align="center">
                                                        <a href="?menu=petugas&hapus&id=<?php echo md5(sha1($r['id_petugas'])); ?>" onclick="return confirm('Yakin Akan hapus data ini ?')">
                                                            <span class="glyphicon glyphicon-trash"></span>
                                                        </a>
                                                    </td>
                                            <?php } else { ?>
                                                <td>&nbsp;</td>
                                            <?php } ?>
                                            <td align="center">
                                                <a href="?menu=petugas&edit&id=<?php echo md5(sha1($r['id_petugas'])); ?>">
                                                        <span class="glyphicon glyphicon-edit"></span>
                                                </a>
                                            </td>
                                        </tr>

                                <?php   } } } ?>
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
