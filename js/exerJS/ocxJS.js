/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function getContent(yaweiOCX) {
    var str;
    try {
        str = yaweiOCX.GetContent();
        //console.log("getContent:"+'debug...');
    } catch(e) {
        console.log("getContent:"+e);
    }
    return str;
}

function clearContent(yaweiOCX) {
    try {
        yaweiOCX.ClearContent();
    } catch(e) {
        console.log("clearContent:"+e);
    }
}
function hideToolBar( yaweiOCX) {
    try {
        yaweiOCX.HideToolBar();
    } catch(e) {
        console.log("hideToolBar:"+e);
    }
}

function hideSecondToolBar( yaweiOCX) {
    try {
        yaweiOCX.HideSecondToolBar();
    } catch(e) {
        console.log("hideSecondToolBar:"+e);
    }
}
/*
//光标定位函数。
function locate( yaweiOCX, index) {
    try {
        yaweiOCX.Locate(index);
    } catch(e) {
        console.log("locate("+yaweiOCX+","+index+"):"+e);
    }
}

function setLibPath( yaweiOCX, spath ) {
    var res;
    try{
        res = yaweiOCX.SetLibPath(spath);
    }catch(e){
        console.log("setLibPath:"+e);
    }
    return res;
}

function addEvent(obj, event, handler) {
    if (obj.attachEvent) {
        try {
            obj.setAttribute("event_"+event, "\""+event+"\"");
            obj.attachEvent(event, handler);
        } catch (e) {
            console.log('attachEvent ' + event + ' except！');
        }
    }
    else if (obj.addEventListener) {
        try {
            obj.setAttribute("event_"+event, "\""+event+"\"");
            obj.addEventListener(event, handler);
        } catch (e) {
            console.log('addEventListener ' + event + ' except！');
        }
    }
}



function iePrintOCX(){
    var str;
    str = "<div id = \"ocxDIV\">";
    str += "<object id=\"typeOCX\" classid=\"CLSID:ED848B16-B8D3-46c3-8516-E22371CCBC4B\"";
    str +="></object>"
    document.write(str);
}

function ffPrintOCX(objID) {
    var str;
    str = "<object id=\""+objID+"\" type=\"application/x-itst-activex\" ";
    str += "clsid=\"{ED848B16-B8D3-46c3-8516-E22371CCBC4B}\" ";
    str += "width ='600' height='350' ";
    //暂时去掉，。。。这个方法可能不对。
    //str += "param_src=\"http://192.168.101.235/ocxTest/cab/YaWei6.CAB\"";
    str += "event_OnStenoPress = \"OnStenoPress\"";
    str += "></object>";
    document.write(str);
}

*/
/***********************************************************
 * 开始消息响应函数
 * @param {type} ppszLibPath
 * @returns {undefined}
 */
/*
function onSetLibPath(ppszLibPath) {
    console.log("Path:"+ppszLibPath);
}

function onClick(button) {
    if (button == 0)
        alert("左击");
    else if (button == 1)
        alert("右击");
    else 
        alert("错误的参数！");
}

function onStenoPress(pszStenoString ,device) {
    console.log(pszStenoString);
}

function onKeyPress(nChar, nRepCnt, nFlags) {
    alert(nChar+"");
}


*/