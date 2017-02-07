<script type="text/javascript">
function long0(){
    var temp = document.getElementById("input01").value;
    usertipsSpan = document.getElementById("usertips");  
    usertipsSpan.style.color = "red";  
    var reg=/^[A-Za-z0-9]+$/;
    if(!reg.test(temp)||temp.length<3||temp.length>15){
        usertipsSpan.innerHTML='密码必须为3-15位的数字和字母的组合';
        document.getElementById("input01").value="";
    }else {  
        usertipsSpan.innerHTML='';  
    }
}
function long(){
    var temp = document.getElementById("input02").value;
    usertipsSpan = document.getElementById("usertips2");  
    usertipsSpan.style.color = "red";  
    var reg=/^[A-Za-z0-9]+$/;
    if(!reg.test(temp)||temp.length<3||temp.length>15){
        usertipsSpan.innerHTML='密码必须为3-15位的数字和字母的组合';
        document.getElementById("input02").value="";
    }else {  
        usertipsSpan.innerHTML='';  
    }
}
function long2(){
    var temp = document.getElementById("input03").value;
    usertipsSpan = document.getElementById("usertips3");  
    usertipsSpan.style.color = "red";  
    var reg=/^[A-Za-z0-9]+$/;
    if(!reg.test(temp)||temp.length<3||temp.length>15){
        usertipsSpan.innerHTML='密码必须为3-15位的数字和字母的组合';
        document.getElementById("input03").value="";
    }else {  
        usertipsSpan.innerHTML='';  
    }
}
</script>

<div class="span3">
       <div style="padding: 8px 8px;height: 565px;">
           <li ><h3>&nbsp;&nbsp;个人设置</h3></li> 
           <ul class="nav nav-list">
           <li  id="two"><a class="cont2" href="./index.php?r=teacher/teaInformation">个人资料</a></li>   
           <li  id="one"><a class="cont1" href="./index.php?r=teacher/set">修改密码</a></li>   
           </ul>
        </div>
</div>

<div class="span9" style="width: 1159px;height: 750px;margin-top: -19px;background-color: #f8f4f2">
    <div style="margin-left: 30px">
        <h3 >设置密码</h3><br>
    
    <form id="myForm" method="post" action="./index.php?r=teacher/set" enctype="multipart/form-data">
        <fieldset>
        <div class="control-group">
                    <label class="control-label" for="input01">旧密码<h style="color:red;">*</h></label>
                <div class="controls">
                    <input name="old" type="password"  onblur="long0()" class="input-xlarge" id="input01" style="height: 30px;"/>
                    <span id="usertips" style="margin-left: 15px;"></span> 
                </div>
                   <label class="control-label" for="input02">新密码<h style="color:red;">*</h></label> 
                <div class="controls">
                    <input name="new1" type="password"  onblur="long()" class="input-xlarge" id="input02" style="height: 30px;"/>
                    <span id="usertips2" style="margin-left: 15px;"></span> 
                </div>
                   <label class="control-label" for="input03">确认密码<h style="color:red;">*</h> </label>
                <div class="controls">
                    <input name="defnew" type="password" onblur="long2()" class="input-xlarge" id="input03" style="height: 30px;"/>
                    <span id="usertips3" style="margin-left: 15px;"></span> 
                </div>
        </div>
                <div style="margin-top: 30px;">
                    <a class="btn btn-primary" href="./index.php?r=teacher/index">取消</a>
                    <a class="btn btn-primary" href="#" name="submit" onclick="judge()">确定</a> 
                </div>
            </fieldset>
    </form>  
    </div>
</div>

<script>  
$(document).ready(function(){
    var result = '<?php echo $result;?>';
    if(result == '1')
    window.wxc.xcConfirm('密码修改成功！', window.wxc.xcConfirm.typeEnum.success);
    else if(result == '0')
    window.wxc.xcConfirm('密码修改失败！', window.wxc.xcConfirm.typeEnum.error);
    else if(result=='old error')
    window.wxc.xcConfirm('原密码错误！', window.wxc.xcConfirm.typeEnum.error);
}); 
function judge(){
    var old = $("#input01")[0].value;
    var new1 = $("#input02")[0].value;
    var defnew=$("#input03")[0].value;
    if(old!="" &&new1!=""&&old==new1){
        window.wxc.xcConfirm('新旧密码不能一样', window.wxc.xcConfirm.typeEnum.info);
        $("#input02")[0].value="";
    	$("#input03")[0].value="";
        return false;
    }
    if(new1===defnew){
    }else
    {
        window.wxc.xcConfirm('新密码和确认密码不一致', window.wxc.xcConfirm.typeEnum.info);
    	$("#input02")[0].value="";
    	$("#input03")[0].value="";
        return false;
    }
    if(new1 === "" ||old === ""||defnew === "" ){
        window.wxc.xcConfirm('密码不能为空', window.wxc.xcConfirm.typeEnum.info);
        return false;
    }
    $('#myForm').submit();
    return false
}
</script>