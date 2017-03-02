
<script src="<?php echo JS_URL; ?>jquery.min.js" ></script>
<?php 
require 'examSideBar.php';
?>
<script src="<?php echo JS_URL; ?>exerJS/timeCounter.js"></script>
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
       color: #767679;
    }
    .currentTag{
         float: right;
         margin-top: -61px;
         margin-right: 25px;
         background-color: #F8F4EE;
         width: 200px;
         height: 38px;
    }
    .wordTag1{
        font-size: 16px;
        color: #767679;
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
<?php $listenpath = "./resources/race/" . $race['resourseID'];
 ?>
<div class="span9" style="width: 1159px;height: 750px;margin-top: -19px;background-color: #f8f4f2">
    <div style="background-color: #fbf8f7;height: 58px;width: 1159px;">
    <?php
        if($nowOnStep == 6){?>
            <div class="stage" style=" margin-left: 25px"><a href="#" class="word">文字校对</a></div>
            <div class="stage"><a href="#" class="word">文本速录</a></div>
            <div class="stage"><a href="#" class="word">实时速录</a></div>
            <div class="stage"><a href="#" class="word">会议公文整理</a></div>    
            <div class="stage"><a href="#" class="word">蒙目速录</a></div>
    <?php }else{ ?>    
            <div class="stage" style=" margin-left: 25px"><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=1" class="word">文字校对</a></div>
            <div class="stage"><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=2" class="word">文本速录</a></div>
            <div class="stage"><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=3" class="word">实时速录</a></div>
            <div class="stage"><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=4" class="word">会议公文整理</a></div>    
            <div class="stage"><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=5" class="word">蒙目速录</a></div>
    <?php } ?>
        <div class="stage" style="border-bottom:2px solid #ff0000; "><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=6" class="word" style=" color: #ff0000;">模拟办公管理</a></div>
    </div>
    <div style="background-color: #fff;height: 600px;margin-top: 20px;width: 1082px;margin-left: 16px">
        <img src="<?php echo IMG_URL_NEW; ?>icon_video.png" style="position: relative;left: 25px;top: 25px;"/><h3 style="position: relative;left: 61px;top: -18px;width: 180px">模拟办公管理</h3>
            <?php
    if ($nowOnStep != 0) {
        if($nowOnStep == 1){?>
        
        <div class="currentTag"><span class="wordTag1">当前进行:</span><span class="wordTag2">文字校对</span></div>
      <?php
        }else if($nowOnStep == 2){?>
        
        <div class="currentTag"><span class="wordTag1">当前进行:</span><span class="wordTag2">文本速录</span></div>
      <?php
        }else if($nowOnStep == 32){
            echo '<div class="currentTag"><span class="wordTag1">当前进行:</span><span class="wordTag2">实时速录</span></div>';
        }else if($nowOnStep == 3){
            echo '<div class="currentTag"><span class="wordTag1">当前进行:</span><span class="wordTag2">实时速录</span></div>';
        }else if($nowOnStep == 4){
            echo '<div class="currentTag"><span class="wordTag1">当前进行:</span><span class="wordTag2">听到校对</span></div>';
        }else if($nowOnStep == 5){
            echo '<div class="currentTag"><span class="wordTag1">当前进行:</span><span class="wordTag2">蒙目速录</span></div>';
        }else if($nowOnStep == 6){
            echo '<div class="currentTag"><span class="wordTag1">当前进行:</span><span class="wordTag2">模拟办公管理</span></div>';
        }
    } else {?>
         <?php 
            $result = Race::model()->findAll("indexID=? AND step =? AND is_over =?", array($_GET['indexID'], $step,1));
            if(count($result)===0){
                ?>
        <button class="btn_4big" id="start" style=" float: right;margin-top: -61px;margin-right: 25px" onclick="start()"> 开始考试</button>
          <?php } else { ?>
        <button class="btn_4big" id="start" onclick="stop()" style=" float: right; margin-top: -61px;margin-right: 25px"> 开始考试</button>   
        <?php }
           } ?>
           
        <div style=" width: 320px;height: 118px;background-color: #fff;border-right:2px solid #fedfd7;float: left">
            <span class="words" style="position: relative;left: 61px;">考试时间</span>
            <h3 class="time" style="position: relative;left: 140px;top: 20px"><?php echo $race['time']/60; ?>分钟</h3>
        </div>
        <div style=" width: 320px;height: 118px;background-color: #fff;border-right:2px solid #fedfd7;float: left">
            <span class="words" style="position: relative;left: 25px;">倒计时</span>
            <h3 class="time" style="position: relative;left: 119px;top: 20px" id = "sideTime">00:00</h3>
        </div>
        <div style=" width: 320px;height: 118px;background-color: #fff;float: left">
            <span class="words" style="position: relative;left: 25px;">阶段结束时间</span>
            <div>
            <h3 class="time" style="position: relative;left: 122px;top: 20px;" id = "endTime" >未开始</h3>
            </div>
        </div>
        <div style=" width: 500px;height: 118px;margin-top: 196px">
        
        <?php if (file_exists($listenpath)) { ?>
        <span class="words" style="position: relative;left: 61px;top: -174px">考试视频</span>
        <video id="audio" style="position: relative;left: 93px;top: 9px;width: 356px;height: 200px" src="<?php echo $listenpath; ?>" preload="auto" controls="controls"  ></video><br>
    <?php } else { ?>
        <span class="words" style="position: relative;left: 61px;">考试音频</span>
       <span style="color: red;position: relative;left: 93px;top: 1px;width: 360px;font-size: 16px">原音频文件丢失或损坏！</span>
    <?php } ?>
        </div>
    </div>
</div>

<script>
    function getExam(indexID){
                 var inindexID = indexID;
        <?php 
        $teacherID = Yii::app()->session['userid_now'];
        $teacher = Teacher::model()->find("userID=?", array($teacherID));
        $oncourse = Course::model()->find("courseID=?", array($teacher['classID']));
        $onraceID = $oncourse['onRaceID'];
        $onrace = Race::model()->find("raceID=?", array($onraceID));
        $onindexID = $onrace['indexID'];
        $onstep = $onrace['step'];
        ?>   
            <?php
        if($nowOnStep == 0){ ?>
        window.location.href = "./index.php?r=teacher/control&indexID="+indexID+"&&step=1";
        <?php }else{ ?>
        var onindexID =<?php echo $onindexID?> 
        if(onindexID == inindexID){ 
        window.location.href = "./index.php?r=teacher/control&indexID=<?php echo $onindexID; ?>&&step=<?php echo $onstep; ?>";
        }
        else{
            window.wxc.xcConfirm('正在考试，暂时不能离开此试卷！', window.wxc.xcConfirm.typeEnum.error);
        }
        <?php } ?>
    }
    $(document).ready(function () {
    window.parent.doClick1();
    $("#audio").bind("contextmenu",function(e){  
          return false;  
    }); 
    });
   var doc = document;
    (function () {
        var flag = <?php echo $flag; ?>;
//        var CDTime = doc.querySelector('#CDTime');
        if (flag === 1) {
//            doc.querySelector("#start")["hidden"] = true;
            var curtime = <?php echo time(); ?>;
            var endTime = doc.querySelector("#endTime");
            endTime.innerHTML = '<?php echo $endTime; ?>';
            tCounter3(curtime, <?php
    if ($endTime == 0) {
        echo 0;
    } else {
        echo strtotime($endTime);
    }

    ?>, "sideTime", endDo,playAudio,"");
        }
//        else {
//            CDTime.focus();
//        }
         function playAudio(sideTime){
            var fristAu = document.getElementById("audio");
            var examTime = <?php echo ($race['time'] == NULL )?  0 : $race['time']; ?>;
            if(examTime === sideTime){
               fristAu.autoplay = "true";
                fristAu.style.visibility = "visible";        
            }
        }
        function endDo() {
            window.location.href = './index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=6&over=1';
        }
    })();

    function start() {
        var time = 20;
        var reg = new RegExp("^[0-9]*$");
        if(!reg.test(time)){
            window.wxc.xcConfirm('请输入正确的数字！', window.wxc.xcConfirm.typeEnum.error);
        }else{
            window.location.href = './index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=<?php echo $step ?>&raceID=<?php echo $race['raceID']; ?>&CDTime=' + time;
        }
    }
    function stop() {
    window.wxc.xcConfirm('该阶段已经考过了！', window.wxc.xcConfirm.typeEnum.error);
    }
</script>

