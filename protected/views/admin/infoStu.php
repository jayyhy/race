<?php
    if(Yii::app()->session['lastUrl']=="stuDontHaveClass"||Yii::app()->session['lastUrl']=="infoClass")
        require 'classLstSideBar.php';
    else
        require 'stuSideBar.php';?>
<div class="span9">
    <h3>学生信息</h3>
    <div class="hero-unit">
    <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <td width="30%">学号:</td>
                    <td><?php echo $id;?></td>
                </tr>
                <tr>
                    <td>姓名:</td>
                    <td><?php echo $name;?></td>
                </tr>
                 <tr>
                    <td>性别:</td>
                    <td><?php echo $sex;?></td>
                </tr>
                 <tr>
                    <td>年龄:</td>
                    <td><?php echo $age;?></td>
                </tr>
                <tr>
                    <td>班级:</td>
                    <td><?php $sqlClass = TbClass::model()->find("classID = $class");
          echo $sqlClass['className'];
    ?></td>
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
        <?php if(Yii::app()->session['lastUrl']=="stuDontHaveClass"){?>
        <a href="./index.php?r=admin/stuDontHaveClass&&page=<?php echo Yii::app()->session['lastPage'];?>" style="padding: 7px 37px; " class="btn btn-primary">返回</a>
        <?php }else if(Yii::app()->session['lastUrl']=="infoClass"){?>
        <a href="./index.php?r=admin/infoClass&&classID=<?php echo $class;?>" style="padding: 7px 37px; "  class="btn btn-primary">返回</a>
        <?php } else if(isset($flag)){?>
        <a href="./index.php?r=admin/searchStu&&page=<?php echo Yii::app()->session['lastPage'];?>" style="padding: 7px 37px; "  class="btn btn-primary">返回</a>
        <?php }else{?>
        <a href="./index.php?r=admin/stuLst&&page=<?php echo Yii::app()->session['lastPage'];?>"  style="padding: 7px 37px; " class="btn btn-primary">返回</a>
        <?php }?>
    </div>
</div>
<script>
    $(document).ready(function(){
       <?php if(Yii::app()->session['lastUrl']=="stuDontHaveClass") {?>
        $("#stuLst").attr("class","active");
       <?php }?>
    });
</script>
