/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : blogphp

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2021-04-27 13:20:06
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `be_admin`
-- ----------------------------
DROP TABLE IF EXISTS `be_admin`;
CREATE TABLE `be_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `password` varchar(64) NOT NULL,
  `status` int(3) NOT NULL DEFAULT '1',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `last_time` int(11) DEFAULT NULL,
  `count` tinyint(5) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `pic` text,
  `nickName` varchar(20) DEFAULT '0',
  `info` text COMMENT '[{"title":"asaaa","icon":"fa-github","url":"http://www.qq.com"},{"title":"asaaa","icon":"fa-qq","url":"http://www.wexin.com"}]',
  `desc` varchar(50) DEFAULT NULL,
  `del_url` varchar(255) NOT NULL,
  `forgotPass` tinyint(3) DEFAULT '0' COMMENT '1忘记密码',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=gbk ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of be_admin
-- ----------------------------
INSERT INTO `be_admin` VALUES ('1', 'admin', '84386805f4fa719c7023544210fea50c', '1', '1538743898', '1583412943', '1583412912', '2', '127.0.0.1', 'https://i.loli.net/2020/01/07/4FdBnGSqMocwrvX.gif', '蝶！', '[\r\n{\"title\":\"Blog\",\"icon\":\"fa-home\",\"url\":\"http://blog.liuhai.fun\"},\r\n{\"title\":\"GitHub\",\"icon\":\"fa-github\",\"url\":\"https://github.com/Haiwar\"},\r\n{\"title\":\"告白墙\",\"icon\":\"fa-heart\",\"url\":\"http://love.liuhai.fun\"},\r\n{\"title\":\"互联网热榜\",\"icon\":\"fa-fire\",\"url\":\"http://new.liuhai.fun\"},\r\n{\"title\":\"Element-UI简易后台管理系统\",\"icon\":\"fa-etsy\",\"url\":\"http://element.liuhai.fun\"}\r\n]', '愿你在尘世获得幸福 ，我只愿面朝大海，春暖花开。', '', '0');
INSERT INTO `be_admin` VALUES ('36', 'test', '84386805f4fa719c7023544210fea50c', '1', '1573798063', '1582472910', '1583153943', '1', '117.139.133.12', 'https://i.loli.net/2019/06/15/5d046c17409da48073.png', 'test', '', 'test', '', '0');

-- ----------------------------
-- Table structure for `be_article`
-- ----------------------------
DROP TABLE IF EXISTS `be_article`;
CREATE TABLE `be_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` mediumtext COLLATE utf8mb4_unicode_ci,
  `pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `click` int(64) DEFAULT '0' COMMENT '点赞',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT '10000',
  `cid` int(11) DEFAULT NULL,
  `rec` tinyint(3) DEFAULT '0' COMMENT '是否推荐',
  `look` int(64) DEFAULT '0' COMMENT '浏览',
  `rec_time` int(11) DEFAULT NULL COMMENT '推荐时间',
  `like_time` int(11) DEFAULT NULL,
  `is_origin` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否原创',
  `editor` tinyint(3) DEFAULT '1' COMMENT '1百度编辑器 2wangEditor编辑器',
  `del_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `editor_html_code` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'makedown语法',
  `is_del` tinyint(3) unsigned DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of be_article
-- ----------------------------

-- ----------------------------
-- Table structure for `be_auth_group`
-- ----------------------------
DROP TABLE IF EXISTS `be_auth_group`;
CREATE TABLE `be_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of be_auth_group
-- ----------------------------
INSERT INTO `be_auth_group` VALUES ('4', 'test用户', '1', '81,105,82,103,41,42,27,28,31,32,116,119,117,45,83,46,47,37,38,35,36,69,70,65,66');

-- ----------------------------
-- Table structure for `be_auth_group_access`
-- ----------------------------
DROP TABLE IF EXISTS `be_auth_group_access`;
CREATE TABLE `be_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE,
  KEY `group_id` (`group_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of be_auth_group_access
-- ----------------------------
INSERT INTO `be_auth_group_access` VALUES ('1', '4');
INSERT INTO `be_auth_group_access` VALUES ('33', '4');
INSERT INTO `be_auth_group_access` VALUES ('35', '4');
INSERT INTO `be_auth_group_access` VALUES ('36', '4');

-- ----------------------------
-- Table structure for `be_auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `be_auth_rule`;
CREATE TABLE `be_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '',
  `title` char(20) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1菜单(只是做下拉框) 2列表(显示数据) 3不显示(删除或者修改等隐藏操作)',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `condition` char(100) NOT NULL DEFAULT '',
  `pid` mediumint(9) DEFAULT '0',
  `level` tinyint(1) DEFAULT NULL,
  `sort` int(5) DEFAULT '1000',
  `style` varchar(50) DEFAULT NULL,
  `is_fun` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of be_auth_rule
-- ----------------------------
INSERT INTO `be_auth_rule` VALUES ('27', 'Article', '文章管理', '1', '1', '', '0', '0', '8000', 'fa-stack-overflow', '0');
INSERT INTO `be_auth_rule` VALUES ('28', 'article/index', '文章列表', '2', '1', '', '27', '1', '1000', '', '0');
INSERT INTO `be_auth_rule` VALUES ('29', 'article/edit', '文章修改', '2', '1', '', '27', '1', '1000', '0', '1');
INSERT INTO `be_auth_rule` VALUES ('30', 'article/delete', '文章删除', '2', '1', '', '27', '1', '1000', '', '1');
INSERT INTO `be_auth_rule` VALUES ('31', 'Cate', '栏目管理', '1', '1', '', '0', '0', '7000', 'fa-align-justify', '0');
INSERT INTO `be_auth_rule` VALUES ('32', 'cate/index', '栏目列表', '2', '1', '', '31', '1', '1000', '', '0');
INSERT INTO `be_auth_rule` VALUES ('33', 'cate/edit', '栏目修改', '2', '1', '', '31', '1', '1000', '', '1');
INSERT INTO `be_auth_rule` VALUES ('34', 'cate/delete', '栏目删除', '2', '1', '', '31', '1', '1000', '', '1');
INSERT INTO `be_auth_rule` VALUES ('35', 'Data', '数据备份/还原', '1', '1', '', '0', '0', '1000', 'fa-desktop', '0');
INSERT INTO `be_auth_rule` VALUES ('36', 'data/index', '数据库表', '2', '1', '', '35', '1', '1000', '0', '0');
INSERT INTO `be_auth_rule` VALUES ('37', 'Img', '轮播图管理', '1', '0', '', '0', '0', '1000', 'fa-caret-square-o-left', '0');
INSERT INTO `be_auth_rule` VALUES ('38', 'img/index', '轮播图列表', '2', '1', '', '37', '1', '1000', '', '0');
INSERT INTO `be_auth_rule` VALUES ('39', 'img/edit', '轮播图修改', '2', '1', '', '37', '1', '1000', '0', '1');
INSERT INTO `be_auth_rule` VALUES ('40', 'img/delete', '轮播图删除', '2', '1', '', '37', '1', '1000', '0', '1');
INSERT INTO `be_auth_rule` VALUES ('41', 'Admin', '管理员', '1', '1', '', '0', '0', '9000', 'fa-users', '0');
INSERT INTO `be_auth_rule` VALUES ('42', 'admin/index', '管理员列表', '2', '1', '', '41', '1', '1000', '0', '0');
INSERT INTO `be_auth_rule` VALUES ('43', 'admin/edit', '管理员修改', '2', '1', '', '41', '1', '1000', '0', '1');
INSERT INTO `be_auth_rule` VALUES ('44', 'admin/delete', '管理员删除', '2', '1', '', '41', '1', '1000', '0', '1');
INSERT INTO `be_auth_rule` VALUES ('45', 'Conf', '系统', '1', '1', '', '0', '0', '1000', 'fa-gear', '0');
INSERT INTO `be_auth_rule` VALUES ('46', 'conf/index', '配置项', '2', '1', '', '45', '1', '1000', '0', '0');
INSERT INTO `be_auth_rule` VALUES ('47', 'conf/lists', '配置列表（配置功能）', '2', '1', '', '45', '1', '1000', '', '0');
INSERT INTO `be_auth_rule` VALUES ('48', 'conf/edit', '配置项修改', '2', '1', '', '45', '1', '1000', '', '1');
INSERT INTO `be_auth_rule` VALUES ('49', 'conf/delete', '配置项删除', '2', '1', '', '45', '1', '1000', '0', '1');
INSERT INTO `be_auth_rule` VALUES ('52', 'data/handler', '数据表操作', '2', '1', '', '35', '1', '1000', '0', '1');
INSERT INTO `be_auth_rule` VALUES ('65', 'Comment', '评论管理', '1', '1', '', '0', '0', '1000', 'fa-comment', '0');
INSERT INTO `be_auth_rule` VALUES ('66', 'comment/index', '评论列表', '2', '1', '', '65', '1', '1000', '', '0');
INSERT INTO `be_auth_rule` VALUES ('67', 'comment/delete', '评论删除', '2', '1', '', '65', '1', '1000', '', '1');
INSERT INTO `be_auth_rule` VALUES ('68', 'comment/edit', '评论修改', '2', '1', '', '65', '1', '1000', '', '1');
INSERT INTO `be_auth_rule` VALUES ('69', 'Link', '友情链接', '1', '1', '', '0', '0', '1000', 'fa-link', '0');
INSERT INTO `be_auth_rule` VALUES ('70', 'link/index', '链接列表', '2', '1', '', '69', '1', '1000', '', '0');
INSERT INTO `be_auth_rule` VALUES ('71', 'link/delete', '链接删除', '2', '1', '', '69', '1', '1000', '', '1');
INSERT INTO `be_auth_rule` VALUES ('72', 'link/edit', '链接修改', '2', '1', '', '69', '1', '1000', '', '1');
INSERT INTO `be_auth_rule` VALUES ('73', 'link/add', '链接添加', '2', '1', '', '69', '1', '1000', '', '1');
INSERT INTO `be_auth_rule` VALUES ('74', 'img/add', '轮播图添加', '2', '1', '', '37', '1', '1000', '0', '1');
INSERT INTO `be_auth_rule` VALUES ('75', 'cate/add', '栏目添加', '2', '1', '', '31', '1', '1000', '', '1');
INSERT INTO `be_auth_rule` VALUES ('76', 'article/add', '文章添加', '2', '1', '', '27', '1', '1000', '0', '1');
INSERT INTO `be_auth_rule` VALUES ('77', 'conf/add', '配置项添加', '2', '1', '', '45', '1', '1000', '', '1');
INSERT INTO `be_auth_rule` VALUES ('78', 'admin/add', '管理员添加', '2', '1', '', '41', '1', '1000', '0', '1');
INSERT INTO `be_auth_rule` VALUES ('81', 'AuthRule', '节点列表管理', '1', '1', '', '0', '0', '10001', 'fa-list-ul', '0');
INSERT INTO `be_auth_rule` VALUES ('82', 'AuthGroup', '权限用户组', '1', '1', '', '0', '0', '10000', 'fa-sitemap', '0');
INSERT INTO `be_auth_rule` VALUES ('83', 'conf/awesome', '图标库', '2', '1', '', '45', '1', '1000', '0', '0');
INSERT INTO `be_auth_rule` VALUES ('84', 'article/addpost', '文章提交添加', '2', '1', '', '27', '1', '1000', '0', '1');
INSERT INTO `be_auth_rule` VALUES ('85', 'article/editpost', '文章提交修改', '2', '1', '', '27', '1', '1000', '0', '1');
INSERT INTO `be_auth_rule` VALUES ('86', 'admin/addpost', '管理员提交添加', '2', '1', '', '41', '1', '1000', '0', '1');
INSERT INTO `be_auth_rule` VALUES ('87', 'admin/editpost', '管理员提交修改', '2', '1', '', '41', '1', '1000', '', '1');
INSERT INTO `be_auth_rule` VALUES ('88', 'cate/addpost', '栏目提交添加', '2', '1', '', '31', '1', '1000', '', '1');
INSERT INTO `be_auth_rule` VALUES ('89', 'cate/editpost', '栏目提交修改', '2', '1', '', '31', '1', '1000', '', '1');
INSERT INTO `be_auth_rule` VALUES ('90', 'link/addpost', '链接提交添加', '2', '1', '', '69', '1', '1000', '', '1');
INSERT INTO `be_auth_rule` VALUES ('91', 'link/editpost', '链接提交修改', '2', '1', '', '69', '1', '1000', '', '1');
INSERT INTO `be_auth_rule` VALUES ('92', 'auth_rule/addpost', '节点提交添加', '2', '1', '', '81', '1', '1000', '0', '1');
INSERT INTO `be_auth_rule` VALUES ('93', 'auth_rule/editpost', '节点提交修改', '2', '1', '', '81', '1', '1000', '0', '1');
INSERT INTO `be_auth_rule` VALUES ('94', 'auth_group/addpost', '用户组提交添加', '2', '1', '', '82', '1', '1000', '', '1');
INSERT INTO `be_auth_rule` VALUES ('95', 'auth_group/editpost', '用户组提交修改', '2', '1', '', '82', '1', '1000', '', '1');
INSERT INTO `be_auth_rule` VALUES ('96', 'img/addpost', '轮播图提交添加', '2', '1', '', '37', '1', '1000', '', '1');
INSERT INTO `be_auth_rule` VALUES ('97', 'img/editpost', '轮播图提交修改', '2', '1', '', '37', '1', '1000', '', '1');
INSERT INTO `be_auth_rule` VALUES ('98', 'conf/editpost', '配置项提交修改', '2', '1', '', '45', '1', '1000', '', '1');
INSERT INTO `be_auth_rule` VALUES ('99', 'conf/addpost', '配置项提交添加', '2', '1', '', '45', '1', '1000', '', '1');
INSERT INTO `be_auth_rule` VALUES ('100', 'comment/editpost', '评论提交修改', '2', '1', '', '65', '1', '1000', '', '1');
INSERT INTO `be_auth_rule` VALUES ('101', 'auth_group/edit', '权限用户组修改', '2', '1', '', '82', '1', '1000', '0', '1');
INSERT INTO `be_auth_rule` VALUES ('102', 'auth_group/add', '权限用户组添加', '2', '1', '', '82', '1', '1000', '0', '1');
INSERT INTO `be_auth_rule` VALUES ('103', 'auth_group/index', '权限用户组列表', '2', '1', '', '82', '1', '1000', '0', '0');
INSERT INTO `be_auth_rule` VALUES ('105', 'auth_rule/index', '节点列表', '2', '1', '', '81', '1', '1000', '0', '0');
INSERT INTO `be_auth_rule` VALUES ('107', 'auth_rule/delete', '节点列表删除', '2', '1', '', '81', '1', '1000', '0', '1');
INSERT INTO `be_auth_rule` VALUES ('108', 'auth_rule/add', '节点列表添加', '2', '1', '', '81', '1', '1000', '0', '1');
INSERT INTO `be_auth_rule` VALUES ('109', 'auth_group/delete', '权限用户组删除', '2', '1', '', '82', '1', '1000', '', '1');
INSERT INTO `be_auth_rule` VALUES ('112', 'auth_rule/status', '节点的禁止与开启', '2', '1', '', '81', '1', '1000', '0', '1');
INSERT INTO `be_auth_rule` VALUES ('113', 'auth_rule/edit', '节点列表修改', '2', '1', '', '81', '1', '1000', '0', '1');
INSERT INTO `be_auth_rule` VALUES ('115', 'conf/listspost', '配置列表提交修改（配置功能）', '2', '1', '', '45', '1', '1000', '', '1');
INSERT INTO `be_auth_rule` VALUES ('116', 'Log', '日志管理', '1', '1', '', '0', '0', '1000', 'fa-clipboard', '0');
INSERT INTO `be_auth_rule` VALUES ('117', 'log/login', '登录日志', '2', '1', '', '116', '1', '1000', '', '0');
INSERT INTO `be_auth_rule` VALUES ('119', 'log/operate', '操作日志', '2', '1', '', '116', '1', '1000', '', '0');
INSERT INTO `be_auth_rule` VALUES ('120', 'Timeline', '时间轴管理', '1', '1', '', '0', '0', '1000', 'fa-clock-o', '0');
INSERT INTO `be_auth_rule` VALUES ('121', 'timeline/index', '时间轴列表', '2', '1', '', '120', '1', '1000', '', '0');
INSERT INTO `be_auth_rule` VALUES ('122', 'data/importlist', '导出SQL列表', '2', '1', '', '35', '1', '1000', '', '0');

-- ----------------------------
-- Table structure for `be_cate`
-- ----------------------------
DROP TABLE IF EXISTS `be_cate`;
CREATE TABLE `be_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catename` varchar(64) DEFAULT NULL,
  `url` varchar(15) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `desc` varchar(64) DEFAULT NULL,
  `type` tinyint(1) DEFAULT '0' COMMENT '1. 文章列表 2. 单页',
  `sort` int(11) DEFAULT '10000',
  `create_time` int(11) DEFAULT NULL,
  `content` text,
  `pid` int(11) DEFAULT NULL COMMENT '上级id',
  `edit_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=gbk ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of be_cate
-- ----------------------------

-- ----------------------------
-- Table structure for `be_comment`
-- ----------------------------
DROP TABLE IF EXISTS `be_comment`;
CREATE TABLE `be_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT '0' COMMENT 'oath用户id',
  `user_name` varchar(64) DEFAULT NULL,
  `user_email` varchar(64) DEFAULT NULL,
  `user_avatar` varchar(255) DEFAULT NULL,
  `user_comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `create_time` int(11) DEFAULT NULL,
  `aid` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `status` tinyint(3) DEFAULT '1' COMMENT '0禁止 1启用',
  `ip` varchar(64) DEFAULT NULL,
  `path` varchar(25) DEFAULT NULL,
  `send_email` bigint(5) DEFAULT '0' COMMENT '1发送,0不发送',
  `link` varchar(30) DEFAULT NULL,
  `rule` tinyint(3) DEFAULT '0' COMMENT '0游客，1邻居，2管理员',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=gbk ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of be_comment
-- ----------------------------

-- ----------------------------
-- Table structure for `be_conf`
-- ----------------------------
DROP TABLE IF EXISTS `be_conf`;
CREATE TABLE `be_conf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cn_name` varchar(64) DEFAULT NULL,
  `en_name` varchar(64) DEFAULT NULL,
  `type` tinyint(3) DEFAULT '1' COMMENT '配置类型:1:单行文本框、2:文本域、3:单选按钮、4:复选按钮、5:下拉菜单、6:图片、7:视频',
  `value` text COMMENT '配置值',
  `values` varchar(255) DEFAULT NULL COMMENT '配置可选值',
  `sort` int(11) DEFAULT '10000',
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  `status` tinyint(3) DEFAULT '1' COMMENT '中英文转换',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of be_conf
-- ----------------------------
INSERT INTO `be_conf` VALUES ('1', '网站名称', 'seo_name', '1', 'Sonder', '', '8', '1538814376', '1539012946', '1');
INSERT INTO `be_conf` VALUES ('2', '网站关键字', 'keywords', '1', '技术博客,PHP,JavaScript,Vue', '', '2', '1538814421', '1538831877', '1');
INSERT INTO `be_conf` VALUES ('3', '网站描述', 'desc', '2', '刘海的Vue博客,Musclewiki健身百科站主,Bilibiili贫穷健身Up主。该网站通过Nuxtjs搭建而来,分享学习、工作中一些技术文章,记录常用踩坑代码。码云:liuhaier,GitHub:Haiwar', '', '1', '1538814507', null, '1');
INSERT INTO `be_conf` VALUES ('4', '是否关闭网站', 'close', '3', '否', '是,否', '3', '1538814572', '1538840202', '1');
INSERT INTO `be_conf` VALUES ('6', '导航栏是否固定', 'fixed', '4', '是', '是', '5', '1538824206', '1544842490', '1');
INSERT INTO `be_conf` VALUES ('8', '网站申明', 'copyright', '1', '2018-2020', '', '6', '1538831582', '1539506514', '1');
INSERT INTO `be_conf` VALUES ('9', '备案号', 'banquan', '1', '蜀ICP备1111190号', '', '9', '1539506562', '1539742949', '1');
INSERT INTO `be_conf` VALUES ('10', '个性签名', 'qianming', '1', '乘风波浪会有时，直挂云帆破沧海', '', '10', '1539506909', null, '1');
INSERT INTO `be_conf` VALUES ('14', '去掉轮播图部分', 'del_lunbo', '3', '关闭', '开启,关闭', '14', '1565854293', null, '1');
INSERT INTO `be_conf` VALUES ('15', '文章列表显示数目', 'artlsit_number', '1', '3', '用于api', '15', '1569675459', null, '1');
INSERT INTO `be_conf` VALUES ('19', '是否开启老前台', 'old_index', '3', '否', '是,否', '10000', '1583034428', '1583036294', '1');
INSERT INTO `be_conf` VALUES ('20', '文章密码', 'article_pass', '1', '123123', '', '10000', '1598105422', null, '1');

-- ----------------------------
-- Table structure for `be_img`
-- ----------------------------
DROP TABLE IF EXISTS `be_img`;
CREATE TABLE `be_img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pic` text,
  `desc` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `sort` int(11) DEFAULT '10000',
  `status` tinyint(3) DEFAULT '0' COMMENT '发布状态',
  `item` tinyint(1) DEFAULT '0' COMMENT '第一展示',
  `rec_index` tinyint(3) DEFAULT NULL COMMENT '广告位 1首页,2右侧',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=gbk ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of be_img
-- ----------------------------

-- ----------------------------
-- Table structure for `be_link`
-- ----------------------------
DROP TABLE IF EXISTS `be_link`;
CREATE TABLE `be_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `status` tinyint(3) DEFAULT '1',
  `name` varchar(64) DEFAULT NULL,
  `sort` int(11) DEFAULT '10000',
  `pic` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=gbk ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of be_link
-- ----------------------------

-- ----------------------------
-- Table structure for `be_login_log`
-- ----------------------------
DROP TABLE IF EXISTS `be_login_log`;
CREATE TABLE `be_login_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '日志id',
  `login_user` varchar(55) NOT NULL COMMENT '登录用户',
  `login_ip` varchar(15) NOT NULL COMMENT '登录ip',
  `login_area` varchar(55) DEFAULT NULL COMMENT '登录地区',
  `login_user_agent` varchar(155) DEFAULT NULL COMMENT '登录设备头',
  `login_time` datetime DEFAULT NULL COMMENT '登录时间',
  `login_status` tinyint(1) DEFAULT '1' COMMENT '登录状态 1 成功 2 失败',
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of be_login_log
-- ----------------------------

-- ----------------------------
-- Table structure for `be_operate_log`
-- ----------------------------
DROP TABLE IF EXISTS `be_operate_log`;
CREATE TABLE `be_operate_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '操作日志id',
  `operator` varchar(55) NOT NULL COMMENT '操作用户',
  `operator_ip` varchar(15) NOT NULL COMMENT '操作者ip',
  `operate_method` varchar(100) NOT NULL COMMENT '操作方法',
  `operate_desc` varchar(155) NOT NULL COMMENT '操作简述',
  `operate_time` datetime NOT NULL COMMENT '操作时间',
  PRIMARY KEY (`log_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of be_operate_log
-- ----------------------------

-- ----------------------------
-- Table structure for `be_reply`
-- ----------------------------
DROP TABLE IF EXISTS `be_reply`;
CREATE TABLE `be_reply` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT '0' COMMENT 'oath用户id',
  `aid` int(11) DEFAULT NULL COMMENT '文章id',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `mid` int(11) DEFAULT NULL COMMENT '回复id',
  `create_time` int(11) DEFAULT NULL,
  `reply_name` varchar(20) DEFAULT NULL COMMENT '回复人姓名',
  `uName` varchar(20) DEFAULT NULL COMMENT '被回复人姓名',
  `ip` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=gbk ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of be_reply
-- ----------------------------

-- ----------------------------
-- Table structure for `be_timeline`
-- ----------------------------
DROP TABLE IF EXISTS `be_timeline`;
CREATE TABLE `be_timeline` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `create_time` int(11) NOT NULL,
  `url` varchar(100) DEFAULT NULL,
  `cid` int(1) unsigned NOT NULL DEFAULT '60' COMMENT '固定时间轴栏目ID',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of be_timeline
-- ----------------------------

-- ----------------------------
-- Table structure for `count_test_user`
-- ----------------------------
DROP TABLE IF EXISTS `count_test_user`;
CREATE TABLE `count_test_user` (
  `id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `login_time` int(11) DEFAULT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of count_test_user
-- ----------------------------
