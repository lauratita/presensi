-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 11, 2024 at 01:38 AM
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
-- Database: `db_presensicekinout`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_foto`
--

CREATE TABLE `tb_foto` (
  `id_foto` varchar(20) NOT NULL,
  `foto_depan` varchar(100) DEFAULT NULL,
  `foto_kanan` varchar(100) DEFAULT NULL,
  `foto_kiri` varchar(100) DEFAULT NULL,
  `foto_atas` varchar(100) DEFAULT NULL,
  `foto_bawah` varchar(100) DEFAULT NULL,
  `nis` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jadwal`
--

CREATE TABLE `tb_jadwal` (
  `id_jadwal` varchar(20) NOT NULL,
  `hari` varchar(10) DEFAULT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `toleransi_masuk` time DEFAULT NULL,
  `toleransi_keluar` time DEFAULT NULL,
  `id_kelas` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jadwal_mapel`
--

CREATE TABLE `tb_jadwal_mapel` (
  `id_jadwal_mapel` varchar(20) NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jum''at','Sabtu') NOT NULL,
  `id_kelas` varchar(20) NOT NULL,
  `kd_mapel` varchar(10) NOT NULL,
  `nik_pegawai` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jenispegawai`
--

CREATE TABLE `tb_jenispegawai` (
  `id_jenis` varchar(20) NOT NULL,
  `nama` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_jenispegawai`
--

INSERT INTO `tb_jenispegawai` (`id_jenis`, `nama`) VALUES
('1', 'Admin'),
('2', 'Guru');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kelas`
--

CREATE TABLE `tb_kelas` (
  `id_kelas` varchar(20) NOT NULL,
  `nama_kelas` varchar(50) DEFAULT NULL,
  `nik_pegawai` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_mapel`
--

CREATE TABLE `tb_mapel` (
  `kd_mapel` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
('1237646', 'Liza', 'Jember', '656236e', 'perempuan', 'liza@gmail.com', '223344'),
('3243434546', 'Ita Nurlaili ', 'Jawa timur', '082336938797', 'perempuan', 'ita@gmail.com', '11223344'),
('3456', 'Lila', 'jember', '3456788', 'perempuan', 'lila12@gmail.com', '123');

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
  `id_jenis` varchar(20) DEFAULT NULL,
  `mp1` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `mp2` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_pegawai`
--

INSERT INTO `tb_pegawai` (`nik_pegawai`, `nama`, `alamat`, `jenis_kelamin`, `password`, `no_hp`, `email`, `id_jenis`, `mp1`, `mp2`) VALUES
('12345678910', 'Ita', 'Bondowoso', 'perempuan', '123456', '6282336928797', 'ita@gmail.com', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_presensi`
--

CREATE TABLE `tb_presensi` (
  `id_presensi` varchar(20) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `jam_datang` time DEFAULT NULL,
  `jam_pulang` time DEFAULT NULL,
  `valid_foto_datang` tinyint(1) DEFAULT NULL,
  `valid_foto_pulang` tinyint(1) DEFAULT NULL,
  `id_jadwal` varchar(20) DEFAULT NULL,
  `nis` varchar(20) DEFAULT NULL,
  `id_surat` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `nis` varchar(20) NOT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `tahun_akademik` date DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `id_kelas` varchar(20) DEFAULT NULL,
  `nik_ortu` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_suratizin`
--

CREATE TABLE `tb_suratizin` (
  `id_surat` varchar(25) NOT NULL,
  `keterangan` enum('izin','sakit') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status` enum('verified','unverified','disable') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `foto_surat` varchar(100) NOT NULL,
  `nik_ortu` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_jadwal_kelas`
-- (See below for the actual view)
--
CREATE TABLE `v_jadwal_kelas` (
`hari` varchar(10)
,`id_jadwal` varchar(20)
,`jam_keluar` time
,`jam_masuk` time
,`nama_kelas` varchar(50)
,`toleransi_keluar` time
,`toleransi_masuk` time
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_mapel`
-- (See below for the actual view)
--
CREATE TABLE `v_mapel` (
`hari` enum('Senin','Selasa','Rabu','Kamis','Jum''at','Sabtu')
,`id_jadwal_mapel` varchar(20)
,`nama_kelas` varchar(50)
,`nama_mapel` varchar(50)
,`nama_pegawai` varchar(50)
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
-- Stand-in structure for view `v_presensi_jadwal_siswa`
-- (See below for the actual view)
--
CREATE TABLE `v_presensi_jadwal_siswa` (
`hari` varchar(10)
,`id_presensi` varchar(20)
,`jam_datang` time
,`jam_keluar` time
,`jam_masuk` time
,`jam_pulang` time
,`nama_siswa` varchar(50)
,`nis` varchar(20)
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
`alamat_siswa` varchar(255)
,`jenis_kelamin_siswa` enum('laki-laki','perempuan')
,`nama_kelas` varchar(50)
,`nama_orangtua` varchar(50)
,`nama_siswa` varchar(50)
,`nis` varchar(20)
,`tahun_akademik` date
,`tanggal_lahir` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_suratizin_ket`
-- (See below for the actual view)
--
CREATE TABLE `v_suratizin_ket` (
`id_surat` varchar(25)
,`keterangan` enum('izin','sakit')
,`nama_orangtua` varchar(50)
,`nama_siswa` varchar(50)
,`nis` varchar(20)
,`status` enum('verified','unverified','disable')
,`tanggal_surat` date
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
-- Structure for view `v_jadwal_kelas`
--
DROP TABLE IF EXISTS `v_jadwal_kelas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_jadwal_kelas`  AS SELECT `j`.`id_jadwal` AS `id_jadwal`, `j`.`hari` AS `hari`, `j`.`jam_masuk` AS `jam_masuk`, `j`.`jam_keluar` AS `jam_keluar`, `j`.`toleransi_masuk` AS `toleransi_masuk`, `j`.`toleransi_keluar` AS `toleransi_keluar`, `k`.`nama_kelas` AS `nama_kelas` FROM (`tb_jadwal` `j` join `tb_kelas` `k` on((`j`.`id_kelas` = `k`.`id_kelas`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_mapel`
--
DROP TABLE IF EXISTS `v_mapel`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_mapel`  AS SELECT `jm`.`id_jadwal_mapel` AS `id_jadwal_mapel`, `jm`.`hari` AS `hari`, `k`.`nama_kelas` AS `nama_kelas`, `m`.`nama` AS `nama_mapel`, `p`.`nama` AS `nama_pegawai` FROM (((`tb_jadwal_mapel` `jm` join `tb_kelas` `k` on((`jm`.`id_kelas` = `k`.`id_kelas`))) join `tb_mapel` `m` on((`jm`.`kd_mapel` = `m`.`kd_mapel`))) join `tb_pegawai` `p` on((`jm`.`nik_pegawai` = `p`.`nik_pegawai`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_pegawai_detail`
--
DROP TABLE IF EXISTS `v_pegawai_detail`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_pegawai_detail`  AS SELECT `p`.`nik_pegawai` AS `nik_pegawai`, `p`.`nama` AS `nama_pegawai`, `p`.`alamat` AS `alamat`, `p`.`jenis_kelamin` AS `jenis_kelamin`, `p`.`no_hp` AS `no_hp`, `p`.`email` AS `email`, `jp`.`nama` AS `jenis_pegawai` FROM (`tb_pegawai` `p` join `tb_jenispegawai` `jp` on((`p`.`id_jenis` = `jp`.`id_jenis`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_presensi_jadwal_siswa`
--
DROP TABLE IF EXISTS `v_presensi_jadwal_siswa`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_presensi_jadwal_siswa`  AS SELECT `p`.`id_presensi` AS `id_presensi`, `p`.`tanggal` AS `tanggal`, `p`.`jam_datang` AS `jam_datang`, `p`.`jam_pulang` AS `jam_pulang`, `p`.`valid_foto_datang` AS `valid_foto_datang`, `p`.`valid_foto_pulang` AS `valid_foto_pulang`, `s`.`nis` AS `nis`, `s`.`nama` AS `nama_siswa`, `j`.`hari` AS `hari`, `j`.`jam_masuk` AS `jam_masuk`, `j`.`jam_keluar` AS `jam_keluar` FROM ((`tb_presensi` `p` join `tb_siswa` `s` on((`p`.`nis` = `s`.`nis`))) join `tb_jadwal` `j` on((`p`.`id_jadwal` = `j`.`id_jadwal`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_siswa_ortu_kelas`
--
DROP TABLE IF EXISTS `v_siswa_ortu_kelas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_siswa_ortu_kelas`  AS SELECT `s`.`nis` AS `nis`, `s`.`nama` AS `nama_siswa`, `s`.`tanggal_lahir` AS `tanggal_lahir`, `s`.`tahun_akademik` AS `tahun_akademik`, `s`.`jenis_kelamin` AS `jenis_kelamin_siswa`, `s`.`alamat` AS `alamat_siswa`, `k`.`nama_kelas` AS `nama_kelas`, `o`.`nama` AS `nama_orangtua` FROM ((`tb_siswa` `s` join `tb_kelas` `k` on((`s`.`id_kelas` = `k`.`id_kelas`))) join `tb_orangtua` `o` on((`s`.`nik_ortu` = `o`.`nik_ortu`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_suratizin_ket`
--
DROP TABLE IF EXISTS `v_suratizin_ket`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_suratizin_ket`  AS SELECT `sz`.`id_surat` AS `id_surat`, `sz`.`keterangan` AS `keterangan`, `sz`.`status` AS `status`, `sz`.`tanggal` AS `tanggal_surat`, `s`.`nis` AS `nis`, `s`.`nama` AS `nama_siswa`, `o`.`nama` AS `nama_orangtua` FROM ((`tb_suratizin` `sz` join `tb_siswa` `s` on((`sz`.`nik_ortu` = `s`.`nik_ortu`))) join `tb_orangtua` `o` on((`sz`.`nik_ortu` = `o`.`nik_ortu`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_wali_kelas`
--
DROP TABLE IF EXISTS `v_wali_kelas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_wali_kelas`  AS SELECT `k`.`id_kelas` AS `id_kelas`, `k`.`nama_kelas` AS `nama_kelas`, `p`.`nama` AS `nama_wali_kelas` FROM (`tb_kelas` `k` join `tb_pegawai` `p` on((`k`.`nik_pegawai` = `p`.`nik_pegawai`))) ;

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
-- Indexes for table `tb_jadwal_mapel`
--
ALTER TABLE `tb_jadwal_mapel`
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
  ADD KEY `nik_pegawai` (`nik_pegawai`);

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
  ADD KEY `fk_jenispegawai` (`id_jenis`),
  ADD KEY `fk_mapel1` (`mp1`),
  ADD KEY `fk_mapel2` (`mp2`);

--
-- Indexes for table `tb_presensi`
--
ALTER TABLE `tb_presensi`
  ADD PRIMARY KEY (`id_presensi`),
  ADD KEY `id_jadwal` (`id_jadwal`),
  ADD KEY `nis` (`nis`),
  ADD KEY `id_surat` (`id_surat`);

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
  ADD KEY `fk_nikortu` (`nik_ortu`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_foto`
--
ALTER TABLE `tb_foto`
  ADD CONSTRAINT `tb_foto_ibfk_1` FOREIGN KEY (`nis`) REFERENCES `tb_siswa` (`nis`);

--
-- Constraints for table `tb_jadwal`
--
ALTER TABLE `tb_jadwal`
  ADD CONSTRAINT `tb_jadwal_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id_kelas`);

--
-- Constraints for table `tb_jadwal_mapel`
--
ALTER TABLE `tb_jadwal_mapel`
  ADD CONSTRAINT `fk_guru` FOREIGN KEY (`nik_pegawai`) REFERENCES `tb_pegawai` (`nik_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idkelas` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_kd_mapel` FOREIGN KEY (`kd_mapel`) REFERENCES `tb_mapel` (`kd_mapel`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD CONSTRAINT `tb_kelas_ibfk_1` FOREIGN KEY (`nik_pegawai`) REFERENCES `tb_pegawai` (`nik_pegawai`);

--
-- Constraints for table `tb_pegawai`
--
ALTER TABLE `tb_pegawai`
  ADD CONSTRAINT `fk_jenispegawai` FOREIGN KEY (`id_jenis`) REFERENCES `tb_jenispegawai` (`id_jenis`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_mapel1` FOREIGN KEY (`mp1`) REFERENCES `tb_mapel` (`kd_mapel`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_mapel2` FOREIGN KEY (`mp2`) REFERENCES `tb_mapel` (`kd_mapel`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_presensi`
--
ALTER TABLE `tb_presensi`
  ADD CONSTRAINT `tb_presensi_ibfk_1` FOREIGN KEY (`id_jadwal`) REFERENCES `tb_jadwal` (`id_jadwal`),
  ADD CONSTRAINT `tb_presensi_ibfk_2` FOREIGN KEY (`nis`) REFERENCES `tb_siswa` (`nis`),
  ADD CONSTRAINT `tb_presensi_ibfk_3` FOREIGN KEY (`id_surat`) REFERENCES `tb_suratizin` (`id_surat`);

--
-- Constraints for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD CONSTRAINT `tb_siswa_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id_kelas`),
  ADD CONSTRAINT `tb_siswa_ibfk_2` FOREIGN KEY (`nik_ortu`) REFERENCES `tb_orangtua` (`nik_ortu`);

--
-- Constraints for table `tb_suratizin`
--
ALTER TABLE `tb_suratizin`
  ADD CONSTRAINT `fk_nikortu` FOREIGN KEY (`nik_ortu`) REFERENCES `tb_orangtua` (`nik_ortu`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
