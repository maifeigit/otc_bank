/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : quantumex

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2020-09-18 12:27:12
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `max_auth_group`
-- ----------------------------
DROP TABLE IF EXISTS `max_auth_group`;
CREATE TABLE `max_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `rules` varchar(255) NOT NULL COMMENT '权限规则ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='权限组表';

-- ----------------------------
-- Records of max_auth_group
-- ----------------------------
INSERT INTO `max_auth_group` VALUES ('1', '超级管理员', '1', '1,2,3,73,74,88,5,6,7,8,9,10,11,12,39,40,41,42,43,14,13,20,21,22,23,24,15,25,26,27,28,29,30,75,77,78,79,80,81,76,82,83,84,85,86,87,16,17,44,45,46,47,48,18,49,50,51,52,53,19,31,32,33,34,35,36,37,54,55,58,59,60,61,62,56,63,64,65,66,67,57,68,69,70,71,72');
INSERT INTO `max_auth_group` VALUES ('2', '运营', '1', '');
INSERT INTO `max_auth_group` VALUES ('3', '文案', '1', '');

-- ----------------------------
-- Table structure for `max_auth_group_access`
-- ----------------------------
DROP TABLE IF EXISTS `max_auth_group_access`;
CREATE TABLE `max_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`) USING BTREE,
  KEY `uid` (`uid`) USING BTREE,
  KEY `group_id` (`group_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限组规则表';

-- ----------------------------
-- Records of max_auth_group_access
-- ----------------------------
INSERT INTO `max_auth_group_access` VALUES ('19', '1');

-- ----------------------------
-- Table structure for `max_auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `max_auth_rule`;
CREATE TABLE `max_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL DEFAULT '' COMMENT '规则名称',
  `title` varchar(20) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态',
  `pid` smallint(5) unsigned NOT NULL COMMENT '父级ID',
  `icon` varchar(50) DEFAULT '' COMMENT '图标',
  `sort` tinyint(4) unsigned NOT NULL COMMENT '排序',
  `condition` char(100) DEFAULT '',
  `param` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=109 DEFAULT CHARSET=utf8 COMMENT='规则表';

-- ----------------------------
-- Records of max_auth_rule
-- ----------------------------
INSERT INTO `max_auth_rule` VALUES ('5', 'admin/Menu/default', '菜单管理', '1', '0', '0', 'fa fa-bars', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('6', 'admin/Menu/index', '后台菜单', '1', '1', '5', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('7', 'admin/Menu/add', '添加菜单', '1', '0', '6', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('8', 'admin/Menu/save', '保存菜单', '1', '0', '6', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('9', 'admin/Menu/edit', '编辑菜单', '1', '0', '6', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('10', 'admin/Menu/update', '更新菜单', '1', '0', '6', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('11', 'admin/Menu/delete', '删除菜单', '1', '0', '6', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('14', 'admin/Index/default', '数据管理', '1', '1', '0', 'fa fa-file-text', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('16', 'admin/AdminUser/default', '用户管理', '1', '1', '0', 'fa fa-users', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('18', 'admin/AdminUser/index', '管理员', '1', '1', '16', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('19', 'admin/AuthGroup/index', '权限组', '1', '1', '16', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('31', 'admin/AuthGroup/add', '添加权限组', '1', '0', '19', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('32', 'admin/AuthGroup/save', '保存权限组', '1', '0', '19', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('33', 'admin/AuthGroup/edit', '编辑权限组', '1', '0', '19', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('34', 'admin/AuthGroup/update', '更新权限组', '1', '0', '19', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('35', 'admin/AuthGroup/delete', '删除权限组', '1', '0', '19', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('36', 'admin/AuthGroup/auth', '授权', '1', '0', '19', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('37', 'admin/AuthGroup/updateAuthGroupRule', '更新权限组规则', '1', '0', '19', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('49', 'admin/AdminUser/add', '添加管理员', '1', '0', '18', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('50', 'admin/AdminUser/save', '保存管理员', '1', '0', '18', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('51', 'admin/AdminUser/edit', '编辑管理员', '1', '0', '18', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('52', 'admin/AdminUser/update', '更新管理员', '1', '0', '18', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('53', 'admin/AdminUser/delete', '删除管理员', '1', '0', '18', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('54', 'admin/Slide/default', '轮播图管理', '1', '0', '0', 'fa fa-wrench', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('55', 'admin/SlideCategory/index', '轮播图分类', '1', '1', '54', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('56', 'admin/Slide/index', '轮播图列表', '1', '1', '54', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('58', 'admin/SlideCategory/add', '添加分类', '1', '0', '55', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('59', 'admin/SlideCategory/save', '保存分类', '1', '0', '55', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('60', 'admin/SlideCategory/edit', '编辑分类', '1', '0', '55', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('61', 'admin/SlideCategory/update', '更新分类', '1', '0', '55', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('62', 'admin/SlideCategory/delete', '删除分类', '1', '0', '55', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('63', 'admin/Slide/add', '添加轮播', '1', '0', '56', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('64', 'admin/Slide/save', '保存轮播', '1', '0', '56', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('65', 'admin/Slide/edit', '编辑轮播', '1', '0', '56', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('66', 'admin/Slide/update', '更新轮播', '1', '0', '56', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('67', 'admin/Slide/delete', '删除轮播', '1', '0', '56', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('73', 'admin/ChangePassword/index', '修改密码', '1', '0', '1', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('74', 'admin/ChangePassword/updatePassword', '更新密码', '1', '0', '1', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('75', 'admin/index/index', '数据列表', '1', '1', '14', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('76', 'admin/Article/index', '内容列表', '1', '0', '14', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('77', 'admin/ArticleCategory/add', '添加栏目', '1', '0', '75', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('78', 'admin/ArticleCategory/save', '保存栏目', '1', '0', '75', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('79', 'admin/ArticleCategory/edit', '编辑栏目', '1', '0', '75', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('80', 'admin/ArticleCategory/update', '更新栏目', '1', '0', '75', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('81', 'admin/ArticleCategory/delete', '删除栏目', '1', '0', '75', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('82', 'admin/Article/add', '添加文章', '1', '0', '76', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('83', 'admin/Article/save', '保存文章', '1', '0', '76', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('84', 'admin/Article/edit', '编辑文章', '1', '0', '76', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('85', 'admin/Article/update', '更新文章', '1', '0', '76', '', '0', '', '');
INSERT INTO `max_auth_rule` VALUES ('86', 'admin/Article/delete', '删除文章', '1', '0', '76', '', '0', '', '');

-- ----------------------------
-- Table structure for `max_bank_card`
-- ----------------------------
DROP TABLE IF EXISTS `max_bank_card`;
CREATE TABLE `max_bank_card` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `bank_name` varchar(256) NOT NULL DEFAULT '' COMMENT '银行名称',
  `bank_card` varchar(64) NOT NULL COMMENT '银行卡号',
  `branch` varchar(20) DEFAULT NULL COMMENT '支行信息',
  `name` varchar(10) NOT NULL COMMENT '用户姓名',
  `quota` decimal(15,2) DEFAULT NULL COMMENT '交易额度',
  `create_time` int(10) DEFAULT NULL COMMENT '提交时间',
  `status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='入金信息表';

-- ----------------------------
-- Records of max_bank_card
-- ----------------------------
INSERT INTO `max_bank_card` VALUES ('1', '工商银行', '6220236214', '安华支行', '陈明', '500000.00', '1599410518', '1');
INSERT INTO `max_bank_card` VALUES ('12', '招商银行', '6222152122', null, '上海化工股份有限公司', '500000.00', '1600400027', '0');

-- ----------------------------
-- Table structure for `max_deposit`
-- ----------------------------
DROP TABLE IF EXISTS `max_deposit`;
CREATE TABLE `max_deposit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uid` int(10) NOT NULL COMMENT '用户ID',
  `username` varchar(30) NOT NULL COMMENT '用户名',
  `amount` decimal(15,4) DEFAULT '0.0000' COMMENT '交易金额',
  `sn` varchar(64) NOT NULL COMMENT '第三方单号',
  `platform_sn` varchar(64) DEFAULT NULL COMMENT '平台订单号',
  `app_id` int(2) DEFAULT NULL COMMENT '应用ID',
  `create_time` int(10) DEFAULT NULL COMMENT '提交时间',
  `pic` varchar(256) DEFAULT NULL COMMENT '转账截图',
  `status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='入金信息表';

-- ----------------------------
-- Records of max_deposit
-- ----------------------------

-- ----------------------------
-- Table structure for `max_system`
-- ----------------------------
DROP TABLE IF EXISTS `max_system`;
CREATE TABLE `max_system` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `system` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为系统配置(1是，0否)',
  `group` varchar(20) NOT NULL DEFAULT 'base' COMMENT '分组',
  `title` varchar(20) NOT NULL COMMENT '配置标题',
  `name` varchar(50) NOT NULL COMMENT '配置名称，由英文字母和下划线组成',
  `value` text NOT NULL COMMENT '配置值',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '配置类型()',
  `options` text NOT NULL COMMENT '配置项(选项名:选项值)',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '文件上传接口',
  `tips` varchar(255) NOT NULL COMMENT '配置提示',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) unsigned NOT NULL COMMENT '状态',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COMMENT='系统配置';

-- ----------------------------
-- Records of max_system
-- ----------------------------
INSERT INTO `max_system` VALUES ('1', '1', 'sys', '扩展配置分组', 'config_group', '', '3', ' ', '', '请按如下格式填写：&lt;br&gt;键值:键名&lt;br&gt;键值:键名&lt;br&gt;&lt;span style=&quot;color:#f00&quot;&gt;键值只能为英文、数字、下划线&lt;/span&gt;', '1', '1', '1492140215', '1492140215');
INSERT INTO `max_system` VALUES ('13', '1', 'base', '网站域名', 'site_domain', '', '1', '', '', '', '2', '1', '1492140215', '1492140215');
INSERT INTO `max_system` VALUES ('14', '1', 'upload', '图片上传大小限制', 'upload_image_size', '0', '1', '', '', '单位：KB，0表示不限制大小', '3', '1', '1490841797', '1491040778');
INSERT INTO `max_system` VALUES ('15', '1', 'upload', '允许上传图片格式', 'upload_image_ext', 'jpg,png,gif,jpeg,ico', '1', '', '', '多个格式请用英文逗号（,）隔开', '4', '1', '1490842130', '1491040778');
INSERT INTO `max_system` VALUES ('16', '1', 'upload', '缩略图裁剪方式', 'thumb_type', '2', '5', '1:等比例缩放\r\n2:缩放后填充\r\n3:居中裁剪\r\n4:左上角裁剪\r\n5:右下角裁剪\r\n6:固定尺寸缩放\r\n', '', '', '5', '1', '1490842450', '1491040778');
INSERT INTO `max_system` VALUES ('17', '1', 'upload', '图片水印开关', 'image_watermark', '1', '4', '0:关闭\r\n1:开启', '', '', '6', '1', '1490842583', '1491040778');
INSERT INTO `max_system` VALUES ('18', '1', 'upload', '图片水印图', 'image_watermark_pic', '/upload/sys/image/49/4d0430eaf30318ef847086d0b63db0.png', '8', '', '', '', '7', '1', '1490842679', '1491040778');
INSERT INTO `max_system` VALUES ('19', '1', 'upload', '图片水印透明度', 'image_watermark_opacity', '50', '1', '', '', '可设置值为0~100，数字越小，透明度越高', '8', '1', '1490857704', '1491040778');
INSERT INTO `max_system` VALUES ('20', '1', 'upload', '图片水印图位置', 'image_watermark_location', '9', '5', '7:左下角\r\n1:左上角\r\n4:左居中\r\n9:右下角\r\n3:右上角\r\n6:右居中\r\n2:上居中\r\n8:下居中\r\n5:居中', '', '', '9', '1', '1490858228', '1491040778');
INSERT INTO `max_system` VALUES ('21', '1', 'upload', '文件上传大小限制', 'upload_file_size', '0', '1', '', '', '单位：KB，0表示不限制大小', '1', '1', '1490859167', '1491040778');
INSERT INTO `max_system` VALUES ('22', '1', 'upload', '允许上传文件格式', 'upload_file_ext', 'doc,docx,xls,xlsx,ppt,pptx,pdf,wps,txt,rar,zip', '1', '', '', '多个格式请用英文逗号（,）隔开', '2', '1', '1490859246', '1491040778');
INSERT INTO `max_system` VALUES ('23', '1', 'upload', '文字水印开关', 'text_watermark', '0', '4', '0:关闭\r\n1:开启', '', '', '10', '1', '1490860872', '1491040778');
INSERT INTO `max_system` VALUES ('24', '1', 'upload', '文字水印内容', 'text_watermark_content', '', '1', '', '', '', '11', '1', '1490861005', '1491040778');
INSERT INTO `max_system` VALUES ('25', '1', 'upload', '文字水印字体', 'text_watermark_font', '', '9', '', '', '不上传将使用系统默认字体', '12', '1', '1490861117', '1491040778');
INSERT INTO `max_system` VALUES ('26', '1', 'upload', '文字水印字体大小', 'text_watermark_size', '20', '1', '', '', '单位：px(像素)', '13', '1', '1490861204', '1491040778');
INSERT INTO `max_system` VALUES ('27', '1', 'upload', '文字水印颜色', 'text_watermark_color', '#000000', '1', '', '', '文字水印颜色，格式:#000000', '14', '1', '1490861482', '1491040778');
INSERT INTO `max_system` VALUES ('28', '1', 'upload', '文字水印位置', 'text_watermark_location', '7', '5', '7:左下角\r\n1:左上角\r\n4:左居中\r\n9:右下角\r\n3:右上角\r\n6:右居中\r\n2:上居中\r\n8:下居中\r\n5:居中', '', '', '11', '1', '1490861718', '1491040778');
INSERT INTO `max_system` VALUES ('29', '1', 'upload', '缩略图尺寸', 'thumb_size', '300x300;500x500', '1', '', '', '为空则不生成，生成 500x500 的缩略图，则填写 500x500，多个规格填写参考 300x300;500x500;800x800', '4', '1', '1490947834', '1491040778');
INSERT INTO `max_system` VALUES ('30', '1', 'develop', '开发模式', 'app_debug', '1', '4', '0:关闭\r\n1:开启', '', '', '0', '1', '1491005004', '1492093874');
INSERT INTO `max_system` VALUES ('31', '1', 'develop', '页面Trace', 'app_trace', '1', '4', '0:关闭\r\n1:开启', '', '', '0', '1', '1491005081', '1492093874');
INSERT INTO `max_system` VALUES ('33', '1', 'sys', '富文本编辑器', 'editor', 'kindeditor', '5', 'ueditor:UEditor\r\numeditor:UMEditor\r\nkindeditor:KindEditor\r\nckeditor:CKEditor', '', '', '2', '0', '1491142648', '1492140215');
INSERT INTO `max_system` VALUES ('35', '1', 'databases', '备份目录', 'backup_path', './backup/database/', '1', '', '', '数据库备份路径,路径必须以 / 结尾', '0', '1', '1491881854', '1491965974');
INSERT INTO `max_system` VALUES ('36', '1', 'databases', '备份分卷大小', 'part_size', '20971520', '1', '', '', '用于限制压缩后的分卷最大长度。单位：B；建议设置20M', '0', '1', '1491881975', '1491965974');
INSERT INTO `max_system` VALUES ('37', '1', 'databases', '备份压缩开关', 'compress', '1', '4', '0:关闭\r\n1:开启', '', '压缩备份文件需要PHP环境支持gzopen,gzwrite函数', '0', '1', '1491882038', '1491965974');
INSERT INTO `max_system` VALUES ('38', '1', 'databases', '备份压缩级别', 'compress_level', '4', '6', '1:最低\r\n4:一般\r\n9:最高', '', '数据库备份文件的压缩级别，该配置在开启压缩时生效', '0', '1', '1491882154', '1491965974');
INSERT INTO `max_system` VALUES ('39', '1', 'base', '网站状态', 'site_status', '1', '4', '0:关闭\r\n1:开启', '', '站点关闭后将不能访问，后台可正常登录', '1', '1', '1492049460', '1494690024');
INSERT INTO `max_system` VALUES ('40', '1', 'sys', '后台管理路径', 'admin_path', 'admin.php', '1', '', '', '必须以.php为后缀', '0', '0', '1492139196', '1492140215');
INSERT INTO `max_system` VALUES ('41', '1', 'base', '网站标题', 'site_title', '', '1', '', '', '网站标题是体现一个网站的主旨，要做到主题突出、标题简洁、连贯等特点，建议不超过28个字', '6', '1', '1492502354', '1494695131');
INSERT INTO `max_system` VALUES ('42', '1', 'base', '网站关键词', 'site_keywords', '', '1', '', '', '网页内容所包含的核心搜索关键词，多个关键字请用英文逗号&quot;,&quot;分隔', '7', '1', '1494690508', '1494690780');
INSERT INTO `max_system` VALUES ('43', '1', 'base', '网站描述', 'site_description', '', '2', '', '', '网页的描述信息，搜索引擎采纳后，作为搜索结果中的页面摘要显示，建议不超过80个字', '8', '1', '1494690669', '1494691075');
INSERT INTO `max_system` VALUES ('44', '1', 'base', 'ICP备案信息', 'site_icp', '', '1', '', '', '请填写ICP备案号，用于展示在网站底部，ICP备案官网：&lt;a href=&quot;http://www.miibeian.gov.cn&quot; target=&quot;_blank&quot;&gt;http://www.miibeian.gov.cn&lt;/a&gt;', '9', '1', '1494691721', '1494692046');
INSERT INTO `max_system` VALUES ('45', '1', 'base', '统计代码', 'site_statis', '', '2', '', '', '第三方流量统计代码，前台调用时请先用 htmlspecialchars_decode函数转义输出', '10', '1', '1494691959', '1494694797');
INSERT INTO `max_system` VALUES ('46', '1', 'base', '网站名称', 'site_name', '', '1', '', '', '将显示在浏览器窗口标题等位置', '3', '1', '1494692103', '1494694680');
INSERT INTO `max_system` VALUES ('47', '1', 'base', '网站LOGO', 'site_logo', '', '8', '', '', '网站LOGO图片', '4', '1', '1494692345', '1494693235');
INSERT INTO `max_system` VALUES ('48', '1', 'base', '网站图标', 'site_favicon', '', '8', '', '/admin/annex/favicon', '又叫网站收藏夹图标，它显示位于浏览器的地址栏或者标题前面，&lt;strong class=&quot;red&quot;&gt;.ico格式&lt;/strong&gt;，&lt;a href=&quot;https://www.baidu.com/s?ie=UTF-8&amp;wd=favicon&quot; target=&quot;_blank&quot;&gt;点此了解网站图标&lt;/a&gt;', '5', '0', '1494692781', '1494693966');
INSERT INTO `max_system` VALUES ('49', '1', 'base', '手机网站', 'wap_site_status', '0', '4', '0:关闭\r\n1:开启', '', '如果有手机网站，请设置为开启状态，否则只显示PC网站', '2', '0', '1498405436', '1498405436');
INSERT INTO `max_system` VALUES ('50', '1', 'sys', '云端推送', 'cloud_push', '0', '4', '0:关闭\r\n1:开启', '', '关闭之后，无法通过云端推送安装扩展', '3', '0', '1504250320', '1504250320');
INSERT INTO `max_system` VALUES ('51', '0', 'base', '手机网站域名', 'wap_domain', '', '1', '', '', '手机访问将自动跳转至此域名', '2', '0', '1504304776', '1504304837');
INSERT INTO `max_system` VALUES ('52', '0', 'sys', '多语言支持', 'multi_language', '0', '4', '0:关闭\r\n1:开启', '', '开启后你可以自由上传多种语言包', '4', '0', '1506532211', '1506532211');

-- ----------------------------
-- Table structure for `max_user`
-- ----------------------------
DROP TABLE IF EXISTS `max_user`;
CREATE TABLE `max_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(11) DEFAULT '3' COMMENT '用户组id',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `password` char(60) NOT NULL COMMENT '密码',
  `avatar` varchar(100) DEFAULT '/public/uploads/avatar/default' COMMENT '头像',
  `mobile` varchar(11) DEFAULT '' COMMENT '手机',
  `email` varchar(50) DEFAULT '' COMMENT '邮箱',
  `hometown` varchar(20) DEFAULT '' COMMENT '城市',
  `signature` varchar(255) DEFAULT NULL COMMENT '自我介绍',
  `topics` int(11) unsigned DEFAULT '0' COMMENT '话题数',
  `posts` int(11) unsigned DEFAULT '0' COMMENT '贴子数',
  `status` tinyint(1) unsigned DEFAULT '1' COMMENT '用户状态  1 正常  2 禁止',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `last_login_time` int(10) DEFAULT NULL COMMENT '最后登陆时间',
  `last_login_ip` varchar(50) DEFAULT '' COMMENT '最后登录IP',
  `sex` tinyint(1) DEFAULT '0' COMMENT '0男1女',
  `credit` int(10) DEFAULT '0' COMMENT '积分',
  `inviter` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of max_user
-- ----------------------------
INSERT INTO `max_user` VALUES ('1', '1', 'qua', '$2y$10$4/q3r1zJyBH2lrTQ7PPTS.RTxCZBixgbvzt.eeCyiRQlfmZD65WUq', '/public/uploads/avatar/1/1', '', '', '', null, '11', '15', '1', '1584420919', '1600397832', '127.0.0.1', '0', '5', null);
