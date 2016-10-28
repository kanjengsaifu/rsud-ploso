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
    <h1>Status Transaksi Pembelian</h1>
</div><!--pagetitle-->
<div class="maincontent">
    <div class="contentinner">
<?php if(isset($_GET['act'])){
    if($_GET['act']=="edit"){ ?>
        <!-- EDIT PRODUSEN -->
        <?php if(!empty($_GET['NoPembelian'])){
            $NoPembelian = $_GET['NoPembelian'];
            $qrypembeliantamup = "SELECT
pembelian.NoPembelian AS NoPembelian,
produsen.NamaProdusen AS NamaProdusen,
pembelian.TglPembelian AS TglPembelian,
pembelian.BatasTglTerima AS BatasTglTerima,
pembelian.TotalHrgPembelian AS TotalHrgPembelian,
pembelian.StatusPembelian AS StatusPembelian
FROM
pembelian
INNER JOIN produsen ON produsen.KodeProdusen = pembelian.KodeProdusen
WHERE
pembelian.NoPembelian = '$NoPembelian'";
            $rspembeliantamup = mysqli_query($mysqli, $qrypembeliantamup);
            $rwpembeliantamup = mysqli_fetch_array($rspembeliantamup);
            $NoPembelian = $rwpembeliantamup['NoPembelian'];
            $NamaProdusen = $rwpembeliantamup['NamaProdusen'];
            $TglPembelian = date("m/d/Y", strtotime($rwpembeliantamup['TglPembelian']));
            $BatasTglTerima = date("m/d/Y", strtotime($rwpembeliantamup['BatasTglTerima']));
            $TotalHrgPembelian = $rwpembeliantamup['TotalHrgPembelian'];
            $StatusPembelian = $rwpembeliantamup['StatusPembelian'];
        ?>
        <a href="media.php?module=statustranspembelian" class="btn btn-primary"><i class="iconsweets-arrowleft iconsweets-white"></i>  &nbsp; Kembali</a>
        <h4 class="widgettitle nomargin shadowed">Edit Status Transaksi Pembelian</h4>   
        <div class="widgetcontent bordered shadowed nopadding">
            <form id="form1" class="stdform stdform2" method="post" action="media.php?module=statustranspembelian&act=edit&NoPembelian=<?php echo $NoPembelian;?>">
                <input type="hidden" name="NoPembelian" value="<?php echo $NoPembelian; ?>" />
                <p class="control-group">
                    <label class="control-label" for="NoPembelian">No.Transaksi</label>
                    <span class="field controls"><?php echo $NoPembelian; ?></span>
                </p>
                <p class="control-group">
                    <label class="control-label" for="NamaProdusen">Produsen</label>
                    <span class="field controls"><?php echo $NamaProdusen; ?></span>
                </p>
                <p class="control-group">
                    <label class="control-label" for="TglPembelian">Tanggal Pembelian</label>
                    <span class="field controls"><?php echo $TglPembelian; ?> <small><em>bulan / tanggal / tahun</em></small></span>
                </p>
                <p class="control-group">
                    <label class="control-label" for="BatasTglTerima">Batas Tanggal Penerimaan</label>
                    <span class="field controls"><?php echo $BatasTglTerima; ?> <small><em>bulan / tanggal / tahun</em></small></span>
                </p>
                <p class="control-group">
                    <label class="control-label" for="TotalHrgPembelian">Total</label>
                    <span class="field controls">Rp. <?php echo $TotalHrgPembelian; ?></span>
                </p>
                <p class="control-group">
                    <label class="control-label" for="StatusPembelian">Status Pembelian</label>
                    <span class="field controls">
                        <input type="radio" name="StatusPembelian" value="B" <?php echo ($StatusPembelian=="B")?"checked":""; ?> /> belum diterima  &nbsp; &nbsp;
                        <input type="radio" name="StatusPembelian" value="L" <?php echo ($StatusPembelian=="L")?"checked":""; ?> /> diterima  &nbsp; &nbsp;
                        <input type="radio" name="StatusPembelian" value="T" <?php echo ($StatusPembelian=="T")?"checked":""; ?> /> ditolak
                    </span>
                </p>
                <p class="stdformbutton">
                    <button name="simpan" type="submit" class="btn btn-primary">Simpan</button>
                </p>
            </form>
        </div><!--widgetcontent-->
        
        <?php
            //Aksi Simpan
            if(isset($_POST['simpan'])){
                $HNoPembelian = $_POST['NoPembelian'];
                $StatusPembelian = $_POST['StatusPembelian'];
                $qry = "UPDATE pembelian SET StatusPembelian='$StatusPembelian' WHERE NoPembelian='$HNoPembelian'";
                $rs = mysqli_query($mysqli, $qry);
                //UPDATE STOK BARANG MASUK.barang
                    $rstampilbrg = mysqli_query($mysqli, "SELECT KodeBarang FROM barang");
                    while ($rwtampilbrg = mysqli_fetch_array($rstampilbrg)){
                        $KodeBarang = $rwtampilbrg['KodeBarang'];
                        $rsTotBrgMasuk = mysqli_query($mysqli, "SELECT
                            SUM(barangdibeli.JmlBrgDibeli) AS TotBrgMasuk
                            FROM
                            pembelian
                            INNER JOIN barangdibeli ON barangdibeli.NoPembelian = pembelian.NoPembelian
                            INNER JOIN barang ON barang.KodeBarang = barangdibeli.KodeBarang
                            WHERE barangdibeli.KodeBarang = '".$KodeBarang."' AND pembelian.StatusPembelian = 'L'");
                        $rwTotBrgMasuk = mysqli_fetch_array($rsTotBrgMasuk);
                        $TotBrgMasuk = $rwTotBrgMasuk['TotBrgMasuk'];
                        $updatebrgmskBarang = mysqli_query($mysqli, "UPDATE barang SET BarangMasuk = '".$TotBrgMasuk."' WHERE KodeBarang = '".$KodeBarang."'");
                    }
                //END UPDATE STOK BARANG MASUK.barang
                //UPDATE STOK Tersedia
                $qrytampilbrg = mysqli_query($mysqli, "SELECT KodeBarang, BarangMasuk, BarangKeluar FROM barang");
                while ($rstampilbrg = mysqli_fetch_array($qrytampilbrg)){
                    $KodeBarang = $rstampilbrg['KodeBarang'];
                    $BrgMasuk = $rstampilbrg['BarangMasuk'];
                    $BrgKeluar = $rstampilbrg['BarangKeluar'];
                    $StokTersedia = $BrgMasuk - $BrgKeluar;
                    $qryupstoktersediabrg = mysqli_query($mysqli, "UPDATE barang SET StokTersedia = '".$StokTersedia."' WHERE KodeBarang = '".$KodeBarang."'");
                }
                // END UPDATE STOK Tersedia
                if($rs){
                    echo "<script>window.location='media.php?module=statustranspembelian'</script>";
                }
            }
            //End aksi simpan
        ?>
        <?php
        }
        ?>
        <!-- EDIT PRODUSEN --> 
    <?php } ?>
<?php
}else{
?>
<!--TAMPIL DATA TRANSAKSI PEMBELIAN-->
        <h4 class="widgettitle">Daftar Data Status Transaksi Pembelian</h4>
        <table class="table table-bordered" id="dyntable">
            <colgroup>
                <col class="con0" style="align: center; width: 4%" />
                <col class="con1" />
                <col class="con0" />
                <col class="con1" />
                <col class="con0" />
                <col class="con1" />
                <col class="con0" />
                <col class="con1" />
            </colgroup>
            <thead>
                <tr>
                    <th class="head0 nosort"><input type="checkbox" class="checkall" /></th>
                    <th class="head0">No.Transaksi</th>
                    <th class="head1">Produsen</th>
                    <th class="head0">Tanggal Pembelian <small><em>(thn/bln/tgl)</em></small></th>
                    <th class="head1">Batas Tanggal Penerimaan <small><em>(thn/bln/tgl)</em></small></th>
                    <th class="head0">Total</th>
                    <th class="head1">Status</th>
                    <th class="head0">Edit Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $qry = "SELECT
pembelian.NoPembelian AS NoTransPem,
produsen.NamaProdusen AS Produsen,
pembelian.TglPembelian AS TglBeli,
pembelian.BatasTglTerima AS TglBatTerima,
pembelian.TotalHrgPembelian AS Total,
pembelian.StatusPembelian AS `Status`
FROM
pembelian
INNER JOIN produsen ON produsen.KodeProdusen = pembelian.KodeProdusen
";
                    $rs = mysqli_query($mysqli, $qry);
                    while ($rw = mysqli_fetch_array($rs)){
                        if($rw['Status']=="B"){
                            $status = "balum diterima";
                            $warna = "#f0ad4e";
                        }elseif ($rw['Status']=="L") {
                            $status = "diterima";
                            $warna = "none";
                        }elseif($rw['Status']=="T"){
                            $status = "ditolak";
                            $warna = "#d9534f";
                        }
                ?>
                <tr class="gradeC">
                    <td><span class="center"><input type="checkbox" /></span></td>
                    <td><?php echo $rw['NoTransPem']; ?></td>
                    <td><?php echo $rw['Produsen']; ?></td>
                    <td><?php echo $rw['TglBeli']; ?></td>
                    <td><?php echo $rw['TglBatTerima']; ?></td>
                    <td><?php echo "Rp. ".$rw['Total']; ?></td>
                    <td style="background-color: <?php echo $warna; ?>;"><?php echo $status; ?></td>
                    <td class="centeralign">
                        <a href="media.php?module=statustranspembelian&act=edit&NoPembelian=<?php echo $rw['NoTransPem']; ?>"><span class="icon-edit"></span></a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
<!--TAMPIL DATA TRANSAKSI PEMBELIAN-->
<?php
}
?>
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