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
    <h1>Unit Mutasi</h1>
</div><!--pagetitle-->
<div class="maincontent">
    <div class="contentinner">
<?php if(isset($_GET['act'])){
    if($_GET['act']=="add"){ ?>
    <!-- TAMBAH KONSUMEN -->
        <?php
            function KdUnit($tabel, $inisial){
                require("_koneksi.php");
                $struktur = mysqli_query($mysqli, "SELECT * FROM $tabel");
                $finfo = mysqli_fetch_field_direct($struktur,0);
                $field = $finfo->name;
                $panjang = $finfo->length;//10

                $qry = mysqli_query($mysqli, "SELECT max(".$field.") FROM ".$tabel);
                $rowKdUnit = mysqli_fetch_array($qry);
                if ($rowKdUnit[0]=="") {
                    $angka=0;
                }else{
                    $angka = substr($rowKdUnit[0], strlen($inisial));
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
            <a href="media.php?module=unitmutasi" class="btn btn-primary"><i class="iconsweets-arrowleft iconsweets-white"></i>  &nbsp; Kembali</a>
            <h4 class="widgettitle nomargin shadowed">Tambahkan Data Unit Mutasi Baru</h4>  
                <div class="widgetcontent bordered shadowed nopadding">
                    <form id="form1" class="stdform stdform2" method="post" action="media.php?module=unitmutasi&act=add">
                            <p class="control-group">
                                <label class="control-label" for="KdUnit">Kode Unit</label>
                                <span class="field controls"><input type="text" name="KdUnit" id="KdUnit" class="input-xxlarge" value="<?php echo KdUnit("unitmutasi","UNIT"); ?>" readonly /></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="NamaUnit">Nama Unit</label>
                                <span class="field controls"><input type="text" name="NamaUnit" id="NamaUnit" class="input-xxlarge" /></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="PJUnit">Penanggung Jawab</label>
                                <span class="field controls"><input type="text" name="PJUnit" id="PJUnit" class="input-xxlarge" /></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="IdLevel">Devisi Bagian</label>
                                <span class="field controls">
                                    <select name="IdLevel" data-placeholder="Cari Devisi Bagian" style="width:350px" class="chzn-select" tabindex="2" required>
                                        <option value=""></option>
                                        <?php
                                        $qslevel = "SELECT * FROM leveluser";
                                        $rslevel = mysqli_query($mysqli, $qslevel);
                                        while ($rwlevel = mysqli_fetch_array($rslevel)){
                                        ?>
                                        <option value="<?php echo $rwlevel['IdLevel'];?>"><?php echo $rwlevel['Level']; ?></option>
                                        <?php } ?>
                                    </select>
                                </span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="TelpUnit">Nomor Handphone</label>
                                <span class="field controls"><input type="text" name="TelpUnit" id="TelpUnit" class="input-large" /></span>
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
                        $KdUnit = $_POST['KdUnit'];
                        $NamaUnit = $_POST['NamaUnit'];
                        $PJUnit = $_POST['PJUnit'];
                        $TelpUnit = $_POST['TelpUnit'];
                        $IdLevel = $_POST['IdLevel'];
                        $qry = "INSERT INTO unitmutasi(KdUnit, NamaUnit, PJUnit, TelpUnit, IdLevel) VALUES ('$KdUnit','$NamaUnit','$PJUnit','$TelpUnit','$IdLevel')";
						
                        $rs = mysqli_query($mysqli, $qry);
                        if($rs){
                            echo "<script>window.location='media.php?module=unitmutasi'</script>";
                        }
                    }
                    //End aksi simpan
                    ?>
                    
    <!-- TAMBAH KONSUMEN -->
    <?php }elseif ($_GET['act']=="del") {
    ?>
        <!-- DELETE KONSUMEN -->
        <?php
        //Aksi Hapus
            $KdUnit = $_GET['KdUnit'];
            $qrydel = mysqli_query($mysqli, "DELETE FROM unitmutasi WHERE sha1(KdUnit) = '".$KdUnit."'");
            if($qrydel){
                echo "<script>window.location='media.php?module=unitmutasi'</script>";
            }
        //End Aksi Hapus
        ?>
        <!-- DELETE KONSUMEN -->
    <?php
    }elseif ($_GET['act']=="edit") {
    ?>
        <!-- EDIT KONSUMEN -->
        <?php if(!empty($_GET['KdUnit'])){
            $KdUnit = $_GET['KdUnit'];
            $qry = "SELECT unitmutasi.*, leveluser.Level FROM unitmutasi INNER JOIN leveluser ON unitmutasi.IdLevel=leveluser.IdLevel WHERE sha1(unitmutasi.KdUnit) = '$KdUnit'";
            $rs = mysqli_query($mysqli, $qry);
            $rw = mysqli_fetch_array($rs);
        ?>
            <a href="media.php?module=unitmutasi" class="btn btn-primary"><i class="iconsweets-arrowleft iconsweets-white"></i>  &nbsp; Kembali</a>
            <h4 class="widgettitle nomargin shadowed">Edit Data Unit Mutasi</h4>    
                <div class="widgetcontent bordered shadowed nopadding">
                    <form id="form1" class="stdform stdform2" method="post" action="media.php?module=unitmutasi&act=edit">
                            <p class="control-group">
                                <label class="control-label" for="KdUnit">Kode Unit Mutasi</label>
                                <span class="field controls"><input type="text" name="KdUnit" id="KdUnit" class="input-xxlarge" value="<?php echo $rw['KdUnit']; ?>" readonly /></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="NamaUnit">Nama Unit</label>
                                <span class="field controls"><input type="text" name="NamaUnit" id="NamaUnit" class="input-xxlarge" value="<?php echo $rw['NamaUnit']; ?>" /></span>
                            </p>
							<p class="control-group">
                                <label class="control-label" for="PJUnit">Penanggung Jawab</label>
                                <span class="field controls"><input type="text" name="PJUnit" id="PJUnit" class="input-xxlarge" value="<?php echo $rw['PJUnit']; ?>" /></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="IdLevel">Devisi Bagian</label>
                                <span class="field controls">
                                    <select name="IdLevel" data-placeholder="Cari Devisi Bagian" style="width:350px" class="chzn-select" tabindex="2">
                                        
                                        <?php
                                        $qslevel = "SELECT * FROM leveluser";
                                        $rslevel = mysqli_query($mysqli, $qslevel); 
                                        while ($rwlevel = mysqli_fetch_array($rslevel)){
                                            echo "<option value="."'"."$rwlevel[IdLevel]"."'"; if ($rw['Level']==$rwlevel['Level']) {
                                            echo " "."selected";
                                            } echo ">"; echo $rwlevel['Level']."</option>";
                                         } ?>
                                    </select>
                                </span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="TelpUnit">Nomor Handphone</label>
                                <span class="field controls"><input type="text" name="TelpUnit" id="TelpUnit" class="input-large" value="<?php echo $rw['TelpUnit']; ?>" /></span>
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
                $HKdUnit = $_POST['KdUnit'];
                $NamaUnit = $_POST['NamaUnit'];
                $PJUnit = $_POST['PJUnit'];
                $TelpUnit = $_POST['TelpUnit'];
                $IdLevel = $_POST['IdLevel'];
                $qry = "UPDATE unitmutasi SET NamaUnit='$NamaUnit', PJUnit='$PJUnit', TelpUnit='$TelpUnit', IdLevel='$IdLevel' WHERE KdUnit='$HKdUnit'";
                $rs = mysqli_query($mysqli, $qry);
                if($rs){
                    echo "<script>window.location='media.php?module=unitmutasi'</script>";
                }
            }
            //End aksi simpan
        }else{
            header("location:media.php?module=unitmutasi");
        }
        ?>
        <!-- EDIT KONSUMEN --> 
    <?php } ?>
<?php
}else{
?>
<!--TAMPIL DATA KONSUMEN-->
        <a href="media.php?module=unitmutasi&act=add" class="btn btn-primary"><i class="icon-plus-sign icon-white"></i>  &nbsp; Tambah data Unit Mutasi</a>
        <h4 class="widgettitle">Daftar Data Unit Mutasi</h4>
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
                    <th class="head0">Kode Unit Mutasi</th>
                    <th class="head1">Nama Unit</th>
                    <th class="head0">Penanggung Jawab Unit</th>
                    <th class="head1">Nomor Handphone</th>
                    <th class="head0"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $qry = "SELECT * FROM unitmutasi";
                    $rs = mysqli_query($mysqli, $qry);
                    while ($rw = mysqli_fetch_array($rs)){
                ?>
                <tr class="gradeC">
                    <td><span class="center"><input type="checkbox" /></span></td>
                    <td><?php echo $rw['KdUnit']; ?></td>
                    <td><?php echo $rw['NamaUnit']; ?></td>
                    <td><?php echo $rw['PJUnit']; ?></td>
                    <td><?php echo $rw['TelpUnit']; ?></td>
                    <td class="centeralign">
                        <a href="media.php?module=unitmutasi&act=edit&KdUnit=<?php echo sha1($rw['KdUnit']); ?>"><span class="icon-edit"></span></a>
                        <a href="media.php?module=unitmutasi&act=del&KdUnit=<?php echo sha1($rw['KdUnit']); ?>"><span class="icon-trash"></span></a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
<!--TAMPIL DATA KONSUMEN-->
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