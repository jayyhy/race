<div class="span3">
    <div class="well" style="padding: 8px 0;">
        <ul class="nav nav-list">
            <li class="nav-header"><i class="icon-plus"></i>添加</li>
            <li>
                <input id="value" type="text" class="search-query span2" placeholder="试卷名称" />
            </li>
            <li style="margin-top:10px">
                <button onclick="addRace()" class="btn_4big">添 加</button>
            </li>
            <li class="divider"></li>
            <li class="active" ><a href="./index.php?r=teacher/raceLst"><i class="icon-align-left"></i> 试卷列表</a></li>
        </ul>
    </div>
</div>
<div class="span9">

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
</script>
