<script src="<?php echo JS_URL; ?>exerJS/timeCounter.js"></script>
<div class="span3">
    <div class="well" style="padding: 8px 0;">
        <ul class="nav nav-list">
            <li <?php
            if ($step == 1) {
                echo 'class="active"';
            }
            ?>  ><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=1"><i class="icon-align-left"></i> 阶段一</a></li>
            <li <?php
            if ($step == 2) {
                echo 'class="active"';
            }
            ?> ><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=2"><i class="icon-align-left"></i> 阶段二</a></li>
            <li <?php
            if ($step == 3) {
                echo 'class="active"';
            }
            ?> ><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=3"><i class="icon-align-left"></i> 阶段三</a></li>
            <li <?php
            if ($step == 4) {
                echo 'class="active"';
            }
            ?> ><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=4"><i class="icon-align-left"></i> 阶段四</a></li>
            <li <?php
            if ($step == 5) {
                echo 'class="active"';
            }
            ?> ><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=5"><i class="icon-align-left"></i> 阶段五</a></li>
            <li <?php
            if ($step == 6) {
                echo 'class="active"';
            }
            ?> ><a href="./index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=6"><i class="icon-align-left"></i> 阶段六</a></li>
        </ul>
    </div>
</div>
<div class="span9">
    <h2>第三阶段</h2>
    <?php if($nowOnStep!=0){echo '<p>当前进行:第'.$nowOnStep.'阶段</p>';}?>
    <p>考试时间:<?php echo $race['time']; ?>分钟</p>
    <p>倒计时:<font id = "sideTime">未开始</font></p>
    <p>阶段结束时间:<font id = "endTime">未开始</font></p>
    <button class="btn_4big" id="start" onclick="window.location.href = './index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=<?php echo $step?>&raceID=<?php echo $race['raceID']; ?>'">开始</button>
</div>

<script>
    (function () {
        var doc = document;
        var flag = <?php echo $flag; ?>;
        if (flag === 1) {
            doc.querySelector("#start")["hidden"]=true;
            var curtime = <?php echo time(); ?>;
            var endTime = doc.querySelector("#endTime");
            endTime.innerHTML= '<?php echo $endTime; ?>';
            tCounter(curtime, <?php if($endTime==0){ echo 0;}else{ echo strtotime($endTime);} ?>, "sideTime", endDo);
        }
        function endDo() {
            window.location.href = './index.php?r=teacher/control&indexID=<?php echo $_GET['indexID']; ?>&step=<?php echo $step+1?>&over=1';
        }
    })();
</script>

