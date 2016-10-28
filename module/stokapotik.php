<!--CEK LOGIN-->
<?php
if(isset($_SESSION['NamaPengguna']) and isset($_SESSION['Sandi'])){
    require("_koneksi.php");
    $NamaPengguna = $_SESSION['NamaPengguna'];
    $Sandi = $_SESSION['Sandi'];
    $qry = "SELECT * FROM users WHERE NamaPengguna = '$NamaPengguna' AND Sandi = '$Sandi'";
    $rs = mysqli_query($mysqli, $qry);
    $rw = mysqli_fetch_array($rs);
    if($NamaPengguna == $rw['NamaPengguna'] and $Sandi == $rw['Sandi']){
?>
<!--CEK LOGIN-->

<div class="pagetitle">
    <h1>Stok Terkini</h1>
</div><!--pagetitle-->
<div class="maincontent">
    <div class="contentinner">
       
        <h4 class="widgettitle">Daftar Data Stok Obat Terkini</h4>
        <table class="table table-bordered" id="dyntable">
            <colgroup>
                <col class="con0" style="align: center; width: 4%" />
                <col class="con1" />
                <col class="con0" />
                <col class="con1" />
                <col class="con0" />
            </colgroup>
            <thead>
                <tr>
                    <th class="head0 nosort"><input type="checkbox" class="checkall" /></th>
                    <th class="head0">Nama Obat</th>
                    <th class="head1">Batch Obat</th>
                    <th class="head1">Expired Date</th>
                    <th class="head0">Bentuk Obat</th>
                    <th class="head1">Jumlah Obat Masuk</th>
                    <th class="head1">Jumlah Obat Keluar</th>
                    <th class="head0">Stok Tersedia</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $qry = mysqli_query($mysqli, "SELECT obatmutasi.*, obat.*, transaksimutasi.KdUnit FROM obatmutasi INNER JOIN obat ON obatmutasi.BatchObat = obat.BatchObat INNER JOIN transaksimutasi ON obatmutasi.NoTransaksi = transaksimutasi.NoTransaksi WHERE transaksimutasi.KdUnit = 'UNIT01'");
                while ($rs = mysqli_fetch_array($qry)){
                    $NamaObat = $rs['NamaObat'];
                    $BatchObat = $rs['BatchObat']; 
                    $Ed = $rs['ExpiredDate'];                    
                    $BentukObat = $rs['BentukObat'];
                    $Jumlah = $rs['JmlObatMutasi'];
                    $ObatMutasiKeluar = $rs['ObatMutasiKeluar'];
                    $StokTersedia = $rs['StokObatMutasi'];
                    //$warna = $StokTersedia<=$StokMinimum?"#f0ad4e":"";
                ?>
                <tr class="gradeC">
                    <td><span class="center"><input type="checkbox" /></span></td>
                    <td><?php echo $NamaObat; ?></td>
                    <td><?php echo $BatchObat; ?></td>
                    <td><?php echo $Ed; ?></td>
                    <td><?php echo $BentukObat; ?></td>
                    <td><?php echo $Jumlah; ?></td>
                    <td ><?php echo $ObatMutasiKeluar; ?></td>
                    <td ><?php echo $StokTersedia; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
<!--TAMPIL DATA TRANSAKSI PEMBELIAN-->
    </div><!--contentinner-->
</div><!--maincontent-->
<!--CEK LOGIN-->
<?php
    }else{
        header("location:logout.php");
    }
}else{
    header("location:logout.php");
}
?>
<!--CEK LOGIN-->