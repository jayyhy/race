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
    <h2>盲打</h2>
    <?php
    if ($nowOnStep != 0) {
        echo '<p>当前进行:第' . $nowOnStep . '阶段</p>';
    } else {
        ?>
<!--        <p>设置准备时间:<input style="width: 30px" id="CDTime"/>秒</p>-->
    <?php } ?>
    <p>考试时间:<?php echo floor($race['time'] / 60); ?> 分 <?php echo floor($race['time']-floor($race['time'] / 60) * 60); ?> 秒</p>
    <p>倒计时:<font id = "sideTime">未开始</font></p>
    <p>阶段结束时间:<font id = "endTime">未开始</font></p>
    <button class="btn_4big" id="start" onclick="start()">开始</button>
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
            tCounter(curtime, <?php
    if ($endTime == 0) {
        echo 0;
    } else {
        echo strtotime($endTime);
    }
    ?>, "sideTime", endDo);
        }
//        else {
//            CDTime.focus();
//        }

        function endDo() {
            window.location.href = './index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=<?php echo $step + 1 ?>&over=1';
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
</script>

