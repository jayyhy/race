<div class="span3">
    <div class="leftbar" style="margin-left: 20px;height: 40px" id="on_add" >
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
<div class="span9">
    <div >
        
    </div>
<!--    <h2>试卷列表</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th class="font-center">试卷号</th>
                <th class="font-center">试卷名</th>
                <th class="font-center">创建时间</th>
                <th class="font-center">操作</th>
            </tr>
        </thead>-->
        <tbody>        
            <?php //foreach ($raceIndex as $k => $model): ?>
<!--                <tr>
                    <td class="font-center"><?php echo $model['indexID']; ?></td>
                    <td class="font-center"><?php echo $model['name']; ?></td>
                    <td class="font-center"><?php echo $model['createTime']; ?></td>
                    <td class="font-center" style="width: 100px">  
                        <a href="./index.php?r=teacher/control&indexID=<?php echo $model['indexID']; ?>&step=1"  ><img title="管控" src="<?php echo IMG_URL; ?>edit.png"></a>
                    </td>
                </tr>            -->
            <?php //endforeach; ?> 
        </tbody>
    </table>
    <!-- 学生列表结束 -->
    <!-- 显示翻页标签 -->
    <div align=center>
        <?php
        $this->widget('CLinkPager', array('pages' => $pages));
        ?>
    </div>
</div>
<script>
    $(document).ready(function () {
    window.parent.doClick1();
    });
    function getExam(indexID){
         window.location.href = "./index.php?r=teacher/control&indexID="+indexID+"&&step=1";
    }
</script>

