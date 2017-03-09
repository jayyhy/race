<html lang="zh-cn">
    <head>
        <meta charset="utf-8">
        <title>亚伟速录竞赛系统(2017)</title>
        <link href="<?php echo CSS_URL; ?>bootstrap.min.css" rel="stylesheet">
            <link href="<?php echo CSS_URL; ?>site.css" rel="stylesheet">
            <script src="<?php echo JS_URL; ?>jquery.min.js"></script>
            <script src="<?php echo JS_URL; ?>bootstrap.min.js"></script>
<!--            <script src="<?php //echo JS_URL; ?>site.js"></script>-->
<!--            改变alter样式-- extensions/xcConfirm 工具包下-- --> 
                <link rel="stylesheet" type="text/css" href="<?php echo XC_Confirm; ?>css/xcConfirm.css"/>
		<script src="<?php echo XC_Confirm; ?>js/jquery-1.9.1.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo XC_Confirm; ?>js/xcConfirm.js" type="text/javascript" charset="utf-8"></script>
    </head>
    <body>
        <div style="width: 450px; height: 280px;margin:0 auto;">
            <h3><font color="#ff0000">关闭服务器</font></h3>
            <input type="hidden" name="flag" value="1" />
        <form action="./index.php?r=teacher/ISshutDown" class="form-horizontal" method="post" id="form-addStu">
        <fieldset>
            <div>
                    <legend>请输入您的密码</legend>
                    <span style="font-size: 18px">密码：</span> <input name="password" type="password" style="width:280px; height:30px;" id="password" value="" />
            </div><br><br>
            <button  class="btn btn-primary" onclick="closeServer()">确认</button>　　　　　　　　
            <a class="btn btn-primary" onclick="closeWindow()" href="#">取消</a>
        </fieldset>
    </form>
        </div>
    </body>
</html>

<script>

    function closeWindow(){
            window.opener.location.reload();
            window.close();
    }
    window.onload=function(){
        closeServer(<?php if(isset($result)){echo $result;}?>);
    }
    function closeServer(result){
         //alert(result);
        if(result===1){
            window.close();
        }else if(result===2){
            window.wxc.xcConfirm('密码错误！', window.wxc.xcConfirm.typeEnum.error);
        }
    }
</script>
