-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 年 09 月 27 日 01:21
-- 服务器版本: 5.5.53
-- PHP 版本: 5.4.45

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `zhihuoinfo`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin_admin`
--

CREATE TABLE IF NOT EXISTS `admin_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` char(32) NOT NULL,
  `number` varchar(10) NOT NULL DEFAULT '0' COMMENT '工号',
  `birthday` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(15) NOT NULL COMMENT '电话号码',
  `weixin` varchar(50) NOT NULL COMMENT '微信号',
  `qq` varchar(12) NOT NULL COMMENT 'qq号',
  `native` varchar(50) NOT NULL COMMENT '籍贯',
  `address` varchar(120) NOT NULL COMMENT '家庭住址',
  `schooling` varchar(20) NOT NULL COMMENT '学历 1研究生2本科3大专4高职',
  `company_id` tinyint(3) unsigned NOT NULL COMMENT '公司id',
  `depart_id` tinyint(3) unsigned NOT NULL COMMENT '部门id',
  `entry` date NOT NULL COMMENT '入职时间',
  `entry_pos` varchar(30) NOT NULL COMMENT '入职职位',
  `remark` text NOT NULL COMMENT '备注说明',
  `status` tinyint(4) NOT NULL DEFAULT '2',
  `create_user_id` int(10) unsigned NOT NULL,
  `create_time` int(10) unsigned NOT NULL COMMENT '创建时间',
  `update_user_id` int(10) unsigned NOT NULL COMMENT '更新人',
  `update_time` int(10) unsigned NOT NULL COMMENT '更新时间',
  `salary` int(11) NOT NULL COMMENT '工资',
  `is_delete` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否删除 默认:0,2已删除1:正常',
  `entry_year` varchar(20) NOT NULL COMMENT '工龄',
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='管理员表' AUTO_INCREMENT=17 ;

--
-- 转存表中的数据 `admin_admin`
--

INSERT INTO `admin_admin` (`id`, `username`, `password`, `number`, `birthday`, `email`, `mobile`, `weixin`, `qq`, `native`, `address`, `schooling`, `company_id`, `depart_id`, `entry`, `entry_pos`, `remark`, `status`, `create_user_id`, `create_time`, `update_user_id`, `update_time`, `salary`, `is_delete`, `entry_year`) VALUES
(1, 'admin', '4297f44b13955235245b2497399d7a93', '122222', '19900214', '469688010@qq.com', '15296977170', '兰亭', '469688010', '江苏淮安', '江苏南通市涟水县', '1', 22, 8, '2016-06-17', '20', '', 2, 1, 1506302672, 0, 0, 6000, 1, '1年3月8天'),
(2, 'mingquan', 'e10adc3949ba59abbe56e057f20f883e', '44444', '19920216', '1020266554@qq.com', '15296977170', 'ssssss', '2222222222', '宁夏银川', '宁夏银川西夏区镇北堡镇', '3', 23, 8, '2017-06-02', '19', '', 2, 2, 1506318333, 0, 0, 0, 0, '3月23天'),
(10, 'test', 'e10adc3949ba59abbe56e057f20f883e', '0', '', '', '0', '', '', '', '', '', 0, 0, '0000-00-00', '', '', 1, 0, 0, 0, 0, 5000, 0, '0'),
(14, 'mood', '112233', '0', '', '', '17702581068', '', '', '', '', '', 0, 0, '0000-00-00', '', '', 1, 0, 0, 0, 0, 0, 0, '0'),
(15, 'tianmao', '4297f44b13955235245b2497399d7a93', '0', '', '', '', '', '', '', '', '', 0, 0, '0000-00-00', '', '', 1, 0, 0, 0, 0, 0, 0, '0'),
(16, 'test001', 'e10adc3949ba59abbe56e057f20f883e', '0', '', '', '', '', '', '', '', '', 0, 0, '0000-00-00', '', '', 1, 0, 0, 0, 0, 0, 0, '0');

-- --------------------------------------------------------

--
-- 表的结构 `admin_auth_group`
--

CREATE TABLE IF NOT EXISTS `admin_auth_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` text COMMENT '规则id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户组表' AUTO_INCREMENT=21 ;

--
-- 转存表中的数据 `admin_auth_group`
--

INSERT INTO `admin_auth_group` (`id`, `title`, `status`, `rules`) VALUES
(1, '超级管理员', 1, '1,2,3,4,6,7,8,14,15,16,17,18,19,21,20,143,144,149,151,152,154,153,155,156,157,158,159,160'),
(2, '一般管理员', 1, '1,2,3,4,6,7,8,14,15,16,17,18,19,21,20,143,144,149,151,152,154,153,155,156,157,159,160'),
(4, '员工', 1, '1,17,149,14,19,21,143,144,15,4,19,18,123,151');

-- --------------------------------------------------------

--
-- 表的结构 `admin_auth_group_access`
--

CREATE TABLE IF NOT EXISTS `admin_auth_group_access` (
  `uid` int(11) unsigned NOT NULL COMMENT '用户id',
  `group_id` int(11) unsigned NOT NULL COMMENT '用户组id',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户组明细表';

--
-- 转存表中的数据 `admin_auth_group_access`
--

INSERT INTO `admin_auth_group_access` (`uid`, `group_id`) VALUES
(1, 1),
(2, 2),
(10, 4),
(14, 2),
(15, 2),
(16, 1),
(90, 15),
(103, 2);

-- --------------------------------------------------------

--
-- 表的结构 `admin_auth_rule`
--

CREATE TABLE IF NOT EXISTS `admin_auth_rule` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级id',
  `name` char(80) NOT NULL DEFAULT '' COMMENT '规则唯一标识',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '规则中文名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为0禁用',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '' COMMENT '规则表达式，为空表示存在就验证，不为空表示按照条件验证',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='规则表' AUTO_INCREMENT=161 ;

--
-- 转存表中的数据 `admin_auth_rule`
--

INSERT INTO `admin_auth_rule` (`id`, `pid`, `name`, `title`, `status`, `type`, `condition`) VALUES
(16, 3, 'Admin/Rule/add_group', '添加角色', 1, 1, ''),
(17, 3, 'Admin/Rule/edit_group', '修改角色', 1, 1, ''),
(18, 3, 'Admin/Rule/delete_group', '删除角色', 1, 1, ''),
(14, 1, 'Test/index/index', '测试权限', 1, 1, ''),
(20, 4, 'Admin/User/add_user', '添加用户（管理员）', 1, 1, ''),
(7, 6, 'Admin/Rule/add', '添加权限', 1, 1, ''),
(1, 0, 'Admin/Index/index', '后台首页', 1, 1, ''),
(149, 0, 'Admin/Admin/index', '员工信息', 1, 1, ''),
(156, 155, 'Admin/Project/add', '项目增加', 1, 1, ''),
(152, 143, 'Admin/Admin/adjust', '调整薪资', 1, 1, ''),
(151, 143, 'Admin/Staff/my_salary', '个人薪资', 1, 1, ''),
(4, 6, 'Admin/User/index', '用户管理', 1, 1, ''),
(19, 10, 'Admin/Index/logout', '退出登录', 1, 1, ''),
(6, 0, 'Admin/Rule/', '权限控制', 1, 1, ''),
(3, 6, 'Admin/Rule/rule_group', '角色管理', 1, 1, ''),
(8, 6, 'Admin/Rule/edit', '修改权限', 1, 1, ''),
(9, 6, 'Admin/Rule/delete', '删除权限', 1, 1, ''),
(2, 6, 'Admin/Rule/rule_list', '权限管理', 1, 1, ''),
(15, 3, 'Admin/Rule/rule_distribution', '分配权限', 1, 1, ''),
(21, 4, 'Admin/User/edit_user', '修改用户', 1, 1, ''),
(155, 1, 'Admin/Project/index', '项目管理', 1, 1, ''),
(154, 143, 'Admin/admin/user_pay', '员工薪资', 1, 1, ''),
(153, 143, 'Admin/Admin/delete_user', '删除员工信息', 1, 1, ''),
(143, 1, 'Admin/Staff/my_center', '个人中心', 1, 1, ''),
(144, 143, 'Admin/Admin/change_msg', '修改个人资料', 1, 1, ''),
(157, 155, 'Admin/Project/edit', '项目修改', 1, 1, ''),
(158, 155, 'Admin/Project/delete', '项目删除', 1, 1, ''),
(159, 143, 'Admin/Admin/check_user', '员工审核', 1, 1, ''),
(160, 143, 'Admin/Admin/check_index', '通过审核员工信息', 1, 1, '');

-- --------------------------------------------------------

--
-- 表的结构 `admin_company`
--

CREATE TABLE IF NOT EXISTS `admin_company` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` int(10) unsigned NOT NULL COMMENT '信息名',
  `company` varchar(60) NOT NULL DEFAULT '' COMMENT '信息的内容',
  PRIMARY KEY (`id`),
  KEY `title` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='公司架构表' AUTO_INCREMENT=26 ;

--
-- 转存表中的数据 `admin_company`
--

INSERT INTO `admin_company` (`id`, `title`, `company`) VALUES
(22, 5, '上海'),
(23, 5, '徐州'),
(24, 5, '苏州'),
(25, 5, '郑州');

-- --------------------------------------------------------

--
-- 表的结构 `admin_depart`
--

CREATE TABLE IF NOT EXISTS `admin_depart` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` int(10) unsigned NOT NULL COMMENT '信息名',
  `depart` varchar(60) NOT NULL DEFAULT '' COMMENT '信息的内容',
  PRIMARY KEY (`id`),
  KEY `title` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='公司部门表' AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `admin_depart`
--

INSERT INTO `admin_depart` (`id`, `title`, `depart`) VALUES
(5, 2, '设计部'),
(6, 2, '建站部'),
(7, 2, '技术部'),
(8, 2, '营销部'),
(9, 2, '财务部'),
(10, 2, '管理层'),
(11, 2, '销售部'),
(12, 2, '市场部');

-- --------------------------------------------------------

--
-- 表的结构 `admin_infomation`
--

CREATE TABLE IF NOT EXISTS `admin_infomation` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` int(10) unsigned DEFAULT NULL COMMENT '信息名： 1学历 2部门 3入职状态4项目类型5公司架构',
  `name` varchar(60) NOT NULL DEFAULT '' COMMENT '信息的内容',
  PRIMARY KEY (`id`),
  KEY `title` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='信息字典表' AUTO_INCREMENT=26 ;

--
-- 转存表中的数据 `admin_infomation`
--

INSERT INTO `admin_infomation` (`id`, `title`, `name`) VALUES
(1, 1, '研究生'),
(2, 1, '本科'),
(3, 1, '大专'),
(4, 1, '高职');

-- --------------------------------------------------------

--
-- 表的结构 `admin_pay`
--

CREATE TABLE IF NOT EXISTS `admin_pay` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(10) unsigned DEFAULT NULL COMMENT '员工id',
  `adjust_salary` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '调整的薪资',
  `total_money` decimal(10,2) NOT NULL COMMENT '调整后的金额',
  `adjust_reason` text NOT NULL COMMENT '调整的薪资',
  `seniority` varchar(100) NOT NULL DEFAULT '' COMMENT '工龄',
  `update_user_id` int(10) unsigned DEFAULT NULL COMMENT '更新人',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `staff_id` (`admin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='员工薪资表' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `admin_pay`
--

INSERT INTO `admin_pay` (`id`, `admin_id`, `adjust_salary`, `total_money`, `adjust_reason`, `seniority`, `update_user_id`, `update_time`) VALUES
(1, 1, '1000.00', '0.00', '满一年加的工资', '1.5', 10, 1505989123),
(2, 1, '100.00', '0.00', '福利', '', 1, 1505989123),
(3, 10, '5000.00', '0.00', '加班费', '', 1, 1505989735),
(4, 1, '100.00', '0.00', '加班工资', '', 1, 1505991012),
(5, 1, '100.00', '0.00', '福利', '', 16, 1506047993);

-- --------------------------------------------------------

--
-- 表的结构 `admin_position`
--

CREATE TABLE IF NOT EXISTS `admin_position` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` int(10) unsigned NOT NULL COMMENT '信息名',
  `position` varchar(60) NOT NULL DEFAULT '' COMMENT '信息的内容',
  PRIMARY KEY (`id`),
  KEY `title` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='项目类型表' AUTO_INCREMENT=26 ;

--
-- 转存表中的数据 `admin_position`
--

INSERT INTO `admin_position` (`id`, `title`, `position`) VALUES
(18, 4, '网站建设'),
(19, 4, 'SEO'),
(20, 4, '小程序'),
(21, 4, 'APP');

-- --------------------------------------------------------

--
-- 表的结构 `admin_project`
--

CREATE TABLE IF NOT EXISTS `admin_project` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` varchar(100) NOT NULL,
  `pro` varchar(100) NOT NULL DEFAULT '' COMMENT '项目名',
  `pro_style_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '项目类型',
  `cycle` varchar(100) NOT NULL DEFAULT '' COMMENT '执行周期',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '项目状态',
  `createtime` int(10) unsigned NOT NULL COMMENT '创建时间',
  `is_delete` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否删除:1未删除2删除',
  PRIMARY KEY (`id`),
  KEY `staff_id` (`admin_id`),
  KEY `pro_style_id` (`pro_style_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='项目表' AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `admin_project`
--

INSERT INTO `admin_project` (`id`, `admin_id`, `pro`, `pro_style_id`, `cycle`, `status`, `createtime`, `is_delete`) VALUES
(3, '2,14', '中国江苏项目', 19, '20', 2, 1506158329, 1),
(4, '2,10', '中国项目', 20, '20', 2, 1506307994, 1);

-- --------------------------------------------------------

--
-- 表的结构 `admin_users`
--

CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(64) NOT NULL DEFAULT '' COMMENT '登录密码；mb_password加密',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '用户头像，相对于upload/avatar目录',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '登录邮箱',
  `email_code` varchar(60) DEFAULT NULL COMMENT '激活码',
  `phone` bigint(11) unsigned DEFAULT NULL COMMENT '手机号',
  `status` tinyint(1) NOT NULL DEFAULT '2' COMMENT '用户状态 0：禁用； 1：正常 ；2：未验证',
  `register_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `last_login_ip` varchar(16) NOT NULL DEFAULT '' COMMENT '最后登录ip',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  PRIMARY KEY (`id`),
  KEY `user_login_key` (`username`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=104 ;

--
-- 转存表中的数据 `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `avatar`, `email`, `email_code`, `phone`, `status`, `register_time`, `last_login_ip`, `last_login_time`) VALUES
(88, 'admin', '123456', '/Upload/avatar/user1.jpg', '1113249273@qq.com', '', 18712377777, 1, 1449199996, '', 0),
(89, 'admin2', '123456', '/Upload/avatar/user2.jpg', '1262135552@qq.com', '', 187123770781, 1, 1449199996, '', 0),
(90, 'wudi1', 'd41d8cd98f00b204e9800998ecf8427e', '', '1113249273@qq.com', NULL, 187123770771, 1, 1484121804, '', 0),
(92, 'test', '827ccb0eea8a706c4c34a16891f84e7b', '', '1262135552@qq.com', NULL, 18712377077, 1, 1484284579, '', 0),
(103, '方明', '12333', '', '1020222222', NULL, 125555555555, 1, 0, '', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
