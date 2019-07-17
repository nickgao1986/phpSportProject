<?php
/**
 * Created by PhpStorm.
 * User: gaoyoujian
 * Date: 2019/6/15
 * Time: 上午7:00
 */
namespace app\api\controller\v1;

use app\api\controller\Common;
use think\Controller;
use app\common\lib\exception\ApiException;
use app\common\lib\Aes;
use app\common\lib\IAuth;
class Contact extends AuthBase {

    public function index()
    {
        $result = model('Contact')->getContacts();
        return show(0,'',$result,200);
    }

    public function save() {
        $id = input('post.id', 0 , 'intval');
        if(empty($id)) {
            return show(config('code.error'), 'id不存在', [], 404);
        }
        $data = [
            'user_id' => $id,
            'username' => '小松鼠的妈妈',
        ];


        try {
            $userNewsId = model('Contact')->add($data);

            if($userNewsId) {
                return show(config('code.success'), 'OK', [], 202);
            }else {
                return show(config('code.error'), '内部错误', [], 500);
            }
        }catch (\Exception $e) {
            echo $e->getMessage();die;
            return show(config('code.error'), '内部错误', [], 500);
        }

    }
}