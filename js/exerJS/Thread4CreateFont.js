/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var briefCode = "";
var briefOriginalYaweiCode = "";
var briefType = "";

function checkYaweiCode(content) {
    for (var i = 0; i < briefCode.length; i++) {
        if (content.content.indexOf(briefCode[i]) >= 0) {
            var re = new RegExp(briefCode[i], "g");
            if (briefCode[i].length === 2) {
                if (briefType[i] == 'X') {
                    content.content = content.content.replace(re, "<span style='border-bottom:1px solid blue'>" + briefCode[i] + "</span>");
                } else if (briefType[i] == 'W') {
                    content.content = content.content.replace(re, "<span style='border-bottom:3px solid blue'>" + briefCode[i] + "</span>");
                } else {
                    content.content = content.content.replace(re, "<span style='border-bottom:2px solid green'>" + briefCode[i] + "</span>");
                }
            } else if (briefCode[i].length === 3) {
                content.content = content.content.replace(re, "<span style='border-bottom:3px solid #0090b0'>" + briefCode[i] + "</span>");
            } else if (briefCode[i].length === 4) {
                content.content = content.content.replace(re, "<span style='border-bottom:5px solid green'>" + briefCode[i] + "</span>");
            } else if (briefCode[i].length > 4) {
                content.content = content.content.replace(re, "<span style='border-bottom:5px solid #FF84BA'>" + briefCode[i] + "</span>");
            }

        }
    }
}


var allContent = {content: ""};
function createFont(color, text, code) {
    var isBrief = 0;
    if (color == "#808080") {
        for (var i = 0; i < text.length; i++) {
            if (text[i].length < 3) {
                for (var j = 0; j < briefOriginalYaweiCode.length; j++) {
                    if (text[i] == briefCode[j]) {
                        isBrief++;
                        if (code[i] == briefOriginalYaweiCode[j].replace(":0", "") || (code[i] == "W:X")) {
                            isBrief--;
                        }
                    }
                }
            } else {
                isBrief++;
            }
            if (isBrief === 0) {
                allContent.content += text[i];
            } else {
                allContent.content += "<span style='color:blue'>" + text[i] + "</span>";
                isBrief--;
            }
        }
        allContent.content = allContent.content.replace(/`/g, "<br/>").replace(/}/g, "&nbsp;");
        checkYaweiCode(allContent);
        allContent.content = "<span style='color:#808080'>" + allContent.content + "</span>";
    } else {
        for (var i = 0; i < text.length; i++) {
            allContent.content += text[i];
        }
        //var t = document.createTextNode(text);
        //f.appendChild(t);
        if (color === "#ff0000") {
            allContent.content = allContent.content.replace(/`/g, "↓<br/>").replace(/}/g, "█");
            checkYaweiCode(allContent);
            allContent.content = "<span style='color:#ff0000'>" + allContent.content + "</span>";
        } else {
            allContent.content = allContent.content.replace(/`/g, "<br/>").replace(/}/g, "&nbsp;");
            checkYaweiCode(allContent);
            allContent.content = "<span style='color:"+color+"'>" + allContent.content + "</span>";
        }
    }
}

this.onmessage = function (event) {
    var text_old = event.data.value.text_old;
    var allInput2 = event.data.value.allInput2;
    briefCode = event.data.value.briefCode;
    briefOriginalYaweiCode = event.data.value.briefOriginalYaweiCode;
    briefType = event.data.value.briefType;
    var inputO = event.data.value.inputO;
    var contentValue = event.data.value.contentValue;
    
    var text = text_old.split("");
    var longIsAgo = 0;
    var old = new Array();
    var oldCode = new Array();
    var isWrong = false;
    var wrong = new Array();
    var length = allInput2.length;
    var countLength = 0;
    for (var i = 0; i < length; i++) {
        if (allInput2[i] !== undefined) {
            var num = allInput2[i].indexOf(">");
            var content = allInput2[i].substring(1, num);
            var yaweiCode = allInput2[i].substring(num + 2, allInput2[i].length).replace(">", "");
            var long = content.length;
            countLength += content.length;
            if (countLength >= text.length) {
                length = i;
            }
            longIsAgo += long;
            if (text[longIsAgo - long] != undefined) {
                var stringText = text[longIsAgo - long];
            }
            for (var j = 1; j < long; j++) {
                if (text[longIsAgo - long + j] != undefined) {
                    stringText += text[longIsAgo - long + j];
                }
            }
            if (content == stringText) {
                if (isWrong == true) {
                    isWrong = false;
                    createFont("#ff0000", wrong, "");
                    wrong = new Array();
                    old = new Array();
                    old.push(stringText);
                    oldCode = new Array();
                    oldCode.push(yaweiCode);
                } else {
                    old.push(stringText);
                    oldCode.push(yaweiCode);
                }
            } else {
                if (isWrong == true)
                    wrong.push(stringText);
                else {
                    isWrong = true;
                    createFont("#808080", old, oldCode);
                    old = new Array();
                    oldCode = new Array();
                    wrong = new Array();
                    wrong.push(stringText);
                }
            }
        }
    }

    if (countLength !== 0) {
        createFont("#808080", old, oldCode);
        createFont("#ff0000", wrong, "");
    }
    if (inputO.length < text.length) {
        var left = contentValue.substr(0 - (text.length - longIsAgo));
        createFont("#000000", left, "");
    }
      postMessage({
            content:allContent
        });
};