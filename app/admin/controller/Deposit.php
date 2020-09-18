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

    public function index($page=1)
    {
        $dataList = Db::name('deposit')->paginate(10, false, ['page'=>$page]);
        return $this->fetch('index', ['dataList' => $dataList]);
    }


}