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
-- Generation Time: 2015-08-30 15:35:22
-- 服务器版本： 5.5.30-log
-- PHP Version: 5.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `warcrm`
--

-- --------------------------------------------------------

--
-- 表的结构 `attachments`
--

CREATE TABLE `attachments` (
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
  KEY `chatId` (`chatId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `chats`
--

CREATE TABLE `chats` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

--
-- 表的结构 `domains`
--

CREATE TABLE `domains` (
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

CREATE TABLE `groups` (
  `id` char(20) NOT NULL,
  `did` char(20) NOT NULL,
  `createUid` char(20) NOT NULL,
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

CREATE TABLE `messages` (
  `id` char(20) NOT NULL,
  `cid` varchar(40) NOT NULL,
  `sender` char(20) NOT NULL,
  `content` text NOT NULL,
  `createTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `extraData` text NOT NULL,
  `did` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
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
  UNIQUE KEY `email` (`email`(30),`did`)
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
