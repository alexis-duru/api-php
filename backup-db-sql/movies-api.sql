-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : sam. 14 jan. 2023 à 16:17
-- Version du serveur :  5.7.32
-- Version de PHP : 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `movies-api`
--

-- --------------------------------------------------------

--
-- Structure de la table `actors`
--

CREATE TABLE `actors` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `bio` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `actors`
--

INSERT INTO `actors` (`id`, `first_name`, `last_name`, `dob`, `bio`) VALUES
(1, 'Morgan', 'Freeman', '1937-06-01', 'Morgan Freeman est un acteur, réalisateur et producteur américain. Il est surtout connu pour ses rôles dans les films \"The Shawshank Redemption\", \"Million Dollar Baby\" et \"The Dark Knight\". Il a remporté l\'Oscar du meilleur acteur dans un second rôle pour son rôle dans \"Million Dollar Baby\" et il est considéré comme l\'un des acteurs les plus respectés de sa génération.'),
(2, 'Tim', 'Robbins', '1958-10-16', 'Tim Robbins est un acteur, réalisateur, producteur et scénariste américain. Il est surtout connu pour ses rôles dans les films \"The Shawshank Redemption\", \"Dead Man Walking\" et \"Mystic River\". Il a remporté l\'Oscar du meilleur acteur dans un second rôle pour son rôle dans \"Mystic River\".'),
(3, 'Tom', 'Hanks', '1956-07-09', 'Tom Hanks est un acteur, producteur, réalisateur et scénariste américain. Il est surtout connu pour ses rôles dans les films \"Forrest Gump\", \"Saving Private Ryan\" et \"Cast Away\". Il a remporté deux Oscars du meilleur acteur pour ses rôles dans \"Philadelphia\" et \"Forrest Gump\" et il est considéré comme l\'un des acteurs les plus populaires et les plus respectés de sa génération.'),
(4, 'Samuel', 'Jackson', '1948-12-21', 'Samuel L. Jackson est un acteur et producteur américain. Il est surtout connu pour ses rôles dans les films \"Pulp Fiction\", \"Snakes on a Plane\" et \"The Avengers\". Il est considéré comme l\'un des acteurs les plus populaires et les plus respectés de sa génération.'),
(5, 'Thomas', 'Jane', '1969-02-22', 'Thomas Jane est un acteur américain, il est surtout connu pour son rôle dans \"The Mist\", \"Deep Blue Sea\" et \"Hung\" . Il a également joué dans des films indépendants et des séries télévisées telles que \"Boogie Nights\" and \"The Punisher\". Il est considéré comme un acteur talentueux et versatile.'),
(6, 'Keanu', 'Reeves', '1964-09-02', ' Keanu Reeves est un acteur connu pour ses rôles dans des films tels que \"The Matrix\", \"John Wick\" et \"Speed\", il est considéré comme l\'un des acteurs les plus populaires de sa génération.');

-- --------------------------------------------------------

--
-- Structure de la table `directors`
--

CREATE TABLE `directors` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `bio` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `directors`
--

INSERT INTO `directors` (`id`, `first_name`, `last_name`, `dob`, `bio`) VALUES
(1, 'Christopher', 'Nolan', '1970-07-30', 'Il est connu pour ses films de science-fiction et de suspense tels que \"Inception\", \"The Dark Knight\" et \"Interstellar\", avec un style visuel innovant et une narration complexe. Il est considéré comme l\'un des réalisateurs les plus importants de sa génération.'),
(2, 'Quentin', 'Tarantino', '1963-03-27', 'Il est connu pour son style de réalisation très personnel et ses dialogues percutants dans des films comme \"Pulp Fiction\" et \"Inglourious Basterds\", Il est considéré comme l\'un des cinéastes les plus influents de sa génération, il a remporté le Prix de la mise en scène à Cannes en 1994 pour Pulp Fiction'),
(3, 'Larry', 'Wachowski', '1965-03-29', 'Ils sont connus pour avoir dirigé et écrit la trilogie Matrix (The Matrix, Matrix Reloaded, Matrix Revolutions) , avec un style visuel innovant et une narration complexe. Ils ont également dirigé et écrit d\'autres films tels que \"V pour Vendetta\" et \"Cloud Atlas\".'),
(4, 'Frank', 'Darabont', '1959-01-29', 'Il est connu pour avoir dirigé et écrit des films tels que \"The Shawshank Redemption\", \"The Green Mile\" et \"The Mist\" . Il est également scénariste pour des séries télévisées telles que \"The Walking Dead\" . Il a été nominé pour un Oscar pour son adaptation de \"The Shawshank Redemption\" .');

-- --------------------------------------------------------

--
-- Structure de la table `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `genres`
--

INSERT INTO `genres` (`id`, `name`) VALUES
(1, 'Drame'),
(2, 'Comédie'),
(3, 'Action'),
(4, 'Thriller'),
(5, 'Science-fiction');

-- --------------------------------------------------------

--
-- Structure de la table `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `release_date` year(4) NOT NULL,
  `plot` varchar(255) NOT NULL,
  `runtime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `movies`
--

INSERT INTO `movies` (`id`, `title`, `release_date`, `plot`, `runtime`) VALUES
(12, 'Inception', 2010, 'Un voleur expérimenté est embauché pour infiltrer les rêves d\'une personne et voler une idée secrète.', '02:15:59'),
(13, 'The Shawshank Redemption', 1994, 'Deux détenus, l\'un coupable de meurtre, l\'autre innocent, développent une amitié au sein de la prison d\'État de Shawshank. Durée: 142 minutes.', '02:25:59'),
(14, 'The Dark Knight', 2008, 'Batman combat le Joker, un criminel sadique qui sème la terreur dans Gotham City.', '02:15:59'),
(15, 'Pulp Fiction', 1994, ' Plusieurs histoires sont entrelacées dans ce film noir sur la criminalité à Los Angeles.', '03:00:59'),
(16, 'The Matrix', 1999, 'Un hacker découvre que le monde réel est un simulacre créé par des machines pour asservir l\'humanité, et rejoint une rébellion pour le renverser.', '02:45:00');

-- --------------------------------------------------------

--
-- Structure de la table `movie_actors`
--

CREATE TABLE `movie_actors` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `actor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `movie_actors`
--

INSERT INTO `movie_actors` (`id`, `movie_id`, `actor_id`) VALUES
(1, 13, 1),
(2, 13, 2),
(3, 15, 4),
(4, 16, 6);

-- --------------------------------------------------------

--
-- Structure de la table `movie_directors`
--

CREATE TABLE `movie_directors` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `director_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `movie_directors`
--

INSERT INTO `movie_directors` (`id`, `movie_id`, `director_id`) VALUES
(1, 12, 1),
(2, 14, 1),
(3, 13, 4),
(4, 16, 3),
(5, 15, 2);

-- --------------------------------------------------------

--
-- Structure de la table `movie_genres`
--

CREATE TABLE `movie_genres` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `movie_genres`
--

INSERT INTO `movie_genres` (`id`, `movie_id`, `genre_id`) VALUES
(1, 12, 5),
(2, 15, 3),
(3, 14, 3),
(4, 16, 5),
(5, 13, 4);

-- --------------------------------------------------------

--
-- Structure de la table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reviews`
--

INSERT INTO `reviews` (`id`, `movie_id`, `username`, `content`, `date`) VALUES
(3, 12, 'Todd McCarthy', 'Inception est un film de science-fiction éblouissant, une expérience cinématographique fascinante qui vous laisse à bout de souffle', '2023-01-12'),
(4, 13, 'Roger Ebert', 'The Shawshank Redemption est un film magnifique, émouvant et incroyablement bien réalisé', '2023-01-12');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `actors`
--
ALTER TABLE `actors`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `directors`
--
ALTER TABLE `directors`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `movie_actors`
--
ALTER TABLE `movie_actors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `actor_id` (`actor_id`);

--
-- Index pour la table `movie_directors`
--
ALTER TABLE `movie_directors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `director_id` (`director_id`);

--
-- Index pour la table `movie_genres`
--
ALTER TABLE `movie_genres`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Index pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `actors`
--
ALTER TABLE `actors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `directors`
--
ALTER TABLE `directors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `movie_actors`
--
ALTER TABLE `movie_actors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `movie_directors`
--
ALTER TABLE `movie_directors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `movie_genres`
--
ALTER TABLE `movie_genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `movie_actors`
--
ALTER TABLE `movie_actors`
  ADD CONSTRAINT `movie_actors_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`),
  ADD CONSTRAINT `movie_actors_ibfk_2` FOREIGN KEY (`actor_id`) REFERENCES `actors` (`id`);

--
-- Contraintes pour la table `movie_directors`
--
ALTER TABLE `movie_directors`
  ADD CONSTRAINT `movie_directors_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`),
  ADD CONSTRAINT `movie_directors_ibfk_2` FOREIGN KEY (`director_id`) REFERENCES `directors` (`id`);

--
-- Contraintes pour la table `movie_genres`
--
ALTER TABLE `movie_genres`
  ADD CONSTRAINT `movie_genres_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`),
  ADD CONSTRAINT `movie_genres_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`);

--
-- Contraintes pour la table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `movie_id` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
