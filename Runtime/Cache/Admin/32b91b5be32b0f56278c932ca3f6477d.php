<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo ($meta_title); ?>|OneThink管理平台</title>
    <link href="/Public/favicon.ico" type="image/x-icon" rel="shortcut icon">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/base.css" media="all">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/common.css" media="all">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/module.css">
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/style.css" media="all">
	<link rel="stylesheet" type="text/css" href="/Public/Admin/css/<?php echo (C("COLOR_STYLE")); ?>.css" media="all">
     <!--[if lt IE 9]>
    <script type="text/javascript" src="/Public/static/jquery-1.10.2.min.js"></script>
    <![endif]--><!--[if gte IE 9]><!-->
    <script type="text/javascript" src="/Public/static/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="/Public/Admin/js/jquery.mousewheel.js"></script>
    <!--<![endif]-->
    
</head>
<body>
    <!-- 头部 -->
    <div class="header">
        <!-- Logo -->
        <span class="logo"></span>
        <!-- /Logo -->

        <!-- 主导航 -->
        <ul class="main-nav">
            <?php if(is_array($__MENU__["main"])): $i = 0; $__LIST__ = $__MENU__["main"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li class="<?php echo ((isset($menu["class"]) && ($menu["class"] !== ""))?($menu["class"]):''); ?>"><a href="<?php echo (U($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <!-- /主导航 -->

        <!-- 用户栏 -->
        <div class="user-bar">
            <a href="javascript:;" class="user-entrance"><i class="icon-user"></i></a>
            <ul class="nav-list user-menu hidden">
                <li class="manager">你好，<em title="<?php echo session('user_auth.username');?>"><?php echo session('user_auth.username');?></em></li>
                <li><a href="<?php echo U('User/updatePassword');?>">修改密码</a></li>
                <li><a href="<?php echo U('User/updateNickname');?>">修改昵称</a></li>
                <li><a href="<?php echo U('Public/logout');?>">退出</a></li>
            </ul>
        </div>
    </div>
    <!-- /头部 -->

    <!-- 边栏 -->
    <div class="sidebar">
        <!-- 子导航 -->
        
    <div id="subnav" class="subnav">
    <?php if(!empty($_extra_menu)): ?>
        <?php echo extra_menu($_extra_menu,$__MENU__); endif; ?>
    <?php if(is_array($__MENU__["child"])): $i = 0; $__LIST__ = $__MENU__["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub_menu): $mod = ($i % 2 );++$i;?><!-- 子导航 -->
        <?php if(!empty($sub_menu)): if(!empty($key)): ?><h3><i class="icon icon-unfold"></i><?php echo ($key); ?></h3><?php endif; ?>
            <ul class="side-sub-menu">
                <?php if(is_array($sub_menu)): $i = 0; $__LIST__ = $sub_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li>
                        <a class="item" href="<?php echo (U($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a>
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul><?php endif; ?>
        <!-- /子导航 --><?php endforeach; endif; else: echo "" ;endif; ?>
 <h3>
 	<i class="icon <?php if(!in_array((ACTION_NAME), explode(',',"mydocument,draftbox,examine"))): ?>icon-fold<?php endif; ?>"></i>
 	个人中心
 </h3>
 	<ul class="side-sub-menu <?php if(!in_array((ACTION_NAME), explode(',',"mydocument,draftbox,examine"))): ?>subnav-off<?php endif; ?>">
 		<li <?php if((ACTION_NAME) == "mydocument"): ?>class="current"<?php endif; ?>><a class="item" href="<?php echo U('article/mydocument');?>">我的文档</a></li>
 		<?php if(($show_draftbox) == "1"): ?><li <?php if((ACTION_NAME) == "draftbox"): ?>class="current"<?php endif; ?>><a class="item" href="<?php echo U('article/draftbox');?>">草稿箱</a></li><?php endif; ?>
		<?php if(($show_examine) == "1"): ?><li <?php if((ACTION_NAME) == "examine"): ?>class="examine"<?php endif; ?>><a class="item" href="<?php echo U('article/examine');?>">待审核</a></li><?php endif; ?>
 	</ul>

    <?php if(is_array($nodes)): $i = 0; $__LIST__ = $nodes;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub_menu): $mod = ($i % 2 );++$i;?><!-- 子导航 -->
        <?php if(!empty($sub_menu)): ?><h3>
            	<i class="icon <?php if(($sub_menu['current']) != "1"): ?>icon-fold<?php endif; ?>"></i>
            	<?php if(($sub_menu['allow_publish']) > "0"): ?><a class="item" href="<?php echo (U($sub_menu["url"])); ?>"><?php echo ($sub_menu["title"]); ?></a><?php else: echo ($sub_menu["title"]); endif; ?>
            </h3>
            <ul class="side-sub-menu <?php if(($sub_menu["current"]) != "1"): ?>subnav-off<?php endif; ?>">
                <?php if(is_array($sub_menu['_child'])): $i = 0; $__LIST__ = $sub_menu['_child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$menu): $mod = ($i % 2 );++$i;?><li <?php if($menu['id'] == $cate_id or $menu['current'] == 1): ?>class="current"<?php endif; ?>>
                        <?php if(($menu['allow_publish']) > "0"): ?><a class="item" href="<?php echo (U($menu["url"])); ?>"><?php echo ($menu["title"]); ?></a><?php else: ?><a class="item" href="javascript:void(0);"><?php echo ($menu["title"]); ?></a><?php endif; ?>

                        <!-- 一级子菜单 -->
                        <?php if(isset($menu['_child'])): ?><ul class="subitem">
                        	<?php if(is_array($menu['_child'])): foreach($menu['_child'] as $key=>$three_menu): ?><li>
                                <?php if(($three_menu['allow_publish']) > "0"): ?><a class="item" href="<?php echo (U($three_menu["url"])); ?>"><?php echo ($three_menu["title"]); ?></a><?php else: ?><a class="item" href="javascript:void(0);"><?php echo ($three_menu["title"]); ?></a><?php endif; ?>
                                <!-- 二级子菜单 -->
                                <?php if(isset($three_menu['_child'])): ?><ul class="subitem">
                                	<?php if(is_array($three_menu['_child'])): foreach($three_menu['_child'] as $key=>$four_menu): ?><li>
                                        <?php if(($four_menu['allow_publish']) > "0"): ?><a class="item" href="<?php echo U('index','cate_id='.$four_menu['id']);?>"><?php echo ($four_menu["title"]); ?></a><?php else: ?><a class="item" href="javascript:void(0);"><?php echo ($four_menu["title"]); ?></a><?php endif; ?>
                                        <!-- 三级子菜单 -->
                                        <?php if(isset($four_menu['_child'])): ?><ul class="subitem">
                                        	<?php if(is_array($four_menu['_child'])): $i = 0; $__LIST__ = $four_menu['_child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$five_menu): $mod = ($i % 2 );++$i;?><li>
                                            	<?php if(($five_menu['allow_publish']) > "0"): ?><a class="item" href="<?php echo U('index','cate_id='.$five_menu['id']);?>"><?php echo ($five_menu["title"]); ?></a><?php else: ?><a class="item" href="javascript:void(0);"><?php echo ($five_menu["title"]); ?></a><?php endif; ?>
                                            </li><?php endforeach; endif; else: echo "" ;endif; ?>
                                        </ul><?php endif; ?>
                                        <!-- end 三级子菜单 -->
                                    </li><?php endforeach; endif; ?>
                                </ul><?php endif; ?>
                                <!-- end 二级子菜单 -->
                            </li><?php endforeach; endif; ?>
                        </ul><?php endif; ?>
                        <!-- end 一级子菜单 -->
                    </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul><?php endif; ?>
        <!-- /子导航 --><?php endforeach; endif; else: echo "" ;endif; ?>
    <!-- 回收站 -->
	<?php if(($show_recycle) == "1"): ?><h3>
        <em class="recycle"></em>
        <a href="<?php echo U('article/recycle');?>">回收站</a>
    </h3><?php endif; ?>
</div>
<script>
    $(function(){
        $(".side-sub-menu li").hover(function(){
            $(this).addClass("hover");
        },function(){
            $(this).removeClass("hover");
        });
    })
</script>


        <!-- /子导航 -->
    </div>
    <!-- /边栏 -->

    <!-- 内容区 -->
    <div id="main-content">
        <div id="top-alert" class="fixed alert alert-error" style="display: none;">
            <button class="close fixed" style="margin-top: 4px;">&times;</button>
            <div class="alert-content">这是内容</div>
        </div>
        <div id="main" class="main">
            
            <!-- nav -->
            <?php if(!empty($_show_nav)): ?><div class="breadcrumb">
                <span>您的位置:</span>
                <?php $i = '1'; ?>
                <?php if(is_array($_nav)): foreach($_nav as $k=>$v): if($i == count($_nav)): ?><span><?php echo ($v); ?></span>
                    <?php else: ?>
                    <span><a href="<?php echo ($k); ?>"><?php echo ($v); ?></a>&gt;</span><?php endif; ?>
                    <?php $i = $i+1; endforeach; endif; ?>
            </div><?php endif; ?>
            <!-- nav -->
            

            
    <script type="text/javascript" src="/Public/static/uploadify/jquery.uploadify.min.js"></script>
    <div class="main-title cf">
        <h2>
            编辑<?php echo (get_document_model($data["model_id"],'title')); ?> [
            <?php if(is_array($rightNav)): $i = 0; $__LIST__ = $rightNav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$nav): $mod = ($i % 2 );++$i;?><a href="<?php echo U('article/index','cate_id='.$nav['id']);?>"><?php echo ($nav["title"]); ?></a>
                <?php if(count($rightNav) > $i): ?><i class="ca"></i><?php endif; endforeach; endif; else: echo "" ;endif; ?>
            <?php if(isset($article)): ?>：<a
                    href="<?php echo U('article/index','cate_id='.$data['category_id'].'&pid='.$article['id']);?>"><?php echo ($article["title"]); ?></a><?php endif; ?>
            ]
        </h2>
    </div>
    <!-- 标签页导航 -->
    <div class="tab-wrap">
        <ul class="tab-nav nav">
            <?php $_result=parse_config_attr($model['field_group']);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$group): $mod = ($i % 2 );++$i;?><li data-tab="tab<?php echo ($key); ?>"
                <?php if(($key) == "1"): ?>class="current"<?php endif; ?>
                ><a href="javascript:void(0);"><?php echo ($group); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
        <div class="tab-content">
            <!-- 表单 -->
            <form id="form" action="<?php echo U('personal_edit');?>" method="post" class="form-horizontal">
                <!-- 基础文档模型 -->
                <input type="hidden" name="id" value="<?php echo ($data['id']); ?>">
                <div class="form-item cf">
                    <label class="item-label">name</label>
                    <div class="controls">
                        <input type="text" class="text input-large" name="name" value="<?php echo ($data['name']); ?>"></div>
                </div>
                <div class="form-item cf">
                    <label class="item-label">gender</label>
                    <div class="controls">
                        <input type="text" class="text input-large" name="gender" value="<?php echo ($data['gender']); ?>"></div>
                </div>
                <div class="form-item cf">
                    <label class="item-label">jobinten</label>
                    <div class="controls">
                        <input type="text" class="text input-large" name="jobinten" value="<?php echo ($data['jobinten']); ?>"></div>
                </div>
                <div class="form-item cf">
                    <label class="item-label">mobile</label>
                    <div class="controls">
                        <input type="text" class="text input-large" name="mobile" value="<?php echo ($data['mobile']); ?>"></div>
                </div>
                <div class="form-item cf">
                    <label class="item-label">email</label>
                    <div class="controls">
                        <input type="text" class="text input-large" name="email" value="<?php echo ($data['email']); ?>"></div>
                </div>
                <div class="form-item cf">
                    <label class="item-label">education</label>
                    <div class="controls">
                        <input type="text" class="text input-large" name="education" value="<?php echo ($data['education']); ?>"></div>
                </div>
                <div class="form-item cf">
                    <label class="item-label">region</label>
                    <div class="controls">
                        <input type="text" class="text input-large" name="region" value="<?php echo ($data['region']); ?>"></div>
                </div>
                <div class="form-item cf">
                    <label class="item-label">pay</label>
                    <div class="controls">
                        <input type="text" class="text input-large" name="pay" value="<?php echo ($data['pay']); ?>"></div>
                </div>
                <div class="form-item cf">
                    <label class="item-label">worktime</label>
                    <div class="controls">
                        <input type="text" class="text input-large" name="worktime" value="<?php echo ($data['worktime']); ?>"></div>
                </div>
                <div class="form-item cf">
                    <label class="item-label">position</label>
                    <div class="controls">
                        <input type="text" class="text input-large" name="position" value="<?php echo ($data['position']); ?>"></div>
                </div>
                <div class="form-item cf">
                    <label class="item-label">company</label>
                    <div class="controls">
                        <input type="text" class="text input-large" name="company" value="<?php echo ($data['company']); ?>"></div>
                </div>
                <div class="form-item cf">
                    <label class="item-label">studytime</label>
                    <div class="controls">
                        <input type="text" class="text input-large" name="studytime" value="<?php echo ($data['studytime']); ?>"></div>
                </div>
                <div class="form-item cf">
                    <label class="item-label">major</label>
                    <div class="controls">
                        <input type="text" class="text input-large" name="major" value="<?php echo ($data['major']); ?>"></div>
                </div>
                <div class="form-item cf">
                    <label class="item-label">school</label>
                    <div class="controls">
                        <input type="text" class="text input-large" name="school" value="<?php echo ($data['school']); ?>"></div>
                </div>
                <div class="form-item cf">
                    <label class="item-label">self</label>
                    <div class="controls">
                        <input type="text" class="text input-large" name="self" value="<?php echo ($data['self']); ?>"></div>
                </div>
                <div class="form-item cf">
                    <label class="item-label">picture</label>
                    <div class="controls">
                        <input type="text" class="text input-large" name="picture" value="<?php echo ($data['picture']); ?>"></div>
                </div>
                <div class="form-item cf">
                    <label class="item-label">age</label>
                    <div class="controls">
                        <input type="text" class="text input-large" name="age" value="<?php echo ($data['age']); ?>"></div>
                </div>
                <div class="form-item cf">
                    <label class="item-label">year</label>
                    <div class="controls">
                        <input type="text" class="text input-large" name="year" value="<?php echo ($data['year']); ?>"></div>
                </div>
                <div class="form-item cf">
                    <button class="btn submit-btn   hidden"  type="submit"
                            >确 定
                    </button>
                    <a class="btn btn-return" href="<?php echo (cookie('__forward__')); ?>">返 回</a>
                    <?php if(C('OPEN_DRAFTBOX') and (ACTION_NAME == 'add' or $data['status'] == 3)): ?><button class="btn save-btn" url="<?php echo U('article/autoSave');?>" target-form="form-horizontal"
                                id="autoSave">
                            存草稿
                        </button><?php endif; ?>
                    <input type="hidden" name="id" value="<?php echo ((isset($data["id"]) && ($data["id"] !== ""))?($data["id"]):''); ?>"/>
                    <input type="hidden" name="pid" value="<?php echo ((isset($data["pid"]) && ($data["pid"] !== ""))?($data["pid"]):''); ?>"/>
                    <input type="hidden" name="model_id" value="<?php echo ((isset($data["model_id"]) && ($data["model_id"] !== ""))?($data["model_id"]):''); ?>"/>
                    <input type="hidden" name="group_id" value="<?php echo ((isset($data["group_id"]) && ($data["group_id"] !== ""))?($data["group_id"]):''); ?>"/>
                    <input type="hidden" name="category_id" value="<?php echo ((isset($data["category_id"]) && ($data["category_id"] !== ""))?($data["category_id"]):''); ?>">
                </div>
            </form>
        </div>
    </div>

        </div>
        <div class="cont-ft">
            <div class="copyright">
                <div class="fl">感谢使用<a href="http://www.onethink.cn" target="_blank">OneThink</a>管理平台</div>
                <div class="fr">V<?php echo (ONETHINK_VERSION); ?></div>
            </div>
        </div>
    </div>
    <!-- /内容区 -->
    <script type="text/javascript">
    (function(){
        var ThinkPHP = window.Think = {
            "ROOT"   : "", //当前网站地址
            "APP"    : "/index.php?s=", //当前项目地址
            "PUBLIC" : "/Public", //项目公共目录地址
            "DEEP"   : "<?php echo C('URL_PATHINFO_DEPR');?>", //PATHINFO分割符
            "MODEL"  : ["<?php echo C('URL_MODEL');?>", "<?php echo C('URL_CASE_INSENSITIVE');?>", "<?php echo C('URL_HTML_SUFFIX');?>"],
            "VAR"    : ["<?php echo C('VAR_MODULE');?>", "<?php echo C('VAR_CONTROLLER');?>", "<?php echo C('VAR_ACTION');?>"]
        }
    })();
    </script>
    <script type="text/javascript" src="/Public/static/think.js"></script>
    <script type="text/javascript" src="/Public/Admin/js/common.js"></script>
    <script type="text/javascript">
        +function(){
            var $window = $(window), $subnav = $("#subnav"), url;
            $window.resize(function(){
                $("#main").css("min-height", $window.height() - 130);
            }).resize();

            /* 左边菜单高亮 */
            url = window.location.pathname + window.location.search;
            url = url.replace(/(\/(p)\/\d+)|(&p=\d+)|(\/(id)\/\d+)|(&id=\d+)|(\/(group)\/\d+)|(&group=\d+)/, "");
            $subnav.find("a[href='" + url + "']").parent().addClass("current");

            /* 左边菜单显示收起 */
            $("#subnav").on("click", "h3", function(){
                var $this = $(this);
                $this.find(".icon").toggleClass("icon-fold");
                $this.next().slideToggle("fast").siblings(".side-sub-menu:visible").
                      prev("h3").find("i").addClass("icon-fold").end().end().hide();
            });

            $("#subnav h3 a").click(function(e){e.stopPropagation()});

            /* 头部管理员菜单 */
            $(".user-bar").mouseenter(function(){
                var userMenu = $(this).children(".user-menu ");
                userMenu.removeClass("hidden");
                clearTimeout(userMenu.data("timeout"));
            }).mouseleave(function(){
                var userMenu = $(this).children(".user-menu");
                userMenu.data("timeout") && clearTimeout(userMenu.data("timeout"));
                userMenu.data("timeout", setTimeout(function(){userMenu.addClass("hidden")}, 100));
            });

	        /* 表单获取焦点变色 */
	        $("form").on("focus", "input", function(){
		        $(this).addClass('focus');
	        }).on("blur","input",function(){
				        $(this).removeClass('focus');
			        });
		    $("form").on("focus", "textarea", function(){
			    $(this).closest('label').addClass('focus');
		    }).on("blur","textarea",function(){
			    $(this).closest('label').removeClass('focus');
		    });

            // 导航栏超出窗口高度后的模拟滚动条
            var sHeight = $(".sidebar").height();
            var subHeight  = $(".subnav").height();
            var diff = subHeight - sHeight; //250
            var sub = $(".subnav");
            if(diff > 0){
                $(window).mousewheel(function(event, delta){
                    if(delta>0){
                        if(parseInt(sub.css('marginTop'))>-10){
                            sub.css('marginTop','0px');
                        }else{
                            sub.css('marginTop','+='+10);
                        }
                    }else{
                        if(parseInt(sub.css('marginTop'))<'-'+(diff-10)){
                            sub.css('marginTop','-'+(diff-10));
                        }else{
                            sub.css('marginTop','-='+10);
                        }
                    }
                });
            }
        }();
    </script>
    
    <link href="/Public/static/datetimepicker/css/datetimepicker.css" rel="stylesheet" type="text/css">
    <?php if(C('COLOR_STYLE')=='blue_color') echo '
        <link href="/Public/static/datetimepicker/css/datetimepicker_blue.css" rel="stylesheet" type="text/css">
        '; ?>
    <link href="/Public/static/datetimepicker/css/dropdown.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/Public/static/datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="/Public/static/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js"
            charset="UTF-8"></script>
    <script type="text/javascript">

        Think.setValue("type", <?php echo ((isset($data["type "]) && ($data["type "] !== ""))?($data["type "]): '""'); ?>)
        ;
        Think.setValue("display", <?php echo ((isset($data["display "]) && ($data["display "] !== ""))?($data["display "]): 0); ?>)
        ;

        $('#submit').click(function () {
            $('#form').submit();
        });

        $(function () {
            $('.date').datetimepicker({
                format: 'yyyy-mm-dd',
                language: "zh-CN",
                minView: 2,
                autoclose: true
            });
            $('.time').datetimepicker({
                format: 'yyyy-mm-dd hh:ii',
                language: "zh-CN",
                minView: 2,
                autoclose: true
            });
            showTab();

        <
            if condition = "C('OPEN_DRAFTBOX') and (ACTION_NAME eq 'add' or $data['status'] eq 3)" >
            //保存草稿
                var interval;
            $('#autoSave').click(function () {
                var target_form = $(this).attr('target-form');
                var target = $(this).attr('url')
                var form = $('.' + target_form);
                var query = form.serialize();
                var that = this;

                $(that).addClass('disabled').attr('autocomplete', 'off').prop('disabled', true);
                $.post(target, query).success(function (data) {
                    if (data.status == 1) {
                        updateAlert(data.info, 'alert-success');
                        $('input[name=id]').val(data.data.id);
                    } else {
                        updateAlert(data.info);
                    }
                    setTimeout(function () {
                        $('#top-alert').find('button').click();
                        $(that).removeClass('disabled').prop('disabled', false);
                    }, 1500);
                })

                //重新开始定时器
                clearInterval(interval);
                autoSaveDraft();
                return false;
            });

            //Ctrl+S保存草稿
            $('body').keydown(function (e) {
                if (e.ctrlKey && e.which == 83) {
                    $('#autoSave').click();
                    return false;
                }
            });

            //每隔一段时间保存草稿
            function autoSaveDraft() {
                interval = setInterval(function () {
                    //只有基础信息填写了，才会触发
                    var title = $('input[name=title]').val();
                    var name = $('input[name=name]').val();
                    var des = $('textarea[name=description]').val();
                    if (title != '' || name != '' || des != '') {
                        $('#autoSave').click();
                    }
                }, 1000 * parseInt({
            :
                C('DRAFT_AOTOSAVE_INTERVAL')
            }))
                ;
            }

            autoSaveDraft();

        <
            /if>

        });
    </script>

</body>
</html>