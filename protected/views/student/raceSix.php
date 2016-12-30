
<script src="<?php echo JS_URL; ?>exerJS/timeCounter.js"></script>
<script src="<?php echo JS_URL; ?>jquery.min.js" ></script>
<body>
    <h2>视频纠错</h2>
    <h3>本阶段共：<?php echo floor($race['time'] / 60); ?> 分 <?php echo floor($race['time']-floor($race['time'] / 60) * 60); ?> 秒</h3>
    <h3>剩余：<span id="time"></span></h3>
    <div style="position:absolute;top:0px;left:500px;">
    <?php $listenpath = "./resources/race/" . $race['resourseID']; ?>
    <?php if (file_exists($listenpath)) { ?>

        <video id="audio" src = "<?php echo $listenpath; ?>" preload = "auto" autoplay="true" style="height:200px;"></video>
    <?php } else { ?>
        <p style="color: red">原音频文件丢失或损坏！</p>
    <?php } ?>
    </div>
    <script>
        var yaweiOCX1=window.parent.document.getElementById("typeOCX");
        var RightRadio=0;
        function savetxt() {
            var StudentID = '<?php echo Yii::app()->session['userid_now']; ?>';
            var timestamp = (new Date()).valueOf();
            yaweiOCX1.ExportTxtFile("D:/YAWEIEXAM/6/" + 2 + <?php echo $race['raceID']; ?> + StudentID +timestamp+ ".txt");
            var raceID = <?php echo $race['raceID']; ?>;
            var route = "D:/YAWEIEXAM/6/" + 2 + <?php echo $race['raceID']; ?> + StudentID +timestamp+ ".txt";
            $.ajax({
            type: "POST",
            url: "index.php?r=student/saveroute",
            data: {raceID: raceID, route:route},
            success: function () {
               
            },
            error: function (xhr, type, exception) {
                
            }
        });
        }
        function saveInReTime(){
            var yaweiOCX1=window.parent.document.getElementById("typeOCX")
            var content=yaweiOCX1.GetContent();
             window.parent.saveInRealTime(<?php echo $race['raceID']; ?>,content);
        }
        function endDo() {
            var originalContent='<?php echo $race['content'];?>';
            var content2=yaweiOCX1.GetContent();
            var worker = new Worker('js/exerJS/GetAccuracyRate.js');
            worker.onmessage = function (event) {
                if (!isNaN(event.data.accuracyRate)) {
                    window.RightRadio = event.data.accuracyRate;
                    saveRightRadio();
                }
                worker.terminate();
            };
            worker.postMessage({
                currentContent: content2,
                originalContent: originalContent
            });
            window.parent.over(<?php echo $race['raceID']; ?>,<?php echo $race['step']?>);
        }
        
        function saveRightRadio(){
            $.ajax({
                type:"POST",
                dataType:"json",
                url:"index.php?r=api/answerDataSave",
                data:{right_Radio:window.RightRadio,race_ID:<?php echo $race['raceID']; ?>},
                success:function(){
                },
                error: function (xhr) {
                    console.log(xhr, "Failed");
                }
            });
        }
        
        function timec(){
            var startTime =  <?php echo $startTime; ?>;
            var curtime = <?php echo time(); ?>;
            var endtime = <?php echo $endTime; ?>;
//            var audio = document.querySelector("#audio");
//            audio.currentTime = (curtime - startTime);
            tCounter(curtime, endtime, "time", endDo,saveInReTime);
            reciveContent(); 
        }
        setTimeout(timec,0);
        setInterval(savetxt,2000);
        function reciveContent() {
        yaweiOCX1.LoadFromTxtFile("<?php echo $route;?>");
        }
    </script>
</body>


