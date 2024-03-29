-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-05-21 08:18:48
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

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
-- 表的结构 `nox_class`
--

CREATE TABLE IF NOT EXISTS `nox_class` (
  `cid` int(11) NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `cname` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '分类名称',
  `cdes` text COLLATE utf8_bin COMMENT '分类描述',
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `nox_class`
--

INSERT INTO `nox_class` (`cid`, `cname`, `cdes`) VALUES
(1, '产品分类', '一个产品分类'),
(9, 'Vip特权', '赠送');

-- --------------------------------------------------------

--
-- 表的结构 `nox_global`
--

CREATE TABLE IF NOT EXISTS `nox_global` (
  `gid` int(11) NOT NULL AUTO_INCREMENT,
  `sitename` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '网站名称',
  `birth` tinyint(4) NOT NULL COMMENT '生日提醒提前日期（天）',
  PRIMARY KEY (`gid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `nox_global`
--

INSERT INTO `nox_global` (`gid`, `sitename`, `birth`) VALUES
(1, 'Nox客户管理平台', 3);

-- --------------------------------------------------------

--
-- 表的结构 `nox_project`
--

CREATE TABLE IF NOT EXISTS `nox_project` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `pname` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '项目名称',
  `pdesc` text COLLATE utf8_bin COMMENT '项目描述',
  `cid` int(11) NOT NULL COMMENT '分类ID',
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `nox_project`
--

INSERT INTO `nox_project` (`pid`, `pname`, `pdesc`, `cid`) VALUES
(4, '产品1', '', 1),
(10, '生日贺礼', '', 9);

-- --------------------------------------------------------

--
-- 表的结构 `nox_users`
--

CREATE TABLE IF NOT EXISTS `nox_users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `uname` varchar(64) COLLATE utf8_bin NOT NULL COMMENT '账号',
  `upass` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '密码',
  `ulevel` int(11) NOT NULL COMMENT '权限',
  `ulogtime` int(10) DEFAULT NULL COMMENT '登录时间',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `nox_users`
--

INSERT INTO `nox_users` (`uid`, `uname`, `upass`, `ulevel`, `ulogtime`) VALUES
(1, 'root', 'a5a732e5c7aacf8ab59cdf472e79f19f487f8adc', 0, 1432189051);

-- --------------------------------------------------------

--
-- 表的结构 `nox_vip`
--

CREATE TABLE IF NOT EXISTS `nox_vip` (
  `vid` int(11) NOT NULL AUTO_INCREMENT,
  `vcard` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '会员卡号',
  `vname` varchar(64) COLLATE utf8_bin NOT NULL COMMENT '会员姓名',
  `vbirth` int(10) DEFAULT NULL COMMENT '出生日期',
  `vcontact_info` varchar(18) COLLATE utf8_bin DEFAULT NULL COMMENT '联系方式',
  `vcontact_address` text COLLATE utf8_bin COMMENT '联系地址',
  `vserver_owner` varchar(64) COLLATE utf8_bin DEFAULT NULL COMMENT '服务店家',
  `vproduct` text COLLATE utf8_bin COMMENT '购买产品',
  `vproject` text COLLATE utf8_bin COMMENT '拥有礼包',
  `vproject_consume` text COLLATE utf8_bin COMMENT '已消费礼包',
  `vproject_not_consume` text COLLATE utf8_bin COMMENT '未消费礼包',
  `vmoney` int(9) NOT NULL DEFAULT '0' COMMENT '消费金额',
  `vintegral` int(11) NOT NULL DEFAULT '0' COMMENT '积分',
  `vpass` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '查询密码',
  PRIMARY KEY (`vid`),
  UNIQUE KEY `vcard` (`vcard`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `nox_vip`
--

INSERT INTO `nox_vip` (`vid`, `vcard`, `vname`, `vbirth`, `vcontact_info`, `vcontact_address`, `vserver_owner`, `vproduct`, `vproject`, `vproject_consume`, `vproject_not_consume`, `vmoney`, `vintegral`, `vpass`) VALUES
(12, '1000', 'sdasd', 1431532800, '123123', '', '', '["4","5"]', '["10"]', 'null', '["10"]', 200, 10, '74e22fd687e82206d375a478e0a549ff7c7519d7');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
