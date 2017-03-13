<div class="stuindex">
    <iframe scrolling="no" class="stuIframe" seamless src="./index.php?r=student/waitForStart"></iframe>
    <div style="float: right;margin-left: 0px;margin-top: 40px;">
        <div id="bgyw" style=" width :860px; height:560px; background: #A9A5A3;">
            <div style=" margin-left :5px; padding-top: 5px;">
    <object id="typeOCX" type="application/x-itst-activex" 
            clsid="{ED848B16-B8D3-46c3-8516-E22371CCBC4B}" 
            width ='850' height='550'
            >
    </object>
            </div>
        </div>
        </div>
</div>
<script>
    $(document).ready(function () {
      <?php if(isset($showname)){ ?>
alert("<?php echo "请确认你的考号："."$showname";?>");
window.location.href = "./index.php?r=student/index";
                <?php } ?>
    });
    var yaweiOCX = document.getElementById("typeOCX");
    var doc = document;
    var dialogArgument;
    function over(raceID, step,rate) {
        var content="";
        if (step === 2) {
            content = yaweiOCX.GetContent();
            var StudentID = '<?php echo Yii::app()->session['userid_now']; ?>';
            yaweiOCX.ExportTxtFile("D:/" + step + raceID + StudentID + ".txt");
            yaweiOCX.ClearContent();
        }
        if (step === 3) {
            content = yaweiOCX.GetContent();
            var StudentID = '<?php echo Yii::app()->session['userid_now']; ?>';
            yaweiOCX.ExportTxtFile("D:/" +step+ raceID + StudentID + ".txt");
            yaweiOCX.ClearContent();
        }
        if (step === 4) {
            content = yaweiOCX.GetContent();
            var StudentID = '<?php echo Yii::app()->session['userid_now']; ?>';
            yaweiOCX.ExportTxtFile("D:/" + step + raceID + StudentID + ".txt");
            yaweiOCX.ClearContent();
        }
        if (step === 5) {
            content = yaweiOCX.GetContent();
            var StudentID = '<?php echo Yii::app()->session['userid_now']; ?>';
            yaweiOCX.ExportTxtFile("D:/" + step + raceID + StudentID + ".txt");
            yaweiOCX.ClearContent();
        }
        if (step === 6) {
            content = yaweiOCX.GetContent();
            var StudentID = '<?php echo Yii::app()->session['userid_now']; ?>';
            yaweiOCX.ExportTxtFile("D:/" + step + raceID + StudentID + ".txt");
            yaweiOCX.ClearContent();
        }
        if (step === 32) {
            content = yaweiOCX.GetContent();
            var StudentID = '<?php echo Yii::app()->session['userid_now']; ?>';
            yaweiOCX.ExportTxtFile("D:/" + step + raceID + StudentID + ".txt");
            yaweiOCX.ClearContent();
        }
//        window.wxc.xcConfirm("本阶段结束，将提交试卷！", window.wxc.xcConfirm.typeEnum.warning, {
//            onClose: function () {
                ajaxSubmit(raceID, content,rate);
//            }
//        });
    }
    
    function saveInRealTime(raceID, content){
//        $.ajax({
//            type: "POST",
//            url: "index.php?r=student/over",
//            data: {raceID: raceID, content: content},
//            success: function (data) {
//            },
//            error: function (xhr, type, exception) {
//                console.log('waitForStart error', type);
//                console.log(xhr, "Failed");
//                console.log(exception, "exception");
//            }
//        });
    }

    function ajaxSubmit(raceID, content,rate) {
        $.ajax({
            type: "POST",
            url: "index.php?r=student/over",
            data: {raceID: raceID, content: content,rate:rate},
            success: function (data) {
                if (data === '1') {
                    window.location.href = "index.php?r=student/index";
                    window.localStorage.removeItem("current");
                    window.localStorage.removeItem("currentThree");
                    window.localStorage.removeItem("currentFive");
                } else {
                    window.wxc.xcConfirm("交卷失败！请联系监考老师备份答案！", window.wxc.xcConfirm.typeEnum.warning);
                }
            },
            error: function (xhr, type, exception) {
                window.wxc.xcConfirm("交卷失败！请联系监考老师备份答案！", window.wxc.xcConfirm.typeEnum.warning);
                console.log('waitForStart error', type);
                console.log(xhr, "Failed");
                console.log(exception, "exception");
            }
        });
    }
       function sscc(raceID, content,route){
        $.ajax({
            type: "POST",
            url: "index.php?r=student/sscc",
            data: {raceID: raceID, content: content, route:route},
            success: function (data) {
            },
            error: function (xhr, type, exception) {
                console.log('waitForStart error', type);
                console.log(xhr, "Failed");
                console.log(exception, "exception");
            }
        });
    }


    function clearContent() {
        yaweiOCX.ClearContent();
    }

    function reciveContent(raceID) {
//        yaweiOCX.LoadFromTxtFile("D:/" + "3" + raceID + StudentID + ".txt");
    }
    
    function stepFive(){
        doc.querySelector("#typeOCX").height="0";
        $("#bgyw").hide();
    }

</script>