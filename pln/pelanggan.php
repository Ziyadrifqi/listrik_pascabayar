<?php  
	if (!isset($_GET['menu'])) {
		header('Location: hal_utama.php?menu=pelanggan');
		exit();
	}

	// Dasar
	$table = "pelanggan";
	$id = isset($_GET['id']) ? $_GET['id'] : '';
	$where = "MD5(SHA1(id_pelanggan)) = '$id'";
	$redirect = "?menu=pelanggan";

	// Kode Auto
	$id_pel = date("YmdHis");
	$no_met = str_pad(date("z") + 1, 3, "0", STR_PAD_LEFT) . date("ymNHs");

	// Untuk Kebutuhan CRUD
	$tenggang = date("d");
	$id_pelanggan = isset($_POST['id_pelanggan']) ? $_POST['id_pelanggan'] : '';
	$no_meter = isset($_POST['no_meter']) ? $_POST['no_meter'] : '';
	$nama = isset($_POST['nama']) ? $_POST['nama'] : '';
	$alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
	$id_tarif = isset($_POST['id_tarif']) ? $_POST['id_tarif'] : '';

	// Tampung Data
	$simpan_pelanggan = array(
		'id_pelanggan' => $id_pelanggan,
		'no_meter' => $no_meter,
		'nama' => $nama,
		'alamat' => $alamat,
		'tenggang' => $tenggang,
		'id_tarif' => $id_tarif,
	);

	$ubah_pelanggan = array(
		'nama' => $nama,
		'alamat' => $alamat,
		'id_tarif' => $id_tarif,
	);

	// Untuk Penggunaan Default Meter Awal
	$bulan = (date("d") > 25) ? (($bulan = date("m") + 1) < 10 ? "0$bulan" : $bulan) : date("m");
	$tahun = (date("d") > 25 && date("m") == 12) ? date("Y") + 1 : date("Y");

	$simpan_penggunaan = array(
		'id_penggunaan' => $id_pelanggan . $bulan . $tahun,
		'id_pelanggan' => $id_pelanggan,
		'bulan' => $bulan,
		'tahun' => $tahun,
		'meter_awal' => 0,
	);

	if (isset($_POST['bsimpan'])) {
		$aksi->simpan("penggunaan", $simpan_penggunaan);
		$aksi->simpan($table, $simpan_pelanggan);
		$aksi->alert("Data Berhasil Disimpan", $redirect);
		exit();
	}

	if (isset($_POST['bubah'])) {
		$aksi->update($table, $ubah_pelanggan, $where);
		$aksi->alert("Data Berhasil Diubah", $redirect);
		exit();
	}

	if (isset($_GET['edit'])) {
		$edit = $aksi->edit($table, $where);
	}

	if (isset($_GET['hapus'])) {
		$aksi->hapus("penggunaan", "id_pelanggan = '$id'");
		$aksi->hapus($table, $where);
		$aksi->alert("Data Berhasil Dihapus", $redirect);
		exit();
	}

	if (isset($_POST['bcari'])) {
		$text = $_POST['tcari'];
		$cari = "WHERE id_pelanggan LIKE '%$text%' OR nama LIKE '%$text%' OR no_meter LIKE '%$text%' OR alamat LIKE '%$text%' OR tenggang LIKE '%$text%'";
	} else {
		$cari = "";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>PELANGGAN</title>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-3">
					<div class="panel panel-default">
						<div class="panel-heading">
							<?php echo !isset($_GET['id']) ? "INPUT PELANGGAN" : "UBAH PELANGGAN"; ?>
						</div>
						<div class="panel-body">
							<form method="post">
								<div class="col-md-12">
									<div class="form-group">
										<label>ID PELANGGAN</label>
										<input type="text" name="id_pelanggan" class="form-control" placeholder="Masukan ID Pelanggan" required readonly value="<?php echo !isset($_GET['id']) ? $id_pel : $edit['id_pelanggan']; ?>">
									</div>
									<div class="form-group">
										<label>NO.METER</label>
										<input type="text" name="no_meter" class="form-control" placeholder="Masukan NO.METER" required readonly value="<?php echo !isset($_GET['id']) ? $no_met : $edit['no_meter']; ?>">
									</div>
									<div class="form-group">
										<label>NAMA</label>
										<input type="text" name="nama" class="form-control" placeholder="Masukan Nama" required value="<?php echo isset($edit['nama']) ? $edit['nama'] : ''; ?>">
									</div>
									<div class="form-group">
										<label>ALAMAT</label>
										<textarea name="alamat" class="form-control" required rows="3"><?php echo isset($edit['alamat']) ? $edit['alamat'] : ''; ?></textarea>
									</div>
									<div class="form-group">
										<label>JENIS TARIF</label>
										<select name="id_tarif" class="form-control" required>
											<?php  
												$b = $aksi->caridata("tarif WHERE id_tarif = '{$edit['id_tarif']}'");
												if (isset($_GET['id'])) {?>
													<option selected value="<?php echo $b['id_tarif'] ?>"><?php echo $b['kode_tarif']; ?></option>
												<?php } ?>
												<option></option>
											<?php  
												$a = $aksi->tampil("tarif");
												foreach ($a as $tarif) { ?>
													<option value="<?php echo $tarif['id_tarif'] ?>"><?php echo $tarif['kode_tarif']; ?></option>
											<?php }?>
										</select>
									</div>
									<div class="form-group">
										<?php  
										  if (!isset($_GET['id'])) {?>
											<input type="submit" name="bsimpan" class="btn btn-primary btn-lg btn-block" value="SIMPAN">
										  <?php } else { ?>
											<input type="submit" name="bubah" class="btn btn-success btn-lg btn-block" value="UBAH">
										<?php } ?>
										<a href="?menu=pelanggan" class="btn btn-danger btn-lg btn-block">RESET</a>
									</div>
								</div>
							</form>
						</div>
						<div class="panel-footer">&nbsp;</div>
					</div>
				</div>
				<div class="col-md-9">
					<div class="panel panel-default">
						<div class="panel-heading">DAFTAR PELANGGAN</div>
						<div class="panel-body">
							<div class="col-md-12">
								<form method="post">
									<div class="input-group">
										<input type="text" name="tcari" class="form-control" value="<?php echo isset($text) ? $text : ''; ?>" placeholder="Masukan Keyword Pencarian......">
										<div class="input-group-btn">
											<button type="submit" name="bcari" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span>&nbsp;CARI</button>
											<button type="submit" name="brefresh" class="btn btn-success"><span class="glyphicon glyphicon-refresh"></span>&nbsp;REFRESH</button>
										</div>
									</div>
								</form>
							</div>
							<br>
							
							<div class="col-md-12">
								<div class="table-responsive">
									<table class="table table-bordered table-striped table-hover">
										<thead>
											<tr>
												<th>No.</th>
												<th>ID Pelanggan</th>
												<th>No.Meter</th>
												<th>Nama</th>
												<th>Alamat</th>
												<th>Tenggang</th>
												<th>Kode Tarif</th>
												<th colspan="2"><center>AKSI</center></th>
											</tr>
										</thead>
										<tbody>
											<?php  
												$no = 1;
												$data = $aksi->tampil($table, '', $cari);
												if (empty($data)) {
													$aksi->no_record(9);
												} else {
													foreach ($data as $r) {
														$tarif = $aksi->caridata("tarif WHERE id_tarif = '{$r['id_tarif']}'");
														$isPending = $aksi->cekdata("penggunaan WHERE id_pelanggan = '{$r['id_pelanggan']}' AND meter_awal = 0") ? : '';
														?>
														<tr<?php echo $isPending; ?>>
															<td><?php echo $no++; ?></td>
															<td><?php echo $r['id_pelanggan']; ?></td>
															<td><?php echo $r['no_meter']; ?></td>
															<td><?php echo $r['nama']; ?></td>
															<td><?php echo $r['alamat']; ?></td>
															<td><?php echo $r['tenggang']; ?></td>
															<td><?php echo $tarif['kode_tarif']; ?></td>
															<td><a href="?menu=pelanggan&id=<?php echo md5(sha1($r['id_pelanggan'])); ?>&edit" class="btn btn-warning btn-sm">Edit</a></td>
															<td><a href="?menu=pelanggan&id=<?php echo md5(sha1($r['id_pelanggan'])); ?>&hapus" onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn btn-danger btn-sm">Hapus</a></td>
														</tr>
												<?php } } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>

