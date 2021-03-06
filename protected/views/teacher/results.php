<div class="leftbar" style="margin-left: 20px;"> 
<?php 
    $stepName2=  Race::model()->find("indexID=? AND step=?",array($indexID,2))['raceName'];
    $stepName3=  Race::model()->find("indexID=? AND step=?",array($indexID,3))['raceName'];
    $stepName5=  Race::model()->find("indexID=? AND step=?",array($indexID,5))['raceName'];
?>
<table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th class="font-center">试卷号</th>
                <th class="font-center">试卷名</th>
                <th class="font-center">正确率</th>
                <th class="font-center">作答内容</th>
            </tr>
        </thead>
        <tbody>        
            <?php foreach ($raceLst as $k => $model): ?>
                <tr>
                    <td class="font-center"><?php echo $model['indexID']; ?></td>
                    <td class="font-center"><a href="#" onclick="isOver(<?php echo $model['indexID']; ?>,0)"><?php echo $model['name']; ?></a></td>
                    <td class="font-center"><a href="#" onclick="isOver(<?php echo $model['indexID']; ?>,1)">导出</a></td>
                    <td class="font-center"><a href="#" onclick="isOver2(<?php echo $model['indexID']; ?>,1)">导出</a></td>
                </tr>            
            <?php endforeach; ?> 
        </tbody>
    </table>
    <div align=center>
        <?php
        $this->widget('CLinkPager', array('pages' => $pages));
        ?>
    </div>
</div>
<div class="rightbar">
    <?php if(isset($stuList)){ ?>
  <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th class="font-center">考  号</th>
                <th class="font-center"><?php echo $stepName2; ?></th>
                <th class="font-center"><?php echo $stepName3; ?></th>
                <th class="font-center"><?php echo $stepName5; ?></th>
            </tr>
        </thead>
        <tbody>        
            <?php foreach ($data as $k => $model): ?>
            <tr  >
                <td style="text-align: center"><?php echo $model['studentID'];?></td>
                <td style="text-align: center"><?php if($model['resultstep2']['rate']==null){echo"未作答";}else{echo $model['resultstep2']['rate']."%";}?></td>
                <td style="text-align: center"><?php if($model['resultstep3']['rate']==null){echo"未作答";}else{echo $model['resultstep3']['rate']."%";}?></td>
                <td style="text-align: center"><?php if($model['resultstep5']['rate']==null){echo"未作答";}else{echo $model['resultstep5']['rate']."%";}?></td>
            </tr>
            <?php endforeach; ?> 
        </tbody>
    </table>  
    <?php } ?>
</div>
<script>
    $(document).ready(function () {
    window.parent.doClick2();
    });
    function isOver(indexID ,tag){
        $.ajax({
            type: "POST",
            url: "index.php?r=teacher/isOvered",
            data: {indexID: indexID},
            success: function (data) {
                if(tag === 1){
                     window.location.href = "./index.php?r=teacher/Exportresults&indexID="+indexID;
                }
                if(tag=== 0){
                    window.location.href = "./index.php?r=teacher/results&indexID="+indexID;
                }
            },
            error: function (xhr, type, exception) {
                
            }
        });          
    }
        function isOver2(indexID ,tag){
        $.ajax({
            type: "POST",
            url: "index.php?r=teacher/isOvered",
            data: {indexID: indexID},
            success: function (data) {
                    if(tag === 1){
                        window.location.href = "./index.php?r=teacher/Exportresults&indexID="+indexID+"&&answer=1";
                    }
                    if(tag=== 0){
                       window.location.href = "./index.php?r=teacher/results&indexID="+indexID;
                    }
            },
            error: function (xhr, type, exception) {
                
            }
        });          
    }
  </script>
