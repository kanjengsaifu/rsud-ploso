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
    <h1>User Software Inventori Obat</h1>
</div><!--pagetitle-->
<div class="maincontent">
    <div class="contentinner">
<?php if(isset($_GET['act'])){
    if($_GET['act']=="add"){ ?>
    <!-- TAMBAH KONSUMEN -->
        <?php
            function IdUser($tabel, $inisial){
                require("_koneksi.php");
                $struktur = mysqli_query($mysqli, "SELECT * FROM $tabel");
                $finfo = mysqli_fetch_field_direct($struktur,0);
                $field = $finfo->name;
                $panjang = $finfo->length;//10

                $qry = mysqli_query($mysqli, "SELECT max(".$field.") FROM ".$tabel);
                $rowIdUser = mysqli_fetch_array($qry);
                if ($rowIdUser[0]=="") {
                    $angka=0;
                }else{
                    $angka = substr($rowIdUser[0], strlen($inisial));
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
            <a href="admin.php?module=user" class="btn btn-primary"><i class="iconsweets-arrowleft iconsweets-white"></i>  &nbsp; Kembali</a>
            <h4 class="widgettitle nomargin shadowed">Tambahkan User Baru</h4>  
                <div class="widgetcontent bordered shadowed nopadding">
                    <form id="form1" class="stdform stdform2" method="post" action="admin.php?module=user&act=add">
                            <p class="control-group">
                                <label class="control-label" for="IdUser">Id User</label>
                                <span class="field controls"><input type="text" name="IdUser" id="IdUser" class="input-xxlarge" value="<?php echo IdUser("users","USER"); ?>" readonly /></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="NamaPengguna">Nama User</label>
                                <span class="field controls"><input type="text" name="NamaPengguna" id="NamaPengguna" class="input-xxlarge" /></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="Sandi">Sandi</label>
                                <span class="field controls"><input type="text" name="Sandi" id="Sandi" class="input-xxlarge" /></span>
                            </p>

                            <p class="control-group">
                                <label class="control-label" for="IdLevel">Level User</label>
                                <span class="field controls">
                                    <select name="IdLevel" data-placeholder="Cari Level User" style="width:350px" class="chzn-select" tabindex="2">
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
                            <p class="stdformbutton">
                                <button name="simpan" type="submit" class="btn btn-primary">Simpan</button>
                                <button type="reset" class="btn">Batal</button>
                            </p>
                        </form>
                    </div><!--widgetcontent-->
                    
                    <?php
                    //Aksi Simpan
                    if(isset($_POST['simpan'])){
                        $IdUser = $_POST['IdUser'];
                        $NamaPengguna = $_POST['NamaPengguna'];
                        $pengacak  = "A1B4C2D5E7F3G6HIJKLM";
                        $Sandi = md5($pengacak.md5($pengacak.md5($_POST['Sandi']).$pengacak).$pengacak);
                        $IdLevel = $_POST['IdLevel'];
                        $qry = "INSERT INTO users(IdUser, NamaPengguna, Sandi, IdLevel) VALUES ('$IdUser','$NamaPengguna','$Sandi','$IdLevel')";
                        
                        $rs = mysqli_query($mysqli, $qry);
                        if($rs){
                            echo "<script>window.location='admin.php?module=user'</script>";
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
            $IdUser = $_GET['IdUser'];
            $qrydel = mysqli_query($mysqli, "DELETE FROM users WHERE sha1(IdUser) = '".$IdUser."'");
            if($qrydel){
                echo "<script>window.location='admin.php?module=user'</script>";
            }
        //End Aksi Hapus
        ?>
        <!-- DELETE KONSUMEN -->
    <?php
    }elseif ($_GET['act']=="edit") {
    ?>
        <!-- EDIT KONSUMEN -->
        <?php if(!empty($_GET['IdUser'])){
            $IdUser = $_GET['IdUser'];
            $qry = "SELECT * FROM unitmutasi WHERE sha1(IdUser) = '$IdUser'";
            $rs = mysqli_query($mysqli, $qry);
            $rw = mysqli_fetch_array($rs);
        ?>
            <a href="admin.php?module=user" class="btn btn-primary"><i class="iconsweets-arrowleft iconsweets-white"></i>  &nbsp; Kembali</a>
            <h4 class="widgettitle nomargin shadowed">Edit Data Unit Mutasi</h4>    
                <div class="widgetcontent bordered shadowed nopadding">
                    <form id="form1" class="stdform stdform2" method="post" action="admin.php?module=user&act=edit">
                            <p class="control-group">
                                <label class="control-label" for="IdUser">Id User</label>
                                <span class="field controls"><input type="text" name="IdUser" id="IdUser" class="input-xxlarge" value="<?php echo $rw['IdUser']; ?>" readonly /></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="NamaPengguna">Nama User</label>
                                <span class="field controls"><input type="text" name="NamaPengguna" id="NamaPengguna" class="input-xxlarge" value="<?php echo $rw['NamaPengguna']; ?>" /></span>
                            </p>
                            <p class="control-group">
                                <label class="control-label" for="PJUnit">Penanggung Jawab</label>
                                <span class="field controls"><input type="text" name="PJUnit" id="PJUnit" class="input-xxlarge" value="<?php echo $rw['PJUnit']; ?>" /></span>
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
                $qry = "UPDATE unitmutasi SET NamaUnit='$NamaUnit', PJUnit='$PJUnit', TelpUnit='$TelpUnit' WHERE KdUnit='$HKdUnit'";
                $rs = mysqli_query($mysqli, $qry);
                if($rs){
                    echo "<script>window.location='admin.php?module=user'</script>";
                }
            }
            //End aksi simpan
        }else{
            header("location:admin.php?module=user");
        }
        ?>
        <!-- EDIT KONSUMEN --> 
    <?php } ?>
<?php
}else{
?>
<!--TAMPIL DATA KONSUMEN-->
        <a href="admin.php?module=user&act=add" class="btn btn-primary"><i class="icon-plus-sign icon-white"></i>  &nbsp; Tambah User</a>
        <h4 class="widgettitle">Daftar User Software Inventori Obat</h4>
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
                    <th class="head0">Id User</th>
                    <th class="head1">Nama User</th>
                    <th class="head0">Sandi</th>
                    <th class="head1">Level</th>
                    <th class="head0"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $qry = "SELECT users.*, leveluser.Level FROM users INNER JOIN leveluser ON users.IdLevel=leveluser.IdLevel";
                    $rs = mysqli_query($mysqli, $qry);
                    while ($rw = mysqli_fetch_array($rs)){
                ?>
                <tr class="gradeC">
                    <td><span class="center"><input type="checkbox" /></span></td>
                    <td><?php echo $rw['IdUser']; ?></td>
                    <td><?php echo $rw['NamaPengguna']; ?></td>
                    <td><?php echo $rw['Sandi']; ?></td>
                    <td><?php echo $rw['Level']; ?></td>
                    <td class="centeralign">
                        <a href="admin.php?module=user&act=edit&KdUnit=<?php echo sha1($rw['KdUnit']); ?>"><span class="icon-edit"></span></a>
                        <a href="admin.php?module=user&act=del&IdUser=<?php echo sha1($rw['IdUser']); ?>"><span class="icon-trash"></span></a>
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