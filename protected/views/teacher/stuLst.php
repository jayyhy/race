<div class="span3">
    <div class="well" style="padding: 8px 0;">
        <ul class="nav nav-list">
            <li  class="active"><a href="#"><i class="icon-align-left"></i><?php echo $raceIndex["name"]; ?></a></li>
        </ul>
    </div>
</div>
<div class="span9">
    <h2>试卷列表</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th class="font-center">学生ID</th>
                <th class="font-center">班级ID</th>
                <th class="font-center">操作</th>
            </tr>
        </thead>
        <tbody>        
            <?php foreach ($students as $k => $model): ?>
                <tr>
                    <td class="font-center"><?php echo $model['userID']; ?></td>
                    <td class="font-center"><?php echo $model['classID']; ?></td>
                    <td class="font-center" style="width: 100px">  
                        <a href="./index.php?r=teacher/detail&indexID=<?php echo $raceIndex["indexID"]; ?>&step=1"  ><img title="管控" src="<?php echo IMG_URL; ?>edit.png"></a>
                    </td>
                </tr>            
            <?php endforeach; ?> 
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
</script>


