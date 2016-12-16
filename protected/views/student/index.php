<div class="span9 stuindex">
    <iframe scrolling="no" class="stuIframe" seamless src="./index.php?r=student/waitForStart"></iframe>
    <object id="typeOCX" type="application/x-itst-activex" 
            clsid="{ED848B16-B8D3-46c3-8516-E22371CCBC4B}" 
            width ='1090' height='350'
            >
    </object>
</div>
<script>
    var yaweiOCX = document.getElementById("typeOCX");
    var doc = document;
    function over(raceID, step) {
        var content = yaweiOCX.GetContent();
        if (step === 2) {
            var StudentID = '<?php echo Yii::app()->session['userid_now']; ?>';
            yaweiOCX.ExportTxtFile("D:/" + step + raceID + StudentID + ".txt");
        }
        if (step === 3) {
            var StudentID = '<?php echo Yii::app()->session['userid_now']; ?>';
            yaweiOCX.ExportTxtFile("D:/" +step+ raceID + StudentID + ".txt");
        }
        if (step === 4) {
            var StudentID = '<?php echo Yii::app()->session['userid_now']; ?>';
            yaweiOCX.ExportTxtFile("D:/" + step + raceID + StudentID + ".txt");
        }
        if (step === 5) {
            var StudentID = '<?php echo Yii::app()->session['userid_now']; ?>';
            yaweiOCX.ExportTxtFile("D:/" + step + raceID + StudentID + ".txt");
        }
        if (step === 6) {
            var StudentID = '<?php echo Yii::app()->session['userid_now']; ?>';
            yaweiOCX.ExportTxtFile("D:/" + step + raceID + StudentID + ".txt");
        }
        yaweiOCX.ClearContent();
//        window.wxc.xcConfirm("本阶段结束，将提交试卷！", window.wxc.xcConfirm.typeEnum.warning, {
//            onClose: function () {
                ajaxSubmit(raceID, content);
//            }
//        });
    }
    
    function saveInRealTime(){
        $.ajax({
            type:"POST",
            
            url:""
        });
    }

    function ajaxSubmit(raceID, content) {
        $.ajax({
            type: "POST",
            url: "index.php?r=student/over",
            data: {raceID: raceID, content: content},
            success: function (data) {
                if (data === '1') {
                    window.location.href = "index.php?r=student/index";
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

    function clearContent() {
        yaweiOCX.ClearContent();
    }

    function reciveContent(raceID) {
        var StudentID = '<?php echo Yii::app()->session['userid_now']; ?>';
        yaweiOCX.LoadFromTxtFile("D:/" + "3" + raceID + StudentID + ".txt");
    }
    
    function stepFive(){
        doc.querySelector("#typeOCX").height="30";
    }

</script>