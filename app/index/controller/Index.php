<?php
namespace app\index\controller;

use app\common\controller\HomeBase;
use Db;
use Cache;
use Session;

class Index extends HomeBase
{
    // 首页
    public function index()
    {
    	if($this->request->isPost()) {
    		$amount= $this->request->post('amount');
    		$order = $this->request->post('order');
            $address = $this->request->post('address');
            
        	return $this->fetch('index', ['amount'=>$amount, 'order'=>$order, 'address'=>$address]);
    	}
    }


    // 转账凭证
    public function certificate()
    {
    	if($this->request->isPost()) {
    		$post = $this->request->post();
    		if(empty($post['image'])){
    			$this->error('请上传转账凭证');
    		}

    		$data = [
    			'wallet'  => $post['wallet'],
    			'name'    => $post['username'],
    			'account' => $post['account'],
    			'address' => $post['address'],
    			'image'   => $post['image'],
    			'amount'  => $post['amount'],
    			'transaction_id' => $post['order'],
    			'create_time'  => time(),
    			'status'  => 0,    			
    		];
    		
    		if(Db::name('deposit')->insert($data)){
    			$this->success('数据已提交', '', 'http://trader.quantumex.io/fund/tradingFlow');
    		}else{
    			$this->error('网络异常，请重新操作');
    		}
    	}
    }


}
