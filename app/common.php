<?php
use think\Db;
use think\facade\Session;
//use PHPMailer\PHPMailer\PHPMailer;


/**
 * 获取分类所有子分类
 * @param int $cid 分类ID
 * @return array|bool
 */
function get_category_children($cid)
{
    if (empty($cid)) {
        return false;
    }

    $children = Db::name('category')->where(['path' => ['like', "%,{$cid},%"]])->select();

    return array2tree($children);
}

/**
 * 根据分类ID获取文章列表（包括子分类）
 * @param int   $cid   分类ID
 * @param int   $limit 显示条数
 * @param array $where 查询条件
 * @param array $order 排序
 * @param array $filed 查询字段
 * @return bool|false|PDOStatement|string|\think\Collection
 */
function get_articles_by_cid($cid, $limit = 10, $where = [], $order = [], $filed = [])
{
    if (empty($cid)) {
        return false;
    }

    $ids = Db::name('category')->where(['path' => ['like', "%,{$cid},%"]])->column('id');
    $ids = (!empty($ids) && is_array($ids)) ? implode(',', $ids) . ',' . $cid : $cid;

    $fileds = array_merge(['id', 'cid', 'title', 'introduction', 'thumb', 'reading', 'publish_time'], (array)$filed);
    $map    = array_merge(['cid' => ['IN', $ids], 'status' => 1, 'publish_time' => ['<= time', date('Y-m-d H:i:s')]], (array)$where);
    $sort   = array_merge(['is_top' => 'DESC', 'sort' => 'DESC', 'publish_time' => 'DESC'], (array)$order);

    $article_list = Db::name('article')->where($map)->field($fileds)->order($sort)->limit($limit)->select();

    return $article_list;
}

/**
 * 根据分类ID获取文章列表，带分页（包括子分类）
 * @param int   $cid       分类ID
 * @param int   $page_size 每页显示条数
 * @param array $where     查询条件
 * @param array $order     排序
 * @param array $filed     查询字段
 * @return bool|\think\paginator\Collection
 */
function get_articles_by_cid_paged($cid, $page_size = 15, $where = [], $order = [], $filed = [])
{
    if (empty($cid)) {
        return false;
    }

    $ids = Db::name('category')->where(['path' => ['like', "%,{$cid},%"]])->column('id');
    $ids = (!empty($ids) && is_array($ids)) ? implode(',', $ids) . ',' . $cid : $cid;

    $fileds = array_merge(['id', 'cid', 'title', 'introduction', 'thumb', 'reading', 'publish_time'], (array)$filed);
    $map    = array_merge(['cid' => ['IN', $ids], 'status' => 1, 'publish_time' => ['<= time', date('Y-m-d H:i:s')]], (array)$where);
    $sort   = array_merge(['is_top' => 'DESC', 'sort' => 'DESC', 'publish_time' => 'DESC'], (array)$order);

    $article_list = Db::name('article')->where($map)->field($fileds)->order($sort)->paginate($page_size);

    return $article_list;
}

/**
 * 数组层级缩进转换
 * @param array $array 源数组
 * @param int   $pid
 * @param int   $level
 * @return array
 */
function array2level($array, $pid = 0, $level = 1)
{
    static $list = [];
    foreach ($array as $v) {
        if ($v['pid'] == $pid) {
            $v['level'] = $level;
            $list[]     = $v;
            array2level($array, $v['id'], $level + 1);
        }
    }

    return $list;
}

/**
 * 构建层级（树状）数组
 * @param array  $array          要进行处理的一维数组，经过该函数处理后，该数组自动转为树状数组
 * @param string $pid_name       父级ID的字段名
 * @param string $child_key_name 子元素键名
 * @return array|bool
 */
function array2tree(&$array, $pid_name = 'pid', $child_key_name = 'children')
{
    $counter = array_children_count($array, $pid_name);
    if (!isset($counter[0]) || $counter[0] == 0) {
        return $array;
    }
    $tree = [];
    while (isset($counter[0]) && $counter[0] > 0) {
        $temp = array_shift($array);
        if (isset($counter[$temp['id']]) && $counter[$temp['id']] > 0) {
            array_push($array, $temp);
        } else {
            if ($temp[$pid_name] == 0) {
                $tree[] = $temp;
            } else {
                $array = array_child_append($array, $temp[$pid_name], $temp, $child_key_name);
            }
        }
        $counter = array_children_count($array, $pid_name);
    }

    return $tree;
}

/**
 * 子元素计数器
 * @param array $array
 * @param int   $pid
 * @return array
 */
function array_children_count($array, $pid)
{
    $counter = [];
    foreach ($array as $item) {
        $count = isset($counter[$item[$pid]]) ? $counter[$item[$pid]] : 0;
        $count++;
        $counter[$item[$pid]] = $count;
    }

    return $counter;
}

/**
 * 把元素插入到对应的父元素$child_key_name字段
 * @param        $parent
 * @param        $pid
 * @param        $child
 * @param string $child_key_name 子元素键名
 * @return mixed
 */
function array_child_append($parent, $pid, $child, $child_key_name)
{
    foreach ($parent as &$item) {
        if ($item['id'] == $pid) {
            if (!isset($item[$child_key_name]))
                $item[$child_key_name] = [];
            $item[$child_key_name][] = $child;
        }
    }

    return $parent;
}

/**
 * 循环删除目录和文件
 * @param string $dir_name
 * @return bool
 */

 function delete_dir_file($dirName)
    {
    	$result = false;
        if ($handle = opendir($dirName)) {
            while (false !== ($item = readdir($handle))) {
                if ($item != "." && $item != "..") {
                    if (is_dir("$dirName/$item")) {
                        delete_dir_file("$dirName/$item");
                    } else {
                        //删除文件
                        unlink("$dirName/$item");
                    }
                }
            }
            closedir($handle);
            //删除空文件夹
            if (rmdir($dirName)) {
                $result = true;
            }
            return $result;
        }
    }

/**
 * 判断是否为手机访问
 * @return  boolean
 */
function is_mobile()
{
    static $is_mobile;

    if (isset($is_mobile)) {
        return $is_mobile;
    }

    if (empty($_SERVER['HTTP_USER_AGENT'])) {
        $is_mobile = false;
    } elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false
        || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false
    ) {
        $is_mobile = true;
    } else {
        $is_mobile = false;
    }

    return $is_mobile;
}

/**
 * 手机号格式检查
 * @param string $mobile
 * @return bool
 */
function check_mobile_number($mobile)
{
    if (!is_numeric($mobile)) {
        return false;
    }
    $reg = '#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#';

    return preg_match($reg, $mobile) ? true : false;
}

/**
 * 检测用户是否登录
 * @return  true/false
 */
function is_login()
{
    $member = session('user_id');
    return ($member)?true:false;
}
/**
 * 友好的时间显示
 *
 * @param int    $sTime 待显示的时间
 * @param string $type  类型. normal | mohu | full | ymd | other
 * @param string $alt   已失效
 * @return string
 */
function friendlyDate($sTime,$type = 'normal',$alt = 'false') {
    if (!$sTime)
        return '';
    //sTime=源时间，cTime=当前时间，dTime=时间差
    $cTime      =   time();
    $dTime      =   $cTime - $sTime;
    $dDay       =   intval(date("z",$cTime)) - intval(date("z",$sTime));
    //$dDay     =   intval($dTime/3600/24);
    $dYear      =   intval(date("Y",$cTime)) - intval(date("Y",$sTime));
    //normal：n秒前，n分钟前，n小时前，日期
    if($type=='normal'){
        if( $dTime < 60 ){
            if($dTime < 10){
                return '刚刚';    //by yangjs
            }else{
                return intval(floor($dTime / 10) * 10)."秒前";
            }
        }elseif( $dTime < 3600 ){
            return intval($dTime/60)."分钟前";
        //今天的数据.年份相同.日期相同.
        }elseif( $dYear==0 && $dDay == 0  ){
            //return intval($dTime/3600)."小时前";
            return '今天'.date('H:i',$sTime);
        }elseif($dYear==0){
            return date("m月d日 H:i",$sTime);
        }else{
            return date("Y-m-d H:i",$sTime);
        }
    }elseif($type=='mohu'){
        if( $dTime < 60 ){
            return $dTime."秒前";
        }elseif( $dTime < 3600 ){
            return intval($dTime/60)."分钟前";
        }elseif( $dTime >= 3600 && $dDay == 0  ){
            return intval($dTime/3600)."小时前";
        }elseif( $dDay > 0 && $dDay<=7 ){
            return intval($dDay)."天前";
        }elseif( $dDay > 7 &&  $dDay <= 30 ){
            return intval($dDay/7) . '周前';
        }elseif( $dDay > 30 ){
            return intval($dDay/30) . '个月前';
        }
    //full: Y-m-d , H:i:s
    }elseif($type=='full'){
        return date("Y-m-d , H:i:s",$sTime);
    }elseif($type=='ymd'){
        return date("Y-m-d",$sTime);
    }else{
        if( $dTime < 60 ){
            return $dTime."秒前";
        }elseif( $dTime < 3600 ){
            return intval($dTime/60)."分钟前";
        }elseif( $dTime >= 3600 && $dDay == 0  ){
            return intval($dTime/3600)."小时前";
        }elseif($dYear==0){
            return date("Y-m-d H:i:s",$sTime);
        }else{
            return date("Y-m-d H:i:s",$sTime);
        }
    }
}
/**
 * 二维数组合并
 * @param string $
 * @return
 */
function arr_map($arr)
{
     foreach($arr as $k => $v){
         foreach($v as $k1 => $v2){
             $new_arr[$k1][$k] = $v2;
             }
         }
     return $new_arr;
}
/**
 * has_permission
 * @param string $
 * @return
 */
function has_permission($uid, $type=1)
{
    switch ($type) {
        case 1:
            return $uid == Session::get('user_id') || in_array(Session::get('group_id'),[1,2]);
        case 2:
            return in_array(Session::get('group_id'),[1,2]);
        case 3 :
            return Session::get('group_id') == 1;
        default:
            return false;
    }
}

/**
 * 获取用户组名
 * @param string $
 * @return
 */

function get_group_name($id)
{
    $result = array();
    Cache::remember('group_list',function(){
		return Db::name('auth_group')->select();
	});
	$group_list = Cache::get('group_list');
    foreach($group_list as $k=>$val){
        $result[$val['id']] = $val['title'];
    }
    return $result[$id];
}



/*
 * 格式化输出
 * @param array $data 要输出的数据
 */
function pr($data)
{
    echo '<pre>';
    print_r($data);
}


/*
 * 返回数据格式
 * @param  errCode  状态码（0成功，其它失败）
 * @param  result  返回数据
 * @param  message   提示信息
 */
function resJson($errCode=0, $data=[], $message='Success')
{
    $resultData = array('errCode'=>$errCode, 'message'=>$message, 'data'=>$data);
    echo json_encode($resultData, JSON_UNESCAPED_SLASHES);
    exit;
}


/*
 * 积分记录
 * @param  uid      用户ID
 * @param  type     积分类型(参考congif.system.credit_type)
 * @param  score    变动积分
 * @param  outOrIn  积分流入或流出(0出1进) 
 * @param  from     积分来源
 * @param  info     积分描述
 */
function credit_log($uid,$type,$score=0,$outOrIn=0,$from=0,$info=null)
{
    if(!$uid || !$type || !$score){
        return false;
    }
    // 当前积分
    $balance = Db::name('credit')->where('uid', $uid)->order('id DESC')->value('balance');
    $balance = isset($balance) ? intval($balance) : 0;

    $balance = ($outOrIn==1) ? intval($balance+$score) : intval($balance-$score);
    if($balance<0){
       return false;
    }
    // 数据
    $data['uid']  = $uid;
    $data['type'] = $type;
    $data['outOrIn'] = $outOrIn;
    $data['score']   = $score;
    $data['balance'] = $balance;
    $data['target']  = $from;
    $data['info']    = $info;
    $data['add_time']= time();
    // 启动事务
    Db::startTrans();
    try{
        // 写入积分记录
        Db::name('credit')->insert($data);
        // 更新积分
        Db::name('user')->where('id', $uid)->setField('credit', $balance);
        // 用户等级
        check_user_auth_group();
        // 提交事务
        Db::commit();
    } catch (\Exception $e) {
        // 回滚事务
        Db::rollback();
    }
}

// 用户认证等级检查
function check_user_auth_group()
{
    $uid = session('user_id');   // 用户ID
    $gid = session('group_id');  // 用户组ID
    if(!$uid || $gid){
        return;
    }
    // 分组过滤
    if(in_array($gid,[1,2,11])){
        return;
    }
    // 获得总分数
    $score = Db::name('credit')->where(['uid'=>$uid,'outOrIn'=>1])->sum('score');
    // 积分等级
    if($score<100){
        $group_id = 3;
    }elseif($score>100 && $score<500){
        $group_id = 4;
    }elseif($score>500 && $score<1500){
        $group_id = 5;
    }elseif($score>1500 && $score<2500){
        $group_id = 6;
    }elseif($score>2500 && $score<3500){
        $group_id = 7;
    }elseif($score>3500 && $score<5000){
        $group_id = 8;
    }elseif($score>5000 && $score<7000){
        $group_id = 9;
    }elseif($score>7000 && $score<10000){
        $group_id = 10;
    }elseif($score>10000){
        $group_id = 11;
    }
	// 用户分组数据
	$group_name = Config::get('system.auth_group');
    // 用户等级处理
    if($gid!=$group_id){
        Db::name('user')->where('id', $uid)->setField('group_id', $group_id);
		$msg = '恭喜您，您的帐号等级由['.$group_name[$gid].']升级为['.$group_name[$group_id].']。';
        sendMsg($uid, '帐号等级升级', $msg);
        Session::set('group_id', $group_id);
        Session::set('group_name', $group_name[$group_id]);
    }
}

/*
 * 站内消息发送
 * @param  uid     用户ID
 * @param  title   消息标题
 * @param  msg     消息内容
 * @param  type    消息类型
 * @param  target  发送方ID
 */
function sendMsg($uid,$title,$msg,$type=0,$target=0)
{
    $data['uid']  = $uid;
    $data['type'] = $type;
    $data['title']= $title;
    $data['msg']  = $msg;
    $data['add_time'] = time();
    $data['target'] = $target;
    Db::name('message')->insert($data);
}


/*
 * 邮件发送
 * @param  toMail   收件人邮箱
 * @param  subject  邮件标题
 * @param  content  邮件内容
 * @param  attach   附件数据
 */
function SendMail($toMail,$subject,$content,$attach=array())
{
    //$mail = new PHPMailer;
	$mail = new \PHPMailer\PHPMailer\PHPMailer();
	//pr($mail);

	
	// 发件方
    $mail->IsSMTP();                                         // 使用SMTP服务器发送Email
    $mail->CharSet = config('system.mail_smtp.charset');     // 字符编码
    $mail->Host = config('system.mail_smtp.host');           // 设置SMTP服务器
	$mail->Port = config('system.mail_smtp.port');           // 端口号
	$mail->SMTPAuth = config('system.mail_smtp.auth');       // 是否使用身份验证
	$mail->SMTPSecure = config('system.mail_smtp.secure');   // 安全协议
    $mail->Username = config('system.mail_smtp.username');   // 发送方邮箱
    $mail->Password = config('system.mail_smtp.password');   // 发送方邮箱密码
    $mail->From = config('system.mail_smtp.from');           // 设置邮件头的From字段
    $mail->FromName = config('system.mail_smtp.from_name');  // 设置发件人名字
	$mail->addReplyTo(config('system.mail_smtp.reply'), config('system.mail_smtp.reply_name'));  // 回复邮箱和名称

	// 收件方
    $mail->AddAddress($toMail);  // 收件人地址
	$mail->Subject = $subject;   // 邮件标题
	$mail->IsHTML(true);         // html格式支持
    $mail->Body = $content;      // 邮件内容

	// 附件
	//$attachment = $_SERVER['DOCUMENT_ROOT'].'//public/static/default/images/logo.png';
	//$mail->addAttachment($attachment, "网站LOGO.png");
	if($attach){
		foreach($attach as $k=>$v){
			$mail->addAttachment($v['filepath'], $v['filename']);
		}
	}
    
    // 发送邮件
    if(!$mail->Send()){
		return $mail->ErrorInfo;
	}else{
		return true;
	}
}


/*
 * curl请求
 * @param  url     请求URL
 * @param  method  请求方法
 * @param  params  请求URL
 */
function httpRequest($url, $method='GET', $params=array())
{
    $method = strtoupper($method);
    if(trim($url)=='' || !in_array($method, array('GET','POST'))) {
        return false;
    }
    $curl=curl_init();
    curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl,CURLOPT_HEADER, 0);
    if ($method=='GET') {
        if ($params) {
            $str='?';
            foreach($params as $k=>$v){
                $str.=$k.'='.$v.'&';
            }
            $str=substr($str,0,-1);
            $url.=$str;
        }
        curl_setopt($curl,CURLOPT_URL, $url);
    } else if ($method=='POST') {
        curl_setopt($curl,CURLOPT_URL, $url);
        curl_setopt($curl,CURLOPT_POST, 1);
        curl_setopt($curl,CURLOPT_POSTFIELDS, $params);
    }
    $output = curl_exec($curl);
    curl_close($curl);
    return json_decode($output, true);
}