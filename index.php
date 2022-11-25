<?php
session_start();
if (!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Pendaftaran</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href=
    "https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity=
    "sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin=
    "anonymous">
</head>
<body>
    <!-- HEADER -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">DIGITAL TALENT</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=
                "#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php?fungsi=read">Calon Peserta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?fungsi=create">Daftar Baru</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href=""></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<?php
include('koneksi.php');
// --- Program Utama -------
if (isset($_GET['fungsi'])){
    switch($_GET['fungsi']){
        case "create":
        create($koneksi);
        break;
    case "create_success":
        create_success();
        break;
    case "read":
        read($koneksi);
        break;
    case "update":
        update($koneksi);
        break;
    case "update_success":
        update_success();
        break;
    case "delete":
        delete($koneksi);
        break;
    case "delete_success":
        delete_success();
        break;
    default:
        read($koneksi);
    }
} else {
    mainpage();
}
// --- Fungsi Tampilan halaman awal
function mainpage(){
    echo'
    <div class="container" style="margin-top:20px">
        <h3>Pendaftaran Peserta Digital Telent</h3>
        <hr>
        <p> Silahkan pilih <b> Menu Daftar Baru</b> untuk menambahkan peserta baru </p>
    </div>';
}
// --- Fungsi tambah data (Create)
function create($koneksi){
    if (isset($_POST['btn_simpan'])){
        $nama_peserta = $_POST['nama_peserta'];
        $alamat = $_POST['alamat'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $agama = $_POST['agama'];
        $sekolah_asal = $_POST['sekolah_asal'];
        if(!empty($nama_peserta) && !empty($alamat) && !empty($jenis_kelamin) && !empty($agama)
        && !empty($sekolah_asal)){
            $sql = "INSERT INTO pendaftaran (id_peserta,nama_peserta, alamat, jenis_kelamin, 
            agama, sekolah_asal) VALUES('','".$nama_peserta."','".$alamat."','".$jenis_kelamin."','".$agama.
            "','".$sekolah_asal."')";
            //echo $sql;
            $simpan = mysqli_query($koneksi, $sql);
            if($simpan && isset($_GET['fungsi'])){
                if($_GET['fungsi'] == 'create'){
                    header('location: index.php?fungsi=create_success');
                }
            }
        } else {
            $pesan = "Tidak dapat menyimpan, data belum lengkap!";
        }
    }
    ?>
    <div class="container" style="margin-top:20px">
        <h2>Tambah Data Peserta</h2>
        <form action="index.php?fungsi=create" method="post">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input type="text" name="nama_peserta" class="form-control" size="4"
                    required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                    <textarea name="alamat" class="form-control" required></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                <div class="col-sm-10">
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="jenis_kelamin" value=
                        "L" required>
                        <label class="form-check-label">Laki-laki</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="jenis_kelamin" value=
                        "P" required>
                        <label class="form-check-label">Perempuan</label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Agama</label>
                <div class="col-sm-10">
                    <select name="agama" class="form-control" required>
                        <option value="">Pilih salah satu</option>
                        <option value="Islam">Islam</option>
                        <option value="Kristen Protestan">Kristen Protestan</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Budha">Budha</option>
                        <option value="Kepercayaan lainnya">Kepercayaan lainnya</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Sekolah Asal</label>
                <div class="col-sm-10">
                    <input type="text" name="sekolah_asal" class="form-control" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">&nbsp;</label>
                <div class="col-sm-10">
                    <input type="submit" name="btn_simpan" class="btn btn-primary" value=
                    "Simpan">
                    <input type="reset" name="btn_reset" class="btn btn-info" value="Reset">
                    <a href="index.php" class="btn btn-success" role="button">Kembali</a>
                </div>
            </div>
        </form>
    </div>
    <?php
}
// --- Fungsi Tampilan halaman berhasil tambah data
function create_success(){
    echo'
    <div class="container" style="margin-top:20px">
        <h3>Data Calon Peserta Digital Telent</h3>
        <hr>
        <p> Pendaftaran Berhasil </p>
    </div>';
}
// --- Fungsi Baca Data (Read)
function read($koneksi){
    echo'
    <div class="container" style="margin-top:20px">
    <h2>Pendaftar</h2>
    <hr>
    <a href="cetak_excel.php"><button>Cetak Spreadsheet</button></a>
    <a href="cetak_pdf.php"><button>Cetak PDF</button></a><br>
    <table class="table table-striped table-hover table-sm table-bordered">
    <thead class="thead-dark">
        <tr>
            <th>No</th>
            <th>Nama Peserta</th>
            <th>Alamat</th>
            <th>Jenis Kelamin</th>
            <th>Agama</th>
            <th>Sekolah Asal</th>
            <th>Tindakan</th>
        </tr>
    </thead>
    <tbody>';
    //query ke database SELECT tabel mahasiswa urut berdasarkan id yang paling besar
    $sql = "SELECT * FROM pendaftaran";
    $query = mysqli_query($koneksi, $sql);
    //jika query diatas menghasilkan nilai > 0 maka menjalankan script di bawah if...
    if(mysqli_num_rows($query) > 0){
        $no=1;
        //melakukan perulangan while dengan dari dari query $sql
        while($data = mysqli_fetch_assoc($query)){
        //menampilkan data perulangan
            echo '
            <tr>
                <td>'.$no.'</td>
                <td>'.$data['nama_peserta'].'</td>
                <td>'.$data['alamat'].'</td>
                <td>'.$data['jenis_kelamin'].'</td>
                <td>'.$data['agama'].'</td>
                <td>'.$data['sekolah_asal'].'</td>
                <td>
                <a href="index.php?fungsi=update&id_peserta='.$data['id_peserta'
                ].'" class="badge badge-warning">Edit</a>
                <a href="index.php?fungsi=delete&id_peserta='.$data['id_peserta'
                ].'" class="badge badge-danger" onclick="return confirm(\'Yakin ingin menghapus data 
                ini?\')">Delete</a>
                </td>
            </tr>';
            $no++;
        }
        //jika query menghasilkan nilai 0
    }else{
        echo '
        <tr>
            <td colspan="6">Tidak ada data.</td>
        </tr>
        ';
    }
    echo'
    <tbody>
    </table>
    </div>';
}
// --- Fungsi Ubah Data (Update)
function update($koneksi){
    if (isset($_POST['btn_simpan'])){
        $id_peserta = $_POST['id_peserta'];
        $nama_peserta = $_POST['nama_peserta'];
        $alamat = $_POST['alamat'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $agama = $_POST['agama'];
        $sekolah_asal = $_POST['sekolah_asal'];
        if(!empty($nama_peserta) && !empty($alamat) && !empty($jenis_kelamin) && !empty($agama)
            && !empty($sekolah_asal)){
            $sql = "UPDATE pendaftaran SET nama_peserta='$nama_peserta', alamat='$alamat', 
            jenis_kelamin='$jenis_kelamin', agama='$agama', sekolah_asal='$sekolah_asal' WHERE id_peserta='
            $id_peserta'";
            echo $sql;
            $update = mysqli_query($koneksi, $sql);
            if($update && isset($_GET['fungsi'])){
                if($_GET['fungsi'] == 'update'){
                    header('location: index.php?fungsi=update_success');
                }
            }
        } else {
            $pesan = "Tidak dapat menyimpan, data belum lengkap!";
        }
    } else {
        $id_peserta = $_GET['id_peserta'];
        // ambil data peserta untuk ditampilkan ke dalam form update
        $sql_peserta = "SELECT * FROM pendaftaran WHERE id_peserta=" . $id_peserta;
        $query_peserta = mysqli_query($koneksi, $sql_peserta);
        $data_peserta = mysqli_fetch_assoc($query_peserta);
    }
?>
    <div class="container" style="margin-top:20px">
    <h2>Update Data Peserta</h2>
        <form action="index.php?fungsi=update" method="post">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Nama</label>
            <div class="col-sm-10">
                <input type="text" name="nama_peserta" class="form-control" size="4" value="
                <?php echo $data_peserta['nama_peserta']; ?>" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Alamat</label>
            <div class="col-sm-10">
                <textarea name="alamat" class="form-control" required><?php echo
                $data_peserta['alamat']; ?></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
            <div class="col-sm-10">
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="jenis_kelamin" value=
                    "L" <?php if($data_peserta['jenis_kelamin'] == 'L'){ echo 'checked'; } ?> required>
                    <label class="form-check-label">Laki-laki</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="jenis_kelamin" value=
                    "P" <?php if($data_peserta['jenis_kelamin'] == 'P'){ echo 'checked'; } ?> required>
                    <label class="form-check-label">Perempuan</label>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Agama</label>
            <div class="col-sm-10">
                <select name="agama" class="form-control" required>
                    <option value="">Pilih salah satu</option>
                    <option value="Islam" <?php if($data_peserta['agama'] == 'Islam'){ echo
                        'selected'; } ?>>Islam</option>
                    <option value="Kristen Protestan" <?php if($data_peserta['agama'] ==
                        'Kristen Protestan'){ echo 'selected'; } ?>>Kristen Protestan</option>
                    <option value="Katolik" <?php if($data_peserta['agama'] == 'Katolik'){
                        echo 'selected'; } ?>>Katolik</option>
                    <option value="Hindu" <?php if($data_peserta['agama'] == 'Hindu'){ echo
                        'selected'; } ?>>Hindu</option>
                    <option value="Budha"<?php if($data_peserta['agama'] == 'Budha'){ echo
                        'selected'; } ?>>Budha</option>
                    <option value="Kepercayaan lainnya" <?php if($data_peserta['agama'] ==
                        'Kepercayaan lainnya'){ echo 'selected'; } ?>>Kepercayaan lainnya</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Sekolah Asal</label>
            <div class="col-sm-10">
                <input type="text" name="sekolah_asal" class="form-control" value="<?php
                echo $data_peserta['sekolah_asal']; ?>" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">&nbsp;</label>
            <div class="col-sm-10">
                <input type="hidden" name="id_peserta" value="<?php echo $id_peserta; ?>">
                <input type="submit" name="btn_simpan" class="btn btn-primary" value=
                "Simpan">
                <a href="index.php" class="btn btn-success" role="button">Kembali</a>
            </div>
        </div>
        </form>
    </div>
<?php
}
// --- Fungsi update data peserta berhasil tambah data
function update_success(){
    echo'
        <div class="container" style="margin-top:20px">
            <h3>Data Calon Peserta Digital Telent</h3>
            <hr>
            <p> Update Data Peserta Berhasil </p>
        </div>';
}
// --- Fungsi Delete
function delete($koneksi){
    if(isset($_GET['id_peserta']) && isset($_GET['fungsi'])){
        $id_peserta = $_GET['id_peserta'];
        $sql_hapus = "DELETE FROM pendaftaran WHERE id_peserta=" . $id_peserta;
        $hapus = mysqli_query($koneksi, $sql_hapus);
        if($hapus){
            if($_GET['fungsi'] == 'delete'){
            header('location: index.php?fungsi=delete_success');
            }
        }
    }
}
// --- Fungsi delete data peserta berhasil tambah data
function delete_success(){
    echo'
    <div class="container" style="margin-top:20px">
        <h3>Data Calon Peserta Digital Telent</h3>
        <hr>
        <p> Delete Data Peserta Berhasil </p>
    </div>';
}
?>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity=
"sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin=
"anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity=
"sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin=
"anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity=
"sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin=
"anonymous"></script>
</body>
</html>
