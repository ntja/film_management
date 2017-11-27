
--
-- Database: `film_management`
--
CREATE DATABASE IF NOT EXISTS `film_management` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `film_management`;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL COMMENT 'primary key of the row',
  `content` varchar(255) NOT NULL COMMENT 'content of comment',
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'when the comment has been posted',
  `user` int(11) NOT NULL COMMENT 'user who made the comment',
  `film` int(11) NOT NULL COMMENT 'film the comment belongs to'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `films`
--

CREATE TABLE `films` (
  `id` int(11) NOT NULL COMMENT 'primary key of the row',
  `name` varchar(100) NOT NULL COMMENT 'name of the film',
  `slug_name` varchar(100) NOT NULL COMMENT 'slug version of film name',
  `description` text NOT NULL COMMENT 'description of film',
  `release_date` date NOT NULL COMMENT 'date when the film has been released',
  `rating` enum('1','2','3','4','5') NOT NULL COMMENT 'scale of rating',
  `ticket_price` double NOT NULL COMMENT 'price of ticket',
  `country` varchar(100) NOT NULL,
  `photo` varchar(255) NOT NULL COMMENT 'film cover'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `film_genres`
--

CREATE TABLE `film_genres` (
  `id` int(11) NOT NULL COMMENT 'primary key of the row',
  `film` int(11) NOT NULL COMMENT 'Film ID',
  `genre` int(11) NOT NULL COMMENT 'genre ID'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL COMMENT 'primary key of the row',
  `name` varchar(100) NOT NULL COMMENT 'name of genre'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT 'primary key of the row',
  `full_name` varchar(100) NOT NULL COMMENT 'user first name',
  `email` varchar(255) NOT NULL COMMENT 'user email address',
  `password` varchar(255) NOT NULL COMMENT 'user password'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`),
  ADD KEY `film` (`film`);

--
-- Indexes for table `films`
--
ALTER TABLE `films`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `film_genres`
--
ALTER TABLE `film_genres`
  ADD PRIMARY KEY (`id`),
  ADD KEY `film` (`film`),
  ADD KEY `genre` (`genre`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key of the row', AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `films`
--
ALTER TABLE `films`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key of the row', AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `film_genres`
--
ALTER TABLE `film_genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key of the row', AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key of the row', AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key of the row', AUTO_INCREMENT=19;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_films_film` FOREIGN KEY (`film`) REFERENCES `films` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_comments_users_user` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `film_genres`
--
ALTER TABLE `film_genres`
  ADD CONSTRAINT `fk_films_films_genres_film` FOREIGN KEY (`film`) REFERENCES `films` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_genres_films_genres_genre` FOREIGN KEY (`genre`) REFERENCES `genres` (`id`) ON UPDATE CASCADE;

