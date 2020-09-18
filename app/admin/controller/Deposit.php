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
$pubkey = "-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAyRKwE0KffswpU2M67HYQ
MvstrdkcrQpmWgdKnud3YEiIYQfpev0EqSLarjO32BFxNppd80zVWeCEyVaZJl/p
5GkMVC24dzs99wNHTDpsN0Gr3CRBMYQiOrZ8Eg1AVW/SsGEtRNmWUFgr/bqMLAmZ
/ZPoXHCZIzucNFG0pLhJsFG3bHuJYNMLluNEA4SxQ3quWglzU/YNW+s6RlzvxJft
tdVfkqDs3QjADXG5z7uXyyWUjiXQvGQcIGbei/bjFLxTvmh8qRrk8GWX8DfMqKyR
hU0LOKk2GvbAVqeqGr1Mp6IC/bTJPNI66qKee5Y19oOlvBdJmQxW32q4fe9u1JSS
CQIDAQAB
-----END PUBLIC KEY-----";

        if ($this->request->isPost()) {
            $post = $this->request->post();
            if($post['status']==1){
                $deposit = Db::name('deposit')->where(['id'=>$post['id']])->find();
                $bank = Db::name('bank_card')->where(['id'=>$deposit['bank_id']])->find();
                $data = [
                     'id'          => $post['id'],
                     'uid'         => $deposit['uid'],
                     'username'    => $deposit['username'],
                     'sn'          => $deposit['sn'],
                     'amount'      => $deposit['amount'],
                     'create_time' => time(),
                     'bank_id'     => $deposit['bank_id'],
                     'bank_name'   => $bank['bank_name'],
                     'bank_card'   => $bank['bank_card'],
                     'bank_person' => $bank['name'],
                     'platform_sn' => $deposit['platform_sn'],
                     'pic'         => $deposit['pic'],
                     'pic_time'    => time(),
                     'push_time'   => time(),
                     'notice_number' => 1,
                     'status' => 200,
                     'remark' => '收款成功',
                ];
                $json = json_encode($data);

                $crypto = '';
                foreach (str_split($json, 128) as $chunk){
                    openssl_public_encrypt($chunk, $encryptData, $pubkey);
                    $crypto .= $encryptData;
                }
                $encrypt = base64_encode($crypto);
                $encrypt = json_encode($encrypt);
                $postData = [
                        'target' => 'bankRecharge',
                        'remark' => '银行转款：收款成功',
                        'id'     => $post['id'],
                        'data'   => $encrypt,
                ];

                $url = 'https://pay.yettaldn.com/receive/data';
                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);  // 必须
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);  // 必须是2
                curl_setopt($curl, CURLOPT_HEADER, 0);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_TIMEOUT, 1000);
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);

                $result = curl_exec($curl);
                curl_close($curl);
                $pushResult = json_decode($result, true);

                if($pushResult['status']==200){
                    if(Db::name('deposit')->where(['id'=>$post['id']])->update(['status'=>1])){
                        $this->success('审核成功');
                    }else{
                        $this->error('已上分，本地审核状态失败');
                    }
                }else{
                    $this->error($pushResult['msg']);
                }
            }else{
                if(Db::name('deposit')->where(['id'=>$post['id']])->update(['status'=>2])){
                    $this->success('状态已更新');
                }else{
                    $this->error('状态更新失败');
                }
            }
        }
    }
}