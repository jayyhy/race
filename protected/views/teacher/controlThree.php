<script src="<?php echo JS_URL; ?>exerJS/timeCounter.js"></script>
<div class="span3">
    <div class="well" style="padding: 8px 0;">
        <ul class="nav nav-list">
            <li <?php
            if ($step == 1) {
                echo 'class="active"';
            }
            ?>  ><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=1"><i class="icon-align-left"></i> 文本校对</a></li>
            <li <?php
            if ($step == 2) {
                echo 'class="active"';
            }
            ?> ><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=2"><i class="icon-align-left"></i> 看打</a></li>
            <li <?php
            if ($step == 3) {
                echo 'class="active"';
            }
            ?> ><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=3"><i class="icon-align-left"></i> 听打</a></li>
            <li <?php
            if ($step == 4) {
                echo 'class="active"';
            }
            ?> ><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=4"><i class="icon-align-left"></i> 听打校对</a></li>
            <li <?php
            if ($step == 5) {
                echo 'class="active"';
            }
            ?> ><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=5"><i class="icon-align-left"></i> 盲打</a></li>
            <li <?php
            if ($step == 6) {
                echo 'class="active"';
            }
            ?> ><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=6"><i class="icon-align-left"></i> 视频纠错</a></li>
        </ul>
    </div>
</div>
<div class="span9">
    <h2>听打</h2>
    <?php
    if ($nowOnStep != 0) {
        if($nowOnStep == 1){
            echo '<p>当前进行:文本校对</p>';
        }else if($nowOnStep == 2){
            echo '<p>当前进行:看打</p>';
        }else if($nowOnStep == 3){
            echo '<p>当前进行:听打</p>';
        }else if($nowOnStep == 4){
            echo '<p>当前进行:听打校对</p>';
        }else if($nowOnStep == 5){
            echo '<p>当前进行:盲打</p>';
        }else if($nowOnStep == 6){
            echo '<p>当前进行:视频纠错</p>';
        }
    } else {
        ?>
<!--        <p>设置准备时间:<input style="width: 30px" id="CDTime"/>秒</p>-->
    <?php } ?>
    <?php $listenpath = "./resources/race/" . $race['resourseID']; 
           $listenpath2 = "./resources/race/" . $race2['resourseID'];
            $indexID = $_GET['indexID'];
            $radio = Resourse::model()->find("path='$indexID'"); 
            $dir ="./resources/race/radio";
            $file=realpath($dir . iconv("UTF-8", "gb2312", $radio['resourseID']));
            $player=new COM("WMPlayer.OCX");
            $media=$player->newMedia($file);
            $time=round($media->duration);
            $listenpath3 = "./resources/race/radio" . $radio['resourseID'];
    ?>
    <p>考试时间:<?php echo floor(($race['time'] +$race2['time']+$time)/ 60); ?> 分 <?php echo floor(($race['time'] +$race2['time']+$time)-floor(($race['time'] +$race2['time']+$time) / 60) * 60); ?> 秒</p>
    <p>倒计时:<font id = "sideTime">未开始</font></p>
    <p>阶段结束时间:<font id = "endTime">未开始</font></p>
    <?php 
            $result = Race::model()->findAll("indexID=? AND step =? AND is_over =?", array($_GET['indexID'], $step,1));
            if(count($result)===0){
                ?>
    <button class="btn_4big" id="start" onclick="start()"> 开始</button>
    <?php } else { ?>
    <button class="btn_4big" id="start" onclick="stop()"> 开始</button>   
     <?php
            } 
        ?>

    
    <?php if (file_exists($listenpath)) { ?>
    <audio id="audition" style="visibility: hidden" src="<?php echo $listenpath3; ?>" preload="auto" controls="controls"  ></audio>
    <audio id="fristAu" style="visibility: hidden" src="<?php echo $listenpath; ?>" preload="auto" controls="controls"  ></audio>
    <audio id="secondAu" style="visibility: hidden" src="<?php echo $listenpath2; ?>" preload="auto" controls="controls" ></audio>
    <?php } else { ?>
        <p style="color: red">原音频文件丢失或损坏！</p>
    <?php } ?>
</div>

<script>
    var doc = document;
    (function () {
        var flag = <?php echo $flag; ?>;
//        var CDTime = doc.querySelector('#CDTime');
        if (flag === 1) {
            doc.querySelector("#start")["hidden"] = true;
            var curtime = <?php echo time(); ?>;
            var endTime = doc.querySelector("#endTime");
            endTime.innerHTML = '<?php echo $endTime; ?>';
            tCounter3(curtime, <?php
    if ($endTime == 0) {
        echo 0;
    } else {
        echo strtotime($endTime);
    }
    ?>, "sideTime", endDo , playAudio,"");
        }
//        else {
//            CDTime.focus();
//        }
        function playAudio(sideTime){
            var fristAu = document.getElementById("fristAu");
            var secondAu = document.getElementById("secondAu");
            var audition = document.getElementById("audition");
            var tag ="1";
            var flag ="1";
            var examTime = <?php echo $race['time'] +$race2['time'] +$time;?>;
            if(examTime == sideTime){
               audition.autoplay = "true";
                audition.style.visibility = "visible";                 
            }
            if(audition.ended && tag == "1"){
                fristAu.autoplay = "true";
               audition.style.visibility = "hidden";
                fristAu.style.visibility = "visible";
                tag ="0";
            }
            if(fristAu.ended && flag == "1"){
                secondAu.autoplay = "true";
               fristAu.style.visibility = "hidden";
                secondAu.style.visibility = "visible";
                flag ="0";
            }
        }
        function endDo() {
            window.location.href = './index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=<?php echo $step ?>&over=1';
        }
    })();

    function start() {
//        var time = doc.querySelector('#CDTime').value;
        var time =20;
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

