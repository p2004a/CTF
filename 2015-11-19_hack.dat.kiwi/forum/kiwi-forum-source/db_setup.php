<?php

sql("CREATE DATABASE `{$creds['dbname']}`");
sql("USE `{$creds['dbname']}`");

sql("CREATE TABLE IF NOT EXISTS `posts` (
`ID` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `subject` varchar(256) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `content` text NOT NULL
) ");
sql("CREATE TABLE IF NOT EXISTS `profile` (
  `ID` int(11) NOT NULL,
  `alias` varchar(64) NOT NULL
)");
sql("CREATE TABLE IF NOT EXISTS `users` (
`ID` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `salt` varchar(64) NOT NULL,
  `password` varchar(64) NOT NULL,
  `email` varchar(128) NOT NULL DEFAULT '',
  `access` int(11) NOT NULL DEFAULT '0'
)");

sql("ALTER TABLE `posts`
 ADD PRIMARY KEY (`ID`), ADD KEY `owner` (`owner`)");
sql("ALTER TABLE `profile`
 ADD PRIMARY KEY (`ID`)");
sql("ALTER TABLE `users`
 ADD PRIMARY KEY (`ID`), ADD UNIQUE KEY `username` (`username`), ADD KEY `email` (`email`,`access`)");
sql("ALTER TABLE `posts`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT");
sql("ALTER TABLE `users`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT");

sql("INSERT INTO `posts` (`ID`, `owner`, `subject`, `timestamp`, `content`) VALUES
(1, 1, 'Welcome', 1446764022, 'Hello mere mortals. Give it your best shot!')");

