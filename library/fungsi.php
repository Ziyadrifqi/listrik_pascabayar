<?php
class oop {
    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    public function simpan($table, $data) {
        $columns = implode(", ", array_keys($data));
        $values = "'" . implode("', '", array_values($data)) . "'";
        
        $query = "INSERT INTO $table ($columns) VALUES ($values)";
        
        if ($this->conn->query($query) === FALSE) {
            if ($this->conn->errno === 1062) {
                // Duplicate entry error
                echo "Duplicate entry detected.";
            } else {
                // Other errors
                echo "Error: " . $this->conn->error;
            }
            return false;
        } else {
            echo "Data successfully inserted.";
            return true;
        }
    }
    
    public function tampil($table, $where = '', $cari = '') {
        $sql = "SELECT * FROM $table $where $cari";
        $result = $this->conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    public function edit($table, $where) {
        $sql = "SELECT * FROM $table WHERE $where";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }

    public function hapus($table, $where) {
        $sql = "DELETE FROM $table WHERE $where";
        return $this->conn->query($sql);
    }

    // Method to update data
    public function update($table, $data, $where) {
        $sets = [];
        foreach ($data as $column => $value) {
            $sets[] = "$column='$value'";
        }
        $set_clause = implode(", ", $sets);
        $query = "UPDATE $table SET $set_clause WHERE $where";
        if ($this->conn->query($query) === FALSE) {
            echo "Error: " . $this->conn->error;
        }
    }

    public function caridata($table) {
        $sql = "SELECT * FROM $table";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }

    public function cekdata($table) {
        $sql = "SELECT * FROM $table";
        $result = $this->conn->query($sql);
        return $result->num_rows;
    }

    public function pesan($pesan) {
        echo "<script>alert('$pesan');</script>";
    }

    public function alert($pesan, $alamat) {
        echo "<script>alert('$pesan');document.location.href='$alamat'</script>";
    }

    public function redirect($alamat) {
        echo "<script>document.location.href='$alamat'</script>";
    }

    public function no_record($col) {
        echo "<tr><td colspan='$col' align='center'>Data Tidak Ada !!!</td></tr>";
    }

    public function rupiah($uang) {
        echo "Rp. ".number_format($uang, 0, ',', '.').",-";
    }

    public function bulan($bulan) {
        $bln = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        echo $bln[$bulan] ?? '';
    }

    public function bulan_substr($bulan) {
        $bln = [
            '01' => 'JAN', '02' => 'FEB', '03' => 'MAR', '04' => 'APR',
            '05' => 'MEI', '06' => 'JUN', '07' => 'JUL', '08' => 'AGU',
            '09' => 'SEP', '10' => 'OKT', '11' => 'NOV', '12' => 'DES'
        ];
        echo $bln[$bulan] ?? '';
    }

    public function format_tanggal($tanggal) {
        $tahun = substr($tanggal, 0, 4);
        $bulan = substr($tanggal, 5, 2);
        $tanggal = substr($tanggal, 8, 2);
        $bln = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', '04' => 'April',
            '05' => 'Mei', '06' => 'Juni', '07' => 'Juli', '08' => 'Agustus',
            '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
        ];
        echo "$tanggal ".$bln[$bulan]." $tahun";
    }

    public function hari($today) {
        $hari = [
            '1' => 'Senin', '2' => 'Selasa', '3' => 'Rabu', '4' => 'Kamis',
            '5' => 'Jumat', '6' => 'Sabtu', '7' => 'Minggu'
        ];
        echo $hari[$today] ?? '';
    }

    public function login($table, $username, $password, $alamat) {

        $username = $this->conn->real_escape_string($username);
        $password = $this->conn->real_escape_string($password);
        $sql = "SELECT * FROM $table WHERE username = '$username' AND password = '$password'";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            if ($table == "petugas") {
                $_SESSION['username_petugas'] = $data['username'];
                $_SESSION['id_petugas'] = $data['id_petugas'];
                $_SESSION['nama_petugas'] = $data['nama'];
                $_SESSION['akses_petugas'] = $data['akses'];
                $this->alert("Login Berhasil, Selamat Datang ".$data['nama'], $alamat);
            } elseif ($table == "agen") {
                $_SESSION['username_agen'] = $data['username'];
                $_SESSION['biaya_admin'] = $data['biaya_admin'];
                $_SESSION['id_agen'] = $data['id_agen'];
                $_SESSION['nama_agen'] = $data['nama'];
                $_SESSION['akses_agen'] = $data['akses'];
                $this->alert("Login Berhasil, Selamat Datang ".$data['nama'], $alamat);
            }
        } else {
            $this->pesan("username atau password salah");
        }
    }

    public function upload($tempat) {
        $alamatfile = $_FILES['foto']['tmp_name'];
        $namafile = $_FILES['foto']['name'];
        move_uploaded_file($alamatfile, "$tempat/$namafile");
        return $namafile;
    }
}

?>
