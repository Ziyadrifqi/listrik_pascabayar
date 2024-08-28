<?php
if (!isset($_GET['menu'])) {
    header('Location: hal_utama.php?menu=pembayaran');
    exit();
}

$table = "pembayaran";
$id = $_GET['id'] ?? '';
$where = "id_pembayaran = '$id'";
$redirect = "?menu=pembayaran";

// Generate automatic code
$hari_ini = date("Ymd");
$sql = $conn->query("SELECT id_pembayaran FROM pembayaran WHERE id_pembayaran LIKE '%$hari_ini%' ORDER BY id_pembayaran DESC");
$cek = $sql->fetch_assoc();

if (empty($cek)) {
    $id_pembayaran = "BYR" . $hari_ini . "0001";
} else {
    $kode = substr($cek['id_pembayaran'], 12, 4) + 1;
    $id_pembayaran = "BYR" . $hari_ini . str_pad($kode, 4, '0', STR_PAD_LEFT);
}

// Initialize variables
$id_pelanggan = $_POST['id_pelanggan'] ?? '';
?>
<!DOCTYPE html>
<html>
<head>
    <title>PEMBAYARAN</title>
</head>

<body>
<style> 
.container-fluid{
            margin: 3rem;
        }
        </style>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading" style="font-family: Monaco, monospace; font-size: 15px">INPUT PEMBAYARAN - <?php echo $id_pembayaran; ?></div>
                        <div class="panel-body">
                            <form method="post">
                                <label style="font-family: Monaco, monospace; font-size: 15px">ID PELANGGAN</label>
                                <div class="input-group">
                                    <input type="text" name="id_pelanggan" class="form-control"
                                           value="<?php echo htmlspecialchars($_GET['id_pelanggan'] ?? $id_pelanggan); ?>"
                                           placeholder="Masukan ID Pelanggan ...."
                                           onkeypress='return event.charCode >= 48 && event.charCode <= 57' list="list">
                                    <datalist id="list">
                                        <?php
                                        $result = $conn->query("SELECT * FROM pelanggan");
                                        while ($row = $result->fetch_assoc()) { ?>
                                            <option value="<?php echo $row['id_pelanggan']; ?>"><?php echo $row['nama']; ?></option>
                                        <?php } ?>
                                    </datalist>
                                    <div class="input-group-btn">
                                        <button type="submit" name="bcari_id" class="btn btn-primary"><span
                                                class="glyphicon glyphicon-search"></span>&nbsp;CARI
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
           if (isset($_POST['bcari_id'])) {
					$pelanggan = $aksi->caridata("pelanggan WHERE id_pelanggan = '$id_pelanggan'");	
					$tagihan = $aksi->cekdata("tagihan WHERE id_pelanggan = '$id_pelanggan' AND status ='Belum Bayar'");	
					if ($pelanggan) {
                        $tarif = $aksi->caridata("tarif WHERE id_tarif = '{$pelanggan['id_tarif']}'");
                        $tarif_perkwh = $tarif['tarif_perkwh'] ?? 0;
                    } else {
                        $tarif_perkwh = 0; // Default value or handle error
                    }

					if($pelanggan==""){
							echo "<div class='col-md-12'><center><h2>ID PELANGGAN TIDAK DITEMUKAN</h2></center></div>";
					}elseif($tagihan == 0){
							$aksi->pesan("ID Pelangan Tidak Memiliki Tunggakan Tagihan");
					}else{
                    ?>
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <center>DETAIL TAGIHAN - <?php echo $id_pelanggan . " - " . $pelanggan['nama']; ?>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <div class="col-md-3">
                                        <center><label>Detail Pelanggan - <?php echo $pelanggan['nama']; ?></label></center>
                                        <table class="table table-striped table-hover" align="center">
                                            <tr>
                                                <td align="right">ID Pelanggan</td>
                                                <td width="5%">:</td>
                                                <td align="left"><?php echo $pelanggan['id_pelanggan']; ?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Nama</td>
                                                <td width="5%">:</td>
                                                <td align="left"><?php echo $pelanggan['nama']; ?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">No.Meter</td>
                                                <td width="5%">:</td>
                                                <td align="left"><?php echo $pelanggan['no_meter']; ?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Alamat</td>
                                                <td width="5%">:</td>
                                                <td align="left"><?php echo $pelanggan['alamat']; ?></td>
                                            </tr>
                                            <tr>
                                                <td align="right">Tarif</td>
                                                <td width="5%">:</td>
                                                <td align="left"><?php echo $tarif['kode_tarif'] . "<br>" . number_format($tarif['tarif_perkwh']); ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-9">
                                        <center><label>Detail Tagihan - <?php echo $pelanggan['nama']; ?></label></center>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover">
                                                <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>ID Pelanggan</th>
                                                    <th>Bulan</th>
                                                    <th><center>Meter Terpakai</center></th>
                                                    <th><center>Tarif/KWh</center></th>
                                                    <th><center>Jumlah Bayar</center></th>
                                                    <th><center>AKSI</center></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $no = 0;
                                                $result = $conn->query("SELECT * FROM tagihan WHERE id_pelanggan = '$id_pelanggan' AND status = 'Belum Bayar' ORDER BY bulan ASC");
                                                while ($row = $result->fetch_assoc()) {
                                                    $penggunaan = $conn->query("SELECT * FROM penggunaan WHERE id_pelanggan = '{$row['id_pelanggan']}' AND bulan = '{$row['bulan']}' AND tahun = '{$row['tahun']}'")->fetch_assoc();
                                                    $no++; ?>
                                                    <tr>
                                                        <td><?php echo $no; ?>.</td>
                                                        <td><?php echo $row['id_pelanggan']; ?></td>
                                                        <td><?php echo $row['bulan'] . "-" . $row['tahun']; ?></td>
                                                        <td align="center"><?php echo $row['jumlah_meter']; ?></td>
                                                        <td align="center"><?php echo number_format($row['tarif_perkwh']); ?></td>
                                                        <td align="center"><?php echo number_format($row['jumlah_bayar']); ?></td>
                                                        <td align="center"><a
                                                                href="?menu=pembayaran&id_pelanggan=<?php echo $row['id_pelanggan']; ?>&bulan=<?php echo $row['bulan']; ?>&tahun=<?php echo $row['tahun']; ?>"
                                                                class="btn btn-success btn-lg btn-block" target="_blank">BAYAR</a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <td colspan="5" align="right">TOTAL TAGIHAN<strong>:</strong></td>
                                                    <td colspan="2" align="center">
                                                        <input type="text" name="total_bayar"
                                                               value="<?php echo number_format($conn->query("SELECT SUM(jumlah_bayar) AS sum_bayar FROM tagihan WHERE id_pelanggan = '$id_pelanggan' AND status = 'Belum Bayar'")->fetch_assoc()['sum_bayar']); ?>"
                                                               readonly class="form-control">
                                                    </td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">&nbsp;</div>
                        </div>
                    </div>
                <?php }}elseif(isset($_GET['id_pelanggan'])){ 
				$penggunaan = $aksi->caridata("penggunaan WHERE id_pelanggan = '$_GET[id_pelanggan]' AND bulan = '$_GET[bulan]' AND tahun = '$_GET[tahun]'");
				$tagihan = $aksi->caridata("tagihan WHERE id_pelanggan = '$_GET[id_pelanggan]' AND bulan = '$_GET[bulan]' AND tahun = '$_GET[tahun]'");
				$sum_akhir = ($tagihan['jumlah_bayar']+$_SESSION['biaya_admin']);

				@$biaya_admin = $_POST['biaya_admin'];
				@$total_bayar = $_POST['total_bayar'];
				@$total_akhir = $_POST['total_akhir'];
				@$bayar = $_POST['bayar'];
				@$kembali = $_POST['kembali'];
				@$tanggal = date("Y-m-d");
				@$id_agen = $_SESSION['id_agen'];

				@$id_pel = $_GET['id_pelanggan'];
				@$bln = $_GET['bulan'];
				@$thn = $_GET['tahun'];
				@$field = array(
					'id_pembayaran'=>$id_pembayaran,
					'id_pelanggan'=>$id_pel,
					'tgl_bayar'=>$tanggal,
					'jumlah_bayar'=>$total_bayar,
					'biaya_admin'=>$biaya_admin,
					'bulan_bayar'=>$bln,
					'tahun_bayar'=>$thn,
					'total_akhir'=>$total_akhir,
					'bayar'=>$bayar,
					'kembali'=>$kembali,
					'id_agen'=>$id_agen,
				);

				if (isset($_POST['bbayar'])) {
					if ($bayar < $total_akhir) {
						$aksi->pesan("Maaf Uang Tidak Mencukupi");
					}else{
						$aksi->update("tagihan",array('status'=>"Terbayar"),"id_pelanggan = '$id_pel' AND bulan = '$bln' AND tahun = '$thn' AND status = 'Belum Bayar'");
						$aksi->simpan($table,$field);
						$aksi->alert("Data Berhasil Disimpan","struk.php?id_pelanggan=".$id_pel."&bulan=".$bln."&tahun=".$thn);
					}
				}

				?>
						<div class="col-md-12">
							<div class="col-md-3"></div>
							<div class="col-md-6">
								<div class="panel panel-default">
									<div class="panel-heading">PEMBAYARAN - <?php echo @$_GET['id_pelanggan']." Bulan ";$aksi->bulan(@$_GET['bulan']); echo " ".@$_GET['tahun']; ?></div>
									<div class="panel-body">
										<div class="col-md-12">
											<form method="post">
											 		<tfoot>
											 			<tr>
												 			<td colspan="7" align="right" valign="center">BULAN PENGGUNAAN</td>
												 			<td colspan="2" align="center" valign="center">
												 				<input type="text" name="bulan" value="<?php $aksi->bulan($_GET['bulan']);echo " ".$_GET['tahun']?>" readonly class="form-control" required>
												 			</td>
												 		</tr>
												 		
												 		<tr>
												 			<td colspan="7" align="right" valign="center">METER TERPAKAI</td>
												 			<td colspan="2" align="center" valign="center">
												 				<input type="text" name="jumlah_meter" value="<?php echo @$tagihan['jumlah_meter']; ?>" readonly class="form-control">
												 			</td>
												 		</tr>
												 		<tr>
												 			<td colspan="7" align="right" valign="center">TARIF/KWH</td>
												 			<td colspan="2" align="center" valign="center">
												 				<input type="text" name="tarif_perkwh" value="<?php echo @$tagihan['tarif_perkwh']; ?>" readonly class="form-control">
												 			</td>
												 		</tr>
												 		<tr>
												 			<td colspan="7" align="right" valign="center">TAGIHAN PLN</td>
												 			<td colspan="2" align="center" valign="center">
												 				<input type="text" name="total_bayar" value="<?php echo @$tagihan['jumlah_bayar']; ?>" readonly class="form-control">
												 			</td>
												 		</tr>
												 		<tr>
												 			<td colspan="7" align="right" valign="center">BIAYA ADMIN <strong>:</strong></td>
												 			<td colspan="2" align="center" valign="center">
												 				<input type="text" name="biaya_admin" value="<?php echo @$_SESSION['biaya_admin']; ?>" readonly class="form-control">
												 			</td>
												 		</tr>
												 		<tr>
												 			<td colspan="7" align="right" valign="center">TOTAL AKHIR<strong>:</strong></td>
												 			<td colspan="2" align="center" valign="center">
												 				<input type="text" id="ttotalakhir" name="total_akhir" value="<?php echo $sum_akhir;?>" readonly class="form-control" required>
												 			</td>
												 		</tr>
												 		<tr>
												 			<td colspan="7" align="right" valign="center">BAYAR<strong>:</strong></td>
												 			<td colspan="2" align="center" valign="center">
												 				<input type="text" id="tbayar" name="bayar" required class="form-control" onkeypress='return event.charCode >=48 && event.charCode <=57' required>
												 			</td>
												 		</tr>
												 		<tr>
												 			<td colspan="7" align="right" valign="center">KEMBALI<strong>:</strong></td>
												 			<td colspan="2" align="center" valign="center">
												 				<input type="text" id="tkembalian" name="kembali" value="" required  readonly class="form-control" >
												 			</td>
												 		</tr>
												 		<tr>
												 			<td colspan="7" align="right" valign="center">&nbsp;</td>
												 			<td colspan="2" align="center" valign="center">
												 				<input type="submit" name="bbayar" value="BAYAR" class="btn btn-primary btn-lg btn-block">
												 			</td>
												 		</tr>
												 	</tfoot>
											 	</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
		</div>
	</div>
</body>
</html>