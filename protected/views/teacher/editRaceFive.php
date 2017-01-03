<?php require 'raceLstBar.php';?>
<style>
    .stage{
        float: left;
        margin-left: 40px;
        margin-top: 20px;
        height: 35px
    }
    .word{
        font-size: 18px;
        font-weight: bold;
        color: #29282e;
    }
    .words{
       font-size: 18px;
       color: #c9c9c9;
    }
    .currentTag{
         float: right;
         margin-top: -61px;
         margin-right: 25px;
         background-color: #F8F4EE;
         width: 184px;
         height: 38px;
    }
    .wordTag1{
        font-size: 16px;
        color: #DAD9D6;
        position: relative;
        left: 18px;
        top: 9px;
    }
    .wordTag2{
        font-size: 16px;
        color: #3F3E43;
        position: relative;
        left: 24px;
        top: 9px;
    }
    
</style>
<script>
     function wo(f){
          if(f == 1){
        $("#audio1").remove() ;
        $("#a1").remove();
        $("#input").show();
        $("#span1").show();

        }
         if(f == 2){
        $("#audio2").remove() ;
        $("#a2").remove();
        $("#input02").show();
        $("#span2").show();

        }
     }
</script>
<div class="span9" style="width: 1176px;height: 800px;margin-top: -19px;background-color: #f8f4f2">
    <div style="background-color: #fbf8f7;height: 58px;width: 1159px;">
        <div class="stage" style=" margin-left: 25px;"><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=1" class="word" >文本校对</a></div>
        <div class="stage" ><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=2" class="word" >看打</a></div>
        <div class="stage" ><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=3" class="word" >听打</a></div>
        <div class="stage"><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=4" class="word">听打校对</a></div>
        <div class="stage" style="border-bottom:2px solid #ff0000; "><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=5" class="word" style=" color: #ff0000;">盲打</a></div>
        <div class="stage"><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=6" class="word">视频纠错</a></div>
    </div>
     <div style="background-color: #fff;height: 700px;margin-top: 20px;width: 1082px;margin-left: 16px;">
        <input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="test" />
        <img src="<?php echo IMG_URL_NEW; ?>icon_close.png" style="position: relative;left: 25px;top: 25px;"/><h3 style="position: relative;left: 61px;top: -18px;width: 120px">盲打</h3><br>
        <form class="form-horizontal" method="post" action="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=5" id="myForm" enctype="multipart/form-data">
           <div style="margin-top: -24px;margin-left: 60px;" >
            <?php if ($race != "") { ?>
                                <?php $listenpath = "./resources/race/" . $race['resourseID']; ?>
            <?php if (file_exists($listenpath)) { ?>
           <audio id="audio2" src = "<?php echo $listenpath; ?>" preload = "auto" controls></audio><a href="javascript:;" onclick="wo(2)" id="a2"  ><img src="<?php echo IMG_URL_NEW; ?>icon_delete_on.png" style="position: relative;left: 25px;top: -11px;" /></a>
                      <input type="file" name="file" id="input02" style="margin-bottom:2%;display: none;float: left;"> <span style=" position: relative;left: -24px;top: 4px;display: none" id="span2">(上传音频)</span>          
                     <?php } else { ?>
                                     <input type="file" name="file" id="input02" style="float: left;" > <span style=" position: relative;left: -24px;top: 0px">(上传音频)</span> <span style="color: red;position: relative;left: 1px;top: 1px;width: 360px;font-size: 16px">原音频文件丢失或损坏！</span>
                                <?php } ?>
                                    <?php } else {?>
                                    <input type="file" name="file" id="input02" style="float: left;" > <span style=" position: relative;left: -24px;top: 0px">(上传音频)</span>
            
            <?php } ?>
            
                <div id="upload" style=" float: left;display: none" >
                            <img src="./img/default/upload-small.gif"  alt="正在努力上传。。"/>
                            正在上传，请稍等...
                            <div id="number">0%</div>
                        </div>
           </div>
            <div style="clear:both; margin-top: 24px;margin-left: 60px">
                
                <input type="file" name="myfile" id="myfile" >  <span style=" position: relative;left: -24px;top: 0px">(上传答案)</span>
            </div>
            <div style="margin-top: 19px;margin-left: 60px">
                <textarea name="content" style="width:435px; height:200px;border-color: #FEE1DA;" id="content" ><?php echo $race['content']; ?></textarea>
            </div>
            <div style=" margin-left: 297px;margin-top: 25px">
                <button  class="btn_6big" style=" width: 96px">取 消</button>&nbsp;&nbsp;
                <button class="btn_5big" style=" width: 96px" type="submit">确 定</button>
            </div>
        </form>
     </div>
</div>
<!--<div class="span9">
    <h2>盲打</h2>
    <div>
        <h3 style="text-align: center">持续时间以及配分</h3>
        <h3></h3>
        <form class="form-horizontal" method="post" action="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=5" id="myForm" enctype="multipart/form-data"> 
            
            <div class="control-group">
                <label class="control-label">分数：</label>
                <div class="controls">
                    <textarea name="score" style="width:50px; height:20px;" id="score"><?php echo $race['score']; ?></textarea> 分
                </div>
            </div>

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
    
</div>-->

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
        var A = document.getElementById("content").value;
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
//        $("#wordCount").text(v);
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
