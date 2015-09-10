<?php

use yii\db\Schema;
use yii\db\Migration;

class m150830_080137_first extends Migration
{
    public function up()
    {
        $this->execute(<<<EOF
-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015-09-10 22:23:16
-- 服务器版本： 5.6.19-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `warcrm`
--

-- --------------------------------------------------------

--
-- 表的结构 `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` char(20) NOT NULL,
  `pid` char(20) NOT NULL,
  `did` char(20) NOT NULL,
  `ownerId` char(20) NOT NULL,
  `title` varchar(256) NOT NULL,
  `content` text NOT NULL,
  `createTime` timestamp NULL DEFAULT NULL,
  `lastModify` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `did` (`did`),
  KEY `ownerId` (`ownerId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `attachments`
--

CREATE TABLE IF NOT EXISTS `attachments` (
  `id` char(20) NOT NULL,
  `name` varchar(256) NOT NULL,
  `size` int(11) NOT NULL,
  `key` varchar(256) NOT NULL,
  `ext` varchar(20) NOT NULL,
  `chatId` char(40) NOT NULL,
  `ownerId` char(20) NOT NULL,
  `createTime` timestamp NULL DEFAULT NULL,
  `did` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `chatId` (`chatId`),
  KEY `ownerId` (`ownerId`),
  KEY `did` (`did`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `chats`
--

CREATE TABLE IF NOT EXISTS `chats` (
  `pk` int(11) NOT NULL AUTO_INCREMENT,
  `id` char(20) NOT NULL,
  `type` tinyint(3) NOT NULL,
  `uid` char(20) NOT NULL,
  `lastMessage` varchar(20) DEFAULT NULL,
  `lastSenderUid` char(20) DEFAULT NULL,
  `unReadCount` int(11) NOT NULL DEFAULT '0',
  `createTime` timestamp NULL DEFAULT NULL,
  `lastActivity` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`pk`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

-- --------------------------------------------------------

--
-- 表的结构 `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` char(20) NOT NULL,
  `ownerId` char(20) NOT NULL,
  `did` char(20) NOT NULL,
  `content` text NOT NULL,
  `createTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lastModify` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `relationId` char(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `relationId` (`relationId`),
  KEY `did` (`did`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `domains`
--

CREATE TABLE IF NOT EXISTS `domains` (
  `id` char(20) NOT NULL,
  `domain` varchar(64) NOT NULL,
  `name` varchar(256) NOT NULL,
  `description` varchar(256) DEFAULT NULL,
  `logo` varchar(256) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `createTime` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `domain` (`domain`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` char(20) NOT NULL,
  `did` char(20) NOT NULL,
  `createUid` char(20) NOT NULL,
  `avatar` text NOT NULL,
  `members` varchar(256) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(256) DEFAULT NULL,
  `createTime` timestamp NULL DEFAULT NULL,
  `lastActivity` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `did` (`did`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` char(20) NOT NULL,
  `cid` varchar(40) NOT NULL,
  `sender` char(20) NOT NULL,
  `content` text NOT NULL,
  `createTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `extraData` text NOT NULL,
  `did` char(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cid` (`cid`),
  KEY `did` (`did`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` char(20) NOT NULL,
  `name` varchar(20) NOT NULL,
  `content` longblob NOT NULL,
  `ownerId` char(20) NOT NULL,
  `members` varchar(500) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `did` char(20) NOT NULL,
  `createTime` timestamp NULL DEFAULT NULL,
  `lastModify` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `did` (`did`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `sprints`
--

CREATE TABLE IF NOT EXISTS `sprints` (
  `id` char(20) NOT NULL,
  `pid` char(20) NOT NULL,
  `did` char(20) NOT NULL,
  `name` int(11) NOT NULL,
  `startTime` timestamp NULL DEFAULT NULL,
  `endTIme` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` char(20) NOT NULL,
  `pid` char(20) NOT NULL,
  `sid` char(20) NOT NULL,
  `did` char(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` date NOT NULL,
  `createUserId` char(20) NOT NULL,
  `ownerId` char(20) NOT NULL,
  `followers` text NOT NULL,
  `createTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lastModify` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `sid` (`sid`),
  KEY `did` (`did`),
  KEY `createUserId` (`createUserId`),
  KEY `ownerId` (`ownerId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` char(20) NOT NULL,
  `email` varchar(256) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `title` varchar(40) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `avatar` varchar(256) DEFAULT NULL,
  `description` varchar(256) DEFAULT NULL,
  `password` varchar(32) NOT NULL,
  `salt` char(6) NOT NULL,
  `did` char(20) NOT NULL,
  `isAdmin` tinyint(4) NOT NULL DEFAULT '0',
  `createTime` timestamp NULL DEFAULT NULL,
  `lastActivity` timestamp NULL DEFAULT NULL,
  `accessToken` char(32) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `loginStatus` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `accessToken` (`accessToken`),
  UNIQUE KEY `email` (`email`(30),`did`),
  KEY `did` (`did`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
EOF
        );
    }

    public function down()
    {
        $this->execute(<<<EOF
DROP TABLE {{attachments}};
DROP TABLE {{chats}};
DROP TABLE {{domains}};
DROP TABLE {{groups}};
DROP TABLE {{messages}};
DROP TABLE {{users}};
DROP TABLE {{projects}};
DROP TABLE {{articles}};
DROP TABLE {{sprints}};
DROP TABLE {{tasks}};
DROP TABLE {{comments}};
EOF
        );
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
