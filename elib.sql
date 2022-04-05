-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 05, 2022 at 02:28 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elib`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

DROP TABLE IF EXISTS `blog`;
CREATE TABLE IF NOT EXISTS `blog` (
  `idblog` varchar(6) NOT NULL,
  `tanggal` date NOT NULL,
  `judul` varchar(150) DEFAULT NULL,
  `konten` longtext,
  `idusers` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `thumb` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`idblog`),
  KEY `FK_blog_users` (`idusers`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`idblog`, `tanggal`, `judul`, `konten`, `idusers`, `thumb`) VALUES
('B00003', '2022-02-07', 'Sertijab Dankormar, KSAL Ungkap tentang Kekuatan Marinir', '<p style=\"text-align: justify;\">Sertijab Dankormar, KSAL Ungkap tentang Kekuatan Marinir</p>\r\n<p style=\"text-align: justify;\">&nbsp;</p>\r\n<p style=\"text-align: justify;\">JAKARTA - Kepala Staf Angkatan Laut (KSAL) Laksamana TNI Yudo Margono memimpin serah terima jabatan (sertijab) Komandan Korps Marinir (Dankormar) di Mako Korps Marinir, Jakarta Pusat, Senin (7/2/2022). Jabatan Dankormar diserahkan dari Mayjen TNI Suhartono kepada Mayjen Widodo Dwi Purwanto.</p>\r\n<p style=\"text-align: justify;\">Sebelumnya, Widodo Dwi Purwanto menjabat sebagai Asisten Potensi Maritim (Aspotmar) KSAL. Sementara Mayjen TNI Suhartono selanjutnya menjabat Komandan Pembinaan Doktrin, Pendidikan dan Latihan Angkatan Laut (Dankodiklatal) di Surabaya, Jawa Timur.<br /><br />\"Sebagai Kotama Operasi, penggunaan kekuatan Marinir sesuai perintah Panglima TNI, tetapi di dalam pembinaan di bawah Kepala Staf Angkatan Laut,\" ujar KSAL Yudo dalam keterangan tertulis. Dia menuturkan bahwa selama ini prajurit Baret Ungu telah memiliki sejarah yang amat panjang. Di mana, dalam sejarah itu tercatat bahwa prajurit Marinir memiliki loyalitas yang tinggi.<br /><br />\"Sejarah Marinir membuktikan bahwa Marinir memiliki loyalitas tinggi, tegak lurus. Sebagai bagian dari TNI dan TNI AL, Marinir terbukti memiliki loyalitas tinggi, tegak lurus sesuai Komando yang diberikan satuan atas,\" tuturnya. Sejak tahun 2019, kata KSAL, Korps Marinir sudah berstatus sebagai Kotama Ops dan Bin. Oleh karenanya, Yudo memastikan akan membina kemampuan dan kekuatan Korps Marinir sehingga menjadi satuan yang modern dan profesional. \"Sedangkan penggunaan kekuatannya oleh Panglima TNI baik untuk tugas-tugas Operasi Militer Perang maupun Operasi Militer Selain Perang,\" tambah KSAL.<br /><br /></p>', 'U00001', './assets/img/8afc022b523f7b4a5389478ee4d5885a.jpg'),
('B00004', '2022-02-08', 'Sertijab Komandan Kormar', '<p>Senin 07 Februari 2022, 14:00 WIB Sertijab Komandan Korps Marinir Administrator | Foto Kepala Staf Angkatan Laut Laksamana TNI Yudo Margono (kiri) menyerahkan Pataka Korps Marinir Jalesu Bhumyamca Jayamahe kepada pejabat baru Komandan Korps Marinir Mayjen TNI (Mar) Widodo Dwi Purwanto (tengah) disaksikan pejabat lama Mayjen TNI (Mar) Suhartono (kanan) dalam Upacara Serah Terima Jabatan Komandan Korps Marinir (Dankormar) di Markas Komando Korps Marinir, Kwitang, Jakarta, Senin (7/2/2022). Mayjen TNI (Mar) Widodo Dwi Purwanto resmi menjabat sebagai Dankormar menggantikan Mayjen TNI (Mar) Suhartono. ANTARA/Aprillio Akbar/aww/rdi<br /><br />Sumber:&nbsp;<a href=\"https://mediaindonesia.com/galleries/detail_galleries/22680-sertijab-komandan-korps-marinir\">https://mediaindonesia.com/galleries/detail_galleries/22680-sertijab-komandan-korps-marinir</a></p>', 'U00001', './assets/img/e2a8a047d33edd4d758e2c66cddf1050.jpg'),
('B00005', '2022-02-08', 'Profil Dankormar Mayjen TNI Widodo Dwi Purwanto, Pemimpin Pasukan Elite TNI AL', '<p>JAKARTA - Mayjen TNI (Mar) Widodo Dwi Purwanto resmi menjabat sebagai Komandan Korps Marinir (Dankormar) TNI AL. Pria kelahiran Malang, Jawa Timur 26 Juni 1965 ini menjadi orang nomor satu di Korps Baret Ungu, yang merupakan pasukan elite TNI AL ke-24. Mayjen TNI (Mar) Widodo menerima tongkat komando dari Mayjen TNI (Mar) Suhartono dalam upacara serah terima jabatan yang digelar di Markas Komando Korps Marinir di Jalan Usman dan Harun No 40, Kwitang, Jakarta Pusat, Senin (7/2/2022).</p>\r\n<p>Pengangkatan Mayjen TNI (Mar) Widodo sebagai Dankormar menggantikan Mayjen TNI (Mar) Suhartono yang diangkat menjadi Dankodiklatal, tertuang dalam Surat Keputusan (SK) Jabatan Nomor 66/I/2022 tanggal 21 Januari 2022 tentang Pemberhentian dari dan Pengangkatan Dalam Jabatan di Lingkungan TNI. Dalam surat yang diteken Jenderal Andika itu, secara keseluruhan terdapat 328 perwira tinggi yang dimutasi. &ldquo;Jabatan lama Asisten Potensi Maritim (Aspotmar) Kepala Staf Angkatan Laut (KSAL), menjadi Dankormar,&rdquo; bunyi SK tersebut.</p>\r\n<p>Sebagai lulusan Akademi Angkatan Laut (AAL) 1988 angkatan ke-33, Mayjen TNI (Mar) Widodo pernah merasakan penugasan operasi di Aceh dan Timor-Timur (Timtim) sekarang bernama Timor Leste. Baca juga: Ribuan Prajurit Pasukan Elite TNI AL Lepas Jenderal Marinir Perisai Hidup Jokowi Karena pengabdiannya tersebut, suami dari dr. Sri Widayati Avianti dan ayah dari Irfan Bayu Widodo ini mengantongi sejumlah tanda jasa antara lain, Satya Lencana Kesetiaan VIII, XVI, XXIV, Satya Lencana GOM VII, Satya Lencana Dharma Nusa, Satya Lencana Kebaktian Sosial.<br /><br /></p>\r\n<p>Selama meniti kariernya di militer, Mayjen TNI (Mar) Widodo telah beberapa kali mengikuti pendidikan. Antara lain, Dikko, Diklapa Kopur A-15 pada 2001, Suspa Hb Intel Pus/Prop pada 2005, dan Seskoal A-45 pada 2007, serta Dikreg Sesko TNI XL pada 2013. Berikut ini jabatan yang pernah di emban Mayjen TNI (Mar) Widodo di TNI AL:</p>\r\n<p>1. Letnan Dua sampai dengan Letnan Satu <br />&bull; Danton 3 Ki F Yonif &ndash; 4 Marinir <br />&bull; Danton 3 Ki E Yonif &ndash; 4 Marinir <br />&bull; Danton 2 Ki F Yonif &ndash; 4 Marinir <br />&bull; Danton 3 Ki F Yonif &ndash; 4 Marinir <br />&bull; Danton 3 Ki E Yonif &ndash; 4 Marinir <br />&bull; Danton 2 Ki F Yonif &ndash; 4 Marinir <br />&bull; Danton 1 Ki E Yonif &ndash; 4 Marinir <br />&bull; Danton MO Kima Yonif &ndash; 4 Marinir <br />&bull; Wadanki D Yonif &ndash; 4 Marinir</p>\r\n<p>2. Kapten <br />&bull; Danki D Yonif &ndash; 4 Marinir <br />&bull; Dankima Yonif &ndash; 4 Marinir <br />&bull; Kasi Opslat Sops Brigif &ndash; 2 Marinir <br />&bull; Kasi Rengar Sops Brigif &ndash; 2 Marinir <br />&bull; Pasi &ndash; 2 Yonif &ndash; 2 Marinir<br /><br /></p>\r\n<p>3. Mayor <br />&bull; Wadan Yonif &ndash; 6 Marinir <br />&bull; Kaspri Kormar <br />&bull; Danseta Dasmil</p>\r\n<p>4. Letnan Kolonel <br />&bull; Danyonif &ndash; 4 Marinir <br />&bull; Pasops Brigif &ndash; 2 Marinir <br />&bull; Kasbrigif &ndash; 3 Marinir 5.</p>\r\n<p>Kolonel <br />&bull; Asops Kaspasmar &ndash; 2 Marinir <br />&bull; Danbrigif &ndash; 3 Marinir (2010)[1] <br />&bull; Aspers Dankormar <br />&bull; Dan Kolatmar[2] <br />&bull; Dan Korsis Seskoal[3] <br />&bull; Asrena Dankormar (2014)[4] <br />&bull; Dandenma Mabesal (2014&mdash;2016)<br /><br /></p>\r\n<p>6. Brigadir Jenderal <br />&bull; Danlantamal I/Belawan[5] (2016) <br />&bull; Dan Pasmar II/Jakarta[6][7] (2016&mdash;2017) <br />&bull; Kasgartap III/Surabaya (2017&mdash;2018)[8] <br />&bull; Kaskormar[9] (2018&mdash;2020) <br />&bull; Kadispotmar (2020) 7. Mayor Jenderal <br />&bull; Aspotmar Kasal (2020&mdash;2022) <br />&bull; Dankormar (2022&mdash;Sekarang).<br /><br /><br /></p>\r\n<p>&nbsp;</p>', 'U00001', './assets/img/01d9bb8ee6d59cc66eaf20461d4caeb8.jpg'),
('B00006', '2022-02-08', 'Kasus Omicron Melonjak, Istana: Rem Darurat Belum Perlu Ditarik', '<p><strong>JAKARTA -&nbsp;</strong>Tenaga Ahli Utama Kantor Staf Presiden (KSP) Abraham Wirotomo mengatakan, pemerintah belum akan memberlakukan&nbsp;<strong><a href=\"https://www.okezone.com/tag/ppkm\">PPKM darurat</a></strong>&nbsp;meski angka kasus Covid-19 varian<strong><a href=\"https://www.okezone.com/tag/omicron\">&nbsp;Omicron</a></strong>&nbsp;meningkat tinggi.</p>\r\n<p>\"Data mingguan terakhir menunjukan, meski angka kasus meningkat tinggi namun angka keterpakaian rumah sakit masih sangat terkendali. Sehingga rem darurat belum perlu ditarik,\" ujar Abraham di gedung Bina Graha Jakarta, Selasa (8/2/2022).</p>\r\n<p>Menurutnya, kesiapan pemerintah menghadapi Omicron menjadi lebih baik karena selalu melibatkan para pakar serta mengandalkan data dan kajian ilmiah. Ia mencontohkan soal derajat keparahan Omicron, yang sudah terbukti kebenarannya.</p>\r\n<p>\"Setelah kita kaji karakteristik keparahan Omicron lebih ringan dari Delta, pemerintah pun mengambil kebijakan untuk prioritas isoman atau isoter bagi yang bergejala ringan atau tanpa gejala, dan memprioritaskan RS bagi lansia atau yang memiliki komorbid,\" tutur Abraham.</p>\r\n<p>\"Ini bukti nyata kesiapan pemerintah menghadapi Omicron,\" sambungnya.</p>\r\n<p>Pria yang akrab disapa Bram ini juga memastikan, perubahan level PPKM akan disesuaikan dengan assessment setiap daerah, dengan indikator tambahan keterisian tempat tidur rumah sakit dan capaian vaksinasi.</p>', 'U00001', './assets/img/d4930bbe047426ccf4a594be413079df.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `blog_komentar`
--

DROP TABLE IF EXISTS `blog_komentar`;
CREATE TABLE IF NOT EXISTS `blog_komentar` (
  `idblog_komentar` varchar(6) NOT NULL,
  `nama` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `komentar` text NOT NULL,
  `idblog` varchar(6) NOT NULL,
  `tanggal` datetime NOT NULL,
  PRIMARY KEY (`idblog_komentar`),
  KEY `FK_blog_komentar_key` (`idblog`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_komentar`
--

INSERT INTO `blog_komentar` (`idblog_komentar`, `nama`, `email`, `komentar`, `idblog`, `tanggal`) VALUES
('K00001', 'contoh', 'contoh@gmai.com', 'Contoh komentar', 'B00006', '2022-04-04 11:29:26');

-- --------------------------------------------------------

--
-- Table structure for table `dokumen`
--

DROP TABLE IF EXISTS `dokumen`;
CREATE TABLE IF NOT EXISTS `dokumen` (
  `iddokumen` varchar(6) NOT NULL,
  `idpenelitian` varchar(6) CHARACTER SET utf8mb4 NOT NULL,
  `judul_dok` varchar(45) NOT NULL,
  `path` varchar(150) NOT NULL,
  PRIMARY KEY (`iddokumen`),
  KEY `FK_dokumen_key` (`idpenelitian`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dokumen`
--

INSERT INTO `dokumen` (`iddokumen`, `idpenelitian`, `judul_dok`, `path`) VALUES
('D00001', 'P00001', 'Jurnal', './assets/dokumen/73d120e839f4d60c0d9360f5dcd60038.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `dokumen_gambar`
--

DROP TABLE IF EXISTS `dokumen_gambar`;
CREATE TABLE IF NOT EXISTS `dokumen_gambar` (
  `iddokumen` varchar(6) NOT NULL,
  `idpenelitian` varchar(6) CHARACTER SET utf8mb4 NOT NULL,
  `judul_dok` varchar(45) NOT NULL,
  `path` varchar(150) NOT NULL,
  PRIMARY KEY (`iddokumen`),
  KEY `FK_dokumen_gambar_penelitian` (`idpenelitian`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dokumen_gambar`
--

INSERT INTO `dokumen_gambar` (`iddokumen`, `idpenelitian`, `judul_dok`, `path`) VALUES
('D00001', 'P00001', 'Page 01', './assets/dokumen_gambar/0a6e80873959e22f49e7543b40dd5a0f.png'),
('D00002', 'P00001', 'Page 02', './assets/dokumen_gambar/0ecc1148ca045144438ae60bbb31add3.png'),
('D00003', 'P00001', 'Page 03', './assets/dokumen_gambar/6eb941f234800f5b6d50917d8e2b1256.png');

-- --------------------------------------------------------

--
-- Table structure for table `identitas`
--

DROP TABLE IF EXISTS `identitas`;
CREATE TABLE IF NOT EXISTS `identitas` (
  `kode` varchar(6) NOT NULL DEFAULT '0',
  `instansi` varchar(255) NOT NULL,
  `slogan` varchar(100) DEFAULT NULL,
  `tahun` float DEFAULT NULL,
  `pimpinan` varchar(150) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `kdpos` varchar(7) DEFAULT NULL,
  `tlp` varchar(15) DEFAULT NULL,
  `fax` varchar(35) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `logo` longtext,
  `lat` varchar(45) DEFAULT NULL,
  `lon` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `identitas`
--

INSERT INTO `identitas` (`kode`, `instansi`, `slogan`, `tahun`, `pimpinan`, `alamat`, `kdpos`, `tlp`, `fax`, `website`, `email`, `logo`, `lat`, `lon`) VALUES
('K00001', 'KORPS MARINIR', 'JALESU BHUMYAMCA JAYAMAHE', 15, 'MAYJEN TNI MARINIR WIDODO DWI PURWANTO', 'Jl. Prajurit KKO Usman dan Harun, RT.1/RW.5, Senen, Kec. Senen, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10410', '60178', '08', '-', '', '@gmail.com', './assets/img/4558c846aec00cf55f69e2c6b58e530c.png', '-7.4063726', '112.5841074');

-- --------------------------------------------------------

--
-- Table structure for table `inbox`
--

DROP TABLE IF EXISTS `inbox`;
CREATE TABLE IF NOT EXISTS `inbox` (
  `idinbox` varchar(6) NOT NULL,
  `nama` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `judul` varchar(45) NOT NULL,
  `pesan` varchar(250) NOT NULL,
  PRIMARY KEY (`idinbox`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inbox`
--

INSERT INTO `inbox` (`idinbox`, `nama`, `email`, `judul`, `pesan`) VALUES
('I00001', 'rampa', 'rampa@gmail.com', 'Tanya atika', 'Apakah atika ada ?');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_penelitian`
--

DROP TABLE IF EXISTS `kategori_penelitian`;
CREATE TABLE IF NOT EXISTS `kategori_penelitian` (
  `idkategori` varchar(6) NOT NULL,
  `nama_kategori` varchar(45) NOT NULL,
  PRIMARY KEY (`idkategori`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori_penelitian`
--

INSERT INTO `kategori_penelitian` (`idkategori`, `nama_kategori`) VALUES
('K00001', 'Hanjar Taktik Tempur'),
('K00002', 'Piranti Lunak Bidang Staff'),
('K00003', 'Bujuk MIL TNI (terbatas)');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_penelitian_sub`
--

DROP TABLE IF EXISTS `kategori_penelitian_sub`;
CREATE TABLE IF NOT EXISTS `kategori_penelitian_sub` (
  `idkat_p_sub` varchar(6) NOT NULL,
  `nama_sub_kat` varchar(100) NOT NULL,
  `idkategori` varchar(6) NOT NULL,
  PRIMARY KEY (`idkat_p_sub`),
  KEY `FK_kategori_penelitian_sub_key` (`idkategori`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori_penelitian_sub`
--

INSERT INTO `kategori_penelitian_sub` (`idkat_p_sub`, `nama_sub_kat`, `idkategori`) VALUES
('S00001', 'Artileri', 'K00001'),
('S00002', 'Infateri', 'K00001'),
('S00003', 'Kaveleri', 'K00001'),
('S00004', 'Banpur', 'K00001'),
('S00005', 'bidang perancaan dan ang', 'K00002'),
('S00006', 'bidang intel', 'K00002'),
('S00007', 'bid ops dan lat', 'K00002'),
('S00008', 'bid pers', 'K00002'),
('S00009', 'bid log', 'K00002'),
('S00010', 'bid hukum', 'K00002'),
('S00011', 'bid kes', 'K00002'),
('S00012', 'dokrin jalesveva jayamahe', 'K00003'),
('S00013', 'jukgar opsfib dalam omp', 'K00003'),
('S00014', 'jukgar ophantai', 'K00003'),
('S00015', 'juknis pengamanan pulau', 'K00003');

-- --------------------------------------------------------

--
-- Table structure for table `korps`
--

DROP TABLE IF EXISTS `korps`;
CREATE TABLE IF NOT EXISTS `korps` (
  `idkorps` varchar(6) CHARACTER SET utf8mb4 NOT NULL,
  `nama_korps` varchar(45) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`idkorps`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `korps`
--

INSERT INTO `korps` (`idkorps`, `nama_korps`) VALUES
('K00001', 'Laut (P)'),
('K00002', 'Laut (T)'),
('K00003', 'Laut (E)'),
('K00004', 'Laut (S)'),
('K00005', 'Laut (PM)'),
('K00006', 'Laut (K)'),
('K00007', 'Laut (KH)'),
('K00008', 'Marinir'),
('K00009', 'Bah'),
('K00010', 'Nav'),
('K00011', 'Kom'),
('K00012', 'Tlg'),
('K00013', 'Ekl'),
('K00014', 'Eko'),
('K00015', 'Mer'),
('K00016', 'Amo'),
('K00017', 'Rdl'),
('K00018', 'SAA'),
('K00019', 'SBA'),
('K00020', 'TRB'),
('K00021', 'Esa'),
('K00022', 'ETK'),
('K00023', 'PDK'),
('K00024', 'Jas'),
('K00025', 'Mus'),
('K00026', 'TTG'),
('K00027', 'Ttu'),
('K00028', 'Keu'),
('K00029', 'Mes'),
('K00030', 'Lis'),
('K00031', 'TKU'),
('K00032', 'MPU'),
('K00033', 'LPU'),
('K00034', 'Ang'),
('K00036', 'POM'),
('K00037', 'EDE'),
('K00038', 'Lek'),
('K00039', 'Pas'),
('K00040', 'PNS'),
('K00042', 'Tek'),
('K00043', 'Bek'),
('K00044', 'Adm');

-- --------------------------------------------------------

--
-- Table structure for table `logdownload`
--

DROP TABLE IF EXISTS `logdownload`;
CREATE TABLE IF NOT EXISTS `logdownload` (
  `idlog` varchar(6) NOT NULL,
  `idsiswa` varchar(6) CHARACTER SET utf8mb4 NOT NULL,
  `tanggal` date NOT NULL,
  `idpenelitian` varchar(6) CHARACTER SET utf8mb4 NOT NULL,
  `iddokumen` varchar(6) NOT NULL,
  PRIMARY KEY (`idlog`),
  KEY `FK_logdownload_siswa` (`idsiswa`),
  KEY `FK_logdownload_penelitian` (`idpenelitian`),
  KEY `FK_logdownload_dok` (`iddokumen`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logdownload`
--

INSERT INTO `logdownload` (`idlog`, `idsiswa`, `tanggal`, `idpenelitian`, `iddokumen`) VALUES
('L00001', 'S00002', '2022-02-19', 'P00001', 'D00001'),
('L00002', 'S00002', '2022-02-19', 'P00001', 'D00001'),
('L00003', 'S00002', '2022-02-19', 'P00001', 'D00001');

-- --------------------------------------------------------

--
-- Table structure for table `medsos`
--

DROP TABLE IF EXISTS `medsos`;
CREATE TABLE IF NOT EXISTS `medsos` (
  `idmedsos` varchar(6) NOT NULL,
  `tw` varchar(150) NOT NULL,
  `fb` varchar(150) NOT NULL,
  `ig` varchar(150) NOT NULL,
  `lk` varchar(150) NOT NULL,
  PRIMARY KEY (`idmedsos`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `medsos`
--

INSERT INTO `medsos` (`idmedsos`, `tw`, `fb`, `ig`, `lk`) VALUES
('M00001', 'https://www.google.com/', 'https://www.google.com/', 'https://www.google.com/', 'https://www.google.com/');

-- --------------------------------------------------------

--
-- Table structure for table `pangkat`
--

DROP TABLE IF EXISTS `pangkat`;
CREATE TABLE IF NOT EXISTS `pangkat` (
  `idpangkat` varchar(6) CHARACTER SET utf8mb4 NOT NULL,
  `nama_pangkat` varchar(45) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`idpangkat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pangkat`
--

INSERT INTO `pangkat` (`idpangkat`, `nama_pangkat`) VALUES
('P00001', 'ADMINISTRATOR'),
('P00005', 'Laksma TNI'),
('P00010', 'Kolonel'),
('P00011', 'Letkol'),
('P00012', 'Mayor'),
('P00013', 'Kapten'),
('P00014', 'Lettu'),
('P00016', 'Peltu'),
('P00017', 'Pelda'),
('P00018', 'Serma'),
('P00019', 'Serka'),
('P00020', 'Sertu'),
('P00031', 'Penata Tk I III/d'),
('P00033', 'Penata III/C');

-- --------------------------------------------------------

--
-- Table structure for table `penelitian`
--

DROP TABLE IF EXISTS `penelitian`;
CREATE TABLE IF NOT EXISTS `penelitian` (
  `idpenelitian` varchar(6) CHARACTER SET utf8mb4 NOT NULL,
  `tanggal` datetime NOT NULL,
  `judul` varchar(250) NOT NULL,
  `tahun` float NOT NULL DEFAULT '0',
  `katakunci` varchar(100) NOT NULL,
  `thumbnail` varchar(150) NOT NULL,
  `sinopsis` text NOT NULL,
  `idkategori` varchar(6) NOT NULL,
  `idkat_p_sub` varchar(6) NOT NULL,
  `sandi` varchar(15) DEFAULT NULL,
  `strata` varchar(20) NOT NULL,
  `penulis` varchar(150) NOT NULL,
  `penerbit` varchar(150) NOT NULL,
  PRIMARY KEY (`idpenelitian`),
  KEY `FK_penelitian_kategori` (`idkategori`),
  KEY `FK_penelitian_subkat` (`idkat_p_sub`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penelitian`
--

INSERT INTO `penelitian` (`idpenelitian`, `tanggal`, `judul`, `tahun`, `katakunci`, `thumbnail`, `sinopsis`, `idkategori`, `idkat_p_sub`, `sandi`, `strata`, `penulis`, `penerbit`) VALUES
('P00001', '2022-02-19 14:54:53', 'Judul percobaan', 2022, 'Perobaan', './assets/img/985cc88cc93f0deab4f245700b11044f.jpg', '<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>', 'K00002', 'S00005', '', 'Umum', 'Rampa', 'Gramedia');

-- --------------------------------------------------------

--
-- Table structure for table `penelitian_komentar`
--

DROP TABLE IF EXISTS `penelitian_komentar`;
CREATE TABLE IF NOT EXISTS `penelitian_komentar` (
  `idkomen` varchar(6) NOT NULL,
  `nama` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `komentar` text NOT NULL,
  `tanggal` datetime NOT NULL,
  `idpenelitian` varchar(6) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`idkomen`),
  KEY `FK_penelitian_komentar_key` (`idpenelitian`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penelitian_komentar`
--

INSERT INTO `penelitian_komentar` (`idkomen`, `nama`, `email`, `komentar`, `tanggal`, `idpenelitian`) VALUES
('K00001', 'Atika', 'atika@gmail.com', 'Komentar', '2022-02-10 21:30:49', 'P00001'),
('K00002', 'rampa', 'rampa@gmail.com', 'Coba', '2022-04-04 11:08:12', 'P00001');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

DROP TABLE IF EXISTS `pengguna`;
CREATE TABLE IF NOT EXISTS `pengguna` (
  `idsiswa` varchar(6) CHARACTER SET utf8mb4 NOT NULL,
  `nama` varchar(45) NOT NULL,
  `nrp` varchar(15) NOT NULL,
  `email` varchar(45) NOT NULL,
  `idpangkat` varchar(6) CHARACTER SET utf8mb4 NOT NULL,
  `idkorps` varchar(6) CHARACTER SET utf8mb4 NOT NULL,
  `foto` varchar(150) DEFAULT NULL,
  `pass` varchar(45) NOT NULL,
  PRIMARY KEY (`idsiswa`),
  KEY `FK_siswa_pangkat` (`idpangkat`),
  KEY `FK_siswa_korps` (`idkorps`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`idsiswa`, `nama`, `nrp`, `email`, `idpangkat`, `idkorps`, `foto`, `pass`) VALUES
('S00002', 'Atika wardhani rustiaria', '222', 'atika@gmail.com', 'P00018', 'K00002', './assets/img/089537623dc7e4999cb4170b193959b7.jpg', 'aGtq');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `idrole` varchar(6) CHARACTER SET utf8mb4 NOT NULL,
  `nama_role` varchar(45) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`idrole`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`idrole`, `nama_role`) VALUES
('R00001', 'ADMINISTRATOR'),
('R00002', 'STAFF');

-- --------------------------------------------------------

--
-- Table structure for table `slider_tentang`
--

DROP TABLE IF EXISTS `slider_tentang`;
CREATE TABLE IF NOT EXISTS `slider_tentang` (
  `idslider_tentang` varchar(6) NOT NULL,
  `path` varchar(150) NOT NULL,
  `judul` varchar(45) DEFAULT NULL,
  `keterangan` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`idslider_tentang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `slider_tentang`
--

INSERT INTO `slider_tentang` (`idslider_tentang`, `path`, `judul`, `keterangan`) VALUES
('S00001', './assets/img/b72a0b7cf5e89d282b1331a1052bfcf2.jpg', 'Thumbnail 1', ''),
('S00002', './assets/img/24f36f5d5d537018e460008af58b9b52.jpg', 'Thumbnail 2', ''),
('S00003', './assets/img/56dafd53be0aacc50543dd255b027522.png', 'dsadsadsads', 'dsadasdasdsa');

-- --------------------------------------------------------

--
-- Table structure for table `tentang`
--

DROP TABLE IF EXISTS `tentang`;
CREATE TABLE IF NOT EXISTS `tentang` (
  `idtentang` varchar(6) NOT NULL,
  `pesan` text,
  PRIMARY KEY (`idtentang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tentang`
--

INSERT INTO `tentang` (`idtentang`, `pesan`) VALUES
('T00001', 'Deskripsi E-Library Korps Marinir adalah suatu Aplikasi Website ..........................................\r\n...........................................\r\n.......................................................\r\n................................................................');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `idusers` varchar(20) CHARACTER SET utf8mb4 NOT NULL,
  `nrp` varchar(15) CHARACTER SET utf8mb4 NOT NULL,
  `pass` varchar(45) CHARACTER SET utf8mb4 NOT NULL,
  `nama` varchar(45) CHARACTER SET utf8mb4 NOT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `agama` varchar(45) CHARACTER SET utf8mb4 DEFAULT NULL,
  `kota_asal` varchar(45) CHARACTER SET utf8mb4 DEFAULT NULL,
  `foto` varchar(150) CHARACTER SET utf8mb4 DEFAULT NULL,
  `satuan_kerja` varchar(45) CHARACTER SET utf8mb4 DEFAULT NULL,
  `idrole` varchar(6) CHARACTER SET utf8mb4 NOT NULL,
  `idkorps` varchar(6) CHARACTER SET utf8mb4 NOT NULL,
  `idpangkat` varchar(6) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`idusers`),
  KEY `FK_users_role` (`idrole`),
  KEY `FK_users_korps` (`idkorps`),
  KEY `FK_users_pangkat` (`idpangkat`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idusers`, `nrp`, `pass`, `nama`, `tgl_lahir`, `agama`, `kota_asal`, `foto`, `satuan_kerja`, `idrole`, `idkorps`, `idpangkat`) VALUES
('U00001', 'ADMIN', 'aGtq', 'ADMIN', '1991-01-30', 'Islam', 'Tembilahan Riau', './assets/images/e7118256aaf4d1de09199e2b6cbe667c.png', 'TNI ANGKATAN LAUT', 'R00001', 'K00007', 'P00014');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog`
--
ALTER TABLE `blog`
  ADD CONSTRAINT `FK_blog_users` FOREIGN KEY (`idusers`) REFERENCES `users` (`idusers`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `blog_komentar`
--
ALTER TABLE `blog_komentar`
  ADD CONSTRAINT `FK_blog_komentar_key` FOREIGN KEY (`idblog`) REFERENCES `blog` (`idblog`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dokumen`
--
ALTER TABLE `dokumen`
  ADD CONSTRAINT `FK_dokumen_key` FOREIGN KEY (`idpenelitian`) REFERENCES `penelitian` (`idpenelitian`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dokumen_gambar`
--
ALTER TABLE `dokumen_gambar`
  ADD CONSTRAINT `FK_dokumen_gambar_penelitian` FOREIGN KEY (`idpenelitian`) REFERENCES `penelitian` (`idpenelitian`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kategori_penelitian_sub`
--
ALTER TABLE `kategori_penelitian_sub`
  ADD CONSTRAINT `FK_kategori_penelitian_sub_key` FOREIGN KEY (`idkategori`) REFERENCES `kategori_penelitian` (`idkategori`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `logdownload`
--
ALTER TABLE `logdownload`
  ADD CONSTRAINT `FK_logdownload_dok` FOREIGN KEY (`iddokumen`) REFERENCES `dokumen` (`iddokumen`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_logdownload_penelitian` FOREIGN KEY (`idpenelitian`) REFERENCES `penelitian` (`idpenelitian`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_logdownload_siswa` FOREIGN KEY (`idsiswa`) REFERENCES `pengguna` (`idsiswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penelitian`
--
ALTER TABLE `penelitian`
  ADD CONSTRAINT `FK_penelitian_kategori` FOREIGN KEY (`idkategori`) REFERENCES `kategori_penelitian` (`idkategori`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_penelitian_subkat` FOREIGN KEY (`idkat_p_sub`) REFERENCES `kategori_penelitian_sub` (`idkat_p_sub`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penelitian_komentar`
--
ALTER TABLE `penelitian_komentar`
  ADD CONSTRAINT `FK_penelitian_komentar_key` FOREIGN KEY (`idpenelitian`) REFERENCES `penelitian` (`idpenelitian`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD CONSTRAINT `FK_siswa_korps` FOREIGN KEY (`idkorps`) REFERENCES `korps` (`idkorps`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_siswa_pangkat` FOREIGN KEY (`idpangkat`) REFERENCES `pangkat` (`idpangkat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_users_korps` FOREIGN KEY (`idkorps`) REFERENCES `korps` (`idkorps`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_users_pangkat` FOREIGN KEY (`idpangkat`) REFERENCES `pangkat` (`idpangkat`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_users_role` FOREIGN KEY (`idrole`) REFERENCES `role` (`idrole`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
