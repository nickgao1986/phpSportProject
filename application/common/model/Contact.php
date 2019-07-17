<?php
/**
 * Created by PhpStorm.
 * User: gaoyoujian
 * Date: 2019/6/15
 * Time: 上午6:58
 */

namespace app\common\model;
use think\Model;
use app\common\model\Base;

class Contact extends Base {

    public function getContacts($data = []) {

        $result = $this->select();
        return $result;
    }

    public function getUserNewsByCondition($condition = [], $from=0, $size = 20) {
        $result = $this->where($condition)
            ->field($this->_getListField())
            ->limit($from, $size)
            ->select();
        return $result;
    }

    private function _getListField() {
        return [
            'id',
            'username',
            'avatar',
            'user_id'
        ];
    }



}