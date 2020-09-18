<?php
namespace app\api\controller;

use think\Controller;
use Session;
use Db;
use image\Image;
use Cache;
use Env;

/**
 * 通用上传接口
 * Class Upload
 * @package app\api\controller
 */
class Upload extends Controller
{
    protected function initialize()
    {
        parent::initialize();
        define('ROOT_PATH',Env::get('root_path'));
    }

    /**
     * 通用图片上传接口
     * @return \think\response\Json
     */
    public function index()
    {
        $config = [
            'size' => 2097152,
            'ext'  => 'jpg,gif,png,bmp'
        ];
        // 订单号
        if($_GET['order']){

        }

        $file = $this->request->file('file');

        $save_path   = '/public/uploads/';
        $upload_path = str_replace('\\', '/', ROOT_PATH . $save_path);
        
        $info = $file->validate($config)->move($upload_path);



        if ($info) {
            $result = [
                'error' => 0,
                'url'   => str_replace('\\', '/', $save_path . $info->getSaveName())
            ];
        } else {
            $result = [
                'error'   => 1,
                'message' => $file->getError()
            ];
        }
        return json($result);
    }
}