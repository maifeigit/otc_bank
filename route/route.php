<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------


// 天浪资管
Route::rule('about','index/Index/about');
// 天浪思投
Route::rule('fundseeder','index/Index/fundseeder');
// 基金平台
Route::rule('fund','index/Index/fund');
// 解决方案
Route::rule('solutions','index/Index/solutions');
// 常见问题
Route::rule('faqs','index/Index/faqs');
// 联系我们
Route::rule('contact','index/Index/contact');
// 免责声明
Route::rule('disclaimer','index/Index/disclaimer');
// 隐私声明
Route::rule('privacy','index/Index/privacy');

// 新闻详情
Route::get('detail/:id', 'news/detail')->pattern(['id'=>'\d+']);



