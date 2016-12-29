<?php
//固定span3
?>
<div class="span3">
    <div class="leftbar" style="margin-left: 20px;height: 40px;width: 220px" id="on_add" >
         <img src="<?php echo IMG_URL; ?>icon_test.png" style="position: absolute;left: 22px;top: 76px;"/><font style="font-size:23px;font-weight: 600;position: absolute;left: 45px;top: 76px;">&nbsp;试卷列表</font>
    </div>
    <div style="margin-left: 20px;margin-top: 54px;">
    <?php foreach ($raceIndex as $k => $model): ?>
     <div style="margin-top: 15px;background:#F8F4F2;width: 210px;height: 88px;border-radius: 6px;" onclick="getExam(<?php echo $model['indexID']; ?>)">
        <div style="margin-left: 10px;padding-top: 15px;">
            <font style="font-size:16px; font-weight: 600;color: #E35C43"><?php echo "0".$model['indexID']; ?>&nbsp;&nbsp;&nbsp;</font><font style="font-size:16px; font-weight: 600;"><?php echo $model['name']; ?></font>
        </div>
        <div style="margin-left: 10px;padding-top: 10px;"><?php echo $model['createTime']; ?></div>
     </div>
     <?php endforeach; ?> 
    </div>
</div>

