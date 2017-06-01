/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 100108
Source Host           : localhost:3306
Source Database       : heizi

Target Server Type    : MYSQL
Target Server Version : 100108
File Encoding         : 65001

Date: 2017-06-01 17:57:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for h_admin
-- ----------------------------
DROP TABLE IF EXISTS `h_admin`;
CREATE TABLE `h_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '递增主键',
  `username` varchar(255) NOT NULL COMMENT '用户名',
  `password` varchar(32) NOT NULL COMMENT '密码',
  `group` tinyint(3) NOT NULL COMMENT '所在分组',
  `rule` text COMMENT '权限',
  `nickname` varchar(255) DEFAULT NULL COMMENT '昵称',
  `mobile` varchar(20) DEFAULT NULL COMMENT '手机',
  `logn_ip` varchar(50) DEFAULT NULL COMMENT '登录ip',
  `logn_time` int(11) DEFAULT NULL COMMENT '登录时间',
  `logn_last_time` int(11) DEFAULT NULL COMMENT '上一次登录时间',
  `add_time` int(11) NOT NULL COMMENT '注册时间',
  `reg_ip` varchar(50) NOT NULL COMMENT '注册ip',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `update_id` int(11) NOT NULL COMMENT '修改人',
  `add_id` int(11) NOT NULL COMMENT '添加人',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='后台用户表';

-- ----------------------------
-- Table structure for h_group
-- ----------------------------
DROP TABLE IF EXISTS `h_group`;
CREATE TABLE `h_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) NOT NULL COMMENT '分组名称',
  `group_rule` text COMMENT '分组权限',
  `add_time` int(11) NOT NULL,
  `add_id` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `update_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='后台分组';

-- ----------------------------
-- Table structure for h_log
-- ----------------------------
DROP TABLE IF EXISTS `h_log`;
CREATE TABLE `h_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '用户ID',
  `uid_name` varchar(50) DEFAULT NULL COMMENT '用户名称',
  `add_time` int(11) NOT NULL COMMENT '添加时间',
  `url` varchar(255) NOT NULL COMMENT '访问链接',
  `content` varchar(255) NOT NULL COMMENT '备注说明',
  `type` varchar(10) NOT NULL COMMENT '操作类型',
  `action_id` int(10) DEFAULT NULL COMMENT '操作结果',
  `surface` varchar(255) DEFAULT NULL COMMENT '操作的表名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for h_menu
-- ----------------------------
DROP TABLE IF EXISTS `h_menu`;
CREATE TABLE `h_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) NOT NULL COMMENT '菜单名称',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父级id',
  `level` tinyint(3) NOT NULL DEFAULT '1' COMMENT '菜单等级',
  `m` varchar(50) NOT NULL COMMENT 'model层',
  `c` varchar(50) NOT NULL COMMENT '控制器层',
  `a` varchar(50) NOT NULL COMMENT '方法层',
  `url` varchar(255) NOT NULL COMMENT '真实链接',
  `content` varchar(255) NOT NULL COMMENT '备注',
  `add_time` int(11) NOT NULL COMMENT '添加时间',
  `add_id` int(11) NOT NULL COMMENT '添加人id',
  `update_id` int(11) NOT NULL COMMENT '修改人id',
  `update_time` int(11) NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='后台菜单权限';
