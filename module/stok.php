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
                    <th class="head0">Bentuk Obat</th>
                    <th class="head1">Stok Minimum</th>
                    <th class="head0">Stok Tersedia</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $qry = mysqli_query($mysqli, "SELECT * FROM obat");
                while ($rs = mysqli_fetch_array($qry)){
                    $NamaObat = $rs['NamaObat'];
                    $BatchObat = $rs['BatchObat'];                    
                    $BentukObat = $rs['BentukObat'];
                    $StokMinimum = $rs['StokMinimum'];
                    $StokTersedia = $rs['StokTersedia'];
                    $warna = $StokTersedia<=$StokMinimum?"#f0ad4e":"";
                ?>
                <tr class="gradeC">
                    <td><span class="center"><input type="checkbox" /></span></td>
                    <td><?php echo $NamaObat; ?></td>
                    <td><?php echo $BatchObat; ?></td>
                    <td><?php echo $BentukObat; ?></td>
                    <td style="background-color: <?php echo $warna; ?>;"><?php echo $StokMinimum; ?></td>
                    <td style="background-color: <?php echo $warna; ?>;"><?php echo $StokTersedia; ?></td>
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