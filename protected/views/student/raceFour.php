<meta http-equiv="refresh" content="300">
<script src="<?php echo JS_URL; ?>exerJS/timeCounter.js"></script>
<script src="<?php echo JS_URL; ?>jquery.min.js" ></script>
<body>
    <h2>听打校对</h2>
    <h3>本阶段共：<?php echo $race['time']/60; ?> 分钟</h3>
    <h3>剩余：<span id="time"></span></h3>
    <script>
        var yaweiOCX1=window.parent.document.getElementById("typeOCX");
        function savetxt() {
            var StudentID = '<?php echo Yii::app()->session['userid_now']; ?>';
            var timestamp = (new Date()).valueOf();
            yaweiOCX1.ExportTxtFile("D:/YAWEIEXAM/4/" + 2 + <?php echo $race['raceID']; ?> + StudentID +timestamp+ ".txt");
        }
        function saveInReTime(){
            var yaweiOCX1=window.parent.document.getElementById("typeOCX")
            var content=yaweiOCX1.GetContent();
             window.parent.saveInRealTime(<?php echo $race['raceID']; ?>,content);
        }
        function endDo(){
            window.parent.over(<?php echo $race['raceID']; ?>,<?php echo $race['step']?>);
        }
      function timec(){
            var curtime = <?php echo time(); ?>;
            var endtime = <?php echo $endTime; ?>;
            var lastRaceIDForStepFour = <?php echo $lastRaceIDForStepFour;?>;
            window.parent.reciveContent(lastRaceIDForStepFour);
            tCounter(curtime, endtime, "time", endDo,saveInReTime);
        }
        setTimeout(timec,0);
        setInterval(savetxt,10000)
    </script>
</body>