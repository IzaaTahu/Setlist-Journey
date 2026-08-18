-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql305.infinityfree.com
-- Generation Time: Aug 17, 2026 at 08:27 PM
-- Server version: 11.4.12-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_41786085_setlist_journey1`
--

-- --------------------------------------------------------

--
-- Table structure for table `chapters`
--

CREATE TABLE `chapters` (
  `id_chapter` int(11) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tema_warna` varchar(7) DEFAULT '#C084FC',
  `bg_image` varchar(255) DEFAULT NULL,
  `urutan` int(11) NOT NULL,
  `is_active` tinyint(1) DEFAULT 0,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp(),
  `dekorasi` varchar(50) DEFAULT 'none'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chapters`
--

INSERT INTO `chapters` (`id_chapter`, `judul`, `slug`, `deskripsi`, `tema_warna`, `bg_image`, `urutan`, `is_active`, `dibuat_pada`, `dekorasi`) VALUES
(1, 'Cara Meminum Ramune', 'cara-meminum-ramune', 'Perjalanan pertamamu dimulai di sini. Ikuti setlist pembuka yang penuh semangat.', '#4A90B8', NULL, 1, 1, '2026-05-17 12:08:58', 'bubble'),
(2, 'Sambil Menggandeng Erat Tanganmu', 'sambil-menggandeng-erat-tanganmu', 'Chapter berikutnya — selesaikan Chapter 1 untuk membukanya.', '#D4618A', NULL, 2, 0, '2026-05-17 12:09:11', 'confetti');

-- --------------------------------------------------------

--
-- Table structure for table `guestbook`
--

CREATE TABLE `guestbook` (
  `id_pesan` int(11) NOT NULL,
  `id_chapter` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `nama` varchar(200) DEFAULT NULL,
  `pesan` text NOT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guestbook`
--

INSERT INTO `guestbook` (`id_pesan`, `id_chapter`, `id_user`, `nama`, `pesan`, `dibuat_pada`) VALUES
(1, 1, 1, 'kentang', 'aku admin kau ...', '2026-05-17 12:17:52'),
(2, 1, 4, 'kursi', 'keren banget njirr', '2026-05-21 00:59:24'),
(3, 1, NULL, 'Fidan Luthfullahi', 'welek', '2026-05-21 04:59:11');

-- --------------------------------------------------------

--
-- Table structure for table `milestones`
--

CREATE TABLE `milestones` (
  `id_milestone` int(11) NOT NULL,
  `id_chapter` int(11) NOT NULL,
  `setelah_track` int(11) NOT NULL,
  `judul` varchar(200) DEFAULT NULL,
  `pesan` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `milestones`
--

INSERT INTO `milestones` (`id_milestone`, `id_chapter`, `setelah_track`, `judul`, `pesan`, `foto`, `dibuat_pada`) VALUES
(1, 1, 8, 'Separuh Perjalanan', 'Kamu sudah melewati 8 lagu pertama. Dari optimisme Kizashi hingga kenakalan Usotsuki Dachou — setiap lagu punya dunianya sendiri. Masih ada 8 lagu lagi, dan yang terbaik belum datang.', NULL, '2026-05-17 12:11:15'),
(2, 1, 14, 'Hampir Sampai', 'Dua lagu lagi. Sebentar lagi kamu akan sampai di momen yang paling banyak membuat member menangis di atas panggung. Bersiaplah.', NULL, '2026-05-17 12:11:15');

-- --------------------------------------------------------

--
-- Table structure for table `quests`
--

CREATE TABLE `quests` (
  `id_quest` int(11) NOT NULL,
  `id_track` int(11) NOT NULL,
  `tipe` enum('trivia','tebak_lirik','tebak_siluet','susun_lirik','baca_lore','easter_egg','tulis_kesan','decode_cipher') NOT NULL,
  `pertanyaan` text DEFAULT NULL,
  `durasi_baca` int(11) DEFAULT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quests`
--

INSERT INTO `quests` (`id_quest`, `id_track`, `tipe`, `pertanyaan`, `durasi_baca`, `dibuat_pada`) VALUES
(1, 1, 'baca_lore', 'Baca dan resapi sebelum melanjutkan perjalananmu...', 30, '2026-05-17 12:11:09'),
(2, 2, 'trivia', 'Di lagu Koutei no Koinu, center berperan sebagai seekor anjing yang bebas mengganggu member lain. Apa makna tersembunyi di balik adegan ini?', NULL, '2026-05-17 12:11:09'),
(3, 3, 'tebak_lirik', 'Lengkapi lirik berikut: \"Di depan orang lain, kau ___ku. Tapi kalau berdua, kamu ___ku.\" (pisahkan dengan koma, contoh: kata1, kata2)', NULL, '2026-05-17 12:11:09'),
(4, 4, 'trivia', '\"Omatase\" dalam bahasa Jepang memiliki arti...', NULL, '2026-05-17 12:11:09'),
(5, 5, 'decode_cipher', 'Sebuah pesan tersembunyi ditemukan di balik panggung. Decode-lah pesan ini: SHENAHV (Petunjuk: setiap huruf digeser 13 langkah dalam alfabet — A jadi N, B jadi O, dan seterusnya)', NULL, '2026-05-17 12:11:09'),
(6, 6, 'easter_egg', 'Ada sesuatu yang tersembunyi di halaman ini. Temukan!', NULL, '2026-05-17 12:11:09'),
(7, 7, 'baca_lore', 'Lagu ini hanya untuk dirasakan. Bacalah perlahan...', 30, '2026-05-17 12:11:09'),
(8, 8, 'trivia', '\"Usotsuki Dachou\" jika diterjemahkan ke bahasa Indonesia berarti...', NULL, '2026-05-17 12:11:09'),
(9, 9, 'tulis_kesan', 'Kamu baru saja tiba di dunia ini. Tuliskan satu hal yang kamu rasakan sekarang.', NULL, '2026-05-17 12:11:09'),
(10, 10, 'trivia', 'Siapa satu-satunya member JKT48 yang memiliki latar belakang balet sungguhan dan kini menjadi center Kodoku no Ballerina?', NULL, '2026-05-17 12:11:09'),
(11, 11, 'tulis_kesan', 'Lagu ini tentang bersyukur atas momen sekarang. Tuliskan satu hal yang kamu syukuri hari ini.', NULL, '2026-05-17 12:11:09'),
(12, 12, 'trivia', 'Di bagian akhir Winning Ball, member melempar bola kasti ke arah penonton. Apa yang terjadi dengan bola yang berhasil ditangkap?', NULL, '2026-05-17 12:11:09'),
(13, 13, 'tebak_lirik', 'Lengkapi lirik berikut: \"Energi yang kuterima sekarang, ___ untuk berlari.\"', NULL, '2026-05-17 12:11:09'),
(14, 14, 'easter_egg', 'Psst... ada bola yang menggelinding di suatu tempat. Temukan!', NULL, '2026-05-17 12:11:09'),
(15, 15, 'trivia', '12-iro no Yume Crayon biasanya dibawakan di posisi mana dalam setlist Cara Meminum Ramune?', NULL, '2026-05-17 12:11:09'),
(16, 16, 'baca_lore', 'Ini adalah akhir dari perjalanan pertamamu. Tidak perlu terburu-buru.', 30, '2026-05-17 12:11:09');

-- --------------------------------------------------------

--
-- Table structure for table `quest_log`
--

CREATE TABLE `quest_log` (
  `id_log` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_quest` int(11) NOT NULL,
  `jawaban` text DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT NULL,
  `dikerjakan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quest_log`
--

INSERT INTO `quest_log` (`id_log`, `id_user`, `id_quest`, `jawaban`, `is_correct`, `dikerjakan`) VALUES
(1, 1, 1, 'baca_lore_done', NULL, '2026-05-17 12:12:25'),
(2, 1, 2, 'Menguji apakah member junior sudah akrab dan tidak sungkan dengan seniornya', 1, '2026-05-17 12:12:32'),
(3, 1, 3, 'guruku, pacarku', 1, '2026-05-17 12:12:41'),
(4, 1, 4, 'Sudah menunggu lama ya', 1, '2026-05-17 12:12:51'),
(5, 1, 5, 'furanui', 1, '2026-05-17 12:14:18'),
(6, 1, 6, 'easter_egg_found', NULL, '2026-05-17 12:14:27'),
(7, 1, 7, 'baca_lore_done', NULL, '2026-05-17 12:15:48'),
(8, 1, 8, 'Burung Unta si Pembohong', 1, '2026-05-17 12:15:57'),
(9, 1, 9, 'bete', NULL, '2026-05-17 12:16:09'),
(10, 1, 10, 'Oline', 1, '2026-05-17 12:16:16'),
(11, 1, 11, 'makan mie', NULL, '2026-05-17 12:16:27'),
(12, 1, 12, 'Bisa dibawa pulang oleh penonton sebagai kenang-kenangan', 1, '2026-05-17 12:16:34'),
(13, 1, 13, 'kan kusimpan', 1, '2026-05-17 12:16:43'),
(14, 1, 14, 'easter_egg_found', NULL, '2026-05-17 12:16:52'),
(15, 1, 15, 'Menjelang lagu penutup', 1, '2026-05-17 12:17:00'),
(16, 1, 16, 'baca_lore_done', NULL, '2026-05-17 12:17:38'),
(17, 1, 16, 'baca_lore_done', NULL, '2026-05-18 03:04:39'),
(18, 1, 16, 'baca_lore_done', NULL, '2026-05-18 03:04:41'),
(19, 4, 1, 'baca_lore_done', NULL, '2026-05-21 00:52:06'),
(20, 4, 2, 'Menguji apakah member junior sudah akrab dan tidak sungkan dengan seniornya', 1, '2026-05-21 00:52:14'),
(21, 4, 3, 'guruku, pacarku', 1, '2026-05-21 00:52:24'),
(22, 4, 4, 'Sudah menunggu lama ya', 1, '2026-05-21 00:52:34'),
(23, 4, 5, 'furanui', 1, '2026-05-21 00:52:44'),
(24, 4, 6, 'easter_egg_found', NULL, '2026-05-21 00:52:53'),
(25, 4, 7, 'baca_lore_done', NULL, '2026-05-21 00:53:31'),
(26, 4, 8, 'Burung Unta si Pembohong', 1, '2026-05-21 00:53:56'),
(27, 4, 9, 'senang', NULL, '2026-05-21 00:54:28'),
(28, 4, 10, 'Oline', 1, '2026-05-21 00:54:48'),
(29, 4, 11, 'bigel cantik banget', NULL, '2026-05-21 00:55:27'),
(30, 4, 12, 'Bisa dibawa pulang oleh penonton sebagai kenang-kenangan', 1, '2026-05-21 00:55:39'),
(31, 4, 13, 'kan kusimpan', 1, '2026-05-21 00:55:55'),
(32, 4, 14, 'easter_egg_found', NULL, '2026-05-21 00:56:19'),
(33, 4, 15, 'Menjelang lagu penutup', 1, '2026-05-21 00:56:27'),
(34, 4, 16, 'baca_lore_done', NULL, '2026-05-21 00:59:03'),
(35, 6, 1, 'baca_lore_done', NULL, '2026-05-21 08:53:20'),
(36, 6, 2, 'Menguji apakah member junior sudah akrab dan tidak sungkan dengan seniornya', 1, '2026-05-21 08:53:59'),
(37, 6, 3, 'guru,pacar', 0, '2026-05-21 08:55:10'),
(38, 6, 3, 'guruku,pacarku', 0, '2026-05-21 08:55:17'),
(39, 6, 3, 'guruku ,pacarku', 0, '2026-05-21 08:55:24'),
(40, 6, 3, 'guruku, pacarku', 1, '2026-05-21 08:55:29'),
(41, 1, 4, 'Terima kasih sudah datang', 0, '2026-07-18 08:11:18'),
(42, 1, 4, 'Terima kasih sudah datang', 0, '2026-07-18 08:11:26'),
(43, 1, 4, 'Terima kasih sudah datang', 0, '2026-07-18 08:11:30');

-- --------------------------------------------------------

--
-- Table structure for table `quest_options`
--

CREATE TABLE `quest_options` (
  `id_option` int(11) NOT NULL,
  `id_quest` int(11) NOT NULL,
  `teks_opsi` text NOT NULL,
  `is_correct` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quest_options`
--

INSERT INTO `quest_options` (`id_option`, `id_quest`, `teks_opsi`, `is_correct`) VALUES
(1, 2, 'Menunjukkan siapa member paling populer', 0),
(2, 2, 'Menguji apakah member junior sudah akrab dan tidak sungkan dengan seniornya', 1),
(3, 2, 'Tradisi lama dari AKB48 yang diwariskan ke JKT48', 0),
(4, 2, 'Menentukan siapa yang jadi center berikutnya', 0),
(5, 3, 'guruku, pacarku', 1),
(6, 4, 'Selamat datang', 0),
(7, 4, 'Sampai jumpa lagi', 0),
(8, 4, 'Sudah menunggu lama ya', 1),
(9, 4, 'Terima kasih sudah datang', 0),
(10, 5, 'FURANUI', 1),
(11, 8, 'Angsa yang Kesepian', 0),
(12, 8, 'Merak yang Sombong', 0),
(13, 8, 'Elang yang Pemberani', 0),
(14, 8, 'Burung Unta si Pembohong', 1),
(15, 10, 'Muthe', 0),
(16, 10, 'Christy', 0),
(17, 10, 'Fiony', 0),
(18, 10, 'Oline', 1),
(19, 12, 'Harus dikembalikan ke member setelah show', 0),
(20, 12, 'Ditukar dengan merchandise resmi JKT48', 0),
(21, 12, 'Bisa dibawa pulang oleh penonton sebagai kenang-kenangan', 1),
(22, 12, 'Dilelang untuk kegiatan amal', 0),
(23, 13, 'Kan Kusimpan', 1),
(24, 15, 'Lagu pembuka', 0),
(25, 15, 'Setelah jeda / interval', 0),
(26, 15, 'Menjelang lagu penutup', 1),
(27, 15, 'Lagu pertama di bagian encore', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tracks`
--

CREATE TABLE `tracks` (
  `id_track` int(11) NOT NULL,
  `id_chapter` int(11) NOT NULL,
  `judul_lagu` varchar(200) NOT NULL,
  `urutan` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `trivia` text DEFAULT NULL,
  `mood` varchar(50) DEFAULT NULL,
  `lirik_petikan` text DEFAULT NULL,
  `audio_preview` varchar(255) DEFAULT NULL,
  `bg_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tracks`
--

INSERT INTO `tracks` (`id_track`, `id_chapter`, `judul_lagu`, `urutan`, `deskripsi`, `trivia`, `mood`, `lirik_petikan`, `audio_preview`, `bg_image`) VALUES
(1, 1, 'Kizashi (Pertanda)', 1, 'Sebelum tirai teater benar-benar terbuka, ada satu momen — detik-detik ketika napas ditahan, lampu belum menyala penuh, dan sesuatu yang besar terasa akan segera dimulai. Kizashi adalah momen itu. Bukan tentang apa yang sudah terjadi, tapi tentang keyakinan bahwa yang terbaik masih di depan.\r\n \r\nAda perasaan aneh yang hanya bisa dirasakan di pintu masuk — bukan di dalam, bukan di luar. Di ambang. Di titik di mana semua kemungkinan masih terbuka dan belum ada yang salah. Kizashi menangkap perasaan itu dengan sempurna.\r\n \r\nDalam budaya Jepang, \"kizashi\" berarti tanda atau pertanda — sesuatu yang kecil yang memberi tahu bahwa sesuatu yang lebih besar akan datang. Setetes hujan sebelum badai. Senyum tipis sebelum kabar baik. Degup jantung sebelum nama kamu dipanggil.\r\n \r\nSetiap kali setlist ini dibuka dengan Kizashi, ada kesepakatan diam-diam antara panggung dan penonton — bahwa malam ini akan jadi sesuatu. Bahwa perjalanan yang dimulai di sini layak untuk diselesaikan sampai lagu terakhir.', 'Kizashi sering dijadikan lagu pembuka setlist Cara Meminum Ramune karena energinya yang terasa seperti \"aba-aba\" — mempersiapkan penonton untuk perjalanan panjang yang menanti di 15 lagu berikutnya.', 'hopeful', NULL, NULL, NULL),
(2, 1, 'Koutei no Koinu (Schoolyard Puppy)', 2, 'Ada jenis cinta yang tidak bisa disembunyikan — yang terlalu polos untuk berpura-pura, terlalu gugup untuk bicara langsung. Koutei no Koinu adalah tentang perasaan itu. Tentang seseorang yang mendekatimu bukan dengan kata-kata manis, tapi dengan cara yang canggung, lucu, dan tulus.', 'Di balik keseruan lagunya, Koutei no Koinu punya fungsi tersembunyi di internal JKT48 — lagu ini jadi semacam \"tes keberanian\" bagi member junior. Center lagu ini punya adegan di mana ia harus berperan sebagai anjing yang bebas mengganggu member lain di atas panggung. Kalau si center berani iseng ke seniornya tanpa canggung, itu tanda mereka sudah benar-benar merasa seperti keluarga. Dan di era sekarang, center lagu ini sering diisi para trainee — jadi penonton pun bisa ikut menilai: sudah akrab belum mereka?', 'playful', NULL, NULL, NULL),
(3, 1, 'Disco Hokenshitsu (Disco di UKS)', 3, 'Siapa bilang UKS cuma tempat tidur siang dan minta izin pulang? Di sini, kasurnya jadi dancefloor, dan stetoskop digantung di kursi. Disco Hokenshitsu adalah lagu tentang bolos pelajaran demi ketemu seseorang yang bikin jantung berdegup lebih kencang dari biasanya — dan entah itu karena demam atau bukan, kamu tidak terlalu peduli.', 'Lirik lagu ini terang-terangan playful — ada baris \"Mari kita menari di atas kasur!\" dan \"Ku menarik pinggangmu\" yang bikin lagu ini jadi salah satu yang paling memorable di setlist. Member JKT48 sendiri sadar betul lagu ini bukan untuk semua usia — kalau sebelum perform mereka melihat ada penonton cilik di barisan depan, beberapa member secara spontan akan mengurangi intensitas koreografi mereka. Dan kalau ada bocil yang sudah kadung nonton? Solusinya simpel: \"Abaikan artinya ya, nikmatin lagunya aja!\"', 'chaotic', NULL, NULL, NULL),
(4, 1, 'Omatase Setlist (Setlist yang Dinanti)', 4, 'Kalau ada satu lagu di setlist ini yang terasa seperti surat cinta langsung dari panggung ke penonton, itu adalah Omatase Setlist. Lagu ini berbicara tentang kerinduan yang akhirnya terbayar — tentang penantian panjang yang berakhir di momen ketika lampu menyala dan semua orang akhirnya bertemu lagi.', '\"Omatase\" dalam bahasa Jepang berarti \"sudah menunggu lama ya.\" Lagu ini sering dibawakan dengan energi yang meledak-ledak, seolah member ingin bilang: \"Kami tahu kalian sudah lama menunggu. Ini untuk kalian.\"', 'celebratory', NULL, NULL, NULL),
(5, 1, 'Cross', 5, 'Tidak semua lagu butuh senyum. Cross hadir dengan energi yang berbeda — gelap, tegas, dan penuh ketegangan. Di tengah setlist yang penuh keceriaan, Cross adalah momen ketika semuanya tiba-tiba berubah serius. Seperti persilangan dua jalan yang tidak bisa dihindari.', 'Cross sering jadi lagu yang paling \"mengejutkan\" penonton baru JKT48 — mereka datang dengan ekspektasi idol dance yang cute, lalu tiba-tiba berhadapan dengan koreografi yang jauh lebih sharp dan powerful. Banyak fans menyebut lagu ini sebagai bukti bahwa JKT48 bukan sekadar idol biasa.', 'intense', NULL, NULL, NULL),
(6, 1, 'Finland Miracle', 6, 'Tidak ada yang tahu kenapa Finland, tidak ada yang tahu kenapa Miracle — dan justru itu yang membuat lagu ini sempurna. Finland Miracle adalah tentang kesenangan yang tidak butuh alasan, tentang persahabatan yang chaotic dan absurd tapi justru karena itulah terasa nyata.', 'Finland Miracle adalah salah satu lagu yang paling sering bikin member sendiri ketawa di atas panggung — energinya terlalu menyenangkan untuk ditahan. Penonton biasanya ikut teriak-teriak bahkan tanpa tahu artinya, dan entah bagaimana itu justru membuat semuanya makin seru.', 'cheerful', NULL, NULL, NULL),
(7, 1, 'Manazashi, Sayonara (Menatapmu Sayonara)', 7, 'Ada perpisahan yang disertai tangis dan drama. Dan ada perpisahan seperti ini — yang hanya diwakili oleh tatapan terakhir, tanpa kata-kata lebih. Manazashi, Sayonara bukan tentang perpisahan yang dramatis. Justru sebaliknya — dan itulah yang membuatnya jauh lebih menyakitkan.\r\n \r\n\"Manazashi\" dalam bahasa Jepang berarti tatapan — bukan sembarang tatapan, tapi tatapan yang menyimpan sesuatu. Yang tidak bisa diucapkan dengan kata. Yang bertahan lebih lama dari pelukan dan lebih dalam dari air mata.\r\n \r\nLagu ini duduk di tengah setlist seperti jeda napas yang tidak direncanakan. Setelah hiruk pikuk lagu-lagu sebelumnya, Manazashi Sayonara datang dan tiba-tiba semuanya terasa lebih sunyi. Bukan karena lagunya pelan, tapi karena ia berbicara tentang sesuatu yang semua orang pernah rasakan — menatap seseorang untuk terakhir kali, tahu bahwa itu terakhir kali, dan tidak bisa melakukan apa-apa selain menatap.\r\n \r\nHanya dua member yang membawakan lagu ini setiap show-nya. Tidak ada keramaian, tidak ada formasi besar. Hanya dua orang, satu lagu, dan seluruh teater yang tiba-tiba ikut diam.', 'Lagu ini hanya dibawakan oleh dua member setiap show-nya, menjadikannya salah satu momen paling intim di seluruh setlist. Siapapun yang kebagian membawakan lagu ini, suasana teater biasanya langsung berubah — lebih sunyi, lebih dalam.', 'bittersweet', NULL, NULL, NULL),
(8, 1, 'Usotsuki Dachou (Burung Unta si Pembohong)', 8, 'Burung unta menyembunyikan kepalanya di pasir karena tidak mau menghadapi kenyataan. Kamu juga melakukan hal yang sama — pura-pura tidak tahu, pura-pura tidak lihat, pura-pura tidak sayang. Tapi bohong yang lucu tetap bohong juga, dan Usotsuki Dachou hadir untuk mengingatkan itu dengan cara yang paling menyebalkan: sambil senyum-senyum.', 'Ekspresi member saat membawakan lagu ini biasanya penuh dengan muka jahil dan gerakan yang terang-terangan mengolok-olok si \"pembohong\" — menjadikan lagu ini salah satu yang paling ekspresif dan menghibur untuk ditonton secara live.', 'mischievous', NULL, NULL, NULL),
(9, 1, 'Nice to Meet You!', 9, 'Sederhana, manis, dan tulus — Nice to Meet You! adalah jabat tangan pertama yang hangat. Lagu ini tidak mencoba jadi sesuatu yang besar. Ia hanya hadir, menyapamu, dan dengan cara itu justru meninggalkan kesan yang sulit dilupakan.', 'Nice to Meet You! sering jadi lagu favorit penonton yang baru pertama kali datang ke teater JKT48 — energinya yang welcoming membuat siapapun langsung merasa diterima, bahkan sebelum mereka hafal nama satu member pun.', 'bright', NULL, NULL, NULL),
(10, 1, 'Kodoku no Ballerina (Ballerina dalam Sepi)', 10, 'Di tengah sorak sorai teater, ada satu momen ketika semuanya terasa hening. Kodoku no Ballerina adalah lagu itu — tentang keindahan yang hadir justru dalam kesendirian, tentang seseorang yang menari bukan untuk ditonton, tapi karena menari adalah satu-satunya cara ia bicara.', 'Selama bertahun-tahun, posisi center lagu ini menjadi perebutan antara tiga nama: Christy, Muthe, dan Fiony — ketiganya bukan penari balet terlatih, tapi mampu membawakan lagu ini dengan penghayatan yang luar biasa. Segalanya berubah ketika Gen 12 datang membawa Oline — satu-satunya member JKT48 yang memiliki latar belakang balet sungguhan. Fans langsung menggadang-gadangkannya sebagai generasi berikutnya dari lagu ini, dan kini hal itu benar-benar terwujud.', 'melancholic', NULL, NULL, NULL),
(11, 1, 'Ima Kimi to Irareru Koto (Sekarang Ku Bersama Denganmu)', 11, 'Tidak selalu tentang masa depan atau masa lalu. Kadang yang paling berharga adalah sekarang — detik ini, di tempat ini, bersama orang ini. Ima Kimi to Irareru Koto adalah tentang rasa syukur yang sederhana itu, yang justru karena kesederhanaannya terasa begitu hangat dan dalam.', 'Lagu ini sering membuat suasana teater berubah menjadi sangat tenang dan penuh perasaan — banyak penonton yang mengaku baru benar-benar \"merasakan\" teater JKT48 saat lagu ini dimainkan. Ada sesuatu di nada dan liriknya yang membuat orang ingin berdiam sejenak.', 'sentimental', NULL, NULL, NULL),
(12, 1, 'Winning Ball', 12, 'Kalah tidak apa-apa — asal kamu kembali berdiri dan mencoba lagi. Winning Ball adalah tentang semangat itu, tentang tim yang saling mendukung dan tidak menyerah meski skor belum berpihak. Energinya murni, gerakannya penuh tenaga, dan pesan di baliknya sederhana: terus maju.', 'Di bagian akhir lagu, ada momen ikonik di mana member akan melempar dan memukul bola kasti ke arah penonton — dan penonton yang berhasil menangkapnya bisa membawa pulang bola tersebut sebagai kenang-kenangan. Kedengarannya manis, tapi ada catatan kecil: tidak semua member bisa mengontrol kekuatan pukulannya. Sudah cukup banyak cerita tentang bola yang melaju terlalu kencang dan... meleset dari tangan penonton. Pakai helm kalau perlu.', 'energetic', NULL, NULL, NULL),
(13, 1, 'Akushu no Ai (Cinta dalam Handshake)', 13, 'Dalam dunia idol, ada satu momen yang tidak bisa digantikan oleh siapapun — jabat tangan. Bukan karena gesturnya, tapi karena apa yang ada di dalamnya: tatapan yang tulus, senyum yang nyata, dan rasa \"terima kasih sudah datang\" yang disampaikan tanpa kata-kata. Akushu no Ai adalah lagu tentang momen itu.', 'Lagu ini sering dibawakan dengan penghayatan yang sangat personal — member biasanya tampak benar-benar berbicara kepada penonton di depan mereka, bukan sekadar perform. Bagi banyak fans, lagu ini adalah momen di mana jarak antara panggung dan penonton terasa paling tipis.', 'heartfelt', NULL, NULL, NULL),
(14, 1, 'Bowling Ganbou (Harapan Bowling)', 14, 'Tidak semua harapan harus besar dan serius. Kadang harapanmu cukup sederhana: ingin strike, ingin menang, ingin hari ini menyenangkan. Bowling Ganbou adalah tentang harapan-harapan kecil yang justru membuat hidup terasa lebih ringan — dan tentang bagaimana usaha sekecil apapun tetap layak untuk dirayakan.', 'Bowling Ganbou adalah salah satu lagu yang paling \"bebas\" di setlist ini — member biasanya tampak paling santai dan paling banyak senyum saat membawakan lagu ini. Tidak ada tekanan, tidak ada intensitas — hanya kesenangan murni yang menular ke seluruh teater.', 'goofy', NULL, NULL, NULL),
(15, 1, '16-iro no Yume Crayon (16 Warna Crayon Mimpi)', 15, 'Sebelum kamu tahu mimpimu harus realistis, sebelum ada yang bilang warna itu tidak ada di dunia nyata — kamu pernah punya kotak crayon 16 warna dan percaya bahwa semua gambarmu indah. 16-iro no Yume Crayon adalah tentang masa itu. Tentang mimpi yang masih berwarna-warni dan belum punya batas.', 'Lagu ini sering dibawakan menjelang akhir setlist, menjadikannya semacam \"persiapan emosional\" sebelum lagu penutup. Banyak fans menggambarkan momen ini sebagai yang paling nostalgik di seluruh show — seolah seluruh energi teater sejenak menjadi lebih lembut dan hangat.', 'dreamy', NULL, NULL, NULL),
(16, 1, 'Ramune no Nomikata (Cara Meminum Ramune)', 16, 'Ada orang-orang yang selalu bilang \"gak apa-apa\" — bahkan ketika semuanya jauh dari baik-baik saja. Ramune no Nomikata adalah lagu untuk mereka. Tentang seorang teman yang melihat tanda-tanda kelelahan yang coba disembunyikan, dan dengan lembut berkata: kamu tidak harus kuat sekarang. Istirahatlah. Seperti ramune yang tidak bisa diminum sekaligus — hidup juga tidak harus dijalani dengan terburu-buru.\r\n \r\nRamune adalah minuman bersoda Jepang dengan kelereng di dalam botolnya. Cara meminumnya unik — kamu harus menekan kelereng ke dalam dengan jari, dan kelereng itu akan menggelinding ke dalam botol, membuka jalan untuk airnya mengalir. Tidak bisa terburu-buru. Tidak bisa dipaksa. Harus dilakukan dengan sabar, perlahan.\r\n \r\nLiriknya berbicara tentang seseorang yang terus bilang \"gak apa-apa\" lewat chat, tapi kamu tahu dari cara dia bercanda bahwa semuanya tidak baik-baik saja. Dan kamu hanya ingin bilang: tidak apa-apa untuk tidak baik-baik saja. Istirahatlah sejenak. Tariklah satu napas dalam.\r\n \r\nLagu ini sering membuat member menangis di atas panggung — bukan hanya karena melodinya yang mellow, tapi karena liriknya terasa sangat personal. Di usia muda yang seharusnya penuh semangat, jadwal latihan dan perform yang padat sering membuat mereka merasa harus terus kuat. Ramune no Nomikata adalah pengingat bahwa mereka tidak harus selalu begitu.', 'Tidak sedikit member JKT48 yang berkaca-kaca, bahkan menangis, saat membawakan lagu penutup ini. Dan mungkin bukan hanya karena lagunya yang mellow — liriknya berbicara tentang kelelahan yang disembunyikan di balik senyum, tentang usia muda yang seharusnya bebas tapi justru terkekang oleh jadwal latihan dan perform yang padat. Bagi para member, lagu ini bukan sekadar lagu. Dalam banyak hal, itu adalah cermin.', 'nostalgic', NULL, NULL, NULL),
(17, 2, 'Angin Kita (Bokura no Kaze)', 1, 'Sebelum langkah pertama diambil, selalu ada momen di mana angin bertiup — seolah alam semesta sendiri yang memberi tanda bahwa sesuatu yang baru sedang dimulai. Angin Kita adalah lagu tentang momen itu. Tentang dua orang yang memutuskan untuk melangkah maju bersama, tanpa tahu persis ke mana angin akan membawa mereka — tapi tidak takut, karena mereka tidak berjalan sendiri.\n\nAda perasaan yang sulit dijelaskan ketika kamu berdiri di titik awal sebuah perjalanan — campuran antara gugup dan excited, antara tidak tahu dan tidak peduli karena yang penting ada seseorang di sisimu. Angin Kita menangkap perasaan itu. Bukan tentang tujuan, tapi tentang keberanian untuk mulai.', 'Angin Kita sering dijadikan lagu pembuka setlist ini karena energinya yang terasa seperti tarikan napas panjang sebelum perjalanan panjang dimulai — mempersiapkan penonton untuk 15 lagu berikutnya yang penuh warna.', 'hopeful', NULL, NULL, NULL),
(18, 2, 'Mango No.2', 2, 'Tidak semua lagu perlu dalam maknanya. Mango No.2 hadir untuk satu tujuan saja — membuatmu tersenyum tanpa alasan yang jelas. Energi musim panas, sedikit genit, sedikit absurd, dan entah kenapa sangat melekat di kepala bahkan setelah lagu selesai.\n\nKalau Wimbledon adalah tentang cinta pertama yang puitis, Mango No.2 adalah tentang crush yang kamu sendiri tidak bisa jelaskan kenapa — tapi kamu tetap senyum-senyum setiap kali ingat dia.', 'Mango No.2 adalah salah satu lagu yang paling sering membuat member sendiri tidak bisa menahan senyum di atas panggung. Energinya terlalu menyenangkan untuk ditahan dengan serius — dan penonton biasanya langsung ikut larut dari detik pertama.', 'playful', NULL, NULL, NULL),
(19, 2, 'Sambil Menggandeng Erat Tanganku (Te wo Tsunaginagara)', 3, 'Ada jenis kekuatan yang tidak datang dari dalam dirimu sendiri — tapi dari tangan yang menggenggammu saat kamu hampir menyerah. Sambil Menggandeng Erat Tanganku adalah tentang kekuatan itu. Tentang persahabatan yang bukan sekadar ada di momen bahagia, tapi yang benar-benar hadir ketika jalannya berat.\n\nLagu ini adalah jantung dari seluruh setlist — dan bukan tanpa alasan. Di antara semua cerita tentang cinta, kehilangan, dan nostalgia dalam setlist ini, lagu ini bicara tentang sesuatu yang lebih abadi: bahwa kamu tidak harus melewati apapun sendirian.', 'Lagu yang menjadi nama setlist ini bukan dipilih secara kebetulan — ia mewakili semangat keseluruhan dari perjalanan ini. Setiap member yang membawakan lagu ini biasanya tampak paling terhubung satu sama lain di atas panggung, seolah liriknya bukan hanya untuk penonton tapi juga untuk sesama member di sisinya.', 'heartfelt', NULL, NULL, NULL),
(20, 2, 'Bel Sekolah adalah Love Song (Chime wa Love Song)', 4, 'Bel sekolah tidak pernah bermakna banyak — sampai kamu menyadari bahwa bunyinya selalu bersamaan dengan saat kamu melihat seseorang. Tiba-tiba bel itu bukan lagi penanda pergantian pelajaran, tapi sebuah lagu cinta yang hanya bisa kamu dengar sendiri.\n\nChime wa Love Song adalah tentang perasaan yang terlalu besar untuk diungkapkan dan terlalu indah untuk diabaikan — yang tersembunyi rapi di balik seragam sekolah dan jadwal pelajaran. Tentang deg-degan kecil yang terasa seperti dunia.', 'Lagu ini sering disebut sebagai \"soundtrack kehidupan SMA yang tidak pernah terjadi\" oleh fans — karena vibesnya begitu persis menggambarkan perasaan yang semua orang pernah rasakan tapi tidak pernah bisa diungkapkan dengan kata-kata.', 'dreamy', NULL, NULL, NULL),
(21, 2, 'Glory Days', 5, 'Lagu ini mengisahkan seorang remaja yang mulai mempertanyakan arti hidupnya — bukan dengan cara yang gelap, tapi dengan cara yang jujur. Ia menjalani hari-hari dengan santai: lebih banyak tertawa bersama teman daripada menghafal pelajaran, lebih sering mendengarkan lagu cinta daripada memahami artinya. Ketika orang dewasa memberi nasihat, ia mendengarkan — tapi dalam hatinya masih bertanya, apakah semua itu benar-benar penting?\n\nSampai suatu saat ia memutuskan untuk tidak lagi menunggu jawaban. Ia mulai bergerak, mencoba, gagal, mencoba lagi — karena ia sadar waktu terus berjalan dan selalu ada kesempatan untuk memulai ulang. Tapi di balik semangatnya itu, ada ruang kecil yang tetap kosong — perasaan hampa yang datang setiap kali ia bertanya untuk siapa sebenarnya ia bersinar.\n\nGlory Days mengajarkan bahwa setelah merasakan pahitnya kehidupan, manusia justru menjadi lebih kuat — dan satu-satunya jalan yang benar adalah jalan yang dipilih oleh hati sendiri.', 'Glory Days sering mengejutkan penonton baru karena kedalaman liriknya tidak langsung terasa di permukaan. Di balik energi yang rebellious dan cool, tersimpan pertanyaan-pertanyaan existensial yang terasa sangat nyata bagi siapapun yang pernah muda dan bingung.', 'rebellious', NULL, NULL, NULL),
(22, 2, 'Barcode Hati Ini (Kono Mune no Barcode)', 6, 'Malam yang tidak bisa tidur membawanya ke minimarket — bukan karena lapar, tapi karena ada kemungkinan kecil bahwa cowok teman sekelasnya yang tinggal di dekat rumahnya itu mungkin ada di sana. Ia membeli sekaleng kopi yang ternyata tidak manis, membuka majalah fashion tanpa benar-benar membacanya, dan menunggu.\n\nRasa sayangnya tersimpan seperti barcode — garisnya terukir jelas, tapi tidak semua orang bisa membacanya. Setiap kali kasir memindai barang belanjaannya, ada sesuatu yang terasa seperti perasaannya sedang tersampaikan tanpa kata-kata. Dan ketika barcode tidak terbaca dan kasir harus mengetik nomor secara manual — momen itu terasa seperti percakapan rahasia yang hanya ia yang mengerti.\n\nIa tidak berani mengucapkan apapun. Tapi setidaknya, ia berharap CCTV merekamnya — dan suatu hari, ia yang dilihat.', 'Barcode Hati Ini adalah salah satu lagu paling \"sinematik\" dalam setlist ini — setiap detailnya terasa seperti adegan film pendek. Minimarket, kopi tidak manis, majalah yang tidak dibaca, CCTV. Semuanya ada. Semuanya terasa familiar.', 'mysterious', NULL, NULL, NULL);
INSERT INTO `tracks` (`id_track`, `id_chapter`, `judul_lagu`, `urutan`, `deskripsi`, `trivia`, `mood`, `lirik_petikan`, `audio_preview`, `bg_image`) VALUES
(23, 2, 'Ajak Aku Pergi Menuju ke Wimbledon (Wimbledon he Tsuretette)', 7, 'Setiap pagi di kereta yang sama, jam yang sama, pintu yang sama — ada seorang cowok dengan raket tenis yang selalu turun satu stasiun sebelumnya. Ia tidak tahu namanya. Tapi tanpa sadar, ia sudah menetapkan cowok itu sebagai cinta pertamanya.\n\nIa membayangkan suatu hari cowok itu berdiri di lapangan Wimbledon — turnamen tenis paling bergengsi di dunia — sementara ia duduk di bangku pojok penonton, menahan napas dan berdoa dalam diam. Bukan sebagai siapa-siapa, hanya sebagai seseorang yang percaya sejak awal.\n\nMimpi itu mungkin terlalu besar untuk sebuah pertemuan singkat di kereta — tapi perasaan pertama tidak pernah meminta izin untuk datang.', 'Lagu ini menjadi unit song dalam setlist dengan nuansa kostum yang ceria dan menggemaskan — jauh dari kesan serius Wimbledon yang sesungguhnya. Dan justru kontras itulah yang membuat lagu ini begitu lovable.', 'cheerful', NULL, NULL, NULL),
(24, 2, 'Sang Pianis Hujan (Ame no Pianist)', 8, 'Ia duduk terdiam di sofa sambil menggigit kukunya saat semuanya berakhir. Pria itu berkata bahwa ini adalah kesalahannya sendiri — bahwa ia akan menemukan seseorang yang lebih baik — sambil tersenyum untuk meyakinkan bahwa semua akan baik-baik saja. Mereka berdua tahu kalimat itu tidak sepenuhnya benar. Tapi tidak ada yang lebih menyakitkan dari kebaikan di akhir sebuah hubungan.\n\nIa akhirnya pergi keluar di tengah hujan — dan menemukan seorang pianis yang memainkan Nocturne Chopin di bawah rinai hujan kota. Lagu perpisahan itu seolah dimainkan khusus untuknya. Ia menangis lebih deras dari hujan.', 'Ada member JKT48 yang pernah tampil membawakan lagu ini dan bukannya namanya yang diteriakkan penonton — tapi nama member lain yang biasa membawakan lagu ini. Momen itu menjadi salah satu cerita paling memilukan di era yang paradoks: era di mana JKT48 sedang paling ramai sekaligus paling keras dalam fanatisme fansnya. Era itu kini dikenal sebagai salah satu dark age dalam sejarah JKT48 — penuh semangat di permukaan, tapi menyimpan luka yang dalam bagi banyak member.', 'melancholic', NULL, NULL, NULL),
(25, 2, 'Keberadaan Coklat Itu (Choco no Yukue)', 9, 'Valentine tahun itu, ia memutuskan untuk tidak lagi hanya diam. Setelah pulang sekolah, ia menyerahkan sekotak coklat langsung ke tangan cowok populer yang sudah lama ia suka — lalu pergi tanpa menunggu reaksinya.\n\nYang mengganggunya bukan penolakan. Yang mengganggunya adalah tidak ada kabar sama sekali. Apakah coklat itu dimakan? Dibuang? Ia tidak meminta banyak — hanya ingin tahu bahwa sekotak coklat itu setidaknya sampai ke mulutnya dan rasanya enak. Tidak perlu ucapan terima kasih, tidak perlu balasan perasaan. Hanya pengakuan kecil bahwa keberanian seorang perempuan untuk mencintai — itu layak untuk dihargai.', 'Keberadaan Coklat Itu adalah salah satu lagu yang paling sering membuat penonton tertawa kecil sambil mengangguk — karena kegelisahan yang digambarkannya terlalu familiar. Siapa yang tidak pernah penasaran bagaimana nasib sesuatu yang sudah diberikan dengan sepenuh hati?', 'nervous', NULL, NULL, NULL),
(26, 2, 'Innocence', 10, 'Di balik senyum yang selalu tersedia, ada perasaan yang tidak pernah diizinkan untuk keluar. Innocence adalah tentang konflik itu — antara apa yang ingin dikatakan dan apa yang akhirnya diucapkan. Antara marah yang ditahan dan sedih yang berpura-pura tidak ada.\n\nLagu ini lebih emosional dari yang kebanyakan orang sadari saat pertama kali mendengarnya. Ada frustrasi di balik melodi yang terdengar biasa — perasaan yang terjebak di antara ingin jujur dan takut menyakiti.', 'Banyak fans yang baru menyadari kedalaman emosional Innocence setelah mendengarnya berkali-kali. Lagu ini sering disebut sebagai \"hidden gem\" dari setlist ini — terdengar biasa di permukaan, tapi menyimpan sesuatu yang jauh lebih dalam.', 'conflicted', NULL, NULL, NULL),
(27, 2, 'Romance Rocket', 11, 'Tidak ada cerita yang rumit di sini. Romance Rocket adalah tentang energi — energi yang meledak di tengah konser, yang membuat semua orang lupa untuk diam dan hanya ingin berteriak dan melompat bersama. Cinta yang terlalu cepat dan terlalu besar untuk dijelaskan dengan kata-kata biasa.\n\nKalau ada satu lagu di setlist ini yang paling jujur menggambarkan kegembiraan murni sebuah pertunjukan idol — Romance Rocket adalah lagu itu.', 'Romance Rocket adalah lagu yang paling sering membuat suasana teater berubah total dalam hitungan detik. Dari apapun momen sebelumnya, begitu intro lagu ini dimulai, semua orang langsung siap untuk berteriak.', 'energetic', NULL, NULL, NULL),
(28, 2, 'Arah Sang Cinta dan Balasannya (Koi no Keikou to Taisaku)', 12, 'Seperti siswa yang membuat analisis serius tentang sesuatu yang sama sekali tidak bisa dianalisis — begitulah lagu ini bekerja. Ada usaha yang sungguh-sungguh untuk memahami cinta secara logis, membuat strategi, menyusun rencana. Dan tentu saja, semuanya kacau di akhir karena cinta tidak pernah mengikuti logika.\n\nLagu ini ringan, menggelitik, dan terasa seperti tertawa pada diri sendiri saat masih muda.', 'Ekspresi member saat membawakan lagu ini biasanya penuh dengan muka serius yang dibuat-buat — seolah benar-benar sedang menganalisis cinta di papan tulis. Dan justru itu yang membuat lagu ini selalu mengundang tawa dari penonton.', 'teasing', NULL, NULL, NULL),
(29, 2, 'Aku Sangat Suka (Daisuki)', 13, 'Kadang yang paling sulit bukan mengucapkan kata yang rumit — tapi mengucapkan kata yang paling sederhana dengan benar-benar tulus. Daisuki tidak mencoba menjadi apapun selain apa adanya: pengakuan polos bahwa ada seseorang yang begitu berarti sampai tidak ada kata lain yang lebih tepat selain \"aku sangat suka kamu.\"\n\nDi antara semua lagu dalam setlist ini yang bercerita tentang cinta yang rumit dan penuh tanda tanya — Daisuki adalah yang paling sederhana. Dan justru karena itu, ia yang paling terasa.', 'Daisuki sering menjadi momen paling tenang dalam setlist — di antara semua energi dan drama, tiba-tiba ada satu lagu yang hanya ingin bilang satu hal dengan jujur. Dan justru kesederhanaan itu yang membuat banyak penonton diam dan merasakannya.', 'sincere', NULL, NULL, NULL),
(30, 2, 'Tali Persahabatan (Rope no Yuujou)', 14, 'Ada persahabatan yang bertahan bukan karena tidak pernah diuji — tapi justru karena sudah melewati ujian terberat dan memilih untuk tetap bersama. Rope no Yuujou adalah tentang ikatan itu. Tentang tali yang ditarik dari dua arah tapi tidak pernah putus — karena keduanya tahu bahwa tanpa tali itu, mereka masing-masing akan jatuh.\n\nLagu ini bukan tentang kesenangan persahabatan. Ini tentang kekuatannya.', 'Rope no Yuujou sering dibawakan dengan penghayatan yang sangat dalam — member biasanya saling berpegangan tangan atau bertukar tatapan selama perform, seolah liriknya bukan hanya tentang karakter dalam lagu tapi juga tentang hubungan mereka sendiri.', 'empowering', NULL, NULL, NULL),
(31, 2, 'Malam Hari Selasa, Pagi Hari Rabu (Kayoubi no Yoru, Suiyoubi no Asa)', 15, 'Ada jam-jam di antara malam dan pagi yang terasa seperti milik dunia yang berbeda — terlalu larut untuk hari kemarin, terlalu awal untuk hari ini. Di situlah lagu ini tinggal. Di antara Selasa yang belum mau berakhir dan Rabu yang belum siap dimulai.\n\nPerasaan yang ditangkap lagu ini bukan kesedihan yang jelas — tapi kerinduan yang samar. Seperti menginginkan sesuatu untuk bertahan sedikit lebih lama, tanpa tahu persis apa yang dimaksud.', 'Lagu ini sering dibawakan menjelang akhir setlist — dan menjadi semacam \"persiapan emosional\" sebelum lagu penutup. Suasana teater biasanya mulai berubah lebih tenang dan dalam saat lagu ini dimainkan.', 'nostalgic', NULL, NULL, NULL),
(32, 2, 'Di Tempat Jauh pun (Tooku ni Ite mo)', 16, 'Jarak tidak pernah benar-benar bisa memutus sesuatu yang sudah terikat dari dalam. Tooku ni Ite mo adalah tentang keyakinan itu — bahwa ada ikatan yang tidak perlu kehadiran fisik untuk tetap terasa nyata. Bahwa ada orang-orang yang tetap bersamamu bahkan ketika mereka sudah tidak ada di tempat yang sama.\n\nLagu ini berkisah tentang perpisahan yang tidak dramatis — seorang teman yang pergi mengejar jalan hidupnya yang jauh dan bersinar, diantar hanya dengan senyum dan lambaian tangan di halte bis. Tidak ada tangisan yang terlihat. Tapi langit yang membentang luas di atas keduanya tetap sama — dan di situlah mereka masih terhubung.\n\nLagu penutup ini tidak berteriak. Ia hanya berbisik — dan justru bisikan itu yang paling lama bertahan setelah pertunjukan selesai. Seperti pelukan terakhir yang tidak ingin dilepas, tapi akhirnya harus.', 'Di konser 11th Anniversary JKT48 tahun 2022, Tooku ni Ite mo dibawakan di antara puluhan lagu dari berbagai era — dan menjadi salah satu momen paling emosional malam itu. Banyak member menangis saat membawakan lagu ini. Salah satunya adalah Olla, yang beberapa hari sebelum konser baru saja kehilangan sang ayah. Sebelumnya, ibunya juga telah pergi di masa pandemi. Olla naik ke panggung malam itu sebagai seseorang yang baru saja kehilangan satu-satunya orang tua yang tersisa — dan membawakan lagu tentang penghiburan untuk orang yang jauh, sementara ia sendiri adalah orang yang paling membutuhkan penghiburan itu.\n\n\"Di saat kesulitan cobalah memandang langit. Kar\'na s\'perti biasa di sini \'ku s\'lalu mendengarkan cerita-ceritamu. Kita \'tak akan pernah sendirian.\"', 'bittersweet', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password_pengguna` varchar(200) NOT NULL,
  `ROLE` enum('admin','user') NOT NULL DEFAULT 'user',
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `email`, `password_pengguna`, `ROLE`, `dibuat_pada`) VALUES
(1, 'kentang', 'kentang@gmail.com', '$2y$10$ElgUHDlvZKIa9S8YpNKtrON65.WDV35qDBx1XorW5rxpVYxnyXLdi', 'admin', '2026-05-17 12:04:38'),
(2, 'admin', 'admin@gmail.com', '$2y$10$hnQzgZE4k4i6w5pKmpMirOJrdHvh8JRnQDb9Bot8KytMHoH/Qch16', 'admin', '2026-05-17 12:23:55'),
(3, 'kerang', 'kerang@gmail.com', '$2y$10$ONLbL2qepDuNyP2b0yDUcO4duuhAXBe52d8wmMYe9GiYrQ24BcTLe', 'user', '2026-05-17 14:08:54'),
(4, 'kursi', 'kursi@gmail.com', '$2y$10$F..WYACTNxsrGpcRIqB4lO./i51tvnIGbsg9cY6xXSx9d/V6YVI7G', 'admin', '2026-05-17 14:46:09'),
(5, 'kentang', 'fidanfidan@aifafa.com', '$2y$10$s5tRonCZaJ4I0J77/vGeruKaDv7zIZjqHok3fQYKF8i2MGwl6.sCa', 'user', '2026-05-21 05:02:15'),
(6, 'papa', 'putra@gmail.com', '$2y$10$qGAc6rqvWw/n91d4nZ/98.ogIEXDqUMRCIBHtcDm7ptGOAAKKOVxG', 'user', '2026-05-21 08:52:19'),
(7, 'Hellp', 'hello@hello.com', '$2y$10$5SN2eQJ0CUwHPET6hzz3hOJ.03lX3dKDvyOcrY3ZWb7NnCnx5rPH2', 'user', '2026-05-21 11:31:14');

-- --------------------------------------------------------

--
-- Table structure for table `user_progress`
--

CREATE TABLE `user_progress` (
  `id_user` int(11) NOT NULL,
  `id_chapter` int(11) NOT NULL,
  `track_terbuka` int(11) DEFAULT 1,
  `selesai` tinyint(1) DEFAULT 0,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_progress`
--

INSERT INTO `user_progress` (`id_user`, `id_chapter`, `track_terbuka`, `selesai`, `updated_at`) VALUES
(1, 1, 17, 1, '2026-05-17 12:17:52'),
(1, 2, 1, 0, '2026-05-17 15:02:43'),
(2, 1, 1, 0, '2026-06-12 06:23:26'),
(4, 1, 17, 1, '2026-05-21 00:59:24'),
(4, 2, 1, 0, '2026-05-21 00:59:39'),
(6, 1, 4, 0, '2026-05-21 08:55:29'),
(7, 1, 1, 0, '2026-05-21 11:31:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`id_chapter`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `guestbook`
--
ALTER TABLE `guestbook`
  ADD PRIMARY KEY (`id_pesan`),
  ADD KEY `id_chapter` (`id_chapter`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `milestones`
--
ALTER TABLE `milestones`
  ADD PRIMARY KEY (`id_milestone`),
  ADD KEY `id_chapter` (`id_chapter`);

--
-- Indexes for table `quests`
--
ALTER TABLE `quests`
  ADD PRIMARY KEY (`id_quest`),
  ADD KEY `id_track` (`id_track`);

--
-- Indexes for table `quest_log`
--
ALTER TABLE `quest_log`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_quest` (`id_quest`);

--
-- Indexes for table `quest_options`
--
ALTER TABLE `quest_options`
  ADD PRIMARY KEY (`id_option`),
  ADD KEY `id_quest` (`id_quest`);

--
-- Indexes for table `tracks`
--
ALTER TABLE `tracks`
  ADD PRIMARY KEY (`id_track`),
  ADD KEY `id_chapter` (`id_chapter`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_progress`
--
ALTER TABLE `user_progress`
  ADD PRIMARY KEY (`id_user`,`id_chapter`),
  ADD KEY `id_chapter` (`id_chapter`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chapters`
--
ALTER TABLE `chapters`
  MODIFY `id_chapter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `guestbook`
--
ALTER TABLE `guestbook`
  MODIFY `id_pesan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `milestones`
--
ALTER TABLE `milestones`
  MODIFY `id_milestone` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `quests`
--
ALTER TABLE `quests`
  MODIFY `id_quest` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `quest_log`
--
ALTER TABLE `quest_log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `quest_options`
--
ALTER TABLE `quest_options`
  MODIFY `id_option` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tracks`
--
ALTER TABLE `tracks`
  MODIFY `id_track` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `guestbook`
--
ALTER TABLE `guestbook`
  ADD CONSTRAINT `guestbook_ibfk_1` FOREIGN KEY (`id_chapter`) REFERENCES `chapters` (`id_chapter`) ON DELETE CASCADE,
  ADD CONSTRAINT `guestbook_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL;

--
-- Constraints for table `milestones`
--
ALTER TABLE `milestones`
  ADD CONSTRAINT `milestones_ibfk_1` FOREIGN KEY (`id_chapter`) REFERENCES `chapters` (`id_chapter`) ON DELETE CASCADE;

--
-- Constraints for table `quests`
--
ALTER TABLE `quests`
  ADD CONSTRAINT `quests_ibfk_1` FOREIGN KEY (`id_track`) REFERENCES `tracks` (`id_track`) ON DELETE CASCADE;

--
-- Constraints for table `quest_log`
--
ALTER TABLE `quest_log`
  ADD CONSTRAINT `quest_log_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `quest_log_ibfk_2` FOREIGN KEY (`id_quest`) REFERENCES `quests` (`id_quest`) ON DELETE CASCADE;

--
-- Constraints for table `quest_options`
--
ALTER TABLE `quest_options`
  ADD CONSTRAINT `quest_options_ibfk_1` FOREIGN KEY (`id_quest`) REFERENCES `quests` (`id_quest`) ON DELETE CASCADE;

--
-- Constraints for table `tracks`
--
ALTER TABLE `tracks`
  ADD CONSTRAINT `tracks_ibfk_1` FOREIGN KEY (`id_chapter`) REFERENCES `chapters` (`id_chapter`) ON DELETE CASCADE;

--
-- Constraints for table `user_progress`
--
ALTER TABLE `user_progress`
  ADD CONSTRAINT `user_progress_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_progress_ibfk_2` FOREIGN KEY (`id_chapter`) REFERENCES `chapters` (`id_chapter`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
