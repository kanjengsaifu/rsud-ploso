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
    <!-- TAMBAH BARANG -->
        <?php
            function KdBarang($tabel, $inisial){
                require("_koneksi.php");
                $struktur = mysqli_query($mysqli, "SELECT * FROM $tabel");
                $finfo = mysqli_fetch_field_direct($struktur,0);
                $field = $finfo->name;//KodeProdusen
                $panjang = $finfo->length;//10

                $qry = mysqli_query($mysqli, "SELECT max(".$field.") FROM ".$tabel);
                $rowKodeBarang = mysqli_fetch_array($qry);
                if ($rowKodeBarang[0]=="") {
                    $angka=0;
                }else{
                    $angka = substr($rowKodeBarang[0], strlen($inisial));
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
            <a href="media.php?module=barang" class="btn btn-primary"><i class="iconsweets-arrowleft iconsweets-white"></i>  &nbsp; Kembali</a>
            <h4 class="widgettitle nomargin shadowed">Tambahkan Data Obat Baru</h4>  
                <div class="widgetcontent bordered shadowed nopadding">
                    <form id="form1" class="stdform stdform2" method="post" action="media.php?module=barang&act=add">
                            <p class="control-group">
                                <label class="control-label" for="KodeBarang">Kode Obat</label>
                                <span class="field controls"><input type="text" name="KodeBarang" id="KodeBarang" class="input-xxlarge" value="<?php echo KdBarang("barang","OBAT"); ?>" readonly /></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="NamaBarang">Nama Obat</label>
                                <span class="field controls"><input type="text" name="NamaBarang" id="NamaBarang" class="input-xxlarge" /></span>
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
                                <label class="control-label" for="NamaBarang">Batch</label>
                                <span class="field controls"><input type="text" name="NamaBarang" id="NamaBarang" class="input-xxlarge" /></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="HrgBeli">Harga Beli</label>
                                <span class="field controls input-prepend input-append"><span class="add-on">Rp. </span><input type="text" name="HrgBeli" id="HrgBeli" class="input-large" /></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="HrgJual">Harga Jual</label>
                                <span class="field controls input-prepend input-append"><span class="add-on">Rp. </span><input type="text" name="HrgJual" id="HrgJual" class="input-large" /></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="StokMinimum">Stok Minimum</label>
                                <span class="field controls"><input type="text" name="StokMinimum" id="StokMinimum" class="input-large" /></span>
                            </p>
                            <p class="stdformbutton">
                                <button name="simpan" type="submit" class="btn btn-primary">Simpan</button>
                                <button type="reset" class="btn">Batal</button>
                            </p>
                        </form>
                    </div><!--widgetcontent-->
                    
                    <?php
                    //Aksi Simpan
                    if(isset($_POST['simpan'])){
                        $KodeBarang = $_POST['KodeBarang'];
                        $NamaBarang = $_POST['NamaBarang'];
                        $Satuan = $_POST['Satuan'];
                        $HrgBeli = $_POST['HrgBeli'];
                        $HrgJual = $_POST['HrgJual'];
                        $StokMinimum = $_POST['StokMinimum'];
                        $qry = "INSERT INTO barang(KodeBarang, NamaBarang, Satuan, HrgBeli, HrgJual, StokMinimum) VALUES ('$KodeBarang','$NamaBarang','$Satuan','$HrgBeli','$HrgJual','$StokMinimum')";
                        $rs = mysqli_query($mysqli, $qry);
                        if($rs){
                            echo "<script>window.location='media.php?module=barang'</script>";
                        }
                    }
                    //End aksi simpan
                    ?>
                    
    <!-- TAMBAH BARANG -->
    <?php }elseif ($_GET['act']=="del") {
    ?>
        <!-- DELETE BARANG -->
        <?php
        //Aksi Hapus
            $KodeBarang = $_GET['KodeBarang'];
            $qrydel = mysqli_query($mysqli, "DELETE FROM barang WHERE sha1(KodeBarang) = '".$KodeBarang."'");
            if($qrydel){
                echo "<script>window.location='media.php?module=barang'</script>";
            }
        //End Aksi Hapus
        ?>
        <!-- DELETE BARANG -->
    <?php
    }elseif ($_GET['act']=="edit") {
    ?>
        <!-- EDIT BARANG -->
        <?php if(!empty($_GET['KodeBarang'])){
            $KodeBarang = $_GET['KodeBarang'];
            $qry = "SELECT * FROM barang WHERE sha1(KodeBarang) = '$KodeBarang'";
            $rs = mysqli_query($mysqli, $qry);
            $rw = mysqli_fetch_array($rs);
        ?>
            <a href="media.php?module=barang" class="btn btn-primary"><i class="iconsweets-arrowleft iconsweets-white"></i>  &nbsp; Kembali</a>
            <h4 class="widgettitle nomargin shadowed">Edit Data Obat</h4>    
                <div class="widgetcontent bordered shadowed nopadding">
                    <form id="form1" class="stdform stdform2" method="post" action="media.php?module=barang&act=edit">
                            <p class="control-group">
                                <label class="control-label" for="KodeBarang">Kode Obat</label>
                                <span class="field controls"><input type="text" name="KodeBarang" id="KodeBarang" class="input-xxlarge" value="<?php echo $rw['KodeBarang']; ?>" readonly /></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="NamaBarang">Nama Obat</label>
                                <span class="field controls"><input type="text" name="NamaBarang" id="NamaBarang" class="input-xxlarge" value="<?php echo $rw['NamaBarang']; ?>" /></span>
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
                $HKodeBarang = $_POST['KodeBarang'];
                $NamaBarang = $_POST['NamaBarang'];
                $Satuan = $_POST['Satuan'];
                $HrgBeli = $_POST['HrgBeli'];
                $HrgJual = $_POST['HrgJual'];
                $StokMinimum = $_POST['StokMinimum'];
                $qry = "UPDATE barang SET NamaBarang='$NamaBarang', Satuan='$Satuan', HrgBeli='$HrgBeli', HrgJual='$HrgJual', StokMinimum='$StokMinimum' WHERE KodeBarang='$HKodeBarang'";
                $rs = mysqli_query($mysqli, $qry);
                if($rs){
                    echo "<script>window.location='media.php?module=barang'</script>";
                }
            }
            //End aksi simpan
        }else{
            header("location:media.php?module=barang");
        }
        ?>
        <!-- EDIT BARANG --> 
    <?php } ?>
<?php
}else{
?>
<!--TAMPIL DATA BARANG-->
        <a href="media.php?module=barang&act=add" class="btn btn-primary"><i class="icon-plus-sign icon-white"></i>  &nbsp; Tambah data obat</a>
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
                    <th class="head0">Kode Obat</th>
					<th class="head0">Batch</th>
                    <th class="head1">Nama Obat</th>
                    <th class="head0">Bentuk</th>
                    <th class="head1">Harga Beli</th>
                    
                    <th class="head1">Stok Minimum</th>
                    <th class="head0"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $qry = "SELECT * FROM barang";
                    $rs = mysqli_query($mysqli, $qry);
                    while ($rw = mysqli_fetch_array($rs)){
                ?>
                <tr class="gradeC">
                    <td><span class="center"><input type="checkbox" /></span></td>
                    <td><?php echo $rw['KodeBarang']; ?></td>
					<td>123aa34p</td>
                    <td><?php echo $rw['NamaBarang']; ?></td>
                    <td><?php echo $rw['Satuan']; ?></td>
                    <td><?php echo "Rp. ".$rw['HrgBeli']; ?></td>
                    
                    <td><?php echo $rw['StokMinimum']; ?></td>
                    <td class="centeralign">
                        <a href="media.php?module=barang&act=edit&KodeBarang=<?php echo sha1($rw['KodeBarang']); ?>"><span class="icon-edit"></span></a>
                        <a href="media.php?module=barang&act=del&KodeBarang=<?php echo sha1($rw['KodeBarang']); ?>"><span class="icon-trash"></span></a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
<!--TAMPIL DATA BARANG-->
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