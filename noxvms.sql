-- phpMyAdmin SQL Dump
-- version 4.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2015-02-13 09:29:59
-- 服务器版本： 5.5.19
-- PHP Version: 5.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `noxvms`
--

-- --------------------------------------------------------

--
-- 表的结构 `nox_global`
--

CREATE TABLE IF NOT EXISTS `nox_global` (
  `gid` int(11) NOT NULL,
  `sitename` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '网站名称',
  `birth` tinyint(4) NOT NULL COMMENT '生日提醒提前日期（天）'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `nox_global`
--

INSERT INTO `nox_global` (`gid`, `sitename`, `birth`) VALUES
(1, 'NoxVMS', 3);

-- --------------------------------------------------------

--
-- 表的结构 `nox_project`
--

CREATE TABLE IF NOT EXISTS `nox_project` (
  `pid` int(11) NOT NULL,
  `pname` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '项目名称',
  `pdesc` text COLLATE utf8_bin COMMENT '项目描述'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `nox_project`
--

INSERT INTO `nox_project` (`pid`, `pname`, `pdesc`) VALUES
(1, '产品1', ''),
(2, '产品2', '');

-- --------------------------------------------------------

--
-- 表的结构 `nox_users`
--

CREATE TABLE IF NOT EXISTS `nox_users` (
  `uid` int(11) NOT NULL,
  `uname` varchar(64) COLLATE utf8_bin NOT NULL COMMENT '账号',
  `upass` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '密码',
  `ulevel` int(11) NOT NULL COMMENT '权限',
  `ulogtime` int(10) DEFAULT NULL COMMENT '登录时间'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `nox_users`
--

INSERT INTO `nox_users` (`uid`, `uname`, `upass`, `ulevel`, `ulogtime`) VALUES
(1, 'root', 'a5a732e5c7aacf8ab59cdf472e79f19f487f8adc', 0, 1423704196),
(6, 'admin', 'db1eb703b5aa7070e975737265831fe255422bba', 1, 1423618285);

-- --------------------------------------------------------

--
-- 表的结构 `nox_vip`
--

CREATE TABLE IF NOT EXISTS `nox_vip` (
  `vid` int(11) NOT NULL,
  `vcard` int(30) NOT NULL COMMENT '会员卡号',
  `vname` varchar(64) COLLATE utf8_bin NOT NULL COMMENT '会员姓名',
  `vbirth` int(10) DEFAULT NULL COMMENT '出生日期',
  `vcontact_info` int(18) DEFAULT NULL COMMENT '联系方式',
  `vcontact_address` text COLLATE utf8_bin COMMENT '联系地址',
  `vserver_owner` varchar(64) COLLATE utf8_bin DEFAULT NULL COMMENT '服务店家',
  `vserver_owner_number` int(18) DEFAULT NULL COMMENT '店家号码',
  `varea_manager` varchar(64) COLLATE utf8_bin DEFAULT NULL COMMENT '区域经理',
  `vproject` text COLLATE utf8_bin COMMENT '拥有项目',
  `vproject_consume` text COLLATE utf8_bin COMMENT '已消费项目',
  `vproject_not_consume` text COLLATE utf8_bin COMMENT '未消费项目'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `nox_vip`
--

INSERT INTO `nox_vip` (`vid`, `vcard`, `vname`, `vbirth`, `vcontact_info`, `vcontact_address`, `vserver_owner`, `vserver_owner_number`, `varea_manager`, `vproject`, `vproject_consume`, `vproject_not_consume`) VALUES
(1, 1021443805, '用户名', -312019200, 2147483647, '成都', '温江', 110, 'admin', '["1"]', 'null', '["1"]'),
(6, 1000, '用户名2', -28800, 10086, 'M78星云', '什么鬼', 110, NULL, '["1","2"]', '["1"]', '["2"]');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `nox_global`
--
ALTER TABLE `nox_global`
  ADD PRIMARY KEY (`gid`);

--
-- Indexes for table `nox_project`
--
ALTER TABLE `nox_project`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `nox_users`
--
ALTER TABLE `nox_users`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `nox_vip`
--
ALTER TABLE `nox_vip`
  ADD PRIMARY KEY (`vid`), ADD UNIQUE KEY `vcard` (`vcard`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nox_global`
--
ALTER TABLE `nox_global`
  MODIFY `gid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `nox_project`
--
ALTER TABLE `nox_project`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `nox_users`
--
ALTER TABLE `nox_users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `nox_vip`
--
ALTER TABLE `nox_vip`
  MODIFY `vid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
