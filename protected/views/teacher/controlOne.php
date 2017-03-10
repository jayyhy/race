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
         width: 300px;
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
<div class="span9" style="width: 1159px;height: 750px;margin-top: -19px;background-color: #f8f4f2">
    <div style="background-color: #fbf8f7;height: 58px;width: 1159px;">
        <?php 
            $index_id=$_GET['indexID'];
            $stepName1=  Race::model()->find("indexID=? AND step=?",array($index_id,1))['raceName'];
            $stepName2=  Race::model()->find("indexID=? AND step=?",array($index_id,2))['raceName'];
            $stepName3=  Race::model()->find("indexID=? AND step=?",array($index_id,3))['raceName'];
            $stepName4=  Race::model()->find("indexID=? AND step=?",array($index_id,4))['raceName'];
            $stepName5=  Race::model()->find("indexID=? AND step=?",array($index_id,5))['raceName'];
            $stepName6=  Race::model()->find("indexID=? AND step=?",array($index_id,6))['raceName'];
        ?>
        <div class="stage" style=" margin-left: 25px;border-bottom:2px solid #ff0000; "><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=1" class="word" style=" color: #ff0000;"><?php echo $stepName1; ?></a></div>
    <?php
        if($nowOnStep == 1){
            ?>
            <div class="stage"><a href="#" class="word"><?php echo $stepName2; ?></a></div>
            <div class="stage"><a href="#" class="word"><?php echo $stepName3; ?></a></div>
            <div class="stage"><a href="#" class="word"><?php echo $stepName4; ?></a></div>
            <div class="stage"><a href="#" class="word"><?php echo $stepName5; ?></a></div>
            <div class="stage"><a href="#" class="word"><?php echo $stepName6; ?></a></div>
            <?php  }else{ 
                ?>
                    <div class="stage"><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=2" class="word"><?php echo $stepName2; ?></a></div>
                    <div class="stage"><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=3" class="word"><?php echo $stepName3; ?></a></div>
                    <div class="stage"><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=4" class="word"><?php echo $stepName4; ?></a></div>
                    <div class="stage"><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=5" class="word"><?php echo $stepName5; ?></a></div>
                    <div class="stage"><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=6" class="word"><?php echo $stepName6; ?></a></div>
            <?php  }?>
        </div>
    <div style="background-color: #fff;height: 600px;margin-top: 20px;width: 1082px;margin-left: 16px"><br><br><br><br>
            <?php
    if ($nowOnStep != 0) {
       
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
            <font class="words" style="position: relative;left: 61px;">考试时间</font>
            <h3 class="time" style="position: relative;left: 140px;top: 20px"><?php echo $race['time']/60; ?>分钟</h3>
        </div>
        <div style=" width: 320px;height: 118px;background-color: #fff;border-right:2px solid #fedfd7;float: left">
            <font class="words" style="position: relative;left: 25px;">倒计时</font>
            <h3 class="time" style="position: relative;left: 119px;top: 20px" id = "sideTime">00:00</h3>
        </div>
        <div style=" width: 320px;height: 118px;background-color: #fff;float: left">
            <font class="words" style="position: relative;left: 25px;">阶段结束时间</font>
            <div>
            <h3 class="time" style="position: relative;left: 122px;top: 20px;" id = "endTime" >未开始</h3>
            </div>
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
            tCounter(curtime, <?php
    if ($endTime == 0) {
        echo 0;
    } else {
        echo strtotime($endTime);
    }
    ?>, "sideTime", endDo,"");
        } 
//        else {
//            CDTime.focus();
//        }

        function endDo() {
            window.location.href = './index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=<?php echo $step ?>&over=1';
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

