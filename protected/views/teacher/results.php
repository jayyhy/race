<div class="leftbar" style="margin-left: 20px;">    
<table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th class="font-center">试卷号</th>
                <th class="font-center">试卷名</th>
                <th class="font-center">操作</th>
            </tr>
        </thead>
        <tbody>        
            <?php foreach ($raceLst as $k => $model): ?>
                <tr>
                    <td class="font-center"><?php echo $model['indexID']; ?></td>
                    <td class="font-center"><a href="./index.php?r=teacher/results&indexID=<?php echo $model['indexID']; ?>"><?php echo $model['name']; ?></a></td>
                    <td class="font-center"><a href="./index.php?r=teacher/Exportresults&indexID=<?php echo $model['indexID']; ?>">导出</a></td>
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
                <th class="font-center">看打</th>
                <th class="font-center">听打</th>
                <th class="font-center">听打校对</th>
                <th class="font-center">盲打</th>
                <th class="font-center">视频纠错</th>
            </tr>
        </thead>
        <tbody>        
            <?php foreach ($data as $k => $model): ?>
            <tr>
            <tr>
                <td><?php echo $model['studentID'];?></td>
                <td><?php if($model['resultstep2']['rate']==null){echo"未作答";}else{echo $model['resultstep2']['rate']."%";}?></td>
                <td><?php if($model['resultstep3']['rate']==null){echo"未作答";}else{echo $model['resultstep3']['rate']."%";}?></td>
                <td><?php if($model['resultstep4']['rate']==null){echo"未作答";}else{echo $model['resultstep4']['rate']."%";}?></td>
                <td><?php if($model['resultstep5']['rate']==null){echo"未作答";}else{echo $model['resultstep5']['rate']."%";}?></td>
                <td><?php if($model['resultstep6']['rate']==null){echo"未作答";}else{echo $model['resultstep6']['rate']."%";}?></td>   
            </tr>
            <?php endforeach; ?> 
        </tbody>
    </table>  
    <?php } ?>
</div>
