<?php $indexID = $race['indexID'];
         $race2 = Race::model()->find("indexID = '$indexID' and step = 32");
         
   ?>
<meta http-equiv="refresh" content="300">
<script src="<?php echo JS_URL; ?>exerJS/timeCounter.js"></script>
<script src="<?php echo JS_URL; ?>jquery.min.js" ></script>
<body>
    <h2>听打</h2>
    <h3>本阶段共：<?php echo floor(($race['time']+$race2['time']) / 60); ?> 分 <?php echo floor(($race['time']+$race2['time'])-floor(($race['time']+$race2['time']) / 60) * 60); ?> 秒</h3>
    <h3>剩余：<span id="time"></span></h3>
    <?php $listenpath = "./resources/race/" . $race['resourseID']; 
           $listenpath2 = "./resources/race/" . $race2['resourseID'];
    ?>
    <?php if (file_exists($listenpath)) { ?>
    <div style="position:absolute;top:0px;left:500px;">
        <video id="audio" src = "<?php echo $listenpath; ?>" poster="./resources/race/01d32256f4084132f875a944080917.gif" preload = "auto" autoplay="true" height="200px"></video>
        <video id="audio2" src = "<?php echo $listenpath2; ?>" poster="./resources/race/01d32256f4084132f875a944080917.gif" height="200px" style="display: none"></video>
    </div>
 <?php } else { ?>
        <p style="color: red">原音频文件丢失或损坏！</p>
    <?php } ?>
    <script>
        (function () {
            var audio = document.querySelector("#audio");
            var startTime =  <?php echo $startTime; ?>;
            var curtime = <?php echo time(); ?>;
            var endtime = <?php echo $endTime; ?>;           
            audio.currentTime = (curtime - startTime);
            var timer = setInterval(function() {
                console.log(audio.ended);
                if(audio.ended){ 
                   
                   document.getElementById("audio2").autoplay = "true";
                   document.getElementById("audio2").diaplay = "inline"
                   clearInterval(timer);
                }
                
            },1000);
            tCounter(curtime, endtime, "time", endDo);
        })();
        function endDo() {
            window.parent.over(<?php echo $race2['raceID']; ?>,<?php echo $race2['step']?>);
        }
    </script>
</body>


