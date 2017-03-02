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
        <div class="stage" style=" margin-left: 25px;"><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=1" class="word" >文字校对</a></div>
        <div class="stage" ><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=2" class="word" >文本速录</a></div>
        <div class="stage" ><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=3" class="word" >实时速录</a></div>
        <div class="stage"><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=4" class="word">会议公文整理</a></div>
        <div class="stage" style="border-bottom:2px solid #ff0000; "><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=5" class="word" style=" color: #ff0000;">蒙目速录</a></div>
        <div class="stage"><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=6" class="word">模拟办公管理</a></div>
    </div>
     <div style="background-color: #fff;height: 700px;margin-top: 20px;width: 1082px;margin-left: 16px;">
        <input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="test" />
        <img src="<?php echo IMG_URL_NEW; ?>icon_close.png" style="position: relative;left: 25px;top: 25px;"/><h3 style="position: relative;left: 61px;top: -18px;width: 120px">蒙目速录</h3><br>
        <form class="form-horizontal" method="post" action="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=5" id="myForm" enctype="multipart/form-data">
           <div style="margin-top: -24px;margin-left: 60px;" >
            <?php if ($race != "") { ?>
                                <?php $listenpath = "./resources/race/" . $race['resourseID']; ?>
            <?php if (file_exists($listenpath)) { ?>
           <audio id="audio2" src = "<?php echo $listenpath; ?>" preload = "auto" controls></audio><a href="javascript:;" onclick="wo(2)" id="a2"  ><img src="<?php echo IMG_URL_NEW; ?>icon_delete_on.png" style="position: relative;left: 25px;top: -11px;" /></a>
                      <input type="file" name="file" id="input02" style="margin-bottom:2%;display: none;float: left;"> <span style=" position: relative;left: 47px;top: 4px;display: none" id="span2">(上传音频,mp3或wav)</span>          
                     <?php } else { ?>
                                     <input type="file" name="file" id="input02" style="float: left;" > <span style=" position: relative;left:47px;top: 0px">(上传音频,mp3或wav)</span> <span style="color: red;position: relative;left: 56px;top: 1px;width: 360px;font-size: 16px">原音频文件丢失或损坏！</span>
                                <?php } ?>
                                    <?php } else {?>
                                    <input type="file" name="file" id="input02" style="float: left;" > <span style=" position: relative;left: 47px;top: 0px">(上传音频,mp3或wav)</span>
            
            <?php } ?>
            
                <span id="upload" style=" position: relative;left: 56px;display: none" >
                            <img src="./img/default/upload-small.gif"  alt="正在努力上传。。"/>
                            正在上传，请稍等...
                            <span id="number">0%</span>
                        </span>
           </div>
            <div style="clear:both; margin-top: 24px;margin-left: 60px">
                
                <input type="file" name="myfile" id="myfile" >  <span style=" position: relative;left: 56px;top: 0px">(上传答案，txt)</span>
            </div>
            <div style="margin-top: 19px;margin-left: 60px">
                <textarea name="content" style="width:435px; height:200px;border-color: #FEE1DA;display: none" id="content" ><?php echo $race['content']; ?></textarea>
            </div>
            <div style=" margin-left: 38%;margin-top: 25px">
                <button class="btn_5big" style=" width: 96px" type="submit">确 定</button>
            </div>
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
        var A = "<?php echo $race['content']; ?>";
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
