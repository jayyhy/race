
<script src="<?php echo JS_URL; ?>exerJS/timeCounter.js"></script>
<script src="<?php echo JS_URL; ?>jquery.min.js" ></script>
<body onbeforeunload="getVideoTime()">
    <div id="beginTime" style="position: relative;" align="center">
        <img src="<?php echo IMG_UIStu_URL; ?>null_pre.png" height="250px" style="position: relative;top:40px">
        <div style="position: absolute;z-index:2;left:43%;top:50%;color: grey">倒计时：</div>
        <div style="position: absolute;z-index:2;left:48%;top:65%"><span id = "sideTime" style="font-size: 30px;color: red">00</span></div>
    </div>
    <div style="margin-left: 30px;" id="examTime" style=" display:none;position: relative;">
    <img src="<?php echo IMG_URL_NEW; ?>icon_video.png" style="position: relative;top: 31px;"/><h2 style="position: relative;left:38px;top: -18px;width: 120px">视频纠错</h2>

    <?php $listenpath = "./resources/race/" . $race['resourseID']; ?>
    <?php if (file_exists($listenpath)) { ?>

        <video id="audio" src = "<?php echo $listenpath; ?>" preload = "auto" style="width: 350px; "></video>
    <?php } else { ?>
        <p style="color: red">原音频文件丢失或损坏！</p>
    <?php } ?>

    <div style="width: 150px;height: 160px;background-color: #ffffff;margin-left: 10px;float: left;margin-top: 20px;">
        <h4 style="position: relative;left: 30px;color: gray;top: 10px">本阶段共：</h4>
        <h2 style="position: relative;left:30px;top:50px"><?php echo floor($race['time'] / 60); ?> 分 <?php echo floor($race['time']-floor($race['time'] / 60) * 60); ?> 秒</h2>
    </div>
    <div style="width: 150px;height: 160px;background-color: #ffffff;margin-left: 34px;float: left;margin-top: 20px;">
        <h4 style="position: relative;left: 30px;color: gray;top: 10px">剩余时间：</h4>
        <h2 style="position: relative;left:30px;top:50px"><span id="time"></span></h2>
    </div>
    </div>
    <script>
        var qcsscc ;
        $("#examTime").hide();
        (function () {
      var side = setInterval(function () {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "index.php?r=student/AjaxHertBeatWaitForStart",
                data: {},
                success: function (data) {
                    if (data !== 0) {
                        var nowTime = data['nowTime'];
                        var startTime = data['startTime'];
                        if (startTime >nowTime) {
                            $("#beginTime").show();
                            var seconds = startTime - nowTime;
                            printTimes(seconds, "sideTime");                   
                        }else{
                            $("#beginTime").hide();
                            $("#examTime").show();
                            clearInterval(side);
                            window.parent.clearContent();
                            setTimeout(timec,0);
                            var video = document.getElementById('audio');
                            video.autoplay = "true";
                            qcsscc =  setInterval(savetxt,2239);
                            
                        }
                    }
                },
                error: function (xhr, type, exception) {
                    console.log('waitForStart error', type);
                    console.log(xhr, "Failed");
                    console.log(exception, "exception");
                }
            });
        }, 1433);
    })();
         function printTimes(seconds, eleID) {
        var hh = parseInt((seconds) / 3600);
        var mm = parseInt((seconds) % 3600 / 60);
        var ss = parseInt((seconds) % 60);
        var strTime = "";
//        strTime += hh < 10 ? "0" + hh : hh;
//        strTime += ":";
//        strTime += mm < 10 ? "0" + mm : mm;
//        strTime += ":";
        strTime += ss < 10 ? "0" + ss : ss;
        document.getElementById(eleID).innerHTML = strTime;
    }
        
        window.parent.doC();
        var StudentID = '<?php echo Yii::app()->session['userid_now']; ?>';
       function getVideoTime() {
          var video = document.getElementById('audio');
          // Store
          var current = video.currentTime;
          window.localStorage.setItem("current", current);
       }
       var video = document.getElementById('audio');
       var current = window.localStorage.getItem("current");
       if(current === null){
           
       }else {
       video.currentTime = current;
      }
        var yaweiOCX1=window.parent.document.getElementById("typeOCX");
        var RightRadio=0;
        $("#audio").bind("contextmenu",function(e){  
          return false;  
        }); 
        function savetxt() {
            var StudentID = '<?php echo Yii::app()->session['userid_now']; ?>';
            var timestamp = (new Date()).valueOf();
            yaweiOCX1.ExportTxtFile("D:/YAWEIEXAM/6/" + 2 + <?php echo $race['raceID']; ?> + StudentID +timestamp+ ".txt");
            var raceID = <?php echo $race['raceID']; ?>;
            var route = "D:/YAWEIEXAM/6/" + 2 + <?php echo $race['raceID']; ?> + StudentID +timestamp+ ".txt";
             var content=yaweiOCX1.GetContent();
             window.parent.sscc(<?php echo $race['raceID']; ?>,content,route);
        }
        function saveInReTime(){
            var content=yaweiOCX1.GetContent();
             window.parent.saveInRealTime(<?php echo $race['raceID']; ?>,content);
        }
        function endDo() {
            clearInterval(qcsscc);
            window.parent.over(<?php echo $race['raceID']; ?>,<?php echo $race['step']?>);
        }
        
        function timec(){
            var startTime =  <?php echo $startTime; ?>;
            var curtime = <?php echo time()+20; ?>;
            var endtime = <?php echo $endTime; ?>;
//            var audio = document.querySelector("#audio");
//            audio.currentTime = (curtime - startTime);
            tCounter(curtime, endtime, "time", endDo,saveInReTime);
            reciveContent(); 
        }
        
        function reciveContent() {
        yaweiOCX1.LoadFromTxtFile("<?php echo $route;?>");
        }
    </script>
</body>


