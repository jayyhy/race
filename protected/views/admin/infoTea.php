<?php
    if(Yii::app()->session['lastUrl']=="classLst"||Yii::app()->session['lastUrl']=="infoClass"||Yii::app()->session['lastUrl']=="searchClass")
        require 'classLstSideBar.php';
    else
        require 'teaSideBar.php';?>
<div class="span9">
    <h3>老师信息</h3>
    <div class="hero-unit">
    <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <td width="30%">工号:</td>
                    <td><?php echo $id;?></td>
                </tr>
                <tr>
                    <td>姓名:</td>
                    <td><?php echo $name;?></td>
                </tr>
                <tr>
                    <td>年龄:</td>
                    <td><?php echo $age;?></td>
                </tr>
                <tr>
                    <td>性别:</td>
                    <td><?php echo $sex;?></td>
                </tr>
                <tr>
                    <td>部门:</td>
                    <td><?php if($department=="") echo "无"; else echo $department;?></td>
                </tr>
                <tr>
                    <td>院校:</td>
                    <td><?php if($school=="") echo "无"; else echo $school;?></td>
                </tr>
                <tr>
                    <td>联系电话:</td>
                    <td><?php if($phone_number=="") echo "无"; else echo $phone_number;?></td>
                </tr>
                <tr>
                    <td>联系邮箱:</td>
                    <td><?php if($mail_address=="") echo "无"; else echo $mail_address;?></td>
                </tr>
                
            </tbody>
    </table>
        <?php if(Yii::app()->session['lastUrl']=="classLst"){ ?>
        <a href="./index.php?r=admin/classLst&&page=<?php echo Yii::app()->session['lastPage'];?>" style="padding: 7px 37px; " class="btn btn-primary">返回</a>
        <?php  }else if(Yii::app()->session['lastUrl']=="searchClass"){?>
        <a href="./index.php?r=admin/searchClass&&page=<?php echo Yii::app()->session['lastPage'];?>" style="padding: 7px 37px; " class="btn btn-primary">返回</a>
        <?php }else if(Yii::app()->session['lastUrl']=="infoClass"){?>
        <a href="./index.php?r=admin/infoClass&&classID=<?php echo $_GET['classID'];?>" style="padding: 7px 37px; " class="btn btn-primary">返回</a>
        <?php }else if(isset($flag)){?>
        <a href="./index.php?r=admin/searchTea&&page=<?php echo Yii::app()->session['lastPage'];?>" style="padding: 7px 37px; " class="btn btn-primary">返回</a>
        <?php }else{?>
        <a href="./index.php?r=admin/teaLst&&page=<?php echo Yii::app()->session['lastPage'];?>" style="padding: 7px 37px; " class="btn btn-primary">返回</a>
        <?php }?>
    </div>
</div>
