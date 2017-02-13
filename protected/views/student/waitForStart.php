<script src="<?php echo JS_URL; ?>jquery.min.js" ></script>
<section style="height:200px;margin-left: 50px;">
    <div class="waittime"id="ready" style="text-align: center">
        <img src="<?php echo IMG_UIStu_URL; ?>null_prepare.png" height="250px" style="position: relative;top:40px">
    </div>
    <div id="beginTime" style="display:none;position: relative;" align="center">
        <img src="<?php echo IMG_UIStu_URL; ?>null_pre.png" height="250px" style="position: relative;top:40px">
        <div style="position: absolute;z-index:2;left:43%;top:50%;color: grey">倒计时：</div>
        <div style="position: absolute;z-index:2;left:48%;top:65%"><span id = "sideTime" style="font-size: 30px;color: red">00</span></div>
    </div>
</section>
<script>
    (function () {
        setInterval(function () {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "index.php?r=student/AjaxHertBeatWaitForStart",
                data: {},
                success: function (data) {
                    if (data !== 0) {
                        if(data['step'] === "6"){
                            window.location.href = "index.php?r=student/race&raceID=" + data['raceID'];
                        }
                        var nowTime = data['nowTime'];
                        var startTime = data['startTime'];
                        if (startTime > nowTime) {
                            $("#ready").hide();
                            $("#beginTime").show();
                            var seconds = startTime - nowTime;
                            printTime(seconds, "sideTime");                   
                        }else{
                            window.parent.clearContent();
                            window.location.href = "index.php?r=student/race&raceID=" + data['raceID'];
//                        $.ajax({
//                        type: "POST",
//                        dataType: 'json',
//                        url: "index.php?r=student/accepttime",
//                        data: {
//                        raceID:data['raceID'],
//                          },
//                        success: function (data) {},            
//                        error: function (xhr, type, exception) {
//                    console.log('waitForStart error', type);
//                    console.log(xhr, "Failed");
//                    console.log(exception, "exception");
//                }
//            });   
                        }
                    }
                },
                error: function (xhr, type, exception) {
                    console.log('waitForStart error', type);
                    console.log(xhr, "Failed");
                    console.log(exception, "exception");
                }
            });
        }, 500);
    })();
    function printTime(seconds, eleID) {
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
</script>
