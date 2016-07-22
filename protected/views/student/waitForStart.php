<script src="<?php echo JS_URL; ?>jquery.min.js" ></script>
<section >
    <h2>比赛即将开始，请调试控件。</h2>
    <h3>倒计时<span id = "sideTime">00:00:00</span></h3>
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
                        var nowTime = data['nowTime'];
                        var startTime = data['startTime'];
                        if (startTime > nowTime) {
                            var seconds = startTime - nowTime;
                            printTime(seconds, "sideTime");
                        }else{
                            window.parent.clearContent();
                            window.location.href = "index.php?r=student/race&raceID=" + data['raceID'];
                        }
                    }
                },
                error: function (xhr, type, exception) {
                    console.log('waitForStart error', type);
                    console.log(xhr, "Failed");
                    console.log(exception, "exception");
                }
            });
        }, 1000);
    })();
    function printTime(seconds, eleID) {
        var hh = parseInt((seconds) / 3600);
        var mm = parseInt((seconds) % 3600 / 60);
        var ss = parseInt((seconds) % 60);
        var strTime = "";
        strTime += hh < 10 ? "0" + hh : hh;
        strTime += ":";
        strTime += mm < 10 ? "0" + mm : mm;
        strTime += ":";
        strTime += ss < 10 ? "0" + ss : ss;
        document.getElementById(eleID).innerHTML = strTime;
    }
</script>
