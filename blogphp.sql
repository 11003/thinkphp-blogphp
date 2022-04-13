/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : wsgc

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2022-04-13 17:33:28
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for be_admin
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of be_admin
-- ----------------------------
INSERT INTO `be_admin` VALUES ('1', 'admin', '0eface8427e13f129352203058dc85c2', '1', '1538743898', '1649842123', '1649841581', '3', '110.184.160.160', 'http://index.musclewiki.cn/upload/20220328/c7bc95e9f90a993d45b29c2d47b61704.png', 'Sonder', '[\r\n{\"title\":\"我的博客\",\"icon\":\"https://s2.loli.net/2022/03/09/YaTiXg7bUtj2Fx6.png\",\"url\":\"http://blog.musclewiki.cn/\"},\r\n{\"title\":\"后台\",\"icon\":\"https://s2.loli.net/2022/03/09/IMdZHoN7QGPiUcv.png\",\"url\":\"/login\"},\r\n{\"title\":\"GitHub\",\"icon\":\"https://s2.loli.net/2022/03/09/JGYUjSId9Va8MOF.png\",\"url\":\"https://github.com/Haiwar\"},\r\n{\"title\":\"我的简历\",\"icon\":\"https://s2.loli.net/2022/03/09/s5nAWuZ1UKioCMg.png\",\"url\":\"http://home.liuhai.work/web-liuhai-3year.pdf\"},\r\n{\"title\":\"告白墙\",\"icon\":\"https://s2.loli.net/2022/03/09/NCJrnXM54pQVWSL.png\",\"url\":\"http://love.musclewiki.cn/\"},\r\n{\"title\":\"健身百科\",\"icon\":\"https://musclewiki.cn/static/index/images/favicon.ico\",\"url\":\"https://musclewiki.cn/\"}\r\n]', '愿你在尘世获得幸福 ，我只愿面朝大海，春暖花开。', '', '0');
INSERT INTO `be_admin` VALUES ('36', 'test', '0eface8427e13f129352203058dc85c2', '1', '1573798063', '1646368682', '1649519598', '1', '36.142.132.249', 'https://i.loli.net/2019/06/15/5d046c17409da48073.png', 'test', '', 'test2222', '', '0');

-- ----------------------------
-- Table structure for be_article
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
  `is_md` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否加密',
  PRIMARY KEY (`id`),
  FULLTEXT KEY `search_content` (`content`),
  FULLTEXT KEY `search_title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=303 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of be_article
-- ----------------------------
INSERT INTO `be_article` VALUES ('302', 'vue.js中封装全局filter ', '', '', '', '<p><strong>创建filters文件夹，里面创建filters.js文件，用来定义全局filter</strong><br><img src=\"https://s2.loli.net/2022/03/29/EcoJv4galGCky8s.png\" alt=\"image.png\">\r\n<p><strong>filters.js</strong></p>\r\n<pre><code>let filterOne = (value) =&gt; {\r\n  return value * 10\r\n}\r\nlet filterTwo = (value, pm) =&gt; {\r\n  return value * pm\r\n}\r\nexport default {\r\n  filterOne,\r\n  filterTwo\r\n}\r\n</code></pre><p><strong>main.js</strong></p>\r\n<pre><code>import filters from \'./filters/filters.js\'\r\nfor (let value in filters) {\r\n  // value是filter名称（字符串）\r\n  // filters[value] 对象里面的某个元素，就是filters中定义的方法\r\n  Vue.filter(value, filters[value])\r\n}\r\n</code></pre><p><strong>这样就全局定义了所有的filter，就可以在界面中使用了。</strong></p>\r\n<pre><code>年龄：{{ age | filterOne | filterTwo(0.5) }}\r\n</code></pre>', '0', '1648546070', '1648546070', '10000', '51', '0', '54', null, null, '0', '1', '', '**创建filters文件夹，里面创建filters.js文件，用来定义全局filter**  \r\n![image.png](https://s2.loli.net/2022/03/29/EcoJv4galGCky8s.png)\r\n\r\n**filters.js**\r\n\r\n```\r\nlet filterOne = (value) => {\r\n  return value * 10\r\n}\r\nlet filterTwo = (value, pm) => {\r\n  return value * pm\r\n}\r\nexport default {\r\n  filterOne,\r\n  filterTwo\r\n}\r\n\r\n```\r\n\r\n**main.js**\r\n\r\n```\r\nimport filters from \'./filters/filters.js\'\r\nfor (let value in filters) {\r\n  // value是filter名称（字符串）\r\n  // filters[value] 对象里面的某个元素，就是filters中定义的方法\r\n  Vue.filter(value, filters[value])\r\n}\r\n```\r\n\r\n**这样就全局定义了所有的filter，就可以在界面中使用了。**\r\n\r\n```\r\n年龄：{{ age | filterOne | filterTwo(0.5) }}\r\n```\r\n', '0', '0');

-- ----------------------------
-- Table structure for be_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `be_auth_group`;
CREATE TABLE `be_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of be_auth_group
-- ----------------------------
INSERT INTO `be_auth_group` VALUES ('4', 'test用户', '1', '81,105,113,108,82,102,101,103,41,43,42,78,27,28,76,31,33,32,75,120,128,125,121,37,38,45,123,46,77,48,35,36,69,73,72,70,65,68,66');

-- ----------------------------
-- Table structure for be_auth_group_access
-- ----------------------------
DROP TABLE IF EXISTS `be_auth_group_access`;
CREATE TABLE `be_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE,
  KEY `group_id` (`group_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of be_auth_group_access
-- ----------------------------
INSERT INTO `be_auth_group_access` VALUES ('1', '4');
INSERT INTO `be_auth_group_access` VALUES ('33', '4');
INSERT INTO `be_auth_group_access` VALUES ('35', '4');
INSERT INTO `be_auth_group_access` VALUES ('36', '4');
INSERT INTO `be_auth_group_access` VALUES ('41', '4');

-- ----------------------------
-- Table structure for be_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `be_auth_rule`;
CREATE TABLE `be_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '' COMMENT '节点路径(控制器/方法)',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '节点名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1开启 0禁用',
  `condition` char(100) NOT NULL DEFAULT '',
  `pid` mediumint(9) NOT NULL DEFAULT '0',
  `level` tinyint(1) NOT NULL DEFAULT '0' COMMENT '等级',
  `sort` int(5) NOT NULL DEFAULT '1000',
  `style` varchar(50) DEFAULT NULL,
  `is_menu` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否为菜单 1不是 2是',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of be_auth_rule
-- ----------------------------
INSERT INTO `be_auth_rule` VALUES ('27', 'Article', '文章管理', '1', '', '0', '0', '8000', 'fa-stack-overflow', '2', '1');
INSERT INTO `be_auth_rule` VALUES ('28', 'article/index', '文章列表', '1', '', '27', '1', '1000', null, '2', '1');
INSERT INTO `be_auth_rule` VALUES ('29', 'article/edit', '文章修改', '1', '', '27', '1', '1000', '0', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('30', 'article/delete', '文章删除', '1', '', '27', '1', '1000', null, '1', '1');
INSERT INTO `be_auth_rule` VALUES ('31', 'Cate', '栏目管理', '1', '', '0', '0', '7000', 'fa-align-justify', '2', '1');
INSERT INTO `be_auth_rule` VALUES ('32', 'cate/index', '栏目列表', '1', '', '31', '1', '1000', null, '2', '1');
INSERT INTO `be_auth_rule` VALUES ('33', 'cate/edit', '栏目修改', '1', '', '31', '1', '1000', null, '1', '1');
INSERT INTO `be_auth_rule` VALUES ('34', 'cate/delete', '栏目删除', '1', '', '31', '1', '1000', null, '1', '1');
INSERT INTO `be_auth_rule` VALUES ('35', 'Data', '数据备份/还原', '1', '', '0', '0', '1000', 'fa-desktop', '2', '1');
INSERT INTO `be_auth_rule` VALUES ('36', 'data/index', '数据库表', '1', '', '35', '1', '1000', '0', '2', '1');
INSERT INTO `be_auth_rule` VALUES ('37', 'Img', '轮播图管理', '0', '', '0', '0', '1000', 'fa-caret-square-o-left', '2', '1');
INSERT INTO `be_auth_rule` VALUES ('38', 'img/index', '轮播图列表', '1', '', '37', '1', '1000', null, '2', '1');
INSERT INTO `be_auth_rule` VALUES ('39', 'img/edit', '轮播图修改', '1', '', '37', '1', '1000', '0', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('40', 'img/delete', '轮播图删除', '1', '', '37', '1', '1000', '0', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('41', 'Admin', '管理员', '1', '', '0', '0', '9000', 'fa-users', '2', '1');
INSERT INTO `be_auth_rule` VALUES ('42', 'admin/index', '管理员列表', '1', '', '41', '1', '1000', '0', '2', '1');
INSERT INTO `be_auth_rule` VALUES ('43', 'admin/edit', '管理员修改', '1', '', '41', '1', '1000', '0', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('44', 'admin/delete', '管理员删除', '1', '', '41', '1', '1000', '0', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('45', 'Conf', '系统', '1', '', '0', '0', '1000', 'fa-gear', '2', '1');
INSERT INTO `be_auth_rule` VALUES ('46', 'conf/index', '配置项', '1', '', '45', '1', '1000', '0', '2', '1');
INSERT INTO `be_auth_rule` VALUES ('47', 'conf/lists', '配置列表（配置功能）', '1', '', '45', '1', '1000', null, '2', '1');
INSERT INTO `be_auth_rule` VALUES ('48', 'conf/edit', '配置项修改', '1', '', '45', '1', '1000', null, '1', '1');
INSERT INTO `be_auth_rule` VALUES ('49', 'conf/delete', '配置项删除', '1', '', '45', '1', '1000', '0', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('52', 'data/handler', '数据表操作', '1', '', '35', '1', '1000', '0', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('65', 'Comment', '评论管理', '1', '', '0', '0', '1000', 'fa-comment', '2', '1');
INSERT INTO `be_auth_rule` VALUES ('66', 'comment/index', '评论列表', '1', '', '65', '1', '1000', '', '2', '1');
INSERT INTO `be_auth_rule` VALUES ('67', 'comment/delete', '评论删除', '1', '', '65', '1', '1000', null, '1', '1');
INSERT INTO `be_auth_rule` VALUES ('68', 'comment/edit', '评论修改', '1', '', '65', '1', '1000', null, '1', '1');
INSERT INTO `be_auth_rule` VALUES ('69', 'Link', '友情链接', '1', '', '0', '0', '1000', 'fa-link', '2', '1');
INSERT INTO `be_auth_rule` VALUES ('70', 'link/index', '链接列表', '1', '', '69', '1', '1000', null, '2', '1');
INSERT INTO `be_auth_rule` VALUES ('71', 'link/delete', '链接删除', '1', '', '69', '1', '1000', null, '1', '1');
INSERT INTO `be_auth_rule` VALUES ('72', 'link/edit', '链接修改', '1', '', '69', '1', '1000', null, '1', '1');
INSERT INTO `be_auth_rule` VALUES ('73', 'link/add', '链接添加', '1', '', '69', '1', '1000', null, '1', '1');
INSERT INTO `be_auth_rule` VALUES ('74', 'img/add', '轮播图添加', '1', '', '37', '1', '1000', '0', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('75', 'cate/add', '栏目添加', '1', '', '31', '1', '1000', null, '1', '1');
INSERT INTO `be_auth_rule` VALUES ('76', 'article/add', '文章添加', '1', '', '27', '1', '1000', '0', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('77', 'conf/add', '配置项添加', '1', '', '45', '1', '1000', null, '1', '1');
INSERT INTO `be_auth_rule` VALUES ('78', 'admin/add', '管理员添加', '1', '', '41', '1', '1000', '0', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('81', 'AuthRule', '节点列表管理', '1', '', '0', '0', '10001', 'fa-list-ul', '2', '1');
INSERT INTO `be_auth_rule` VALUES ('82', 'AuthGroup', '权限用户组', '1', '', '0', '0', '10000', 'fa-sitemap', '2', '1');
INSERT INTO `be_auth_rule` VALUES ('84', 'article/addpost', '文章提交添加', '1', '', '27', '1', '1000', '0', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('85', 'article/editpost', '文章提交修改', '1', '', '27', '1', '1000', '0', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('86', 'admin/addpost', '管理员提交添加', '1', '', '41', '1', '1000', '0', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('87', 'admin/editpost', '管理员提交修改', '1', '', '41', '1', '1000', '', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('88', 'cate/addpost', '栏目提交添加', '1', '', '31', '1', '1000', '', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('89', 'cate/editpost', '栏目提交修改', '1', '', '31', '1', '1000', '', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('90', 'link/addpost', '链接提交添加', '1', '', '69', '1', '1000', '', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('91', 'link/editpost', '链接提交修改', '1', '', '69', '1', '1000', '', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('92', 'auth_rule/addpost', '节点提交添加', '1', '', '81', '1', '1000', '0', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('93', 'auth_rule/editpost', '节点提交修改', '1', '', '81', '1', '1000', '0', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('94', 'auth_group/addpost', '用户组提交添加', '1', '', '82', '1', '1000', '', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('95', 'auth_group/editpost', '用户组提交修改', '1', '', '82', '1', '1000', '', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('96', 'img/addpost', '轮播图提交添加', '1', '', '37', '1', '1000', '', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('97', 'img/editpost', '轮播图提交修改', '1', '', '37', '1', '1000', '', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('98', 'conf/editpost', '配置项提交修改', '1', '', '45', '1', '1000', '', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('99', 'conf/addpost', '配置项提交添加', '1', '', '45', '1', '1000', '', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('100', 'comment/editpost', '评论提交修改', '1', '', '65', '1', '1000', '', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('101', 'auth_group/edit', '权限用户组修改', '1', '', '82', '1', '1000', '0', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('102', 'auth_group/add', '权限用户组添加', '1', '', '82', '1', '1000', '0', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('103', 'auth_group/index', '权限用户组列表', '1', '', '82', '1', '1000', '0', '2', '1');
INSERT INTO `be_auth_rule` VALUES ('105', 'auth_rule/index', '节点列表', '1', '', '81', '1', '1000', '0', '2', '1');
INSERT INTO `be_auth_rule` VALUES ('107', 'auth_rule/delete', '节点列表删除', '1', '', '81', '1', '1000', '0', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('108', 'auth_rule/add', '节点列表添加', '1', '', '81', '1', '1000', '0', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('109', 'auth_group/delete', '权限用户组删除', '1', '', '82', '1', '1000', '', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('112', 'auth_rule/status', '节点的禁止与开启', '1', '', '81', '1', '1000', '0', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('113', 'auth_rule/edit', '节点列表修改', '1', '', '81', '1', '1000', '0', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('115', 'conf/listspost', '配置列表提交修改（配置功能）', '1', '', '45', '1', '1000', '', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('116', 'Log', '日志管理', '1', '', '0', '0', '1000', 'fa-clipboard', '2', '1');
INSERT INTO `be_auth_rule` VALUES ('117', 'log/login', '登录日志', '1', '', '116', '1', '1000', '', '2', '1');
INSERT INTO `be_auth_rule` VALUES ('119', 'log/operate', '操作日志', '1', '', '116', '1', '1000', '', '2', '1');
INSERT INTO `be_auth_rule` VALUES ('120', 'Timeline', '时间轴/代码笔记', '1', '', '0', '0', '1000', 'fa-clock-o', '2', '1');
INSERT INTO `be_auth_rule` VALUES ('121', 'timeline/index', '时间轴和代码笔记列表', '1', '', '120', '1', '1000', '0', '2', '1');
INSERT INTO `be_auth_rule` VALUES ('122', 'data/importlist', '导出SQL列表', '1', '', '35', '1', '999', '', '2', '1');
INSERT INTO `be_auth_rule` VALUES ('123', 'conf/awesome', '图标库', '1', '', '45', '1', '1000', '', '2', '1');
INSERT INTO `be_auth_rule` VALUES ('125', 'timeline/add', '时间轴添加', '1', '', '120', '1', '1000', '', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('126', 'timeline/addpost', '时间轴提交添加', '1', '', '120', '1', '1000', '', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('127', 'timeline/dels', '时间轴批量删除', '1', '', '120', '1', '1000', '', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('128', 'timeline/edit', '时间轴修改', '1', '', '120', '1', '1000', '', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('129', 'timeline/editpost', '时间轴提交修改', '1', '', '120', '1', '1000', '', '1', '1');
INSERT INTO `be_auth_rule` VALUES ('130', 'timeline/delete', '时间轴删除', '1', '', '120', '1', '1000', '0', '1', '1');

-- ----------------------------
-- Table structure for be_cate
-- ----------------------------
DROP TABLE IF EXISTS `be_cate`;
CREATE TABLE `be_cate` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `catename` varchar(64) CHARACTER SET gbk DEFAULT NULL,
  `url` varchar(15) CHARACTER SET gbk DEFAULT NULL,
  `keywords` varchar(255) CHARACTER SET gbk DEFAULT NULL,
  `desc` varchar(64) CHARACTER SET gbk DEFAULT NULL,
  `type` tinyint(1) DEFAULT '0',
  `sort` int(11) DEFAULT '10000',
  `create_time` int(11) DEFAULT NULL,
  `content` text CHARACTER SET gbk,
  `pid` int(11) DEFAULT NULL COMMENT '上级id',
  `edit_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of be_cate
-- ----------------------------
INSERT INTO `be_cate` VALUES ('14', '随笔集', 'artlist.html', '', '', '1', '10000', '1538897944', '', '0', '1619575315');
INSERT INTO `be_cate` VALUES ('35', '二〇一九年', '', '', '', '1', '10000', '1539093243', '', '36', '1542870378');
INSERT INTO `be_cate` VALUES ('36', '闲言', '', '', '', '1', '10000', '1539093339', '', '0', '1544079248');
INSERT INTO `be_cate` VALUES ('40', '二〇一八年', '', '', '', '1', '10000', '1539093339', '', '36', '1542870181');
INSERT INTO `be_cate` VALUES ('41', '关于我', '', 'About Me', '我没有梦想，只想做一只咸鱼', '2', '60', '1539486240', '', '0', '1646287293');
INSERT INTO `be_cate` VALUES ('48', '邻居', '', '', '友情链接', '2', '10000', '1564329325', '', '0', '1564329369');
INSERT INTO `be_cate` VALUES ('51', 'JavaScript', '', '', '', '1', '10000', '1568105057', '', '14', null);
INSERT INTO `be_cate` VALUES ('52', 'PHP', null, '', '', '1', '10000', '1571043516', '', '14', null);
INSERT INTO `be_cate` VALUES ('53', '部署', null, '', '', '1', '10000', '1576578350', '', '14', null);
INSERT INTO `be_cate` VALUES ('54', '数据库', null, '', '', '1', '10000', '1576829480', '', '14', '1586163817');
INSERT INTO `be_cate` VALUES ('59', '简历', null, 'lzm', '刘紫鸣的简历', '2', '10000', '1582611412', '<h2>基本信息</h2>\n<ul>\n<li>刘紫鸣/男/2年经验</li>\n</ul>\n<h2>个人优势</h2>\n<p>喜欢尝试新事物，对所有未知都充满好奇，不善花言巧语的表达，只会用行动证明自己。善于团队协作，全程参与过多次项目开展。熟练使用PS、A1、Axure、Sketch、principle、墨刀等设计工具</p>\n<h2>工作经历</h2>\n<h3>成都网众天弘科技有限公司</h3>\n<p>设计师｜设计部 2016.04-2017.03</p>\n<p>内容：</p>\n<ol>\n<li>全面负责公司的平面设计工作</li>\n<li>根据项目要求负责项目有关美术方面的设计与制作</li>\n<li>负责微信端和官网页面维护</li>\n<li>协助技术部门做相关设计</li>\n<li>上级交办的其他任务</li>\n</ol>\n<h3>成都瑞泰互动信息技术有限公司</h3>\n<p>UI设计师｜设计部 2014.09-2016.02</p>\n<p>内容：</p>\n<ol>\n<li>配合项目部门，策划部门完成相关项目物料的平面设计</li>\n<li>公司品牌宣传需要的物料设计，包括但不限于网站美工，宣传画册等</li>\n<li>根据客户要求进行文字、色彩、图片、图案的创意及版式设计，不限于PPT&amp;H5</li>\n<li>负责网站页面的整体美工创意、设计和页面的实现</li>\n<li>配合网站策划及开发人员进行相应的专题页面制作</li>\n</ol>\n<h2>项目经历</h2>\n<h3>小程序制作系统</h3>\n<p>2017.11-2018.04</p>\n<p>项目描述：</p>\n<p>小程序制作系统是一款面向2B2C的产品，帮助企业快速拥有自己的小程序，全程可视化UI编辑，排版布局拖拽式操作企业只需根据功能需求拖拽对应组件，自由组合，模块间搭配使用，云端自动生成，真正的实现“所见即所得”，随时修改，随时上线。丰富的数据统计功能、精准的用户画像、高效的内容管理后台以及各种社会化营销模块，为企业的线上线下业务提供了更多的想象空间和创收可能。</p>\n<p>责任描述：</p>\n<ol>\n<li>前期负责功能调研，参考大量的竞品和资料分析，整理小程序系统1.0版功能逻辑</li>\n<li>绘制产品原型图并撰写PID</li>\n<li>根据产品原型图制作UI图</li>\n<li>全程和技术部无缝对接，跟进产品开发进度</li>\n<li>持续产品优化及更新</li>\n</ol>\n<h3>CGG游戏公会社区</h3>\n<p>2019.09-2020.09</p>\n<p>项目描述：</p>\n<p>这一款APP是做游戏公会社区的，以公会排行和社区讨论为痛点进行开发和探讨，后面又与电商模块相结合（还在开发中），游戏网游爱好者的聚集地，打卡上分获得积分兑换荣誉。游戏大神经验总结，让每一个人都有拿到BOSS的机会，还有更多的好物等着你的购买。</p>\n<p>责任描述：</p>\n<ol>\n<li>负责项目的整体设计，完成落地页的及时推送，以及修改工作</li>\n<li>负责更新迭代，测试软件上线的要求</li>\n<li>总结痛点，提高界面的用户体验感受，注重界面的规范统一性和一致性</li>\n</ol>\n<h3>线多多APP</h3>\n<p>2019.11-2020.01</p>\n<p>项目描述：</p>\n<p>钱多多是一款理财类的APP，针对一些有理财需求的用户，它的核心功能主要是用户精准推荐高质量的理财产品，以工作的白领人群为主，并增加了小息借贷和生活服务功能等，让更多有需求的人加入进来。</p>\n<p>责任描述：</p>\n<p>负责App的界面风格以及图标、按钮等，并把控整体实现的视觉效果，参与整体过程中的评审，舍弃传统的设计理念，利用留白作内容区分，沉浸式体验。提高用户对数字的敏感度。</p>\n<h2>作品</h2>\n<p><img src=\"https://cdn.jsdelivr.net/gh/Haiwar/images/musclewiki/woman/huling/Chest_m/O1CN01frPm751fHLOE82c31_!!2542743981.jpg_790x10000Q75.jpg\" alt=\"\" /></p>\n<p><img src=\"https://cdn.jsdelivr.net/gh/Haiwar/images/img/ps_xuanfudao.png\" alt=\"\" /></p>\n<p><img src=\"https://gitee.com/liuhaier/images/raw/master/img/ps_dushi.png\" alt=\"\" /></p>\n<p><img src=\"https://gitee.com/liuhaier/images/raw/master/img/ps_renzuozhe.png\" alt=\"\" /></p>\n<p><img src=\"https://gitee.com/liuhaier/images/raw/master/img/ps_xie.png\" alt=\"\" /></p>\n<p><img src=\"https://gitee.com/liuhaier/images/raw/master/img/QQ图片20210921114123.jpg\" alt=\"\" /><img src=\"https://gitee.com/liuhaier/images/raw/master/img/QQ图片20210921114127.jpg\" alt=\"\" /><img src=\"https://gitee.com/liuhaier/images/raw/master/img/QQ图片20210921114131.jpg\" alt=\"\" /><img src=\"https://gitee.com/liuhaier/images/raw/master/img/QQ图片20210921114135.jpg\" alt=\"\" /><img src=\"https://gitee.com/liuhaier/images/raw/master/img/QQ图片20210921114140.jpg\" alt=\"\" /><img src=\"https://gitee.com/liuhaier/images/raw/master/img/QQ图片20210921114110.jpg\" alt=\"\" /><img src=\"https://gitee.com/liuhaier/images/raw/master/img/DA7EFB8C9713C642E86E2B1ACBF5D51C_750_750.jpg\" alt=\"\" /><img src=\"https://gitee.com/liuhaier/images/raw/master/img/QQ图片20210921114119.jpg\" alt=\"\" /><img src=\"https://gitee.com/liuhaier/images/raw/master/img/QQ图片20210921114103.jpg\" alt=\"\" /><img src=\"https://gitee.com/liuhaier/images/raw/master/img/QQ图片20210921114116.jpg\" alt=\"\" /><img src=\"https://cdn.jsdelivr.net/gh/Haiwar/images/img/QQ图片20210921114144.jpg\" alt=\"\" /></p>\n<h2>致谢</h2>\n<p>非常感谢您花时间接受并查阅我的作品，期待能有机会和您一起工作。</p>', '41', '1647400857');
INSERT INTO `be_cate` VALUES ('60', '时光轴', null, '', '', '3', '10000', '1583415335', '', '0', '1618208808');
INSERT INTO `be_cate` VALUES ('61', 'CSS', null, '', '', '1', '10000', '1583459683', '', '14', null);
INSERT INTO `be_cate` VALUES ('62', '计算机网络/服务器', null, '', '', '1', '10000', '1583459931', '', '14', '1586163805');
INSERT INTO `be_cate` VALUES ('63', '二〇二〇年', null, '', '', '1', '10000', '1583460017', '', '36', '1615897610');
INSERT INTO `be_cate` VALUES ('64', '简历2', null, 'resume', '', '2', '10000', '1584272659', '<h2>个人信息</h2>\n<ul>\n<li>\n<p>李春城/男</p>\n</li>\n<li>\n<p>大专/汽车检测与维修技术</p>\n</li>\n<li>\n<p>工作年限：5 年</p>\n</li>\n<li>\n<p>期望职位：4S后市场销售</p>\n</li>\n<li>\n<p>期望薪资: 8K ~ 10K</p>\n</li>\n<li>\n<p>期望城市：成都</p>\n</li>\n</ul>\n<h2>个人优势</h2>\n<ul>\n<li>具备市场营销方面的知识</li>\n<li>有良好的沟通能力，能准确的把握客户心理、发掘潜在需求</li>\n<li>熟悉德系车升级及原厂性能车改装方案</li>\n<li>熟练使用word，excel，ppt</li>\n<li>为人热心、幽默，乐于助人</li>\n<li>热爱体育运动</li>\n<li>C1驾照</li>\n</ul>\n<h2>工作经历</h2>\n<h4>深圳市龙匠科技有限公司 （ 2015.03 ~ 至今）市场部销售区域经理</h4>\n<p>工作内容：</p>\n<ol>\n<li>负责洽谈跟进维护鹏峰、粤宝、合宝、广物、东风南方4s集团店汽车各类精品业务，经手公司淘宝销售渠道，利用网络社交软件及同行商会挖掘潜在客户，定期筹划车友线下活动开展促销方案。</li>\n<li>负责具备各系外饰、内饰、电子改装的诊断经验</li>\n<li>负责协助工程师测试德系车CNA总线数据，培训4S店内销售 公司汽车精品功能及销售话术激励方案。</li>\n<li>负责企业采购PMC，lATF16949管理者代表</li>\n</ol>\n<p>工作业绩：</p>\n<ol>\n<li>公司自主汽车精品月销售额150w～200w</li>\n<li>淘宝渠道月销售额5w ~ 6w</li>\n</ol>\n<h2>教育经历</h2>\n<ul>\n<li>2013.9 - 2015.7 共青科技职业学院/专科/汽车检测与维修技术</li>\n</ul>', '41', '1620128603');
INSERT INTO `be_cate` VALUES ('66', '简历燕', null, '', '', '2', '10000', '1587183667', '<h2>基本信息</h2>\n<ul>\n<li>\n<p>杨燕/女</p>\n</li>\n<li>\n<p>大专/学前教育</p>\n</li>\n<li>\n<p>工作年限：1 年</p>\n</li>\n<li>\n<p>期望城市：成都</p>\n</li>\n<li>\n<p>期望职位：前台</p>\n</li>\n<li>\n<p>期望薪资: 面议</p>\n</li>\n<li>\n<p>求职类型: 社招</p>\n</li>\n</ul>\n<h2>个人优势</h2>\n<ul>\n<li>普通话标准，口齿伶俐，有良好的沟通能力</li>\n<li>做事稳重、责任心强，对待工作积极认真</li>\n<li>良好的团队合作精神以及较好的个人亲和力，为人热心、幽默</li>\n<li>熟练使用word，excel，ppt等常用办公软件</li>\n</ul>\n<h2>工作经历</h2>\n<h4>江西共青城红谷育新幼儿园 幼师</h4>\n<p>2018.9 ~ 2018.12</p>\n<h4>江西共青城格美双语幼儿园 幼师</h4>\n<p>2019.4 ~ 2019.8</p>\n<h4>成都华兴阳光幼儿园 幼师</h4>\n<p>2019.9 ~ 2020.1</p>\n<h2>教育经历</h2>\n<ul>\n<li>2016.9 - 2019.7 共青科技职业学院/大专/学前教育</li>\n</ul>\n<h2>奖项证书</h2>\n<ul>\n<li>普通话二级甲等</li>\n<li>教师资格证</li>\n<li>国家励志奖学金</li>\n</ul>', '41', '1620128591');
INSERT INTO `be_cate` VALUES ('69', '旧--简历', null, '', '', '2', '10000', '1609936612', '<h2>基本信息</h2>\n<ul>\n<li>刘海/男/23岁</li>\n<li>大专/软件技术</li>\n<li>工作经验：2 年</li>\n<li>期望职位：前端开发工程师</li>\n<li>期望薪资：面议</li>\n<li>电话：199 5049 3316</li>\n<li>邮箱：juvenile6@foxmail.com</li>\n<li>GitHub：<a href=\"https://github.com/Haiwar\">https://github.com/Haiwar</a></li>\n<li>博客：<a href=\"http://blog.musclewiki.cn/\">http://blog.musclewiki.cn/</a></li>\n</ul>\n<h2>专业技能</h2>\n<ul>\n<li>基础技能：HTML、JS、CSS、PHP、LESS</li>\n<li>前端框架：Bootstrap、jQuery、Vue全家桶、Swpier</li>\n<li>UI 技术库：element、andt、layui</li>\n<li>数据库相关：MySQL</li>\n<li>服务器相关：Nginx、Apache</li>\n<li>软件技能：Postman、禅道</li>\n<li>版本管理和工程化部署工具：Svn、Git、Composer、Webpack</li>\n</ul>\n<h2>工作经历</h2>\n<h4>成都小步创想慧联科技有限公司 （2019.02 ~ 2020.7）Web前端</h4>\n<ul>\n<li>参与多个项目的工作流程设计和实现</li>\n<li>参与对项目整体需求分析、设计、编码等开发工作</li>\n<li>参与项目重难点模块的开发工作，项目部署、后期维护</li>\n<li>参与并处理公司外包项目的网页端手机端项目开发</li>\n<li>负责项目后期维护和技术支持</li>\n</ul>\n<h4>深圳德盟互联科技有限公司 （2018.7 ~ 2018.12）PHP、Web前端</h4>\n<ul>\n<li>参与项目需求调研、分析、产品设计，并负责完成核心代码</li>\n<li>参与热门技术的调研，并将成熟的技术/方案引入带项目中</li>\n<li>参与完善现有项目的框架结构以及迭代优化</li>\n<li>参与公司微信相关以及网页端手机端的项目开发，保证项目服务器稳定运行</li>\n</ul>\n<h2>项目经验</h2>\n<h4>小步执法综合管理（2019.05 - 至今）</h4>\n<ul>\n<li>项目描述 \n<ul>\n<li>小步执法主要是一个配合各种需求定制开发的多功能定制化执法系统，主要包括有执法案件管理，巡更管理，学习充电管理，违建专项管理、队伍管理，工作考核管理、车辆管理、视频分析调取，综合指挥中心管理等等的综合平台</li>\n</ul></li>\n<li>项目难点 \n<ul>\n<li>熟练使用 Ant.design 组件的应用和编写</li>\n<li>深刻认知 Vue 组件与组件之间值的传递以及 Vue 的生命周期</li>\n<li>使用 npm 安装依赖，webpack 工具进行项目开发打包以及性能优化</li>\n<li>熟悉使用 Chrome 的 Lighthouse 优化工具进行调试优化</li>\n</ul></li>\n</ul>\n<p>项目链接: <a href=\"http://zf.zfdeve.xbcx.com.cn/wq/admin/core/login/index\">http://zf.zfdeve.xbcx.com.cn/wq/admin/core/login/index</a></p>\n<h4>网格化防疫大数据处理平台（2020.01 - 2020.02）</h4>\n<ul>\n<li>项目描述 \n<ul>\n<li>网格化防疫管理平台 ,是为了响应疫情爆发，以及对疫情反思所推出的公益化疫情防控平台，主要包括了外来人口新入境信息记录反馈，居家隔离身体状况记录反馈，集中隔离多人信息记录反馈，以及网格员入户调查等记录反馈</li>\n</ul></li>\n<li>项目难点 \n<ul>\n<li>参与开发、持续改进前端页面设计平台，通过开发工具、改进流程，保证前端业务开发的高效性</li>\n<li>快速搭建后台前端框架，制定项目中常用的组件</li>\n<li>项目初期因人手紧缺，暂时进行后端api接口开发</li>\n</ul></li>\n</ul>\n<p>项目链接: <a href=\"http://yiqing.zfdeve.xbcx.com.cn/wq/admin/core/login/index\">http://yiqing.zfdeve.xbcx.com.cn/wq/admin/core/login/index</a></p>\n<h4>宝塔桥智慧社区系统（2019.12 - 2020.04）</h4>\n<ul>\n<li>项目描述 \n<ul>\n<li>为满足社区信息化治理要求，订制开发的宝塔桥智慧社区系统，主要包括了水域管理，工单管理，停车场管理等</li>\n</ul></li>\n<li>项目难点 \n<ul>\n<li>负责停车场管理，停车设备管理、停车收费、停车场台账、停车统计报表、车辆超限预警阈值设置相关web开发</li>\n<li>负责项目指挥中心开发，利用Vuex的getters搭配filter实现人员、车辆、水域搜寻及分类的功能</li>\n<li>使用高德api完成水域划分区域管理</li>\n</ul></li>\n</ul>\n<p>项目链接: <a href=\"http://baotaqiao.zfdeve.xbcx.com.cn/wq/admin/core/login/index\">http://baotaqiao.zfdeve.xbcx.com.cn/wq/admin/core/login/index</a></p>\n<h4>小鸡窝（2019.03 - 2019.04）</h4>\n<ul>\n<li>项目描述 \n<ul>\n<li>此项目是摆放周边的共享储存柜，类似共享单车需要扫码支付使用</li>\n</ul></li>\n<li>项目难点 \n<ul>\n<li>深刻认知到对安卓、IOS接口的定义参数传递</li>\n<li>完成关注消息提醒、页面签到功能、会员到期时间提醒、用户咨询、自动回复、事件推送等功能</li>\n<li>通过抓包工具获取 Ajax 接口并解析 json 数据</li>\n<li>对数据采用echarts制作可视化图表统计销量</li>\n</ul></li>\n</ul>\n<p>项目链接: <a href=\"http://xiaojiwo.com/\">http://xiaojiwo.com/</a></p>\n<h4>Worth电商网站</h4>\n<ul>\n<li>项目描述 \n<ul>\n<li>跨境电商网站，主要负责首页、支付页、商品详情、公司介绍、个人中心、等功能模块</li>\n</ul></li>\n<li>项目难点 \n<ul>\n<li>运用 Bootstrap 对页面进行美化以及用户的交互动画</li>\n<li>使用 Swpierjs 完成商品轮播预览，评论模块的滚动轮播等功能</li>\n<li>负责 Google地图的api对收货地址的自动填充，图片通过懒加载方式，减少重复代码的冗余，减少 30% 页面加载时间</li>\n<li>熟练掌握 PC 端和移动端的响应式布局方式，并能根据业务需求，封装高复用、可维护性好的前端组件</li>\n</ul></li>\n</ul>\n<p>项目链接: <a href=\"https://www.worth2own.com/\">https://www.worth2own.com/</a></p>\n<h4>匠筑装饰设计工程官网</h4>\n<ul>\n<li>项目介绍 \n<ul>\n<li>匠筑装饰是一家专业从事房屋设计和房屋装饰销售的公司，主要负责首页、产品分类、产品详情、合作加盟、公司介绍、联系客服、等功能后台模块，以及对用户订单管理，对用户的下单管理的实现</li>\n</ul></li>\n<li>项目难点 \n<ul>\n<li>主要负责首页、产品分类、产品详情、合作加盟、公司介绍、联系客服、等功能模块，以及对用户订单管理，对用户的下单管理的实现</li>\n<li>使用 Echarts 插件，图文并茂显示产品、订单的统计结果</li>\n<li>运用 Bootstrap 进行页面美化与自适应开发</li>\n</ul></li>\n</ul>\n<h2>个人优势</h2>\n<ul>\n<li>熟悉前后端开发，有丰富的 LAMP 开发与良好的 Web 网络开发，具有独立解决问题的能力</li>\n<li>拥有良好的语法规范，出色的沟通交流能力，以及对代码的优化整理能力（掌握前端每个环节，如图片懒加载、减少http请求、最大化减少浏览器重构与重绘）</li>\n<li>能熟练封装组件（提高代码可维护性、低耦合性），可快速熟悉业务、具有良好的协作意识、按时完成开发任务，能承受工作压力</li>\n<li>拥有 Geek 精神，热爱开源，在 GitHub 上有多个开源项目</li>\n<li>了解网站性能优化，能解决多浏览器兼容问题，熟练使用传统Web前端开发技术体系</li>\n<li>了解Linux基本语法，能够独立搭建服务器以及部署项目</li>\n</ul>\n<h2>开源项目</h2>\n<h4>ant.design 后台管理系统框架</h4>\n<ul>\n<li>此后台管理系统是自己封装的后台管理系统，由 ant.design Vue 框架开发</li>\n<li>ant.design 框架各个组件的使用、axios 数据接口调用的方法与跨域配置、Vue路由导航守卫以及Vuex状态管理模式，其中还封装了路由懒加载与组件懒加载。是根据项目经验总结出来的后台管理系统</li>\n</ul>\n<p>项目链接: <a href=\"https://gitee.com/liuhaier/fuller-admin-antv/\">https://gitee.com/liuhaier/fuller-admin-antv/</a></p>\n<h4>抖音小程序</h4>\n<ul>\n<li>此项目是仿照抖音所完成的小程序。包含了用户之间的关注、视频点赞收藏、私信等功能</li>\n</ul>\n<p>项目链接: <a href=\"https://github.com/Haiwar/douyin-app/\">https://github.com/Haiwar/douyin-app/</a></p>\n<h4>表白墙</h4>\n<ul>\n<li>此项目是由ThinkPHP5框架开发的告白墙。使用jQuery-mobile 框架进行手机端布局，PHPMailer 发送表白邮箱消息等功能</li>\n</ul>\n<p>项目链接: <a href=\"http://love.musclewiki.cn/\">http://love.musclewiki.cn/</a></p>\n<h4>健身百科</h4>\n<ul>\n<li>主要用于扩展健身教程的网站，前后端由自己独立完成。目前访问量日均300 以上</li>\n</ul>\n<p>项目链接: <a href=\"https://musclewiki.cn/\">https://musclewiki.cn/</a></p>\n<h2>教育经历</h2>\n<ul>\n<li>2016.9 - 2019.7 共青科技职业学院/大专/软件技术/信息工程学院</li>\n<li>2017.7 - 2020.12 南昌理工学院/南昌理工/自考本科/工商企业管理</li>\n</ul>\n<h2>致谢</h2>\n<p>非常感谢您花时间接受并阅读我的简历，期待能有机会和您一起工作。</p>', '41', null);
INSERT INTO `be_cate` VALUES ('70', 'uniapp', null, '', '', '1', '10000', '1611932427', '', '14', null);
INSERT INTO `be_cate` VALUES ('71', '二〇二一年', null, '', '', '1', '10000', '1615897603', '', '36', null);
INSERT INTO `be_cate` VALUES ('72', '干货分享', null, '', '', '1', '10000', '1620367480', '', '0', null);

-- ----------------------------
-- Table structure for be_comment
-- ----------------------------
DROP TABLE IF EXISTS `be_comment`;
CREATE TABLE `be_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT '0' COMMENT 'oath用户id',
  `user_name` varchar(64) DEFAULT NULL,
  `user_email` varchar(64) DEFAULT NULL,
  `user_avatar` text,
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=263 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of be_comment
-- ----------------------------

-- ----------------------------
-- Table structure for be_conf
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of be_conf
-- ----------------------------
INSERT INTO `be_conf` VALUES ('1', '网站名称', 'seo_name', '1', 'Sonder', '', '8', '1538814376', '1539012946', '1');
INSERT INTO `be_conf` VALUES ('2', '网站关键字', 'keywords', '1', '技术博客,PHP,JavaScript,Vue', '', '2', '1538814421', '1538831877', '1');
INSERT INTO `be_conf` VALUES ('3', '网站描述', 'desc', '2', '刘海的Vue博客,Musclewiki健身百科站主,Bilibiili贫穷健身Up主。该网站通过Nuxtjs搭建而来,分享学习、工作中一些技术文章,记录常用踩坑代码。码云:liuhaier,GitHub:Haiwar', '', '1', '1538814507', null, '1');
INSERT INTO `be_conf` VALUES ('4', '是否关闭网站', 'close', '3', '否', '是,否', '3', '1538814572', '1538840202', '1');
INSERT INTO `be_conf` VALUES ('6', '导航栏是否固定', 'fixed', '4', '是', '是', '5', '1538824206', '1544842490', '1');
INSERT INTO `be_conf` VALUES ('8', '网站申明', 'copyright', '1', '2018-2020', '', '6', '1538831582', '1539506514', '1');
INSERT INTO `be_conf` VALUES ('9', '备案号', 'banquan', '1', '蜀ICP备19030690号-2', '', '9', '1539506562', '1539742949', '1');
INSERT INTO `be_conf` VALUES ('10', '个性签名', 'qianming', '1', '乘风波浪会有时，直挂云帆破沧海', '', '10', '1539506909', null, '1');
INSERT INTO `be_conf` VALUES ('14', '去掉轮播图部分', 'del_lunbo', '3', '关闭', '开启,关闭', '14', '1565854293', null, '1');
INSERT INTO `be_conf` VALUES ('15', '文章列表显示数目', 'artlsit_number', '1', '9', '用于api', '15', '1569675459', null, '1');
INSERT INTO `be_conf` VALUES ('19', '是否开启老前台', 'old_index', '3', '否', '是,否', '10000', '1583034428', '1583036294', '1');
INSERT INTO `be_conf` VALUES ('20', '文章密码', 'article_pass', '1', '123456', '', '10000', '1598105422', null, '1');
INSERT INTO `be_conf` VALUES ('21', 'Banner图片', 'bannerImg', '1', 'https://s2.loli.net/2022/03/17/xcLR6HsAZiUr42m.jpg', '', '10000', '1622784213', null, '1');
INSERT INTO `be_conf` VALUES ('22', 'Banner视频', 'bannerVideo', '2', 'https://mdup.apdcdn.tc.qq.com/vcloud1022.tc.qq.com/1022_75a60aa2767d4043803bc4fa468c5ca6.f0.webm?vkey=D3B5B322585A16C1BD0845B87525CAC8FC0DA9104B7AEA6133DF93C50FE131037C839E12D0346E66BD74BD778C77ED5A41D98C6E969646B4D3FC8B6A4045D5716D83B3E8284DADF4C701CDFE32B8B1ED2D2E98C2543F971A&sha=0', '', '10000', '1622784249', '1622784280', '1');

-- ----------------------------
-- Table structure for be_img
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of be_img
-- ----------------------------

-- ----------------------------
-- Table structure for be_link
-- ----------------------------
DROP TABLE IF EXISTS `be_link`;
CREATE TABLE `be_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  `status` tinyint(3) DEFAULT '1',
  `name` varchar(64) DEFAULT NULL,
  `sort` int(11) DEFAULT '10000',
  `pic` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of be_link
-- ----------------------------

-- ----------------------------
-- Table structure for be_login_log
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
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=269 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of be_login_log
-- ----------------------------

-- ----------------------------
-- Table structure for be_operate_log
-- ----------------------------
DROP TABLE IF EXISTS `be_operate_log`;
CREATE TABLE `be_operate_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '操作日志id',
  `operator` varchar(55) NOT NULL COMMENT '操作用户',
  `operator_ip` varchar(15) NOT NULL COMMENT '操作者ip',
  `operate_method` varchar(100) NOT NULL COMMENT '操作方法',
  `operate_desc` varchar(155) NOT NULL COMMENT '操作简述',
  `operate_time` datetime NOT NULL COMMENT '操作时间',
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=153 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of be_operate_log
-- ----------------------------
INSERT INTO `be_operate_log` VALUES ('1', 'admin', '118.112.73.63', 'index/clear', 'admin清除了缓存数据', '2021-03-23 18:10:06');
INSERT INTO `be_operate_log` VALUES ('2', 'admin', '118.112.75.143', 'index/clear', 'admin清除了缓存数据', '2021-03-29 18:29:35');
INSERT INTO `be_operate_log` VALUES ('3', 'admin', '118.112.73.149', 'index/clear', 'admin清除了缓存数据', '2021-04-02 19:04:21');
INSERT INTO `be_operate_log` VALUES ('4', 'admin', '51.91.128.35', 'index/clear', 'admin清除了缓存数据', '2021-04-08 15:49:38');
INSERT INTO `be_operate_log` VALUES ('5', 'admin', '118.112.73.203', 'index/clear', 'admin清除了缓存数据', '2021-04-09 15:31:36');
INSERT INTO `be_operate_log` VALUES ('6', 'admin', '118.112.72.18', 'index/clear', 'admin清除了缓存数据', '2021-04-16 12:26:12');
INSERT INTO `be_operate_log` VALUES ('7', 'admin', '118.112.72.18', 'index/clear', 'admin清除了缓存数据', '2021-04-16 13:06:30');
INSERT INTO `be_operate_log` VALUES ('8', 'admin', '171.217.50.54', 'index/clear', 'admin清除了缓存数据', '2021-04-17 16:33:48');
INSERT INTO `be_operate_log` VALUES ('9', 'admin', '171.217.50.54', 'index/clear', 'admin清除了缓存数据', '2021-04-17 18:35:23');
INSERT INTO `be_operate_log` VALUES ('10', 'admin', '171.217.50.54', 'index/clear', 'admin清除了缓存数据', '2021-04-17 19:00:43');
INSERT INTO `be_operate_log` VALUES ('11', 'admin', '171.217.50.54', 'index/clear', 'admin清除了缓存数据', '2021-04-18 17:37:02');
INSERT INTO `be_operate_log` VALUES ('12', 'admin', '171.217.50.54', 'index/clear', 'admin清除了缓存数据', '2021-04-19 22:56:15');
INSERT INTO `be_operate_log` VALUES ('13', 'admin', '118.112.74.134', 'index/clear', 'admin清除了缓存数据', '2021-04-20 16:44:08');
INSERT INTO `be_operate_log` VALUES ('14', 'admin', '118.112.74.134', 'index/clear', 'admin清除了缓存数据', '2021-04-20 16:49:41');
INSERT INTO `be_operate_log` VALUES ('15', 'test', '118.112.72.77', 'index/clear', 'test清除了缓存数据', '2021-04-21 16:55:21');
INSERT INTO `be_operate_log` VALUES ('16', 'test', '118.112.72.77', 'admin/editpost', 'test修改了管理员（ID:36）：test', '2021-04-21 16:59:15');
INSERT INTO `be_operate_log` VALUES ('17', 'admin', '118.112.72.77', 'index/clear', 'admin清除了缓存数据', '2021-04-21 17:07:08');
INSERT INTO `be_operate_log` VALUES ('18', 'admin', '118.112.72.77', 'index/clear', 'admin清除了缓存数据', '2021-04-21 17:19:15');
INSERT INTO `be_operate_log` VALUES ('19', 'admin', '118.112.73.157', 'index/clear', 'admin清除了缓存数据', '2021-04-23 13:07:39');
INSERT INTO `be_operate_log` VALUES ('20', 'admin', '118.112.75.173', 'index/clear', 'admin清除了缓存数据', '2021-04-24 14:58:00');
INSERT INTO `be_operate_log` VALUES ('21', 'admin', '118.112.74.164', 'index/clear', 'admin清除了缓存数据', '2021-04-26 15:13:01');
INSERT INTO `be_operate_log` VALUES ('22', 'admin', '118.112.74.164', 'index/clear', 'admin清除了缓存数据', '2021-04-26 15:15:14');
INSERT INTO `be_operate_log` VALUES ('23', 'admin', '118.112.74.164', 'index/clear', 'admin清除了缓存数据', '2021-04-27 11:59:31');
INSERT INTO `be_operate_log` VALUES ('24', 'admin', '118.112.74.164', 'index/clear', 'admin清除了缓存数据', '2021-04-27 13:31:49');
INSERT INTO `be_operate_log` VALUES ('25', 'test', '118.112.74.164', 'admin/editpost', 'test修改了管理员（ID:36）：test', '2021-04-28 10:19:31');
INSERT INTO `be_operate_log` VALUES ('26', 'test', '118.112.74.164', 'admin/editpost', 'test修改了管理员（ID:36）：test', '2021-04-28 10:21:04');
INSERT INTO `be_operate_log` VALUES ('27', 'test', '118.112.74.164', 'admin/editpost', 'test修改了管理员（ID:36）：test', '2021-04-28 10:27:52');
INSERT INTO `be_operate_log` VALUES ('28', 'test', '118.112.74.164', 'admin/editpost', 'test修改了管理员（ID:36）：test', '2021-04-28 10:28:07');
INSERT INTO `be_operate_log` VALUES ('29', 'admin', '118.112.73.127', 'index/clear', 'admin清除了缓存数据', '2021-04-29 14:26:12');
INSERT INTO `be_operate_log` VALUES ('30', 'admin', '118.112.75.18', 'index/clear', 'admin清除了缓存数据', '2021-05-07 13:18:22');
INSERT INTO `be_operate_log` VALUES ('31', 'admin', '171.223.95.248', 'index/clear', 'admin清除了缓存数据', '2021-05-10 23:05:14');
INSERT INTO `be_operate_log` VALUES ('32', 'admin', '171.217.48.212', 'index/clear', 'admin清除了缓存数据', '2021-05-15 21:24:37');
INSERT INTO `be_operate_log` VALUES ('33', 'admin', '118.112.75.20', 'index/clear', 'admin清除了缓存数据', '2021-05-17 12:15:05');
INSERT INTO `be_operate_log` VALUES ('34', 'admin', '118.112.73.70', 'index/clear', 'admin清除了缓存数据', '2021-05-19 09:47:31');
INSERT INTO `be_operate_log` VALUES ('35', 'admin', '118.112.75.80', 'index/clear', 'admin清除了缓存数据', '2021-05-25 13:55:30');
INSERT INTO `be_operate_log` VALUES ('36', 'admin', '118.112.75.80', 'index/clear', 'admin清除了缓存数据', '2021-05-25 15:18:02');
INSERT INTO `be_operate_log` VALUES ('37', 'admin', '118.112.72.46', 'index/clear', 'admin清除了缓存数据', '2021-05-28 09:45:52');
INSERT INTO `be_operate_log` VALUES ('38', 'admin', '171.217.51.131', 'index/clear', 'admin清除了缓存数据', '2021-05-30 09:42:08');
INSERT INTO `be_operate_log` VALUES ('39', 'admin', '118.112.74.29', 'index/clear', 'admin清除了缓存数据', '2021-06-07 11:10:36');
INSERT INTO `be_operate_log` VALUES ('40', 'admin', '118.112.75.35', 'index/clear', 'admin清除了缓存数据', '2021-06-08 16:28:54');
INSERT INTO `be_operate_log` VALUES ('41', 'admin', '118.112.74.101', 'index/clear', 'admin清除了缓存数据', '2021-06-19 13:56:49');
INSERT INTO `be_operate_log` VALUES ('42', 'admin', '118.112.75.229', 'index/clear', 'admin清除了缓存数据', '2021-06-21 11:00:47');
INSERT INTO `be_operate_log` VALUES ('43', 'admin', '118.112.74.227', 'index/clear', 'admin清除了缓存数据', '2021-06-25 11:19:40');
INSERT INTO `be_operate_log` VALUES ('44', 'test', '118.112.74.227', 'admin/editpost', 'test修改了管理员（ID:36）：test', '2021-06-25 11:22:28');
INSERT INTO `be_operate_log` VALUES ('45', 'test', '118.112.74.227', 'admin/editpost', 'test修改了管理员（ID:36）：test', '2021-06-25 11:22:36');
INSERT INTO `be_operate_log` VALUES ('46', 'admin', '218.88.38.71', 'admin/editpost', 'admin修改了管理员（ID:36）：test', '2021-06-26 20:29:16');
INSERT INTO `be_operate_log` VALUES ('47', 'admin', '118.112.75.199', 'index/clear', 'admin清除了缓存数据', '2021-06-29 10:07:22');
INSERT INTO `be_operate_log` VALUES ('48', 'admin', '118.112.73.169', 'index/clear', 'admin清除了缓存数据', '2021-07-09 11:26:01');
INSERT INTO `be_operate_log` VALUES ('49', 'admin', '118.112.73.230', 'index/clear', 'admin清除了缓存数据', '2021-07-12 10:59:47');
INSERT INTO `be_operate_log` VALUES ('50', 'admin', '118.112.75.134', 'index/clear', 'admin清除了缓存数据', '2021-07-14 10:05:54');
INSERT INTO `be_operate_log` VALUES ('51', 'admin', '118.112.74.116', 'index/clear', 'admin清除了缓存数据', '2021-07-23 11:24:13');
INSERT INTO `be_operate_log` VALUES ('52', 'admin', '118.112.74.116', 'index/clear', 'admin清除了缓存数据', '2021-07-23 14:00:23');
INSERT INTO `be_operate_log` VALUES ('53', 'admin', '171.217.51.164', 'admin/editpost', 'admin修改了管理员（ID:1）：admin', '2021-07-24 19:13:36');
INSERT INTO `be_operate_log` VALUES ('54', 'admin', '118.112.73.184', 'index/clear', 'admin清除了缓存数据', '2021-07-29 10:49:01');
INSERT INTO `be_operate_log` VALUES ('55', 'admin', '118.112.74.188', 'index/clear', 'admin清除了缓存数据', '2021-07-31 11:21:54');
INSERT INTO `be_operate_log` VALUES ('56', 'admin', '118.112.73.192', 'admin/editpost', 'admin修改了管理员（ID:1）：admin', '2021-08-03 13:18:57');
INSERT INTO `be_operate_log` VALUES ('57', 'admin', '118.112.73.192', 'index/clear', 'admin清除了缓存数据', '2021-08-03 13:23:43');
INSERT INTO `be_operate_log` VALUES ('58', 'admin', '110.184.69.30', 'index/clear', 'admin清除了缓存数据', '2021-08-13 15:42:47');
INSERT INTO `be_operate_log` VALUES ('59', 'admin', '110.184.69.30', 'admin/editpost', 'admin修改了管理员（ID:1）：admin', '2021-08-14 11:04:02');
INSERT INTO `be_operate_log` VALUES ('60', 'admin', '171.217.49.167', 'index/clear', 'admin清除了缓存数据', '2021-08-15 12:26:31');
INSERT INTO `be_operate_log` VALUES ('61', 'admin', '110.184.66.76', 'index/clear', 'admin清除了缓存数据', '2021-08-16 17:34:25');
INSERT INTO `be_operate_log` VALUES ('62', 'admin', '110.184.64.143', 'index/clear', 'admin清除了缓存数据', '2021-08-19 17:38:24');
INSERT INTO `be_operate_log` VALUES ('63', 'admin', '110.185.17.216', 'index/clear', 'admin清除了缓存数据', '2021-08-20 09:57:35');
INSERT INTO `be_operate_log` VALUES ('64', 'admin', '110.184.67.126', 'index/clear', 'admin清除了缓存数据', '2021-09-03 11:12:43');
INSERT INTO `be_operate_log` VALUES ('65', 'admin', '110.184.68.249', 'index/clear', 'admin清除了缓存数据', '2021-09-06 11:13:58');
INSERT INTO `be_operate_log` VALUES ('66', 'admin', '110.184.68.249', 'index/clear', 'admin清除了缓存数据', '2021-09-06 18:14:10');
INSERT INTO `be_operate_log` VALUES ('67', 'admin', '110.185.17.245', 'index/clear', 'admin清除了缓存数据', '2021-09-11 18:00:36');
INSERT INTO `be_operate_log` VALUES ('68', 'admin', '110.184.65.252', 'index/clear', 'admin清除了缓存数据', '2021-09-18 13:18:45');
INSERT INTO `be_operate_log` VALUES ('69', 'admin', '218.88.39.212', 'index/clear', 'admin清除了缓存数据', '2021-09-21 14:35:24');
INSERT INTO `be_operate_log` VALUES ('70', 'admin', '110.184.66.177', 'index/clear', 'admin清除了缓存数据', '2021-09-23 10:21:20');
INSERT INTO `be_operate_log` VALUES ('71', 'admin', '222.210.155.125', 'index/clear', 'admin清除了缓存数据', '2021-10-10 22:38:04');
INSERT INTO `be_operate_log` VALUES ('72', 'admin', '110.184.68.182', 'index/clear', 'admin清除了缓存数据', '2021-10-12 10:49:42');
INSERT INTO `be_operate_log` VALUES ('73', 'admin', '110.184.160.88', 'index/clear', 'admin清除了缓存数据', '2021-10-18 14:54:21');
INSERT INTO `be_operate_log` VALUES ('74', 'admin', '110.185.17.182', 'index/clear', 'admin清除了缓存数据', '2021-10-22 12:29:18');
INSERT INTO `be_operate_log` VALUES ('75', 'admin', '171.217.50.70', 'index/clear', 'admin清除了缓存数据', '2021-10-24 22:45:10');
INSERT INTO `be_operate_log` VALUES ('76', 'admin', '171.217.50.70', 'index/clear', 'admin清除了缓存数据', '2021-10-27 20:07:42');
INSERT INTO `be_operate_log` VALUES ('77', 'admin', '110.184.64.9', 'index/clear', 'admin清除了缓存数据', '2021-10-28 15:48:50');
INSERT INTO `be_operate_log` VALUES ('78', 'test', '218.88.39.161', 'index/clear', 'test清除了缓存数据', '2021-11-07 18:58:06');
INSERT INTO `be_operate_log` VALUES ('79', 'test', '218.88.39.161', 'index/clear', 'test清除了缓存数据', '2021-11-07 18:59:54');
INSERT INTO `be_operate_log` VALUES ('80', 'admin', '110.184.64.86', 'index/clear', 'admin清除了缓存数据', '2021-11-08 11:50:31');
INSERT INTO `be_operate_log` VALUES ('81', 'admin', '110.184.67.9', 'index/clear', 'admin清除了缓存数据', '2021-11-16 18:29:06');
INSERT INTO `be_operate_log` VALUES ('82', 'admin', '110.184.66.24', 'index/clear', 'admin清除了缓存数据', '2021-11-18 13:41:24');
INSERT INTO `be_operate_log` VALUES ('83', 'admin', '110.184.160.34', 'index/clear', 'admin清除了缓存数据', '2021-11-19 13:51:04');
INSERT INTO `be_operate_log` VALUES ('84', 'admin', '110.184.160.34', 'index/clear', 'admin清除了缓存数据', '2021-11-20 14:22:28');
INSERT INTO `be_operate_log` VALUES ('85', 'admin', '110.184.160.34', 'index/clear', 'admin清除了缓存数据', '2021-11-20 14:22:39');
INSERT INTO `be_operate_log` VALUES ('86', 'admin', '110.184.160.34', 'index/clear', 'admin清除了缓存数据', '2021-11-23 14:31:44');
INSERT INTO `be_operate_log` VALUES ('87', 'admin', '110.184.160.34', 'index/clear', 'admin清除了缓存数据', '2021-11-24 12:33:00');
INSERT INTO `be_operate_log` VALUES ('88', 'admin', '110.184.65.80', 'index/clear', 'admin清除了缓存数据', '2021-11-26 17:00:19');
INSERT INTO `be_operate_log` VALUES ('89', 'admin', '110.184.65.80', 'index/clear', 'admin清除了缓存数据', '2021-11-30 14:49:31');
INSERT INTO `be_operate_log` VALUES ('90', 'admin', '110.184.68.173', 'admin/editpost', 'admin修改了管理员（ID:36）：test', '2021-12-01 13:17:35');
INSERT INTO `be_operate_log` VALUES ('91', 'admin', '110.184.68.173', 'admin/editpost', 'admin修改了管理员（ID:36）：test', '2021-12-01 13:17:59');
INSERT INTO `be_operate_log` VALUES ('92', 'test', '110.184.68.173', 'index/clear', 'test清除了缓存数据', '2021-12-01 13:18:49');
INSERT INTO `be_operate_log` VALUES ('93', 'admin', '110.184.68.173', 'admin/editpost', 'admin修改了管理员（ID:36）：test', '2021-12-01 13:19:30');
INSERT INTO `be_operate_log` VALUES ('94', 'admin', '110.184.68.173', 'index/clear', 'admin清除了缓存数据', '2021-12-02 14:24:05');
INSERT INTO `be_operate_log` VALUES ('95', 'admin', '110.184.68.173', 'index/clear', 'admin清除了缓存数据', '2021-12-02 18:29:30');
INSERT INTO `be_operate_log` VALUES ('96', 'admin', '110.185.16.77', 'index/clear', 'admin清除了缓存数据', '2021-12-14 10:15:02');
INSERT INTO `be_operate_log` VALUES ('97', 'admin', '110.184.64.68', 'index/clear', 'admin清除了缓存数据', '2021-12-15 15:51:50');
INSERT INTO `be_operate_log` VALUES ('98', 'admin', '110.184.71.46', 'index/clear', 'admin清除了缓存数据', '2022-01-06 13:07:12');
INSERT INTO `be_operate_log` VALUES ('99', 'admin', '110.184.161.180', 'admin/editpost', 'admin修改了管理员（ID:1）：admin', '2022-01-10 11:44:22');
INSERT INTO `be_operate_log` VALUES ('100', 'admin', '171.217.51.80', 'index/clear', 'admin清除了缓存数据', '2022-01-14 22:18:20');
INSERT INTO `be_operate_log` VALUES ('101', 'admin', '171.217.48.67', 'index/clear', 'admin清除了缓存数据', '2022-01-16 19:50:24');
INSERT INTO `be_operate_log` VALUES ('102', 'admin', '110.184.70.161', 'index/clear', 'admin清除了缓存数据', '2022-01-20 11:18:52');
INSERT INTO `be_operate_log` VALUES ('103', 'admin', '110.185.16.4', 'index/clear', 'admin清除了缓存数据', '2022-01-24 14:38:38');
INSERT INTO `be_operate_log` VALUES ('104', 'admin', '110.185.16.4', 'index/clear', 'admin清除了缓存数据', '2022-01-24 17:53:07');
INSERT INTO `be_operate_log` VALUES ('105', 'admin', '110.184.161.40', 'index/clear', 'admin清除了缓存数据', '2022-01-26 16:53:17');
INSERT INTO `be_operate_log` VALUES ('106', 'admin', '110.185.17.253', 'index/clear', 'admin清除了缓存数据', '2022-02-08 13:16:25');
INSERT INTO `be_operate_log` VALUES ('107', 'admin', '110.185.17.253', 'index/clear', 'admin清除了缓存数据', '2022-02-08 16:17:01');
INSERT INTO `be_operate_log` VALUES ('108', 'admin', '110.185.17.253', 'index/clear', 'admin清除了缓存数据', '2022-02-09 14:59:49');
INSERT INTO `be_operate_log` VALUES ('109', 'admin', '110.184.65.35', 'index/clear', 'admin清除了缓存数据', '2022-02-11 10:39:21');
INSERT INTO `be_operate_log` VALUES ('110', 'admin', '110.184.65.35', 'index/clear', 'admin清除了缓存数据', '2022-02-12 11:09:13');
INSERT INTO `be_operate_log` VALUES ('111', 'admin', '110.184.68.229', 'index/clear', 'admin清除了缓存数据', '2022-02-18 15:42:29');
INSERT INTO `be_operate_log` VALUES ('112', 'admin', '110.184.68.229', 'index/clear', 'admin清除了缓存数据', '2022-02-18 15:42:38');
INSERT INTO `be_operate_log` VALUES ('113', 'admin', '110.184.161.7', 'index/clear', 'admin清除了缓存数据', '2022-02-23 13:34:32');
INSERT INTO `be_operate_log` VALUES ('114', 'admin', '110.184.161.7', 'index/clear', 'admin清除了缓存数据', '2022-02-23 16:00:01');
INSERT INTO `be_operate_log` VALUES ('115', 'admin', '110.184.160.12', 'index/clear', 'admin清除了缓存数据', '2022-03-03 13:26:58');
INSERT INTO `be_operate_log` VALUES ('116', 'admin', '110.184.70.88', 'admin/editpost', 'admin修改了管理员（ID:36）：test', '2022-03-04 12:38:02');
INSERT INTO `be_operate_log` VALUES ('117', 'admin', '110.184.70.88', 'admin/editpost', 'admin修改了管理员（ID:1）：admin', '2022-03-09 16:02:47');
INSERT INTO `be_operate_log` VALUES ('118', 'admin', '110.184.70.88', 'index/clear', 'admin清除了缓存数据', '2022-03-09 16:02:49');
INSERT INTO `be_operate_log` VALUES ('119', 'admin', '110.184.70.88', 'admin/editpost', 'admin修改了管理员（ID:1）：admin', '2022-03-09 16:03:23');
INSERT INTO `be_operate_log` VALUES ('120', 'admin', '110.184.70.88', 'admin/editpost', 'admin修改了管理员（ID:1）：admin', '2022-03-09 16:16:16');
INSERT INTO `be_operate_log` VALUES ('121', 'admin', '110.184.70.88', 'admin/editpost', 'admin修改了管理员（ID:1）：admin', '2022-03-09 16:19:47');
INSERT INTO `be_operate_log` VALUES ('122', 'admin', '110.184.70.88', 'admin/editpost', 'admin修改了管理员（ID:1）：admin', '2022-03-09 16:21:44');
INSERT INTO `be_operate_log` VALUES ('123', 'admin', '110.184.70.88', 'admin/editpost', 'admin修改了管理员（ID:1）：admin', '2022-03-09 16:22:58');
INSERT INTO `be_operate_log` VALUES ('124', 'test', '110.184.70.88', 'index/clear', 'test清除了缓存数据', '2022-03-09 16:29:02');
INSERT INTO `be_operate_log` VALUES ('125', 'test', '110.184.70.88', 'index/clear', 'test清除了缓存数据', '2022-03-09 16:29:19');
INSERT INTO `be_operate_log` VALUES ('126', 'test', '110.184.70.88', 'index/clear', 'test清除了缓存数据', '2022-03-09 16:30:46');
INSERT INTO `be_operate_log` VALUES ('127', 'admin', '110.184.70.88', 'index/clear', 'admin清除了缓存数据', '2022-03-09 16:33:16');
INSERT INTO `be_operate_log` VALUES ('128', 'admin', '110.184.70.88', 'admin/editpost', 'admin修改了管理员（ID:1）：admin', '2022-03-09 18:26:53');
INSERT INTO `be_operate_log` VALUES ('129', 'admin', '171.223.95.223', 'admin/editpost', 'admin修改了管理员（ID:1）：admin', '2022-03-09 21:29:42');
INSERT INTO `be_operate_log` VALUES ('130', 'admin', '171.223.95.223', 'admin/editpost', 'admin修改了管理员（ID:1）：admin', '2022-03-09 21:30:16');
INSERT INTO `be_operate_log` VALUES ('131', 'admin', '171.223.95.223', 'admin/editpost', 'admin修改了管理员（ID:1）：admin', '2022-03-09 21:44:42');
INSERT INTO `be_operate_log` VALUES ('132', 'admin', '110.184.67.179', 'index/clear', 'admin清除了缓存数据', '2022-03-10 16:24:59');
INSERT INTO `be_operate_log` VALUES ('133', 'admin', '182.148.200.164', 'index/clear', 'admin清除了缓存数据', '2022-03-11 23:20:11');
INSERT INTO `be_operate_log` VALUES ('134', 'admin', '110.185.16.66', 'admin/editpost', 'admin修改了管理员（ID:1）：admin', '2022-03-14 10:33:52');
INSERT INTO `be_operate_log` VALUES ('135', 'admin', '110.185.16.66', 'admin/editpost', 'admin修改了管理员（ID:1）：admin', '2022-03-14 10:36:08');
INSERT INTO `be_operate_log` VALUES ('136', 'admin', '110.185.16.66', 'admin/editpost', 'admin修改了管理员（ID:1）：admin', '2022-03-14 10:36:26');
INSERT INTO `be_operate_log` VALUES ('137', 'admin', '110.185.16.66', 'admin/editpost', 'admin修改了管理员（ID:1）：admin', '2022-03-14 12:34:34');
INSERT INTO `be_operate_log` VALUES ('138', 'admin', '110.185.16.66', 'index/clear', 'admin清除了缓存数据', '2022-03-14 15:27:34');
INSERT INTO `be_operate_log` VALUES ('139', 'admin', '110.185.16.66', 'index/clear', 'admin清除了缓存数据', '2022-03-16 13:44:28');
INSERT INTO `be_operate_log` VALUES ('140', 'admin', '110.184.69.86', 'index/clear', 'admin清除了缓存数据', '2022-03-21 16:30:14');
INSERT INTO `be_operate_log` VALUES ('141', 'admin', '110.184.64.240', 'admin/editpost', 'admin修改了管理员（ID:1）：admin', '2022-03-28 18:13:51');
INSERT INTO `be_operate_log` VALUES ('142', 'admin', '110.184.64.240', 'admin/editpost', 'admin修改了管理员（ID:1）：admin', '2022-03-28 18:14:54');
INSERT INTO `be_operate_log` VALUES ('143', 'admin', '110.184.64.240', 'admin/editpost', 'admin修改了管理员（ID:1）：admin', '2022-03-28 18:18:35');
INSERT INTO `be_operate_log` VALUES ('144', 'admin', '110.184.64.240', 'admin/editpost', 'admin修改了管理员（ID:1）：admin', '2022-03-28 18:19:53');
INSERT INTO `be_operate_log` VALUES ('145', 'admin', '110.184.64.240', 'index/clear', 'admin清除了缓存数据', '2022-03-29 14:27:19');
INSERT INTO `be_operate_log` VALUES ('146', 'admin', '110.184.64.240', 'index/clear', 'admin清除了缓存数据', '2022-03-31 17:34:17');
INSERT INTO `be_operate_log` VALUES ('147', 'admin', '110.184.161.163', 'index/clear', 'admin清除了缓存数据', '2022-04-06 17:41:14');
INSERT INTO `be_operate_log` VALUES ('148', 'admin', '110.184.67.141', 'index/clear', 'admin清除了缓存数据', '2022-04-07 09:46:41');
INSERT INTO `be_operate_log` VALUES ('149', 'admin', '110.184.67.141', 'index/clear', 'admin清除了缓存数据', '2022-04-08 14:25:56');
INSERT INTO `be_operate_log` VALUES ('150', 'admin', '110.184.67.141', 'index/clear', 'admin清除了缓存数据', '2022-04-11 10:07:56');
INSERT INTO `be_operate_log` VALUES ('151', 'admin', '110.184.160.160', 'index/clear', 'admin清除了缓存数据', '2022-04-13 15:37:45');
INSERT INTO `be_operate_log` VALUES ('152', 'admin', '127.0.0.1', 'admin/editpost', 'admin修改了管理员（ID:1）：admin', '2022-04-13 17:28:43');

-- ----------------------------
-- Table structure for be_reply
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of be_reply
-- ----------------------------
INSERT INTO `be_reply` VALUES ('10', '0', '30', 'dsadada', '6', '1571739674', '刘海', '刘海', '222.209.78.119');
INSERT INTO `be_reply` VALUES ('11', '1', '30', 'dsadsaas', '6', '1571739752', '柳乘风', '刘海', '222.209.78.119');
INSERT INTO `be_reply` VALUES ('12', '0', '30', 'ccccccccccccc', '8', '1571740512', '刘海', '刘海', '222.209.78.119');
INSERT INTO `be_reply` VALUES ('13', '1', '42', 'sad', '11', '1571758403', '柳乘风', '大哥', '222.209.32.22');
INSERT INTO `be_reply` VALUES ('20', '1', null, 'adasdsa', '11', '1571801811', '柳乘风', '大哥', null);
INSERT INTO `be_reply` VALUES ('21', '1', null, '不客气?', '13', '1571819715', '柳乘风', '大哥', null);
INSERT INTO `be_reply` VALUES ('23', '0', '42', '2222222222222', '31', '1572012704', '刘海2', '刘海2', '222.209.78.119');
INSERT INTO `be_reply` VALUES ('24', '0', '43', 'dsadsa', '52', '1572018790', '市金saasas', '市金saasas', '222.209.78.119');
INSERT INTO `be_reply` VALUES ('32', '0', '41', '啊啊啊', '66', '1572022321', '执法ssss', '执法ssss', '222.209.78.119');
INSERT INTO `be_reply` VALUES ('33', '0', '41', '反反复复烦烦烦烦烦烦烦烦烦', '66', '1572022412', '执法ssss', '执法ssss', '222.209.78.119');
INSERT INTO `be_reply` VALUES ('35', '0', '41', 'vvvvvvvvv', '66', '1572023523', '市金saasas', '执法ssss', '222.209.78.119');
INSERT INTO `be_reply` VALUES ('39', '0', '29', '123', '75', '1575125597', '邵轩', '执法ssss', '117.136.62.19');
INSERT INTO `be_reply` VALUES ('40', '0', '42', '123', '77', '1575125624', '邵轩', '邵轩', '117.136.62.19');
INSERT INTO `be_reply` VALUES ('41', '0', '42', '12312312', '77', '1575125636', '邵轩', '邵轩', '117.136.62.19');
INSERT INTO `be_reply` VALUES ('42', '0', '42', '12312312sss', '78', '1575126565', 'aaa', 'aaa', '117.136.62.19');
INSERT INTO `be_reply` VALUES ('45', '0', '42', '?????', '77', '1575549044', '执法ssss', '邵轩', '110.191.203.42');
INSERT INTO `be_reply` VALUES ('47', '0', '46', 'w(ﾟДﾟ)w', '82', '1576811343', '致命毒药', '致命毒药', '171.213.40.153');
INSERT INTO `be_reply` VALUES ('48', '0', '46', '11点10分?', '82', '1576811422', '苏酒', '致命毒药', '171.213.40.153');
INSERT INTO `be_reply` VALUES ('49', '1', null, '爱了~?', '84', '1647262135', '柳乘风', '苏酒', null);
INSERT INTO `be_reply` VALUES ('51', '1', null, '一生要走多远的路程?经过多少年?才能走到终点?', '83', '1577242807', '柳乘风', '苏酒', null);
INSERT INTO `be_reply` VALUES ('57', '1', null, '11', '123', '1581828754', '柳乘风', 'admin', null);
INSERT INTO `be_reply` VALUES ('59', '0', '30', 'dddddddd', '163', '1581832504', '12321', '12321', '222.215.26.243');
INSERT INTO `be_reply` VALUES ('60', '0', '30', 'dddddddd', '163', '1581832505', '12321', '12321', '222.215.26.243');
INSERT INTO `be_reply` VALUES ('61', '0', '30', '32132132131', '163', '1581832848', '12321', '12321', '222.215.26.243');
INSERT INTO `be_reply` VALUES ('62', '0', '30', '的撒打算大飒飒大师大', '163', '1581832854', '12321', '12321', '222.215.26.243');
INSERT INTO `be_reply` VALUES ('63', '0', '30', '打算打算打算', '163', '1581832860', '12321', '12321', '222.215.26.243');
INSERT INTO `be_reply` VALUES ('64', '0', '30', '2131231232132132131', '162', '1581832866', '12321', '12321', '222.215.26.243');
INSERT INTO `be_reply` VALUES ('65', '0', '30', '法师法师法发顺丰', '162', '1581832872', '12321', '12321', '222.215.26.243');
INSERT INTO `be_reply` VALUES ('66', '0', '41', '擦擦擦', '176', '1581833757', '12321', '12321', '222.215.26.243');
INSERT INTO `be_reply` VALUES ('67', '0', '41', '擦擦擦', '176', '1581833757', '12321', '12321', '222.215.26.243');
INSERT INTO `be_reply` VALUES ('68', '0', '41', 'vvvvvvvva', '179', '1581833997', '12321', '12321', '222.215.26.243');
INSERT INTO `be_reply` VALUES ('69', '0', '41', '啊水水水水水水水水水水水水世道', '179', '1581834001', '12321', '12321', '222.215.26.243');
INSERT INTO `be_reply` VALUES ('73', '1', null, '好的，已添加~', '183', '1581837455', '柳乘风', 'camellia', null);
INSERT INTO `be_reply` VALUES ('82', '0', '62', '<p>111111</p>', '210', '1582437704', 'Sonder', 'Sonder', '117.139.134.4');
INSERT INTO `be_reply` VALUES ('83', '0', '62', '<p>111111</p>', '210', '1582437721', 'Sonder', 'Sonder', '117.139.134.4');
INSERT INTO `be_reply` VALUES ('84', '0', '62', '<p>222222222</p>', '210', '1582437727', 'Sonder', 'Sonder', '117.139.134.4');
INSERT INTO `be_reply` VALUES ('85', '1', null, '0', '211', '1582449221', '柳乘风', 'Sonder', null);
INSERT INTO `be_reply` VALUES ('88', '1', null, '已添加~', '216', '1584849898', 'Sonder', 'AI码真香', null);
INSERT INTO `be_reply` VALUES ('89', '1', null, 'hello！boy', '219', '1587136921', 'Sonder', 'mars', null);
INSERT INTO `be_reply` VALUES ('90', '1', null, '嗨喽，已添加！我会经常来逛贵站的~', '220', '1587568130', 'Sonder', '飒白', null);
INSERT INTO `be_reply` VALUES ('92', '1', null, '对滴，谢谢。已经添加贵站，我会经常光临贵站~', '223', '1647262177', 'Sonder', 'ShareMan', null);
INSERT INTO `be_reply` VALUES ('93', '1', null, '?', '240', '1598275245', 'Sonder', 'px', null);
INSERT INTO `be_reply` VALUES ('94', '1', null, '我也没有', '242', '1612835283', 'Sonder', '最后', null);
INSERT INTO `be_reply` VALUES ('95', '0', '187', '<p>3213213123</p>', '245', '1617953068', '232323', '232323', '118.112.73.203');
INSERT INTO `be_reply` VALUES ('97', '0', '170', '<p>33333</p>', '252', '1618283152', '123312', '123312', '118.112.72.244');
INSERT INTO `be_reply` VALUES ('98', '0', '170', '<p>啊实打实大啊</p>', '252', '1618283163', '123312', '123312', '118.112.72.244');
INSERT INTO `be_reply` VALUES ('99', '1', null, '随便整', '243', '1619663812', 'Sonder', 'pickle', null);
INSERT INTO `be_reply` VALUES ('100', '1', null, '不好意思~~没看到，我已添加，欢迎互访！~', '244', '1635087268', 'Sonder', '冰河洗剑', null);
INSERT INTO `be_reply` VALUES ('101', '1', null, '你好，需要代码改一下', '245', '1644390127', 'Sonder', '卡城', null);
INSERT INTO `be_reply` VALUES ('102', '1', null, '你可以自己研究先，实在不行有偿给你修改?望理解', '246', '1644394084', 'Sonder', '卡成', null);
INSERT INTO `be_reply` VALUES ('103', '1', null, '加我QQ：814029073', '247', '1644394339', 'Sonder', '卡成', null);
INSERT INTO `be_reply` VALUES ('104', '1', null, '?', '218', '1646286991', 'Sonder', 'Super Model', null);

-- ----------------------------
-- Table structure for be_timeline
-- ----------------------------
DROP TABLE IF EXISTS `be_timeline`;
CREATE TABLE `be_timeline` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `create_time` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `cid` int(1) unsigned NOT NULL DEFAULT '60' COMMENT '固定时间轴栏目ID',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `keywords` varchar(100) DEFAULT NULL,
  `type` int(10) NOT NULL DEFAULT '1' COMMENT '1:时间轴 2:代码笔记',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of be_timeline
-- ----------------------------

-- ----------------------------
-- Table structure for count_test_user
-- ----------------------------
DROP TABLE IF EXISTS `count_test_user`;
CREATE TABLE `count_test_user` (
  `id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `login_time` int(11) DEFAULT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of count_test_user
-- ----------------------------
INSERT INTO `count_test_user` VALUES ('0000000001', '1573798129', '125.71.177.150', null);
INSERT INTO `count_test_user` VALUES ('0000000002', '1578384246', '218.89.196.44', null);
INSERT INTO `count_test_user` VALUES ('0000000003', '1578449576', '218.89.196.44', null);
INSERT INTO `count_test_user` VALUES ('0000000004', '1578537254', '171.88.106.56', null);
INSERT INTO `count_test_user` VALUES ('0000000005', '1580977031', '171.91.80.24', null);
INSERT INTO `count_test_user` VALUES ('0000000006', '1580978280', '113.220.21.223', null);
INSERT INTO `count_test_user` VALUES ('0000000007', '1581054236', '171.91.80.24', null);
INSERT INTO `count_test_user` VALUES ('0000000008', '1581830516', '222.215.26.243', '1');
INSERT INTO `count_test_user` VALUES ('0000000009', '1581834869', '112.227.127.213', null);
INSERT INTO `count_test_user` VALUES ('0000000010', '1582298965', '117.139.134.4', null);
INSERT INTO `count_test_user` VALUES ('0000000011', '1582472326', '117.139.134.4', null);
INSERT INTO `count_test_user` VALUES ('0000000012', '1583125823', '171.88.106.32', null);
INSERT INTO `count_test_user` VALUES ('0000000013', '1583153943', '117.139.133.12', null);
INSERT INTO `count_test_user` VALUES ('0000000014', '1583463604', '171.88.106.32', null);
INSERT INTO `count_test_user` VALUES ('0000000015', '1583496734', '117.139.132.137', null);
INSERT INTO `count_test_user` VALUES ('0000000016', '1592358575', '182.148.14.43', null);
INSERT INTO `count_test_user` VALUES ('0000000017', '1594309018', '118.115.59.156', null);
INSERT INTO `count_test_user` VALUES ('0000000018', '1594434281', '110.184.62.255', null);
INSERT INTO `count_test_user` VALUES ('0000000019', '1595200732', '112.21.54.220', null);
INSERT INTO `count_test_user` VALUES ('0000000020', '1595238301', '113.104.208.5', null);
INSERT INTO `count_test_user` VALUES ('0000000021', '1595499818', '218.88.36.173', '1');
INSERT INTO `count_test_user` VALUES ('0000000022', '1596089873', '182.148.15.67', null);
INSERT INTO `count_test_user` VALUES ('0000000023', '1597538279', '222.211.234.172', null);
INSERT INTO `count_test_user` VALUES ('0000000024', '1598105404', '117.176.231.220', null);
INSERT INTO `count_test_user` VALUES ('0000000025', '1598149251', '171.92.172.13', null);
INSERT INTO `count_test_user` VALUES ('0000000026', '1599469911', '182.138.120.241', null);
INSERT INTO `count_test_user` VALUES ('0000000027', '1601019687', '61.238.21.35', null);
INSERT INTO `count_test_user` VALUES ('0000000028', '1602229240', '118.112.74.77', '1');
INSERT INTO `count_test_user` VALUES ('0000000029', '1604799705', '163.142.200.115', null);
INSERT INTO `count_test_user` VALUES ('0000000030', '1607332178', '118.112.75.210', '1');
INSERT INTO `count_test_user` VALUES ('0000000031', '1607332268', '183.229.32.105', null);
INSERT INTO `count_test_user` VALUES ('0000000032', '1618827727', '222.218.97.86', null);
INSERT INTO `count_test_user` VALUES ('0000000033', '1618995108', '118.112.72.77', null);
INSERT INTO `count_test_user` VALUES ('0000000034', '1619495095', '118.112.74.164', '1');
INSERT INTO `count_test_user` VALUES ('0000000035', '1619501698', '165.22.251.31', null);
INSERT INTO `count_test_user` VALUES ('0000000036', '1619572417', '118.112.74.164', null);
INSERT INTO `count_test_user` VALUES ('0000000037', '1619703903', '171.217.51.240', null);
INSERT INTO `count_test_user` VALUES ('0000000038', '1619772145', '119.123.243.5', null);
INSERT INTO `count_test_user` VALUES ('0000000039', '1620442369', '216.189.56.64', null);
INSERT INTO `count_test_user` VALUES ('0000000040', '1620460690', '171.223.32.239', null);
INSERT INTO `count_test_user` VALUES ('0000000041', '1620659037', '171.223.95.248', null);
INSERT INTO `count_test_user` VALUES ('0000000042', '1621408122', '199.19.111.52', null);
INSERT INTO `count_test_user` VALUES ('0000000043', '1621993542', '171.216.85.165', null);
INSERT INTO `count_test_user` VALUES ('0000000044', '1623316766', '113.77.194.128', null);
INSERT INTO `count_test_user` VALUES ('0000000045', '1623575534', '125.64.195.105', null);
INSERT INTO `count_test_user` VALUES ('0000000046', '1624366569', '183.92.222.234', null);
INSERT INTO `count_test_user` VALUES ('0000000047', '1624410485', '183.92.222.234', null);
INSERT INTO `count_test_user` VALUES ('0000000048', '1624591295', '118.112.74.227', null);
INSERT INTO `count_test_user` VALUES ('0000000049', '1625772834', '180.140.155.9', null);
INSERT INTO `count_test_user` VALUES ('0000000050', '1628608133', '223.87.243.253', null);
INSERT INTO `count_test_user` VALUES ('0000000051', '1629161878', '106.57.82.251', null);
INSERT INTO `count_test_user` VALUES ('0000000052', '1630387535', '123.185.76.224', null);
INSERT INTO `count_test_user` VALUES ('0000000053', '1630549171', '45.77.28.53', null);
INSERT INTO `count_test_user` VALUES ('0000000054', '1631608723', '111.121.68.20', null);
INSERT INTO `count_test_user` VALUES ('0000000055', '1635216681', '58.56.233.194', null);
INSERT INTO `count_test_user` VALUES ('0000000056', '1635324547', '143.198.136.189', null);
INSERT INTO `count_test_user` VALUES ('0000000057', '1635480247', '180.116.178.46', null);
INSERT INTO `count_test_user` VALUES ('0000000058', '1636282655', '218.88.39.161', null);
INSERT INTO `count_test_user` VALUES ('0000000059', '1636361352', '180.164.93.14', null);
INSERT INTO `count_test_user` VALUES ('0000000060', '1637328329', '171.39.143.170', null);
INSERT INTO `count_test_user` VALUES ('0000000061', '1638335800', '110.184.68.173', null);
INSERT INTO `count_test_user` VALUES ('0000000062', '1646368694', '110.184.70.88', null);
INSERT INTO `count_test_user` VALUES ('0000000063', '1646814326', '110.184.70.88', null);
INSERT INTO `count_test_user` VALUES ('0000000064', '1649519598', '36.142.132.249', null);
