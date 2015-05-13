-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015-05-13 08:46:13
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
(1, '家具套装', '一个产品分类'),
(9, '24000元项目代金券礼包', '赠送');

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
(1, '法铂丽会员管理系统', 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `nox_project`
--

INSERT INTO `nox_project` (`pid`, `pname`, `pdesc`, `cid`) VALUES
(4, '面膜', '', 1),
(5, '眼霜', '', 1),
(6, '手霜', '', 1),
(7, '4000元面部整形代金券', '', 9),
(8, '4000元躯体塑形代金券', '', 9),
(9, '4000元微整形代金券', '', 9);

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
(1, 'root', 'a5a732e5c7aacf8ab59cdf472e79f19f487f8adc', 0, 1431479992),
(6, 'admin', 'db1eb703b5aa7070e975737265831fe255422bba', 1, 1423618285);

-- --------------------------------------------------------

--
-- 表的结构 `nox_vip`
--

CREATE TABLE IF NOT EXISTS `nox_vip` (
  `vid` int(11) NOT NULL AUTO_INCREMENT,
  `vcard` int(30) NOT NULL COMMENT '会员卡号',
  `vname` varchar(64) COLLATE utf8_bin NOT NULL COMMENT '会员姓名',
  `vbirth` int(10) DEFAULT NULL COMMENT '出生日期',
  `vcontact_info` varchar(18) COLLATE utf8_bin DEFAULT NULL COMMENT '联系方式',
  `vcontact_address` text COLLATE utf8_bin COMMENT '联系地址',
  `vserver_owner` varchar(64) COLLATE utf8_bin DEFAULT NULL COMMENT '服务店家',
  `vserver_owner_number` int(18) DEFAULT NULL COMMENT '店家号码',
  `varea_manager` varchar(64) COLLATE utf8_bin DEFAULT NULL COMMENT '区域经理',
  `vproduct` text COLLATE utf8_bin COMMENT '购买产品',
  `vproject` text COLLATE utf8_bin COMMENT '拥有礼包',
  `vproject_consume` text COLLATE utf8_bin COMMENT '已消费礼包',
  `vproject_not_consume` text COLLATE utf8_bin COMMENT '未消费礼包',
  `vintegral` int(11) NOT NULL DEFAULT '0' COMMENT '积分',
  `vpass` varchar(40) COLLATE utf8_bin NOT NULL COMMENT '查询密码',
  PRIMARY KEY (`vid`),
  UNIQUE KEY `vcard` (`vcard`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `nox_vip`
--

INSERT INTO `nox_vip` (`vid`, `vcard`, `vname`, `vbirth`, `vcontact_info`, `vcontact_address`, `vserver_owner`, `vserver_owner_number`, `varea_manager`, `vproduct`, `vproject`, `vproject_consume`, `vproject_not_consume`, `vintegral`, `vpass`) VALUES
(1, 1021443805, '用户名', -312019200, '2147483647', '成都', '温江', 110, 'admin', NULL, '[]', 'null', '[]', 0, ''),
(6, 1000, '用户名2', -28800, '10086', 'M78星云', '什么鬼', 110, NULL, NULL, '[]', '[]', '[]', 0, '475d063fe2c92fd29c10f6c633f63a0287219863'),
(8, 2147483647, '斯蒂芬', 1432051200, '123123123123', '', '', 0, '', NULL, '[]', 'null', '[]', 0, '74e22fd687e82206d375a478e0a549ff7c7519d7'),
(9, 55555, '姓名', 1431100800, '999999', '', '', 110, '', '["4","5","6"]', '["7","8","9"]', 'null', '["7","8","9"]', 10, '3badf652b896b557c7d92973169b516cc7abc073'),
(10, 5333333, '跤不死', 1431014400, '888888888', '成都', '店家', 0, '经历', '["4","5"]', '["7"]', '[]', '["7"]', 10, '534419a090d0e7594ba044381f1d3e9c349515de');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
