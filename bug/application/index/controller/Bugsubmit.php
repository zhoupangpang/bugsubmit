<?php
namespace app\index\controller;

use think\Config;
use think\Controller;
use think\Db;
use think\Exception;
use think\Request;

class Bugsubmit extends Controller
{
    //显示bug列表
    public function index()
    {
        $data = input();
        if(isset($data['token']) && $data['token'] == '123456') {
            try{
                $res = Db::name('bugsubmit')
                    ->field('id,title,isSolve,time,name,connect')
                    ->order('time', 'desc')
                    ->select();
                return view('index', ['list' => $res, 'data' => $data['token']]);
            }catch(Exception $e) {
                $this->error('获取列表失败');
            }
        } else{
            try{
                $res = Db::name('bugsubmit')
                    ->field('id,title,isSolve,time,name,connect')
                    ->order('time', 'desc')
                    ->select();
                return view('index', ['list' => $res, 'data' => 0]);
            }catch(Exception $e) {
                $this->error('获取列表失败');
            }
        }

    }

    //发表bug
    public function setbug()
    {
        //获取数据
        $data = input();
        if(empty($data)) {
            return view('addBug');
        }else {
            //存入数据库
            $data['isSolve']  = 0;
            $data['time'] = time();
            $res = Db::name('bugsubmit')->insert($data);
            if($res) {
                return "提交成功";
            }else {
                return "提交失败";
            }
        }

    }

    //显示bug详情
    public function getdetail()
    {
        $input = input();
        $res = Db::name('bugsubmit')
            ->where('id', $input['id'])
            ->select();
        if($res) {
            return view('detail', ['data' => $res[0]]);
        }else {
            $this->error('获取详情失败');
        }
    }

    //删除bug
    public function deletebug()
    {
        $input = input();
        $res = Db::name('bugsubmit')
            ->where('id', $input['id'])
            ->delete();
        if($res) {
            return "删除成功";
        }else {
            return "删除失败";
        }
    }

    //更新bug为已解决
    public function updatebug()
    {
        $input = input();
        $row = Db::name('bugsubmit')
            ->where('id', $input['id'])
            ->column('isSolve');
        if($row[0] == 1) {
            return 1;
        }
        $res = Db::name('bugsubmit')
            ->where('id', $input['id'])
            ->update(['isSolve' => 1]);
        if($res) {
            return 1;
        }else {
            return 0;
        }
    }
}