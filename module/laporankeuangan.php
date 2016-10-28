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
    <h1>Laporan Keuangan & Grafik Barang</h1>
</div><!--pagetitle-->
<div class="maincontent">
    <div class="contentinner">
<!--TAMPIL DATA PRODUSEN-->
        <h4 class="widgettitle nomargin">Laporan Keuangan dan Grafik Penjualan Barang </h4>
        <table class="table table-bordered">
                    <colgroup>
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                    </colgroup>
                    <thead>
                        <tr>
                            <th>Total Keuangan Pembelian</th>
                            <th>Total Keuangan Penjualan</th>
                            <th>Laba</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $qry = "SELECT
                                    SUM(TotalHrgPembelian) AS TotPembelian
                                    FROM
                                    pembelian
                                    WHERE
                                    pembelian.StatusPembelian = 'L'";
                            $qrypnjualan = "SELECT
                                    SUM(TotalHrgPenjualan) AS TotPenjualan
                                    FROM
                                    penjualan
                                    WHERE
                                    penjualan.StatusPenjualan = 'L'";
                            $rs = mysqli_query($mysqli, $qry);
                            $rw = mysqli_fetch_array($rs);
                            $rspnjualan = mysqli_query($mysqli, $qrypnjualan);
                            $rwpnjualan = mysqli_fetch_array($rspnjualan);
                            $TotPembelian = $rw['TotPembelian'];
                            $TotPenjualan = $rwpnjualan['TotPenjualan'];
                            $Laba = $TotPenjualan - $TotPembelian;
                        ?>
                        <tr>
                            <td><?php echo "Rp. ".$TotPembelian; ?></td>
                            <td><?php echo "Rp. ".$TotPenjualan; ?></td>
                            <td><?php echo "Rp. ".$Laba; ?></td>
                        </tr>
                    </tbody>
        </table>
		<br/>
		<div id='garfik'></div>	
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