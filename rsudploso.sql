-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 28 Okt 2016 pada 06.20
-- Versi Server: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rsudploso`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `KodeBarang` varchar(15) NOT NULL,
  `NamaBarang` varchar(20) NOT NULL,
  `Satuan` varchar(15) NOT NULL,
  `Batch` varchar(20) NOT NULL,
  `HrgBeli` int(11) NOT NULL,
  `HrgJual` int(11) NOT NULL,
  `BarangMasuk` int(11) NOT NULL,
  `BarangKeluar` int(11) NOT NULL,
  `StokMinimum` int(11) NOT NULL,
  `StokTersedia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`KodeBarang`, `NamaBarang`, `Satuan`, `Batch`, `HrgBeli`, `HrgJual`, `BarangMasuk`, `BarangKeluar`, `StokMinimum`, `StokTersedia`) VALUES
('BRNG000001', 'Radio', 'unit', '', 25000, 30000, 90, 83, 10, 7),
('BRNG000002', 'Televisi Politron', 'unit', '', 200000, 250000, 40, 37, 10, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barangdibeli`
--

CREATE TABLE `barangdibeli` (
  `IdBarangDibeli` varchar(10) NOT NULL,
  `NoPembelian` varchar(15) NOT NULL,
  `KodeBarang` varchar(10) NOT NULL,
  `JmlBrgDibeli` int(11) NOT NULL,
  `DiskonBrgDibeli` int(11) NOT NULL,
  `TotHrgBrgDibeli` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `barangdibeli`
--

INSERT INTO `barangdibeli` (`IdBarangDibeli`, `NoPembelian`, `KodeBarang`, `JmlBrgDibeli`, `DiskonBrgDibeli`, `TotHrgBrgDibeli`) VALUES
('BRDB000001', 'TRNSB0000000001', 'BRNG000001', 20, 2000, 498000),
('BRDB000002', 'TRNSB0000000001', 'BRNG000002', 20, 50000, 3950000),
('BRDB000003', 'TRNSB0000000002', 'BRNG000001', 50, 50000, 1200000),
('BRDB000004', 'TRNSB0000000003', 'BRNG000001', 20, 0, 500000),
('BRDB000005', 'TRNSB0000000004', 'BRNG000002', 3, 0, 600000),
('BRDB000006', 'TRNSB0000000004', 'BRNG000002', 10, 0, 2000000),
('BRDB000007', 'TRNSB0000000005', 'BRNG000002', 7, 0, 1400000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `barangdijual`
--

CREATE TABLE `barangdijual` (
  `IdBarangDijual` varchar(10) NOT NULL,
  `NoPenjualan` varchar(15) NOT NULL,
  `KodeBarang` varchar(10) NOT NULL,
  `JmlBrgDijual` int(11) NOT NULL,
  `DiskonBrgDijual` int(11) NOT NULL,
  `TotHrgBrgDijual` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `barangdijual`
--

INSERT INTO `barangdijual` (`IdBarangDijual`, `NoPenjualan`, `KodeBarang`, `JmlBrgDijual`, `DiskonBrgDijual`, `TotHrgBrgDijual`) VALUES
('BRDJ000001', 'TRNSJ0000000001', 'BRNG000001', 9, 0, 270000),
('BRDJ000002', 'TRNSJ0000000002', 'BRNG000001', 5, 0, 150000),
('BRDJ000003', 'TRNSJ0000000003', 'BRNG000001', 56, 0, 1680000),
('BRDJ000004', 'TRNSJ0000000003', 'BRNG000002', 20, 0, 5000000),
('BRDJ000005', 'TRNSJ0000000005', 'BRNG000002', 3, 0, 750000),
('BRDJ000006', 'TRNSJ0000000006', 'BRNG000001', 13, 0, 390000),
('BRDJ000007', 'TRNSJ0000000006', 'BRNG000002', 2, 0, 500000),
('BRDJ000008', 'TRNSJ0000000007', 'BRNG000002', 12, 0, 3000000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `konsumen`
--

CREATE TABLE `konsumen` (
  `KodeKonsumen` varchar(10) NOT NULL,
  `NamaKonsumen` varchar(50) NOT NULL,
  `PenanggungJawab` varchar(80) NOT NULL,
  `TelpKonsumen` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `konsumen`
--

INSERT INTO `konsumen` (`KodeKonsumen`, `NamaKonsumen`, `PenanggungJawab`, `TelpKonsumen`) VALUES
('KSMN000001', 'Unit Gawat Darurat', 'Mochamad Abdul Aziz', '085852720505'),
('KSMN000002', 'Unit Rawat Inap', 'Hairul', '085852720507');

-- --------------------------------------------------------

--
-- Struktur dari tabel `leveluser`
--

CREATE TABLE `leveluser` (
  `IdLevel` int(11) NOT NULL,
  `Level` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `leveluser`
--

INSERT INTO `leveluser` (`IdLevel`, `Level`) VALUES
(1, 'Admin'),
(2, 'Admin Pelaporan'),
(3, 'Kepala Gudang'),
(4, 'Apotik Rawat Jalan'),
(5, 'Apotik Rawat Inap'),
(6, 'Unit Laboratorium'),
(7, 'IGD');

-- --------------------------------------------------------

--
-- Struktur dari tabel `obat`
--

CREATE TABLE `obat` (
  `BatchObat` varchar(50) NOT NULL,
  `NamaObat` varchar(100) NOT NULL,
  `BentukObat` varchar(20) NOT NULL,
  `ExpiredDate` date NOT NULL,
  `SumberPengadaan` varchar(20) NOT NULL,
  `StokMinimum` int(11) NOT NULL,
  `ObatMasuk` int(11) NOT NULL,
  `ObatKeluar` int(11) NOT NULL,
  `StokTersedia` int(11) NOT NULL,
  `HrgJual` int(11) NOT NULL,
  `TotPembelian` bigint(20) NOT NULL,
  `Faktur` varchar(30) NOT NULL,
  `TglInputObat` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `obat`
--

INSERT INTO `obat` (`BatchObat`, `NamaObat`, `BentukObat`, `ExpiredDate`, `SumberPengadaan`, `StokMinimum`, `ObatMasuk`, `ObatKeluar`, `StokTersedia`, `HrgJual`, `TotPembelian`, `Faktur`, `TglInputObat`) VALUES
('parac2349988', 'Paracetamol', 'Sirup', '2017-06-23', 'E-purchasing', 30, 700, 510, 190, 1500, 89000000, '234.128/Parac/X/2016', '2016-10-16 11:49:11'),
('amox544129', 'Amoxicilin', 'Tablet', '2017-04-29', 'E-purchasing', 30, 500, 310, 190, 700, 21000000, '234.128/Amox/X/2016', '2016-10-16 11:47:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `obatmutasi`
--

CREATE TABLE `obatmutasi` (
  `IdObatMutasi` varchar(10) NOT NULL,
  `NoTransaksi` varchar(10) NOT NULL,
  `BatchObat` varchar(50) NOT NULL,
  `JmlObatMutasi` int(11) NOT NULL,
  `ObatMutasiMasuk` int(11) NOT NULL,
  `ObatMutasiKeluar` int(11) NOT NULL,
  `StokObatMutasi` int(11) NOT NULL,
  `TotHrgObtMts` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `obatmutasi`
--

INSERT INTO `obatmutasi` (`IdObatMutasi`, `NoTransaksi`, `BatchObat`, `JmlObatMutasi`, `ObatMutasiMasuk`, `ObatMutasiKeluar`, `StokObatMutasi`, `TotHrgObtMts`) VALUES
('OBTMSI0004', 'TRNMSI0004', 'parac2349988', 10, 10, 0, 10, 0),
('OBTMSI0003', 'TRNMSI0003', 'parac2349988', 100, 100, 0, 100, 0),
('OBTMSI0005', 'TRNMSI0004', 'amox544129', 10, 10, 0, 10, 0),
('OBTMSI0002', 'TRNMSI0002', 'amox544129', 300, 300, 0, 300, 0),
('OBTMSI0001', 'TRNMSI0001', 'parac2349988', 300, 300, 0, 300, 0),
('OBTMSI0007', 'TRNMSI0005', 'parac2349988', 100, 100, 0, 100, 150000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `obatmutasi2`
--

CREATE TABLE `obatmutasi2` (
  `IdObatMutasi2` varchar(10) NOT NULL,
  `NoTransaksi` varchar(10) NOT NULL,
  `IdObatMutasi` varchar(10) NOT NULL,
  `BatchObat` varchar(50) NOT NULL,
  `JmlObatMutasi2` int(11) NOT NULL,
  `ObatMutasiMasuk` int(11) NOT NULL,
  `ObatMutasiKeluar` int(11) NOT NULL,
  `StokObatMutasi2` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `obatmutasi2`
--

INSERT INTO `obatmutasi2` (`IdObatMutasi2`, `NoTransaksi`, `IdObatMutasi`, `BatchObat`, `JmlObatMutasi2`, `ObatMutasiMasuk`, `ObatMutasiKeluar`, `StokObatMutasi2`) VALUES
('OBTMS20001', 'TRNMSI0005', 'OBTMSI0003', '', 50, 50, 0, 50);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian`
--

CREATE TABLE `pembelian` (
  `NoPembelian` varchar(15) NOT NULL,
  `KodeProdusen` varchar(10) NOT NULL,
  `TglPembelian` date NOT NULL,
  `BatasTglTerima` date NOT NULL,
  `TotalHrgPembelian` int(11) NOT NULL,
  `StatusPembelian` enum('B','L','T') NOT NULL DEFAULT 'B'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `pembelian`
--

INSERT INTO `pembelian` (`NoPembelian`, `KodeProdusen`, `TglPembelian`, `BatasTglTerima`, `TotalHrgPembelian`, `StatusPembelian`) VALUES
('TRNSB0000000001', 'PRDN000001', '2015-01-20', '2015-01-30', 4448000, 'L'),
('TRNSB0000000002', 'PRDN000001', '2015-01-20', '2015-01-30', 1200000, 'L'),
('TRNSB0000000003', 'PRDN000001', '2016-02-10', '2016-02-10', 500000, 'L'),
('TRNSB0000000004', 'PRDN000001', '2016-10-01', '2016-10-13', 2600000, 'L'),
('TRNSB0000000005', 'PRDN000001', '2016-10-01', '2016-10-14', 1400000, 'L');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `NoPenjualan` varchar(15) NOT NULL,
  `KodeKonsumen` varchar(10) NOT NULL,
  `TglPenjualan` date NOT NULL,
  `BatasTglPengiriman` date NOT NULL,
  `TotalHrgPenjualan` int(11) NOT NULL,
  `StatusPenjualan` enum('B','L','T') NOT NULL DEFAULT 'L'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`NoPenjualan`, `KodeKonsumen`, `TglPenjualan`, `BatasTglPengiriman`, `TotalHrgPenjualan`, `StatusPenjualan`) VALUES
('TRNSJ0000000001', 'KSMN000001', '2015-01-20', '2015-01-20', 270000, 'L'),
('TRNSJ0000000002', 'KSMN000002', '2015-01-20', '2015-01-20', 150000, 'L'),
('TRNSJ0000000003', 'KSMN000002', '2015-01-20', '2015-01-20', 6680000, 'L'),
('TRNSJ0000000004', '', '1970-01-01', '1970-01-01', 0, 'L'),
('TRNSJ0000000005', 'KSMN000002', '2016-10-01', '2016-10-11', 750000, 'L'),
('TRNSJ0000000006', 'KSMN000002', '2016-10-10', '2016-10-12', 890000, 'L');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produsen`
--

CREATE TABLE `produsen` (
  `KodeProdusen` varchar(10) NOT NULL,
  `NamaProdusen` varchar(50) NOT NULL,
  `AlamatProdusen` varchar(80) NOT NULL,
  `TelpProdusen` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `produsen`
--

INSERT INTO `produsen` (`KodeProdusen`, `NamaProdusen`, `AlamatProdusen`, `TelpProdusen`) VALUES
('PRDN000001', 'PT Elektro Jaya', 'Jl Puri Mojokerto', '085791019956');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksimutasi`
--

CREATE TABLE `transaksimutasi` (
  `NoTransaksi` varchar(10) NOT NULL,
  `KdUnit` varchar(6) NOT NULL,
  `TglMutasi` date NOT NULL,
  `TotHrgMutasi` int(11) NOT NULL,
  `DatetimeTransaksi` datetime NOT NULL,
  `IdUser` varchar(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `transaksimutasi`
--

INSERT INTO `transaksimutasi` (`NoTransaksi`, `KdUnit`, `TglMutasi`, `TotHrgMutasi`, `DatetimeTransaksi`, `IdUser`) VALUES
('TRNMSI0001', 'UNIT01', '2020-10-10', 0, '2016-10-16 12:06:19', '3'),
('TRNMSI0002', 'UNIT02', '2020-10-10', 0, '2016-10-16 12:07:33', '3'),
('TRNMSI0003', 'UNIT01', '2020-11-11', 0, '2016-10-16 12:43:27', '3'),
('TRNMSI0004', 'UNIT01', '2016-10-19', 0, '2016-10-19 03:49:32', '3');

-- --------------------------------------------------------

--
-- Struktur dari tabel `unitmutasi`
--

CREATE TABLE `unitmutasi` (
  `KdUnit` varchar(6) NOT NULL,
  `NamaUnit` varchar(50) NOT NULL,
  `PJUnit` varchar(50) NOT NULL,
  `TelpUnit` varchar(15) NOT NULL,
  `IdLevel` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `unitmutasi`
--

INSERT INTO `unitmutasi` (`KdUnit`, `NamaUnit`, `PJUnit`, `TelpUnit`, `IdLevel`) VALUES
('UNIT01', 'Apotik Rawat Jalan', 'Bpk Ahmad Zidni', '085852024269', 3),
('UNIT02', 'Apotik Rawat Inap', 'Bpk Mubarok', '085852024269', 3),
('UNIT03', 'Unit Laboratorium', 'Bpk Ahmad Zidni', '085852024269', 3),
('UNIT04', 'Instalasi Gawat Darurat', 'Bpk Ahmad Ali', '085852024269', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `IdUser` varchar(6) NOT NULL,
  `NamaPengguna` varchar(50) NOT NULL,
  `Sandi` varchar(32) NOT NULL,
  `IdLevel` int(11) NOT NULL,
  `Aktif` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`IdUser`, `NamaPengguna`, `Sandi`, `IdLevel`, `Aktif`) VALUES
('USER01', 'rsudploso', '853c9e7b4478347336aec0ef837abc63', 1, 'Y'),
('USER02', 'pelaporan', '853c9e7b4478347336aec0ef837abc63', 2, 'Y'),
('USER03', 'gudang', '853c9e7b4478347336aec0ef837abc63', 3, 'Y'),
('USER04', 'apotik', '19555e85fb4985453f72f588643a3ce1', 4, 'Y'),
('USER05', 'rawatinap', '19555e85fb4985453f72f588643a3ce1', 5, 'Y'),
('USER06', 'lab', '19555e85fb4985453f72f588643a3ce1', 6, 'Y'),
('USER07', 'igd', '19555e85fb4985453f72f588643a3ce1', 7, 'Y');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`KodeBarang`);

--
-- Indexes for table `barangdibeli`
--
ALTER TABLE `barangdibeli`
  ADD PRIMARY KEY (`IdBarangDibeli`),
  ADD KEY `KodeBarang` (`KodeBarang`);

--
-- Indexes for table `barangdijual`
--
ALTER TABLE `barangdijual`
  ADD PRIMARY KEY (`IdBarangDijual`);

--
-- Indexes for table `konsumen`
--
ALTER TABLE `konsumen`
  ADD PRIMARY KEY (`KodeKonsumen`);

--
-- Indexes for table `leveluser`
--
ALTER TABLE `leveluser`
  ADD PRIMARY KEY (`IdLevel`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`BatchObat`);

--
-- Indexes for table `obatmutasi`
--
ALTER TABLE `obatmutasi`
  ADD PRIMARY KEY (`IdObatMutasi`);

--
-- Indexes for table `obatmutasi2`
--
ALTER TABLE `obatmutasi2`
  ADD PRIMARY KEY (`IdObatMutasi2`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`NoPembelian`),
  ADD KEY `KodeProdusen` (`KodeProdusen`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`NoPenjualan`);

--
-- Indexes for table `produsen`
--
ALTER TABLE `produsen`
  ADD PRIMARY KEY (`KodeProdusen`);

--
-- Indexes for table `transaksimutasi`
--
ALTER TABLE `transaksimutasi`
  ADD PRIMARY KEY (`NoTransaksi`);

--
-- Indexes for table `unitmutasi`
--
ALTER TABLE `unitmutasi`
  ADD PRIMARY KEY (`KdUnit`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`IdUser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `leveluser`
--
ALTER TABLE `leveluser`
  MODIFY `IdLevel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
