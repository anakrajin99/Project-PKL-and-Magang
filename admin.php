<!-- panggil header -->
<?php include "header.php"; ?>

<?php

// uji jika tombol simpan diklik
if (isset($_POST['bsimpan'])) {
    $tgl = date('Y-m-d');

    $nama = htmlspecialchars($_POST['nama'], ENT_QUOTES);
    $alamat = htmlspecialchars($_POST['Alamat'], ENT_QUOTES);
    $tujuan = htmlspecialchars($_POST['Tujuan'], ENT_QUOTES);
    $nohp = htmlspecialchars($_POST['No.hp'], ENT_QUOTES);

    $simpan = mysqli_query($koneksi, " INSERT INTO dbbukutamu VALUES ('', '$tgl', '$nama', '$alamat', '$tujuan', '$nohp',)");

    if ($simpan) {
        echo "<script>alert('Simpan Data Sukses, Terima Kasih...!');
         document.location='?'</script>";
    } else {
        echo "<script>alert('Simpan Data Gagal!!!'); 
        document.location='?'</script>";
    }
}

?>

<!-- Head -->
<div class="head text-center">
    <img src="assets/img/logo stbnd.png" width="100">
    <h2 class="text-white">Sistem Informasi Buku Tamu <br>Dinas Komunikasi Dan Informatika Kabupaten Situbondo</h2>
</div>
<!-- end Head -->

<!-- awal row -->

<div class="row mt-2">
    <!-- col-lg-7 -->
    <div class="col-lg-7 mb-3">
        <div class="card shadow bg-gradient-light">
            <!-- card-body -->
            <div class="card-body">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Identitas Tamu</h1>
                </div>
                <form class="user" method="POST" action="">
                    <div class="form-group">
                        <input type="text" class="form-control form-cotroluser" name="nama" placeholder="Nama Tamu" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-cotroluser" name="Alamat" placeholder="Alamat Tamu" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-cotroluser" name="Tujuan" placeholder="Tujuan Tamu" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control form-cotroluser" name="No.HP" placeholder="NO.HP Tamu" required>
                    </div>

                    <button type="submit" name="bsimpan" class="btn btn-primary btn-user btn-block">Simpan Data</button>

                </form>
                <hr>
                <div class="text-center">
                    <a class="small" href="#"> copyright KOMINFO Pusat Data</a>
                </div>
                <div class="text-center">
                    <a class="big" href="#">By. Prodi Sistem Informasi | ~PKL22~ | 2022 -<?= date('Y') ?></a>
                </div>
            </div>
            <!-- end card-body -->
        </div>
    </div>
    <!-- end col-lg-7 -->

    <!-- col-lg-5 -->
    <div class="col-lg-5 mb-3">
        <!-- card -->
        <div class="card shadow ">
            <!-- card-body -->
            <div class="card-body">
                <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Statistik Tamu</h1>
                </div>
                <?php
                $tgl_sekarang = date('Y-m-d');
                $kemarin = date('Y-m-d', strtotime('-1 day', strtotime(date('Y-m-d'))));
                $seminggu = date('Y-m-d h:i:s', strtotime('-1 week +1 day', strtotime($tgl_sekarang)));
                $sekarang = date('Y-m-d h:i:s');

                $tgl_sekarang = mysqli_fetch_array(mysqli_query(
                    $koneksi,
                    "SELECT count(*) FROM ttamu where tanggal like '%$tgl_sekarang%'"
                ));

                $kemarin = mysqli_fetch_array(mysqli_query(
                    $koneksi,
                    "SELECT count(*) FROM ttamu where tanggal like '%$kemarin%'"
                ));

                $seminggu = mysqli_fetch_array(mysqli_query(
                    $koneksi,
                    "SELECT count(*) FROM ttamu where tanggal BETWEEN '$seminggu' and '$sekarang'"
                ));

                $bulan_ini = date('m');
                $sebulan = mysqli_fetch_array(mysqli_query(
                    $koneksi,
                    "SELECT count(*) FROM ttamu where month(tanggal) = '$bulan_ini'"
                ));

                $keseluruhan = mysqli_fetch_array(mysqli_query(
                    $koneksi,
                    "SELECT count(*) FROM ttamu "
                ));

                ?>
                <table class="table table-bordered">
                    <tr>
                        <td>Hari ini</td>
                        <td>: <?= $tgl_sekarang[0] ?></td>
                    </tr>
                    <tr>
                        <td>Kemarin</td>
                        <td>: <?= $kemarin[0] ?></td>
                    </tr>
                    <tr>
                        <td>Minggu ini</td>
                        <td>: <?= $seminggu[0] ?></td>
                    </tr>
                    <tr>
                        <td>Bulan ini</td>
                        <td>: <?= $sebulan[0] ?></td>
                    </tr>
                    <tr>
                        <td>Keseluruhan</td>
                        <td>: <?= $keseluruhan[0] ?></td>
                    </tr>
                </table>
            </div>
            <!-- end card-body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col-lg-5 -->


</div>
<!-- end row -->


<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Tamu hari ini [<?= date('d-m-Y') ?>]</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>N0.</th>
                        <th>Tanggal</th>
                        <th>Nama Tamu</th>
                        <th>Alamat</th>
                        <th>Tujuan</th>
                        <th>No.Hp</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>N0.</th>
                        <th>Tanggal</th>
                        <th>Nama Tamu</th>
                        <th>Alamat</th>
                        <th>Tujuan</th>
                        <th>No.Hp</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    $tgl = date('Y-m-d'); //2022-08-23
                    $tampil = mysqli_query($koneksi, "SELECT * FROM ttamu where tanggal like '%$tgl%' order by id desc");

                    $no = 1;

                    while ($data = mysqli_fetch_array($tampil)) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['tanggal'] ?></td>
                            <td><?= $data['nama'] ?></td>
                            <td><?= $data['alamat'] ?></td>
                            <td><?= $data['tujuan'] ?></td>
                            <td><?= $data['nohp'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- panggil footer -->
<?php include "footer.php"; ?>