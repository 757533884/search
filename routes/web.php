<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('bbb', function () {
    return view('welcome');
});
//Route::get('demo', 'Admin\demo');
/*******基础业务********/
Route::get('/admin/base/a','Admin\BaseController@a');
Route::get('/admin/base/b','Admin\BaseController@b');
Route::get('/admin/base/c','Admin\BaseController@c');
Route::get('/admin/base/d','Admin\BaseController@d');
Route::get('/admin/base/e','Admin\BaseController@e');
Route::get('/admin/base/f','Admin\BaseController@f');
Route::get('/admin/base/g','Admin\BaseController@g');
Route::get('/admin/base/h','Admin\BaseController@h');
Route::get('/admin/base/i','Admin\BaseController@i');
Route::get('/admin/base/j','Admin\BaseController@j');
Route::get('/admin/base/k','Admin\BaseController@k');
Route::get('/admin/base/l','Admin\BaseController@l');
Route::get('/admin/base/m','Admin\BaseController@m');
Route::get('/admin/base/n','Admin\BaseController@n');
Route::get('/admin/base/o','Admin\BaseController@o');
Route::get('/admin/base/p','Admin\BaseController@p');
Route::get('/admin/base/q','Admin\BaseController@q');
Route::get('/admin/base/l','Admin\BaseController@l');
Route::get('/admin/base/s','Admin\BaseController@s');
Route::get('/admin/base/t','Admin\BaseController@t');
/*******基础业务********/

//ajax
Route::get('/index',function(){
    return view('admin/lookup/index');
});

Route::get('/response/index',function(){
    return response()->json(['name'=>'777777777','age'=>22]);
});

//获取csv
Route::get('admin/look/csv','Admin\lookUpController@readcsv');
//测试
Route::get('admin/look/demo','Admin\lookUpController@demo');
//测试2
Route::get('admin/look/demo2','Admin\lookUpController@demo2');
//测试3 函数返回值约束
Route::get('admin/look/demo3','Admin\lookUpController@demo3');
//测试4 静态变量
Route::get('admin/look/demo4','Admin\lookUpController@demo4');
//测试5 redis操作
Route::get('admin/look/demo5','Admin\lookUpController@demo5');
//测试6 随机数
Route::get('admin/look/demo6','Admin\lookUpController@demo6');
//测试7 序列化
Route::get('admin/look/demo7','Admin\lookUpController@demo7');
//测试8 生成验证码
Route::get('admin/look/demo8','Admin\lookUpController@demo8');
Route::get('admin/look/demo9','Admin\lookUpController@demo9');
Route::get('admin/look/demo10/{id}','Admin\lookUpController@demo10');
//测试11 计算时间
Route::get('admin/look/demo11','Admin\lookUpController@demo11');
//输入一个时间往前推n天
Route::get('admin/look/demo12/{time}/{day}','Admin\lookUpController@demo12');
//新认证店铺邀请人查询
Route::get('admin/look/verifyInvitation/{id}','Admin\lookUpController@verifyInvitation');
//产品库拍品佣金比例
Route::get('admin/look/depotCommission/{id}','Admin\lookUpController@depotCommission');
//用户表和认证表绑定身份证信息比对
Route::get('admin/look/userIdcardMatch/{id}','Admin\lookUpController@userIdcardMatch');
//银行卡四要素验证
Route::get('admin/look/bank_verify','Admin\lookUpController@bank_verify');
//活动大厅
Route::get('admin/look/event_hall/{uri}','Admin\lookUpController@event_hall');
//重新认证
Route::get('admin/look/verify/{phone}','Admin\lookUpController@re_verify');
//管理员--登录系统
//Route::get('admin/manage/login','Admin\ManageController@login');
//表结构
Route::get('admin/look/one','Admin\lookUpController@one');
//主要业务
Route::get('admin/look/info','Admin\lookUpController@info');
//后台展示
Route::get('admin/index/index','Admin\IndexController@index');
//测试
Route::get('admin/index/test','Admin\IndexController@test');
//后台首页--右侧
Route::get('admin/index/welcome','Admin\IndexController@welcome');
//用户列表
Route::get('admin/user/index','Admin\UserController@index');
//简单查询
Route::get('admin/look/index','Admin\LookUpController@index');
//获取用户id
Route::get('admin/look/getID/{id}','Admin\LookUpController@getID');
//获取拍品id
Route::get('admin/look/getSale/{id}','Admin\LookUpController@getSale');
//所有店铺
Route::get('admin/look/allshop/{id}','Admin\LookUpController@allshop');
//卖家 每人每天每店铺限制
Route::get('admin/look/sellerLimit/{id}','Admin\LookUpController@sellerLimit');
//买家 每人每天每店铺限制
Route::get('admin/look/buyerLimit/{id}','Admin\LookUpController@buyerLimit');
//商家扣分
Route::get('admin/look/saleScore/{id}','Admin\LookUpController@saleScore');
//用户认证积分明细
Route::get('admin/look/verifyScore/{id}','Admin\LookUpController@verifyScore');
//抽奖
Route::get('admin/look/lottery','Admin\LookUpController@lottery');
//根据订单号获取id
Route::get('admin/look/toBlance/{id}','Admin\LookUpController@toBlance');
//根据银行卡查询用户信息
Route::get('admin/look/bankCard/{id}','Admin\LookUpController@bankCard');
//被屏蔽用户数
Route::get('admin/look/blacklist/{id}','Admin\LookUpController@blacklist');
//卖家违约扣分
Route::get('admin/look/afterSale/{id}','Admin\LookUpController@afterSale');
//卖家扣分没违约
Route::get('admin/look/deduct/{id}','Admin\LookUpController@deduct');
//买家违约扣分
Route::get('admin/look/buySale/{id}/{type}','Admin\LookUpController@buySale');
//卖家违约拍品
Route::get('admin/look/saleId/{id}','Admin\LookUpController@saleId');
//买家退货
Route::get('admin/look/returned','Admin\LookUpController@returned');
//冻结余额
Route::get('admin/look/frozen','Admin\LookUpController@frozen');
//银行卡验证
Route::get('admin/look/bankVerify','Admin\LookUpController@bankVerify');
//银行卡信息
Route::get('admin/look/bankInfo','Admin\LookUpController@bankInfo');
//当面交易查询
Route::get('admin/look/faceTrade/{id}','Admin\LookUpController@faceTrade');
//售假
Route::get('admin/look/sellOff','Admin\LookUpController@sellOff');
//格式化id
Route::get('admin/look/formatId','Admin\LookUpController@formatId');
//多人中拍
Route::get('admin/look/win/{id}','Admin\LookUpController@win');
//橱窗投放次数
Route::get('admin/look/windows','Admin\LookUpController@windows');
//获取封店商家信息
Route::get('admin/look/forbidden','Admin\LookUpController@forbidden');
//报表成拍金额
Route::get('admin/look/order','Admin\LookUpController@order');
//橱窗购买明细
Route::get('admin/look/buyWindows/{id}','Admin\LookUpController@buyWindows');
//15天成交笔数
Route::get('admin/look/paid/{id}','Admin\LookUpController@paid');
//同天买卖家完成的单子
Route::get('admin/look/sameDayList/{id}','Admin\LookUpController@sameDayList');
//15天退款单子
Route::get('admin/look/sell_returned/{id}','Admin\LookUpController@sell_returned');
//15天完成单子
Route::get('admin/look/sell_finished/{id}','Admin\LookUpController@sell_finished');
//某天成拍报表金额
Route::get('admin/look/endSalePrice/{id}/{date}','Admin\LookUpController@endSalePrice');
//用户昵称
Route::get('admin/look/nickname/{id}','Admin\LookUpController@nickname');
//ocr
Route::get('admin/look/ocr','Admin\LookUpController@ocr');

//获取刷单接口
Route::get('admin/look/shuadan_sale/{id}','Admin\LookUpController@shuadan_sale');

/**
 * Redis测试
 */
Route::get('admin/redis/demo1','Admin\RedisController@demo1');



