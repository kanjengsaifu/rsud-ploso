<?php
session_start();
require("_koneksi.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Software Inventori Obat | RSUD Ploso Jombang</title>
        <link rel="stylesheet" href="css/style.default.css" type="text/css" />
        <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
    </head>

    <body class="loginbody">

        <div class="loginwrapper">
            <div class="loginwrap zindex100 animate2 bounceInDown">
                <h1 class="logintitle"><span class="iconfa-lock"></span> Sistem Persediaan Gudang Obat <span class="subtitle">Silahkan masuk untuk memulai !</span></h1>
		<div class="loginwrapperinner">
                    <form id="loginform" action="index.php?login=1" method="post">
                        <p class="animate4 bounceIn"><input type="text" id="username" name="NamaPengguna" placeholder="ID Pengguna atau Nama Pengguna" autofocus /></p>
                        <p class="animate5 bounceIn"><input type="password" id="password" name="Sandi" placeholder="Sandi" /></p>
                        <p class="animate6 bounceIn"><button class="btn btn-default btn-block">Masuk</button></p>
                        <p class="animate7 fadeIn"><a href="http://portalphantom.blogspot.com/" target="_self">&copy; <?php echo date("Y"); ?> | RSUD Ploso Jombang 2016</a></p>
                    </form>
		</div><!--loginwrapperinner-->
            </div>
            <div class="loginshadow animate3 fadeInUp"></div>
	</div><!--loginwrapper-->

        <script type="text/javascript">
        jQuery.noConflict();

        jQuery(document).ready(function(){

                var anievent = (jQuery.browser.webkit)? 'webkitAnimationEnd' : 'animationend';
                jQuery('.loginwrap').bind(anievent,function(){
                        jQuery(this).removeClass('animate2 bounceInDown');
                });

                jQuery('#username,#password').focus(function(){
                        if(jQuery(this).hasClass('error')) jQuery(this).removeClass('error');
                });

                jQuery('#loginform button').click(function(){
                        if(!jQuery.browser.msie) {
                                if(jQuery('#username').val() == '' || jQuery('#password').val() == '') {
                                        if(jQuery('#username').val() == '') jQuery('#username').addClass('error'); else jQuery('#username').removeClass('error');
                                        if(jQuery('#password').val() == '') jQuery('#password').addClass('error'); else jQuery('#password').removeClass('error');
                                        jQuery('.loginwrap').addClass('animate0 wobble').bind(anievent,function(){
                                                jQuery(this).removeClass('animate0 wobble');
                                        });
                                } else {
                                        jQuery('.loginwrapper').addClass('animate0 fadeOutUp').bind(anievent,function(){
                                                jQuery('#loginform').submit();
                                        });
                                }
                                return false;
                        }
                });
        });
        </script>
    </body>
</html>
<!--Cek Login-->
<?php
if(isset($_GET['login'])){
        if(!empty($_POST['NamaPengguna']) and !empty($_POST['Sandi'])){
            $NamaPengguna = $_POST['NamaPengguna'];
            //$Sandi = $_POST['Sandi'];
            $pengacak  = "A1B4C2D5E7F3G6HIJKLM";
            $Sandi = md5($pengacak.md5($pengacak.md5($_POST['Sandi']).$pengacak).$pengacak);
            $qry = "SELECT * FROM users WHERE IdUser = '$NamaPengguna' OR NamaPengguna = '$NamaPengguna' AND Sandi = '$Sandi'";
            $rs = mysqli_query($mysqli, $qry);
            $rw = mysqli_fetch_array($rs);
            if(($NamaPengguna == $rw['IdUser'] or $NamaPengguna == $rw['NamaPengguna']) and $Sandi == $rw['Sandi'] and $rw['IdLevel'] == 1 ){
                $_SESSION['IdUser'] = $rw['IdUser'];
                $_SESSION['NamaPengguna'] = $rw['NamaPengguna'];
                $_SESSION['Sandi'] = $rw['Sandi'];
                $_SESSION['Level'] = $rw['IdLevel'];
                //header("location:media.php?module=home");
                header("location:admin.php?module=home");
            }elseif (($NamaPengguna == $rw['IdUser'] or $NamaPengguna == $rw['NamaPengguna']) and $Sandi == $rw['Sandi'] and $rw['IdLevel'] == 2) {
                $_SESSION['IdUser'] = $rw['IdUser'];
                $_SESSION['NamaPengguna'] = $rw['NamaPengguna'];
                $_SESSION['Sandi'] = $rw['Sandi'];
                $_SESSION['Level'] = $rw['IdLevel'];
                header("location:media.php?module=home");
            }elseif (($NamaPengguna == $rw['IdUser'] or $NamaPengguna == $rw['NamaPengguna']) and $Sandi == $rw['Sandi'] and $rw['IdLevel'] == 3) {
                $_SESSION['IdUser'] = $rw['IdUser'];
                $_SESSION['NamaPengguna'] = $rw['NamaPengguna'];
                $_SESSION['Sandi'] = $rw['Sandi'];
                $_SESSION['Level'] = $rw['IdLevel'];
                header("location:media.php?module=home");
            }elseif (($NamaPengguna == $rw['IdUser'] or $NamaPengguna == $rw['NamaPengguna']) and $Sandi == $rw['Sandi'] and $rw['IdLevel'] == 4) {
                $_SESSION['IdUser'] = $rw['IdUser'];
                $_SESSION['NamaPengguna'] = $rw['NamaPengguna'];
                $_SESSION['Sandi'] = $rw['Sandi'];
                $_SESSION['Level'] = $rw['IdLevel'];
                header("location:unitapotik.php?module=home");
            }elseif (($NamaPengguna == $rw['IdUser'] or $NamaPengguna == $rw['NamaPengguna']) and $Sandi == $rw['Sandi'] and $rw['IdLevel'] == 5) {
                $_SESSION['IdUser'] = $rw['IdUser'];
                $_SESSION['NamaPengguna'] = $rw['NamaPengguna'];
                $_SESSION['Sandi'] = $rw['Sandi'];
                $_SESSION['Level'] = $rw['IdLevel'];
                header("location:unitumum.php?module=home");            
            }else{
                header("location:index.php");
            }
        }
}
?>
<!--End Cek Login-->