<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <title>亚伟速录</title>
    <META HTTP-EQUIV="Cache-Control" CONTENT="no-cache,no-store, must-revalidate">
    <META HTTP-EQUIV="pragma" CONTENT="no-cache">
    <META HTTP-EQUIV="expires" CONTENT="0"> 
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <script src="<?php echo JS_URL; ?>jquery.min.js"></script>
    <link href="<?php echo CSS_URL; ?>login.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo CSS_URL; ?>bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo CSS_URL; ?>font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo CSS_URL; ?>style.css" rel="stylesheet" type="text/css"/>
</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->

<body class="login">
	<!-- BEGIN LOGO -->
	<div class="logo">
	</div>
	<!-- END LOGO -->
	<!-- BEGIN LOGIN -->
	<div class="content">
		<!-- BEGIN LOGIN FORM -->
           <?php $form=$this->beginWidget('CActiveForm');?>
                <h3 class="form-title">用户登录</h3>
			<div class="alert alert-error hide">
				<button class="close" data-dismiss="alert"></button>
				<span>请输入用户名和密码</span>
			</div>
                         
			<div class="control-group">
				<!--<label class="control-label visible-ie8 visible-ie9">Username</label>-->
				<div class="controls">
					<div class="input-icon left">
						<i class="icon-user"></i>
						<!-- 为一个模型属性渲染一个输入框   -->
						<?php 
						$cookie = Yii::app()->request->getCookies();
						if(!empty($cookie['usernamecookie']->value))
						$login_model->username=$cookie['usernamecookie']->value;
                         echo $form->textField($login_model,'username',array('class'=>'m-wrap placeholder-no-fix','placeholder'=>"请输入您的用户名")); ?>
                        <?php echo $form->error($login_model,'username'); ?>
					</div>
				</div>
			</div>

			<div class="control-group">
				<div class="controls">
					<div class="input-icon left">
						<i class="icon-lock"></i>
                            <!--<input class="m-wrap placeholder-no-fix" type="password" placeholder="请输入您的密码" name="password" />-->
                            <?php echo $form->passwordField($login_model,'password',array('class'=>'m-wrap placeholder-no-fix','placeholder'=>"请输入您的密码")); ?>
                            <?php echo $form->error($login_model,'password'); ?>
                    </div>
				</div>
			</div>
                        
            <div class="control-group">
                 <div  class="controls">
                     <div  class="input-icon left">
                          <?php
                             $cookie = Yii::app()->request->getCookies();
                             if(!empty($cookie['usertypecookie']->value))
                          	 	$login_model->usertype = $cookie['usertypecookie']->value;
                             echo $form->dropDownList($login_model,'usertype',array('empty'=>'请选择身份','student'=>"学生",'teacher'=>'老师','admin'=>"管理员")); 
                          ?>
                     </div>
                 </div>
            </div>
                        
			<div class="form-actions">
				
				<label class="checkbox">
					<?php 
						$cookie = Yii::app()->request->getCookies();
						if(!empty($cookie['remcookie']->value))
							echo $form->checkBox($login_model, 'rememberMe',array('checked'=>'checked'));
						else
							echo $form->checkBox($login_model, 'rememberMe',array('checked'=>'')); 
						
						?>
					<p>记住用户名和身份</p>
				</label>
				<button type="submit" class="btn btn-primary pull-right">
					登录 <i class="m-icon-swapright m-icon-white"></i>
				</button>            
			</div>
			<div class="forget-password">
                <p>
                    <a href="./index.php?r=user/forgetpassword" class="" id="forget-password">忘记密码?</a>
			    </p>
			</div>
                <?php $this->endWidget(); ?>
		<!-- END LOGIN FORM -->        

		

	</div>

	<!-- END LOGIN -->

	<!-- BEGIN COPYRIGHT -->

	<div class="copyright">
		2015 &copy;北京亚伟速录科技有限公司.
	</div>
	<script>
		jQuery(document).ready(function() {     
		  App.init();
		  Login.init();
		});
	</script>
</html>