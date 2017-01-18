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
            $dir ="./resources/race/radio/";
            $file=realpath($dir . iconv("UTF-8", "gb2312", $radio['resourseID']));
            $player=new COM("WMPlayer.OCX");
            $media=$player->newMedia($file);
            $time=round($media->duration);
            $listenpath3 = "./resources/race/radio/" . $radio['resourseID'];
    ?>
    <div style="margin-left: 60px;">
    <img src="<?php echo IMG_URL_NEW; ?>icon_horn.png" style="position: relative;top: 31px;"/><h2 style="position: relative;left:38px;top: -18px;width: 120px">听打(一)</h2>
    </div>
        <?php if (file_exists($listenpath)) { ?>
    <div style="width: 300px;height: 200px;background-color: #ffffff;float: left;margin-left:60px;">
        <video id="audio" src = "<?php echo $listenpath; ?>" poster="./resources/race/01d32256f4084132f875a944080917.gif" height="200px" style="display: none"></video>
        <video id="audio3" src = "<?php echo $listenpath3; ?>" poster="./resources/race/01d32256f4084132f875a944080917.gif" preload = "auto" autoplay="true" height="200px"></video>
        <video id="audio2" src = "<?php echo $listenpath2; ?>" poster="./resources/race/01d32256f4084132f875a944080917.gif" height="200px" style="display: none"></video>
    </div>
 <?php } else { ?>
        <p style="color: red">原音频文件丢失或损坏！</p>
    <?php } ?>
    <div style="width: 300px;height: 150px;background-color: #ffffff;margin-left: 60px;float: left">
        <h4 style="position: relative;left: 30px;color: gray;top: 10px">本阶段共：</h4>
        <h2 style="position: relative;left:100px;top:50px"><?php echo floor(($race['time']+$time) / 60); ?> 分 <?php echo floor(($race['time']+$time)-floor(($race['time']+$time) / 60) * 60); ?> 秒</h2>
    </div>
    <div style="width: 300px;height: 150px;background-color: #ffffff;margin-left: 60px;float: left">
        <h4 style="position: relative;left: 30px;color: gray;top: 10px">剩余时间：</h4>
        <h2 style="position: relative;left:100px;top:50px"><span id="time"></span></h2>
    </div>
    <script>
        window.parent.doC();
        var yaweiOCX1=window.parent.document.getElementById("typeOCX");
        var StudentID = '<?php echo Yii::app()->session['userid_now']; ?>';
        var RightRadio=0;
        function savetxt() {
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
            var content=yaweiOCX1.GetContent();
             window.parent.saveInRealTime(<?php echo $race['raceID']; ?>,content);
        }
        function endDo() {
            <?php $StudentID = Yii::app()->session['userid_now']; ?>
            var originalContent='<?php echo Tool::removeCharacter($race['content']);?>';
            var content2=yaweiOCX1.GetContent();
            content2=content2.replace(/[\：|\—|\-|\~|\*|\￥|\$|\·|\`|\、|\“|\”|\’|\‘|\；|\;|\。|\，|\/|\%|\#|\！|\＠|\＆|\（|\）|\《|\＞|\＂|\＇|\？|\【|\】|\{|\}|\\|\｜|\+|\=|\_|\＾|\:|\》|\＜|\……|\.|\,|\!|\@|\&|\(|\)|\<|\>|\"|\?|\[|\]|]/g,"");
            content2=content2.replace(/\r\n/g, "").replace(/ /g, "");
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
                data:{right_Radio:window.RightRadio,race_ID:<?php echo $race['raceID']; ?>,studentID:StudentID},
                success:function(){
                },
                error: function (xhr) {
                    console.log(xhr, "Failed");
                }
            });
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


