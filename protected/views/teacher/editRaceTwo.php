<div class="span3">
    <div class="well" style="padding: 8px 0;">
        <ul class="nav nav-list">
            <li <?php
            if ($step == 1) {
                echo 'class="active"';
            }
            ?>  ><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=1"><i class="icon-align-left"></i> 文本校对</a></li>
            <li <?php
            if ($step == 2) {
                echo 'class="active"';
            }
            ?> ><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=2"><i class="icon-align-left"></i> 看打</a></li>
            <li <?php
                if ($step == 3) {
                    echo 'class="active"';
                }
                ?> ><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=3"><i class="icon-align-left"></i> 听打</a></li>
            <li <?php
            if ($step == 4) {
                echo 'class="active"';
            }
            ?> ><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=4"><i class="icon-align-left"></i> 听打校对</a></li>
            <li <?php
            if ($step == 5) {
                echo 'class="active"';
            }
            ?> ><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=5"><i class="icon-align-left"></i> 盲打</a></li>
            <li <?php
            if ($step == 6) {
                echo 'class="active"';
            }
            ?> ><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=6"><i class="icon-align-left"></i> 视频纠错</a></li>
        </ul>
    </div>
    <a href="./index.php?r=teacher/RaceLst" class="btn btn-primary" style="width: 16%;" >返回</a>
</div>
<div class="span9">
    <h2>看打</h2>
    <div>
        <h3 style="text-align: center">持续时间以及配分</h3>
        <h3></h3>
        <form class="form-horizontal" method="POST" action="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=2" enctype="multipart/form-data">
            
            <div class="control-group">
                <label class="control-label">时间：</label>
                <div class="controls">
                    <textarea name="time" style="width:50px; height:20px;" id="time" ><?php echo $race['time']/60; ?></textarea> 分钟
                </div>
            </div>
            
<!--            <div class="control-group">
                <label class="control-label">分数：</label>
                <div class="controls">
                    <textarea name="score" style="width:50px; height:20px;" id="score" ><?php echo $race['score']; ?></textarea> 分
                </div>
            </div>-->
            <div class="control-group">
                <label class="control-label" for="input04">上传答案</label>
                <div class="controls">
                    <input type="file" name="myfile" id="myfile" >
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">内容：</label>
                <div class="controls">
                    <textarea name="content" style="width:450px; height:200px;" id="content" disabled="disabled" ><?php echo $race['content']; ?></textarea>
                    <br>字数：<span id="wordCount">0</span> 字
                </div>
            </div>

            <button type="submit" class="btn_4big" style="float:right">确定</button>
        </form>
    </div>
</div>

<script>
    window.addEventListener("submit", function (event) {
        var time = document.querySelector("#time").value;
//        var score = document.querySelector("#score").value;
        var reg = new RegExp("^[0-9]*$");
        if (!reg.test(time)) {
            event.preventDefault();
            window.wxc.xcConfirm('请输入正确的数字', window.wxc.xcConfirm.typeEnum.info);
        }
        var files =  document.getElementById("myfile").value;
        var content = document.getElementById("content").value;
        if(files === "" && content === "") {
            event.preventDefault();
            window.wxc.xcConfirm('内容不能为空', window.wxc.xcConfirm.typeEnum.warning);
        }
    }, true);
    $(document).ready(function () {
        var v=<?php echo Tool::clength($race['content']);?>;
        $("#wordCount").text(v);
        var result = <?php echo "'$result'"; ?>;
        if (result === '1')
            window.wxc.xcConfirm("操作成功！", window.wxc.xcConfirm.typeEnum.success, {
                onOk: function () {
                    window.location.href = "./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=3";
                }
            });
        else if (result === '0') {
            window.wxc.xcConfirm("已有班级进行需要删除的科目，无法删除！", window.wxc.xcConfirm.typeEnum.error, {
                onOk: function () {
                    window.location.href = "./index.php?r=teacher/RaceLst";
                }
            });
        }
         else if (result != '')
        {
            window.wxc.xcConfirm(result, window.wxc.xcConfirm.typeEnum.info);
        }
        
    });
</script>
