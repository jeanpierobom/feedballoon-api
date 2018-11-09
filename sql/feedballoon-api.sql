SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `job_title` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `plan` varchar(50) NOT NULL DEFAULT 'basic',
  `calls_made` int(11) NOT NULL DEFAULT '0',
  `time_start` varchar(255) NOT NULL DEFAULT '0',
  `time_end` varchar(255) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `users` (`id`, `firstName`, `lastName`, `username`, `password`, `plan`, `calls_made`, `time_start`, `time_end`) VALUES
(1, 'First', 'Last', 'test@test.com', 'test123', 'unlimited', 0, '0', '0'),
(2, 'John', 'Smith', 'johnsmith@test.com', 'test123', 'unlimited', 0, '0', '0'),
(3, 'Mary', 'Anne', 'mary@test.com', 'test123', 'unlimited', 0, '0', '0');

ALTER TABLE `users` ADD PRIMARY KEY (`id`);

ALTER TABLE `users` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` TEXT NULL,
  `private` TINYINT(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `groups` (`id`, `name`, `private`) VALUES
(1, 'Langara WMDD 2018', false),
(2, 'FeedBalloon Team', false),
(3, 'ACME Company', false);

ALTER TABLE `groups` ADD PRIMARY KEY (`id`);

ALTER TABLE `groups` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

CREATE TABLE `groups_members` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `approved` TINYINT(1) NOT NULL,
  FOREIGN KEY (group_id) REFERENCES groups(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `groups_members` ADD PRIMARY KEY (`id`);

ALTER TABLE `groups_members` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `tag` VARCHAR(30) NOT NULL,
  `message` VARCHAR(280) NOT NULL,
  `date` TIMESTAMP NOT NULL,
  FOREIGN KEY (from_user_id) REFERENCES users(id),
  FOREIGN KEY (to_user_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `feedback` ADD PRIMARY KEY (`id`);

ALTER TABLE `feedback` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

CREATE TABLE `feedback_reply` (
  `id` int(11) NOT NULL,
  `feedback_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` VARCHAR(280) NOT NULL,
  `date` TIMESTAMP NOT NULL,
  FOREIGN KEY (feedback_id) REFERENCES feedback(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `feedback_reply` ADD PRIMARY KEY (`id`);

ALTER TABLE `feedback_reply` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
