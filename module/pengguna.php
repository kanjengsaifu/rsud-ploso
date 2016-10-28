<!--CEK LOGIN-->
<?php
if(isset($_SESSION['NamaPengguna']) or isset($_SESSION['IdUser']) and isset($_SESSION['Sandi']) and isset($_SESSION['Level'])){
    require("_koneksi.php");
    $IdUser = $_SESSION['IdUser'];
    $Level = $_SESSION['Level'];
    $NamaPengguna = $_SESSION['NamaPengguna'];
    $Sandi = $_SESSION['Sandi'];
    $qry = "SELECT * FROM users WHERE IdUser = '$IdUser' OR NamaPengguna = '$NamaPengguna' AND Sandi = '$Sandi' AND IdLevel = '$Level'";
    $rs = mysqli_query($mysqli, $qry);
    $rw = mysqli_fetch_array($rs);
    if(( $IdUser == $rw['IdUser'] OR $NamaPengguna == $rw['NamaPengguna'] ) and $Sandi == $rw['Sandi'] and $Level == $rw['IdLevel']){
?>
<!--CEK LOGIN-->

<div class="pagetitle">
                    <h1>Pengguna</h1>
                </div><!--pagetitle-->
                
                <div class="maincontent">
                    <div class="contentinner">
                        <div class="row-fluid">
                            <div class="span12">
                                <a href="media.php?module=home" class="btn btn-primary"><i class="iconsweets-arrowleft iconsweets-white"></i>  &nbsp; Kembali</a>
                                <h4 class="widgettitle nomargin shadowed">Update Data Pengguna</h4>
                <div class="widgetcontent bordered shadowed nopadding">
                    <?php
                     $qryuser = mysqli_query($mysqli, "SELECT * FROM users");
                     $rs = mysqli_fetch_array($qryuser);
                    ?>
                    <form name="TambahPengguna" class="stdform stdform2" method="post" action="media.php?module=pengguna&act=1">
                            <p>
                                <label>Nama Pengguna</label>
                                <span class="field"><input type="text" name="NamaPengguna" id="firstname2" class="input-xxlarge" value="<?php echo $rw['NamaPengguna']; ?>" /></span>
                            </p>
                            <p>
                                <label>Sandi</label>
                                <span class="field"><input type="password" name="Sandi" id="lastname2" class="input-xxlarge" required /></span>
                            </p>                      
                            <p class="stdformbutton">
                                <button name="simpan" type="submit" class="btn btn-primary">Simpan</button>
                                <button name="hapus" type="reset" class="btn">Batal</button>
                            </p>
                        </form>
<!--- Aksi Input -->

<?php
if(isset($_GET['act'])){
    require("_koneksi.php");
    $NamaPengguna = $_POST['NamaPengguna'];
    $pengacak  = "A1B4C2D5E7F3G6HIJKLM";
    $Sandi = md5($pengacak.md5($pengacak.md5($_POST['Sandi']).$pengacak).$pengacak);
    $qry = "UPDATE users SET NamaPengguna='$NamaPengguna', Sandi='$Sandi' WHERE IdUser = '$IdUser'";
    $rs = mysqli_query($mysqli, $qry);
    if($rs){
        echo "<script>window.location='logout.php'</script>";
    }
}
?>

<!-- End -->
                    </div><!--widgetcontent-->
                            </div><!--span12-->
                        </div><!--row-fluid-->
                    </div><!--contentinner-->
                </div><!--maincontent-->
    </body>

</html>

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