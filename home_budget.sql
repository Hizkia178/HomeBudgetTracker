-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Bulan Mei 2025 pada 06.21
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `home_budget`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `expense_date` date NOT NULL,
  `description` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `expenses`
--

INSERT INTO `expenses` (`id`, `user_id`, `expense_date`, `description`, `category`, `amount`, `created_at`) VALUES
(4, 18, '2025-05-16', 'Makan nasi padang', 'transport', 400.00, '2025-05-12 22:21:29'),
(5, 19, '2025-05-21', 'Makan nasi padang', 'food', 100.00, '2025-05-12 22:37:45'),
(6, 19, '2025-05-16', 'Makan nasi padang', 'food', 333.00, '2025-05-12 22:45:57'),
(7, 20, '2025-05-23', 'Makan nasi padang', 'entertainment', 455.00, '2025-05-12 22:54:16'),
(8, 20, '2025-05-24', '33', 'entertainment', 4444.00, '2025-05-12 22:54:57'),
(9, 20, '2025-05-26', 'Makan nasi padang', 'entertainment', 3333.00, '2025-05-12 22:56:56'),
(10, 21, '2025-05-17', 'Makan nasi padang', 'food', 100.00, '2025-05-12 22:58:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `income`
--

CREATE TABLE `income` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `income_date` date NOT NULL,
  `description` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `income`
--

INSERT INTO `income` (`id`, `user_id`, `income_date`, `description`, `category`, `amount`, `created_at`) VALUES
(2, 18, '2025-05-17', 'investasi', 'gifts', 4444.00, '2025-05-12 22:21:51'),
(3, 19, '2025-05-23', 'investasi', 'investments', 1000.00, '2025-05-12 22:38:05'),
(4, 19, '2025-05-24', 'investasi', 'gifts', 3333.00, '2025-05-12 22:46:28'),
(5, 20, '2025-05-21', 'investasi', 'freelance', 3444.00, '2025-05-12 22:49:27'),
(6, 21, '2025-05-31', 'investasi', 'investments', 10000.00, '2025-05-12 22:59:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `savings`
--

CREATE TABLE `savings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `savings_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `savings`
--

INSERT INTO `savings` (`id`, `user_id`, `amount`, `created_at`, `savings_date`) VALUES
(1, 19, 900.00, '2025-05-12 22:45:13', '2025-05-13'),
(2, 19, 900.00, '2025-05-12 22:45:19', '2025-05-13'),
(3, 19, 900.00, '2025-05-12 22:45:29', '2025-05-13'),
(4, 19, 900.00, '2025-05-12 22:45:44', '2025-05-13'),
(5, 19, 567.00, '2025-05-12 22:46:02', '2025-05-13'),
(6, 19, 567.00, '2025-05-12 22:46:04', '2025-05-13'),
(7, 19, 567.00, '2025-05-12 22:46:15', '2025-05-13'),
(8, 19, 3900.00, '2025-05-12 22:46:32', '2025-05-13'),
(9, 20, 0.00, '2025-05-12 22:47:18', '2025-05-13'),
(10, 20, 0.00, '2025-05-12 22:49:13', '2025-05-13'),
(11, 20, 0.00, '2025-05-12 22:49:14', '2025-05-13'),
(12, 20, 3444.00, '2025-05-12 22:49:30', '2025-05-13'),
(13, 20, 3444.00, '2025-05-12 22:51:01', '2025-05-13'),
(14, 20, 3444.00, '2025-05-12 22:51:23', '2025-05-13'),
(15, 20, 3444.00, '2025-05-12 22:51:43', '2025-05-13'),
(16, 20, 3444.00, '2025-05-12 22:51:45', '2025-05-13'),
(17, 20, 3444.00, '2025-05-12 22:51:49', '2025-05-13'),
(18, 20, 3444.00, '2025-05-12 22:51:57', '2025-05-13'),
(19, 20, 3444.00, '2025-05-12 22:53:42', '2025-05-13'),
(20, 20, 3444.00, '2025-05-12 22:54:04', '2025-05-13'),
(21, 20, 3444.00, '2025-05-12 22:54:05', '2025-05-13'),
(22, 20, 2989.00, '2025-05-12 22:54:21', '2025-05-13'),
(23, 20, 2989.00, '2025-05-12 22:54:23', '2025-05-13'),
(24, 20, 2989.00, '2025-05-12 22:54:24', '2025-05-13'),
(25, 20, -1455.00, '2025-05-12 22:55:01', '2025-05-13'),
(26, 20, -1455.00, '2025-05-12 22:55:21', '2025-05-13'),
(27, 20, -1455.00, '2025-05-12 22:56:31', '2025-05-13'),
(28, 20, -1455.00, '2025-05-12 22:56:46', '2025-05-13'),
(29, 20, -4788.00, '2025-05-12 22:57:00', '2025-05-13'),
(30, 20, -4788.00, '2025-05-12 22:57:04', '2025-05-13'),
(31, 20, -4788.00, '2025-05-12 22:57:23', '2025-05-13'),
(32, 20, -4788.00, '2025-05-12 22:57:26', '2025-05-13'),
(33, 20, -4788.00, '2025-05-12 22:57:35', '2025-05-13'),
(34, 21, 0.00, '2025-05-12 22:58:37', '2025-05-13'),
(35, 21, -100.00, '2025-05-12 22:59:00', '2025-05-13'),
(36, 21, 9900.00, '2025-05-12 22:59:15', '2025-05-13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `banned_until` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `banned_until`) VALUES
(21, 'Hizkia Siahaan', 'hzkiashn02@gmail.com', '$2y$10$QwEf4qHxGivc4JUM.HaxgOtWaYy/RjHr9Fs3mmZRL7k1kyckQqG9G', '2025-05-12 22:58:11', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `income`
--
ALTER TABLE `income`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `savings`
--
ALTER TABLE `savings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `savings_ibfk_1` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `income`
--
ALTER TABLE `income`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `savings`
--
ALTER TABLE `savings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
