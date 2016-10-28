<div class="leftmenu">        
    <ul class="nav nav-tabs nav-stacked">  
        <li><a href="dashboard.php"><span class="icon-align-justify"></span>Beranda</a></li>
        <!-- MENU ADMIN -->
        <?php
        if($_SESSION['Bagian']=="admin"){
        ?>
        <li class="dropdown"><a href="#"><span class="icon-pencil"></span>Sistem</a>
            <ul>
                <li><a href="?bagian=admin&page=pengguna">Manajemen Pengguna</a></li>
            </ul>
        </li>
        <!-- END MENU ADMIN -->
        <?php
        }else if($_SESSION['Bagian']=="pembelian"){
        ?>
        <!-- MENU PEMBELIAN -->
        <li class="dropdown"><a href="#"><span class="icon-th-list"></span>Tabel Master</a>
            <ul>
                <li><a href="?bagian=pembelian&page=barang">Barang</a></li>
                <li><a href="?bagian=pembelian&page=produsen">Produsen</a></li>
            </ul>
        </li>
        <li class="dropdown"><a href="#"><span class="icon-th-list"></span>Pembelian</a>
            <ul>
                <li><a href="?bagian=pembelian&page=pesanan">Pesanan Pembelian</a></li>
                <li><a href="?bagian=pembelian&page=produsen">Pembayaran</a></li>
            </ul>
        </li>
        <li><a href="?bagian=pembelian&page=konsumen">Stok Terkini</a></li>
        <!-- END MENU PEMBELIAN -->
        <?php
        }else if($_SESSION['Bagian']=="penjualan"){
        ?>
        <!-- MENU PENJUALAN -->
        <li class="dropdown"><a href="#"><span class="icon-th-list"></span>Tabel Master</a>
            <ul>
                <li><a href="?bagian=pembelian&page=konsumen">Konsumen</a></li>
            </ul>
        </li>
        <li class="dropdown"><a href="#"><span class="icon-th-list"></span>Tabel Master</a>
            <ul>
                <li><a href="?bagian=pembelian&page=konsumen">Konsumen</a></li>
            </ul>
        </li>
        <li class="dropdown"><a href="#"><span class="icon-th-list"></span>Penjualan</a>
            <ul>
                <li><a href="?bagian=pembelian&page=konsumen">Pesanan Penjualan</a></li>
                <li><a href="?bagian=pembelian&page=konsumen">Pembayaran</a></li>
            </ul>
        </li>
        <li><a href="?bagian=pembelian&page=konsumen">Stok Terkini</a></li>
        <!-- END MENU PENJUALAN -->
        <?php
        }else if($_SESSION['Bagian']=="pimpinan"){
        ?>
        <!-- MENU PIMPINAN -->
        
        <!-- END MENU PIMPINAN -->
        <?php
        }
        ?>
   </ul>
</div><!--leftmenu-->