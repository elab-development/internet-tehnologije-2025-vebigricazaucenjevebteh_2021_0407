

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
-- Table structure for table `korisniks`
--


--
-- Dumping data for table `korisniks`
--

INSERT INTO `korisniks` (`id`, `ime`, `email`, `password`, `tip_korisnika`, `created_at`, `updated_at`) VALUES
(1, 'Jelena', 'jelena@gmail.com', '$2y$12$llmf4k7cCfNMiAzMzHDcheYaG8vzaP27pFny75WPzSqmqzA14XcxC', 'administrator', '2026-02-05 17:25:54', '2026-02-05 17:25:54'),
(2, 'Anja', 'anja@gmail.com', '$2y$12$cFB7ohbjECa0HVn5BEhJDeUKHpnZvKQ0NCGmQhTyBgEAINvsTwB6a', 'administrator', '2026-02-05 17:25:54', '2026-02-05 17:25:54'),
(3, 'Registrovani', 'registrovani@gmail.com', '$2y$12$K19PGZqnFRiZ295cZdsWaOLL.3ceaAxmq151RJIIDY6lL0kd8STH6', 'registrovani', '2026-02-05 17:25:55', '2026-02-05 17:25:55'),
(4, 'Editor', 'editor@gmail.com', '$2y$12$BW7f1wzGnJWwTZQ42yw8L.dnsUI3dkQprV0y5cq5os18OiKmjxavG', 'editor', '2026-02-05 17:25:55', '2026-02-05 17:25:55'),
(5, 'novo', 'novo@gmail.com', '$2y$12$7ItvicSFdVbHZb.xtHwq4uXwaU72xHcAWGXDS1Paa8Ipg11AW3Kaa', 'registrovani', '2026-02-07 07:37:36', '2026-02-07 07:37:36'),
(6, 'milica', 'milica@gmail.com', '$2y$12$w9k96i8qQX3Z3cXxCbjPsunp9GL8Xm7PrSlotbCauqTMGM4Dej9My', 'registrovani', '2026-02-07 08:00:04', '2026-02-07 08:00:04'),
(7, 'nesto', 'nestp@gmail.com', '$2y$12$Yay.N3L6OI/.RX7wbpPyiOLu9tntTddtr4qu92ytyJaUpIOUy2AEa', 'registrovani', '2026-02-07 10:06:01', '2026-02-07 10:06:01'),
(8, 'petar', 'petar@gmail.com', '$2y$12$XjOgRbD0K3bjcqnV2R4XmuGm1mD9pk7HYFxHGAHditBkFuQvDEqPi', 'registrovani', '2026-02-07 12:14:24', '2026-02-07 12:14:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `korisniks`
--




/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
COMMIT;

