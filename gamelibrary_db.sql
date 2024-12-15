-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2024 at 01:32 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gamelibrary_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_games`
--

CREATE TABLE `tbl_games` (
  `game_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `price` decimal(5,2) DEFAULT NULL,
  `release_year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_games`
--

INSERT INTO `tbl_games` (`game_id`, `title`, `genre`, `price`, `release_year`) VALUES
(1, 'Grand Theft Auto V', 'Action', 29.99, 2013),
(2, 'Red Dead Redemption 2', 'Action', 39.99, 2018),
(3, 'Marvel\'s Spider-Man', 'Action', 49.99, 2018),
(4, 'Batman: Arkham Knight', 'Action', 19.99, 2016),
(5, 'Ghost of Tsushima', 'Adventure', 49.99, 2020),
(6, 'The Witcher 3: Wild Hunt', 'RPG', 19.99, 2015),
(7, 'Cyberpunk 2077', 'RPG', 29.99, 2020),
(8, 'Elden Ring', 'RPG', 60.00, 2022),
(9, 'Final Fantasy VII Remake', 'RPG', 59.99, 2021),
(10, 'Persona 5 Royal', 'RPGs', 59.99, 2020),
(11, 'Dragon Age: Inquisition', 'RPG', 19.99, 2014),
(12, 'The Elder Scrolls V: Skyrim', 'RPG', 39.99, 2011),
(13, 'Mass Effect: Legendary Edition', 'RPG', 59.99, 2021),
(14, 'Call of Duty: Warzone', 'FPS', 0.00, 2020),
(15, 'Valorant', 'FPS', 0.00, 2020),
(16, 'Overwatch 2', 'FPS', 0.00, 2022),
(17, 'Doom Eternal', 'FPS', 39.99, 2020),
(18, 'Apex Legends', 'FPS', 0.00, 2019),
(19, 'Counter-Strike 2', 'FPS', 0.00, 2023),
(20, 'Minecraft', 'Sandbox', 26.95, 2011),
(21, 'Terraria', 'Sandbox', 9.99, 2011),
(22, 'No Man\'s Sky', 'Sandbox', 39.99, 2016),
(23, 'Garry\'s Mod', 'Sandbox', 9.99, 2006),
(24, 'FIFA 23', 'Sports', 59.99, 2022),
(25, 'NBA 2K23', 'Sports', 59.99, 2022),
(26, 'Madden NFL 23', 'Sports', 59.99, 2022),
(27, 'F1 2022', 'Sports', 49.99, 2022),
(28, 'NHL 23', 'Sports', 59.99, 2022),
(29, 'The Legend of Zelda: Breath of the Wild', 'Adventure', 59.99, 2017),
(30, 'Horizon Zero Dawn', 'Adventure', 19.99, 2017),
(31, 'Uncharted 4: A Thief\'s End', 'Adventure', 19.99, 2016),
(32, 'God of War', 'Adventure', 49.99, 2018),
(33, 'Star Wars Jedi: Fallen Order', 'Adventure', 39.99, 2019),
(34, 'Civilization VI', 'Strategy', 29.99, 2016),
(35, 'Total War: Warhammer III', 'Strategy', 59.99, 2022),
(36, 'Age of Empires IV', 'Strategy', 49.99, 2021),
(37, 'XCOM 2', 'Strategy', 29.99, 2016),
(38, 'Europa Universalis IV', 'Strategy', 39.99, 2013),
(39, 'Fortnite', 'Battle Royale', 0.00, 2017),
(40, 'PUBG: Battlegrounds', 'Battle Royale', 29.99, 2017),
(41, 'Fall Guys', 'Battle Royale', 19.99, 2020),
(42, 'Resident Evil Village', 'Horror', 39.99, 2021),
(43, 'Outlast', 'Horror', 19.99, 2013),
(44, 'Dead Space Remake', 'Horror', 49.99, 2023),
(45, 'Phasmophobia', 'Horror', 13.99, 2020),
(46, 'Forza Horizon 5', 'Racing', 59.99, 2021),
(47, 'Gran Turismo 7', 'Racing', 69.99, 2022),
(48, 'Need for Speed Heat', 'Racing', 29.99, 2019),
(49, 'Hades', 'Indie', 24.99, 2020),
(50, 'Stardew Valley', 'Indie', 14.99, 2016),
(51, 'Hollow Knight', 'Indie', 14.99, 2017),
(52, 'Cuphead', 'Indie', 19.99, 2017),
(53, 'League of Legends', 'MOBA', 0.00, 2009),
(54, 'Dota 2', 'MOBA', 0.00, 2013),
(55, 'Microsoft Flight Simulator', 'Simulation', 59.99, 2020),
(56, 'The Sims 4', 'Simulation', 39.99, 2014),
(57, 'Cities: Skylines', 'Simulation', 29.99, 2015),
(58, 'Mortal Kombat 11', 'Fighting', 39.99, 2019),
(59, 'Street Fighter 6', 'Fighting', 59.99, 2023),
(60, 'Super Smash Bros. Ultimate', 'Fighting', 59.99, 2018),
(61, 'Super Mario Odyssey', 'Platformer', 49.99, 2018),
(62, 'Celeste', 'Platformer', 19.99, 2018),
(63, 'Ratchet & Clank: Rift Apart', 'Platformer', 69.99, 2021),
(64, 'Among Us', 'Party', 5.00, 2018),
(65, 'Mario Party Superstars', 'Party', 59.99, 2021),
(66, 'Dead Cells', 'Roguelike', 24.99, 2018),
(67, 'The Binding of Isaac', 'Roguelike', 14.99, 2011),
(68, 'Risk of Rain 2', 'Roguelike', 29.99, 2020);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_wishlist`
--

CREATE TABLE `tbl_wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_wishlist`
--

INSERT INTO `tbl_wishlist` (`id`, `user_id`, `game_id`) VALUES
(1, 2, 18),
(2, 2, 62),
(3, 2, 14),
(8, 2, 66),
(10, 2, 8),
(14, 2, 7),
(15, 2, 30),
(16, 2, 55),
(17, 2, 29),
(18, 2, 67),
(19, 2, 37),
(20, 5, 27);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `email`) VALUES
(1, 'john', '$2y$10$ADiffO0SOBdYejeV2ijrseNOHBZIIcWyCa3i8EXmj9tqc4QWV.z9O', 'admin', 'john@john.com'),
(2, 'johnjohn', '$2y$10$.NEcZZCa6XCJPxhN9hVfHeQ8dbPofMMQfnTuX51LcuwUSj/uZEQ.S', 'user', 'johnjohn@john.com'),
(3, 'jepoy', '$2y$10$RT4kUayYtC.SayYEwNEiT.LDzvjYO.gCM4ckgr2FcIQMxFuOAXHQG', 'user', 'jepoy@gmail.com'),
(4, 'stal', '$2y$10$CTzTWBis4ZvalNwYC1i9rudrys1.IkBfHPqdch36PHjYuVZDZkFze', 'admin', 'stalingrad@gmail.com'),
(5, 'winjan', '$2y$10$DWp0/ff6F.nYYD1cPOdcYOtrBZvnaUXAuaMHC1LIiHptg5BGFUR8m', 'user', 'winjan@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_games`
--
ALTER TABLE `tbl_games`
  ADD PRIMARY KEY (`game_id`);

--
-- Indexes for table `tbl_wishlist`
--
ALTER TABLE `tbl_wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `game_id` (`game_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_games`
--
ALTER TABLE `tbl_games`
  MODIFY `game_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `tbl_wishlist`
--
ALTER TABLE `tbl_wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_wishlist`
--
ALTER TABLE `tbl_wishlist`
  ADD CONSTRAINT `tbl_wishlist_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_wishlist_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `tbl_games` (`game_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
