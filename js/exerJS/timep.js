var hh = 0;
var mm = 0;
var ss = 0;
var strTime = '';
var timer;
var ti;
var isExam;
function startTime() {
    timer = window.setInterval(function () {
        if (window.G_startFlag === 1 && window.G_pauseFlag === 0) {
            changWordPS();
            strTime = "";
            if (++ss == 60)
            {
                if (++mm == 60)
                {
                    hh++;
                    mm = 0;
                }
                ss = 0;
            }
            strTime += hh < 10 ? "0" + hh : hh;
            strTime += ":";
            strTime += mm < 10 ? "0" + mm : mm;
            strTime += ":";
            strTime += ss < 10 ? "0" + ss : ss;
            document.getElementById('timej').innerHTML = strTime;
            if (window.G_endAnalysis === 1) {
                clearInterval(timer);
            }
        }
    }, 1000);
}
;
function startTime2() {
    timer = window.setInterval(function () {
        changWordPS();
        strTime = "";
        if (ss-- == 0)
        {
            if (--mm < 0)
            {
                hh--;
                mm = 59;
            }
            ss = 59;
        }
        strTime += hh < 10 ? "0" + hh : hh;
        strTime += ":";
        strTime += mm < 10 ? "0" + mm : mm;
        strTime += ":";
        strTime += ss < 10 ? "0" + ss : ss;
        if (document.getElementById('time') !== null) {
            document.getElementById('time').innerHTML = strTime;
        }
    }, 1000);
}
;
function getSeconds() {
    return paseInt(hh) * 3600 + paseInt(mm) * 60 + ss;
}
function changWordPS() {
    var length = getWordLength();
    var timeAll = ss / 60 + mm + hh * 60;
    if (isExam == 1) {
        var timeAll = ti - (ss / 60 + mm + hh * 60);
    }
    if (isNaN(timeAll)) {
        timeAll = 0;
    }
    var wps = Math.round(length / timeAll);
    if (timeAll !== 0 && document.getElementById("wordps") !== null)
        document.getElementById("wordps").innerHTML = wps;
}
function getSeconds() {
    var seconds = ss + mm * 60 + hh * 3600;
    return seconds;
}
function getT() {
    return ti;
}
function reloadTime2(tim, isExa) {
    isExam = isExa;
    ti = tim;
    hh = parseInt((tim * 60) / 3600);
    mm = parseInt((tim * 60) % 3600 / 60);
    ss = parseInt((tim * 60) % 60);
    strTime = "";
    strTime += hh < 10 ? "0" + hh : hh;
    strTime += ":";
    strTime += mm < 10 ? "0" + mm : mm;
    strTime += ":";
    strTime += ss < 10 ? "0" + ss : ss;
    if (document.getElementById('time') !== null) {
        document.getElementById('time').innerHTML = strTime;
    }
    clearInterval(timer);
    startTime2();
}
;

function reloadTime() {
    hh = 0;
    mm = 0;
    ss = 0;
    strTime = '00:00:00';
    if (document.getElementById('timej') !== null) {
        document.getElementById('timej').innerHTML = strTime;
    }
    startTime();
}
;
$(document).ready(function () {
    reloadTime();
});