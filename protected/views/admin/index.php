<div class="leftbar" style ="display: none; background: #FFE9E3" id="on_adding">
    <div style="padding: 8px 0; height: 650px;background: #FFE9E3">
    <div style="margin-left: 10px;margin-top: 10px">
        <img src="<?php echo IMG_URL; ?>icon_test.png"/><font style="font-size:20px">&nbsp;创建考场</font>
    </div>
        <div style="background:#FFFFFF;width: 90%;margin-left: 5%">
        <ul class="nav nav-list" style="margin-top: 15px">
            <li>
                <input id="value" type="text" class="search span2" placeholder="请输入考场名" style="margin-top: 13px;width: 92%;border-color: #FEE1DA;"/>
                <input id="kaohao" type="text" class="search span2" placeholder="请输入考场号" style="width: 92%;border-color: #FEE1DA"/>
                <input id="renshu" type="text" class="search span2" placeholder="请输入人数" style="width: 80%;border-color: #FEE1DA"/> <font color="#9797B7">人</font>
            </li>
            <li style="margin-bottom: 30px">
                <button onclick="cancel()" class="btn_6big">取 消</button>
                <button onclick="addCourse()" class="btn_5big">确 定</button>
            </li>
        </ul>
        </div>
    </div>
</div>
<div class="leftbar" id="on_add">
    <div style="height: 100%;margin-left: 10px;margin-top: 10px">
            <img src="<?php echo IMG_URL; ?>icon_test.png"/><font style="font-size:20px">&nbsp;创建考场</font>
            <?php if(count($courseLst)==0){?>
            <div style="margin-top: 10px;margin-left: 10px">
         <a href="#" onclick="adding()"><img title="添加" src="<?php echo IMG_URL; ?>icon_add_1.png">新建考场</a>
    </div>
            <?php } ?>
            <div style="background-color:#FBF8F7;width: 92%; margin-top: 13px">
             <?php foreach ($courseLst as $k => $model): ?>
                <div style="padding: 30px">
            <?php echo $model['name']; ?><br>
            <?php echo $model['createTime']; ?>
            <div style="float: right;margin-top: -10px;">
            <a href="#"  onclick="deleteCourse(<?php echo $model['courseID']; ?>,'<?php echo $model['name']; ?>')" ><img title="删除" src="<?php echo IMG_URL; ?>icon_delete.png"></a>
            </div>
            </div>
             <?php endforeach; ?>   
        </div>
    </div>
    </div>
    <?php if(count($courseLst)!=0){?>
<div class="rightbar">
    <div style="margin-left:3%;font-weight:bold">
        <div style="font-size: 25px;margin-top: 20px;">教学ID:<font color="#FE0100">
            <?php
            foreach ($teacher as $tea){echo $tea['userName'];}
            ?>
            </font>
            &nbsp;&nbsp;&nbsp;&nbsp;
            学生人数:<font color="#FE0100"><?php echo count($student);?></font></div>
    <h3>学生ID:</h3>
   <table class="table table-bordered table-striped">
        <thead>
        </thead>
        <tbody>   
    <?php 
     $i = 0;
         }
         }
            echo "<tr>";
    foreach ($student as $allstu){ 
        $i++;
        echo "<td>";
        echo $allstu['userID'];
        echo "</td>";
        if ($i % 5 == 0) {
          echo "</tr>";
        }
        ?> 
<?php }?>
        </tbody>
    </table>
</div>
</div>
    <?php } else { ?>
<div class="rightbar"><div style="margin-left: 35%"><img src="<?php echo IMG_URL; ?>null_exam.png"></div></div>
    <?php } ?>

<script>

    $(document).ready(function () {
        var result = <?php echo "'$result'"; ?>;
        if (result === '1')
            window.wxc.xcConfirm("操作成功！", window.wxc.xcConfirm.typeEnum.success, {
                onOk: function () {
                    window.location.href = "./index.php?r=admin/courseLst";
                }
            });
        else if (result === '0') {
            window.wxc.xcConfirm("已有班级进行需要删除的科目，无法删除！", window.wxc.xcConfirm.typeEnum.error, {
                onOk: function () {
                    window.location.href = "./index.php?r=admin/courseLst";
                }
            });
        }
        else if (result === '3') {
            window.wxc.xcConfirm("只能新建一个考场！！！", window.wxc.xcConfirm.typeEnum.error, {
                onOk: function () {
                    window.location.href = "./index.php?r=admin/courseLst";
                }
            });
        }
    });
    function check_all(obj, cName)
    {
        var checkboxs = document.getElementsByName(cName);
        for (var i = 0; i < checkboxs.length; i++) {
            checkboxs[i].checked = obj.checked;
        }
    }

    function deleteCourse(id, name) {
        var option = {
            title: "警告",
            btn: parseInt("0011", 2),
            onOk: function () {
                window.location.href = "./index.php?r=admin/deleteCourse&&courseID=" + id;
            }
        };
        window.wxc.xcConfirm("确定要删除考场：" + name + "?这样导致删除人员，考试记录等，并且无法恢复！", "custom", option);
    }

    function addCourse() {
        var reg = /^[0-9a-zA-Z]+$/;
        var courseName = document.querySelector("#value").value;
        var kaohao = document.querySelector("#kaohao").value;
        var renshu = document.querySelector("#renshu").value;
        if(courseName==""){
            window.wxc.xcConfirm('请输入考场名', window.wxc.xcConfirm.typeEnum.info);
        }else if(kaohao==""){
            window.wxc.xcConfirm('请输入考号', window.wxc.xcConfirm.typeEnum.info);
        }
        else if(renshu==""){
            window.wxc.xcConfirm('请输入人数', window.wxc.xcConfirm.typeEnum.info);
        }
        else{ 
            if(isNaN(renshu) || renshu<=0 || renshu>100 || parseInt(renshu)!=renshu){
                    window.wxc.xcConfirm('请在人数框里输入大于0小于100的正整数', window.wxc.xcConfirm.typeEnum.info);
                    return false;
                    
            }
            else if(!reg.test(kaohao)){
                     window.wxc.xcConfirm('请在考号框里只能输入英文和数字', window.wxc.xcConfirm.typeEnum.info);
                    return false;
            }
            else{
                 window.location.href="./index.php?r=admin/addRaceCourse&courseName="+courseName+"&kaohao="+kaohao+"&renshu="+renshu;
            }
    }
    }

    function deleCheck() {
        var checkboxs = document.getElementsByName('checkbox[]');
        var flag = 0;
        for (var i = 0; i < checkboxs.length; i++) {
            if (checkboxs[i].checked) {
                flag = 1;
                break;
            }
        }
        if (flag === 0) {
            window.wxc.xcConfirm('未选中任何考场', window.wxc.xcConfirm.typeEnum.info);
        } else {
            var option = {
                title: "警告",
                btn: parseInt("0011", 2),
                onOk: function () {
                    $('#deleForm').submit();
                }
            };
            window.wxc.xcConfirm("确定删除选中的考场吗？", "custom", option);
        }

    }
    $(document).ready(function () {
        $("#li-stuLst").attr("class", "active");
    });
    function adding(){
        document.getElementById("on_adding").style.display='block';
        document.getElementById("on_add").style.display='none';
    }
    function cancel(){
        document.getElementById("on_adding").style.display='none';
        document.getElementById("on_add").style.display='block';  
    }
</script>
