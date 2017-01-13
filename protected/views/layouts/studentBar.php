<!DOCTYPE html>
<!--[if lt IE 7 ]><html lang="en" class="ie6 ielt7 ielt8 ielt9"><![endif]--><!--[if IE 7 ]><html lang="en" class="ie7 ielt8 ielt9"><![endif]--><!--[if IE 8 ]><html lang="en" class="ie8 ielt9"><![endif]--><!--[if IE 9 ]><html lang="en" class="ie9"> <![endif]--><!--[if (gt IE 9)|!(IE)]><!--> 
<?php
if (isset(Yii::app()->session['userid_now']) && Yii::app()->session['role_now'] == 'student'&&Yii::app()->session['cfmLogin']=1 ) {
    ?>
    <html lang="zh-cn"><!--<![endif]--> 
        <head>
            <meta charset="utf-8">
            <title>亚伟速录</title>
            <link href="<?php echo CSS_URL; ?>bootstrap.min.css" rel="stylesheet">
            <link href="<?php echo CSS_URL; ?>site.css" rel="stylesheet">
            <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
            <script src="<?php echo JS_URL; ?>jquery.min.js" ></script>
            <script src="<?php echo JS_URL; ?>bootstrap.min.js" ></script>
            <script src="<?php echo JS_URL; ?>site.js" ></script>
            <!--            改变alter样式-- extensions/xcConfirm 工具包下-- --> 
            <link rel="stylesheet" type="text/css" href="<?php echo XC_Confirm; ?>css/xcConfirm.css"/>
            <script src="<?php echo JS_URL; ?>jquery-2.1.3.min.js" ></script>
            <script src="<?php echo XC_Confirm; ?>js/xcConfirm.js"   ></script>
            <!--            -->
        </head>
        <body  style="background-color: #f8f4f2">
             <div class="ywnav">
               
                    <a class="ywlogo" href="./index.php?r=student/index"> <div class="ywlogo"> </div></a>
                    <font class="ysgs" style="margin-left: 48%;">亚伟国赛考试系统</font>
                <div class="userUI">
                                            <a href="" id="userUI" data-toggle="dropdown" title="<?php echo Yii::app()->session['userName']; ?>">
                                                
                                                <?php $name=Yii::app()->session['userName'];
                                                        if(Tool::clength($name) <= 7)
                                                            echo $name;
                                                        else
                                                            echo Tool::csubstr($name, 0, 6) . "...";
                                                ?>
                                                <b class="user_dropdown_logo"></b>
                                            </a>

                                            <ul class="dropdown-menu">
                                                <li>
<!--                                                    <a href="./index.php?r=admin/set">设置</a>-->
                                                    <a href="./index.php?r=user/login&exit=1">退出</a>
                                                </li>
                                            </ul>   
                                        </div></div>
                    <?php echo $content; ?>
            <div  class="copyright">
                2015 &copy;南京兜秘网络科技有限公司.&nbsp;&nbsp;&nbsp;<a href="#"  class="copyright">法律声明</a><a href="#"  class="copyright">联系我们</a><a href="#"  class="copyright">获得帮助</a>
            </div>
        </body>
    </html>

<?php } else { ?>
    <script>    window.location.href = "./index.php?r=user/login";</script>
<?php } ?>
<script type="text/javascript">
//    window.onbeforeunload = onbeforeunload_handler;
//    window.onunload = onunload_handler;
//    function onbeforeunload_handler() {
//        $.ajax({
//            type: 'POST',
//            url: "./index.php?r=api/loginOut",
//            data: {user: 'student', userID: '<?php //echo Yii::app()->session['userid_now']; ?>'},
//            success: function (data, textStatus, jqXHR) {
//                console.log('jqXHR' + jqXHR);
//                console.log('textStatus' + textStatus);
//            },
//            error: function (jqXHR, textStatus, errorThrown) {
//                console.log('jqXHR' + jqXHR);
//                console.log('textStatus' + textStatus);
//                console.log('errorThrown' + errorThrown);
//            }
//
//        });
//    }
//    function onunload_handler() {
//        $.ajax({
//            type: 'POST',
//            url: "./index.php?r=api/loginOut",
//            data: {user: 'student', userID: '<?php //echo Yii::app()->session['userid_now']; ?>'},
//            success: function (data, textStatus, jqXHR) {
//                console.log('jqXHR' + jqXHR);
//                console.log('textStatus' + textStatus);
//            },
//            error: function (jqXHR, textStatus, errorThrown) {
//                console.log('jqXHR' + jqXHR);
//                console.log('textStatus' + textStatus);
//                console.log('errorThrown' + errorThrown);
//            }
//
//        });
//    }
function doC(){
    document.body.style.backgroundImage="url(<?php echo IMG_UIStu_URL; ?>student_background.png)";
    document.body.style.backgroundRepeat = 'no-repeat';
    document.body.style.backgroundPosition="bottom";
}
</script>
