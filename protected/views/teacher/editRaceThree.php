<?php require 'raceLstBar.php';?>
<script src="<?php echo JS_URL; ?>jquery.min.js" ></script>
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
<?php
         $listenpath1 = "./resources/race/" . $race['resourseID'];
         $index_id=$_GET['indexID'];
         $stepName0=  Race::model()->find("indexID=? AND step=?",array($index_id,0))['raceName'];
         $stepName1=  Race::model()->find("indexID=? AND step=?",array($index_id,1))['raceName'];
         $stepName2=  Race::model()->find("indexID=? AND step=?",array($index_id,2))['raceName'];
         $stepName3=  Race::model()->find("indexID=? AND step=?",array($index_id,3))['raceName'];
         $stepName4=  Race::model()->find("indexID=? AND step=?",array($index_id,4))['raceName'];
         $stepName5=  Race::model()->find("indexID=? AND step=?",array($index_id,5))['raceName'];
         $stepName6=  Race::model()->find("indexID=? AND step=?",array($index_id,6))['raceName'];
?>
<div class="span9" style="width: 1176px;height: 800px;margin-top: -19px;background-color: #f8f4f2">
    <div style="background-color: #fbf8f7;height: 58px;width: 1159px;">
        <div class="stage" style=" margin-left: 25px;"><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=0" class="word" ><?php echo $stepName0; ?></a></div>
        <div class="stage"><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=1" class="word" ><?php echo $stepName1; ?></a></div>
        <div class="stage" ><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=2" class="word" ><?php echo $stepName2; ?></a></div>
        <div class="stage" style="border-bottom:2px solid #ff0000; "><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=3" class="word" style=" color: #ff0000;"><?php echo $stepName3; ?></a></div>
        <div class="stage"><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=4" class="word"><?php echo $stepName4; ?></a></div>
        <div class="stage"><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=5" class="word"><?php echo $stepName5; ?></a></div>
        <div class="stage"><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=6" class="word"><?php echo $stepName6; ?></a></div>
    </div>
    <div style="background-color: #fff;height: 700px;margin-top: 20px;width: 1082px;margin-left: 16px;">
        <input type="hidden" name="<?php echo ini_get("session.upload_progress.name"); ?>" value="test" />
        <img src="<?php echo IMG_URL_NEW; ?>icon_horn.png" style="position: relative;left: 25px;top: 25px;"/><h3 style="position: relative;left: 61px;top: -18px;width: 120px">阶段三</h3>
        <form class="form-horizontal" method="post" action="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=3" id="myForm" enctype="multipart/form-data">
            <div style="margin-top: -24px;margin-left: 60px" >
                <input id="name" type="text" class="search span2" placeholder="请输入本阶段名称" name="name" style="margin-top: 13px;width: 390px;height: 25px;border-color: #FEE1DA; " value="<?php echo $race['raceName']; ?>"/>&nbsp;&nbsp;
                <span style="font-size: 16px;color: #767679;position: relative;top: 10px">(可重命名)</span>
            </div><br><br>
            
            <div style="margin-top: -24px;margin-left: 60px;" >
               <?php if ($race['resourseID']!="" ) { ?>
                                <?php $listenpath1 = "./resources/race/" . $race['resourseID'];
                                ?>
            <?php if (file_exists($listenpath1)) { ?>
                 <audio id="audio2" src = "<?php echo $listenpath1; ?>" preload = "auto" controls></audio><a href="javascript:;" onclick="wo(2)" id="a2"  ><img src="<?php echo IMG_URL_NEW; ?>icon_delete_on.png" style="position: relative;left: 25px;top: -11px;" /></a>
                      <input type="file" name="file" id="input02" style="margin-top: 17px;display: none"> <span style=" position: relative;left: 47px;top: 11px;display: none" id="span2">(上传音频,mp3或wav)</span>          
                     <?php } else { ?>
                                    <input type="file" name="file" id="input02" style="margin-top: 22px"> <span style=" position: relative;left: 47px;top: 11px">(上传音频,mp3或wav)</span><span style="color: red;position: relative;left: 56px;top: 1px;width: 360px;font-size: 16px">原音频文件丢失或损坏！</span>
                                <?php } ?>
                                    <?php } else {?>
                                    <input type="file" name="file" id="input02" style="margin-top: 22px"> <span style=" position: relative;left: 47px;top: 11px">(上传音频,mp3或wav)</span>
                <?php } ?>
                                     <span id="upload" style=" position: relative;left: 56px;display: none" >
                            <img src="./img/default/upload-small.gif"  alt="正在努力上传。。"/>
                            正在上传，请稍等...
                            <span id="number">0%</span>
                        </span>
            </div>
            <div style="margin-top: 24px;margin-left: 60px">
                
                <input type="file" name="myfile" id="myfile" >  <span style=" position: relative;left: 56px;top: 2px">(上传答案，txt)</span>
            </div>
            <div style="margin-top: 19px;margin-left: 60px">
                <textarea name="content" style="width:435px; height:200px;border-color: #FEE1DA; display: none" id="content" ><?php echo $race['content']; ?></textarea>
            </div>
             <div style="margin-top: 9px;margin-left: 60px">
             <input type="file" name="picfile" id="pic" style="float: left;">  <span style=" position: relative;left: 47px;top: 2px;float: left;">(上传音频图片)</span>
            </div>
            <div style=" margin-left: 38%;margin-top: 55px">
                <button class="btn_5big" style=" width: 96px" type="submit">确 定</button>
            </div>
            
        </form>
    </div>
</div>


<script>
    
    <?php 
    $tag = "0";
    if($race['resourseID'] == NULL){
       $tag = "1"; 
    }
    ?>
    var tag = <?php echo $tag; ?>;
    $("#myForm").submit(function () {
        var uploadFile = $("#input02")[0].value;
        if (uploadFile === "" && tag=="1" )
        {
            window.wxc.xcConfirm('上传文件不能为空', window.wxc.xcConfirm.typeEnum.warning);
            return false;
        }
        var content = "<?php echo $race['content']; ?>";
        var files =  document.getElementById("myfile").value;
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
        window.parent.doClick();
        var v=<?php echo Tool::clength($race['content']);?>;
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
    //移除标签


</script>

