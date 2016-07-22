
<script src="<?php echo JS_URL; ?>/My97DatePicker"></script>
<div class="span9"
     style="height: 250px;width: 1080px;">
    <center><h2>发布公告</h2></center>
<!-- 发布公告-->
    <div style="margin:0 auto;border:0px solid #000;width:800px;height:100px;text-align: center">
        <input id="notice-input" style="width: 60%;" oninput="this.style.color='red'" name="title" placeholder="标题...."><br/><br/>
        <textarea  id="notice-textarea" placeholder="内容...." style="width: 60%;height: 90px;"name="content"></textarea><br/>
        <br/>
        <a id="postnoticel" style="text-align: right;margin-left: 360px" class="btn btn-primary">发布</a>
    </div>
</div>
<div class="span9" style="margin-top: 25px;width: 1080px;">
    <center><h2>公告列表</h2></center>
    <input type="checkbox" name="all" onclick="check_all(this, 'checkbox[]')" style="margin-bottom: 3px"> 全选　批量操作：
    <a href="#" onclick="deleCheck()"><img title="批量删除" src="<?php echo IMG_URL; ?>delete.png"></a>
<!-- 公告列表-->
<table class="table table-bordered table-striped"  style="background: #aaa9a9">
    <thead>
        <tr> 
            
            <th class="font-center">选择</th>
            <th class="font-center" style="width:200px">日期</th>
            <th class="font-center">标题</th>
            <th class="font-center" style="width:200px">操作</th>
        </tr>
    </thead>
    <tbody>
        <form id="deleForm" method="post" action="./index.php?r=admin/deletenotice " > 
        <?php 
               foreach ($noticeRecord as $notice){?>
        <tr>
            <td class="font-center" style="width: 50px"> <input type="checkbox" name="checkbox[]" value="<?php echo $notice['id']; ?>" /> </td>
            <td>
                 <?php echo $notice['noticetime'];?>
            </td>
            <td>
                <a href="./index.php?r=admin/noticeContent&&id=<?php echo $notice['id'];?>"><?php echo $notice['noticetitle'];?></a>
            </td>
            <td>
                <a href="./index.php?r=admin/noticeContent&&id=<?php echo $notice['id'];?>&&action=edit"><img title="编辑" src="<?php echo IMG_URL; ?>edit.png"></a>
                <a href="#" onclick="dele('<?php echo $notice['id'];?>')"><img title="删除" src="<?php echo IMG_URL; ?>delete.png"></a>
            </td>
        </tr>
               <?php }?>
        </form>
    </tbody>
</table>
<div align=right>
    <?php   
        $this->widget('CLinkPager',array('pages'=>$pages));
    ?>
    </div>
</div>
<script>
$(document).ready(function(){
       <?php if(isset($_POST['checkbox'])){ ?>
           window.location.href="./index.php?r=admin/noticeLst";
      <?php }?> 
          
    document.getElementById("notice-input").focus();
    var current_date = new Date();
    var current_time = current_date.toLocaleTimeString();

    $("#postnoticel").click(function() {
        var text1 = $("#notice-input").val();
        var text2 = $("#notice-textarea").val();
        if(text1==""||text2==""){
           window.wxc.xcConfirm("标题或内容不能为空", window.wxc.xcConfirm.typeEnum.info);
            return false;
        }
         if(text1.length > 40){ 
          window.wxc.xcConfirm("标题过长！！！", window.wxc.xcConfirm.typeEnum.info);
        document.getElementById("title").value="";
        }
        $.ajax({
            type: "POST",
            url: "index.php?r=api/putNotice",
            data: {title:  text1 , content:  text2},
            success: function(){   
               
            window.wxc.xcConfirm('公告发布成功！', window.wxc.xcConfirm.typeEnum.success,{
                onOk:function(){
                    window.location.reload();
                }
            });
            },
            error: function(xhr, type, exception){
                window.wxc.xcConfirm('出错了...请重新刷新页面', window.wxc.xcConfirm.typeEnum.error);
                console.log(xhr.responseText, "Failed");
            }
        });
    });
});
    function check_all(obj, cName)
    {
        var checkboxs = document.getElementsByName(cName);
        for (var i = 0; i < checkboxs.length; i++) {
            checkboxs[i].checked = obj.checked;
        }
    }
    function deleCheck() {
    var checkboxs = document.getElementsByName('checkbox[]');
    var flag = 0;
        for (var i = 0; i < checkboxs.length; i++) {
           if(checkboxs[i].checked){
                flag=1;
                break;
           }
        } 
        if(flag===0){
           window.wxc.xcConfirm('未选中任何公告', window.wxc.xcConfirm.typeEnum.info);
        }else{
             var option = {
						title: "警告",
						btn: parseInt("0011",2),
						onOk: function(){
							$('#deleForm').submit();
						}
					};
					window.wxc.xcConfirm("您确定删除吗？", "custom", option);
        }
       
    }
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

