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
    <h1>Transaksi Mutasi</h1>
</div><!--pagetitle-->
<div class="maincontent">
    <div class="contentinner">
<?php if(isset($_GET['act'])){
    if($_GET['act']=="add"){ ?>
    <!-- TAMBAH TRANSAKSI PENJUALAN -->
        <?php
            function NoPenjualan($tabel, $inisial){
                require("_koneksi.php");
                $struktur = mysqli_query($mysqli, "SELECT * FROM $tabel");
                $finfo = mysqli_fetch_field_direct($struktur,0);
                $field = $finfo->name;
                $panjang = $finfo->length;//10

                $qry = mysqli_query($mysqli, "SELECT max(".$field.") FROM ".$tabel);
                $rowNoPenjualan = mysqli_fetch_array($qry);
                if ($rowNoPenjualan[0]=="") {
                    $angka=0;
                }else{
                    $angka = substr($rowNoPenjualan[0], strlen($inisial));
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
            function IdBrgDijual($tabel, $inisial){
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
        <a href="media.php?module=transpenjualan" class="btn btn-primary"><i class="iconsweets-arrowleft iconsweets-white"></i>  &nbsp; Kembali</a>
        <h4 class="widgettitle nomargin shadowed">Menambahkan Obat Pada Transaksi Mutasi</h4>
        <div class="widgetcontent bordered shadowed nopadding">
            <form id="form1" class="stdform stdform2" method="POST" action="media.php?module=transpenjualan&act=add">
                <?php 
                $IdBrgDijual = IdBrgDijual("barangdijual", "BRDJ");
                $NoPenjualan = NoPenjualan("penjualan", "TRNSJ");
                ?>
                <input type="hidden" name="IdBarangDijual" value="<?php echo $IdBrgDijual; ?>" />
                <input type="hidden" name="NoPenjualan" value="<?php echo $NoPenjualan; ?>" />
                
                
                <?php
                //UPDATE BarangKeluar.Tbarang
                            $qrytmplbrg = mysqli_query($mysqli, "SELECT KodeBarang FROM barang");
                            while ($rwqrytmlpbrg = mysqli_fetch_array($qrytmplbrg)){
                                $TKodeBarang = $rwqrytmlpbrg['KodeBarang'];
                                $qryjmlbrgdjl = mysqli_query($mysqli, "SELECT
                                        SUM(barangdijual.JmlBrgDijual) AS TotJmlBrgDijual
                                        FROM
                                        barang
                                        INNER JOIN barangdijual ON barang.KodeBarang = barangdijual.KodeBarang
                                        WHERE barangdijual.KodeBarang = '".$TKodeBarang."'");
                                $rwqryjmlbrgdjl = mysqli_fetch_array($qryjmlbrgdjl);
                                $TotJmlBrgDijual = $rwqryjmlbrgdjl['TotJmlBrgDijual'];
                                $updatebrgklrBarang = mysqli_query($mysqli, "UPDATE barang SET BarangKeluar = '".$TotJmlBrgDijual."' WHERE KodeBarang = '".$TKodeBarang."'");
                            }
                            //END UPDATE BarangKeluar.Tbarang
                            //UPDATE STOK Tersedia
                $qrytampilbrg = mysqli_query($mysqli, "SELECT KodeBarang, BarangMasuk, BarangKeluar FROM barang");
                while ($rstampilbrg = mysqli_fetch_array($qrytampilbrg)){
                    $KodeBarang = $rstampilbrg['KodeBarang'];
                    $BrgMasuk = $rstampilbrg['BarangMasuk'];
                    $BrgKeluar = $rstampilbrg['BarangKeluar'];
                    $StokTersedia = $BrgMasuk - $BrgKeluar;
                    $qryupstoktersediabrg = mysqli_query($mysqli, "UPDATE barang SET StokTersedia = '".$StokTersedia."' WHERE KodeBarang = '".$KodeBarang."'");
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
                            <th class="head1">Jumlah</th>
                            <th class="head1">Diskon</th>
                            <th class="head1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select data-placeholder="Cari Nama Barang" class="chzn-select" style="width:400px" tabindex="2" name="KodeBarang">
                                    <option value=""></option>
                                    <?php
                                    $qrybarang = mysqli_query($mysqli, "SELECT * FROM barang");
                                    while($rwbarang=mysqli_fetch_array($qrybarang))
                                    {
                                    ?>
                                        <option value="<?php echo $rwbarang['KodeBarang']; ?>"><?php echo $rwbarang['NamaBarang'];?> (harga Rp. <?php echo $rwbarang['HrgJual'];?>) Stok <?php echo $rwbarang['StokTersedia']==0?"habis":"$rwbarang[StokTersedia]"; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </td>
                            <td><input type="text" name="JmlBrgDijual" id="JmlBrgDijual" class="input-medium" value="1"/></td>
                            <td><span class="input-prepend input-append"><span class="add-on">Rp. </span><input type="text" name="DiskonBrgDijual" id="DiskonBrgDijual" class="input-medium" value="0" /></span></td>
                            <td class="center"><button name="tambahkan" type="submit" class="btn btn-primary">Tambahkan</button></td>
                        </tr>
                    </tbody>
                </table>
            </form>
            
            <!-- AKSI TAMBAH BRG -->
            <?php
            //ADD BARANG DIJUAL KE TRANSAKSI
                    if(isset($_POST['tambahkan'])){
                        $KodeBarang = $_POST['KodeBarang'];
                        $JmlBrgDijual = $_POST['JmlBrgDijual'];
                        $qrytampilbrg = mysqli_query($mysqli, "SELECT NamaBarang, StokTersedia FROM barang WHERE KodeBarang = '".$KodeBarang."'");
                        $rstampilbrg = mysqli_fetch_array($qrytampilbrg);
                        $NamaBarang = $rstampilbrg['NamaBarang'];
                        $StokTersedia = $rstampilbrg['StokTersedia'];
                        if($JmlBrgDijual <= $StokTersedia){
                            $IdBarangDijual = $_POST['IdBarangDijual'];
                            $NoPenjualan = $_POST['NoPenjualan'];
                            $DiskonBrgDijual = $_POST['DiskonBrgDijual'];
                            $qrybarang = mysqli_query($mysqli, "SELECT HrgJual FROM barang WHERE KodeBarang = '$KodeBarang'");
                            $rsbrg = mysqli_fetch_array($qrybarang);
                            $HrgBrg = $rsbrg['HrgJual'];
                            $TotHrgBrgDijual = ($JmlBrgDijual * $HrgBrg) - $DiskonBrgDijual;
                            $qrybrgdjl = "INSERT INTO barangdijual(IdBarangDijual, NoPenjualan, KodeBarang, JmlBrgDijual, DiskonBrgDijual, TotHrgBrgDijual) VALUES ('$IdBarangDijual','$NoPenjualan','$KodeBarang','$JmlBrgDijual','$DiskonBrgDijual','$TotHrgBrgDijual')";
                            $rsbrgdjl = mysqli_query($mysqli, $qrybrgdjl);
                            if($rsbrgdjl){
                                echo "<script>window.location='media.php?module=transpenjualan&act=add'</script>";
                            }
                        }else{
                            echo("<script>alert('Jumlah stok tersedia $NamaBarang tidak mencukupi. Lihat Stok Terkini!. Dan lakukan transaksi pembelian barang.')</script>");
                            echo "<script>window.location='media.php?module=transpenjualan&act=add'</script>";
                        }   
                    }//end tambahkan
                    //ADD BARANG DIJUAL KE TRANSAKSI
                    
                    if(isset($_GET['barangdijualdel']) AND !empty($_GET['IdBarangDijual'])){
                        $IdBarangDijualdel = $_GET['IdBarangDijual'];
                        $qrybrgdijualdel = mysqli_query($mysqli, "DELETE FROM barangdijual WHERE IdBarangDijual = '".$IdBarangDijualdel."'");
                        if($qrybrgdijualdel){
                            echo "<script>window.location='media.php?module=transpenjualan&act=add'</script>";
                        }
                    }
                    ?>
            <!-- END AKSI TAMBAH BRG -->
            
        </div>
        <h4 class="widgettitle nomargin shadowed">Transaksi Mutasi Obat</h4>   
        <div class="widgetcontent bordered shadowed nopadding">
            <form id="form1" class="stdform stdform2" method="post" action="media.php?module=transpenjualan&act=add">
                <p class="control-group">
                    <label class="control-label" for="NoPenjualan">No.Transaksi</label>
                    <span class="field controls"><input type="text" name="NoPenjualan" id="NoPenjualan" class="input-xxlarge" value="<?php echo $NoPenjualan; ?>" readonly /></span>
                </p>
                <p class="control-group">
                    <label class="control-label" for="NamaKonsumen">Nama Unit</label>
                    <span class="field controls">
                        <select name="KodeKonsumen" data-placeholder="Cari Nama Konsumen" style="width:350px" class="chzn-select" tabindex="2">
                            <option value=""></option>
                            <?php
                            $qrykonsumen = "SELECT * FROM konsumen";
                            $rskonsumen = mysqli_query($mysqli, $qrykonsumen);
                            while ($rwkonsumen = mysqli_fetch_array($rskonsumen)){
                            ?>
                            <option value="<?php echo $rwkonsumen['KodeKonsumen'];?>"><?php echo $rwkonsumen['NamaKonsumen']; ?></option>
                            <?php } ?>
                        </select>
                    </span>
                </p>
                <p class="control-group">
                    <label class="control-label" for="TglPenjualan">Tanggal Mutasi</label>
                    <span class="field controls"><input id="datepicker" type="text" name="TglPenjualan" class="input-small" /> &nbsp; <small><em>bulan / tanggal / tahun</em></small></span>                 
                </p>
                <p class="control-group">
                    <label class="control-label" for="BatasTglPengiriman">Batas Tanggal Pengiriman</label>
                    <span class="field controls"><input id="datepicker1" type="text" name="BatasTglPengiriman" class="input-small" /> &nbsp; <small><em>bulan / tanggal / tahun</em></small></span>
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
                            <th class="head1">Diskon</th>
                            <th class="head0">Sub Total</th>
                            <th class="head1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            
                            $qrybdjl = "SELECT
barang.NamaBarang AS Barang,
barangdijual.JmlBrgDijual AS Jumlah,
barang.HrgJual AS Harga,
barangdijual.IdBarangDijual AS IdBarangDijual,
barangdijual.DiskonBrgDijual AS Diskon,
barangdijual.TotHrgBrgDijual AS TotalHrgItem
FROM
barangdijual
INNER JOIN barang ON barang.KodeBarang = barangdijual.KodeBarang
WHERE
barangdijual.NoPenjualan = '$NoPenjualan'";
                            $rsbdjl = mysqli_query($mysqli, $qrybdjl);
                            $no = 1;
                            while ($rwbdjl = mysqli_fetch_array($rsbdjl)){
                        ?>
                        <tr>
                            <td class="center"><?php echo $no; ?></td>
                            <td><?php echo $rwbdjl['Barang'];?></td>
                            <td><?php echo $rwbdjl['Jumlah'];?></td>
                            <td><?php echo "Rp. ".$rwbdjl['Harga'];?></td>
                            <td><?php echo "Rp. ".$rwbdjl['Diskon'];?></td>
                            <td><?php echo "Rp. ".$rwbdjl['TotalHrgItem'];?></td>
                            <td class="center"><a href="media.php?module=transpenjualan&act=add&barangdijualdel=1&IdBarangDijual=<?php echo $rwbdjl['IdBarangDijual']; ?>" class="btn btn-danger"><i class="iconsweets-trashcan iconsweets-white"></i></a></td>
                        </tr>
                            <?php 
                            $no++;
                            } ?>
                        <tr>
                            <td class="center" colspan="5"><b>Total</b></td>
                            <?php
                            $qrytotalpenjualan = mysqli_query($mysqli, "SELECT SUM(TotHrgBrgDijual) AS Total FROM barangdijual WHERE NoPenjualan='$NoPenjualan'");
                            $rstotal =  mysqli_fetch_array($qrytotalpenjualan);
                            ?>
                            <td colspan="2"><span class="input-prepend input-append"><span class="add-on">Rp. </span><input type="text" name="TotalHrgPenjualan" id="TotalHrgPenjualan" class="input-medium" value="<?php echo $rstotal['Total'] ; ?>" readonly /></span></td>
                            
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
                        $NoPenjualan = $_POST['NoPenjualan'];
                        $KodeKonsumen = $_POST['KodeKonsumen'];
                        $TglPenjualan = date("Y-m-d", strtotime($_POST['TglPenjualan']));
                        $BatasTglPengiriman = date("Y-m-d", strtotime($_POST['BatasTglPengiriman']));
                        $TotalHrgPenjualan = $_POST['TotalHrgPenjualan'];
                        $qry = "INSERT INTO penjualan(NoPenjualan, KodeKonsumen, TglPenjualan, BatasTglPengiriman, TotalHrgPenjualan) VALUES ('$NoPenjualan','$KodeKonsumen','$TglPenjualan','$BatasTglPengiriman','$TotalHrgPenjualan')";
                        $rs = mysqli_query($mysqli, $qry);
                        if($rs){
                            echo "<script>window.location='media.php?module=transpenjualan'</script>";
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
        <!-- EDIT PENJUALAN -->
        <?php if(!empty($_GET['NoPenjualan'])){
            $NoPenjualan = $_GET['NoPenjualan'];
            $qrypenjualantamup = "SELECT * FROM penjualan WHERE NoPenjualan = '$NoPenjualan'";
            $rspenjualantamup = mysqli_query($mysqli, $qrypenjualantamup);
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
        <h4 class="widgettitle nomargin shadowed">Edit Obat Pada Transaksi Mutasi</h4>
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
                            <th class="head0">Obat</th>
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
        <h4 class="widgettitle nomargin shadowed">Edit Transaksi Mutasi</h4>   
        <div class="widgetcontent bordered shadowed nopadding">
            <form id="form1" class="stdform stdform2" method="post" action="media.php?module=transpembelian&act=edit&NoPembelian=<?php echo $NoPembelian;?>">
                <p class="control-group">
                    <label class="control-label" for="NoPembelian">No.Transaksi</label>
                    <span class="field controls"><input type="text" name="NoPembelian" id="NoPembelian" class="input-xxlarge" value="<?php echo $NoPembelian; ?>" readonly /></span>
                </p>
                <p class="control-group">
                    <label class="control-label" for="NamaProdusen">Unit</label>
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
                    <label class="control-label" for="TglPembelian">Tanggal Mutasi</label>
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
                            <th class="head0">Obat</th>
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
<!--TAMPIL DATA TRANSAKSI PENJUALAN-->
        <a href="media.php?module=transpenjualan&act=add" class="btn btn-primary"><i class="icon-plus-sign icon-white"></i>  &nbsp; Tambah transaksi mutasi</a>
        <h4 class="widgettitle">Daftar Data Transaksi Mutasi Obat</h4>
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
                    <th class="head1">Batas Tanggal Pengiriman <small><em>(thn/bln/tgl)</em></small></th>
                    <th class="head0">Total</th>
                    <th class="head1">Status</th>
                    <th class="head0"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $qry = "SELECT
penjualan.NoPenjualan AS NoTransPen,
konsumen.NamaKonsumen AS Konsumen,
penjualan.TglPenjualan AS TglJual,
penjualan.BatasTglPengiriman AS TglBatPengiriman,
penjualan.TotalHrgPenjualan AS Totalpen,
penjualan.StatusPenjualan AS Statuspen
FROM
penjualan
INNER JOIN konsumen ON konsumen.KodeKonsumen = penjualan.KodeKonsumen
";
                    $rs = mysqli_query($mysqli, $qry);
                    while ($rw = mysqli_fetch_array($rs)){
                        if($rw['Statuspen']=="B"){
                            $statuspen = "balum diterima";
                            $warna = "#f0ad4e";
                        }elseif ($rw['Statuspen']=="L") {
                            $statuspen = "diterima";
                            $warna = "none";
                        }elseif($rw['Statuspen']=="T"){
                            $statuspen = "ditolak";
                            $warna = "#d9534f";
                        }
                ?>
                <tr class="gradeC">
                    <td><span class="center"><input type="checkbox" /></span></td>
                    <td><?php echo $rw['NoTransPen']; ?></td>
                    <td><?php echo $rw['Konsumen']; ?></td>
                    <td><?php echo $rw['TglJual']; ?></td>
                    <td><?php echo $rw['TglBatPengiriman']; ?></td>
                    <td><?php echo "Rp. ".$rw['Totalpen']; ?></td>
                    <td style="background-color: <?php echo $warna; ?>;"><?php echo $statuspen; ?></td>
                    <td class="centeralign">
                        <a href="media.php?module=transpenjualan&act=del&NoPenjualan=<?php echo sha1($rw['NoTransPen']); ?>"><span class="icon-trash"></span></a>
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