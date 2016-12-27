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
    <h2>听打</h2>
    <div>
        <h3 style="text-align: center">持续时间以及配分</h3>
        <h3></h3>
        <form class="form-horizontal" method="post" action="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=3" id="myForm" enctype="multipart/form-data"> 
            
<!--            <div class="control-group">
                <label class="control-label">分数：</label>
                <div class="controls">
                    <textarea name="score" style="width:50px; height:20px;" id="score" ><?php echo $race['score']; ?></textarea> 分
                </div>
            </div>-->
            <?php 
            $indexID = $_GET['indexID'];
            $radio = Resourse::model()->find("path='$indexID'"); ?>
            <input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="test" />
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="input02">试音音频：</label>
                    <div class="controls">
                        <?php if ($radio != "") { ?>
                        <div class="control-group">
                                <?php $listenpath = "./resources/race/radio" . $radio['resourseID']; ?>
                                <?php if (file_exists($listenpath)) { ?>
                                    <video  src = "<?php echo $listenpath; ?>" preload = "auto" style="border:1px solid #5C595A" poster="./resources/race/01d32256f4084132f875a944080917.gif" controls></video>
                                <?php } else { ?>
                                    <p style="color: red">原音频文件丢失或损坏！</p>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <input type="file" name="files" id="input">   
                        <div id="upload3" style="display:none;" hidden="true">
                            <img src="./img/default/upload-small.gif"  alt="正在努力上传。。"/>
                            正在上传，请稍等...
                            <div id="number">0%</div>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="input02">文件：</label>
                    <div class="controls">
                        <?php if ($race != "") { ?>
                        <div class="control-group">
                                <?php $listenpath = "./resources/race/" . $race['resourseID']; ?>
                                <?php if (file_exists($listenpath)) { ?>
                                    <video  src = "<?php echo $listenpath; ?>" preload = "auto" style="border:1px solid #5C595A" poster="./resources/race/01d32256f4084132f875a944080917.gif" controls></video>
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
<!--                <div class="control-group">
                    <label class="control-label" for="input03">听打答案：</label>
                    <div class="controls">               
                        <textarea name="content" style="width:450px; height:200px;" id="input03"><?php //echo $race['content']; ?></textarea>
                        <br>字数：<span id="wordCount">0</span> 字
                    </div>
                </div> -->
            </fieldset>
            
            <!--第二个音频 -->           
<!--            <div class="control-group">
                <label class="control-label">分数：</label>
                <div class="controls">
                    <textarea name="score2" style="width:50px; height:20px;" id="score2" ><?php echo $race2['score']; ?></textarea> 分
                </div>
            </div>-->
            
            <input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="test" />
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="input02s">文件：</label>
                    <div class="controls">
                        <?php if ($race2 != "") { ?>
                        <div class="control-group">
                                <?php $listenpath2 = "./resources/race/" . $race2['resourseID']; ?>
                                <?php if (file_exists($listenpath2)) { ?>
                                    <video  src = "<?php echo $listenpath2; ?>" preload = "auto" style="border:1px solid #5C595A" poster="./resources/race/01d32256f4084132f875a944080917.gif" controls></video>
                                <?php } else { ?>
                                    <p style="color: red">原音频文件丢失或损坏！</p>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <input type="file" name="file2" id="input02s">   
                        <div id="upload2" style="display:none;" hidden="true">
                            <img src="./img/default/upload-small.gif"  alt="正在努力上传。。"/>
                            正在上传，请稍等...
                            <div id="number2">0%</div>
                        </div>
                    </div>
<!--                    (支持mp3及wav格式,最大1G)-->
                </div>
                <div class="control-group">
                <label class="control-label" for="input04">上传答案：</label>
                <div class="controls">
                    <input type="file" name="myfile" id="myfile" >
                </div>
            </div>
                <div class="control-group">
                    <label class="control-label" for="input03s">听打答案：</label>
                    <div class="controls">               
                        <textarea name="content2" style="width:450px; height:200px;" id="content2"><?php echo $race['content']; ?></textarea>
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
    $tag2 = "0";
    if($race == NULL){
       $tag = "1"; 
    }
    if($race2 == NULL){
        $tag2 = "1";
    }
    ?>
    var tag = <?php echo $tag; ?>;
    var tag2 = <?php echo $tag2; ?>;
    $("#myForm").submit(function () {
        var uploadFile = $("#input02")[0].value;
        var uploadFile2 = $("#input02s")[0].value;
//        var time = document.querySelector("#name").value;
//        var score = document.querySelector("#score").value;
//        var reg = new RegExp("^[0-9]*$");
//        if (!(reg.test(time) && reg.test(score))) {
//            event.preventDefault();
//            window.wxc.xcConfirm('请输入数字', window.wxc.xcConfirm.typeEnum.info);
//        }
        var radio = document.getElementById("input").vale;
        if(radio == ""){
            window.wxc.xcConfirm('试音文件不能为空', window.wxc.xcConfirm.typeEnum.warning);
            return false;
        }
        if (uploadFile === "" && tag=="1" )
        {
            window.wxc.xcConfirm('上传文件不能为空', window.wxc.xcConfirm.typeEnum.warning);
            return false;
        }
        
        if (uploadFile2 === "" && tag2=="1")
        {
            window.wxc.xcConfirm('上传文件不能为空', window.wxc.xcConfirm.typeEnum.warning);
            return false;
        }
        var files =  document.getElementById("myfile").value;
        var content = document.getElementById("content2").value;
        if (files === "" && content ==="") {
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
        var result4 = <?php echo "'$result4'"; ?>;
        var result5 = <?php echo "'$result5'"; ?>;
        if (result === '1')
            window.wxc.xcConfirm("操作成功！", window.wxc.xcConfirm.typeEnum.success, {
                onOk: function () {
                    window.location.href = "./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=4";
                }
            });
        else if (result === '0') {
            window.wxc.xcConfirm("已有班级进行需要删除的试卷，无法删除！", window.wxc.xcConfirm.typeEnum.error, {
                onOk: function () {
                    window.location.href = "./index.php?r=teacher/RaceLst";
                }
            });
        }else if(result4 !=""){
            window.wxc.xcConfirm(result4, window.wxc.xcConfirm.typeEnum.error);
        }
        else if(result2 !=""){
            window.wxc.xcConfirm(result2, window.wxc.xcConfirm.typeEnum.error);
        }
        else if(result3 !=""){
            window.wxc.xcConfirm(result3, window.wxc.xcConfirm.typeEnum.error);
        }else if(result5 !=""){
            window.wxc.xcConfirm(result5, window.wxc.xcConfirm.typeEnum.error);
        }
    });

</script>
