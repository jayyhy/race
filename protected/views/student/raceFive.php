<meta http-equiv="refresh" content="300">
<script src="<?php echo JS_URL; ?>exerJS/timeCounter.js"></script>
<script src="<?php echo JS_URL; ?>jquery.min.js" ></script>
<body>
    <h2>盲打</h2>
    <h3>本阶段共：<?php echo floor($race['time'] / 60); ?> 分 <?php echo floor($race['time']-floor($race['time'] / 60) * 60); ?> 秒</h3>
    <h3>剩余：<span id="time"></span></h3>
    <?php $listenpath = "./resources/race/" . $race['resourseID']; ?>
    <?php if (file_exists($listenpath)) { ?>
    <audio id="audio" src = "<?php echo $listenpath; ?>" preload = "auto" autoplay="true"></audio>
    <?php } else { ?>
        <p style="color: red">原音频文件丢失或损坏！</p>
    <?php } ?>
    <script>
        (function () {
            var startTime =  <?php echo $startTime; ?>;
            var curtime = <?php echo time(); ?>;
            var endtime = <?php echo $endTime; ?>;
            var audio = document.querySelector("#audio");
            audio.currentTime = (curtime - startTime);
            tCounter(curtime, endtime, "time", endDo);
//            window.parent.stepFive();
        })();
        function endDo() {
            window.parent.over(<?php echo $race['raceID']; ?>,<?php echo $race['step']?>);
        }
    </script>
</body>


