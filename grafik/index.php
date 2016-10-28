<html>
	<head>
	<script src="js/jquery.min.js" type="text/javascript"></script>
    <script src="js/highcharts.js" type="text/javascript"></script>
    <script type="text/javascript">
	
	var chart1;
	$(document).ready(function() {
		chart1 = new Highcharts.Chart({
			chart: {
            	renderTo: 'garfik',
	            type: 'column'
    	    },   
        	title: {
            	text: 'Grafik Barang yang Terjual '
	        },
    	    xAxis: {
        	    categories: ['Barang']
	        },
    	    yAxis: {
        	    title: {
            	text: 'Barang Keluar'
            }
        },
		series:             
            
			[
				<?php 
				include "../_koneksi.php";	//memanggil koneksi
				$sql = "SELECT * FROM barang where BarangKeluar > 0";
				$rs = mysqli_query($mysqli, $sql);
				while ($data = mysqli_fetch_array($rs)) {
					$namabarang = $data['NamaBarang'];
					$jumlah = $data['BarangKeluar'];
					
				?>
					{
						name: '<?php echo $namabarang; ?>',
						data: [<?php echo $jumlah; ?>]
					},
				<?php
				}
				?>
            ]
		});
	});	
</script>

	</head>
	<body>
		<div id='garfik'></div>		
	</body>
</html>
