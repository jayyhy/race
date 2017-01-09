<script src="<?php echo JS_URL; ?>exerJS/timeCounter.js"></script>
<script src="<?php echo JS_URL; ?>jquery.min.js" ></script>
<body>
    <img src="<?php echo IMG_URL_NEW; ?>icon_magnifier.png" style="position: relative;top: 31px;"/><h2 style="position: relative;left:38px;top: -18px;width: 120px">文本校对</h2>
    <div style="width: 530px;height: 350px;background-color: #ffffff;float: left">
        <h4 style="position: relative;left: 30px;color: gray;top: 10px">本阶段共：</h4>
        <h2 style="position: relative;left:230px;top:50px"><?php echo $race['time']/60; ?> 分钟</h2>
    </div>
    <div style="width: 530px;height: 350px;background-color: #ffffff;margin-left: 10px;float: left">
        <h4 style="position: relative;left: 30px;color: gray;top: 10px">剩余时间：</h4>
        <h2 style="position: relative;left:230px;top:50px"><span id="time"></span></h2>
    </div>
    
    <script>
        (function () {
            window.parent.doC();
            var curtime = <?php echo time(); ?>;
            var endtime = <?php echo $endTime; ?>;
            tCounter(curtime, endtime, "time", endDo,"");
            window.parent.stepFive();
        })();
        function endDo(){
            window.parent.over(<?php echo $race['raceID']; ?>);
        }
    </script>
</body>


