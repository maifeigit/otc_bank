<?php
namespace app\common\model;

use think\Model;
use think\Db;

class User extends Model
{
    protected $autoWriteTimestamp = true;

    /**
     * 创建时间
     * @return bool|string
     */
    //protected function setCreateTimeAttr()
    //{
    //    return date('Y-m-d H:i:s');
    //}


    // 最近浏览用户
    public function visitor()
    {
    	$sql = "SELECT distinct ul.`uid`,ul.`from`,u.`group_id`,u.`username`,u.`avatar` FROM `bc_user_login` ul
    			LEFT JOIN `bc_user` u ON u.`id`=ul.`uid`
    			ORDER BY ul.`id` DESC
    			LIMIT 0,15";
    	$data = Db::query($sql);
    	return $data;
    }

    // 用户等级
    public function user_level($uid)
    {
		$sql = "SELECT u.`id`,u.`group_id`,u.`username`,u.`avatar`,ag.`title` FROM `bc_user` u
    			LEFT JOIN `bc_auth_group` ag ON u.`group_id`=ag.`id`
    			WHERE u.`id`={$uid}
    			LIMIT 0,1";
    	$data = Db::query($sql);
    	return $data[0];
	}
}