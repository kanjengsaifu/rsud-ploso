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
    <h1>Obat</h1>
</div><!--pagetitle-->
<div class="maincontent">
    <div class="contentinner">
<?php if(isset($_GET['act'])){
    if($_GET['act']=="add"){ ?>
    <!-- TAMBAH obat -->
        <?php
            function Kdobat($tabel, $inisial){
                require("_koneksi.php");
                $struktur = mysqli_query($mysqli, "SELECT * FROM $tabel");
                $finfo = mysqli_fetch_field_direct($struktur,0);
                $field = $finfo->name;//KodeProdusen
                $panjang = $finfo->length;//10

                $qry = mysqli_query($mysqli, "SELECT max(".$field.") FROM ".$tabel);
                $rowKodeobat = mysqli_fetch_array($qry);
                if ($rowKodeobat[0]=="") {
                    $angka=0;
                }else{
                    $angka = substr($rowKodeobat[0], strlen($inisial));
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
            <a href="media.php?module=obat" class="btn btn-primary"><i class="iconsweets-arrowleft iconsweets-white"></i>  &nbsp; Kembali</a>
            <h4 class="widgettitle nomargin shadowed">Tambahkan Data Obat Baru</h4>  
                <div class="widgetcontent bordered shadowed nopadding">
                    <form id="form1" class="stdform stdform2" method="post" action="media.php?module=obat&act=add">
                            
                            <p class="control-group">
                                <label class="control-label" for="Batchobat">Batch Obat</label>
                                <span class="field controls"><input type="text" name="Batchobat" id="Batchobat" class="input-xlarge" /></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="NamaObat">Nama Obat</label>
                                <span class="field controls"><input type="text" name="NamaObat" id="NamaObat" class="input-xlarge" /></span>
                            </p>
							<p class="control-group" for="Satuan">
                        	<label class="control-label">Bentuk</label>
                            <span class="field">
                            <select data-placeholder="Bentuk Obat" name="Satuan" id="Satuan" class="chzn-select" style="width:200px" tabindex="2" >
                                <option value=""></option>
                            	<option value="Tablet">Tablet</option>
                                <option value="Kapsul">Kapsul</option>
                                <option value="Kaplet">Kaplet</option>
                                <option value="Pil">Pil</option>
                                <option value="Sirup">Sirup</option>
								<option value="Salep">Salep</option>
                                <option value="Serbuk">Serbuk</option>
                            </select>
                            </span>
							</p>

                            <p class="control-group">
                                <label class="control-label" for="ED">Expired Date</label>
                                <span class="field controls"><input id="datepicker" type="text" name="ED" class="input-small" /> &nbsp; <small><em>bulan / tanggal / tahun</em></small></span>                 
                            </p>

							<p class="control-group" for="SumberPengadaan">
                            <label class="control-label">Sumber Pengadaan</label>
                            <span class="field">
                            <select data-placeholder="Cari Sumber Pengadaan" name="SumberPengadaan" id="SumberPengadaan" class="chzn-select" style="width:300px" tabindex="2" >
                                <option value=""></option>
                                <option value="E-purchasing">E-purchasing</option>
                                <option value="PL">PL</option>
                                <option value="Hibah">Hibah</option>
                                <option value="Lelang">Lelang</option>
                                
                            </select>
                            </span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="JumlahObat">Jumlah Obat</label>
                                <span class="field controls"><input type="number" name="JumlahObat" id="JumlahObat" class="input-large"  /></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="StokMinimum">Stok Minimum</label>
                                <span class="field controls"><input type="number" name="StokMinimum" id="StokMinimum" class="input-large" /></span>
                            </p>

                            <p class="control-group">
                                <label class="control-label" for="HrgBeli">Harga Beli</label>
                                <span class="field controls input-prepend input-append"><span class="add-on">Rp. </span><input type="text" name="HrgBeli" id="HrgBeli" class="input-large" /></span>
                            </p>

                            <p class="control-group">
                                <label class="control-label" for="Faktur">Faktur</label>
                                <span class="field controls"><input type="text" name="Faktur" id="Faktur" class="input-xxlarge" /></span>
                            </p>
                            <!-- <p class="control-group">
                                <label class="control-label" for="HrgJual">Harga Jual</label>
                                <span class="field controls input-prepend input-append"><span class="add-on">Rp. </span><input type="text" name="HrgJual" id="HrgJual" class="input-large" /></span>
                            </p> -->

                            
                            <p class="stdformbutton">
                                <button name="simpan" type="submit" class="btn btn-primary">Simpan</button>
                                <button type="reset" class="btn">Batal</button>
                            </p>
                        </form>
                    </div><!--widgetcontent-->
                    
                    <?php
                    //Aksi Simpan
                    if(isset($_POST['simpan'])){
                        date_default_timezone_set('Asia/Jakarta');
                        $Batchobat = $_POST['Batchobat'];
                        $NamaObat = $_POST['NamaObat'];
                        $BentukObat = $_POST['Satuan'];
                        $ExpiredDate =  date("Y-m-d", strtotime($_POST['ED']));
                        $SumberPengadaan = $_POST['SumberPengadaan'];
                        $JumlahObat = $_POST['JumlahObat'];                                               
                        $HrgBeli = $_POST['HrgBeli'];
                        $TotPembelian = $JumlahObat * $HrgBeli;                
                        $StokMinimum = $_POST['StokMinimum'];
                        $Faktur = $_POST['Faktur'];
                        $TglInputObat = date("Y-m-d")." ".date("H:i:s");
                        $qry = "INSERT INTO obat(Batchobat, NamaObat, BentukObat, ExpiredDate, SumberPengadaan,ObatMasuk,HrgBeli,TotPembelian,StokMinimum,Faktur,TglInputObat) VALUES ('$Batchobat','$NamaObat','$BentukObat','$ExpiredDate','$SumberPengadaan','$JumlahObat','$HrgBeli','$TotPembelian','$StokMinimum','$Faktur','$TglInputObat')";
                        $rs = mysqli_query($mysqli, $qry);
                        if($rs){
                            echo "<script>window.location='media.php?module=obat'</script>";
                        }
                    }
                    //End aksi simpan
                    ?>
                    
    <!-- TAMBAH obat -->
    <?php }elseif ($_GET['act']=="del") {
    ?>
        <!-- DELETE obat -->
        <?php
        //Aksi Hapus
            $Kodeobat = $_GET['Kodeobat'];
            $qrydel = mysqli_query($mysqli, "DELETE FROM obat WHERE sha1(Kodeobat) = '".$Kodeobat."'");
            if($qrydel){
                echo "<script>window.location='media.php?module=obat'</script>";
            }
        //End Aksi Hapus
        ?>
        <!-- DELETE obat -->
    <?php
    }elseif ($_GET['act']=="edit") {
    ?>
        <!-- EDIT obat -->
        <?php if(!empty($_GET['Kodeobat'])){
            $Kodeobat = $_GET['Kodeobat'];
            $qry = "SELECT * FROM obat WHERE sha1(Kodeobat) = '$Kodeobat'";
            $rs = mysqli_query($mysqli, $qry);
            $rw = mysqli_fetch_array($rs);
        ?>
            <a href="media.php?module=obat" class="btn btn-primary"><i class="iconsweets-arrowleft iconsweets-white"></i>  &nbsp; Kembali</a>
            <h4 class="widgettitle nomargin shadowed">Edit Data Obat</h4>    
                <div class="widgetcontent bordered shadowed nopadding">
                    <form id="form1" class="stdform stdform2" method="post" action="media.php?module=obat&act=edit">
                            <p class="control-group">
                                <label class="control-label" for="Kodeobat">Kode Obat</label>
                                <span class="field controls"><input type="text" name="Kodeobat" id="Kodeobat" class="input-xxlarge" value="<?php echo $rw['Kodeobat']; ?>" readonly /></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="Namaobat">Nama Obat</label>
                                <span class="field controls"><input type="text" name="Namaobat" id="Namaobat" class="input-xxlarge" value="<?php echo $rw['Namaobat']; ?>" /></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="Satuan">Satuan</label>
                                <span class="field controls"><input type="text" name="Satuan" id="Satuan" class="input-large" value="<?php echo $rw['Satuan']; ?>" /></span>
                            </p>
							<p class="control-group" for="Satuan">
                        	<label class="control-label">Bentuk</label>
                            <span class="field">
                            <select name="Satuan" id="Satuan" class="uniformselect">
                            	<option value="">Tablet</option>
                                <option value="">Kapsul</option>
                                <option value="">Kaplet</option>
                                <option value="">Pil</option>
                                <option value="">Sirup</option>
								<option value="">Salep</option>
                            </select>
                            
                            </span>
							</p>
							<p class="control-group">
                                <label class="control-label" for="Batch">Batch</label>
                                <span class="field controls"><input type="text" name="Batch" id="Batch" class="input-xxlarge" /></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="HrgBeli">Harga Beli</label>
                                <span class="field controls input-prepend input-append"><span class="add-on">Rp. </span><input type="text" name="HrgBeli" id="HrgBeli" class="input-large" value="<?php echo $rw['HrgBeli']; ?>" /></span>
                            </p>

                            <p class="control-group">
                                <label class="control-label" for="HrgJual">Harga Jual</label>
                                <span class="field controls input-prepend input-append"><span class="add-on">Rp. </span><input type="text" name="HrgJual" id="HrgJual" class="input-large" value="<?php echo $rw['HrgJual']; ?>" /></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="StokMinimum">Stok Minimum</label>
                                <span class="field controls"><input type="text" name="StokMinimum" id="StokMinimum" class="input-large" value="<?php echo $rw['StokMinimum']; ?>" /></span>
                            </p>
                            <p class="stdformbutton">
                                <button name="simpan" type="submit" class="btn btn-primary">Simpan</button>
                                <button type="reset" class="btn">Batal</button>
                            </p>
                        </form>
                    </div><!--widgetcontent-->
        <?php
        }elseif (isset ($_POST['simpan'])) {
            //Aksi Simpan
            if(isset($_POST['simpan'])){
                $HKodeobat = $_POST['Kodeobat'];
                $Namaobat = $_POST['Namaobat'];
                $Satuan = $_POST['Satuan'];
                $HrgBeli = $_POST['HrgBeli'];
                $HrgJual = $_POST['HrgJual'];
                $StokMinimum = $_POST['StokMinimum'];
                $qry = "UPDATE obat SET Namaobat='$Namaobat', Satuan='$Satuan', HrgBeli='$HrgBeli', HrgJual='$HrgJual', StokMinimum='$StokMinimum' WHERE Kodeobat='$HKodeobat'";
                $rs = mysqli_query($mysqli, $qry);
                if($rs){
                    echo "<script>window.location='media.php?module=obat'</script>";
                }
            }
            //End aksi simpan
        }else{
            header("location:media.php?module=obat");
        }
        ?>
        <!-- EDIT obat --> 
    <?php } ?>
<?php
}else{
?>
<!--TAMPIL DATA obat-->
        <a href="media.php?module=obat&act=add" class="btn btn-primary"><i class="icon-plus-sign icon-white"></i>  &nbsp; Tambah data obat</a>
        <h4 class="widgettitle">Daftar Data OBAT</h4>
        <table class="table table-bordered" id="dyntable">
            <colgroup>
                <col class="con0" style="align: center; width: 4%" />
                <col class="con1" />
                <col class="con0" />
                <col class="con1" />
                <col class="con0" />
                <col class="con1" />
            </colgroup>
            <thead>
                <tr>
                    <th class="head0 nosort"><input type="checkbox" class="checkall" /></th>
                    <th class="head0">Batch Obat</th>
                    <th class="head1">Nama Obat</th>
                    <th class="head0">Ex. Date <em>(thn/bln/tgl)</em></th>
                    <th class="head1">Bentuk Obat</th>
                    <th class="head0">Harga Satuan</th>
                    <th class="head1">Jumlah Obat</th>
                    <th class="head0">Total Pembelian</th>
                    
                    <th class="head1"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $qry = "SELECT * FROM obat";
                    $rs = mysqli_query($mysqli, $qry);
                    while ($rw = mysqli_fetch_array($rs)){
                ?>
                <tr class="gradeC">
                    <td><span class="center"><input type="checkbox" /></span></td>
                    <td><?php echo $rw['BatchObat']; ?></td>					
                    <td><?php echo $rw['NamaObat']; ?></td>
                    <td><?php echo $rw['ExpiredDate']; ?></td>
                    <td><?php echo $rw['BentukObat']; ?></td>                    
                    <td><?php echo "Rp. ".$rw['HrgJual']; ?></td>
                    <td><?php echo $rw['ObatMasuk']; ?></td>
                    <td><?php echo "Rp. ".$rw['TotPembelian']; ?></td>                    
                    
                    <td class="centeralign">
                        <a href="media.php?module=obat&act=edit&Kodeobat=<?php echo sha1($rw['Kodeobat']); ?>"><span class="icon-edit"></span></a>
                        <a href="media.php?module=obat&act=del&Kodeobat=<?php echo sha1($rw['Kodeobat']); ?>"><span class="icon-trash"></span></a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
<!--TAMPIL DATA obat-->
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