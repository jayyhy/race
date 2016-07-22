<script src="<?php echo JS_URL; ?>/My97DatePicker"></script>
<div class="span9"style="height: 500px;width: 1090px;">
<div >
            <center><h2>查看公告</h2></center>
    </div>
<!-- 公告列表-->
<table style="width: 1180px;height: 236px;border:solid #DDD;">
    <thead>
        <tr style="background: #DDD;height: 36px;min-width: 100%;text-align: left">
            
                <th style="width: 35%;">标题:<?php echo $noticeRecord['noticetitle'];?></th>
                <th style="font-weight:normal;width: 30%">发布时间:<?php echo $noticeRecord['noticetime'];?> </th>
        </tr>
        <tr style="background: #fff;height: 200px;">
            <td colspan="2">
                
                    <textarea style="background:transparent;border-style:none; width: 1077px;height: 190px" disabled="disable"><?php echo str_replace("<br/>", "\r", $noticeRecord['content']) ;?></textarea>
                
                
            </td>       
    </thead>
</table><br/>
<div style="text-align: right;">
        <a href="./index.php?r=student/stuNotice" class="btn btn-primary" >返回</a>
</div>
