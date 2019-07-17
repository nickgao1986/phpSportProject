<?php
/**
 * Created by PhpStorm.
 * User: gaoyoujian
 * Date: 2018/12/11
 * Time: 下午4:47
 */
namespace app\api\controller\v1;

use app\api\controller\Common;
use think\Controller;
use app\common\lib\exception\ApiException;
use app\common\lib\Aes;


class Books extends Controller
{

    public function index()
    {
        $data = input('get.');
        $result = model('Books')->getBooks();
        return show(0,'',$result,200);
    }

    public function save()
    {
        $postData  =  input('param.');
        halt($postData);
        if(empty($postData["bookid"])) {
            $parseJson = json_decode($postData["book"]);
            halt($parseJson);
            $data = [];
            $data['bookName'] = $postData["bookName"];
            $data['book_description'] = $postData["bookDescription"];
            //$data['icon'] = "http://pij4ed5ao.bkt.clouddn.com/book1.jpg";
            try {
                model('Books')->add($data);
                return show(0,'',[],200);
            }catch (\Exception $e) {
                return show(config('code.error'), $e->getMessage(), [], 500);
            }
        }else{
            try {
                model('Books')->save([
                    'bookName' => $postData["bookName"]
                ],[
                    'bookid' => $postData["bookid"]
                ]);
                return show(0,'',[],200);
            }catch (\Exception $e) {
                return show(config('code.error'), $e->getMessage(), [], 500);
            }
        }


        return null;
    }


    public function delete() {
        $id = input('delete.bookid', 0, 'intval');
        if(empty($id)) {
            return show(config('code.error'), 'id不存在', [], 404);
        }

        $data = [
            'bookid' => $id,
        ];
        // 查询库里面是否存在 点赞
        $userNews = model('Books')->get($data);
        if(empty($userNews)) {
            return show(config('code.error'), '没有这条记录', [], 401);
        }

        try {
            model('Books')
                ->where($data)
                ->delete();
        }catch (\Exception $e) {
            return show(config('code.error'), '内部错误 点赞失败', [], 500);
        }
    }


    public function update() {
        $putData  =  input('param.');
        try {
            model('Books')->save([
                'bookName' => $putData["bookName"]
            ],[
                'bookid' => $putData["bookid"]
            ]);

        }catch (\Exception $e) {
            return show(config('code.error'), $e->getMessage(), [], 500);
        }
        return null;
    }




}