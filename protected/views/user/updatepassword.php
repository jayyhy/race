
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
    <h3>重置密码</h3>
    <form id="myForm" method="post" action="./index.php?r=user/updatepassword&&userid=<?php echo $userid;?>&&type=<?php echo $type;?>"> 
         
   
            <div class="control-group">
                <label class="control-label" for="input01">新密码</label>
                <div class="controls">
                    <input name="new1" type="password" class="input-xlarge" id="input01" style="height: 30px;"/>
                </div>
                <label class="control-label" for="input02">确认密码</label>
                <div class="controls">
                    <input name="defnew" type="password" class="input-xlarge" id="input02" onblur="test()" style="height: 30px;"/>
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






