  <?php
    //得到老师ID对应的名称
    foreach ($teacher as $model):
    $teacherID=$model['userID'];
    $teachers["$teacherID"]=$model['userName'];
    endforeach;
    ?>

    <div class="span9">
    <!-- 更改信息列表-->
    <div class="hero-unit">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>更改人</th>
                <th>更改时间</th>
            </tr>
        </thead>
                <tbody>
                    
                    <?php 
                            $logs = explode("b",$log);
                            $len = count($logs);
                            for($i=0;$i<$len-1;$i++)
                            {
                                $change=explode("a",$logs[$i]);
                                $changeP=$change[0];
                                $changeT=$change[1];?>
                    <tr>
                        <td><?php if($changeP=="0")
                                        echo "管理员";
                                    else echo $teachers[$changeP];
                            ?></td>
                        <td><?php echo $changeT;?></td>
                    </tr>            
                            <?php }?> 
                </tbody>
    </table>  
    <!-- 更改列表结束 -->

     <button type="button" onclick="back()">确定</button>
     <script>
        function back()
        {
             $("#cont").load("./index.php?r=admin/<?php echo $source;?>");
        }
    </script>
    </div>

    <!-- 右侧内容展示结束-->
    </div>


