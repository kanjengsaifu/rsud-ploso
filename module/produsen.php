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
    <h1>Produsen</h1>
</div><!--pagetitle-->
<div class="maincontent">
    <div class="contentinner">
<?php if(isset($_GET['act'])){
    if($_GET['act']=="add"){ ?>
    <!-- TAMBAH PRODUSEN -->
        <?php
            function KdProdusen($tabel, $inisial){
                require("_koneksi.php");
                $struktur = mysqli_query($mysqli, "SELECT * FROM $tabel");
                $finfo = mysqli_fetch_field_direct($struktur,0);
                $field = $finfo->name;//KodeProdusen
                $panjang = $finfo->length;//10

                $qry = mysqli_query($mysqli, "SELECT max(".$field.") FROM ".$tabel);
                $rowKodeProdusen = mysqli_fetch_array($qry);
                if ($rowKodeProdusen[0]=="") {
                    $angka=0;
                }else{
                    $angka = substr($rowKodeProdusen[0], strlen($inisial));
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
            <a href="media.php?module=produsen" class="btn btn-primary"><i class="iconsweets-arrowleft iconsweets-white"></i>  &nbsp; Kembali</a>
            <h4 class="widgettitle nomargin shadowed">Tambahkan Data Produsen Baru</h4>  
                <div class="widgetcontent bordered shadowed nopadding">
                    <form id="form1" class="stdform stdform2" method="post" action="media.php?module=produsen&act=add">
                            <p class="control-group">
                                <label class="control-label" for="KodeProdusen">Kode Produsen</label>
                                <span class="field controls"><input type="text" name="KodeProdusen" id="KodeProdusen" class="input-xxlarge" value="<?php echo KdProdusen("produsen","PRDN"); ?>" readonly /></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="NamaProdusen">Nama Produsen</label>
                                <span class="field controls"><input type="text" name="NamaProdusen" id="NamaProdusen" class="input-xxlarge" /></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="AlamatProdusen">Alamat</label>
                                <span class="field controls"><!--<input type="text" name="AlamatProdusen" id="AlamatProdusen" class="input-xxlarge" />--> <textarea cols="80" rows="5" class="span5" name="AlamatProdusen" id="AlamatProdusen"></textarea></span>
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
                        $KodeProdusen = $_POST['KodeProdusen'];
                        $NamaProdusen = $_POST['NamaProdusen'];
                        $AlamatProdusen = $_POST['AlamatProdusen'];
                        $Hp = $_POST['Handphone'];
                        $qry = "INSERT INTO `produsen`(`KodeProdusen`, `NamaProdusen`, `AlamatProdusen`, `TelpProdusen`) VALUES ('$KodeProdusen','$NamaProdusen','$AlamatProdusen','$Hp')";
                        $rs = mysqli_query($mysqli, $qry);
                        if($rs){
                            echo "<script>window.location='media.php?module=produsen'</script>";
                        }
                    }
                    //End aksi simpan
                    ?>
                    
    <!-- TAMBAH PRODUSEN -->
    <?php }elseif ($_GET['act']=="del") {
    ?>
        <!-- DELETE PRODUSEN -->
        <?php
        //Aksi Hapus
            $KodeProdusen = $_GET['KodeProdusen'];
            $qrydel = mysqli_query($mysqli, "DELETE FROM produsen WHERE sha1(KodeProdusen) = '".$KodeProdusen."'");
            if($qrydel){
                echo "<script>window.location='media.php?module=produsen'</script>";
            }
        //End Aksi Hapus
        ?>
        <!-- DELETE PRODUSEN -->
    <?php
    }elseif ($_GET['act']=="edit") {
    ?>
        <!-- EDIT PRODUSEN -->
        <?php if(!empty($_GET['KodeProdusen'])){
            $KodeProdusen = $_GET['KodeProdusen'];
            $qry = "SELECT * FROM produsen WHERE sha1(KodeProdusen) = '$KodeProdusen'";
            $rs = mysqli_query($mysqli, $qry);
            $rw = mysqli_fetch_array($rs);
        ?>
            <a href="media.php?module=produsen" class="btn btn-primary"><i class="iconsweets-arrowleft iconsweets-white"></i>  &nbsp; Kembali</a>
            <h4 class="widgettitle nomargin shadowed">Edit Data Produsen</h4>    
                <div class="widgetcontent bordered shadowed nopadding">
                    <form id="form1" class="stdform stdform2" method="post" action="media.php?module=produsen&act=edit">
                            <p class="control-group">
                                <label class="control-label" for="KodeProdusen">Kode Produsen</label>
                                <span class="field controls"><input type="text" name="KodeProdusen" id="KodeProdusen" class="input-xxlarge" value="<?php echo $rw['KodeProdusen']; ?>" readonly /></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="NamaProdusen">Nama Produsen</label>
                                <span class="field controls"><input type="text" name="NamaProdusen" id="NamaProdusen" class="input-xxlarge" value="<?php echo $rw['NamaProdusen']; ?>" /></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="AlamatProdusen">Alamat</label>
                                <span class="field controls"><textarea cols="80" rows="5" class="span5" name="AlamatProdusen" id="AlamatProdusen"><?php echo $rw['AlamatProdusen']; ?></textarea></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="Handphone">Nomor Handphone</label>
                                <span class="field controls"><input type="text" name="Handphone" id="Handphone" class="input-large" value="<?php echo $rw['TelpProdusen']; ?>" /></span>
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
                $HKodeProdusen = $_POST['KodeProdusen'];
                $NamaProdusen = $_POST['NamaProdusen'];
                $AlamatProdusen = $_POST['AlamatProdusen'];
                $Hp = $_POST['Handphone'];
                $qry = "UPDATE produsen SET NamaProdusen='$NamaProdusen', AlamatProdusen='$AlamatProdusen', TelpProdusen='$Hp' WHERE KodeProdusen='$HKodeProdusen'";
                $rs = mysqli_query($mysqli, $qry);
                if($rs){
                    echo "<script>window.location='media.php?module=produsen'</script>";
                }
            }
            //End aksi simpan
        }else{
            header("location:media.php?module=produsen");
        }
        ?>
        <!-- EDIT PRODUSEN --> 
    <?php } ?>
<?php
}else{
?>
<!--TAMPIL DATA PRODUSEN-->
        <a href="media.php?module=produsen&act=add" class="btn btn-primary"><i class="icon-plus-sign icon-white"></i>  &nbsp; Tambah data produsen</a>
        <h4 class="widgettitle">Daftar Data Produsen</h4>
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
                    <th class="head0">Kode Produsen</th>
                    <th class="head1">Nama Produsen</th>
                    <th class="head0">Alamat</th>
                    <th class="head1">Nomor Handphone</th>
                    <th class="head0"></th>
                </tr>
            </thead>
            <tbody>
                <!--MENAMPILKAN DATA USER-->
                <?php
                    $qry = "SELECT * FROM produsen";
                    $rs = mysqli_query($mysqli, $qry);
                    while ($rw = mysqli_fetch_array($rs)){
                ?>
                <tr class="gradeC">
                    <td><span class="center"><input type="checkbox" /></span></td>
                    <td><?php echo $rw['KodeProdusen']; ?></td>
                    <td><?php echo $rw['NamaProdusen']; ?></td>
                    <td><?php echo $rw['AlamatProdusen']; ?></td>
                    <td><?php echo $rw['TelpProdusen']; ?></td>
                    <td class="centeralign">
                        <a href="media.php?module=produsen&act=edit&KodeProdusen=<?php echo sha1($rw['KodeProdusen']); ?>"><span class="icon-edit"></span></a>
                        <a href="media.php?module=produsen&act=del&KodeProdusen=<?php echo sha1($rw['KodeProdusen']); ?>"><span class="icon-trash"></span></a>
                    </td>
                </tr>
                <?php } ?>
                <!-- Akhir MENAMPILKAN DATA USER -->
            </tbody>
        </table>
<!--TAMPIL DATA PRODUSEN-->
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