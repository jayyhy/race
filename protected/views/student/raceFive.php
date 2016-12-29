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
        var yaweiOCX1=window.parent.document.getElementById("typeOCX");
        function savetxt() {
            var StudentID = '<?php echo Yii::app()->session['userid_now']; ?>';
            var timestamp = (new Date()).valueOf();
            yaweiOCX1.ExportTxtFile("D:/YAWEIEXAM/5/" + 2 + <?php echo $race['raceID']; ?> + StudentID +timestamp+ ".txt");
        }
        function saveInReTime(){
            var yaweiOCX1=window.parent.document.getElementById("typeOCX")
            var content=yaweiOCX1.GetContent();
             window.parent.saveInRealTime(<?php echo $race['raceID']; ?>,content);
        }
        function endDo() {
            window.parent.over(<?php echo $race['raceID']; ?>,<?php echo $race['step']?>);
        }
        function timec(){
            var startTime =  <?php echo $startTime; ?>;
            var curtime = <?php echo time(); ?>;
            var endtime = <?php echo $endTime; ?>;
//            var audio = document.querySelector("#audio");
//            audio.currentTime = (curtime - startTime);
            tCounter(curtime, endtime, "time", endDo,saveInReTime);
        }
        setTimeout(timec,0);
        setInterval(savetxt,10000)
    </script>
</body>


