
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `igrica`
--

-- --------------------------------------------------------

--
-- Table structure for table `rezultats`
--


INSERT INTO `rezultats` (`id`, `created_at`, `updated_at`, `korisnik_id`, `nivo_id`, `phase_id`, `bodovi`) VALUES
(1, '2026-02-06 10:09:38', '2026-02-06 10:09:38', 3, 1, '0', 100),
(2, '2026-02-06 10:28:52', '2026-02-06 10:28:52', 3, 3, '0', 100),
(3, '2026-02-06 10:39:37', '2026-02-06 10:39:37', 3, 2, '0', 100),
(4, '2026-02-07 12:16:41', '2026-02-07 12:16:41', 1, 3, '0', 100),
(5, '2026-02-07 12:22:30', '2026-02-07 12:22:30', 1, 2, '0', 100),
(6, '2026-02-07 12:24:02', '2026-02-07 12:24:02', 1, 2, '1', 100),
(7, '2026-02-07 12:24:42', '2026-02-07 12:24:42', 1, 2, '2', 100),
(8, '2026-02-07 12:25:51', '2026-02-07 12:25:51', 1, 3, '1', 100),
(9, '2026-02-11 13:44:01', '2026-02-11 13:44:01', 2, 2, '0', 100),
(10, '2026-02-11 13:44:17', '2026-02-11 13:44:17', 2, 2, '1', 100),
(11, '2026-02-11 13:44:22', '2026-02-11 13:44:22', 2, 2, '2', 100),
(12, '2026-02-11 13:44:39', '2026-02-11 13:44:39', 2, 3, '0', 100),
(13, '2026-02-11 13:45:26', '2026-02-11 13:45:26', 2, 3, '1', 100);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rezultats`
--

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
