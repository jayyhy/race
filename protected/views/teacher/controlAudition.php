<?php 
require 'examSideBar.php';
?>
<script src="<?php echo JS_URL; ?>exerJS/timeCounter.js"></script>
<style>
    .stage{
        float: left;
        margin-left: 40px;
        margin-top: 20px;
        height: 35px;
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
<?php      
            $listenpath = "./resources/race/" . $race['resourseID']; 
            $index_id=$_GET['indexID'];
            $stepName0=  Race::model()->find("indexID=? AND step=?",array($index_id,0))['raceName'];
            $stepName1=  Race::model()->find("indexID=? AND step=?",array($index_id,1))['raceName'];
            $stepName2=  Race::model()->find("indexID=? AND step=?",array($index_id,2))['raceName'];
            $stepName3=  Race::model()->find("indexID=? AND step=?",array($index_id,3))['raceName'];
            $stepName4=  Race::model()->find("indexID=? AND step=?",array($index_id,4))['raceName'];
            $stepName5=  Race::model()->find("indexID=? AND step=?",array($index_id,5))['raceName'];
            $stepName6=  Race::model()->find("indexID=? AND step=?",array($index_id,6))['raceName'];
    ?>
<div class="span9" style="width: 1159px;height: 750px;margin-top: -19px;background-color: #f8f4f2">
 <div style="background-color: #fbf8f7;height: 58px;width: 1159px;">
    <div class="stage" style=" margin-left: 25px;border-bottom:2px solid #ff0000; "><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=0" class="word" style=" color: #ff0000;"><?php echo $stepName0; ?></a></div>
    <div class="stage"><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=1" class="word"><?php echo $stepName1; ?></a></div>
    <div class="stage"><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=2" class="word"><?php echo $stepName2; ?></a></div>
    <div class="stage"><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=3" class="word"><?php echo $stepName3; ?></a></div>
    <div class="stage"><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=4" class="word"><?php echo $stepName4; ?></a></div>
    <div class="stage"><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=5" class="word"><?php echo $stepName5; ?></a></div>
    <div class="stage"><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=6" class="word"><?php echo $stepName6; ?></a></div>
 </div>
    <div style="background-color: #fff;height: 600px;margin-top: 20px;width: 1082px;margin-left: 16px"><br><br><br><br>
    <?php if (file_exists($listenpath)) { ?>
        
        <audio id="fristAu" style="position: relative;left: 50px;top: 9px;width: 360px" src="<?php echo $listenpath; ?>" preload="auto" controls=""></audio>
        <span style="position: relative;left: 70px;">(试音音频,音频开始播放后不可点击其他页面，否则将停止播放。)</span><br>
    <?php } else { ?>
       <span style="color: red;position: relative;left: 70px;top: 1px;width: 360px;font-size: 16px">原音频文件丢失或损坏！</span>
    <?php } ?>
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
        window.location.href = "./index.php?r=teacher/control&indexID="+indexID+"&&step=0";
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
    
    </script>
