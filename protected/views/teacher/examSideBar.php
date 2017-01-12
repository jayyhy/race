<?php
//固定span3
?>
<div class="span3">
    <div  style="margin-left: 20px;height: 20px;width: 220px" >
         <img src="<?php echo IMG_URL; ?>icon_test.png" style="position: relative;left: 3px;top: 26px;"/>
         <span style="font-size:23px;font-weight: 600;position: relative;left: 6px;top: 30px;">&nbsp;试卷列表</span>
    </div>
    <div style="margin-left: 20px;margin-top: 54px;">
    <?php foreach ($raceIndex as $k => $model): ?>
     <div style="margin-top: 15px;background:#F8F4F2;width: 210px;height: 88px;border-radius: 6px;" >
        <div style="margin-left: 10px;padding-top: 15px;">
            <a href="#" onclick="getExam(<?php echo $model['indexID']; ?>)" title="<?php echo $model['name']; ?>">
                <span style="font-size:16px; font-weight: 600;color: #E35C43"><?php echo "0".$model['indexID']; ?>&nbsp;&nbsp;&nbsp;</span>
                <span style="font-size:16px; font-weight: 600;color: #3A393E">
                    <?php if(Tool::clength($model['name']) <= 4) {
                        echo $model['name'];
                    }else {
                         echo Tool::csubstr($model['name'], 0, 4) . "...";
                    }?>
                </span></a>
        </div>
        <div style="margin-left: 10px;padding-top: 10px;"><?php echo $model['createTime']; ?></div>
     </div>
     <?php endforeach; ?> 
    </div>
</div>

