<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 17/8/5
 * Time: 下午4:37
 */
namespace app\api\controller\v1;

use app\api\controller\Common;
use think\Controller;
use app\common\lib\exception\ApiException;
use app\common\lib\Aes;
use app\common\lib\Upload;
use app\common\lib\Alidayu;

class Image extends Common {

    public function save() {
        halt($this->headers);

        print_r($_FILES);
//        $image = Upload::image();
//        if($image) {
//           return show(config('code.success'), 'ok', config('qiniu.image_url').'/'.$image);
//        }
        //Alidayu::getInstance()->sendSms();
    }
}