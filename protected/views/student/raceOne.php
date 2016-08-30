<script src="<?php echo JS_URL; ?>exerJS/timeCounter.js"></script>
<script src="<?php echo JS_URL; ?>jquery.min.js" ></script>
<body>
    <h2>文本校对</h2>
    <h3>本阶段共：<?php echo $race['time']; ?> 分钟</h3>
    <h3>剩余：<span id="time"></span></h3>
    <script>
        (function () {
            var curtime = <?php echo time(); ?>;
            var endtime = <?php echo $endTime; ?>;
            tCounter(curtime, endtime, "time", endDo);
        })();
        function endDo(){
            window.parent.over(<?php echo $race['raceID']; ?>);
        }
    </script>
</body>


