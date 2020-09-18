<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use Db;
use Config;
use Session;

/**
 * 后台首页
 * Class Index
 * @package app\admin\controller
 */
class Deposit extends AdminBase
{
    protected function initialize()
    {
        parent::initialize();
    }

    public function index($id,$page=1)
    {
    	// 银行卡信息
    	$bank = Db::name('bank_card')->where(['id'=>$id])->find();
    	// 入金记录
        $dataList = Db::name('deposit')->where(['bank_id'=>$id])->order('id DESC')->paginate(10, false, ['page'=>$page]);

        return $this->fetch('index', ['dataList'=>$dataList, 'bank'=>$bank]);
    }

    // 订单审核
    public function review($id)
    {
        $deposit = Db::name('deposit')->where(['status'=>0])->find($id);
        return $this->fetch('review', ['deposit'=>$deposit]);
    }


    // 审核提交
    public function submit($id)
    {
        // 更新订单状态

        // 提交上分
    }
}