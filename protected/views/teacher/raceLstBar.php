<div class="span3">
    <div  style="margin-left: 20px;height: 20px;width: 220px" >
         <img src="<?php echo IMG_URL; ?>icon_test.png" style="position: relative;left: 3px;top: 26px;"/>
         <font style="font-size:23px;font-weight: 600;position: relative;left: 6px;top: 30px;">&nbsp;试卷列表</font>
    </div>
    <div style="margin-left: 20px;margin-top: 54px;">
    <?php if(count($raceLst)>0){ 
        foreach ($raceLst as $k => $model):?>
         <div style="margin-top: 15px;background:#F8F4F2;width: 210px;height: 88px;border-radius: 6px;" >
             
       
            <a href="#" onclick="getExam(<?php echo $model['indexID']; ?>)" style="position: relative;left: 12px;top: 17px;"><font style="font-size:16px; font-weight: 600;color: #E35C43"><?php echo "0".$model['indexID']; ?>&nbsp;&nbsp;&nbsp;</font><font style="font-size:16px; font-weight: 600; color: #3A393E"><?php echo $model['name']; ?></font></a>
        
            <a href="#" onclick="deleteRaceIndex(<?php echo $model['indexID']; ?>,'<?php echo $model['name']; ?>')" ><img src="<?php echo IMG_URL_NEW; ?>icon_delete_on.png" style="position: relative;left: 74px;top: 15px;" /></a>
             
        <div style="margin-left: 12px;padding-top: 28px;"><?php echo $model['createTime']; ?></div>
     </div>
        
    <?php 
    endforeach;
    } ?>
    </div>
    <div style="margin-top: 20px;margin-left: 18px;width: 214px;height: 52px;background-color: #fff;border-radius: 6px;" id="on_add">
        <a href="#" onclick="adding()" style="font-size: 14px;color: #9D9D9C ;position: relative;top: 15px;left: 13px">
              <img title="添加" src="<?php echo IMG_URL; ?>icon_add_1.png"  >&nbsp;&nbsp;新建试卷</a>
    </div>
    <div style="margin-top: 20px;margin-left: 18px;width: 214px;height: 98px;background-color: #fff;border-radius: 6px;display: none;" id="on_adding">
        <ul class="nav nav-list" style="margin-top: 15px">
            <li>
                <input id="value" type="text" class="search span2" placeholder="请输入试卷标题" style="margin-top: 13px;width: 92%;border-color: #FEE1DA;"/>
            </li>
            <li style="margin-bottom: 30px">
                <button onclick="cancel()" class="btn_6big">取 消</button>
                <button onclick="addRace()" class="btn_5big">确 定</button>
            </li>
        </ul>
        </div>
</div>
<script>
    function deleteRaceIndex(id, name) {
        var option = {
            title: "警告",
            btn: parseInt("0011", 2),
            onOk: function () {
                window.location.href = "./index.php?r=teacher/deleteRaceIndex&&indexID=" + id;
            }
        };
        window.wxc.xcConfirm("确定要删除试卷：" + name + "?这样导致删除人员，考试记录等，并且无法恢复！", "custom", option);
    }
    function getExam(indexID){
             window.location.href = "./index.php?r=teacher/editRace&indexID="+indexID+"&step=1";
    }
    function adding(){
        document.getElementById("on_adding").style.display='block';
        document.getElementById("on_add").style.display='none';
    }
    function cancel(){
        document.getElementById("on_adding").style.display='none';
        document.getElementById("on_add").style.display='block';  
    }
    function addRace() {
        var courseName = document.querySelector("#value").value;
        if(courseName!==""){
            window.location.href="./index.php?r=teacher/addRaceIndex&raceName="+courseName;
        }else{
            window.wxc.xcConfirm('请输入试卷名', window.wxc.xcConfirm.typeEnum.info);
        }
    }
    
</script>
    

