<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 17/7/27
 * Time: 下午5:57
 */
namespace app\common\model;
use think\Model;
use app\common\model\Base;

class Books extends Model {


    public function getBooks($data = []) {

        $result = $this->select();
        return $result;
    }

    public function add($data) {
//        if(!is_array($data)) {
//            exception('传递数据不合法');
//        }
        $this->allowField(true)->save($data);

        return null;
    }


}