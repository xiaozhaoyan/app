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
 * 首页接口
 * @people      个人认证接口
 * @picture     首页/公告和照片接口
 * @fulltime    全职和兼职招聘接口
 * @famous      名企招聘接口
 * @hot          热门职位接口
 * @recommend   推荐职位接口
 * @found       首页搜索框接口
 */
class IndexController extends HomeController{
    /*
     * 个人认证接口/查询
     *
     **/
    public function query(){
        $dt = M('personal');// 实例化模型类,参数数据表名称
        $resu = array('code' => 1,'msg' => '','data' => array());
        $tokk = $_SERVER['HTTP_TOKEN'];
        $toke = json_decode(base64_decode($tokk),true);//解密token
        $mobile = $toke['mobile'];//赋值
        $check = $this->checktokens();
        $where = array('mobile' => $mobile);
        if($check != true){
            $resu['code'] =2;
            $resu['msg'] ='请先登录!';
        } else {
            $data = $dt->where($where)->find();
//            var_dump($data);exit;
            if ($data) {
                $resu['msg'] = '个人信息查询成功!';
                $resu['data'] = $data;
            } else {
                $resu['code'] = 2;
                $resu['msg'] = '个人信息查询失败!';
            }
        }
        $this->ajaxReturn($resu);
    }
    /*
     * 个人认证接口/更新
     *
     * @params varchar HTTP_TOKEN           获取前台token
     * @params varchar name           姓名
     * @params varchar mobile         电话
     * @params varchar gender         性别
     * @params varchar birthday       生日
     * @params varchar education      学历
     * @params varchar major          专业
     * @params datatime worktime      工作经验
     * @params varchar email          邮箱
     * @params int age            年龄
     * @['personal']        个人信息表
     * @return json $resu           返回值
     * */

    public function people(){

        $dt = M('personal');// 实例化模型类,参数数据表名称
        $resu = array('code' => 1,'msg' => '','data' => array());
        $tokk = $_SERVER['HTTP_TOKEN'];
        $toke = json_decode(base64_decode($tokk),true);//解密token
        $mobile = $toke['mobile'];//赋值
        $check = $this->checktokens();
        $where = array('mobile' => $mobile);

        if($check != true){
            $resu['code'] =2;
            $resu['msg'] ='请先登录!';
        } else {
            $data=I('post.');
            $datas = array(
                'name' => $data['name'],
                'gender' => $data['gender'],
                'birthday' => $data['birthday'],
                'education' => $data['education'],
                'major' => $data['major'],
                'worktime' => $data['worktime'],
                'email' => $data['email'],
                'age' => $data['age'],
                'card' => $data['card']
            );
            $res = $dt->where($where)->save($datas);//更新修改的信息入库
            if ($res) {
                $resu['msg'] = '个人信息更改成功!';
            } else {
                $resu['code'] = 2;
                $resu['msg'] = '个人信息更改失败!';
            }
        }
        $this->ajaxReturn($resu);
    }

    /*
     * 首页/公告和照片接口
     *
     * @['notice']         公告和照片表
     * @return json $resu           返回值
     * */
    public function picture(){
        $resu = array('code' => 1,'msg' => '页面加载成功!','data' => array());
        //从数据库将值全部拿出来
        $list = M('notice')
            ->select();
        //返回前段进行展示
        if($list){
            $resu['data'] = $list;
        }else{
            $resu['code'] = 2;
            $resu['msg'] = '页面加载失败!';
        }
        $this->ajaxReturn($resu);
    }

    /*
     * 全职和兼职招聘接口
     *
     * 需要从前台获取的数据信息,到分割线为止
     * @params int fulltime            全职兼职,通过他的值(0和1)来判断
     * @return varchar companyname     公司名称
     * @return varchar pay             薪资待遇
     * @return varchar jobinten        职位名称
     * @return varchar jobtitle        职位标题
     * @return varchar jobfield        职位地区
     * @return json $resu           返回给前台的值
     * @['company']         公司信息表
     * */
    public function fulltime(){
        $resu = array('code' => 1,'msg' => '数据查询成功!','data' => array());
        //点击事件
        //从数据库将值拿出来
        $list = M('company')
            ->where(array('fulltime' => $_POST['fulltime']))//在数据库中用1和0来判断是否为全职
            ->field('companyname,pay,jobinten,jobtitle,jobfield')//筛选需要的字段信息
            ->select();
        //返回前段进行展示
        if($list){
            $resu['data'] = $list;
        }else{
            $resu['code'] = 2;
            $resu['msg'] = '数据查询失败!';
        }
        $this->ajaxReturn($resu);
    }
    /*
     * 名企招聘接口
     *
     *@jobinten is not null     这里是指职位名称不为空的公司的所有职位
     *
     * 因为没有具体的要求,暂时展示发布职位不为空的公司和职位
     *
     * 需要返还给前端页面的值
     * @return varchar companyname         公司名称
     * @return varchar pay                 薪资待遇
     * @return varchar jobinten            职位名称
     * @return varchar jobtitle            职位标题
     * @return varchar jobfield            职位地区
     * */
    public function famous(){
        $resu = array('code' => 1,'msg' => '数据查询成功!','data' => array());
        $list = M('company')
            ->where('jobinten is not null')
            ->field('companyname,pay,jobinten,jobtitle,jobfield')
            ->select();

        if($list){
            $resu['data'] = $list;
        }else{
            $resu['code'] = 2;
            $resu['msg'] = '数据查询失败!';
        }
        $this->ajaxReturn($resu);
    }
    /*
     * 热门职位接口
     *
     * 通过查询整个公司信息表中所有职位名称数量多少来排序
     *
     * @['company']     公司信息表
     * @return json $resu       需要返还给前端的数据
     * */

    public function hot(){
        $resu = array('code' => 1,'msg' => '数据查询成功!','data' => array());
        //取出数据并且按数量来进行排序
        $list = M('company')
            ->where('jobinten is not null')
            ->field('jobinten')
            ->select();
        if($list){
            $resu['data'] = $list;
        }else{
            $resu['code'] = 2;
            $resu['msg'] = '数据查询失败!';
        }
        $this->ajaxReturn($resu);
    }
    /*
     * 推荐职位接口
     *
     * 通过个人简历中的'期望职位'来进行筛选
     *
     * @params varchar mobile     电话号码
     *
     * 需要返还给前端的数据
     * @return varchar companyname         公司名称
     * @return varchar pay                 薪资待遇
     * @return varchar jobinten            职位名称
     * @return varchar jobtitle            职位标题
     * @return varchar jobfield            职位地区
     *
     * @return json resume      简历信息表
     * @['company']     公司信息表
     * */

    public function recommend(){
        $resu = array('code' => 1,'msg' => '数据查询成功!','data' => array());
        $list = M('company')
            ->where('jobinten is not null')
            ->limit(10)
            ->order('rand()')
            ->field('companyname,pay,jobinten,jobtitle,jobfield')
            ->select();
        //如果取到相关数据,则往下通过该数据中的'期望职位'来查询相关所有职位信息
        if($list){
            $resu['data'] = $list;
        }else{
            $resu['code'] = 2;
            $resu['msg'] = '获取数据失败,请重试!';
        }
        $this->ajaxReturn($resu);
    }

    /*
     * 首页搜索框接口
     *
     * @params varchar keyword         关键字
     * @return varchar companyname     公司名称
     * @return varchar pay             薪资待遇
     * @return varchar jobinten        职位名称
     * @return varchar jobtitle        职位标题
     * @return varchar jobfield        职位地区
     * @['company']         公司信息表
     * */

    public function found(){

        $resu = array('code' => 1,'msg' => '数据查询成功!','data' => array());
        //先使用模糊查询将值赋给变量$data
        $data['companyname']=array("like","%".$_POST['keyword']."%");
        //将变量放到表中查询公司名称,并且筛选相应字段
        $list = M('company')->where($data)->field('companyname,pay,jobinten,jobtitle,jobfield')->select();
        //如果能够查询到相关数据,则返回相关信息
        if($list){
            $resu['data'] =$list;
        }else{
            //如果查询公司名称无果,则查询职位名称
            $like['jobinten']=array("like","%".$_POST['keyword']."%");
            $list = M('company') ->where($like)->field('companyname,pay,jobinten,jobtitle,jobfield')->select();
            //如果能够查询到职位相关联的信息,那么就返回数据,如果公司名称和职位名称都查询不到就返回false
            if($list){
                $resu['code'] =2;
                $resu['data'] =$list;
            }else{
                $resu['code'] =3;
                $resu['msg'] ='数据查询失败!';
            }
        }
        $this->ajaxReturn($resu);
    }
}