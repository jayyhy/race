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
    <h2>盲打</h2>
    <div>
        <h3 style="text-align: center">持续时间以及配分</h3>
        <h3></h3>
        <form class="form-horizontal" method="post" action="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=5" id="myForm" enctype="multipart/form-data"> 
            
<!--            <div class="control-group">
                <label class="control-label">分数：</label>
                <div class="controls">
                    <textarea name="score" style="width:50px; height:20px;" id="score"><?php echo $race['score']; ?></textarea> 分
                </div>
            </div>-->

            <input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="test" />
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="input02">文件：</label>
                    <div class="controls">
                        <?php if ($race != "") { ?>
                            <div class="control-group">
                                <?php $listenpath = "./resources/race/" . $race['resourseID']; ?>
                                <?php if (file_exists($listenpath)) { ?>
                                    <audio  src = "<?php echo $listenpath; ?>" preload = "auto" controls></audio>
                                <?php } else { ?>
                                    <p style="color: red">原音频文件丢失或损坏！</p>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <input type="file" name="file" id="input02">   
                        <div id="upload" style="display:inline;" hidden="true">
                            <img src="./img/default/upload-small.gif"  alt="正在努力上传。。"/>
                            正在上传，请稍等...
                            <div id="number">0%</div>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                <label class="control-label" for="input04">上传答案</label>
                <div class="controls">
                    <input type="file" name="myfile" id="myfile" >
                </div>
            </div>
                <div class="control-group">
                    <label class="control-label" for="input03">答案：</label>
                    <div class="controls">               
                        <textarea name="content" style="width:450px; height:200px;" id="input03"><?php echo $race['content']; ?></textarea>
                        <br>字数：<span id="wordCount">0</span> 字
                    </div>
                </div> 
            </fieldset>
            <button type="submit" class="btn_4big" style="float:right">确定</button>
        </form>
    </div>
    
</div>

<script>
    <?php
    $tag = "0";
    if($race == null) {
        $tag = "1";
    }
    ?>
        var tag = <?php echo $tag; ?>;
    $("#myForm").submit(function () {
        var uploadFile = $("#input02")[0].value;
//        var time = document.querySelector("#name").value;
////        var score = document.querySelector("#score").value;
//        var reg = new RegExp("^[0-9]*$");
//        if (!(reg.test(time) && reg.test(score))) {
//            event.preventDefault();
//            window.wxc.xcConfirm('请输入数字', window.wxc.xcConfirm.typeEnum.info);
//        }
        if (uploadFile === "" && tag == "1")
        {
            window.wxc.xcConfirm('上传文件不能为空', window.wxc.xcConfirm.typeEnum.warning);
            return false;
        }
        var files =  document.getElementById("myfile").value;
        var A = $("#input03")[0].value;
        if (files === "" && A === "") {
            window.wxc.xcConfirm('内容不能为空', window.wxc.xcConfirm.typeEnum.warning);
            return false;
        }
        $("#upload").show();
        setTimeout('fetch_progress()', 1000);
    });
    function fetch_progress() {
        $.get('./index.php?r=teacher/getProgress', {'<?php echo ini_get("session.upload_progress.name"); ?>': 'test'}, function (data) {
            var progress = parseInt(data);
            $('#number').html(progress + '%');
            if (progress < 100) {
                setTimeout('fetch_progress()', 100);
            } else {
            }
        }, 'html');
    }
    $(document).ready(function () {
        var v=<?php echo Tool::clength($race['content']);?>;
        $("#wordCount").text(v);
        $("#upload").hide();
        var result = <?php echo "'$result'"; ?>;
        var result2 = <?php echo "'$result2'"; ?>;
        var result3 = <?php echo "'$result3'"; ?>;
        if (result === '0') {
            window.wxc.xcConfirm("已有班级进行需要删除的试卷，无法删除！", window.wxc.xcConfirm.typeEnum.error, {
                onOk: function () {
                    window.location.href = "./index.php?r=teacher/RaceLst";
                }
            });}else if(result3!=""){
                   window.wxc.xcConfirm(result3, window.wxc.xcConfirm.typeEnum.error);

            }else if(result2!=""){
                   window.wxc.xcConfirm(result2, window.wxc.xcConfirm.typeEnum.error);

            }else if (result === '1'){
            window.wxc.xcConfirm("操作成功！", window.wxc.xcConfirm.typeEnum.success, {
                onOk: function () {
                    window.location.href = "./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=6";
                }
            });
            }else if(result!="") {
              window.wxc.xcConfirm(result, window.wxc.xcConfirm.typeEnum.error);
            }
    });

</script>
