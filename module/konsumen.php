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
            function KdKonsumen($tabel, $inisial){
                require("_koneksi.php");
                $struktur = mysqli_query($mysqli, "SELECT * FROM $tabel");
                $finfo = mysqli_fetch_field_direct($struktur,0);
                $field = $finfo->name;
                $panjang = $finfo->length;//10

                $qry = mysqli_query($mysqli, "SELECT max(".$field.") FROM ".$tabel);
                $rowKodeKonsumen = mysqli_fetch_array($qry);
                if ($rowKodeKonsumen[0]=="") {
                    $angka=0;
                }else{
                    $angka = substr($rowKodeKonsumen[0], strlen($inisial));
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
            <a href="media.php?module=konsumen" class="btn btn-primary"><i class="iconsweets-arrowleft iconsweets-white"></i>  &nbsp; Kembali</a>
            <h4 class="widgettitle nomargin shadowed">Tambahkan Data Unit Mutasi Baru</h4>  
                <div class="widgetcontent bordered shadowed nopadding">
                    <form id="form1" class="stdform stdform2" method="post" action="media.php?module=konsumen&act=add">
                            <p class="control-group">
                                <label class="control-label" for="KodeKonsumen">Kode Unit</label>
                                <span class="field controls"><input type="text" name="KodeKonsumen" id="KodeKonsumen" class="input-xxlarge" value="<?php echo KdKonsumen("konsumen","UNIT"); ?>" readonly /></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="NamaKonsumen">Nama Unit</label>
                                <span class="field controls"><input type="text" name="NamaKonsumen" id="NamaKonsumen" class="input-xxlarge" /></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="AlamatKonsumen">Penanggung Jawab</label>
                                <span class="field controls"><input type="text" name="PenanggungJawab" id="PenanggungJawab" class="input-xxlarge" /></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="Handphone">Nomor Handphone</label>
                                <span class="field controls"><input type="text" name="Handphone" id="Handphone" class="input-large" /></span>
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
                        $KodeKonsumen = $_POST['KodeKonsumen'];
                        $NamaKonsumen = $_POST['NamaKonsumen'];
                        $PenanggungJawab = $_POST['PenanggungJawab'];
                        $Hp = $_POST['Handphone'];
                        $qry = "INSERT INTO konsumen(KodeKonsumen, NamaKonsumen, PenanggungJawab, TelpKonsumen) VALUES ('$KodeKonsumen','$NamaKonsumen','$PenanggungJawab','$Hp')";
						
                        $rs = mysqli_query($mysqli, $qry);
                        if($rs){
                            echo "<script>window.location='media.php?module=konsumen'</script>";
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
            $KodeKonsumen = $_GET['KodeKonsumen'];
            $qrydel = mysqli_query($mysqli, "DELETE FROM konsumen WHERE sha1(KodeKonsumen) = '".$KodeKonsumen."'");
            if($qrydel){
                echo "<script>window.location='media.php?module=konsumen'</script>";
            }
        //End Aksi Hapus
        ?>
        <!-- DELETE KONSUMEN -->
    <?php
    }elseif ($_GET['act']=="edit") {
    ?>
        <!-- EDIT KONSUMEN -->
        <?php if(!empty($_GET['KodeKonsumen'])){
            $KodeKonsumen = $_GET['KodeKonsumen'];
            $qry = "SELECT * FROM konsumen WHERE sha1(KodeKonsumen) = '$KodeKonsumen'";
            $rs = mysqli_query($mysqli, $qry);
            $rw = mysqli_fetch_array($rs);
        ?>
            <a href="media.php?module=konsumen" class="btn btn-primary"><i class="iconsweets-arrowleft iconsweets-white"></i>  &nbsp; Kembali</a>
            <h4 class="widgettitle nomargin shadowed">Edit Data Konsumen</h4>    
                <div class="widgetcontent bordered shadowed nopadding">
                    <form id="form1" class="stdform stdform2" method="post" action="media.php?module=konsumen&act=edit">
                            <p class="control-group">
                                <label class="control-label" for="KodeKonsumen">Kode Konsumen</label>
                                <span class="field controls"><input type="text" name="KodeKonsumen" id="KodeKonsumen" class="input-xxlarge" value="<?php echo $rw['KodeKonsumen']; ?>" readonly /></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="NamaKonsumen">Nama Konsumen</label>
                                <span class="field controls"><input type="text" name="NamaKonsumen" id="NamaKonsumen" class="input-xxlarge" value="<?php echo $rw['NamaKonsumen']; ?>" /></span>
                            </p>
							<p class="control-group">
                                <label class="control-label" for="PenanggungJawab">Penanggung Jawab</label>
                                <span class="field controls"><input type="text" name="PenanggungJawab" id="PenanggungJawab" class="input-xxlarge" value="<?php echo $rw['PenanggungJawab']; ?>" /></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="Handphone">Nomor Handphone</label>
                                <span class="field controls"><input type="text" name="Handphone" id="Handphone" class="input-large" value="<?php echo $rw['TelpKonsumen']; ?>" /></span>
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
                $HKodeKonsumen = $_POST['KodeKonsumen'];
                $NamaKonsumen = $_POST['NamaKonsumen'];
                $PenanggungJawab = $_POST['PenanggungJawab'];
                $Hp = $_POST['Handphone'];
                $qry = "UPDATE konsumen SET NamaKonsumen='$NamaKonsumen', PenanggungJawab='$PenanggungJawab', TelpKonsumen='$Hp' WHERE KodeKonsumen='$HKodeKonsumen'";
                $rs = mysqli_query($mysqli, $qry);
                if($rs){
                    echo "<script>window.location='media.php?module=konsumen'</script>";
                }
            }
            //End aksi simpan
        }else{
            header("location:media.php?module=konsumen");
        }
        ?>
        <!-- EDIT KONSUMEN --> 
    <?php } ?>
<?php
}else{
?>
<!--TAMPIL DATA KONSUMEN-->
        <a href="media.php?module=konsumen&act=add" class="btn btn-primary"><i class="icon-plus-sign icon-white"></i>  &nbsp; Tambah data konsumen</a>
        <h4 class="widgettitle">Daftar Data Konsumen</h4>
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
                    <th class="head0">Kode Konsumen</th>
                    <th class="head1">Nama Konsumen</th>
                    <th class="head0">Penanggung Jawab Unit</th>
                    <th class="head1">Nomor Handphone</th>
                    <th class="head0"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $qry = "SELECT * FROM konsumen";
                    $rs = mysqli_query($mysqli, $qry);
                    while ($rw = mysqli_fetch_array($rs)){
                ?>
                <tr class="gradeC">
                    <td><span class="center"><input type="checkbox" /></span></td>
                    <td><?php echo $rw['KodeKonsumen']; ?></td>
                    <td><?php echo $rw['NamaKonsumen']; ?></td>
                    <td><?php echo $rw['PenanggungJawab']; ?></td>
                    <td><?php echo $rw['TelpKonsumen']; ?></td>
                    <td class="centeralign">
                        <a href="media.php?module=konsumen&act=edit&KodeKonsumen=<?php echo sha1($rw['KodeKonsumen']); ?>"><span class="icon-edit"></span></a>
                        <a href="media.php?module=konsumen&act=del&KodeKonsumen=<?php echo sha1($rw['KodeKonsumen']); ?>"><span class="icon-trash"></span></a>
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