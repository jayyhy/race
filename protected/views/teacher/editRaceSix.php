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
        <?php 
            $index_id=$_GET['indexID'];
            $stepName0=  Race::model()->find("indexID=? AND step=?",array($index_id,0))['raceName'];
            $stepName1=  Race::model()->find("indexID=? AND step=?",array($index_id,1))['raceName'];
            $stepName2=  Race::model()->find("indexID=? AND step=?",array($index_id,2))['raceName'];
            $stepName3=  Race::model()->find("indexID=? AND step=?",array($index_id,3))['raceName'];
            $stepName4=  Race::model()->find("indexID=? AND step=?",array($index_id,4))['raceName'];
            $stepName5=  Race::model()->find("indexID=? AND step=?",array($index_id,5))['raceName'];
            $stepName6=  Race::model()->find("indexID=? AND step=?",array($index_id,6))['raceName'];
        ?>
        <div class="stage" style=" margin-left: 25px;"><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=0" class="word" ><?php echo $stepName0; ?></a></div>
        <div class="stage"><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=1" class="word" ><?php echo $stepName1; ?></a></div>
        <div class="stage" ><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=2" class="word" ><?php echo $stepName2; ?></a></div>
        <div class="stage" ><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=3" class="word" ><?php echo $stepName3; ?></a></div>
        <div class="stage"><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=4" class="word"><?php echo $stepName4; ?></a></div>
        <div class="stage" ><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=5" class="word" ><?php echo $stepName5; ?></a></div>
        <div class="stage" style="border-bottom:2px solid #ff0000; "><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=6" class="word" style=" color: #ff0000;"><?php echo $stepName6; ?></a></div>
    </div>
        <div style="background-color: #fff;height: 700px;margin-top: 20px;width: 1082px;margin-left: 16px;">
        <input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="test" />
        <img src="<?php echo IMG_URL_NEW; ?>icon_video.png" style="position: relative;left: 25px;top: 25px;"/><h3 style="position: relative;left: 61px;top: -18px;width: 180px">阶段六</h3>
        <form class="form-horizontal" method="post" action="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=6" id="myForm" enctype="multipart/form-data">
            <div style="margin-top: -24px;margin-left: 60px" >
                <input id="name" type="text" class="search span2" placeholder="请输入本阶段名称" name="name" style="margin-top: 13px;width: 390px;height: 25px;border-color: #FEE1DA; " value="<?php echo $race['raceName']; ?>"/>&nbsp;&nbsp;
                <span style="font-size: 16px;color: #767679;position: relative;top: 2px">(可重命名)</span>
            </div><br>  
            <div style="margin-top: -24px;margin-left: 60px" >
                <input id="time" type="text" class="search span2" placeholder="请输入考试时间" name="time" style="margin-top: 13px;width: 390px;height: 25px;border-color: #FEE1DA; " value="<?php echo $race['time']/60; ?>"/>&nbsp;&nbsp;
                <span style="font-size: 16px;color: #767679;position: relative;top: 9px">分钟</span>
            
            </div>
            <div style="margin-top: 18px;margin-left: 60px;" >
            <?php if ($race['resourseID'] != "") { ?>
                                <?php $listenpath = "./resources/race/" . $race['resourseID']; ?>
            <?php if (file_exists($listenpath)) { ?>
                <video id="audio2" src = "<?php echo $listenpath; ?>" preload = "auto" controls style=" width: 400px;height: 226px"></video><a href="javascript:;" onclick="wo(2)" id="a2"  ><img src="<?php echo IMG_URL_NEW; ?>icon_delete_on.png" style="position: relative;left: 25px;top: -11px;" /></a>
                 <input type="file" name="file" id="input02" style="float: left; display: none; margin-bottom: 2%">  <span style=" position: relative;left: 47px;top: 2px;float:24px left; display: none" id="span2">(上传视频，mp4)</span>                   
        <?php } else { ?>
                            <input type="file" name="file" id="input02" style="float: left; margin-bottom: 2%">  <span style=" position: relative;left: 47px;top: 2px;float: left; ">(上传视频，mp4)</span>        <span style="color: red;position: relative;left: 56px;top: 1px;width: 360px;font-size: 16px">原音频文件丢失或损坏！</span>
                                <?php } ?>
                                    <?php }else { ?>
                                    <input type="file" name="file" id="input02" style="float: left; margin-bottom: 2%">  <span style=" position: relative;left: 47px;top: 2px;float: left; ">(上传视频，mp4)</span>
            
            <?php } ?>
                                    
                <span id="upload" style=" position: relative;left: 56px;display: none" >
                            <img src="./img/default/upload-small.gif"  alt="正在努力上传。。"/>
                            正在上传，请稍等...
                            <span id="number">0%</span>
                        </span>
           </div>
            <div style=" margin-left: 38%;margin-top: 56px">
                <button class="btn_5big" style=" width: 96px" type="submit">确 定</button>
            </div>
        </form>
        </div>
    </div>
<script>
    <?php
    $tag = "0";
    if($race['resourseID'] == null) {
        $tag = "1";
    }
    ?>
        var tag = <?php echo $tag; ?>;
    $("#myForm").submit(function () {
        var uploadFile = $("#input02")[0].value;
        var time = document.getElementById("time").value;
//        var score = document.querySelector("#score").value;
        var reg = new RegExp("^[0-9]*$");
        if(time == ""){
            window.wxc.xcConfirm('时间不能为空', window.wxc.xcConfirm.typeEnum.info);
            return false;
        }else{
            if (!(reg.test(time))) {
            window.wxc.xcConfirm('请输入正确数字', window.wxc.xcConfirm.typeEnum.info);
            return false;
        }
        }
        
        if (uploadFile === "" && tag == "1")
        {
            window.wxc.xcConfirm('上传文件不能为空', window.wxc.xcConfirm.typeEnum.warning);
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
        window.parent.doClick();
        var v=<?php echo Tool::clength($race['content']);?>;
//        $("#wordCount").text(v);
        $("#upload").hide();
        var result = <?php echo "'$result'"; ?>;
        var result2 = <?php echo "'$result2'"; ?>;
        var result3 = <?php echo "'$result3'"; ?>;
         if(result3!=""){
                   window.wxc.xcConfirm(result3, window.wxc.xcConfirm.typeEnum.error);

            }else if(result2!=""){
                   window.wxc.xcConfirm(result2, window.wxc.xcConfirm.typeEnum.error);

            }else if (result === '1') {
            window.wxc.xcConfirm("操作成功！", window.wxc.xcConfirm.typeEnum.success, {
                onOk: function () {
                    window.location.href = "./index.php?r=teacher/raceLst";
                }
            });
        }else if (result !== "") {
            window.wxc.xcConfirm(result, window.wxc.xcConfirm.typeEnum.warning);
        } 
    });
</script>
