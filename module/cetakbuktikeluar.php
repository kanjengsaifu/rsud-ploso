<?php
 // Define relative path from this script to mPDF
 $nama_dokumen='Formulir Booking Sunrisedive'; //Beri nama file PDF hasil.
define('_MPDF_PATH','../MPDF60/');
include(_MPDF_PATH . "mpdf.php");
$mpdf=new mPDF('utf-8', 'A4-L'); // Create new mPDF Document

//Beginning Buffer to save PHP variables and HTML tags
ob_start();
?>
<!--sekarang Tinggal Codeing seperti biasanya. HTML, CSS, PHP tidak masalah.-->
<!--CONTOH Code START-->

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>
        table, th, td {
            
            border-collapse: collapse;
            border-spacing: 10px;
            font-family: verdana;
            font-size: 13px;
        }            
        th,td {
            padding: 4px;
        }
    </style>
</head>
<body>
<img src="../img/koprsudploso.png">
<p><b>TANDA BUKTI BARANG KELUAR</b></p>
<?php session_start();
include '../_koneksi.php';
$qs = mysqli_query($mysqli, "SELECT * from v_transaksigudang where NoTrans = 'TRNMSI0004'");
$rs = mysqli_fetch_array($qs);
?>
	<table border='0'>
	<tr>
		<td>Nomor </td>
		<td>:</td>
		<td><?php echo $rs['NoTrans']; ?></td>
	</tr>
	<tr>
		<td>Dari</td>
		<td>:</td>
		<td><?php echo $rs['Dari']; ?></td>
	</tr>
	<tr>
		<td>Kepada</td>
		<td>:</td>
		<td><?php echo $rs['Unit']; ?></td>
	</tr>
	<tr>
		<td>Tanggal</td>
		<td>:</td>
		<td><?php echo $rs['TglMut']; ?></td>
	</tr>
	</table>
<p></p>
	<table border='1' class='table'>
      <thead>
            <tr>
                <th  width="30"><center>No</center></th>
                <th  width="300"><center>Nama Obat</center></th>
                <th  width="100"><center>Satuan</center></th>
                <th  width="100"><center>Harga<br>Satuan</center></th>
                <th  width='100'><center>Permintaan </center></th>
                <th  width='100'><center>Pemberian</center></th>
                <th  width="120"><center>Jumlah<br>Harga</center></th>              
                <th width="180"><center>Ket</center></th>
              </tr>
      </thead>
      <tbody>
      <?php
      	$qs2 = mysqli_query($mysqli, "SELECT * from v_transaksigudang where NoTrans = 'TRNMSI0004'");
		while ($rs2 = mysqli_fetch_array($qs2)) {
			echo "
         <tr>
            <td><center></center></td>
            <td>".$rs2['Obat']."</td>
            <td><center>".$rs2['Satuan']."</center></td>
            <td>Rp. ".$rs2['HrgSatuan']."</td>
            <td><center>".$rs2['Pemberian']."</center></td>
            <td><center>".$rs2['Pemberian']."</center></td>
            <td align='right'>Rp. ".$rs2['JumHrg']."</td>
            <td><center>".$rs2['Ket'].", ".$rs2['Batch']."</center></td>
          </tr>";
		}
       ?>
          <tr>
          	 <?php
      			$qs3 = mysqli_query($mysqli, "SELECT SUM(JumHrg) AS Total from v_transaksigudang where NoTrans = 'TRNMSI0004'");
      			$rs3 = mysqli_fetch_array($qs3);
      		?>
            <td colspan="6"><center>Jumlah Total</center></td>
            
            <td align='right'><?php echo "Rp. ".$rs3['Total']; ?></td>
            <td><center></center></td>
          </tr>
   	</table>
   	<p></p>

   	<table border='0' >
	<tr>
		<td width="500px">Mengetahui / menyetujui </td>
		<td width="500px">Yang Menyerahkan</td>
		<td width="500px">Yang Menerima</td>
	</tr>
	<tr>
		<td>Kepala Instalasi</td>
		<td>Petugas Gudang Obat</td>
		<td></td>

	</tr>
	<tr>
		<td><br><br><br><br><br><br></td>
		<td><br><br><br><br><br><br></td>
		<td><br><br><br><br><br><br></td>
	</tr>
	<tr>
		<td>Aridhina Yunita Rahma S Farm,. Apt</td>
		<td>Nama</td>
		<td><?php echo $rs['Menerima']; ?></td>
	</tr>
	<tr>
		<td>NIP 19840614 201101 2 007</td>
		<td>NIP</td>
		<td>NIP</td>
	</tr>
	</table>
</body>
</html>
<?php
$html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
ob_end_clean();
//Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
$mpdf->WriteHTML(utf8_encode($html));
$mpdf->Output($nama_dokumen.".pdf" ,'I');
exit;
?>