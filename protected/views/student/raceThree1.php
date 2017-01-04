<?php $indexID = $race['indexID'];
         $race2 = Race::model()->find("indexID = '$indexID' and step = 32");
         
   ?>
<meta http-equiv="refresh" content="300">
<script src="<?php echo JS_URL; ?>exerJS/timeCounter.js"></script>
<script src="<?php echo JS_URL; ?>jquery.min.js" ></script>
<body>
    <?php $listenpath = "./resources/race/" . $race['resourseID']; 
           $listenpath2 = "./resources/race/" . $race2['resourseID'];
            $radio = Resourse::model()->find("path='$indexID'"); 
            $dir ="./resources/race/radio";
            $file=realpath($dir . iconv("UTF-8", "gb2312", $radio['resourseID']));
            $player=new COM("WMPlayer.OCX");
            $media=$player->newMedia($file);
            $time=round($media->duration);
            $listenpath3 = "./resources/race/radio" . $radio['resourseID'];
    ?>
    <h2>听打二</h2>
    <h3>本阶段共：<?php echo floor(($race['time']+$race2['time']+$time) / 60); ?> 分 <?php echo floor(($race['time']+$race2['time']+$time)-floor(($race['time']+$race2['time']+$time) / 60) * 60); ?> 秒</h3>
    <h3>剩余：<span id="time"></span></h3>
    
    <?php if (file_exists($listenpath)) { ?>
    <div style="position:absolute;top:0px;left:500px;">
        <video id="audio" src = "<?php echo $listenpath; ?>" poster="./resources/race/01d32256f4084132f875a944080917.gif" height="200px" style="display: none"></video>
        <video id="audio3" src = "<?php echo $listenpath3; ?>" poster="./resources/race/01d32256f4084132f875a944080917.gif" preload = "auto" autoplay="true" height="200px"></video>
        <video id="audio2" src = "<?php echo $listenpath2; ?>" poster="./resources/race/01d32256f4084132f875a944080917.gif" height="200px" style="display: none"></video>
    </div>
 <?php } else { ?>
        <p style="color: red">原音频文件丢失或损坏！</p>
    <?php } ?>
    <script>
        var yaweiOCX1=window.parent.document.getElementById("typeOCX");
        function savetxt() {
            var StudentID = '<?php echo Yii::app()->session['userid_now']; ?>';
            var timestamp = (new Date()).valueOf();
            yaweiOCX1.ExportTxtFile("D:/YAWEIEXAM/3/" + 2 + <?php echo $race['raceID']; ?> + StudentID +timestamp+ ".txt");
            var raceID = <?php echo $race['raceID']; ?>;
            var route = "D:/YAWEIEXAM/3/" + 2 + <?php echo $race['raceID']; ?> + StudentID +timestamp+ ".txt";
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
            window.parent.over(<?php echo $race['raceID']; ?>,<?php echo $race['step']?>);
        }
        function playAudio(sideTime){
            var audio3 = document.getElementById("audio3");
            var audio = document.querySelector("#audio");
            var audio2 = document.getElementById("audio2");
            
            var tag = "1";
             if(audio3.ended && tag =="1"){                   
                   audio.autoplay = "true";
                   tag = "0";
                   
                }
                var flag = "1";
                if(audio.ended && flag =="1"){
                    audio2.autoplay = "true";
                    flag = "0";
                }
        }
            function timec(){
            var curtime = <?php echo time(); ?>;
            var endtime = <?php echo $endTime; ?>;
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


