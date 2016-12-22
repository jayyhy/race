<div class="leftbar" style ="display: none; background: #FFE9E3;margin-left: 20px" id="on_adding">
    <div style="padding: 8px 0; height: 650px;background: #FFE9E3">
    <div style="margin-left: 10px;margin-top: 10px">
        <img src="<?php echo IMG_URL; ?>icon_test.png"/><font style="font-size:20px">&nbsp;创建试卷</font>
    </div>
        <div style="background:#FFFFFF;width: 90%;margin-left: 5%">
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
</div>
<div class="leftbar" style="margin-left: 20px" id="on_add">
    <div style="height: 100%;margin-left: 10px;margin-top: 10px">
            <img src="<?php echo IMG_URL; ?>icon_test.png"/><font style="font-size:20px">&nbsp;创建试卷</font>
            <div style="margin-top: 10px;margin-left: 10px">
         <a href="#" onclick="adding()"><img title="添加" src="<?php echo IMG_URL; ?>icon_add_1.png">&nbsp;创建试卷</a>
    </div>
    </div>
    </div>
<div class="rightbar">

    <h2>试卷列表</h2>
    <!-- 科目列表-->
    <input type="checkbox" name="all" onclick="check_all(this, 'checkbox[]')" style="margin-bottom: 3px"> 全选　　批量操作：
    <a href="#" onclick="deleCheck()"><img title="批量删除" src="<?php echo IMG_URL; ?>delete.png"></a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th class="font-center">选择</th>
                <th class="font-center">试卷号</th>
                <th class="font-center">试卷名</th>
                <th class="font-center">创建时间</th>
                <th class="font-center">操作</th>
            </tr>
        </thead>
        <tbody>        
        <form id="deleForm" method="post" action="./index.php?r=teacher/deleteRaceIndex">
            <?php foreach ($raceLst as $k => $model): ?>
                <tr>
                    <td class="font-center" style="width: 50px"> <input type="checkbox" name="checkbox[]" value="<?php echo $model['indexID']; ?>" /> </td>
                    <td class="font-center"><?php echo $model['indexID']; ?></td>
                    <td class="font-center"><?php echo $model['name']; ?></td>
                    <td class="font-center"><?php echo $model['createTime']; ?></td>
                    <td class="font-center" style="width: 100px">  
                        <a href="./index.php?r=teacher/editRace&indexID=<?php echo $model['indexID']; ?>&step=1"  ><img title="编辑" src="<?php echo IMG_URL; ?>edit.png"></a>
                        <a href="#"  onclick="deleteRaceIndex(<?php echo $model['indexID']; ?>,'<?php echo $model['name']; ?>')" ><img title="删除" src="<?php echo IMG_URL; ?>delete.png"></a>
                    </td>
                </tr>            
            <?php endforeach; ?> 
        </form>
        </tbody>
    </table>
    <!-- 学生列表结束 -->
    <!-- 显示翻页标签 -->
    <div align=center>
        <?php
        $this->widget('CLinkPager', array('pages' => $pages));
        ?>
    </div>
    <!-- 翻页标签结束 -->

    <!-- 右侧内容展示结束-->
</div>

<script>

    $(document).ready(function () {
        window.parent.doClick();
        var result = <?php echo "'$result'"; ?>;
        if (result === '1')
            window.wxc.xcConfirm("操作成功！", window.wxc.xcConfirm.typeEnum.success, {
                onOk: function () {
                    window.location.href = "./index.php?r=teacher/RaceLst";
                }
            });
        else if (result === '0') {
            window.wxc.xcConfirm("已有班级进行需要删除的科目，无法删除！", window.wxc.xcConfirm.typeEnum.error, {
                onOk: function () {
                    window.location.href = "./index.php?r=teacher/RaceLst";
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

    function addRace() {
        var courseName = document.querySelector("#value").value;
        if(courseName!==""){
            window.location.href="./index.php?r=teacher/addRaceIndex&raceName="+courseName;
        }else{
            window.wxc.xcConfirm('请输入试卷名', window.wxc.xcConfirm.typeEnum.info);
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
            window.wxc.xcConfirm('未选中任何试卷', window.wxc.xcConfirm.typeEnum.info);
        } else {
            var option = {
                title: "警告",
                btn: parseInt("0011", 2),
                onOk: function () {
                    $('#deleForm').submit();
                }
            };
            window.wxc.xcConfirm("确定删除选中的试卷吗？", "custom", option);
        }

    }
        function adding(){
        document.getElementById("on_adding").style.display='block';
        document.getElementById("on_add").style.display='none';
    }
    function cancel(){
        document.getElementById("on_adding").style.display='none';
        document.getElementById("on_add").style.display='block';  
    }
    
</script>
