<?php
use think\Db;
use Think\facade\Cache;

/**
 * 获取头像
 * @param int $id
 * @param string $size
 * @return mixed
 */
function get_avatar($id,$size='middle')
{
	$savepath = '/public/uploads/avatar/';
	$folder = substr($id, -1);
	$avatar=$savepath.$folder.'/'.$id.'_'.$size.'.png';
	$file = str_replace('\\', '/', ROOT_PATH . $avatar);
	if(is_file($file)){
		return $avatar;
	}else{
		return '/public/uploads/avatar/default_'.$size.'.png';
	}
}
/**
 * 获取分类名
 * @param int $id
 * @param string $size
 * @return mixed
 */
function get_category_name($cid)
{
	$category_list= Cache::get('category_list');
	foreach($category_list as $v)
	{
		if($v['id']==$cid){
			return $v['name'];
		}
	}
}



/*
 * 登录积分
 */
function login_credit($uid)
{
	$date = date('Ymd');
	$credit = Db::name('credit')->where(array('uid'=>$uid, 'type'=>1))->order('id DESC')->find();
	$signIn = date('Ymd',$credit['add_time']);
	if($date==$signIn){
		return false;
	}
	credit_log($uid, 1, 2, 1, 0, '每日登录');
}

/*
 * 邮箱认证积分
 */
function email_verify_credit($uid)
{
	$credit = Db::name('credit')->where(array('uid'=>$uid, 'type'=>2))->find();
	if(!$credit['uid']){
		credit_log($uid, 2, 10, 1, 0, '邮箱认证');
	}
}

/*
 * 手机绑定积分
 */
function phone_verify_credit($uid)
{

}

/*
 * 微信绑定积分
 */
function wechat_verify_credit($uid)
{

}

/*
 * 邀请注册积分
 * @param  uid  邀请人ID
 * @param  rid  注册人ID
 */
function register_invite_credit($uid, $rid)
{
	$type = 5;   // 积分类型
	$score= 10;  // 积分
	credit_log($uid, $type, $score, 1, $rid, '邀请用户注册奖励积分');
}


/*
 * 发表主题积分
 */
function topic_credit($uid)
{
	$limit= 5;   // 每日5次奖励
	$type = 7;   // 积分类型
	$score= 10;  // 积分
	$today= strtotime(date('Ymd'));
	$topic= Db::name('credit')->where("uid={$uid} AND type={$type} AND add_time>{$today}")->order('id DESC')->limit($limit)->count('id');
	if($topic>=$limit){
		return false;
	}
	credit_log($uid, $type, $score, 1, 0, '发表话题积分');
}

/*
 * 评论回复积分
 */
function review_credit($uid)
{
	$limit= 20;   // 每日20次奖励
	$type = 8;    // 积分类型
	$score= 1;    // 积分
	$today= strtotime(date('Ymd'));
	$topic= Db::name('credit')->where("uid={$uid} AND type={$type} AND add_time>{$today}")->order('id DESC')->limit($limit)->count('id');
	if($topic>=$limit){
		return false;
	}
	credit_log($uid, $type, $score, 1, 0, '话题评论');
}

/*
 * 加精华
 * @param  uid    用户ID
 * @param  topid  话题ID
 */
function essence_credit($uid,$topid)
{
	$type  = 9;     // 积分类型
	$score = 10;    // 积分
	$credit= Db::name('credit')->where("uid={$uid} AND type={$type} AND target={$topid}")->find();
	if($credit){
		return false;
	}
	credit_log($uid, $type, $score, 1, $topid, '精华贴');
}


/*
 * 加置顶
 * @param  uid    用户ID
 * @param  topid  话题ID
 */
function stick_credit($uid,$topid)
{
	$type  = 10;    // 积分类型
	$score = 10;    // 积分
	$credit= Db::name('credit')->where("uid={$uid} AND type={$type} AND target={$topid}")->find();
	if($credit){
		return false;
	}
	credit_log($uid, $type, $score, 1, $topid, '置顶贴');
}