<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use OT\DataDictionary;

/**
 * 我的页面
 * enterprise   企业认证接口
 * resume       简历发布接口
 * mine         我的简历接口
 * regin        登录页面接口
 * sett         账户设置接口
 */
class HumanController extends HomeController{

    /*
     * 企业认证接口
     *
     * @params varchar HTTP_TOKEN       获取前端的token
     * @params varchar companyname      公司名称
     * @params varchar picture          公司图片
     * @params varchar creditcode       社会统一信用代码
     * @params varchar name             联系人
     * @params varchar mobile           手机
     * @params varchar phone            座机
     * @params varchar site             地址
     * @params varchar companyprofile   公司地址
     * @['company']       数据库中的公司信息表
     * */
    public function enterprise(){
        $resu = array('code' => 1,'msg' => '数据查询成功!','data' => array());

        $tokk = $_SERVER['HTTP_TOKEN'];
        $toke = json_decode(base64_decode($tokk),true);//解密token
        $mobile = $toke['mobile'];//赋值
        $check = $this->checktokens();

        //获取前台请求数据
        $companyname = $_POST['companyname'];
        $picture = $_POST['picture'];
        $creditcode = $_POST['creditcode'];
        $name = $_POST['name'];
        $mobi = $mobile;
        $phone = $_POST['phone'];
        $site = $_POST['site'];
        $companyprofile = $_POST['companyprofile'];
        //将获取的参数和数据库字段做匹配
        $ary = array(
            'companyname' => $companyname,
            'picture' => $picture,
            'creditcode' => $creditcode,
            'name' => $name,
            'mobile' => $mobi,
            'phone' => $phone,
            'site' => $site,
            'companyprofile' => $companyprofile
        );
        if($check = true){
            if ($companyname != NULL
                && $creditcode != NULL
                && $name != NULL
                && $mobile != NULL
                && $phone != NULL
                && $site != NULL
                && $companyprofile != NULL) {

                $list = M('company')->where(array('mobile' => $mobile))->find();

                if ($list) {
                    $resu['code'] = 0;
                    M('company')->sava($ary);
                    $resu['msg'] = '已更新该公司认证信息!';
                } else {
                    M('company')->add($ary);
                    $resu['msg'] = '提交认证信息成功!';
                }

            }else{
                $resu['code'] = 2;
                $resu['msg'] = '请输入认证信息信息!';
            }
        }
        $this->ajaxReturn($resu);
    }
    /*
    * 简历发布接口
     *
     * @params varchar HTTP_TOKEN       获取前端的token
     * @return varchar name           姓名
     * @return varchar gender         性别
     * @return varchar jobinten       求职意向
     * @return varchar mobile         手机号码
     * @return varchar email          邮箱
     * @return varchar region         期望地区
     * @return varchar education      学历
     * @return varchar pay            期望薪资
     * @return varchar worktime       工作时间
     * @return varchar position       职位
     * @return varchar company        公司名称
     * @return varchar studytime      学习时间
     * @return varchar major          专业
     * @return varchar school         学校
     * @return varchar self           自我评价
     * @['resume']      简历信息表
    * */
    public function resume(){
        $resu = array('code' => 1,'msg' => '简历发布成功!','data' => array());

        $tokk = $_SERVER['HTTP_TOKEN'];
        $toke = json_decode(base64_decode($tokk),true);//解密token
        $mobile = $toke['mobile'];//赋值
        $check = $this->checktokens();
        $arr = array('mobile' => $mobile,);
        if($check != true){
            $resu['code'] =2;
            $resu['msg'] ='请先登录!';
        }else{
            $db = M('resume');
            //获取前台参数并且查询相关号码的所有信息
            $select = $db->where(array('mobile' => $mobile))->find();
            if($select == null){
                $ad = $db->add($arr);
            }
            //如果前台传送过来的电话号码已存在于数据库中,那么先匹配数据库中相对应的字段
            if($select or $ad){
                $data['name'] = $_POST['name'];
                $data['title'] = $_POST['title'];
                $data['gender'] = $_POST['gender'];
                $data['jobinten'] = $_POST['jobinten'];
                $data['email'] = $_POST['email'];
                $data['region'] = $_POST['region'];
                $data['education'] = $_POST['education'];
                $data['pay'] = $_POST['pay'];
                $data['worktime'] = $_POST['worktime'];
                $data['position'] = $_POST['position'];
                $data['company'] = $_POST['company'];
                $data['studytime'] = $_POST['studytime'];
                $data['major'] = $_POST['major'];
                $data['school'] = $_POST['school'];
                $data['self'] = $_POST['self'];
                //如果已有相同的数据,则更新不相同的数据
                $result=$db->where(array('mobile' => $mobile))->save($data);
                //如果更新成功那么返回信息
                if($result){

                }else{
                    $resu['code'] = 2;
                    $resu['msg'] = '提交失败!';
                }

            }else{
                $resu['code'] = 3;
                $resu['msg'] = '创建失败请重试!';
            }
        }
        $this->ajaxReturn($resu);
    }
    /*
     * 我的简历接口
     *
     * 此接口主要是用于展示给客户自己的简历
     *
     * @params varchar mobile       电话号码
     * $this->checktokens()         调用父类方法检查token是否存在
     * @['resume']                  简历表
     * @return json $db             简历信息
    * */
    public function mine(){
        $resu = array('code' => 1,'msg' => '获取数据成功!','data' => array());
        $tokk = $_SERVER['HTTP_TOKEN'];
        $toke = json_decode(base64_decode($tokk),true);//解密token
        $mobile = $toke['mobile'];//赋值
        $check = $this->checktokens();
        if($check != true){
            $resu['code'] =2;
            $resu['msg'] ='请先登录!';
        }else{
            //通过$mobile来查询跟号码相关的token
            $tok = M('personal')->where(array('mobile' => $mobile))->field('token')->find();
            $yy = implode($tok);
            if($yy != $tokk){
                $resu['code'] =4;
                $resu['msg'] ='请先登录!';
            }else{
                //通过$mobile来查询跟号码相关的所有信息
                $db = M('resume')->where(array('mobile' => $mobile))->find();
                //如果查询到相信数据,则返回前端展示
                if($db){
                    $resu['data'] = $db;
                }else{
                    $resu['code'] = 3;
                    $resu['msg']  ='您还没有创建简历!';
                }
            }

        }
        $this->ajaxReturn($resu);
    }

    /*
   * 职位发布接口
    *
    * @params varchar HTTP_TOKEN       获取前端的token
    * @return varchar jobinten           职位
    * @return varchar pay         月薪
    * @return varchar education       学历
    * @return varchar years         工作年限
    * @return varchar jobfield          地区
    * @return varchar site         公司地址
    * @return varchar mobile      联系电话
    * @return varchar describe            职位详情
     *     * @return varchar fulltime            全职/兼职
    * @['company']      职位信息表
   * */
    public function posits(){
        $resu = array('code' => 1,'msg' => '发布成功!','data' => array());
        $dt = M('company');
        $check = $this->checktokens();
        //获取前台请求数据
        $title = $_POST['title'];
        $jobinten = $_POST['jobinten'];
        $jobtitle = $_POST['jobtitle'];
        $pay = $_POST['pay'];
        $requirement = $_POST['requirement'];
        $companyname = $_POST['companyname'];
        $years = $_POST['years'];
        $jobfield = $_POST['jobfield'];
        $site = $_POST['site'];
        $mobile = $_POST['mobile'];
        $describe = $_POST['describe'];
        $fulltime = $_POST['fulltime'];
        //将获取的参数和数据库字段做匹配
        $ary = array(
            'title' => $title,
            'jobinten' => $jobinten,
            'jobtitle' => $jobtitle,
            'pay' => $pay,
            'requirement' => $requirement,
            'companyname' => $companyname,
            'years' => $years,
            'jobfield' => $jobfield,
            'site' => $site,
            'mobile' => $mobile,
            'describe' => $describe,
            'fulltime' => $fulltime,
        );
        if($check = true){
            if ($jobinten != NULL
                && $title != NULL
                && $jobtitle != NULL
                && $pay != NULL
                && $requirement != NULL
                && $companyname != NULL
                && $years != NULL
                && $jobfield != NULL
                && $site != NULL
                && $mobile != NULL
                && $describe != NULL
                && $fulltime != NULL
            ) {
                $list = $dt->add($ary);
                if ($list) {

                } else {
                    $resu['code'] = 2;
                    $resu['msg']  ='发布失败!';
                }
            }else{
                $resu['code'] = 2;
                $resu['msg']  ='请填写完整信息!';
            }
        }
        $this->ajaxReturn($resu);
    }
    /*
     * 简历详情
     *
     * */
    public function jianli(){
        $resu = array('code' => 1,'msg' => '获取数据成功!','data' => array());
        $mobile = $_POST['mobile'];
        $arr = array('mobile' => $mobile);
        $db = M('resume');
        $list = $db->where($arr)->find();
        if($list){
            $resu = array('code' => 1,'msg' => '!','data' => array());
            $resu['data'] = $list;
        }
        $this->ajaxReturn( $resu);
    }

    
    
    
    /*
     * 发送短信接口
     *
     * */
    public function yanzhengma(){

        $resu = array('code' => 1,'msg' => '登陆成功','data' => array());

        $sendUrl = 'http://v.juhe.cn/sms/send'; //短信接口的URL
        $yanzheng = rand(100000,999999);//定义一个随机六位数的变量
        $smsConf = array(
            'key'   => '5ff30d5a8e99e043e3a245d69810b7dd', //您申请的APPKEY
            'mobile'    => $_POST['mobile'], //接受短信的用户手机号码
            'tpl_id'    => '98177', //您申请的短信模板ID，根据实际情况修改
            'tpl_value' => '#code#='.$yanzheng //您设置的模板变量，根据实际情况修改
        );
        $dt = M('personal');
        $data['yanzhengma'] = $yanzheng;
        $where = array('mobile' => $_POST['mobile']);
        $ff = $dt->where($where)->save($data);
        $_SESSION[$smsConf['mobile']] = $yanzheng;//将验证码绑定在发送验证码的手机上
//        var_dump($yanzheng);exit;
        $content = $this->juhecurl($sendUrl,$smsConf,1); //请求发送短信
        if($content){
            $result = json_decode($content,true);
            $error_code = $result['error_code'];
            if($error_code == 0){//状态为0，说明短信发送成功
                $resu['msg'] = '短信发送成功,短信ID：'.$result['result']['sid'];
            }else{//状态非0，说明失败
                $msg = $result['reason'];
                $resu['code'] = 2;
                $resu['msg'] = "短信发送失败(".$error_code.")：".$msg;
            }
        }else {
            $resu['code'] = 2;
            $resu['msg'] = "短信发送失败";
        }
        $this -> ajaxReturn($resu);
    }
    /*
     * 登录页面接口
     *
     * @params varchar mobile     电话号码
     * @params varchar pwd   验证码
     * */
    public function login(){

        $resu = array('code' => 1,'msg' => '登陆成功','data' => array());
        $mob = array('mobile' => $_POST['mobile']);
        $note = $_POST['pwd'];
        $db = M('personal');//实例化personal表
        $token = array(//接受电话号码并且创建token登陆时间和退出时间
            'mobile' => $_POST['mobile'],
            'ctime' => time(),
            'out_time' => (time()+36000*24*7)
        );
        $toke = base64_encode(json_encode($token));//加密token
        $data['ctime'] = $token['ctime'];
        $data['token'] = $toke;

        $arr = array(
            'mobile' => $_POST['mobile'],
            'ctime' => $data['ctime'],
            'token' => $data['token']);//将获取的电话号码和数据库字段进行匹配

        $yanzhengma = $db->where($mob)->field('yanzhengma')->find();
        //$yanzheng = $_SESSION[$_POST['mobile']];//调取验证码的值
        $yanzheng = implode($yanzhengma);
        if($mob) { //如果能够获取电话号码,就将电话号码传入数据库进行查询
            $list = $db->where($mob)->find();
            if ($list){
                if($yanzheng == $note){//如果验证码匹配那就登陆成功
                    $db->where($mob)->save($data);
                    $resu['data'] = $toke;
                    //session_unset($yanzheng);//销毁session
                    $db->where($mob)->save(array('yanzhengma' => ''));
                }else{
                    $resu['code'] = 2;
                    $resu['msg'] = '登录失败,验证码或手机号错误!';
                };
            }else{
                $db->add($arr);//如果不能查询到相同的电话号码,那么就添加数据
                $resu['code'] = 1;
                $resu['data'] = $toke;
            }
        }
        $this -> ajaxReturn($resu);
    }
    /*
     * 账户设置
     * */
    public function sett(){
        $resu = array('code' => 1,'msg' => '个人信息获取成功!','data' => array());
        $tokk = $_SERVER['HTTP_TOKEN'];
        $toke = json_decode(base64_decode($tokk),true);//解密token
        $mobile = $toke['mobile'];//赋值


        $arr = array('mobile' =>$mobile);
        $check = $this->checktokens();
        $list = M('personal')->where($arr)->field('email,mobile')->find();

        if($list && $check == true){
            $resu['data'] = $list;
        }else{
            $resu['code'] = 2;
            $resu['msg'] = '请先登录!';
        }
        $this->ajaxReturn($resu);
    }
    /*
     * 退出账户
     * */
    public function loginout(){
        $resu = array('code' => 1,'msg' => '退出成功!');
        $tokk = $_SERVER['HTTP_TOKEN'];
        $toke = json_decode(base64_decode($tokk),true);//解密token
        $mobile = $toke['mobile'];//赋值
        $db = M('personal')->where(array('mobile' => $mobile))->save(array('token' => ''));
        if($db){

        }else{
            $resu['code'] = 2;
            $resu['msg'] = '退出失败!';
        }
        $this->ajaxReturn($resu);

    }
}
