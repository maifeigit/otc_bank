<?php
namespace app\common\controller;

use think\Controller;
use Env;
use Db;
use Cache;


/*
 * 小程序基类
 */
class AppletBase extends Controller
{
    // 初始化方法
    protected function initialize()
    {
        parent::initialize();

		define('ROOT_PATH',Env::get('root_path'));
		define('DS',DIRECTORY_SEPARATOR); 
    }

}