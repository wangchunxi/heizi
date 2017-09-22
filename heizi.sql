/*
Navicat MySQL Data Transfer

Source Server         : 192.168.56.130
Source Server Version : 50718
Source Host           : 192.168.56.130:3306
Source Database       : heizi

Target Server Type    : MYSQL
Target Server Version : 50718
File Encoding         : 65001

Date: 2017-09-22 17:53:01
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
  `login_ip` varchar(50) DEFAULT NULL COMMENT '登录ip',
  `login_time` int(11) DEFAULT NULL COMMENT '登录时间',
  `last_login_ip` varchar(50) DEFAULT NULL,
  `last_login_time` int(11) DEFAULT NULL COMMENT '上一次登录时间',
  `add_time` int(11) NOT NULL COMMENT '注册时间',
  `reg_ip` varchar(50) NOT NULL COMMENT '注册ip',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `update_id` int(11) DEFAULT NULL COMMENT '修改人',
  `add_id` int(11) DEFAULT NULL COMMENT '添加人',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>正常，-1=>删除，0=>禁用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='后台用户表';

-- ----------------------------
-- Records of h_admin
-- ----------------------------
INSERT INTO `h_admin` VALUES ('1', 'admin', 'b7ca6c19414db6298480c6e7d23e6ed2', '0', '1,4,5,8,9,10', '小白', '18129911829', '192.168.56.1', '1506063803', '192.168.56.1', '1505905273', '1500037150', '192.168.56.1', null, null, '1', '1');
INSERT INTO `h_admin` VALUES ('2', 'guojingxian@qq.com', '', '0', null, '锅1+1', '18688561053', null, null, null, null, '1501376133', '192.168.56.1', '1502536709', null, '1', '0');

-- ----------------------------
-- Table structure for h_admin_attachment
-- ----------------------------
DROP TABLE IF EXISTS `h_admin_attachment`;
CREATE TABLE `h_admin_attachment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `add_uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '文件名',
  `module` varchar(32) NOT NULL DEFAULT '' COMMENT '模块名，由哪个模块上传的',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '文件路径',
  `thumb` varchar(255) DEFAULT '' COMMENT '缩略图路径',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '文件链接',
  `mime` varchar(64) NOT NULL DEFAULT '' COMMENT '文件mime类型',
  `ext` char(4) NOT NULL DEFAULT '' COMMENT '文件类型',
  `size` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `md5` char(32) NOT NULL DEFAULT '' COMMENT '文件md5',
  `sha1` char(40) NOT NULL DEFAULT '' COMMENT 'sha1 散列值',
  `driver` varchar(16) NOT NULL DEFAULT 'local' COMMENT '上传驱动',
  `download` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '下载次数',
  `add_time` int(11) unsigned DEFAULT '0' COMMENT '上传时间',
  `update_time` int(11) unsigned DEFAULT '0' COMMENT '更新时间',
  `sort` int(11) NOT NULL DEFAULT '100' COMMENT '排序',
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '状态',
  `update_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='附件表';

-- ----------------------------
-- Records of h_admin_attachment
-- ----------------------------

-- ----------------------------
-- Table structure for h_group
-- ----------------------------
DROP TABLE IF EXISTS `h_group`;
CREATE TABLE `h_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) NOT NULL COMMENT '分组名称',
  `group_rule` text COMMENT '分组权限',
  `add_time` int(11) DEFAULT NULL,
  `add_id` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `update_id` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='后台分组';

-- ----------------------------
-- Records of h_group
-- ----------------------------
INSERT INTO `h_group` VALUES ('1', '管理员', null, '1502581544', '1', null, null, '1');

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
  `action_ip` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of h_log
-- ----------------------------
INSERT INTO `h_log` VALUES ('1', '1', 'admin', '1501314500', 'admin/share/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('2', '1', 'admin', '1501316268', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('3', '1', 'admin', '1501325815', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('4', '1', 'admin', '1501328464', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('5', '1', 'admin', '1501346192', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('6', '1', 'admin', '1501363289', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('7', '1', 'admin', '1501810397', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('8', '1', 'admin', '1501813813', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('9', '1', 'admin', '1501847095', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('10', '1', 'admin', '1501900152', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('11', '1', 'admin', '1501908806', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('12', '1', 'admin', '1501939283', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('13', '1', 'admin', '1501970313', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('14', '1', 'admin', '1502382124', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('15', '1', 'admin', '1502397120', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('16', '1', 'admin', '1502478246', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('17', '1', 'admin', '1502491958', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('18', '1', 'admin', '1502506829', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('19', '1', 'admin', '1502530364', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('20', '1', 'admin', '1502559225', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('21', '1', 'admin', '1502589384', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('22', '1', 'admin', '1502607570', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('23', '1', 'admin', '1502621000', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('24', '1', 'admin', '1502638860', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('25', '1', 'admin', '1502653946', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('26', '1', 'admin', '1502654271', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('27', '1', 'admin', '1502724742', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('28', '1', 'admin', '1502742719', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('29', '1', 'admin', '1502782776', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('30', '1', 'admin', '1502813179', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('31', '1', 'admin', '1502813826', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('32', '1', 'admin', '1502847642', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('33', '1', 'admin', '1502848845', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('34', '1', 'admin', '1502865484', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('35', '1', 'admin', '1502865952', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('36', '1', 'admin', '1502873550', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('37', '1', 'admin', '1502889387', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('38', '1', 'admin', '1505730275', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('39', '1', 'admin', '1505873407', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('40', '1', 'admin', '1505905273', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');
INSERT INTO `h_log` VALUES ('41', '1', 'admin', '1506063803', 'share/admin/login', 'id为1用户admin登录成功', '登录', null, 'h_admin', '192.168.56.1');

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
  `update_id` int(11) DEFAULT NULL COMMENT '修改人id',
  `update_time` int(11) DEFAULT NULL COMMENT '修改时间',
  `group` varchar(255) DEFAULT NULL,
  `nav_seat` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=>不为按钮,1=>头部，2=>列表，3=>全部',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>正常，0=》禁用，-1=》软删除',
  `css` varchar(255) DEFAULT NULL,
  `view` int(11) DEFAULT '0' COMMENT '调用模板',
  `patn` varchar(255) NOT NULL DEFAULT '' COMMENT '菜单结构',
  `class` varchar(255) DEFAULT NULL COMMENT '链接请求的打开方式',
  `url_type` varchar(255) DEFAULT NULL COMMENT '链接类型',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COMMENT='后台菜单权限';

-- ----------------------------
-- Records of h_menu
-- ----------------------------
INSERT INTO `h_menu` VALUES ('1', '主页', '0', '1', 'admin', 'Index', 'index', 'admin/Index/index', '', '1499972354', '0', null, null, '主页', '0', '1', '', '0', '0-', null, null);
INSERT INTO `h_menu` VALUES ('4', '系统管理', '0', '1', '', '', '', '', '', '1499977381', '0', null, null, '系统管理', '0', '1', '&#xe630;', '0', '0-', null, null);
INSERT INTO `h_menu` VALUES ('5', '菜单列表', '4', '2', 'admin', 'nav', 'index', 'admin/nav/index', '', '1499978292', '0', null, null, '系统管理', '0', '1', '&#xe61c;', '0', '0-4-', null, null);
INSERT INTO `h_menu` VALUES ('8', '模板列表', '4', '2', 'admin', 'view', 'index', 'admin/view/index', '', '1499979376', '0', null, null, '系统管理', '0', '1', '&#xe61c;', '0', '0-4-', null, null);
INSERT INTO `h_menu` VALUES ('9', '用户管理', '0', '1', '', '', '', '', '', '1500025425', '0', null, null, '用户管理', '0', '1', '&#xe612;', '0', '0-', null, null);
INSERT INTO `h_menu` VALUES ('10', '用户列表', '9', '2', 'admin', 'user', 'index', 'admin/user/index', '', '1500025672', '0', null, null, '用户管理', '0', '1', '&#xe613;', '2', '0-9-', null, null);
INSERT INTO `h_menu` VALUES ('11', 'test', '4', '2', 'admin', 'view', 'newsList', 'admin/view/newsList', '', '1501332552', '0', null, null, '系统管理', '0', '1', '&#xe61c;', '0', '0-4-', null, null);
INSERT INTO `h_menu` VALUES ('12', '用户组列表', '9', '2', 'Admin', 'Group', 'index', 'Admin/Group/index', '', '1502543559', '0', null, null, '用户组列表', '0', '1', '&#xe61c;', '0', '0-9-', null, null);
INSERT INTO `h_menu` VALUES ('13', '添加', '12', '3', 'Admin', 'Group', 'add', 'Admin/Group/add', '', '1502547581', '0', null, null, '添加', '1', '1', '', '0', '0-9-12-', 'Pop', null);
INSERT INTO `h_menu` VALUES ('14', '修改', '12', '3', 'admin', 'Group', 'info', 'admin/Group/info', '', '1502573330', '0', null, null, '修改', '2', '1', '', '0', '0-9-12-', null, null);
INSERT INTO `h_menu` VALUES ('15', '添加', '10', '3', 'admin', 'User', 'add', 'admin/User/add', '', '1502577231', '0', null, null, '添加', '1', '1', '', '0', '0-9-10-', 'Pop', null);
INSERT INTO `h_menu` VALUES ('16', '附件管理', '0', '1', '', '', '', '', '', '1502637106', '1', null, null, '附件管理', '0', '1', '&#xe61d;', '0', '0-', null, null);
INSERT INTO `h_menu` VALUES ('17', '水印图管理', '16', '2', 'admin', 'Attachment', 'Watermark_List', 'admin/Attachment/Watermark_List', '', '1502637360', '1', null, null, '水印图管理', '0', '1', '&#xe60d;', '0', '0-16-', null, null);
INSERT INTO `h_menu` VALUES ('18', '添加', '17', '3', 'admin', 'Attachment', 'Add_watermark', 'admin/Attachment/Add_watermark', '', '1502640393', '1', null, null, '', '1', '1', '', '0', '0-16-17-', 'Pop', null);
INSERT INTO `h_menu` VALUES ('19', '添加', '5', '3', 'admin', 'nav', 'add', 'admin/nav/add', '1', '1502640393', '1', null, null, '添加', '1', '1', '&#xe60d;', '0', '0-4-5-', 'Pop', null);
INSERT INTO `h_menu` VALUES ('23', '货物编辑', '21', '3', 'admin', 'Purchase', 'info', 'admin/Purchase/info', '', '1502880483', '1', null, null, '', '2', '1', '', '0', '0-20-21-', 'Pop', 'Button');
INSERT INTO `h_menu` VALUES ('20', '进销存管理', '0', '1', '', '', '', '', '', '1502850348', '1', null, null, '', '0', '1', '&#xe6b2;', '0', '0-', null, null);
INSERT INTO `h_menu` VALUES ('21', '进销存列表', '20', '2', 'admin', 'purchase', 'index', 'admin/purchase/index', '', '1502850887', '1', null, null, '', '0', '1', '&#xe62a;', '0', '0-20-', null, null);
INSERT INTO `h_menu` VALUES ('22', '添加货物', '21', '3', 'admin', 'Purchase', 'add', 'admin/Purchase/add', '', '1502855129', '1', null, null, '', '1', '1', '', '0', '0-20-21-', 'Pop', 'Button');
INSERT INTO `h_menu` VALUES ('24', 'ajax数据列表', '21', '3', 'admin', 'Purchase', 'getlist', 'admin/Purchase/getlist', '', '1502886569', '1', null, null, '', '0', '1', '', '0', '0-20-21-', '0', 'ajax_list');
INSERT INTO `h_menu` VALUES ('25', '批量添加货物', '21', '3', 'admin', 'Purchase', 'Excel_Import_Goods', 'admin/Purchase/Excel_Import_Goods', '', '1505738360', '1', null, null, '', '1', '1', '', '0', '0-20-21-', 'Pop', 'Button');
INSERT INTO `h_menu` VALUES ('26', '选择货物', '21', '3', 'admin', 'Purchase', 'choice_goods', 'admin/Purchase/choice_goods', '', '1505884537', '1', null, null, '', '1', '1', '', '0', '0-20-21-', 'Pop', 'Button');

-- ----------------------------
-- Table structure for h_purchase
-- ----------------------------
DROP TABLE IF EXISTS `h_purchase`;
CREATE TABLE `h_purchase` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `goods_name` varchar(255) NOT NULL COMMENT '货物名称',
  `goods_specification` varchar(255) NOT NULL COMMENT '货物规格',
  `goods_version` varchar(255) NOT NULL,
  `shape_code` varchar(255) DEFAULT NULL COMMENT '条形码',
  `goods_pice` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '货物单价',
  `goods_num` int(11) NOT NULL DEFAULT '0' COMMENT '货物数量',
  `update_time` int(11) DEFAULT NULL,
  `add_time` int(11) NOT NULL,
  `add_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '-1=>删除，1正常',
  `data_node` int(11) NOT NULL DEFAULT '0' COMMENT '列表数据使用哪个时间段的',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of h_purchase
-- ----------------------------
INSERT INTO `h_purchase` VALUES ('1', '小郭牌米线', 'h-a', 'h-a', '', '0.00', '0', null, '1502873967', '1', '1', '0');
INSERT INTO `h_purchase` VALUES ('2', '测试名称', '测试规格', '测试型号', '123325656', '0.00', '0', null, '1505760232', '1', '1', '0');

-- ----------------------------
-- Table structure for h_purchase_operation
-- ----------------------------
DROP TABLE IF EXISTS `h_purchase_operation`;
CREATE TABLE `h_purchase_operation` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `purchase_id` int(11) NOT NULL,
  `goods_num` int(11) NOT NULL DEFAULT '0' COMMENT '操作数量',
  `operation_time` int(11) NOT NULL COMMENT '操作时间',
  `operation_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0=>进仓，1=》出仓',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>正常,-1=>删除',
  `add_id` int(11) NOT NULL COMMENT '操作人',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of h_purchase_operation
-- ----------------------------

-- ----------------------------
-- Table structure for h_view
-- ----------------------------
DROP TABLE IF EXISTS `h_view`;
CREATE TABLE `h_view` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `view_name` varchar(255) NOT NULL,
  `add_id` int(11) NOT NULL,
  `add_time` int(11) NOT NULL,
  `update_id` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of h_view
-- ----------------------------
INSERT INTO `h_view` VALUES ('1', 'a:11:{i:0;a:1:{i:11;s:4:\"text\";}i:1;a:1:{i:10;s:6:\"select\";}i:2;a:1:{i:9;s:4:\"text\";}i:3;a:1:{i:8;s:4:\"text\";}i:4;a:1:{i:7;s:4:\"text\";}i:5;a:1:{i:6;s:4:\"text\";}i:6;a:1:{i:5;s:4:\"text\";}i:7;a:1:{i:4;s:4:\"text\";}i:8;a:1:{i:3;s:4:\"text\";}i:9;a:1:{i:2;s:6:\"select\";}i:10;a:1:{i:1;s:8:\"textarea\";}}', '导航详情添加or详情', '1', '1499915804', null, null, '1');
INSERT INTO `h_view` VALUES ('2', 'a:5:{i:0;a:1:{i:10;s:4:\"text\";}i:1;a:1:{i:9;s:8:\"password\";}i:2;a:1:{i:8;s:6:\"select\";}i:3;a:1:{i:7;s:4:\"text\";}i:4;a:1:{i:6;s:4:\"text\";}}', '用户添加', '1', '1500025241', null, null, '1');
