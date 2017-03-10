<div class="span3">
    <div class="well" style="padding: 8px 0;">
        <ul class="nav nav-list">
            <li <?php
            if ($step == 1) {
                echo 'class="active"';
            }
            ?>  ><a href="./index.php?r=admin/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=1"><i class="icon-align-left"></i> 1</a></li>
            <li <?php
            if ($step == 2) {
                echo 'class="active"';
            }
            ?> ><a href="./index.php?r=admin/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=2"><i class="icon-align-left"></i> 2</a></li>
            <li <?php
            if ($step == 3) {
                echo 'class="active"';
            }
            ?> ><a href="./index.php?r=admin/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=3"><i class="icon-align-left"></i> 3</a></li>
            <li <?php
            if ($step == 4) {
                echo 'class="active"';
            }
            ?> ><a href="./index.php?r=admin/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=4"><i class="icon-align-left"></i> 4</a></li>
            <li <?php
            if ($step == 5) {
                echo 'class="active"';
            }
            ?> ><a href="./index.php?r=admin/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=5"><i class="icon-align-left"></i> 5</a></li>
            <li <?php
            if ($step == 6) {
                echo 'class="active"';
            }
            ?> ><a href="./index.php?r=admin/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=6"><i class="icon-align-left"></i> 6</a></li>
        </ul>
    </div>
</div>
<div class="span9">
    <h2>6</h2>
    <div>
        <h3 style="text-align: center">持续时间以及配分</h3>
        <h3></h3>
        <form class="form-horizontal" method="post" action="./index.php?r=admin/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=6" id="myForm" enctype="multipart/form-data"> 
            
            <div class="control-group">
                <label class="control-label">分数：</label>
                <div class="controls">
                    <textarea name="score" style="width:50px; height:20px;" id="score"><?php echo $race['score']; ?></textarea> 分
                </div>
            </div>
 
<!--            <span>(支持mp4及flv格式,最大2G)</span>-->
            <input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="test" />
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="input02">文件</label>
                    <div class="controls">
                        <?php if ($race != "") { ?>
                            <div class="control-group">
                                <?php $listenpath = "./resources/race/" . $race['resourseID']; ?>
                                <?php if (file_exists($listenpath)) { ?>
                                    <video  src = "<?php echo $listenpath; ?>" preload = "auto" controls></video>
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
                    <label class="control-label" for="input03">参考答案</label>
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
    $("#myForm").submit(function () {
        var uploadFile = $("#input02")[0].value;
        var time = document.querySelector("#name").value;
        var score = document.querySelector("#score").value;
        var reg = new RegExp("^[0-9]*$");
        if (!(reg.test(time) && reg.test(score))) {
            event.preventDefault();
            window.wxc.xcConfirm('请输入数字', window.wxc.xcConfirm.typeEnum.info);
        }
        if (uploadFile === "")
        {
            window.wxc.xcConfirm('上传文件不能为空', window.wxc.xcConfirm.typeEnum.warning);
            return false;
        }
        var A = $("#input03")[0].value;
        if (A === "") {
            window.wxc.xcConfirm('内容不能为空', window.wxc.xcConfirm.typeEnum.warning);
            return false;
        }
        $("#upload").show();
        setTimeout('fetch_progress()', 1000);
    });
    function fetch_progress() {
        $.get('./index.php?r=admin/getProgress', {'<?php echo ini_get("session.upload_progress.name"); ?>': 'test'}, function (data) {
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
        if (result === '1') {
            window.wxc.xcConfirm("操作成功！", window.wxc.xcConfirm.typeEnum.success, {
                onOk: function () {
                    window.location.href = "./index.php?r=admin/raceLst";
                }
            });
        } else if (result !== "") {
            window.wxc.xcConfirm(result, window.wxc.xcConfirm.typeEnum.warning);
        }
    });
</script>
