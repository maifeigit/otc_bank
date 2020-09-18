<?php
namespace app\common\controller;

use think\Controller;
use Cache;
use Session;
use Db;
use View;
use Env;

class HomeBase extends Controller
{
    public $lang = 'zh';

    protected function initialize()
    {
        parent::initialize();
        // 语言
        if(Cache::get('lang')){
            // $this->lang = (Cache::get('lang')=='zh-cn') ? 'zh' : 'en';
        }
        // 语言切换
        if($this->lang=='zh'){
            $langUrl = '?lang=en-us';
            $langTxt = 'English';
        } else {
            $langUrl = '?lang=zh-cn';
            $langTxt = '中文';
        }
        View::share('langUrl',$langUrl);
        View::share('langTxt',$langTxt);
        // 配置
        $this->system();


        define('ROOT_PATH',Env::get('root_path'));
        define('DS',DIRECTORY_SEPARATOR); 
    }

    /**
     * 获取导航列表
     */
    public function get_category_list($lang='zh')
    {
        if(Cache::get('category_'.$lang)){
            return Cache::get('category_'.$lang);
        }else {
            return $this->category_cache($lang);
        }
    }

    /**
     * 分类缓存
     */
    public function category_cache($lang='zh')
    {
        $data = Db::name('article_category')->cache(true,600)->field('id,name,alias')->where(['pid'=>0])->select();
        foreach($data as $K=>$v){
            // 中文导航
            $category_zh[] = [
                'id'    => $v['id'],
                'name'  => $v['name'],
            ];
            // 英文导航
            $category_en[] = [
                'id'    => $v['id'],
                'name'  => $v['alias'],
            ];
        }
        Cache::set('category_zh', $category_zh);
        Cache::set('category_en', $category_en);
        return $lang=='zh' ? $category_zh : $category_en;
    }

    /**
     * 系统配置
     */
    public function system()
    {
        $config = Db::name('system')->cache(true,600)->column('value','name');
        View::share('config',$config);
    }
}