<div class="span3" style ="display: none;" id="on_adding">
    <div class="well" style="padding: 8px 0; height: 650px;">
        <ul class="nav nav-list" style="margin-top: 100px">
            <li class="divider"></li><br>
            <li>
                <input id="value" type="text" class="search-query span2" placeholder="考场名称" />
                <input id="kaohao" type="text" class="search-query span2" placeholder="考号" />
                <input id="renshu" type="text" class="search-query span2" placeholder="人数" />
            </li>
            <li style="margin-top:10px">
                <button onclick="addCourse()" class="btn_4big">添 加</button>
            </li><br>
            <li class="divider"></li>
        </ul>
    </div>
</div>
<div class="span3" id="on_add">
    <div class="well" style="padding: 8px 0; height: 650px">
        <div style="margin-top: 100px">
                <a href="#" onclick="adding()"><img title="添加" src="<?php echo IMG_URL; ?>add.jpg"></a>
            </div>
    </div>
</div>
<div class="span9">

    <h2>考场列表</h2>
    <!-- 科目列表-->
<!--    <input type="checkbox" name="all" onclick="check_all(this, 'checkbox[]')" style="margin-bottom: 3px"> 全选　　批量操作：
    <a href="#" onclick="deleCheck()"><img title="批量删除" src="<?php echo IMG_URL; ?>delete.png"></a>-->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
<!--                <th class="font-center">选择</th>-->
<!--                <th class="font-center">考场号</th>-->
                <th class="font-center">考场名</th>
                <th class="font-center">创建时间</th>
                <th class="font-center">操作</th>
            </tr>
        </thead>
        <tbody>        
        <form id="deleForm" method="post" action="./index.php?r=admin/deleteCourse">
            <?php foreach ($courseLst as $k => $model): ?>
                <tr>
<!--                    <td class="font-center" style="width: 50px"> <input type="checkbox" name="checkbox[]" value="<?php //echo $model['courseID']; ?>" /> </td>-->
<!--                    <td class="font-center"><?php //echo $model['courseID']; ?></td>-->
                    <td class="font-center"><?php echo $model['name']; ?></td>
                    <td class="font-center"><?php echo $model['createTime']; ?></td>
                    <td class="font-center" style="width: 100px">  
<!--                        <a href="#"  ><img title="查看" src="<?php echo IMG_URL; ?>detail.png"></a>-->
                        <a href="#"  onclick="deleteCourse(<?php echo $model['courseID']; ?>,'<?php echo $model['name']; ?>')" ><img title="删除" src="<?php echo IMG_URL; ?>delete.png"></a>
                    </td>
                </tr>            
            <?php endforeach; ?> 
        </form>
        </tbody>
    </table>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th class="font-center">考号</th>
                <th class="font-center">姓名</th>
            </tr>
        </thead>
        <tbody>   
    <?php foreach ($student as $allstu){ ?>
                  <tr>
                    <td class="font-center"><?php echo $allstu['userID']; ?></td>
                    <td class="font-center"><?php echo $allstu['userName']; ?></td>
                </tr>           
<?php }?>
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
</div>
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
                    window.wxc.xcConfirm('请在人数框里输入大于0小鱼100的正整数', window.wxc.xcConfirm.typeEnum.info);
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
</script>
