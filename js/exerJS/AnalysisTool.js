/* 
 * Js AnalysisTool
 * 注意！需要依赖LCS.js
 * 请在主view中设置全局变量 
 * @param G_setEndTime 设置统计的轮询刷新开始到结束的时间，如果你想让JS1000秒后结束统计请设置1000
 * @param  var G_isOverFlag= 0 ; view 中 设置window.G_isOverFlag = 1 统计控件将结束统计
 * @param  var G_isPause= 0 ; view 中 设置window.G_isPause = 1 统计控件将暂停统计
 * 声明全局变量   
 * @param  var G_content="";
 * @param  var G_keyContent="";
 * @param  var G_startTime      = 0;
 * @param  var G_startFlag      = 0;
 * @param  var G_countAllKey    = 0;
 * @param  var G_countMomentKey = 0;
 * @param  var G_pressTime      = 0;
 * @param  var G_highIntervarlTime  = 0;
 * @param  var G_endAnalysis    = 0;
 * 
 */
var yaweiOCX = {};
var G_isKeyType = 0;
var G_exerciseType = "";
var G_isLook = 0;
var G_keyBoardBreakPause = 0;
var G_saveToDatabase = 0;
var G_isOverFlag = 0;
var G_isPause = 0;
var G_content = "";
var G_keyContent = "";
var G_startTime = 0;
var G_startFlag = 0;
var G_countAllKey = 0;
var G_countMomentKey = 0;
var G_pressTime = 0;
var G_oldStartTime = 0;
var G_highIntervarlTime = 0;
var G_endAnalysis = 0;
var G_oldContentLength = 0;
var G_exerciseData = new Array();
var G_squence = 0;
var G_pauseFlag = 0;
var G_briefResult = "false";
//获取的统计内容之全局变量
var GA_originalContent = "";
var GA_answer = "";
var GA_averageKeyType = 0;
var GA_highstCountKey = 0;
var GA_highstSpeed = 0;
var GA_averageSpeed = 0;
var GA_CountBackDelete = 0;
var GA_IntervalTime = 0;
var GA_highIntervarlTime = 0;
var GA_RightRadio = 0;
var GA_CountAllKey = 0;
var GA_pauseOn = 0;
//统计逻辑
$(document).ready(function () {
    var highstCountKey = 0;
    var highstSpeed = 0;
    var pauseTime = 0;
    var pauseOn = 0;
    //2s内统计统计瞬时击键 次/秒
    //@param id=getMomentKeyType 请将瞬时击键统计的控件id设置为getMomentKeyType
    //2s内统计统计最高击键 次/秒
    //@param id=getHighstCountKey 请将最高击键统计的控件id设置为getHighstCountKey
    //2s内统计统计平均击键 次/分钟
    //@param id=getAverageKeyType 请将最高击键统计的控件id设置为getAverageKeyType
    //2s内统计统计总按键数 次
    //@param id=getcountAllKey 请将最高击键统计的控件id设置为getcountAllKey
    //2s内统计统计平均速度 字/分钟
    //@param id=getAverageSpeed 请将平均速度统计的控件id设置为getAverageSpeed
    //2s内统计最高平均速度 字/分钟
    //@param id=getHighstSpeed 请将最高平均速度统计的控件id设置为getHighstSpeed
    //2s内统计瞬时速度     字/分钟
    //@param id=getMomentSpeed 请将最高平均速度统计的控件id设置为getMomentSpeed 
    //2s内统计回改字数     字
    //@param id=getBackDelete 请将最高平均速度统计的控件id设置为getBackDelete  
    var interval = setInterval(function () {
        var worker;
        var content = window.G_content;
        var keyContent = window.G_keyContent;
        var setEndTime = window.G_setEndTime;
        var startTime = window.G_startTime;
        var countAllKey = window.G_countAllKey;
        var countMomentKey = window.G_countMomentKey;
        var myDate = new Date();
        var nowTime = myDate.getTime();
        //暂停开关
        if (window.G_isPause === 1) {
            if (pauseOn === 0) {
                window.G_keyBoardBreakPause = 1;
                pauseTime = nowTime;
                pauseOn = 1;
                window.G_pauseFlag = 1;
            } else {
                pauseOn = 0;
                window.G_pauseFlag = 0;
                window.G_startTime = (nowTime - pauseTime) + window.G_startTime;
                startTime = window.G_startTime;
            }
            window.G_isPause = 0;
        }
        if (window.G_keyBoardBreakPause === 0 && pauseOn === 1) {
            pauseOn = 0;
            window.G_pauseFlag = 0;
            window.G_startTime = (nowTime - pauseTime) + window.G_startTime;
            startTime = window.G_startTime;
            window.G_isPause = 0;
        }
        if (pauseOn === 1) {
            startTime = (nowTime - pauseTime) + startTime;
        }

        window.GA_CountAllKey = countAllKey;
        $("#getcountAllKey").html(countAllKey);
        if (nowTime > startTime) {
            var averageKeyType = parseInt(countAllKey / (nowTime - startTime) * 60000);
            if (averageKeyType < 1 && averageKeyType > 0) {
                averageKeyType = 1;
            }
            window.GA_averageKeyType = averageKeyType;
            $("#getAverageKeyType").html(averageKeyType);
        } else {
            window.GA_averageKeyType = 0;
            $("#getAverageKeyType").html(0);
        }

        if (countMomentKey > 0) {
            $("#getMomentKeyType").html(countMomentKey / 2);
            if ((countMomentKey / 2) > highstCountKey) {
                highstCountKey = countMomentKey / 2;
                window.GA_highstCountKey = highstCountKey;
                $("#getHighstCountKey").html(highstCountKey);
            }
            window.G_countMomentKey = 0;
        } else {
            $("#getMomentKeyType").html(0);
        }
        countMomentKey = 0;

        if (typeof (content) !== "undefined") {
            //瞬时速度 字/分钟
            if (content.length > 0) {
                var IntervalContentLength = (content.length - window.G_oldContentLength);
                if (IntervalContentLength < 0) {
                    IntervalContentLength = 0;
                }
                window.G_oldContentLength = content.length;
                var momentSpeed = (IntervalContentLength / 2) * 60
                if (momentSpeed > 999) {
                    momentSpeed = 999;
                }
                $("#getMomentSpeed").html(momentSpeed);
                //最高瞬时速度 字/分钟
                if (momentSpeed > highstSpeed) {
                    highstSpeed = momentSpeed;
                    window.GA_highstSpeed = highstSpeed;
                    $("#getHighstSpeed").html(highstSpeed);
                }
            }

            //平均速度 字/分钟
            if (content.length > 0) {
                var averageSpeed = parseInt(content.length / (nowTime - startTime) * 60000);
                if (averageSpeed < 1 && averageSpeed >= 0) {
                    averageSpeed = 1;
                }
                window.GA_averageSpeed = averageSpeed;
                $("#getAverageSpeed").html(averageSpeed);
            }
        }
        //统计回改字数
        var CountBackDelete = 0;
        var array_keyContent = keyContent.split("&");
        if (array_keyContent.length > 3) {
            for (var i = 3; i < array_keyContent.length; i++) {
                var lastHaveLeft = true;
                var lastNo_W = true;
                var array_singleKeyContentLast = array_keyContent[i - 1].split("");

                for (var k = 0; k < array_singleKeyContentLast.length; k++) {
                    if (array_singleKeyContentLast[k] === ":") {
                        if (k === 0) {
                            lastHaveLeft = false;
                        }
                    }
                    if (array_singleKeyContentLast[k] === ":") {
                        if (k > 0) {
                            if (array_singleKeyContentLast[k - 1] === "W") {
                                lastNo_W = false;
                            }
                        }
                    }
                }
                var array_singleKeyContent = array_keyContent[i].split("");
                for (var j = 0; j < array_singleKeyContent.length; j++) {
                    var left;
                    var right;
                    if (array_singleKeyContent[j] !== "W" && array_singleKeyContent[j] !== ":") {
                        left = 0;
                        right = 0;
                        break;
                    }
                    if (array_singleKeyContent[j] === ":") {
                        if (array_singleKeyContent[j - 1] === "W" && lastHaveLeft && lastNo_W) {
                            left = 1;
                        }
                        if (array_singleKeyContent[j + 1] === "W") {
                            right = 1;
                        }
                    }
                }
                if (left === 1) {
                    CountBackDelete++;
                    left = 0;
                }
                if (right === 1) {
                    CountBackDelete++;
                    right = 0;
                }
            }
            window.GA_CountBackDelete = CountBackDelete;
            $("#getBackDelete").html(CountBackDelete);
        }
        if (pauseOn === 0) {
            if (window.G_saveToDatabase === 1 && (window.G_startTime !== 0)) {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "index.php?r=api/analysisSaveToDatabase",
                    data: {exerciseType: window.G_exerciseType, exerciseData: window.G_exerciseData, squence: window.G_squence, answer: window.GA_answer,
                        averageKeyType: window.GA_averageKeyType, highstCountKey: window.GA_highstCountKey, highstSpeed: window.GA_highstSpeed,
                        averageSpeed: window.GA_averageSpeed, CountBackDelete: window.GA_CountBackDelete, CountAllKey: window.GA_CountAllKey,
                        IntervalTime: window.GA_IntervalTime, highIntervarlTime: window.GA_highIntervarlTime, RightRadio: window.GA_RightRadio},
                    success: function (data) {
                    },
                    error: function (xhr, type, exception) {
                        console.log('GetAverageSpeed error', type);
                        console.log(xhr, "Failed");
                        console.log(exception, "exception");
                    }
                });
            }
        }
        if (window.G_isLook === 1) {
            if (typeof (worker) == "undefined")
            {
                worker = new Worker('js/exerJS/GetAccuracyRate.js');
            }
            worker.onmessage = function (event) {
                if (!isNaN(event.data.accuracyRate)) {
                    window.GA_RightRadio = event.data.accuracyRate;
                    $("#wordisRightRadio").html(window.GA_RightRadio);
                }
                worker.terminate();
            };
            worker.postMessage({
                currentContent: window.G_content,
                originalContent: window.GA_originalContent
            });

        }
        //判断统计结束
        if ((nowTime - startTime) > (setEndTime * 1000) || window.G_isOverFlag === 1) {
            window.G_endAnalysis = 1;
            $("#getMomentKeyType").html(0);
            $("#getIntervalTime").html(0);
            clearInterval(interval);
        }

    }, 5000);

});

function saveToDateBaseNow() {
    var worker;
    var content = window.G_content;
    var keyContent = window.G_keyContent;
    var setEndTime = window.G_setEndTime;
    var startTime = window.G_startTime;
    var countAllKey = window.G_countAllKey;
    var countMomentKey = window.G_countMomentKey;
    var myDate = new Date();
    var nowTime = myDate.getTime();
    if (G_isKeyType === 1) {
        yaweiOCX.PutBufferToContent();
        window.GA_answer = yaweiOCX.GetContentWithSteno();
    }
    window.GA_CountAllKey = countAllKey;

    if (countMomentKey > 0) {
        if ((countMomentKey / 2) > highstCountKey) {
            highstCountKey = countMomentKey / 2;
            window.GA_highstCountKey = highstCountKey;
        }
        window.G_countMomentKey = 0;
    } else {
    }
    countMomentKey = 0;

    if (typeof (content) !== "undefined") {
        //瞬时速度 字/分钟
        if (content.length > 0) {
            var IntervalContentLength = (content.length - window.G_oldContentLength);
            if (IntervalContentLength < 0) {
                IntervalContentLength = 0;
            }
            window.G_oldContentLength = content.length;
            var momentSpeed = (IntervalContentLength / 2) * 60
            if (momentSpeed > 999) {
                momentSpeed = 999;
            }
            //最高瞬时速度 字/分钟
            if (momentSpeed > highstSpeed) {
                highstSpeed = momentSpeed;
                window.GA_highstSpeed = highstSpeed;
            }
        }

        //平均速度 字/分钟
        if (content.length > 0) {
            var averageSpeed = parseInt(content.length / (nowTime - startTime) * 60000);
            if (averageSpeed < 1 && averageSpeed >= 0) {
                averageSpeed = 1;
            }
            window.GA_averageSpeed = averageSpeed;
        }
    }
    //统计回改字数
    var CountBackDelete = 0;
    var array_keyContent = keyContent.split("&");
    if (array_keyContent.length > 3) {
        for (var i = 3; i < array_keyContent.length; i++) {
            var lastHaveLeft = true;
            var lastNo_W = true;
            var array_singleKeyContentLast = array_keyContent[i - 1].split("");

            for (var k = 0; k < array_singleKeyContentLast.length; k++) {
                if (array_singleKeyContentLast[k] === ":") {
                    if (k === 0) {
                        lastHaveLeft = false;
                    }
                }
                if (array_singleKeyContentLast[k] === ":") {
                    if (k > 0) {
                        if (array_singleKeyContentLast[k - 1] === "W") {
                            lastNo_W = false;
                        }
                    }
                }
            }
            var array_singleKeyContent = array_keyContent[i].split("");
            for (var j = 0; j < array_singleKeyContent.length; j++) {
                var left;
                var right;
                if (array_singleKeyContent[j] !== "W" && array_singleKeyContent[j] !== ":") {
                    left = 0;
                    right = 0;
                    break;
                }
                if (array_singleKeyContent[j] === ":") {
                    if (array_singleKeyContent[j - 1] === "W" && lastHaveLeft && lastNo_W) {
                        left = 1;
                    }
                    if (array_singleKeyContent[j + 1] === "W") {
                        right = 1;
                    }
                }
            }
            if (left === 1) {
                CountBackDelete++;
                left = 0;
            }
            if (right === 1) {
                CountBackDelete++;
                right = 0;
            }
        }
        window.GA_CountBackDelete = CountBackDelete;
    }
    
    if (window.G_isLook === 1) {
        if (typeof (worker) === "undefined")
        {
            worker = new Worker('js/exerJS/GetAccuracyRate.js');
            ;
        }
        worker.onmessage = function (event) {
            if (!isNaN(event.data.accuracyRate)) {
                window.GA_RightRadio = event.data.accuracyRate;
            }
            worker.terminate();
        };
        worker.postMessage({
            currentContent: window.G_content,
            originalContent: window.GA_originalContent
        });
    }
    
    if (window.G_saveToDatabase === 1 && (window.G_startTime !== 0)) {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "index.php?r=api/analysisSaveToDatabase",
            data: {exerciseType: window.G_exerciseType, exerciseData: window.G_exerciseData, squence: window.G_squence, answer: window.GA_answer,
                averageKeyType: window.GA_averageKeyType, highstCountKey: window.GA_highstCountKey, highstSpeed: window.GA_highstSpeed,
                averageSpeed: window.GA_averageSpeed, CountBackDelete: window.GA_CountBackDelete, CountAllKey: window.GA_CountAllKey,
                IntervalTime: window.GA_IntervalTime, highIntervarlTime: window.GA_highIntervarlTime, RightRadio: window.GA_RightRadio},
            success: function (data) {
            },
            error: function (xhr, type, exception) {
                console.log('GetAverageSpeed error', type);
                console.log(xhr, "Failed");
                console.log(exception, "exception");
            }
        });
    }
    

}

//拿取键码值

//统计平均速度 
//@param $id：控件id
//@param $startTime:设置平均速度统计的开始时间
//@param $content：内容
//@return $data: 获取平均速度 字/分钟
function AjaxGetAverageSpeed(id, startTime, content) {
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "index.php?r=api/getAverageSpeed",
        data: {startTime: startTime, content: content},
        success: function (data) {
            $("#" + id).html(data);
        },
        error: function (xhr, type, exception) {
            console.log('GetAverageSpeed error', type);
            console.log(xhr, "Failed");
            console.log(exception, "exception");

        }
    });
}

//统计瞬时速度 
//@param $id：控件id
//@param $setTime:设置瞬时速度统计的时间区间
//@param $contentlength：区间内输入的字符长度，需要前端js计算，
//@return $data: 获取瞬时速度  字/分钟
function AjaxGetMomentSpeed(id, setTime, contentlength) {
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "index.php?r=api/getMomentSpeed",
        data: {setTime: setTime, contentlength: contentlength},
        success: function (data) {
            $("#" + id).html(data);
        },
        error: function (xhr, type, exception) {
            console.log('GetAverageSpeed error', type);
            console.log(xhr, "Failed");
            console.log(exception, "exception");
        }
    });
}

//统计回改字数
//@param $id：控件id
//@param $doneCount:已统计的回改字数
//@param $keyType：键位码
//@return $donecount: 新的总回改字数
function AjaxGetBackDelete(id, doneCount, keyType) {
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "index.php?r=api/getBackDelete",
        data: {doneCount: doneCount, keyType: keyType},
        success: function (data) {
            $("#" + id).html(data);
        },
        error: function (xhr, type, exception) {
            console.log('GetAverageSpeed error', type);
            console.log(xhr, "Failed");
            console.log(exception, "exception");
        }
    });
}

//统计错误字数  已放入多线程js
//@param $id1：正确字数控件id
//@param $id2：错误字数控件id
//@param $id3：正确率控件id
//@param $originalContent:答案内容
//@param $currentContent：用户输入内容 
//function GetRight_Wrong_AccuracyRate(id1, originalContent, currentContent) {
//    var allCount = 0;
//    var rightCount = 0;
//    var lcs = new LCS(currentContent,originalContent);
//    if (lcs === null)
//        return;
//    lcs.doLCS();
//    allCount = lcs.getStrOrg(1).length;
//    rightCount = lcs.getSubString(3).length;
//    var correct = rightCount / allCount;
//    var accuracyRate = Math.round(correct * 100);
//    window.GA_RightRadio = accuracyRate;
//    if (id1 !== "") {
//        $("#" + id1).html(accuracyRate);
//    }
//}













