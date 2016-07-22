<script type="text/javascript">
function test()
{
	 var temp = document.getElementById("input02");
	 //对电子邮件的验证
	 var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
	 if(!myreg.test(temp.value))
	 {
             window.wxc.xcConfirm('请输入有效的email！', window.wxc.xcConfirm.typeEnum.info);
	     temp.value="";
	     myreg.focus();
	     return false;
	 } 
}
</script>
<html lang="en"><!--<![endif]--> 
	<head>
		<meta charset="utf-8">
		<title>Profile - Akira</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="<?php echo CSS_URL; ?>bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo CSS_URL; ?>bootstrap-responsive.min.css" rel="stylesheet">
		<link href="<?php echo CSS_URL; ?>site.css" rel="stylesheet">
		<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
                <script src="<?php echo JS_URL;?>jquery.min.js"></script>
                <script src="<?php echo JS_URL;?>bootstrap.min.js"></script>
                <script src="<?php echo JS_URL;?>site.js"></script>
		<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	</head>
	<body>
<div class="span9">
    <h3>忘记密码</h3>
    <form id="myForm" method="post" action="./index.php?r=user/forgetpassword"> 
            <div class="control-group">
                <label class="control-label" for="input01">账号</label>
                <div class="controls">
                        <input name="account" type="text" class="input-xlarge" id="input01" style="height: 30px;"/>
                </div>
                <label class="control-label" for="input02">邮箱</label>
                <div class="controls">
                        <input name="email" type="text" class="input-xlarge" id="input02" onblur="test()" style="height: 30px;"/>
                </div>
                
                
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">确认</button> 
                <a href="./index.php?r=student/<?php echo Yii::app()->session['lastUrl'];?>&&page=<?php echo Yii::app()->session['lastPage'];?>" class="btn">返回</a>
            </div>
        
    </form>   
</div>
            </body>
</html>

<script>  
$(document).ready(function(){
    var result = '<?php echo $result;?>';
    if(result === '1')
    window.wxc.xcConfirm('成功！', window.wxc.xcConfirm.typeEnum.success);
    else if(result === '0')
    window.wxc.xcConfirm('失败！', window.wxc.xcConfirm.typeEnum.error);
    else if(result==='email error')
    window.wxc.xcConfirm('邮箱错误！', window.wxc.xcConfirm.typeEnum.info);
}); 
$("#myForm").submit(function(){
    var account = $("#input01")[0].value;
    var email = $("#input02")[0].value;
    
    if(account === "" ||email === ""){
        window.wxc.xcConfirm('不能为空', window.wxc.xcConfirm.typeEnum.info);
        return false;
    }
        
});
</script>



