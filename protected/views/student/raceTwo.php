<meta http-equiv="refresh" content="300">
<script src="<?php echo JS_URL; ?>exerJS/timeCounter.js"></script>
<script src="<?php echo JS_URL; ?>jquery.min.js" ></script>
<body>
    <img src="<?php echo IMG_URL_NEW; ?>icon_open.png" style="position: relative;top: 31px;"/><h2 style="position: relative;left:38px;top: -18px;width: 120px">看打</h2>
    <div style="width: 530px;height: 350px;background-color: #ffffff;float: left">
        <h4 style="position: relative;left: 30px;color: gray;top: 10px">本阶段共：</h4>
        <h2 style="position: relative;left:230px;top:50px"><?php echo $race['time']/60; ?> 分钟</h2>
    </div>
    <div style="width: 530px;height: 350px;background-color: #ffffff;margin-left: 10px;float: left">
        <h4 style="position: relative;left: 30px;color: gray;top: 10px">剩余时间：</h4>
        <h2 style="position: relative;left:230px;top:50px"><span id="time"></span></h2>
    </div>
    <script>
        window.parent.doC();
        var yaweiOCX1=window.parent.document.getElementById("typeOCX");
        var RightRadio=0;
        function savetxt() {
            var StudentID = '<?php echo Yii::app()->session['userid_now']; ?>';
            var timestamp = (new Date()).valueOf();
            yaweiOCX1.ExportTxtFile("D:/YAWEIEXAM/2/" + 2 + <?php echo $race['raceID']; ?> + StudentID +timestamp+ ".txt");
            var route = "D:/YAWEIEXAM/2/" + 2 + <?php echo $race['raceID']; ?> + StudentID +timestamp+ ".txt";
            var raceID = <?php echo $race['raceID']; ?>;
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
//            var yaweiOCX1=window.parent.document.getElementById("typeOCX")
            var content=yaweiOCX1.GetContent();
             window.parent.saveInRealTime(<?php echo $race['raceID']; ?>,content);
        }
        function endDo(){
            <?php $StudentID = Yii::app()->session['userid_now']; ?>
            var originalContent='<?php echo $race['content'];?>';
            var content2=yaweiOCX1.GetContent();
            if(content2==""){
                <?php $step2raceID = race::model()->find("indexID=? AND step=?", array($race['indexID'], 2))['raceID']; ?>;
                content2="<?php echo AnswerRecord::model()->find("raceID=? AND studentID=?",array($step2raceID,$StudentID))['content'];?>";
            }
            currentCount = content2.length;
            originalCount = originalContent.length;
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
            tCounter(curtime, endtime, "time", endDo,saveInReTime);
            reciveContent();
        }
        setTimeout(timec,0);
        setInterval(savetxt,2000)
        function reciveContent() {
        yaweiOCX1.LoadFromTxtFile("<?php echo $route;?>");
        }
    </script>
</body>