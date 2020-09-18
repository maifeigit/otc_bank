<?php
namespace app\api\controller;

use think\Controller;
use Config;
use think\Db;
use Session;
use Cache;
use Log; 

/**
 * 收藏管理
 */
class Bank extends Controller
{

    protected function initialize()
    {
        parent::initialize();
    }


    public function index()
    {

    }


    // 交易请求
    public function apply()
    {
        if ($this->request->isPost()) {
            $post = $this->request->param('data');
            // 平台订单号
            $platform_sn = date('YmdHis').mt_rand(10000,99999);
            // 获取一张可用银行卡
            $bank = Db::name('bank_card')->where(['status'=>1])->find();
            if($bank['id']){
                // 订单数据
                $data = [
                    'bank_id'  => $bank['id'],
                    'uid'      => $post['uid'],
                    'username' => $post['username'],
                    'amount'   => $post['amount'],
                    'sn'       => $post['sn'],
                    'app_id'   => $post['app_id'],
                    'platform_sn' => $platform_sn,
                    'create_time' =>time(),
                    'status'   => 0,
                ];

                // 保存订单数据
                if(Db::name('deposit')->insertGetId($data)){
                    $result['data'] = [
                        'create_time' => time(),
                        'uid'         => $post['uid'],
                        'username'    => $post['username'],
                        'sn'          => $post['sn'],
                        'amount'      => $post['amount'],
                        'bank_id'     => $bank['id'],
                        'bank_name'   => $bank['bank_name'],
                        'bank_card'   => $bank['bank_card'],
                        'bank_person' => $bank['name'],
                        'platform_sn' => $platform_sn,
                        'app_id'      => $post['app_id'],
                    ];
                    echo json_encode($result); exit;
                } else {
                    $result['data'] = [
                        'status' => 400,
                        'msg'    => '订单数据保存失败',
                        'data'   => ''
                    ];
                    echo json_encode($result); exit;
                }
            }else{
                $result['data'] = [
                    'status' => 400,
                    'msg'    => '暂无可用银行卡',
                    'data'   => ''
                ];
                echo json_encode($result); exit;
            }
        }
    }

    public function pic()
    {
        if ($this->request->isPost()) {
            $post = $this->request->param();

            $pic         = $post['pic'];            // 转账截图
            $platform_sn = $post['platform_sn'];    // 平台单号

            if(Db::name('deposit')->where(['platform_sn'=>$platform_sn])->find()){
                // 保存转账截图
                if (Db::name('deposit')->where(['platform_sn'=>$platform_sn])->update(['pic'=>$pic])) {
                    $result['data'] = [
                        'status' => 200,
                        'msg'    => '已更新图片链接',
                        'data'   => ''
                    ];
                    echo json_encode($result); exit;
                } else {
                    $result['data'] = [
                        'status' => 400,
                        'msg'    => '图片链接更新失败',
                        'data'   => ''
                    ];
                    echo json_encode($result); exit;
                }
            }else{
                $result['data'] = [
                    'status' => 400,
                    'msg'    => '查询不到订单',
                    'data'   => ''
                ];
                echo json_encode($result); exit;
            }
        }
    }


}