<meta http-equiv="refresh" content="300">
<script src="<?php echo JS_URL; ?>exerJS/timeCounter.js"></script>
<script src="<?php echo JS_URL; ?>jquery.min.js" ></script>
<body>
    <h2>听打校对</h2>
    <h3>本阶段共：<?php echo $race['time']/60; ?> 分钟</h3>
    <h3>剩余：<span id="time"></span></h3>
    <script>
        var yaweiOCX1=window.parent.document.getElementById("typeOCX");
        var RightRadio=0;
        var step3raceID = <?php $step3raceID = race::model()->find("indexID=? AND step=?", array($race['indexID'], 32)); 
        echo $step3raceID['raceID'];
        ?>;
        var StudentID = '<?php echo Yii::app()->session['userid_now']; ?>';
        function savetxt() {
            var StudentID = '<?php echo Yii::app()->session['userid_now']; ?>';
            var timestamp = (new Date()).valueOf();
            yaweiOCX1.ExportTxtFile("D:/YAWEIEXAM/4/" + 2 + <?php echo $race['raceID']; ?> + StudentID +timestamp+ ".txt");
            var raceID = <?php echo $race['raceID']; ?>;
            var route = "D:/YAWEIEXAM/4/" + 2 + <?php echo $race['raceID']; ?> + StudentID +timestamp+ ".txt";
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
        function endDo(){
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
            var curtime = <?php echo time(); ?>;
            var endtime = <?php echo $endTime; ?>;
            var lastRaceIDForStepFour = <?php echo $lastRaceIDForStepFour;?>;
            window.parent.reciveContent(lastRaceIDForStepFour);
            tCounter(curtime, endtime, "time", endDo,saveInReTime);
            reciveContent();
        }
        setTimeout(timec,0);
        setInterval(savetxt,2000);
         function reciveContent() {
             <?php if($route !=NULL){ ?>
        yaweiOCX1.LoadFromTxtFile("<?php echo $route;?>");

             <?php }else{ ?>
        yaweiOCX1.LoadFromTxtFile("D:/" + "32" + step3raceID + StudentID + ".txt");
            <?php } ?>        }
    </script>
</body>