<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 17/8/5
 * Time: 下午4:37
 */
namespace app\api\controller;

use app\common\lib\IAuth;
use think\Controller;
use app\common\lib\exception\ApiException;
use app\common\lib\Aes;
use ali\top\TopClient;
use ali\top\request\AlibabaAliqinFcSmsNumSendRequest;
use app\common\lib\Alidayu;
use think\Exception;

class Test extends Common {

    public function index() {

        $animal = array('east'=>'tiger','north'=>'wolf','south'=>'monkey');
        $data =  [
            'status'  => 200,
            'message' => 'OK',
            'data'    => $animal,
        ];
        return show(200,'ok',$animal,201);
    }

    public function update($id = 0) {
        //echo $id;exit;
        halt(input('put.'));
        //return $id;
        //id   data
    }

    /**
     * post 新增
     * @return mixed
     */
    public function save() {

        // 获取到提交数据 插入库，
        // 给客户端APP  =》 接口数据
//        return show(1, 'OK', (new Aes())->encrypt(json_encode(input('post.'))), 201);
        $data1 = input('post.');
        if($data1['mt'] != 1) {
            throw new ApiException("你的提交不合法",300);
        }

        $data =  [
            'status'  => 1,
            'message' => 'OK',
            'data'    => input('post.'),
        ];
        return show(1,'ok',input('post.'),201);
    }

    /**
     * 发送短信测试场景
     */
    public function sendSms() {
        $c = new TopClient;
        $c->appkey = "24528979";
        $c->secretKey = "ec6d90dc7e93b4cc824183f71710e1ee";
        $req = new AlibabaAliqinFcSmsNumSendRequest;
        $req->setExtend("123456");
        $req->setSmsType("normal");
        $req->setSmsFreeSignName("singwa娱乐app");
        $req->setSmsParam("{\"number\":\"4567\"}");
        $req->setRecNum("18618158941");
        $req->setSmsTemplateCode("SMS_75915048");
        $resp = $c->execute($req);
        halt($resp);
    }

    public function testsend() {
        Alidayu::getInstance()->setSmsIdentify('18618158941');
    }

    ///  APP登录和web
    // web phpsessionid  , app -> token(唯一性) ，在登录状态下 所有的请求必须带token, token-》失效时间

    public function token() {
        echo IAuth::setAppLoginToken();
    }

}