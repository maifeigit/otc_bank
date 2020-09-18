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
class Index extends AdminBase
{
    protected function initialize()
    {
        parent::initialize();
    }

    public function index($page=1)
    {
        $dataList = Db::name('bank_card')->paginate(10, false, ['page'=>$page]);
        return $this->fetch('index', ['dataList' => $dataList]);
    }

    public function add()
    {
        return $this->fetch('add');
    }

    public function save()
    {
        if ($this->request->isPost()) {
            $post = $this->request->param();
            // 数据处理
            $data = [
                'bank_name' => $post['bank_name'],
                'bank_card' => $post['bank_card'],
                'branch' 	=> $post['branch'],
                'name' 		=> $post['name'],
                'quota'		=> $post['quota'],
                'status' 	=> $post['status'],
                'create_time' => time(),
            ];
            if(Db::name('bank_card')->insertGetId($data)){
            	$this->success('保存成功');
            } else {
	            $this->error('保存失败');
	        }
        }
    }

    public function edit($id)
    {
    	$bank = Db::name('bank_card')->find($id);
        return $this->fetch('edit',['bank'=>$bank]);
    }

    public function update()
    {
        if ($this->request->isPost()) {
            $post = $this->request->param();
            $data = [
                'bank_name' => $post['bank_name'],
                'bank_card' => $post['bank_card'],
                'branch' 	=> $post['branch'],
                'name' 		=> $post['name'],
                'quota'		=> $post['quota'],
                'status' 	=> $post['status'],
            ];
	        if (Db::name('bank_card')->where(['id'=>$post['id']])->update($data)) {
	            $this->success('更新成功');
	        } else {
	            $this->error('更新失败');
	        }
        }
    }


    public function delete($id)
    {
        if (Db::name('bank_card')->where(['id'=>$id])->update(['status'=>0])) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

}