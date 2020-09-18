<?php

return [
    'group_list' => [
	    'base'=>'基础',
	    //'sys'=>'系统',
	    //'upload' =>'上传',
	    //'develop' =>'开发',
	    //'databases' =>'数据库',
	],
	'group_type' => ['input','textarea','array','switch','select','radio','checkbox','image','file'],

	// 用户组（用户升级根据累计获得积分计算升级）
	'auth_group' => [
		1 => '超级管理员',
		2 => '版主',
		3 => '斗者',
		4 => '斗师',
		5 => '斗灵',
		6 => '斗王',
		7 => '斗皇',
		8 => '斗宗',
		9 => '斗尊',
		10=> '斗圣',
		11=> '斗帝'
	],

	// 积分类型（用户获取积分的类型）
	'credit_type' => [
		0 => '系统奖励',
		1 => '登录积分',
		2 => '邮箱认证',
		3 => '手机认证',
		4 => '微信绑定',
		5 => '推广邀请',
		6 => '访问推广',
		7 => '发表主题',
		8 => '留言评论',
		9 => '文章加精',
		10=> '文章置顶'
	],

	// 邮箱配置
	'mail_smtp' => [
		'host'    => 'smtp.163.com',   // SMTP服务器地址
		'port'    => 465,		       // 端口号（注意SSL或非SSL）
		'charset' => 'utf-8',          // 字符集
		'encoding'=> 'base64',         // 编码方式		 
		'auth'    => true,             // SMTP登录验证
		'secure'  => 'ssl',            // SMTP安全协议
		'username' => '',   // SMTP登录邮箱
		'password' => '',     // SMTP登录密码
		'from'     => '',   // 发件人邮箱
		'from_name'=> '',              // 发件人名称
		'reply'     => '',  // 回复邮箱
		'reply_name'=> '',  // 回复名称
	]
];
