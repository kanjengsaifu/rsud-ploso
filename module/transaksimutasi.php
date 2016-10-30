<!--CEK LOGIN-->
<?php
session_start();
if(isset($_SESSION['NamaPengguna']) or isset($_SESSION['IdUser']) and isset($_SESSION['Sandi']) and isset($_SESSION['Level'])){
    require("_koneksi.php");
    $IdUser = $_SESSION['IdUser'];
    $Level = 3;
    $NamaPengguna = $_SESSION['NamaPengguna'];
    $Sandi = $_SESSION['Sandi'];
    $qry = "SELECT * FROM users WHERE IdUser = '$IdUser' OR NamaPengguna = '$NamaPengguna' AND Sandi = '$Sandi' AND IdLevel = '$Level'";
    $rs = mysqli_query($mysqli, $qry);
    $rw = mysqli_fetch_array($rs);
    if(( $IdUser == $rw['IdUser'] OR $NamaPengguna == $rw['NamaPengguna'] ) and $Sandi == $rw['Sandi'] and $Level == $rw['IdLevel']){
        // echo $Level;
        // echo $IdUser;
?>
<!--CEK LOGIN-->

<div class="pagetitle">
    <h1>Transaksi Mutasi</h1>
</div><!--pagetitle-->
<div class="maincontent">
    <div class="contentinner">
<?php if(isset($_GET['act'])){
    if($_GET['act']=="add"){ ?>
    <!-- TAMBAH TRANSAKSI PENJUALAN -->
        <?php
            function NoTransaksi($tabel, $inisial){
                require("_koneksi.php");
                $struktur = mysqli_query($mysqli, "SELECT * FROM $tabel");
                $finfo = mysqli_fetch_field_direct($struktur,0);
                $field = $finfo->name;
                $panjang = $finfo->length;//10

                $qry = mysqli_query($mysqli, "SELECT max(".$field.") FROM ".$tabel);
                $rowNoTransaksi = mysqli_fetch_array($qry);
                if ($rowNoTransaksi[0]=="") {
                    $angka=0;
                }else{
                    $angka = substr($rowNoTransaksi[0], strlen($inisial));
                }
                $angka++;
                $angka = strval($angka);
                $tmp  ="";
                for($i=1; $i<=($panjang-strlen($inisial)-strlen($angka)); $i++) {
                    $tmp=$tmp."0";
                }
                     return $inisial.$tmp.$angka;
            }
        ?>
        <?php
            function IdObatMutasi($tabel, $inisial){
                require("_koneksi.php");
                $struktur = mysqli_query($mysqli, "SELECT * FROM $tabel");
                $finfo = mysqli_fetch_field_direct($struktur,0);
                $field = $finfo->name;
                $panjang = $finfo->length;//10

                $qry = mysqli_query($mysqli, "SELECT max(".$field.") FROM ".$tabel);
                $rowIdBrgDijual = mysqli_fetch_array($qry);
                if ($rowIdBrgDijual[0]=="") {
                    $angka=0;
                }else{
                    $angka = substr($rowIdBrgDijual[0], strlen($inisial));
                }
                $angka++;
                $angka = strval($angka);
                $tmp  ="";
                for($i=1; $i<=($panjang-strlen($inisial)-strlen($angka)); $i++) {
                    $tmp=$tmp."0";
                }
                     return $inisial.$tmp.$angka;
            }
        ?>
        <a href="media.php?module=transaksimutasi" class="btn btn-primary"><i class="iconsweets-arrowleft iconsweets-white"></i>  &nbsp; Kembali</a>
        <h4 class="widgettitle nomargin shadowed">Menambahkan Obat Pada Transaksi Mutasi </h4>
        <div class="widgetcontent bordered shadowed nopadding">
            <form id="form1" class="stdform stdform2" method="POST" action="media.php?module=transaksimutasi&act=add">
                <?php 
                $IdObatMutasi = IdObatMutasi("obatmutasi", "OBTMSI");
                $NoTransaksi = NoTransaksi("transaksimutasi", "TRNMSI");
                ?>
                <input type="hidden" name="IdObatMutasi" value="<?php echo $IdObatMutasi; ?>" />
                <input type="hidden" name="NoTransaksi" value="<?php echo $NoTransaksi; ?>" />
                
                
                <?php
                //UPDATE BarangKeluar.Tbarang
                            $qrytmplobt = mysqli_query($mysqli, "SELECT BatchObat FROM obat");
                            while ($rwqrytmlpobt = mysqli_fetch_array($qrytmplobt)){
                                $TBatchObat = $rwqrytmlpobt['BatchObat'];
                                $qryjmlobtmsi = mysqli_query($mysqli, "SELECT
                                        SUM(obatmutasi.JmlObatMutasi) AS TotJmlObatMutasi
                                        FROM
                                        obat
                                        INNER JOIN obatmutasi ON obat.BatchObat = obatmutasi.BatchObat
                                        WHERE obatmutasi.BatchObat = '".$TBatchObat."'");
                                $rwqryjmlobtmsi = mysqli_fetch_array($qryjmlobtmsi);
                                $TotJmlObatMutasi = $rwqryjmlobtmsi['TotJmlObatMutasi'];
                                $updateobtklObat = mysqli_query($mysqli, "UPDATE obat SET ObatKeluar = '".$TotJmlObatMutasi."' WHERE BatchObat = '".$TBatchObat."'");
                            }
                            //END UPDATE BarangKeluar.Tbarang
                            //UPDATE STOK Tersedia
                $qrytampilobt = mysqli_query($mysqli, "SELECT BatchObat, ObatMasuk, ObatKeluar FROM obat");
                while ($rstampilobt = mysqli_fetch_array($qrytampilobt)){
                    $BatchObat = $rstampilobt['BatchObat'];
                    $ObatMasuk = $rstampilobt['ObatMasuk'];
                    $ObatKeluar = $rstampilobt['ObatKeluar'];
                    $StokTersedia = $ObatMasuk - $ObatKeluar;
                    $qryupstoktersediaobt = mysqli_query($mysqli, "UPDATE obat SET StokTersedia = '".$StokTersedia."' WHERE BatchObat = '".$BatchObat."'");
                }
                // END UPDATE STOK Tersedia
                ?>
                
                <table class="table table-bordered">
                    <colgroup>
                        <col class="con0" style="align: center; width: 510px" />
                        <col class="con1" style="align: center; width: 200px" />
                        <col class="con0" style="align: center; width: 200px" />
                        <col class="con1" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="head0">Obat</th>
                            <th class="head1">Jumlah Obat Yang Mutasi</th>
                            
                            <th class="head1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select data-placeholder="Cari Nama Obat" class="chzn-select" style="width:550px" tabindex="2" name="BatchObat">
                                    <option value=""></option>
                                    <?php
                                    $qryobat = mysqli_query($mysqli, "SELECT * FROM obat");
                                    while($rwobat=mysqli_fetch_array($qryobat))
                                    {
                                    ?>
                                        <option value="<?php echo $rwobat['BatchObat']; ?>"><?php echo $rwobat['NamaObat'];?> Batch <?php echo $rwobat['BatchObat'];?>  Stok <?php echo $rwobat['StokTersedia']==0?"habis":"$rwobat[StokTersedia]"; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </td>
                            <td><input type="text" name="JmlObatMutasi" id="JmlObatMutasi" class="input-medium" value="1"/></td>
                            
                            <td class="center"><button name="tambahkan" type="submit" class="btn btn-primary">Tambahkan</button></td>
                        </tr>
                    </tbody>
                </table>
            </form>
            
            <!-- AKSI TAMBAH BRG -->
            <?php
            //ADD BARANG DIJUAL KE TRANSAKSI
                    if(isset($_POST['tambahkan'])){
                        $BatchObat = $_POST['BatchObat'];
                        $JmlObatMutasi = $_POST['JmlObatMutasi'];
                        $qrytampilobat = mysqli_query($mysqli, "SELECT NamaObat, StokTersedia FROM obat WHERE BatchObat = '".$BatchObat."'");
                        $rstampilobat = mysqli_fetch_array($qrytampilobat);
                        $NamaObat = $rstampilobat['NamaObat'];
                        $StokTersedia = $rstampilobat['StokTersedia'];
                        if($JmlObatMutasi <= $StokTersedia){
                            $IdObatMutasi = $_POST['IdObatMutasi'];
                            $NoTrasaksi = $_POST['NoTrasaksi'];
                            //$DiskonBrgDijual = $_POST['DiskonBrgDijual'];
                            $qryobat = mysqli_query($mysqli, "SELECT HrgJual FROM obat WHERE BatchObat = '$BatchObat'");
                            $rsobt = mysqli_fetch_array($qryobat);
                            $HrgObt = $rsobt['HrgJual'];
                            $TotHrgObtMts = $JmlObatMutasi * $HrgObt;
                            $qryobatmutasi = "INSERT INTO obatmutasi(IdObatMutasi, NoTransaksi, BatchObat, JmlObatMutasi, ObatMutasiMasuk,StokObatMutasi,TotHrgObtMts) VALUES ('$IdObatMutasi','$NoTransaksi','$BatchObat','$JmlObatMutasi','$JmlObatMutasi','$JmlObatMutasi','$TotHrgObtMts')";
                            $rsobatmutasi = mysqli_query($mysqli, $qryobatmutasi);
                            if($rsobatmutasi){
                                echo "<script>window.location='media.php?module=transaksimutasi&act=add'</script>";
                            }
                        }else{
                            echo("<script>alert('Jumlah stok tersedia $NamaObat tidak mencukupi. Lihat Stok Terkini!')</script>");
                            echo "<script>window.location='media.php?module=transaksimutasi&act=add'</script>";
                        }   
                    }//end tambahkan
                    //ADD BARANG DIJUAL KE TRANSAKSI
                    //Hapus Barang pada transaksi
                    if(isset($_GET['obatmutasidel']) AND !empty($_GET['IdObatMutasi'])){
                        $IdObatMutasi = $_GET['IdObatMutasi'];
                        $qsjmlobtmsi = mysqli_query($mysqli, "SELECT BatchObat, JmlObatMutasi from obatmutasi WHERE IdObatMutasi = '$IdObatMutasi'");
                        $rwqsjmlobtmsi = mysqli_fetch_array($qsjmlobtmsi);
                        $JmlObatMutasi = $rwqsjmlobtmsi['JmlObatMutasi'];
                        $BatchObat = $rwqsjmlobtmsi['BatchObat'];
                        $qsobat = mysqli_query($mysqli, "SELECT ObatKeluar, StokTersedia from obat WHERE BatchObat = '$BatchObat'");
                        $rwobat = mysqli_fetch_array($qsobat);
                        $ObatKeluar = $rwobat['ObatKeluar'];
                        $StokTersedia = $rwobat['StokTersedia'];
                        $UpObatKeluar = $ObatKeluar - $JmlObatMutasi;
                        $UpStokTersedia = $StokTersedia + $JmlObatMutasi;
                        $quobat = mysqli_query($mysqli, "UPDATE obat SET ObatKeluar='$UpObatKeluar', StokTersedia='$UpStokTersedia' WHERE BatchObat = '$BatchObat'");
                        $qryobtmutdel = mysqli_query($mysqli, "DELETE FROM obatmutasi WHERE IdObatMutasi = '".$IdObatMutasi."'");
                        if($qryobtmutdel){
                            echo "<script>window.location='media.php?module=transaksimutasi&act=add'</script>";
                        }
                    }
                    ?>
            <!-- END AKSI TAMBAH BRG -->
            
        </div>
        <h4 class="widgettitle nomargin shadowed">Transaksi Mutasi Obat</h4>   
        <div class="widgetcontent bordered shadowed nopadding">
            <form id="form1" class="stdform stdform2" method="post" action="media.php?module=transaksimutasi&act=add">
                <p class="control-group">
                    <label class="control-label" for="NoTransaksi">No.Transaksi</label>
                    <span class="field controls"><input type="text" name="NoTransaksi" id="NoTransaksi" class="input-xxlarge" value="<?php echo $NoTransaksi; ?>" readonly /></span>
                </p>
                <p class="control-group">
                    <label class="control-label" for="NamaKonsumen">Nama Unit</label>
                    <span class="field controls">
                        <select name="KdUnit" data-placeholder="Cari Unit Mutasi" style="width:350px" class="chzn-select" tabindex="2">
                            <option value=""></option>
                            <?php
                            $qryunit = "SELECT * FROM unitmutasi where IdLevel = '$Level'";
                            $rsunit = mysqli_query($mysqli, $qryunit);
                            while ($rwunit = mysqli_fetch_array($rsunit)){
                            ?>
                            <option value="<?php echo $rwunit['KdUnit'];?>"><?php echo $rwunit['NamaUnit']; ?></option>
                            <?php } ?>
                        </select>
                    </span>
                </p>
                <p class="control-group">
                    <label class="control-label" for="TglMutasi">Tanggal Mutasi</label>
                    <span class="field controls"><input id="datepicker" type="text" name="TglMutasi" class="input-small" /> &nbsp; <small><em>bulan / tanggal / tahun</em></small></span>                 
                </p>
                <table class="table table-bordered">
                    <colgroup>
                        <col class="con0" style="align: center; width: 4%" />
                        <col class="con1" style="align: center; width: 300px" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" style="align: center; width: 8%" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="head0 center">No.</th>
                            <th class="head0">Obat</th>
                            <th class="head1">Jumlah</th>
                             <th class="head0">Harga</th>
                            <!-- <th class="head1">Diskon</th> -->
                            <th class="head1">Sub Total</th>
                            <th class="head0"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            
                            $qryobtmsi = "SELECT
obat.NamaObat AS Obat,
obatmutasi.JmlObatMutasi AS JumlahObat,
obat.HrgJual AS Harga,
obatmutasi.IdObatMutasi AS IdObatMutasi,
obatmutasi.TotHrgObtMts AS TotalHrgItem
FROM
obatmutasi
INNER JOIN obat ON obat.BatchObat = obatmutasi.BatchObat
WHERE
obatmutasi.NoTransaksi = '$NoTransaksi'";
                            $rsobtmsi = mysqli_query($mysqli, $qryobtmsi);
                            $no = 1;
                            while ($rwobtmsi = mysqli_fetch_array($rsobtmsi)){
                        ?>
                        <tr>
                            <td class="center"><?php echo $no; ?></td>
                            <td><?php echo $rwobtmsi['Obat'];?></td>
                            <td><?php echo $rwobtmsi['JumlahObat'];?></td>
                            <td><?php echo "Rp. ".$rwobtmsi['Harga'];?></td>                            
                            <td><?php echo "Rp. ".$rwobtmsi['TotalHrgItem'];?></td>
                            <td class="center"><a href="media.php?module=transaksimutasi&act=add&obatmutasidel=1&IdObatMutasi=<?php echo $rwobtmsi['IdObatMutasi']; ?>" class="btn btn-danger"><i class="iconsweets-trashcan iconsweets-white"></i></a></td>
                        </tr>
                            <?php 
                            $no++;
                            } ?>
                        <tr>
                            <td class="center" colspan="4"><b>Total</b></td>
                            <?php
                            $qrytotalpenjualan = mysqli_query($mysqli, "SELECT SUM(TotHrgObtMts) AS Total FROM obatmutasi WHERE NoTransaksi='$NoTransaksi'");
                            $rstotal =  mysqli_fetch_array($qrytotalpenjualan);
                            ?>
                            <td colspan="2"><span class="input-prepend input-append"><span class="add-on">Rp. </span><input type="text" name="TotHrgMts" id="TotHrgMts" class="input-medium" value="<?php echo $rstotal['Total'] ; ?>" readonly /></span></td>
                            
                        </tr>
                    </tbody>
                </table>
                <p class="stdformbutton">
                    <button name="simpan" type="submit" class="btn btn-success">Simpan & Cetak Tanda Bukti</button>                  
                    <button type="reset" class="btn btn-warning">Batal</button>
                </p>
            </form>
        </div><!--widgetcontent-->
                    
                    <?php
                    //Aksi Simpan
                    if(isset($_POST['simpan'])){
                        date_default_timezone_set('Asia/Jakarta');
                        $NoTransaksi = $_POST['NoTransaksi'];
                        $KdUnit = $_POST['KdUnit'];
                        $TglMutasi = date("Y-m-d", strtotime($_POST['TglMutasi']));
                        $DatetimeTransaksi = date("Y-m-d")." ".date("H:i:s");
                        // $BatasTglPengiriman = date("Y-m-d", strtotime($_POST['BatasTglPengiriman']));
                        $TotHrgMts = $_POST['TotHrgMts'];
                        $qry = "INSERT INTO transaksimutasi(NoTransaksi, KdUnit, TglMutasi,TotHrgMutasi, DatetimeTransaksi,IdUser) VALUES ('$NoTransaksi','$KdUnit','$TglMutasi','$TotHrgMts','$DatetimeTransaksi','$Level')";
                        $rs = mysqli_query($mysqli, $qry);
                        if($rs){

                            echo "<script>window.location='media.php?module=transaksimutasi'</script>";
                        }
                    }
                    //End aksi simpan
                    ?>
    
    <?php }elseif ($_GET['act']=="del") {
    ?>
        <!-- DELETE PENJUALAN Dan RElasinya -->
        <?php
        //Aksi Hapus
            $NoPenjualan = $_GET['NoPenjualan'];
            $qrydelpenjualan = mysqli_query($mysqli, "DELETE FROM penjualan WHERE sha1(NoPenjualan) = '".$NoPenjualan."'");
            $qrydelbarangdijual = mysqli_query($mysqli, "DELETE FROM barangdijual WHERE sha1(NoPenjualan) = '".$NoPenjualan."'");
            if($qrydelpenjualan and $qrydelbarangdijual){
                echo "<script>window.location='media.php?module=transpenjualan'</script>";
            }
        //End Aksi Hapus
        ?>
        <!-- DELETE Penjualan -->
    <?php
    }elseif ($_GET['act']=="edit") {
    ?>
        
    <?php } ?>
<?php
}else{
?>
<!--TAMPIL DATA TRANSAKSI PENJUALAN-->
        <a href="media.php?module=transaksimutasi&act=add" class="btn btn-primary"><i class="icon-plus-sign icon-white"></i>  &nbsp; Tambah transaksi mutasi</a>
        <h4 class="widgettitle">Daftar Data Transaksi Mutasi Obat </h4>
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
                    <th class="head1">Unit Mutasi</th>
                    <th class="head0">Tanggal Mutasi <small><em>(thn/bln/tgl)</em></small></th>
                    <th class="head1">Obat Mutasi</th>
                    <th class="head0">Batch Obat</th>
                    <th class="head1">Jumlah Obat Mutasi</th>
                    <th class="head0"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $qry = "SELECT
transaksimutasi.NoTransaksi AS NoTrans,
unitmutasi.NamaUnit AS Unit,
transaksimutasi.TglMutasi AS TglMut,
obat.NamaObat AS Obat,
obatmutasi.BatchObat AS Batch,
obatmutasi.JmlObatMutasi AS Jumlah
FROM
transaksimutasi
INNER JOIN unitmutasi ON transaksimutasi.KdUnit = unitmutasi.KdUnit
INNER JOIN obatmutasi ON transaksimutasi.NoTransaksi = obatmutasi.NoTransaksi
INNER JOIN obat ON obatmutasi.BatchObat = obat.BatchObat  WHERE transaksimutasi.IdUser = '$Level' order by transaksimutasi.NoTransaksi DESC
";
                    $rs = mysqli_query($mysqli, $qry);
                    while ($rw = mysqli_fetch_array($rs)){
                        // if($rw['Statuspen']=="B"){
                        //     $statuspen = "balum diterima";
                        //     $warna = "#f0ad4e";
                        // }elseif ($rw['Statuspen']=="L") {
                        //     $statuspen = "diterima";
                        //     $warna = "none";
                        // }elseif($rw['Statuspen']=="T"){
                        //     $statuspen = "ditolak";
                        //     $warna = "#d9534f";
                        // }
                ?>
                <tr class="gradeC">
                    <td><span class="center"><input type="checkbox" /></span></td>
                    <td><?php echo $rw['NoTrans']; ?></td>
                    <td><?php echo $rw['Unit']; ?></td>
                    <td><?php echo $rw['TglMut']; ?></td>
                    <td><?php echo $rw['Obat']; ?></td>
                    <td><?php echo $rw['Batch']; ?></td>
                    <td><?php echo $rw['Jumlah']; ?></td>
                    
                    <!-- <td style="background-color: <?php echo $warna; ?>;"><?php echo $statuspen; ?></td> -->
                    <td class="centeralign">
                        <a href="media.php?module=transaksimutasi&act=del&NoTransaksi=<?php echo sha1($rw['NoTrans']); ?>"><span class="icon-trash"></span></a>
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