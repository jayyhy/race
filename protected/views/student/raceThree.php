
<!--<meta http-equiv="refresh" content="300">-->
<script src="<?php echo JS_URL; ?>exerJS/timeCounter.js"></script>
<script src="<?php echo JS_URL; ?>jquery.min.js" ></script>
<body onbeforeunload="getVideoTime()">
    <?php $listenpath = "./resources/race/" . $race['resourseID']; 
    ?>
    <div style="margin-left: 60px;">
    <img src="<?php echo IMG_URL_NEW; ?>icon_horn.png" style="position: relative;top: 31px;"/><h2 style="position: relative;left:38px;top: -18px;width: 300px"><?php echo $race['raceName'];?></h2>
    </div>
        <?php if (file_exists($listenpath)) { ?>
    <div style=" text-align: center">
    <div style="width: 300px;height: 200px;background-color: #ffffff;float: left;margin-left:60px;">
        <?php 
                $Picture = Picture::model()->find();
                $pic = $Picture['New_Name'];
                $filePath="./resources/race/".$pic;
                if($Picture != "" && file_exists($filePath)){
                 
                     ?>
        <video id="audio" src = "<?php echo $listenpath; ?>" poster="<?php echo $filePath; ?>" preload = "auto" autoplay="true" height="200px"></video>
            <?php        

              }else{
        ?>
        <video id="audio" src = "<?php echo $listenpath; ?>" poster="./resources/race/01d32256f4084132f875a944080917.gif" preload = "auto" autoplay="true" height="200px" ></video>
              <?php }} else { ?>
        <p style="color: red">原音频文件丢失或损坏！</p>
    <?php } ?>
    <div style="width: 300px;height: 150px;background-color: #ffffff;margin-left: -1px;float: left">
        <h4 style="position: relative;left: -86px;color: gray;top: 10px">本阶段共：</h4>
        <h2 style="position: relative;left:-6px;top:31px"><?php echo floor(($race['time']) / 60); ?> 分 <?php echo floor(($race['time'])-floor(($race['time']) / 60) * 60); ?> 秒</h2>
    </div>
    <div style="width: 300px;height: 150px;background-color: #ffffff;margin-left: -1px;float: left">
        <h4 style="position: relative;left: -86px;color: gray;top: 10px">剩余时间：</h4>
        <h2 style="position: relative;left:-6px;top:31px"><span id="time"></span></h2>
    </div>
    </div>
    </div>
    <script>
        window.parent.doC();
        var yaweiOCX1=window.parent.document.getElementById("typeOCX");
        var StudentID = '<?php echo Yii::app()->session['userid_now']; ?>';
        function getVideoTime() {
          var video = document.getElementById('audio');
          // Store
          var current = video.currentTime;
          window.localStorage.setItem("currentThree", current);
       }
       var video = document.getElementById('audio');
       var current = window.localStorage.getItem("currentThree");
       if(current === null){
           
       }else {
       video.currentTime = current;
      }
        var RightRadio=0;
        function savetxt() {
            var timestamp = (new Date()).valueOf();
            yaweiOCX1.ExportTxtFile("D:/YAWEIEXAM/3/" + 2 + <?php echo $race['raceID']; ?> + StudentID +timestamp+ ".txt");
            var raceID = <?php echo $race['raceID']; ?>;
            var route = "D:/YAWEIEXAM/3/" + 2 + <?php echo $race['raceID']; ?> + StudentID +timestamp+ ".txt";
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
        function endDo() {
            clearInterval(qcsscc);
            <?php $StudentID = Yii::app()->session['userid_now']; ?>
            var originalContent='<?php echo Tool::removeCharacter($race['content']);?>';
            var content2=yaweiOCX1.GetContent();
            content2=content2.replace(/[\||\…|\^|\：|\—|\-|\~|\*|\￥|\$|\·|\`|\、|\“|\”|\’|\‘|\；|\;|\。|\，|\/|\%|\#|\！|\＠|\＆|\（|\）|\《|\＞|\＂|\＇|\？|\【|\】|\{|\}|\\|\｜|\+|\=|\_|\＾|\:|\》|\＜|\……|\.|\,|\!|\@|\&|\(|\)|\<|\>|\"|\?|\[|\]|]/g,"");
            content2=content2.replace(/\r\n/g, "").replace(/ /g, "").replace(/[　]/g, "");
            if(content2==""){
                <?php 
                        $step31raceID = race::model()->find("indexID=? AND step=?", array($race['indexID'], 3))['raceID']; 
                        $content31=AnswerRecord::model()->find("raceID=? AND studentID=?",array($step31raceID,$StudentID))['content'];
                        $content32=  Tool::removeCharacter($content31);
                        $content33=  Tool::filterAllSpaceAndTab($content32);
                ?>
                content2="<?php echo $content33; ?>";
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
//            window.parent.over(<?php //echo $race['raceID']; ?>,<?php //echo $race['step']?>);
        }
        
        function saveRightRadio(){
//            $.ajax({
//                type:"POST",
//                dataType:"json",
//                url:"index.php?r=api/answerDataSave",
//                data:{right_Radio:window.RightRadio,race_ID:<?php echo $race['raceID']; ?>,studentID:StudentID},
//                success:function(){
//                },
//                error: function (xhr) {
//                    console.log(xhr, "Failed");
//                }
//            });
        }
        
        function playAudio(sideTime){
            var audio = document.querySelector("#audio");
        }
            function timec(){
            var curtime = <?php echo time(); ?>;
            var endtime = <?php echo $endTime; ?>;
            tCounter(curtime, endtime, "time", endDo,saveInReTime);
            reciveContent();
        }
        setTimeout(timec,0);
        var qcsscc =  setInterval(savetxt,2239);
        function reciveContent() {
        yaweiOCX1.LoadFromTxtFile("<?php echo $route;?>");
        }
    </script>
</body>


