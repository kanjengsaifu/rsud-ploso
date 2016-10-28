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
<div class="pagetitle">
    <h1>Beranda</h1>
</div><!--pagetitle-->

<div class="maincontent">
    <div class="contentinner content-dashboard content-typography">
        
        <!-- UPDATE STOK -->
        <?php
                //UPDATE BarangKeluar.Tbarang
                            $qrytmplobt = mysqli_query($mysqli, "SELECT BatchObat FROM Obat");
                            while ($rwqrytmplobt = mysqli_fetch_array($qrytmplobt)){
                                $TBatchObat = $rwqrytmplobt['BatchObat'];
                                $qryjmlobtmut = mysqli_query($mysqli, "SELECT
                                        SUM(obatmutasi.JmlObatMutasi) AS TotJmlObtMutasi
                                        FROM
                                        obat
                                        INNER JOIN obatmutasi ON obat.BatchObat = obatmutasi.BatchObat
                                        WHERE obatmutasi.BatchObat = '".$TBatchObat."'");
                                $rwqryjmlobtmut = mysqli_fetch_array($qryjmlobtmut);
                                $TotJmlObtMutasi = $rwqryjmlobtmut['TotJmlObtMutasi'];
                                $upobtkeluar = mysqli_query($mysqli, "UPDATE obat SET ObatKeluar = '".$TotJmlObtMutasi."' WHERE BatchObat = '".$TBatchObat."'");
                            }
                            //END UPDATE BarangKeluar.Tbarang
                            //UPDATE STOK Tersedia
                $qrytampilobt = mysqli_query($mysqli, "SELECT BatchObat, ObatMasuk, ObatKeluar FROM obat");
                while ($rstampilobt = mysqli_fetch_array($qrytampilobt)){
                    $BatchObat = $rstampilobt['BatchObat'];
                    $ObatMasuk = $rstampilobt['ObatMasuk'];
                    $ObatKeluar = $rstampilobt['ObatKeluar'];
                    $StokTersedia = $ObatMasuk - $ObatKeluar;
                    $qryupstokobat = mysqli_query($mysqli, "UPDATE obat SET StokTersedia = '".$StokTersedia."' WHERE BatchObat = '".$BatchObat."'");
                }
                // END UPDATE STOK Tersedia
                ?>
        <!-- END UPDATE STOK -->
        
        <!-- ALERT -->
        <?php
        $qryalertobat = mysqli_query($mysqli, "SELECT * FROM obat");
        while ($rstampilalert = mysqli_fetch_array($qryalertobat)){
            $BatchObat = $rstampilalert['BatchObat'];
            $NamaObat = $rstampilalert['NamaObat'];
            $StokMinimum = $rstampilalert['StokMinimum'];
            $StokTersedia = $rstampilalert['StokTersedia'];
            if($StokTersedia <= $StokMinimum){
                ?>
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Peringatan!</strong> Transaksi pembelian untuk obat <?php echo $NamaObat; ?> dengan kode Batch <?php echo $BatchObat; ?>  dibutuhkan. Stok <?php echo $NamaObat; ?> dibawah stok minimum persediaan. Lihat menu Stok Terkini!
                </div>
                <?php
            }
        }
        ?>
        <!-- END ALERT -->
        <div class="row-fluid">
            <div class="span12">
                    <h4 class="widgettitle nomargin shadowed">Selamat Datang</h4>
                        <div class="widgetcontent bordered shadowed">
                            <h2>Aplikasi Inventori Obat</h2>
                            <p>Aplikasi ini berfungsi untuk membantu Kepala Gudang dalam mengelola inventaris obat-obatan. Fungsi-fungsi aplikasi ini diantaranya : </p>
                            <ul class="list-nostyle">
                                      <li><span class="icon-chevron-right"></span> Mengelola data obat dan unit mutasi.</li>
                                      <li><span class="icon-chevron-right"></span> Mengelola Transaksi mutasi obat.</li>
                                      <li><span class="icon-chevron-right"></span> Mengelola persediaan stok obat.</li>
                                      <!--<li><span class="icon-chevron-right"></span> Mengelola laporan keuangan.</li>-->
                                    </ul>
                        </div>
            </div><!--span12-->
        </div><!--row-fluid-->
    </div><!--contentinner-->
</div><!--maincontent-->
<?php
    }else{
        header("location:logout.php");
    }
}else{
    header("location:logout.php");
}
?>