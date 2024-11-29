-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 29, 2024 at 02:45 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `presenceplus`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_jadwal_mapel`
--

CREATE TABLE `detail_jadwal_mapel` (
  `id_jadwal_mapel` int NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jum"at','Sabtu') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `jam_awal` time DEFAULT NULL,
  `jam_akhir` time DEFAULT NULL,
  `id_kelas` varchar(20) NOT NULL,
  `kd_mapel` varchar(10) NOT NULL,
  `nik_pegawai` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail_jadwal_mapel`
--

INSERT INTO `detail_jadwal_mapel` (`id_jadwal_mapel`, `hari`, `jam_awal`, `jam_akhir`, `id_kelas`, `kd_mapel`, `nik_pegawai`) VALUES
(1, 'Senin', '10:58:00', '24:58:00', 'KLS001', 'MM1101', '8877665544'),
(2, 'Senin', '06:58:00', '13:58:43', 'KLS001', 'MM1104', '88763567234'),
(3, 'Senin', '04:58:00', '13:58:43', 'KLS001', 'MM1101', '8877665544');

-- --------------------------------------------------------

--
-- Table structure for table `tb_jenispegawai`
--

CREATE TABLE `tb_jenispegawai` (
  `id_jenis` int NOT NULL,
  `nama` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_jenispegawai`
--

INSERT INTO `tb_jenispegawai` (`id_jenis`, `nama`) VALUES
(1, 'Admin'),
(2, 'Guru');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kelas`
--

CREATE TABLE `tb_kelas` (
  `id_kelas` varchar(20) NOT NULL,
  `nama_kelas` varchar(50) DEFAULT NULL,
  `nik_pegawai` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_kelas`
--

INSERT INTO `tb_kelas` (`id_kelas`, `nama_kelas`, `nik_pegawai`) VALUES
('10pplg1', 'X PPLG 1', '0987654321'),
('11pplg1', 'XI PPLG 1', '6611552244'),
('KLS001', 'XRPL2', '0987654321'),
('KLS002', 'mm 1', '6611552244'),
('KLS003', 'ki 6', '88763567234'),
('KLS004', 'ki 6', '8877665544');

-- --------------------------------------------------------

--
-- Table structure for table `tb_mapel`
--

CREATE TABLE `tb_mapel` (
  `kd_mapel` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_mapel`
--

INSERT INTO `tb_mapel` (`kd_mapel`, `nama`) VALUES
('1', 'Matematika'),
('MM1101', 'Matematika'),
('MM1102', 'Fisika'),
('MM1103', 'Biologi'),
('MM1104', 'Kimia'),
('MM1105', 'Bahasa Indonesia'),
('MM1106', 'Bahasa Inggris'),
('MM1107', 'Sejarah'),
('MM1108', 'Geografi'),
('MM1109', 'Ekonomi'),
('MM1110', 'Seni Budaya');

-- --------------------------------------------------------

--
-- Table structure for table `tb_orangtua`
--

CREATE TABLE `tb_orangtua` (
  `nik_ortu` varchar(20) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_orangtua`
--

INSERT INTO `tb_orangtua` (`nik_ortu`, `nama`, `alamat`, `no_hp`, `jenis_kelamin`, `email`, `password`) VALUES
('123456787654321', 'Sayang', 'banyuwangi', '1123334', 'perempuan', 'sayang@gmail.com', '1234'),
('1237646', 'Liza', 'Jember', '656236e', 'perempuan', 'liza@gmail.com', '223344'),
('3243434546', 'Ita Nurlaili ', 'Jawa timur', '082336938797', 'perempuan', 'ita@gmail.com', '11223344'),
('3456', 'Lila', 'jember', '3456788', 'perempuan', 'lila12@gmail.com', '123'),
('45565734132377', 'cleo', 'asd', '31456321', 'perempuan', 'af@srgft', '12346578'),
('qer3434', 'Ita Nurlaili', 'fferer', '345345', 'perempuan', 'ita@gmail', '434534');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pegawai`
--

CREATE TABLE `tb_pegawai` (
  `nik_pegawai` varchar(20) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `alamat` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `id_jenis` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_pegawai`
--

INSERT INTO `tb_pegawai` (`nik_pegawai`, `nama`, `alamat`, `jenis_kelamin`, `password`, `no_hp`, `email`, `id_jenis`) VALUES
('0987654321', 'Siti', 'jember', 'perempuan', '12345678', '08654323546', 'siti@gmail.com', 2),
('1234512345', 'Vina', 'Jember', 'perempuan', '$2y$10$iy/4LkU9Rd.Fme3752cDQOV2X6w9et1He6DswVpXZNLbMmnUbNbCS', '0812349900', 'vina@gmail.com', 1),
('12345678910', 'Ita', 'Bondowoso', 'perempuan', '$2y$10$Wpc8aCdbMyoMlxULYeLZLOJUyIZ2Ay98coQHHfcShbx7xyfhHpdnu', '6282336928797', 'ita@gmail.com', 1),
('6611552244', 'farhan', 'banyuwangi', 'laki-laki', '$2y$10$QCfGdtpOzemohrQ/PuTymOB/MhLF90OsPjSa1Cum5ctKO7gtnAau.', '08654323546', 'farhan@gmail.com', 2),
('88763567234', 'Rina Desi', 'Bondowoso', 'perempuan', '$2y$10$eWd0OEnAO1erkTyAJ.k1nefRg.rNVtBkhxf2StJ/ww9ybigX6LWDG', '0812456345', 'rina@gmail.com', 2),
('8877665544', 'Rina Desi', 'jbchhsd', 'perempuan', '$2y$10$RJFAaPGlqI6QlDcS0cXo8..KJzT0.Z2SgZpjIndkinMERzpnI13ci', '12345676543', 'nina@gmail..com', 2),
('991234567', 'Lala', 'Jember', 'perempuan', '123456', '1223234', 'lala@gmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_presensi`
--

CREATE TABLE `tb_presensi` (
  `id_presensi` int NOT NULL,
  `tanggal` date DEFAULT NULL,
  `jam_datang` time DEFAULT NULL,
  `jam_pulang` time DEFAULT NULL,
  `keterangan` enum('alpa','hadir','izin','sakit') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nis` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_surat` int DEFAULT NULL,
  `id_kelas` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `nis` varchar(20) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `tahun_akademik` year DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `id_kelas` varchar(20) DEFAULT NULL,
  `nik_ortu` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_siswa`
--

INSERT INTO `tb_siswa` (`nis`, `nama`, `tanggal_lahir`, `tahun_akademik`, `password`, `jenis_kelamin`, `alamat`, `foto`, `id_kelas`, `nik_ortu`) VALUES
('pplg2208', 'dien', '2007-10-10', 2024, 'pplg2208', 'laki-laki', 'jbr', NULL, '10pplg1', '1237646'),
('pplg2303', 'farhan', '2024-08-04', 2024, 'pplg2303', 'laki-laki', 'bwi', NULL, '10pplg1', '3243434546'),
('pplg2307', 'Ita', '2004-10-01', 2024, 'pplg2307', 'perempuan', 'bws', NULL, '10pplg1', 'qer3434'),
('pplg2401', 'laura', '2014-11-05', 2024, 'pplg2401', 'perempuan', 'jember', NULL, '10pplg1', '3456');

-- --------------------------------------------------------

--
-- Table structure for table `tb_suratizin`
--

CREATE TABLE `tb_suratizin` (
  `id_surat` int NOT NULL,
  `keterangan` enum('izin','sakit') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status` enum('verified','unverified','disable') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `tenggat` date DEFAULT NULL,
  `foto_surat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nik_ortu` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nik_pegawai` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nis` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_suratizin`
--

INSERT INTO `tb_suratizin` (`id_surat`, `keterangan`, `status`, `tanggal`, `tenggat`, `foto_surat`, `nik_ortu`, `nik_pegawai`, `nis`) VALUES
(5, 'izin', 'verified', '2024-11-29', NULL, NULL, '3243434546', '0987654321', 'pplg2303'),
(6, 'sakit', 'verified', '2024-11-29', NULL, NULL, 'qer3434', '0987654321', 'pplg2307'),
(7, 'sakit', 'verified', '2024-11-29', NULL, 'foto.jpg', '1237646', '0987654321', 'pplg2208'),
(8, 'izin', 'disable', '2024-11-29', NULL, 'foto.jpg', '3456', '0987654321', 'pplg2401');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_detail_jadwal_mapel`
-- (See below for the actual view)
--
CREATE TABLE `v_detail_jadwal_mapel` (
`hari` enum('Senin','Selasa','Rabu','Kamis','Jum"at','Sabtu')
,`id_kelas` varchar(20)
,`jam_masuk` time
,`jam_pulang` time
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_detail_jadwal_mapel_new`
-- (See below for the actual view)
--
CREATE TABLE `v_detail_jadwal_mapel_new` (
`hari` enum('Senin','Selasa','Rabu','Kamis','Jum"at','Sabtu')
,`id_kelas` varchar(20)
,`jam_masuk` time
,`jam_pulang` time
,`nama_kelas` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_detail_mapel`
-- (See below for the actual view)
--
CREATE TABLE `v_detail_mapel` (
`Hari` enum('Senin','Selasa','Rabu','Kamis','Jum"at','Sabtu')
,`id_kelas` varchar(20)
,`Jam_Mulai` time
,`Jam_Selesai` time
,`Nama_Guru` varchar(50)
,`Nama_Kelas` varchar(50)
,`Nama_Mapel` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_jadwal_mapel_detail`
-- (See below for the actual view)
--
CREATE TABLE `v_jadwal_mapel_detail` (
`hari` enum('Senin','Selasa','Rabu','Kamis','Jum"at','Sabtu')
,`id_jadwal_mapel` int
,`jam_akhir` time
,`jam_awal` time
,`nama_guru` varchar(50)
,`nama_kelas` varchar(50)
,`nama_mapel` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_pegawai_detail`
-- (See below for the actual view)
--
CREATE TABLE `v_pegawai_detail` (
`alamat` varchar(200)
,`email` varchar(50)
,`jenis_kelamin` enum('laki-laki','perempuan')
,`jenis_pegawai` varchar(50)
,`nama_pegawai` varchar(50)
,`nik_pegawai` varchar(20)
,`no_hp` varchar(15)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_presensi`
-- (See below for the actual view)
--
CREATE TABLE `v_presensi` (
`keterangan` enum('alpa','hadir','izin','sakit')
,`nama` varchar(50)
,`nis` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_rekap`
-- (See below for the actual view)
--
CREATE TABLE `v_rekap` (
`jam_datang` time
,`jam_pulang` time
,`keterangan` enum('alpa','hadir','izin','sakit')
,`nama` varchar(50)
,`nis` varchar(20)
,`tanggal` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_siswa_ortu_kelas`
-- (See below for the actual view)
--
CREATE TABLE `v_siswa_ortu_kelas` (
`alamat_siswa` varchar(255)
,`jenis_kelamin_siswa` enum('laki-laki','perempuan')
,`nama_kelas` varchar(50)
,`nama_orangtua` varchar(50)
,`nama_siswa` varchar(50)
,`nis` varchar(20)
,`tahun_akademik` year
,`tanggal_lahir` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_suratizin`
-- (See below for the actual view)
--
CREATE TABLE `v_suratizin` (
`foto_surat` varchar(255)
,`id_kelas` varchar(20)
,`id_surat` int
,`keterangan` enum('izin','sakit')
,`nama_kelas` varchar(50)
,`nama_ortu` varchar(50)
,`nama_pegawai` varchar(50)
,`nama_siswa` varchar(50)
,`nik_ortu` varchar(20)
,`nik_pegawai` varchar(20)
,`nis` varchar(20)
,`status` enum('verified','unverified','disable')
,`tanggal` date
,`tenggat` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_wali_kelas`
-- (See below for the actual view)
--
CREATE TABLE `v_wali_kelas` (
`id_kelas` varchar(20)
,`nama_kelas` varchar(50)
,`nama_wali_kelas` varchar(50)
);

-- --------------------------------------------------------

--
-- Structure for view `v_detail_jadwal_mapel`
--
DROP TABLE IF EXISTS `v_detail_jadwal_mapel`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_detail_jadwal_mapel`  AS SELECT `detail_jadwal_mapel`.`id_kelas` AS `id_kelas`, `detail_jadwal_mapel`.`hari` AS `hari`, min(`detail_jadwal_mapel`.`jam_awal`) AS `jam_masuk`, max(`detail_jadwal_mapel`.`jam_akhir`) AS `jam_pulang` FROM `detail_jadwal_mapel` GROUP BY `detail_jadwal_mapel`.`id_kelas`, `detail_jadwal_mapel`.`hari` ORDER BY `detail_jadwal_mapel`.`id_kelas` ASC, field(`detail_jadwal_mapel`.`hari`,'Senin','Selasa','Rabu','Kamis','Jum\'at','Sabtu') ASC  ;

-- --------------------------------------------------------

--
-- Structure for view `v_detail_jadwal_mapel_new`
--
DROP TABLE IF EXISTS `v_detail_jadwal_mapel_new`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_detail_jadwal_mapel_new`  AS SELECT `djm`.`id_kelas` AS `id_kelas`, `k`.`nama_kelas` AS `nama_kelas`, `djm`.`hari` AS `hari`, min(`djm`.`jam_awal`) AS `jam_masuk`, max(`djm`.`jam_akhir`) AS `jam_pulang` FROM (`detail_jadwal_mapel` `djm` join `tb_kelas` `k` on((`djm`.`id_kelas` = `k`.`id_kelas`))) GROUP BY `djm`.`id_kelas`, `djm`.`hari` ORDER BY `djm`.`id_kelas` ASC, field(`djm`.`hari`,'Senin','Selasa','Rabu','Kamis','Jum\'at','Sabtu') ASC  ;

-- --------------------------------------------------------

--
-- Structure for view `v_detail_mapel`
--
DROP TABLE IF EXISTS `v_detail_mapel`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_detail_mapel`  AS SELECT `dk`.`id_kelas` AS `id_kelas`, `dk`.`nama_kelas` AS `Nama_Kelas`, `m`.`nama` AS `Nama_Mapel`, `djm`.`hari` AS `Hari`, `djm`.`jam_awal` AS `Jam_Mulai`, `djm`.`jam_akhir` AS `Jam_Selesai`, `p`.`nama` AS `Nama_Guru` FROM (((`detail_jadwal_mapel` `djm` join `tb_kelas` `dk` on((`djm`.`id_kelas` = `dk`.`id_kelas`))) join `tb_mapel` `m` on((`djm`.`kd_mapel` = `m`.`kd_mapel`))) join `tb_pegawai` `p` on((`djm`.`nik_pegawai` = `p`.`nik_pegawai`))) ORDER BY `dk`.`nama_kelas` ASC, field(`djm`.`hari`,'Senin','Selasa','Rabu','Kamis','Jum\'at','Sabtu') ASC, `djm`.`jam_awal` ASC  ;

-- --------------------------------------------------------

--
-- Structure for view `v_jadwal_mapel_detail`
--
DROP TABLE IF EXISTS `v_jadwal_mapel_detail`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_jadwal_mapel_detail`  AS SELECT `djm`.`id_jadwal_mapel` AS `id_jadwal_mapel`, `k`.`nama_kelas` AS `nama_kelas`, `m`.`nama` AS `nama_mapel`, `p`.`nama` AS `nama_guru`, `djm`.`hari` AS `hari`, `djm`.`jam_awal` AS `jam_awal`, `djm`.`jam_akhir` AS `jam_akhir` FROM (((`detail_jadwal_mapel` `djm` join `tb_kelas` `k` on((`djm`.`id_kelas` = `k`.`id_kelas`))) join `tb_mapel` `m` on((`djm`.`kd_mapel` = `m`.`kd_mapel`))) join `tb_pegawai` `p` on((`djm`.`nik_pegawai` = `p`.`nik_pegawai`))) ORDER BY `djm`.`id_kelas` ASC, field(`djm`.`hari`,'Senin','Selasa','Rabu','Kamis','Jum\'at','Sabtu') ASC  ;

-- --------------------------------------------------------

--
-- Structure for view `v_pegawai_detail`
--
DROP TABLE IF EXISTS `v_pegawai_detail`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_pegawai_detail`  AS SELECT `p`.`nik_pegawai` AS `nik_pegawai`, `p`.`nama` AS `nama_pegawai`, `p`.`alamat` AS `alamat`, `p`.`jenis_kelamin` AS `jenis_kelamin`, `p`.`no_hp` AS `no_hp`, `p`.`email` AS `email`, `jp`.`nama` AS `jenis_pegawai` FROM (`tb_pegawai` `p` join `tb_jenispegawai` `jp` on((`p`.`id_jenis` = `jp`.`id_jenis`)))  ;

-- --------------------------------------------------------

--
-- Structure for view `v_presensi`
--
DROP TABLE IF EXISTS `v_presensi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_presensi`  AS SELECT `tb_presensi`.`nis` AS `nis`, `tb_siswa`.`nama` AS `nama`, `tb_presensi`.`keterangan` AS `keterangan` FROM (`tb_presensi` join `tb_siswa` on((`tb_presensi`.`nis` = `tb_siswa`.`nis`)))  ;

-- --------------------------------------------------------

--
-- Structure for view `v_rekap`
--
DROP TABLE IF EXISTS `v_rekap`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_rekap`  AS SELECT `tb_siswa`.`nis` AS `nis`, `tb_siswa`.`nama` AS `nama`, `tb_presensi`.`keterangan` AS `keterangan`, `tb_presensi`.`jam_datang` AS `jam_datang`, `tb_presensi`.`jam_pulang` AS `jam_pulang`, `tb_presensi`.`tanggal` AS `tanggal` FROM (`tb_presensi` join `tb_siswa` on((`tb_presensi`.`nis` = `tb_siswa`.`nis`)))  ;

-- --------------------------------------------------------

--
-- Structure for view `v_siswa_ortu_kelas`
--
DROP TABLE IF EXISTS `v_siswa_ortu_kelas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_siswa_ortu_kelas`  AS SELECT `s`.`nis` AS `nis`, `s`.`nama` AS `nama_siswa`, `s`.`tanggal_lahir` AS `tanggal_lahir`, `s`.`tahun_akademik` AS `tahun_akademik`, `s`.`jenis_kelamin` AS `jenis_kelamin_siswa`, `s`.`alamat` AS `alamat_siswa`, `k`.`nama_kelas` AS `nama_kelas`, `o`.`nama` AS `nama_orangtua` FROM ((`tb_siswa` `s` join `tb_kelas` `k` on((`s`.`id_kelas` = `k`.`id_kelas`))) join `tb_orangtua` `o` on((`s`.`nik_ortu` = `o`.`nik_ortu`)))  ;

-- --------------------------------------------------------

--
-- Structure for view `v_suratizin`
--
DROP TABLE IF EXISTS `v_suratizin`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_suratizin`  AS SELECT `s`.`id_surat` AS `id_surat`, `s`.`tanggal` AS `tanggal`, `s`.`tenggat` AS `tenggat`, `n`.`nis` AS `nis`, `n`.`nama` AS `nama_siswa`, `s`.`foto_surat` AS `foto_surat`, `s`.`status` AS `status`, `s`.`keterangan` AS `keterangan`, `m`.`nik_ortu` AS `nik_ortu`, `m`.`nama` AS `nama_ortu`, `k`.`id_kelas` AS `id_kelas`, `k`.`nama_kelas` AS `nama_kelas`, `p`.`nik_pegawai` AS `nik_pegawai`, `p`.`nama` AS `nama_pegawai` FROM ((((`tb_suratizin` `s` join `tb_orangtua` `m` on((`s`.`nik_ortu` = `m`.`nik_ortu`))) join `tb_siswa` `n` on((`m`.`nik_ortu` = `n`.`nik_ortu`))) join `tb_kelas` `k` on((`n`.`id_kelas` = `k`.`id_kelas`))) join `tb_pegawai` `p` on((`k`.`nik_pegawai` = `p`.`nik_pegawai`)))  ;

-- --------------------------------------------------------

--
-- Structure for view `v_wali_kelas`
--
DROP TABLE IF EXISTS `v_wali_kelas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_wali_kelas`  AS SELECT `k`.`id_kelas` AS `id_kelas`, `k`.`nama_kelas` AS `nama_kelas`, `p`.`nama` AS `nama_wali_kelas` FROM (`tb_kelas` `k` join `tb_pegawai` `p` on((`k`.`nik_pegawai` = `p`.`nik_pegawai`)))  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_jadwal_mapel`
--
ALTER TABLE `detail_jadwal_mapel`
  ADD PRIMARY KEY (`id_jadwal_mapel`),
  ADD KEY `fk_idkelas` (`id_kelas`),
  ADD KEY `fk_kd_mapel` (`kd_mapel`),
  ADD KEY `fk_guru` (`nik_pegawai`);

--
-- Indexes for table `tb_jenispegawai`
--
ALTER TABLE `tb_jenispegawai`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `fk_nikpegawai` (`nik_pegawai`);

--
-- Indexes for table `tb_mapel`
--
ALTER TABLE `tb_mapel`
  ADD PRIMARY KEY (`kd_mapel`);

--
-- Indexes for table `tb_orangtua`
--
ALTER TABLE `tb_orangtua`
  ADD PRIMARY KEY (`nik_ortu`);

--
-- Indexes for table `tb_pegawai`
--
ALTER TABLE `tb_pegawai`
  ADD PRIMARY KEY (`nik_pegawai`),
  ADD KEY `fk_jenis` (`id_jenis`);

--
-- Indexes for table `tb_presensi`
--
ALTER TABLE `tb_presensi`
  ADD PRIMARY KEY (`id_presensi`),
  ADD KEY `fk_nis` (`nis`),
  ADD KEY `fk_surat` (`id_surat`),
  ADD KEY `fk_kelas` (`id_kelas`);

--
-- Indexes for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`nis`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `nik_ortu` (`nik_ortu`);

--
-- Indexes for table `tb_suratizin`
--
ALTER TABLE `tb_suratizin`
  ADD PRIMARY KEY (`id_surat`),
  ADD KEY `fk_pegawai` (`nik_pegawai`),
  ADD KEY `fk_ortu` (`nik_ortu`),
  ADD KEY `fk_nissiswa` (`nis`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_jadwal_mapel`
--
ALTER TABLE `detail_jadwal_mapel`
  MODIFY `id_jadwal_mapel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tb_jenispegawai`
--
ALTER TABLE `tb_jenispegawai`
  MODIFY `id_jenis` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_presensi`
--
ALTER TABLE `tb_presensi`
  MODIFY `id_presensi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tb_suratizin`
--
ALTER TABLE `tb_suratizin`
  MODIFY `id_surat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_jadwal_mapel`
--
ALTER TABLE `detail_jadwal_mapel`
  ADD CONSTRAINT `fk_guru` FOREIGN KEY (`nik_pegawai`) REFERENCES `tb_pegawai` (`nik_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idkelas` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_kd_mapel` FOREIGN KEY (`kd_mapel`) REFERENCES `tb_mapel` (`kd_mapel`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD CONSTRAINT `fk_nikpegawai` FOREIGN KEY (`nik_pegawai`) REFERENCES `tb_pegawai` (`nik_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_pegawai`
--
ALTER TABLE `tb_pegawai`
  ADD CONSTRAINT `fk_jenis` FOREIGN KEY (`id_jenis`) REFERENCES `tb_jenispegawai` (`id_jenis`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_presensi`
--
ALTER TABLE `tb_presensi`
  ADD CONSTRAINT `fk_kelas` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_nis` FOREIGN KEY (`nis`) REFERENCES `tb_siswa` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_surat` FOREIGN KEY (`id_surat`) REFERENCES `tb_suratizin` (`id_surat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD CONSTRAINT `fk_idkelassiswa` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_siswaortu` FOREIGN KEY (`nik_ortu`) REFERENCES `tb_orangtua` (`nik_ortu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_suratizin`
--
ALTER TABLE `tb_suratizin`
  ADD CONSTRAINT `fk_nissiswa` FOREIGN KEY (`nis`) REFERENCES `tb_siswa` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ortu` FOREIGN KEY (`nik_ortu`) REFERENCES `tb_orangtua` (`nik_ortu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pegawai` FOREIGN KEY (`nik_pegawai`) REFERENCES `tb_pegawai` (`nik_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
