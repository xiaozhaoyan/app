<?php
/**
 * Created by PhpStorm.
 * User: Dalei
 * Date: 2018/8/26
 * Time: 22:40
 */

namespace Home\Controller;

/*
 * 寻找简历接口
 *
 * @found   主页面接口
 * @reg     地区筛选接口
 * @job     职位筛选接口
 * @find    搜索接口
 * */
class TofyrController extends HomeController{

    /*
     * 找简历/主页面接口
     *
     * @return varchar picture      头像
     * @return varchar name         姓名
     * @return varchar gender       性别
     * @return varchar mobile       手机
     * @return int age              年龄
     * @return varchar education    学历
     * @return varchar worktime     工作经验
     * @return varchar region       期望地区
     * @return varchar jobinten     期望工作
     * @['resume']      简历信息表
     * */
    public function found(){
        $resu = array('code' => 1,'msg' => '数据查询成功!','data' => array());
        //查询数据表,并且保留需要的字段信息
        $list = M('resume')
            ->field('picture,name,gender,age,education,worktime,region,jobinten,year,mobile')
            ->select();
        if($list){
            $resu['data'] = $list;
        }else{
            $resu['code'] = 2;
            $resu['msg']  ='数据查询失败!';
        }
        $this->ajaxReturn($resu);
    }
    /*
     * 找简历/地区筛选接口
     *
     * @params varchar region      期望地区
     * @return varchar picture     头像
     * @return varchar name        姓名
     * @return varchar gender      性别
     * @return int age             年龄
     * @return varchar education   学历
     * @return varchar worktime    工作经验
     * @return varchar region      期望地区
     * @return varchar jobinten    期望职位
     * @['resume']      简历信息表
     * */
    public function reg(){
        $resu = array('code' => 1,'msg' => '数据查询成功!','data' => array());
        $list = M('resume')
            ->where(array('region' => $_POST['region']))
            ->field('picture,name,gender,age,education,worktime,region,jobinten,year')
            ->select();

        if($list){
            $resu['data'] = $list;
        }else{
            $resu['code'] = 2;
            $resu['msg']  ='数据查询失败!';
        }
        $this->ajaxReturn($resu);
    }
    /*
     * 找简历/职位筛选接口
     *
     * @params varchar jobinten     职位信息
     * @return varchar picture     头像
     * @return varchar name        姓名
     * @return varchar gender      性别
     * @return int age             年龄
     * @return varchar education   学历
     * @return varchar worktime    工作经验
     * @return varchar region      期望地区
     * @return varchar jobinten    期望职位
     * @['resume']      简历信息表
     * */
    public function job(){
        $resu = array('code' => 1,'msg' => '数据查询成功!','data' => array());
        $dt = M('resume');
        $arr = array('region' => $_POST['region']);
        $brr = array('jobinten' => $_POST['jobinten']);
        $crr = array($arr,$brr);
        $zhiwei = $dt
            ->where($crr)
            ->field('picture,name,gender,age,education,worktime,region,jobinten,year')
            ->select();

        if($zhiwei){
            $resu['data'] = $zhiwei;
        }else{
            $resu['code'] = 2;
            $resu['msg']  ='数据查询失败!';
        }
        $this->ajaxReturn($resu);
    }
    /*
     * 找简历/搜索接口
     *
     * @params varchar jobinten     职位信息
     * @return varchar picture     头像
     * @return varchar name        姓名
     * @return varchar gender      性别
     * @return int age             年龄
     * @return varchar education   学历
     * @return varchar worktime    工作经验
     * @return varchar region      期望地区
     * @return varchar keyword     搜索框内容
     * @['resume']      简历信息表
     * */
    public function find(){
        $resu = array('code' => 1,'msg' => '数据查询成功!','data' => array());
        //先使用模糊查询将值赋给变量$data
        $data['jobinten']=array("like","%".$_POST['keyword']."%");
        $list = M('resume')//主要是公司通过岗位来查询简历
            ->where($data)
            ->field('picture,name,gender,age,education,worktime,region,jobinten,year')
            ->select();

        if($list){
            $resu['data'] = $list;
        }else{
            $resu['code'] = 2;
            $resu['msg']  ='数据查询失败!';
        }
        $this->ajaxReturn($resu);
    }
}