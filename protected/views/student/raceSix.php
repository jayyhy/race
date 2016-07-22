<script src="<?php echo JS_URL; ?>exerJS/timeCounter.js"></script>
<script src="<?php echo JS_URL; ?>jquery.min.js" ></script>
<body>
    <h2>第六阶段</h2>
    <h3>本阶段共：<?php echo $race['time']; ?> 分钟</h3>
    <h3>剩余：<span id="time"></span></h3>
    <?php $listenpath = "./resources/race/" . $race['resourseID']; ?>
    <?php if (file_exists($listenpath)) { ?>
    <video id="audio" src = "<?php echo $listenpath; ?>" preload = "auto" autoplay="true"></video>
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
        })();
        function endDo() {
            window.parent.over(<?php echo $race['raceID']; ?>);
        }
    </script>
</body>


