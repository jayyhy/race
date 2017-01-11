<!DOCTYPE html>
<?php
if (isset(Yii::app()->session['userid_now']) && Yii::app()->session['role_now'] == 'teacher'&&Yii::app()->session['cfmLogin']=1 ) {
    ?>

    <html lang="zh-cn"><!--<![endif]--> 
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=no"/>
            <title>亚伟速录</title>
            <link href="<?php echo CSS_URL; ?>bootstrap.min.css" rel="stylesheet">
            <link href="<?php echo CSS_URL; ?>site.css" rel="stylesheet">
            <script src="<?php echo JS_URL; ?>jquery.min.js" ></script>
            <script src="<?php echo JS_URL; ?>bootstrap.min.js" ></script>
            <script src="<?php echo JS_URL; ?>site.js" ></script>
            <!--            改变alter样式-- extensions/xcConfirm 工具包下-- --> 
            <link rel="stylesheet" type="text/css" href="<?php echo XC_Confirm; ?>css/xcConfirm.css"/>
            <script src="<?php echo JS_URL; ?>jquery-2.1.3.min.js" ></script>
            <script src="<?php echo XC_Confirm; ?>js/xcConfirm.js"></script>
        </head>
        <body>
            <?php 
        $teacherID = Yii::app()->session['userid_now'];
        $teacher = Teacher::model()->find("userID=?", array($teacherID));
        $oncourse = Course::model()->find("courseID=?", array($teacher['classID']));
        $onraceID = $oncourse['onRaceID'];
        $onrace = Race::model()->find("raceID=?", array($onraceID));
        $onindexID = $onrace['indexID'];
        $onstep = $onrace['step'];
        ?>   
            <div class="container">
            <div class="ywnav">
                <?php if($onraceID == 0) { ?>
                <a class="ywlogo" href="./index.php?r=teacher/index"> <div class="ywlogo"> </div></a>
                <?php }else{ ?>
                <a class="ywlogo" href="" onclick="nowonexam()"> <div class="ywlogo"> </div></a>
                <?php } ?>
<!--                <font class="ysgs">亚伟国赛管理系统</font>-->
<?php if($onraceID == 0) { ?>
<div class="sjdp" id="sjdp"><a href="./index.php?r=teacher/raceLst" onclick="changesjdp()">试卷调配</a></div>
<?php }else{ ?>
<div class="sjdp" id="sjdp"><a href="" onclick="nowonexam()">试卷调配</a></div>
<?php } ?>
<?php if($onraceID == 0) { ?>
<div class="kcjk" id="kcjk"><a href="./index.php?r=teacher/raceControl">考场监控</a></div>
<?php }else{ ?>
<div class="kcjk" id="kcjk"><a href="./index.php?r=teacher/control&indexID=<?php echo $onindexID; ?>&&step=<?php echo $onstep; ?>">考场监控</a></div>
<?php } ?>
<?php if($onraceID == 0) { ?>
<div class="ksjg" id = "ksjg"><a href="./index.php?r=teacher/results">考试结果</a></div>
<?php }else{ ?>
<div class="ksjg" id = "ksjg"><a href="" onclick="nowonexam()">考试结果</a></div>
<?php } ?>
                <div class="userUI">
                    <a href="" id="userUI" data-toggle="dropdown" title="<?php echo Yii::app()->session['userName']; ?>">
                  <?php $name=Yii::app()->session['userName'];
                  if(Tool::clength($name) <= 5)
                   echo $name;
                       else
                         echo Tool::csubstr($name, 0, 6) . "...";
                               ?>
                                <b class="user_dropdown_logo"></b>
                              </a>

                              <ul class="dropdown-menu">
                                        <li>
                                    <?php if($onraceID == 0) { ?>        
                                   <a href="./index.php?r=teacher/teaInformation">个人设置</a></li>
                               <li><a href="./index.php?r=user/login&exit=1">退出</a>
                                   <?php }else{ ?>
                                <a href="" onclick="nowonexam()">个人设置</a></li>
                               <li><a href="" onclick="nowonexam()">退出</a>
                                   <?php } ?>
                              </li>
                         </ul>   
                       </div></div>       
                <div class="row" style="min-height: 700px">
    <?php echo $content; ?>
                </div></div> 
            </div>  
            <div  class="copyright">
                2015 &copy;南京兜秘网络科技有限公司.&nbsp;&nbsp;&nbsp;<a href="#"  class="copyright">法律声明</a><a href="#"  class="copyright">联系我们</a><a href="#"  class="copyright">获得帮助</a>
            </div>
        </body>
    </html>
<?php } else { ?>
    <script>    window.location.href = "./index.php?r=user/login";</script>
<?php } ?>
<script type="text/javascript">
function doClick(){
   var obj = document.getElementById("sjdp");
   obj.setAttribute("class", "sjdp1");
}
function doClick1(){
   var obj = document.getElementById("kcjk");
   obj.setAttribute("class", "kcjk1");
}
function doClick2(){
   var obj = document.getElementById("ksjg");
   obj.setAttribute("class", "ksjg1");
}
function nowonexam(){
//    window.wxc.xcConfirm('正在考试，暂时不能离开此试卷！', window.wxc.xcConfirm.typeEnum.error);
}
</script>