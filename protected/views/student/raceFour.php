<!--<meta http-equiv="refresh" content="300">-->
<script src="<?php echo JS_URL; ?>exerJS/timeCounter.js"></script>
<script src="<?php echo JS_URL; ?>jquery.min.js" ></script>
<body>
    <div style="margin-left: 40px;">
    <img src="<?php echo IMG_URL_NEW; ?>icon_proof.png" style="position: relative;top: 31px;"/><h2 style="position: relative;left:38px;top: -18px;width: 120px;">听打校对</h2>
    </div>
    <div style="width: 530px;height: 150px;background-color: #ffffff;float: left;margin-left: 40px;">
        <h4 style="position: relative;left: 30px;color: gray;top: 10px">本阶段共：</h4>
        <h2 style="position: relative;left:230px;top:50px"><?php echo $race['time']/60; ?> 分钟</h2>
    </div>
    <div style="width: 530px;height: 150px;background-color: #ffffff;margin-left: 10px;float: left;margin-left: 40px;">
        <h4 style="position: relative;left: 30px;color: gray;top: 10px">剩余时间：</h4>
        <h2 style="position: relative;left:230px;top:50px"><span id="time"></span></h2>
    </div>
    <script>
        window.parent.doC();
        var yaweiOCX1=window.parent.document.getElementById("typeOCX");
        var RightRadio=0;
        var step3raceID = "<?php $step3raceID = Race::model()->find("indexID=? AND step=?", array($race['indexID'], 32)); 
        echo $step3raceID['raceID'];
        ?>";
        var StudentID = '<?php echo Yii::app()->session['userid_now']; ?>';
        function savetxt() {
            var StudentID = '<?php echo Yii::app()->session['userid_now']; ?>';
            var timestamp = (new Date()).valueOf();
            yaweiOCX1.ExportTxtFile("D:/YAWEIEXAM/4/" + 2 + <?php echo $race['raceID']; ?> + StudentID +timestamp+ ".txt");
            var raceID = <?php echo $race['raceID']; ?>;
            var route = "D:/YAWEIEXAM/4/" + 2 + <?php echo $race['raceID']; ?> + StudentID +timestamp+ ".txt";
//            $.ajax({
//            type: "POST",
//            url: "index.php?r=student/saveroute",
//            data: {raceID: raceID, route:route},
//            success: function () {
//               
//            },
//            error: function (xhr, type, exception) {
//                
//            }
//        });
             var content=yaweiOCX1.GetContent();
             window.parent.sscc(<?php echo $race['raceID']; ?>,content,route);
        }
        function saveInReTime(){
            var content=yaweiOCX1.GetContent();
             window.parent.saveInRealTime(<?php echo $race['raceID']; ?>,content);
        }
        function endDo(){
            clearInterval(qcsscc);
            <?php $StudentID = Yii::app()->session['userid_now']; ?>
            var originalContent='<?php echo Tool::removeCharacter($race['content']);?>';
            var content2=yaweiOCX1.GetContent();
            content2=content2.replace(/[\：|\—|\-|\~|\*|\￥|\$|\·|\`|\、|\“|\”|\’|\‘|\；|\;|\。|\，|\/|\%|\#|\！|\＠|\＆|\（|\）|\《|\＞|\＂|\＇|\？|\【|\】|\{|\}|\\|\｜|\+|\=|\_|\＾|\:|\》|\＜|\……|\.|\,|\!|\@|\&|\(|\)|\<|\>|\"|\?|\[|\]|]/g,"");
            content2=content2.replace(/\r\n/g, "").replace(/ /g, "");
            if(content2==""){
                <?php   $step4raceID = race::model()->find("indexID=? AND step=?", array($race['indexID'], 4))['raceID']; 
                        $content1=AnswerRecord::model()->find("raceID=? AND studentID=?",array($step4raceID,$StudentID))['content'];
                        $content2=  Tool::removeCharacter($content1);
                        $content3=  Tool::filterAllSpaceAndTab($content2);
                ?>
                content2="<?php echo $content3;?>";
            }
            var worker = new Worker('js/exerJS/GetAccuracyRate.js');
            worker.onmessage = function (event) {
                if (!isNaN(event.data.accuracyRate)) {
                    window.RightRadio = event.data.accuracyRate;
                    var rate = window.RightRadio;
                    window.parent.over(<?php echo $race['raceID']; ?>,<?php echo $race['step']?>,rate);
                }
                worker.terminate();
            };
            worker.postMessage({
                currentContent: content2,
                originalContent: originalContent
            });
           // window.parent.over(<?php //echo $race['raceID']; ?>,<?php //echo $race['step']?>);
        }
        
        function saveRightRadio(){
//            $.ajax({
//                type:"POST",
//                dataType:"json",
//                url:"index.php?r=api/answerDataSave",
//                data:{right_Radio:window.RightRadio,race_ID:<?php // echo $race['raceID']; ?>,studentID:StudentID},
//                success:function(){
//                },
//                error: function (xhr) {
//                    console.log(xhr, "Failed");
//                }
//            });
        }
        
      function timec(){
            var curtime = <?php echo time(); ?>;
            var endtime = <?php echo $endTime; ?>;
//            var lastRaceIDForStepFour = <?php //echo $lastRaceIDForStepFour;?>;
//            window.parent.reciveContent(lastRaceIDForStepFour);
            tCounter(curtime, endtime, "time", endDo,saveInReTime);
            reciveContent();
        }
        setTimeout(timec,0);
        var qcsscc =  setInterval(savetxt,2239);
         function reciveContent() {
             <?php if($route !=NULL){ ?>
        yaweiOCX1.LoadFromTxtFile("<?php echo $route;?>");

             <?php }else{ ?>
        yaweiOCX1.LoadFromTxtFile("D:/" + "32" + step3raceID + StudentID + ".txt");
            <?php } ?>        }
    </script>
</body>