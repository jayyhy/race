<?php $indexID = $race['indexID'];
         $race2 = Race::model()->find("indexID = '$indexID' and step = 32");
         
   ?>
<!--<meta http-equiv="refresh" content="300">-->
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
    <div style="margin-left: 50px;">
    <img src="<?php echo IMG_URL_NEW; ?>icon_horn.png" style="position: relative;top: 31px;"/><h2 style="position: relative;left:38px;top: -18px;width: 120px">听打(二)</h2>
    <?php if (file_exists($listenpath)) { ?>
    <div style="width: 310px;height: 200px;background-color: #ffffff;float: left">
                <?php 
                $Picture = Picture::model()->find();
                if($Picture != ""){
                    $pic = $Picture['New_Name'];
                    $filePath="./resources/race/".$pic;
                 if(file_exists($filePath)){
                     ?>
         <video id="audio" src = "<?php echo $listenpath; ?>" poster="<?php echo $filePath; ?>" height="250px" style="display: none"></video>
        <video id="audio3" src = "<?php echo $listenpath3; ?>" poster="<?php echo $filePath; ?>" preload = "auto" autoplay="true" height="250px"></video>
        <video id="audio2" src = "<?php echo $listenpath2; ?>" poster="<?php echo $filePath; ?>" height="250px" style="display: none"></video>
        
                                 <?php        
        }
              }else{
                     ?>
        <video id="audio" src = "<?php echo $listenpath; ?>" poster="./resources/race/01d32256f4084132f875a944080917.gif" height="250px" style="display: none"></video>
        <video id="audio3" src = "<?php echo $listenpath3; ?>" poster="./resources/race/01d32256f4084132f875a944080917.gif" preload = "auto" autoplay="true" height="250px"></video>
        <video id="audio2" src = "<?php echo $listenpath2; ?>" poster="./resources/race/01d32256f4084132f875a944080917.gif" height="250px" style="display: none"></video>
    </div>
    <?php } }else { ?>
        <p style="color: red">原音频文件丢失或损坏！</p>
    <?php } ?>
    <div style="width: 300px;height: 150px;background-color: #ffffff;margin-left: 10px;float: left">
        <h4 style="position: relative;left: 30px;color: gray;top: 10px">本阶段共：</h4>
        <h2 style="position: relative;left:100px;top:50px"><?php echo floor(($race2['time']) / 60); ?> 分 <?php echo floor($race2['time']-floor($race2['time'] / 60) * 60); ?> 秒</h2>
    </div>
    <div style="width: 300px;height: 150px;background-color: #ffffff;margin-left: 10px;float: left">
        <h4 style="position: relative;left: 30px;color: gray;top: 10px">剩余时间：</h4>
        <h2 style="position: relative;left:100px;top:50px"><span id="time"></span></h2>
    </div>
    </div>
    <script>
        var yaweiOCX1=window.parent.document.getElementById("typeOCX");
        var raceID = <?php echo $race['raceID']; ?>;
        var StudentID = '<?php echo Yii::app()->session['userid_now']; ?>';
        function savetxt() {
            var timestamp = (new Date()).valueOf();
            yaweiOCX1.ExportTxtFile("D:/YAWEIEXAM/3/" + 2 + <?php echo $race['raceID']; ?> + StudentID +timestamp+ ".txt");
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
            <?php   $step31Content = race::model()->find("indexID=? AND step=?", array($race['indexID'], 3))['content']; 
                    $StudentID = Yii::app()->session['userid_now']; 
                    $step31raceID = race::model()->find("indexID=? AND step=?", array($race['indexID'], 3))['raceID']; ?>;
            var originalContent='<?php echo Tool::removeCharacter($step31Content);?>';
            var content2 = yaweiOCX1.GetContent();
            content2=content2.replace(/[\：|\—|\-|\~|\*|\￥|\$|\·|\`|\、|\“|\”|\’|\‘|\；|\;|\。|\，|\/|\%|\#|\！|\＠|\＆|\（|\）|\《|\＞|\＂|\＇|\？|\【|\】|\{|\}|\\|\｜|\+|\=|\_|\＾|\:|\》|\＜|\……|\.|\,|\!|\@|\&|\(|\)|\<|\>|\"|\?|\[|\]|]/g,"");
            content2=content2.replace(/\r\n/g, "").replace(/ /g, "");
            if(content2==""){
                <?php   $step32raceID=  Race::model()->find("indexID=? AND step=?",array($race['indexID'],32))['raceID'];
                        $content321=AnswerRecord::model()->find("raceID=? AND studentID=?",array($step32raceID,$StudentID))['content'];
                        $content322=  Tool::removeCharacter($content321);
                        $content323=  Tool::filterAllSpaceAndTab($content322);
                ?>
                content2="<?php echo $content323; ?>";
            }
            <?php   $answer1=AnswerRecord::model()->find("raceID=? AND studentID=?", array($step31raceID, $StudentID))['content']; 
                    $answer2= Tool::removeCharacter($answer1);
                    $answer3= Tool::filterAllSpaceAndTab($answer2);
            ?>
            var content3 ="<?php echo $answer3; ?>";
            content2 = content3+content2;
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
//            window.parent.over(<?php// echo $race['raceID']; ?>,<?php //echo $race['step']?>);
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
        var qcsscc =  setInterval(savetxt,2239);
        function reciveContent() {
        yaweiOCX1.LoadFromTxtFile("D:/" + "3" + raceID + StudentID + ".txt");
        }
        
        function saveRightRadio(){
//            $.ajax({
//                type:"POST",
//                dataType:"json",
//                url:"index.php?r=api/answerDataSave",
//                data:{right_Radio:window.RightRadio,race_ID:<?php //echo $race['raceID']; ?>,studentID:StudentID},
//                success:function(){
//                },
//                error: function (xhr) {
//                    console.log(xhr, "Failed");
//                }
//            });
        }
        
    </script>
</body>


