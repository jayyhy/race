
<div class="span9"style="width:1090px;height: 500px">
    <center><h2>公告列表</h2></center>
<!-- 公告列表-->
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th style="width: 30%;font-weight: normal;font-size: 15px">时间</th>
            <th style="width: 70%;font-weight: normal;font-size: 15px">标题</th>  
        </tr>
    </thead>
    <tbody>
        <?php 
               foreach ($noticeRecord as $notice){?>
        <tr>
            <td>
                 <?php echo $notice['noticetime'];?>
            </td>
            <td>
                <a href="./index.php?r=student/noticeContent&&id=<?php echo $notice['id'];?>"><?php echo $notice['noticetitle'];?></a>
            </td>
        </tr>
               <?php }?>
    </tbody>
</table>
<div align=center>
    <?php   
        $this->widget('CLinkPager',array('pages'=>$pages));
    ?>
    </div>
</div>