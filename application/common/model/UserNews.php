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

class UserNews extends Base {

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
            'news_id',
            'user_id'
        ];
    }

}