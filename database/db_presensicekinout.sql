-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 12, 2024 at 12:54 PM
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
-- Database: `1test`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_foto`
--

CREATE TABLE `tb_foto` (
  `id_foto` int NOT NULL,
  `nis` varchar(20) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jadwal`
--

CREATE TABLE `tb_jadwal` (
  `id_jadwal` int NOT NULL,
  `id_kelas` int NOT NULL,
  `hari` varchar(20) DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `interval_keterlambatan_masuk` time NOT NULL,
  `interval_keterlambatan_pulang` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jenis_pegawai`
--

CREATE TABLE `tb_jenis_pegawai` (
  `id_jenis` int NOT NULL,
  `nama` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_kelas`
--

CREATE TABLE `tb_kelas` (
  `id_kelas` int NOT NULL,
  `nama_kelas` varchar(50) DEFAULT NULL,
  `nik` char(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_ortu`
--

CREATE TABLE `tb_ortu` (
  `id_ortu` varchar(20) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `alamat` varchar(200) DEFAULT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pegawai`
--

CREATE TABLE `tb_pegawai` (
  `nik` char(16) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') NOT NULL,
  `id_jenis` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_presensi`
--

CREATE TABLE `tb_presensi` (
  `id_presensi` int NOT NULL,
  `id_jadwal` int NOT NULL,
  `nis` char(10) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jam_datang` time DEFAULT NULL,
  `jam_pulang` time DEFAULT NULL,
  `valid_foto_datang` tinyint(1) DEFAULT NULL,
  `valid_foto_pulang` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `nis` char(10) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `tahun_masuk` year DEFAULT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `id_kelas` int DEFAULT NULL,
  `id_ortu` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_jadwal_kelas`
-- (See below for the actual view)
--
CREATE TABLE `v_jadwal_kelas` (
`hari` varchar(20)
,`id_jadwal` int
,`interval_keterlambatan_masuk` time
,`interval_keterlambatan_pulang` time
,`jam_keluar` time
,`jam_masuk` time
,`nama_kelas` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_jenis_pegawai`
-- (See below for the actual view)
--
CREATE TABLE `v_jenis_pegawai` (
`jenis_pegawai` varchar(100)
,`nama_pegawai` varchar(100)
,`nik` char(16)
,`password` varchar(100)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_presensi_siswa`
-- (See below for the actual view)
--
CREATE TABLE `v_presensi_siswa` (
`hari` varchar(20)
,`id_presensi` int
,`jam_datang` time
,`jam_keluar` time
,`jam_masuk` time
,`jam_pulang` time
,`nama_kelas` varchar(50)
,`nama_siswa` varchar(100)
,`nis` char(10)
,`tanggal` date
,`valid_foto_datang` tinyint(1)
,`valid_foto_pulang` tinyint(1)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_siswa_ortu_kelas`
-- (See below for the actual view)
--
CREATE TABLE `v_siswa_ortu_kelas` (
`alamat_ortu` varchar(200)
,`nama_kelas` varchar(50)
,`nama_ortu` varchar(100)
,`nama_siswa` varchar(100)
,`nis` char(10)
,`tahun_masuk` year
,`tanggal_lahir` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_wali_kelas`
-- (See below for the actual view)
--
CREATE TABLE `v_wali_kelas` (
`nama_kelas` varchar(50)
,`nama_pegawai` varchar(100)
,`nik` char(16)
);

-- --------------------------------------------------------

--
-- Structure for view `v_jadwal_kelas`
--
DROP TABLE IF EXISTS `v_jadwal_kelas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_jadwal_kelas`  AS SELECT `j`.`id_jadwal` AS `id_jadwal`, `k`.`nama_kelas` AS `nama_kelas`, `j`.`hari` AS `hari`, `j`.`jam_masuk` AS `jam_masuk`, `j`.`jam_keluar` AS `jam_keluar`, `j`.`interval_keterlambatan_masuk` AS `interval_keterlambatan_masuk`, `j`.`interval_keterlambatan_pulang` AS `interval_keterlambatan_pulang` FROM (`tb_jadwal` `j` join `tb_kelas` `k` on((`j`.`id_kelas` = `k`.`id_kelas`)))  ;

-- --------------------------------------------------------

--
-- Structure for view `v_jenis_pegawai`
--
DROP TABLE IF EXISTS `v_jenis_pegawai`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_jenis_pegawai`  AS SELECT `p`.`nik` AS `nik`, `p`.`nama` AS `nama_pegawai`, `p`.`password` AS `password`, `j`.`nama` AS `jenis_pegawai` FROM (`tb_pegawai` `p` join `tb_jenis_pegawai` `j` on((`p`.`id_jenis` = `j`.`id_jenis`)))  ;

-- --------------------------------------------------------

--
-- Structure for view `v_presensi_siswa`
--
DROP TABLE IF EXISTS `v_presensi_siswa`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_presensi_siswa`  AS SELECT `p`.`id_presensi` AS `id_presensi`, `s`.`nis` AS `nis`, `s`.`nama` AS `nama_siswa`, `k`.`nama_kelas` AS `nama_kelas`, `j`.`hari` AS `hari`, `j`.`jam_masuk` AS `jam_masuk`, `j`.`jam_keluar` AS `jam_keluar`, `p`.`tanggal` AS `tanggal`, `p`.`jam_datang` AS `jam_datang`, `p`.`jam_pulang` AS `jam_pulang`, `p`.`valid_foto_datang` AS `valid_foto_datang`, `p`.`valid_foto_pulang` AS `valid_foto_pulang` FROM (((`tb_presensi` `p` join `tb_siswa` `s` on((`p`.`nis` = `s`.`nis`))) join `tb_kelas` `k` on((`s`.`id_kelas` = `k`.`id_kelas`))) join `tb_jadwal` `j` on((`p`.`id_jadwal` = `j`.`id_jadwal`)))  ;

-- --------------------------------------------------------

--
-- Structure for view `v_siswa_ortu_kelas`
--
DROP TABLE IF EXISTS `v_siswa_ortu_kelas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_siswa_ortu_kelas`  AS SELECT `s`.`nis` AS `nis`, `s`.`nama` AS `nama_siswa`, `s`.`tanggal_lahir` AS `tanggal_lahir`, `s`.`tahun_masuk` AS `tahun_masuk`, `o`.`nama` AS `nama_ortu`, `o`.`alamat` AS `alamat_ortu`, `k`.`nama_kelas` AS `nama_kelas` FROM ((`tb_siswa` `s` left join `tb_ortu` `o` on((`s`.`id_ortu` = `o`.`id_ortu`))) left join `tb_kelas` `k` on((`s`.`id_kelas` = `k`.`id_kelas`)))  ;

-- --------------------------------------------------------

--
-- Structure for view `v_wali_kelas`
--
DROP TABLE IF EXISTS `v_wali_kelas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_wali_kelas`  AS SELECT `p`.`nik` AS `nik`, `p`.`nama` AS `nama_pegawai`, `k`.`nama_kelas` AS `nama_kelas` FROM (`tb_kelas` `k` join `tb_pegawai` `p` on((`k`.`nik` = `p`.`nik`)))  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_foto`
--
ALTER TABLE `tb_foto`
  ADD PRIMARY KEY (`id_foto`),
  ADD KEY `nis` (`nis`);

--
-- Indexes for table `tb_jadwal`
--
ALTER TABLE `tb_jadwal`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `tb_jenis_pegawai`
--
ALTER TABLE `tb_jenis_pegawai`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `fk_kelas_pegawai` (`nik`),
  ADD KEY `idx_kelas_nik` (`nik`);

--
-- Indexes for table `tb_ortu`
--
ALTER TABLE `tb_ortu`
  ADD PRIMARY KEY (`id_ortu`);

--
-- Indexes for table `tb_pegawai`
--
ALTER TABLE `tb_pegawai`
  ADD PRIMARY KEY (`nik`),
  ADD KEY `fk_jenis_pegawai` (`id_jenis`);

--
-- Indexes for table `tb_presensi`
--
ALTER TABLE `tb_presensi`
  ADD PRIMARY KEY (`id_presensi`),
  ADD KEY `fk_presensi_jadwal` (`id_jadwal`),
  ADD KEY `nis` (`nis`),
  ADD KEY `idx_presensi_nis` (`nis`);

--
-- Indexes for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`nis`),
  ADD KEY `fk_siswa_kelas` (`id_kelas`),
  ADD KEY `fk_siswa_ortu` (`id_ortu`),
  ADD KEY `idx_siswa_kelas` (`id_kelas`),
  ADD KEY `idx_siswa_ortu` (`id_ortu`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_foto`
--
ALTER TABLE `tb_foto`
  MODIFY `id_foto` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_jadwal`
--
ALTER TABLE `tb_jadwal`
  MODIFY `id_jadwal` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_jenis_pegawai`
--
ALTER TABLE `tb_jenis_pegawai`
  MODIFY `id_jenis` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  MODIFY `id_kelas` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_presensi`
--
ALTER TABLE `tb_presensi`
  MODIFY `id_presensi` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_foto`
--
ALTER TABLE `tb_foto`
  ADD CONSTRAINT `tb_foto_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `tb_siswa` (`nis`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_jadwal`
--
ALTER TABLE `tb_jadwal`
  ADD CONSTRAINT `fk_jadwal_kelas` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id_kelas`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD CONSTRAINT `fk_kelas_pegawai` FOREIGN KEY (`nik`) REFERENCES `tb_pegawai` (`nik`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `tb_pegawai`
--
ALTER TABLE `tb_pegawai`
  ADD CONSTRAINT `fk_pegawai_jenis` FOREIGN KEY (`id_jenis`) REFERENCES `tb_jenis_pegawai` (`id_jenis`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tb_presensi`
--
ALTER TABLE `tb_presensi`
  ADD CONSTRAINT `fk_presensi_jadwal` FOREIGN KEY (`id_jadwal`) REFERENCES `tb_jadwal` (`id_jadwal`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_presensi_siswa` FOREIGN KEY (`nis`) REFERENCES `tb_siswa` (`nis`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Constraints for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD CONSTRAINT `fk_siswa_kelas` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id_kelas`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_siswa_ortu` FOREIGN KEY (`id_ortu`) REFERENCES `tb_ortu` (`id_ortu`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
