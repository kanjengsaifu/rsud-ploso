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
    <h1>Transaksi Pembelian</h1>
</div><!--pagetitle-->
<div class="maincontent">
    <div class="contentinner">
<?php if(isset($_GET['act'])){
    if($_GET['act']=="add"){ ?>
    <!-- TAMBAH TRANSAKSI PEMBELIAN -->
        <?php
            function NoPembelian($tabel, $inisial){
                require("_koneksi.php");
                $struktur = mysqli_query($mysqli, "SELECT * FROM $tabel");
                $finfo = mysqli_fetch_field_direct($struktur,0);
                $field = $finfo->name;
                $panjang = $finfo->length;//10

                $qry = mysqli_query($mysqli, "SELECT max(".$field.") FROM ".$tabel);
                $rowNoPembelian = mysqli_fetch_array($qry);
                if ($rowNoPembelian[0]=="") {
                    $angka=0;
                }else{
                    $angka = substr($rowNoPembelian[0], strlen($inisial));
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
            function IdBrgDibeli($tabel, $inisial){
                require("_koneksi.php");
                $struktur = mysqli_query($mysqli, "SELECT * FROM $tabel");
                $finfo = mysqli_fetch_field_direct($struktur,0);
                $field = $finfo->name;
                $panjang = $finfo->length;//10

                $qry = mysqli_query($mysqli, "SELECT max(".$field.") FROM ".$tabel);
                $rowIdBrgDibeli = mysqli_fetch_array($qry);
                if ($rowIdBrgDibeli[0]=="") {
                    $angka=0;
                }else{
                    $angka = substr($rowIdBrgDibeli[0], strlen($inisial));
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
        <a href="media.php?module=transpembelian" class="btn btn-primary"><i class="iconsweets-arrowleft iconsweets-white"></i>  &nbsp; Kembali</a>
        <h4 class="widgettitle nomargin shadowed">Menambahkan Barang Pada Transaksi Pembelian</h4>
        <div class="widgetcontent bordered shadowed nopadding">
            <form id="form1" class="stdform stdform2" method="POST" action="media.php?module=transpembelian&act=add">
                <input type="hidden" name="IdBarangDibeli" value="<?php echo IdBrgDibeli("barangdibeli","BRDB"); ?>" />
                <input type="hidden" name="NoPembelian" value="<?php echo NoPembelian("pembelian","TRNSB"); ?>" />
                <table class="table table-bordered">
                    <colgroup>
                        <col class="con0" style="align: center; width: 510px" />
                        <col class="con1" style="align: center; width: 200px" />
                        <col class="con0" style="align: center; width: 200px" />
                        <col class="con1" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="head0">Barang yang dibeli</th>
                            <th class="head1">Jumlah</th>
                            <th class="head1">Diskon</th>
                            <th class="head1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="KodeBarang" data-placeholder="Cari Nama Barang" style="width:500px" class="chzn-select" tabindex="2">
                                    <option value=""></option>
                                    <?php
                                    $qrybarang = mysqli_query($mysqli, "SELECT * FROM barang");
                                    while($rwbarang=mysqli_fetch_array($qrybarang))
                                    {
                                    echo ("<OPTION VALUE=\"$rwbarang[KodeBarang]\">$rwbarang[NamaBarang] (harga Rp. $rwbarang[HrgBeli])</option>");
                                    }
                                    ?>
                                </select>
                            </td>
                            <td><input type="text" name="JmlBrgDibeli" id="JmlBrgDibeli" class="input-medium" value="1"/></td>
                            <td><span class="input-prepend input-append"><span class="add-on">Rp. </span><input type="text" name="DiskonBrgDibeli" id="DiskonBrgDibeli" class="input-medium" value="0" /></span></td>
                            <td class="center"><button name="tambahkan" type="submit" class="btn btn-primary">Tambahkan</button></td>
                        </tr>
                    </tbody>
                </table>
            </form>
            
            <!-- AKSI TAMBAH BRG -->
            <?php
                    if(isset($_POST['tambahkan'])){
                        $IdBarangDibeli = $_POST['IdBarangDibeli'];
                        $NoPembelian = $_POST['NoPembelian'];
                        $KodeBarang = $_POST['KodeBarang'];
                        $JmlBrgDibeli = $_POST['JmlBrgDibeli'];
                        $DiskonBrgDibeli = $_POST['DiskonBrgDibeli'];
                        $qrybarang = mysqli_query($mysqli, "SELECT HrgBeli FROM barang WHERE KodeBarang = '$KodeBarang'");
                        $rsbrg = mysqli_fetch_array($qrybarang);
                        $HrgBrg = $rsbrg['HrgBeli'];
                        $TotHrgBrgDibeli = ($JmlBrgDibeli * $HrgBrg) - $DiskonBrgDibeli;
                        $qrybrgdbl = "INSERT INTO barangdibeli(IdBarangDibeli, NoPembelian, KodeBarang, JmlBrgDibeli, DiskonBrgDibeli, TotHrgBrgDibeli) VALUES ('$IdBarangDibeli','$NoPembelian','$KodeBarang','$JmlBrgDibeli','$DiskonBrgDibeli','$TotHrgBrgDibeli')";
                        $rsbrgdbl = mysqli_query($mysqli, $qrybrgdbl);
                        if($rsbrgdbl){
                            echo "<script>window.location='media.php?module=transpembelian&act=add'</script>";
                        }
                    }
                    if(isset($_GET['barangdibelidel']) AND !empty($_GET['IdBarangDibeli'])){
                        $IdBarangDibelidel = $_GET['IdBarangDibeli'];
                        $qrybrgdibelidel = mysqli_query($mysqli, "DELETE FROM barangdibeli WHERE IdBarangDibeli = '".$IdBarangDibelidel."'");
                        if($qrybrgdibelidel){
                            echo "<script>window.location='media.php?module=transpembelian&act=add'</script>";
                        }
                    }
                    ?>
            <!-- END AKSI TAMBAH BRG -->
            
        </div>
        <h4 class="widgettitle nomargin shadowed">Transaksi Pembelian</h4>   
        <div class="widgetcontent bordered shadowed nopadding">
            <form id="form1" class="stdform stdform2" method="post" action="media.php?module=transpembelian&act=add">
                <?php
                    $NoPembelian = NoPembelian("pembelian","TRNSB");
                ?>
                <p class="control-group">
                    <label class="control-label" for="NoPembelian">No.Transaksi</label>
                    <span class="field controls"><input type="text" name="NoPembelian" id="NoPembelian" class="input-xxlarge" value="<?php echo $NoPembelian ; ?>" readonly /></span>
                </p>
				<p class="control-group">
                    <label class="control-label" for="FakturPembelian">Faktur Pembelian</label>
                    <span class="field controls"><input type="text" name="FakturPembelian" id="FakturPembelian" class="input-xxlarge"  /></span>
                </p>
                <p class="control-group">
                    <label class="control-label" for="NamaProdusen">Nama Produsen</label>
                    <span class="field controls">
                        <select name="KodeProdusen" data-placeholder="Cari Nama Produsen" style="width:350px" class="chzn-select" tabindex="2">
                            <option value=""></option>
                            <?php
                            $qryprodusen = "SELECT * FROM produsen";
                            $rsprodusen = mysqli_query($mysqli, $qryprodusen);
                            while ($rwprodusen = mysqli_fetch_array($rsprodusen)){
                            ?>
                            <option value="<?php echo $rwprodusen['KodeProdusen'];?>"><?php echo $rwprodusen['NamaProdusen']; ?></option>
                            <?php } ?>
                        </select>
                    </span>
                </p>
                <p class="control-group">
                    <label class="control-label" for="TglPembelian">Tanggal Pembelian</label>
                    <span class="field controls"><input id="datepicker" type="date" name="TglPembelian" class="input-large" /> &nbsp; <small><em>bulan / tanggal / tahun</em></small></span>
                </p>
                <p class="control-group">
                    <label class="control-label" for="BatasTglTerima">Batas Tanggal Penerimaan</label>
                    <span class="field controls"><input id="datepicker1" type="date" name="BatasTglTerima" class="input-large" /> &nbsp; <small><em>bulan / tanggal / tahun</em></small></span>
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
                            <th class="head0">Barang</th>
                            <th class="head1">Jumlah</th>
                            <th class="head0">Harga</th>
                            <th class="head1">Diskon</th>
                            <th class="head0">Sub Total</th>
                            <th class="head1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            
                            $qrybdbl = "SELECT
barang.NamaBarang AS Barang,
barangdibeli.JmlBrgDibeli AS Jumlah,
barang.HrgBeli AS Harga,
barangdibeli.IdBarangDibeli,
barangdibeli.DiskonBrgDibeli AS Diskon,
barangdibeli.TotHrgBrgDibeli AS TotalHrgItem
FROM
barangdibeli
INNER JOIN barang ON barang.KodeBarang = barangdibeli.KodeBarang
WHERE
barangdibeli.NoPembelian = '$NoPembelian'";
                            $rsbdbl = mysqli_query($mysqli, $qrybdbl);
                            $no = 1;
                            while ($rwbdbl = mysqli_fetch_array($rsbdbl)){
                        ?>
                        <tr>
                            <td class="center"><?php echo $no; ?></td>
                            <td><?php echo $rwbdbl['Barang'];?></td>
                            <td><?php echo $rwbdbl['Jumlah'];?></td>
                            <td><?php echo "Rp. ".$rwbdbl['Harga'];?></td>
                            <td><?php echo "Rp. ".$rwbdbl['Diskon'];?></td>
                            <td><?php echo "Rp. ".$rwbdbl['TotalHrgItem'];?></td>
                            <td class="center"><a href="media.php?module=transpembelian&act=add&barangdibelidel=1&IdBarangDibeli=<?php echo $rwbdbl['IdBarangDibeli']; ?>" class="btn btn-danger"><i class="iconsweets-trashcan iconsweets-white"></i></a></td>
                        </tr>
                            <?php 
                            $no++;
                            } ?>
                        <tr>
                            <td class="center" colspan="5"><b>Total</b></td>
                            <?php
                            $qrytotalpembelian = mysqli_query($mysqli, "SELECT SUM(TotHrgBrgDibeli) AS Total FROM barangdibeli WHERE NoPembelian='$NoPembelian'");
                            $rstotal =  mysqli_fetch_array($qrytotalpembelian);
                            ?>
                            <td colspan="2"><span class="input-prepend input-append"><span class="add-on">Rp. </span><input type="text" name="TotalHrgPembelian" id="TotalHrgPembelian" class="input-medium" value="<?php echo $rstotal['Total'] ; ?>" readonly /></span></td>
                            
                        </tr>
                    </tbody>
                </table>
                <p class="stdformbutton">
                    <button name="simpan" type="submit" class="btn btn-primary">Simpan</button>
                    <button type="reset" class="btn">Batal</button>
                </p>
            </form>
        </div><!--widgetcontent-->
                    
                    <?php
                    //Aksi Simpan
                    if(isset($_POST['simpan'])){
                        $NoPembelian = $_POST['NoPembelian'];
                        $KodeProdusen = $_POST['KodeProdusen'];
                        $TglPembelian = date("Y-m-d", strtotime($_POST['TglPembelian']));
                        $BatasTglTerima = date("Y-m-d", strtotime($_POST['BatasTglTerima']));
                        $TotalHrgPembelian = $_POST['TotalHrgPembelian'];
                        $qry = "INSERT INTO pembelian(NoPembelian, KodeProdusen, TglPembelian, BatasTglTerima, TotalHrgPembelian) VALUES ('$NoPembelian','$KodeProdusen','$TglPembelian','$BatasTglTerima','$TotalHrgPembelian')";
                        $rs = mysqli_query($mysqli, $qry);
                        if($rs){
                            echo "<script>window.location='media.php?module=transpembelian'</script>";
                        }
                    }
                    //End aksi simpan
                    ?>
        
    <?php }elseif ($_GET['act']=="del") {
    ?>
        <!-- DELETE PEMBELIAN Dan RElasinya -->
        <?php
        //Aksi Hapus
            $NoPembelian = $_GET['NoPembelian'];
            $qrydelpembelian = mysqli_query($mysqli, "DELETE FROM pembelian WHERE sha1(NoPembelian) = '".$NoPembelian."'");
            $qrydelbarangdibeli = mysqli_query($mysqli, "DELETE FROM barangdibeli WHERE sha1(NoPembelian) = '".$NoPembelian."'");
            if($qrydelpembelian and $qrydelbarangdibeli){
                echo "<script>window.location='media.php?module=transpembelian'</script>";
            }
        //End Aksi Hapus
        ?>
        <!-- DELETE PRODUSEN -->
    <?php
    }elseif ($_GET['act']=="edit") {
    ?>
        <!-- EDIT PRODUSEN -->
        <?php if(!empty($_GET['NoPembelian'])){
            $NoPembelian = $_GET['NoPembelian'];
            $qrypembeliantamup = "SELECT * FROM pembelian WHERE NoPembelian = '$NoPembelian'";
            $rspembeliantamup = mysqli_query($mysqli, $qrypembeliantamup);
            $rwpembeliantamup = mysqli_fetch_array($rspembeliantamup);
            $NoPembelian = $rwpembeliantamup['NoPembelian'];
            $KodeProdusen = $rwpembeliantamup['KodeProdusen'];
            $TglPembelian = date("m/d/Y", strtotime($rwpembeliantamup['TglPembelian']));
            $BatasTglTerima = date("m/d/Y", strtotime($rwpembeliantamup['BatasTglTerima']));
        ?>
        
        <?php
            function IdBrgDibeli($tabel, $inisial){
                require("_koneksi.php");
                $struktur = mysqli_query($mysqli, "SELECT * FROM $tabel");
                $finfo = mysqli_fetch_field_direct($struktur,0);
                $field = $finfo->name;
                $panjang = $finfo->length;//10

                $qry = mysqli_query($mysqli, "SELECT max(".$field.") FROM ".$tabel);
                $rowIdBrgDibeli = mysqli_fetch_array($qry);
                if ($rowIdBrgDibeli[0]=="") {
                    $angka=0;
                }else{
                    $angka = substr($rowIdBrgDibeli[0], strlen($inisial));
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
        <a href="media.php?module=transpembelian" class="btn btn-primary"><i class="iconsweets-arrowleft iconsweets-white"></i>  &nbsp; Kembali</a>
        <h4 class="widgettitle nomargin shadowed">Menambahkan Barang Pada Transaksi Pembelian</h4>
        <div class="widgetcontent bordered shadowed nopadding">
            <form id="form1" class="stdform stdform2" method="POST" action="media.php?module=transpembelian&act=edit&NoPembelian=<?php echo $NoPembelian;?>">
                <input type="hidden" name="IdBarangDibeli" value="<?php echo IdBrgDibeli("barangdibeli","BRDB"); ?>" />
                <input type="hidden" name="NoPembelian" value="<?php echo $NoPembelian; ?>" />
                <table class="table table-bordered">
                    <colgroup>
                        <col class="con0" style="align: center; width: 510px" />
                        <col class="con1" style="align: center; width: 200px" />
                        <col class="con0" style="align: center; width: 200px" />
                        <col class="con1" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="head0">Barang yang dibeli</th>
                            <th class="head1">Jumlah</th>
                            <th class="head1">Diskon</th>
                            <th class="head1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select name="KodeBarang" data-placeholder="Cari Nama Barang" style="width:500px" class="chzn-select" tabindex="2">
                                    <option value=""></option>
                                    <?php
                                    $qrybarang = mysqli_query($mysqli, "SELECT * FROM barang");
                                    while($rwbarang=mysqli_fetch_array($qrybarang))
                                    {
                                    echo ("<OPTION VALUE=\"$rwbarang[KodeBarang]\">$rwbarang[NamaBarang] (harga Rp. $rwbarang[HrgBeli])</option>");
                                    }
                                    ?>
                                </select>
                            </td>
                            <td><input type="text" name="JmlBrgDibeli" id="JmlBrgDibeli" class="input-medium" value="1"/></td>
                            <td><span class="input-prepend input-append"><span class="add-on">Rp. </span><input type="text" name="DiskonBrgDibeli" id="DiskonBrgDibeli" class="input-medium" value="0" /></span></td>
                            <td class="center"><button name="tambahkan" type="submit" class="btn btn-primary">Tambahkan</button></td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
        <!-- AKSI TAMBAH BRG -->
            <?php
                    if(isset($_POST['tambahkan'])){
                        $IdBarangDibeli = $_POST['IdBarangDibeli'];
                        $NoPembelian = $_POST['NoPembelian'];
                        $KodeBarang = $_POST['KodeBarang'];
                        $JmlBrgDibeli = $_POST['JmlBrgDibeli'];
                        $DiskonBrgDibeli = $_POST['DiskonBrgDibeli'];
                        $qrybarang = mysqli_query($mysqli, "SELECT HrgBeli FROM barang WHERE KodeBarang = '$KodeBarang'");
                        $rsbrg = mysqli_fetch_array($qrybarang);
                        $HrgBrg = $rsbrg['HrgBeli'];
                        $TotHrgBrgDibeli = ($JmlBrgDibeli * $HrgBrg) - $DiskonBrgDibeli;
                        $qrybrgdbl = "INSERT INTO barangdibeli(IdBarangDibeli, NoPembelian, KodeBarang, JmlBrgDibeli, DiskonBrgDibeli, TotHrgBrgDibeli) VALUES ('$IdBarangDibeli','$NoPembelian','$KodeBarang','$JmlBrgDibeli','$DiskonBrgDibeli','$TotHrgBrgDibeli')";
                        $rsbrgdbl = mysqli_query($mysqli, $qrybrgdbl);
                        if($rsbrgdbl){
                            echo "<script>window.location='media.php?module=transpembelian&act=edit&NoPembelian=$NoPembelian'</script>";
                        }
                    }
                    if(isset($_GET['barangdibelidel']) AND !empty($_GET['IdBarangDibeli'])){
                        $IdBarangDibelidel = $_GET['IdBarangDibeli'];
                        $qrybrgdibelidel = mysqli_query($mysqli, "DELETE FROM barangdibeli WHERE IdBarangDibeli = '".$IdBarangDibelidel."'");
                        if($qrybrgdibelidel){
                            echo "<script>window.location='media.php?module=transpembelian&act=edit&NoPembelian=$NoPembelian'</script>";
                        }
                    }
                    ?>
            <!-- END AKSI TAMBAH BRG -->
        <h4 class="widgettitle nomargin shadowed">Edit Transaksi Pembelian</h4>   
        <div class="widgetcontent bordered shadowed nopadding">
            <form id="form1" class="stdform stdform2" method="post" action="media.php?module=transpembelian&act=edit&NoPembelian=<?php echo $NoPembelian;?>">
                <p class="control-group">
                    <label class="control-label" for="NoPembelian">No.Transaksi</label>
                    <span class="field controls"><input type="text" name="NoPembelian" id="NoPembelian" class="input-xxlarge" value="<?php echo $NoPembelian; ?>" readonly /></span>
                </p>
                <p class="control-group">
                    <label class="control-label" for="NamaProdusen">Nama Produsen</label>
                    <span class="field controls">
                        <select name="KodeProdusen" data-placeholder="Cari Nama Produsen" style="width:350px" class="chzn-select" tabindex="2">
                            <?php
                            $qrypdsnasal = "SELECT * FROM produsen WHERE KodeProdusen='$KodeProdusen'";
                            $rspdsnasal = mysqli_query($mysqli, $qrypdsnasal);
                            $rwpdsnasal = mysqli_fetch_array($rspdsnasal);
                            ?>
                            <option value="<?php echo $KodeProdusen; ?>"><?php echo $rwpdsnasal['NamaProdusen']; ?></option>
                            <?php
                            $qryprodusen = "SELECT * FROM produsen WHERE KodeProdusen <> '$KodeProdusen'";
                            $rsprodusen = mysqli_query($mysqli, $qryprodusen);
                            while ($rwprodusen = mysqli_fetch_array($rsprodusen)){
                            ?>
                            <option value="<?php echo $rwprodusen['KodeProdusen'];?>"><?php echo $rwprodusen['NamaProdusen']; ?></option>
                            <?php } ?>
                        </select>
                    </span>
                </p>
                <p class="control-group">
                    <label class="control-label" for="TglPembelian">Tanggal Pembelian</label>
                    <span class="field controls"><input id="datepicker" type="text" name="TglPembelian" class="input-small" value="<?php echo $TglPembelian; ?>" /> &nbsp; <small><em>bulan / tanggal / tahun</em></small></span>
                </p>
                <p class="control-group">
                    <label class="control-label" for="BatasTglTerima">Batas Tanggal Penerimaan</label>
                    <span class="field controls"><input id="datepicker1" type="text" name="BatasTglTerima" class="input-small" value="<?php echo $BatasTglTerima; ?>" /> &nbsp; <small><em>bulan / tanggal / tahun</em></small></span>
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
                            <th class="head0">Barang</th>
                            <th class="head1">Jumlah</th>
                            <th class="head0">Harga</th>
                            <th class="head1">Diskon</th>
                            <th class="head0">Sub Total</th>
                            <th class="head1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            
                            $qrybdbl = "SELECT
barang.NamaBarang AS Barang,
barangdibeli.JmlBrgDibeli AS Jumlah,
barang.HrgBeli AS Harga,
barangdibeli.IdBarangDibeli,
barangdibeli.DiskonBrgDibeli AS Diskon,
barangdibeli.TotHrgBrgDibeli AS TotalHrgItem
FROM
barangdibeli
INNER JOIN barang ON barang.KodeBarang = barangdibeli.KodeBarang
WHERE
barangdibeli.NoPembelian = '$NoPembelian'";
                            $rsbdbl = mysqli_query($mysqli, $qrybdbl);
                            $no = 1;
                            while ($rwbdbl = mysqli_fetch_array($rsbdbl)){
                        ?>
                        <tr>
                            <td class="center"><?php echo $no; ?></td>
                            <td><?php echo $rwbdbl['Barang'];?></td>
                            <td><?php echo $rwbdbl['Jumlah'];?></td>
                            <td><?php echo "Rp. ".$rwbdbl['Harga'];?></td>
                            <td><?php echo "Rp. ".$rwbdbl['Diskon'];?></td>
                            <td><?php echo "Rp. ".$rwbdbl['TotalHrgItem'];?></td>
                            <td class="center"><a href="media.php?module=transpembelian&act=edit&NoPembelian=<?php echo $NoPembelian;?>&barangdibelidel=1&IdBarangDibeli=<?php echo $rwbdbl['IdBarangDibeli']; ?>" class="btn btn-danger"><i class="iconsweets-trashcan iconsweets-white"></i></a></td>
                        </tr>
                            <?php 
                            $no++;
                            } ?>
                        <tr>
                            <td class="center" colspan="5"><b>Total</b></td>
                            <?php
                            $qrytotalpembelian = mysqli_query($mysqli, "SELECT SUM(TotHrgBrgDibeli) AS Total FROM barangdibeli WHERE NoPembelian='$NoPembelian'");
                            $rstotal =  mysqli_fetch_array($qrytotalpembelian);
                            ?>
                            <td colspan="2"><span class="input-prepend input-append"><span class="add-on">Rp. </span><input type="text" name="TotalHrgPembelian" id="TotalHrgPembelian" class="input-medium" value="<?php echo $rstotal['Total'] ; ?>" readonly /></span></td>
                            
                        </tr>
                    </tbody>
                </table>
                <p class="stdformbutton">
                    <button name="simpan" type="submit" class="btn btn-primary">Simpan</button>
                    <button type="reset" class="btn">Batal</button>
                </p>
            </form>
        </div><!--widgetcontent-->
        
        <?php
            //Aksi Simpan
            if(isset($_POST['simpan'])){
                $HNoPembelian = $_POST['NoPembelian'];
                $KodeProdusen = $_POST['KodeProdusen'];
                $TglPembelian = date("Y-m-d", strtotime($_POST['TglPembelian']));
                $BatasTglTerima = date("Y-m-d", strtotime($_POST['BatasTglTerima']));
                $TotalHrgPembelian = $_POST['TotalHrgPembelian'];
                $qry = "UPDATE pembelian SET KodeProdusen='$KodeProdusen', TglPembelian='$TglPembelian', BatasTglTerima='$BatasTglTerima', TotalHrgPembelian='$TotalHrgPembelian' WHERE NoPembelian='$HNoPembelian'";
                $rs = mysqli_query($mysqli, $qry);
                if($rs){
                    echo "<script>window.location='media.php?module=transpembelian'</script>";
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
        <a href="media.php?module=transpembelian&act=add" class="btn btn-primary"><i class="icon-plus-sign icon-white"></i>  &nbsp; Tambah transaksi pembelian</a>
        <h4 class="widgettitle">Daftar Data Transaksi Pembelian</h4>
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
                    <th class="head0"></th>
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
                        <a href="media.php?module=transpembelian&act=edit&NoPembelian=<?php echo $rw['NoTransPem']; ?>"><span class="icon-edit"></span></a>
                        <a href="media.php?module=transpembelian&act=del&NoPembelian=<?php echo sha1($rw['NoTransPem']); ?>"><span class="icon-trash"></span></a>
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