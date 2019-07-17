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

class News extends Common {

    public function index() {
        // 小伙伴仿照我们之前讲解的validate验证机制 去做相关校验
        $data = input('get.');

        $whereData['status'] = 0;
        if(!empty($data['catid'])) {
            $whereData['catid'] = input('get.catid', 0, 'intval');
        }
        if(!empty($data['title'])) {
            $whereData['title'] = ['like', '%'.$data['title'].'%'];
        }
        $this->getPageAndSize($data);
        $total = model('News')->getNewsCountByCondition($whereData);
        $news = model('News')->getNewsByCondition($whereData, $this->from, $this->size);

        $result = [
            'total' => $total,
            'page_num' => ceil($total / $this->size),
            'list' => $this->getDealNews($news),
        ];

        return show(config('code.success'), 'OK', $result, 200);
    }

    /**
     * 获取详情接口
     */
    public function read() {
        // 详情页面 APP -》 1、x.com/3.html  2、 接口

        $id = input('param.id', 0, 'intval');
//        halt($id);die;
        if(empty($id)) {
            return new ApiException('id is not ', 404);
        }

        // 通过id 去获取数据表里面的数据
        // try catch untodo
        $news = model('News')->get($id);
        if(empty($news) || $news->status != config('code.status_normal')) {
            return new ApiException('不存在该新闻', 404);
        }

        try {
            model('News')->where(['id' => $id])->setInc('read_count');
        }catch(\Exception $e) {
            return new ApiException('error', 400);
        }

        $cats = config('cat.lists');
        $news->catname = $cats[$news->catid];
        return show(config('code.success'), 'OK', $news, 200);
    }

    public function save()
    {
        $data = input('post.', []);
        $data['title'] = "运动健身计划_男性健康运动_男士减肥方法";
        $data['catid'] = 9;
        $data['image'] = 'http://psfzl2l3l.bkt.clouddn.com/pedo_item_pic_1.png';
        //入库操作
        $id = model('News')->add($data);

//        $data['title'] = "运动健身中的五个误区";
//        $data['catid'] = 2;
//        $data['image'] = 'http://psfzl2l3l.bkt.clouddn.com/pedo_item_pic_2.png';
//        //入库操作
//        $id = model('News')->add($data);

//        $data['title'] = "做到这4点,从此你就能坚持运动健身!";
//        $data['catid'] = 2;
//        $data['image'] = 'http://psfzl2l3l.bkt.clouddn.com/pedo_item_pic_3.png';
//        //入库操作
//        $id = model('News')->add($data);
//
//        $data['title'] = "健身能给人带来什么好处?一起来见识,大家都要运动的原因";
//        $data['catid'] = 2;
//        $data['image'] = 'http://psfzl2l3l.bkt.clouddn.com/pedo_item_pic_4.png';
//        //入库操作
//        $id = model('News')->add($data);
//
//        $data['title'] = "健身俱乐部经营成功的秘诀";
//        $data['catid'] = 2;
//        $data['image'] = 'http://psfzl2l3l.bkt.clouddn.com/pedo_item_pic_5.png';
//        //入库操作
//        $id =  model('News')->add($data);

//        $data['title'] = "短时间燃烧脂肪";
//        $data['catid'] = 1;
//        $data['image'] = 'http://psfzl2l3l.bkt.clouddn.com/pedo_item_pic_6.png';
//        //入库操作
//        $id = model('News')->add($data);
//
//        $data['title'] = "运动状态下高速剧烈";
//        $data['catid'] = 1;
//        $data['image'] = 'http://psfzl2l3l.bkt.clouddn.com/pedo_item_pic_3.png';
//        //入库操作
//        $id = model('News')->add($data);
////
//        $data['title'] = "受大众欢迎的运动";
//        $data['catid'] = 1;
//        $data['image'] = 'http://psfzl2l3l.bkt.clouddn.com/pedo_item_pic_1.png';
//        //入库操作
//         model('News')->add($data);
//
//        $data['title'] = "以跑步机动感单车为例";
//        $data['catid'] = 1;
//        $data['image'] = 'http://psfzl2l3l.bkt.clouddn.com/pedo_item_pic_4.png';
//        //入库操作
//        $id =model('News')->add($data);


//        $data['title'] = "健身运动是一项通过徒手或利用各种器械，运用专门的动作方式和方法进行锻炼";
//        $data['catid'] = 1;
//        $data['image'] = 'http://psfzl2l3l.bkt.clouddn.com/pedo_item_pic_6.png';
//        //入库操作
//        $id =model('News')->add($data);

//            try {
//                $id = model('News')->add($data);
//            }catch (\Exception $e) {
//                return $this->result('', 0, '新增失败11');
//            }

        if($id) {
            return $this->result(['jump_url' => url('news/index')], 1, 'OK');
        } else {
            return $this->result('', 0, '新增失败222');
        }
    }

}