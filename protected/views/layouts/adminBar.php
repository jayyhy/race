<!DOCTYPE html>
<!--[if lt IE 7 ]><html lang="en" class="ie6 ielt7 ielt8 ielt9"><![endif]--><!--[if IE 7 ]><html lang="en" class="ie7 ielt8 ielt9"><![endif]--><!--[if IE 8 ]><html lang="en" class="ie8 ielt9"><![endif]--><!--[if IE 9 ]><html lang="en" class="ie9"> <![endif]--><!--[if (gt IE 9)|!(IE)]><!--> 
<?php
if (isset(Yii::app()->session['userid_now']) && Yii::app()->session['role_now']=='admin'&&Yii::app()->session['cfmLogin']=1 ) {
    ?>

    <html lang="zh-cn"><!--<![endif]--> 
        <head>
            <meta charset="utf-8">
            <title>亚伟速录</title>
            <link href="<?php echo CSS_URL; ?>bootstrap.min.css" rel="stylesheet">
            <link href="<?php echo CSS_URL; ?>site.css" rel="stylesheet">
            <script src="<?php echo JS_URL; ?>jquery.min.js" ></script>
            <script src="<?php echo JS_URL; ?>bootstrap.min.js"></script>
            <script src="<?php echo JS_URL; ?>site.js" ></script>
<!--            改变alter样式-- extensions/xcConfirm 工具包下-- --> 
                <link rel="stylesheet" type="text/css" href="<?php echo XC_Confirm; ?>css/xcConfirm.css"/>
		<script src="<?php echo XC_Confirm; ?>js/xcConfirm.js"  type="text/javascript" charset="utf-8"></script>
<!--            -->
             <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        </head>
        <body>
            <div  class="container">
                <div class="navbar">
                    <div class="navbar-inner">
                        <div class="container">
                            <a class="brand" href="./index.php?r=admin/index"></a>
                            <div class="nav-collapse">
                                <ul class="nav">
<!--                                     <li><a id="course_manager"  href="./index.php?r=admin/courseLst">考场调度</a></li>
                                     <li><a id="topic_manager"  href="./index.php?r=admin/raceLst">试卷调配</a></li>
                                   <li><a id="notice_manager" href="./index.php?r=admin/noticeLst">公告管理</a></li>-->
                                   <li><a id="notice_manager" href="./index.php?r=admin/addRoom">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                           &nbsp;&nbsp;&nbsp;&nbsp;创建考场</a></li>
                                      <li><a id="blank_admin"></a></li>
                                    <li >
                                        <div class="userUI">
                                            <a href="" id="userUI" data-toggle="dropdown" title="<?php echo Yii::app()->session['userName']; ?>">
                                                
                                                <?php $name=Yii::app()->session['userName'];
                                                        if(Tool::clength($name) <= 3)
                                                            echo $name;
                                                        else
                                                            echo Tool::csubstr($name, 0, 3) . "...";
                                                ?>
                                                <b class="user_dropdown_logo"></b>
                                            </a>

                                            <ul class="dropdown-menu">
                                                <li>
<!--                                                    <a href="./index.php?r=admin/set">设置</a>-->
                                                    <a href="./index.php?r=user/login&exit=1">退出</a>
                                                </li>
                                            </ul>   
                                        </div>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>
                  
                </div>
                <div class="row" style="min-height: 700px">
                    <?php echo $content; ?>
                    
                </div>
                  <div style="float: bottom"  class="copyright">
                      2015 &copy;南京兜秘网络科技有限公司.&nbsp;&nbsp;&nbsp;<a href="#"  class="copyright">法律声明</a><a href="#"  class="copyright">联系我们</a><a href="#"  class="copyright">获得帮助</a>
	</div>
            </div>
           
        </body>
        
    </html>
<?php } else { ?>
    <script>    window.location.href = "./index.php?r=user/login"</script>
<?php } ?>

