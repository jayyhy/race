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
                <th class="font-center">阶段一</th>
                <th class="font-center">阶段二</th>
                <th class="font-center">阶段三</th>
                <th class="font-center">阶段四</th>
                <th class="font-center">阶段五</th>
                <th class="font-center">阶段六</th>
            </tr>
        </thead>
        <tbody>        
            <?php foreach ($data as $k => $model): ?>
            <tr>
            <tr>
                <td><?php echo $model['studentID'];?></td>
                <td><?php if($model['resultstep1']['rate']==null){echo"未作答";}echo $model['resultstep1']['rate'];?></td>
                <td><?php if($model['resultstep2']['rate']==null){echo"未作答";}echo $model['resultstep2']['rate'];?></td>
                <td><?php if($model['resultstep3']['rate']==null){echo"未作答";}echo $model['resultstep3']['rate'];?></td>
                <td><?php if($model['resultstep4']['rate']==null){echo"未作答";}echo $model['resultstep4']['rate'];?></td>
                <td><?php if($model['resultstep5']['rate']==null){echo"未作答";}echo $model['resultstep5']['rate'];?></td>
                <td><?php if($model['resultstep6']['rate']==null){echo"未作答";}echo $model['resultstep6']['rate'];?></td>   
            </tr>
            <?php endforeach; ?> 
        </tbody>
    </table>  
    <?php } ?>
</div>
