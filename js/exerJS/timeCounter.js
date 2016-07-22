/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function printTime(seconds, eleID){
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
function tCounter(currTime, endTime, time_id, endDo){
    var seconds = endTime - currTime;
    if(seconds <= 0){
        endDo();
        return;
    }
    printTime(seconds, time_id);
    var timer = setInterval(function() {
        seconds = seconds - 1;
        if(seconds <= 0){
            endDo();
            clearInterval(timer);
        }else{
            if(seconds % 100 === 0){
                $.get("index.php?r=api/getTime",function(data,status){
                    //console.log("Data: " + data + "\nStatus: " + status);
                    seconds = endTime - parseInt(data);
                });
            }
            printTime(seconds, time_id);
        }
    }, 1000);
};
function tCounter2(currTime, endTime, time_id, endDo){
    var seconds = endTime - currTime;
    if(seconds == 0){
        endDo();
        return;
    }
    printTime(seconds, time_id);
    var timer = setInterval(function() {
        seconds = seconds - 1;
        if(seconds == 0){
            endDo();
            clearInterval(timer);
        }else{
            if(seconds % 100 === 0){
                $.get("index.php?r=api/getTime",function(data,status){
                    //console.log("Data: " + data + "\nStatus: " + status);
                    seconds = endTime - parseInt(data);
                });
            }
            printTime(seconds, time_id);
        }
    }, 1000);
};