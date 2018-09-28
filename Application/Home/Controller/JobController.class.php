<?php
/**
 * Created by PhpStorm.
 * User: Dalei
 * Date: 2018/8/26
 * Time: 22:40
 */

namespace Home\Controller;

/*
 * 找工作接口
 * 主页面信息接口
 * 地区筛选接口
 * 职位筛选接口
 * 搜索公司或者职位接口
 * */
class JobController extends HomeController{
    /*
     * 找工作/主页面信息接口
     *
     * 需要返还给前端的数据信息
     * @return varchar companyname 公司名称
     * @return varchar pay         薪资待遇
     * @return varchar jobinten    职位名称
     * @return varchar jobtitle    职位标题
     * @['company']     数据库表中的公司信息表
     * */
    public function index(){

        $resu = array('code' => 1,'msg' => '信息获取成功!','data' => array());
            //查询数据库表中相应信息,并且筛选需要的字段
            $list = M('company')
                ->field('companyname,pay,jobinten,jobtitle,jobfield')
                ->select();
            if($list){
                $resu['data'] =$list;
            }else{
                $resu['code'] =2;
                $resu['msg'] ='数据查询失败!';
            }
        $this->ajaxReturn($resu);
    }
    /*
     * 找工作/地区筛选接口
     *
     * @params varchar jobfield       职位地区
     * 需要返回给前端的数据
     * @return varchar companyname         公司名称
     * @return varchar pay                 薪资待遇
     * @return varchar jobinten            职位名称
     * @return varchar jobtitle            职位标题
     * @return varchar jobfield            职位地区
     * @['company']     数据库表中的公司信息表
     * */
    public function place(){
        $resu = array('code' => 1,'msg' => '数据查询成功!','data' => array());
        //通过前台点击事件来获取地区具体信息,以便于处查询数据库,并且筛选相应字段
        $list = M('company')
            ->where(array('jobfield' => $_POST['jobfield']))
            ->field('companyname,pay,jobinten,jobtitle,jobfield')
            ->select();

        if($list){
            $resu['data'] =$list;
        }else{
            $resu['code'] =2;
            $resu['msg'] ='数据查询失败!';
        }
        $this->ajaxReturn($resu);
    }
    /*
     * 找工作/职位筛选接口
     *
     * @params varchar jobinten       职位名称
     *
     * 需要返回给前端的数据信息
     * @return varchar companyname     公司名称
     * @return varchar pay             薪资待遇
     * @return varchar jobinten        职位名称
     * @return varchar jobtitle        职位标题
     * @return varchar jobfield        职位地区
     * @['company']     数据库表中的公司信息表
     * */
    public function work(){
        $resu = array('code' => 1,'msg' => '数据查询成功!','data' => array());
        $list = M('company')
            //通过前台点击事件来获取职位具体信息,以便于处查询数据库
            ->where(array('title' => $_POST['title']))
            ->field('companyname,pay,jobinten,jobtitle,jobfield')
            ->select();

        if($list){
            $resu['data'] =$list;
        }else{
            $resu['code'] =2;
            $resu['msg'] ='暂时没有这个职位哦!';
        }
        $this->ajaxReturn($resu);
    }
    public function wor(){
        $resu = array('code' => 1,'msg' => '数据查询成功!','data' => array());
        $list = M('company')
            //通过前台点击事件来获取职位具体信息,以便于处查询数据库
            ->where(array('jobinten' => $_POST['jobinten']))
            ->field('companyname,pay,jobinten,jobtitle,jobfield')
            ->select();

        if($list){
            $resu['data'] =$list;
        }else{
            $resu['code'] =2;
            $resu['msg'] ='暂时没有这个职位哦!';
        }
        $this->ajaxReturn($resu);
    }
    /*
     * 找工作/搜索公司或者职位接口
     *
     * @params varchar keyword        关键字
     * @return varchar companyname     公司名称
     * @return varchar pay             薪资待遇
     * @return varchar jobinten        职位名称
     * @return varchar jobtitle        职位标题
     * @return varchar jobfield        职位地区
     * @['company']         公司信息表
     * */
    public function company(){
        $resu = array('code' => 1,'msg' => '数据查询成功!','data' => array());
        //先查询公司名称
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
/*
 * 职位职位详情
 *
 *
 * */

    public function details(){
        $resu = array('code' => 1,'msg' => '查询成功!','data' => array());
        $companyname=$_POST['companyname'];
        $jobinten=$_POST['jobinten'];
        $arr = array(
            'companyname'=> $companyname,
            'jobinten'=>$jobinten,
            );
        $list = M('company')
            //通过前台点击事件来获取职位具体信息,以便于处查询数据库
            ->where($arr)
            ->find();
        if($list){
            $resu['data'] =$list;
        }else{
            $resu['code'] =2;
            $resu['msg'] ='查询失败!';
        }
        $this->ajaxReturn($resu);

    }
    /*
     *
     * 便民服务发布内容
     *
     *
     *
     * */
    public function civilian(){

            $resu = array('code' => 1,'msg' => '发布成功,待审核过后便可以展示你发发布信息!','data' => array());
            //获取前台请求数据
            $title = $_POST['title'];
            $content = $_POST['content'];
            $status = $_POST['status'];
            //将获取的参数和数据库字段做匹配
            $ary = array(
                'title' => $title,
                'content' => $content,
                'status' => $status,
            );
        if ($title!= NULL && $content != NULL) {
                    $list = M('convenient')->add($ary);
                    if ($list) {

                    } else {
                        $resu['code'] = 2;
                        $resu['msg'] = '发布失败!';
                    }

                }
            $this->ajaxReturn($resu);
        }
    /*
     *
     * 便民服务展示内容
     *
     *
     * */
    public function cards(){
        $resu = array('code' => 1,'msg' => '数据查询成功!','data' => array());
        $list = M('card')
            ->field('category')
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
    *
    * 便民服务展示内容
    *
    *
    * */
    public function civilians(){
        $resu = array('code' => 1,'msg' => '数据查询成功!','data' => array());
        $list = M('convenient')
            ->where('status=1')
            ->field('title,content')
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

}