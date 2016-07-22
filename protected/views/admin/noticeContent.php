<div class="span9"style="height: 400px;width: 1080px;">
    <div >
            <center><h2><?php if($result==0) echo '查看公告'; else echo '修改公告' ;?></h2></center>
    </div>
<!-- 公告列表-->

<table   style="width: 1180px;height: 236px;border:solid #DDD;">
        <tr style="background: #DDD;height: 36px;min-width: 100%;text-align: left">
            
                <th style="width: 35%;">标题:<?php echo $noticeRecord['noticetitle'];?></th>
                <th style="width: 20%"></th>
                <th style="font-weight:normal;width: 30%">发布时间:<?php echo $noticeRecord['noticetime'];?> </th>
                <th style="font-weight:normal;width: 15%">操作：&nbsp;&nbsp;
                    <a href="#" onclick="dele('<?php echo $noticeRecord['id'];?>')"><img title="删除" src="<?php echo IMG_URL; ?>delete.png"></a>
                    <a href="./index.php?r=admin/noticeContent&&id=<?php echo $noticeRecord['id'];?>&&action=edit"><img title="编辑" src="<?php echo IMG_URL; ?>edit.png"></a>
                </th>
     
        </tr>
        <tr style="background: #fff;height: 200px;">
            <td colspan="4">
                <?php if($result==0){?>
                <textarea style="background:transparent;border-style:none; width: 1077px;height: 190px" disabled="disable"><?php echo str_replace("<br/>", "\r", $noticeRecord['content']) ;?></textarea>
                <?php }else{?>
                    <textarea id="notice-textarea" style="background:transparent;border-style:none; width: 1077px;height: 190px"><?php echo str_replace("<br/>", "\r", $noticeRecord['content']) ;?></textarea>
                <?php }?>
                
            </td>       
        </tr> 
        
</table> 
<br>
<div style="text-align: right;">
    <?php if($result==0){?>
        <a href="./index.php?r=admin/noticeLst" class="btn btn-primary" >返回</a>
    <?php }else{?>
        <a  id="changel" class="btn btn-primary">保存</a>&nbsp; &nbsp;
        <a href="./index.php?r=admin/noticeLst" class="btn btn-primary" >返回</a>
    <?php }?>
    
</div>

</div>
<script>
$(document).ready(function(){
    var current_date = new Date();
    var current_time = current_date.toLocaleTimeString();
    $("#changel").click(function() {
        var text2 = $("#notice-textarea").val();
        if(text2==""){
           window.wxc.xcConfirm("内容不能为空", window.wxc.xcConfirm.typeEnum.warning);
            return false;
        }
        $.ajax({
            type: "POST",
            url: "index.php?r=api/changeNotice&&id=<?php echo $noticeRecord['id'];?>",
            data: {content:  text2},
            success: function(){   
               
            window.wxc.xcConfirm('修改发布成功！', window.wxc.xcConfirm.typeEnum.success);
            },
            error: function(xhr, type, exception){
                window.wxc.xcConfirm('出错了...请重新刷新页面', window.wxc.xcConfirm.typeEnum.error);
                console.log(xhr.responseText, "Failed");
            }
        });
    });
});
function dele(noticeId)
    {
        var option = {
                title: "警告",
                btn: parseInt("0011",2),
                onOk: function(){
                         window.location.href = "./index.php?r=admin/deleteNotice&&id=" + noticeId ;
                }
        }
        window.wxc.xcConfirm("您确定删除吗？", "custom", option);
    }
</script>


