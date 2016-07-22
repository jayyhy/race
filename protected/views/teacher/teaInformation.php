
<div class="span3">
       <div class="well" style="padding: 8px 0;height: 565px;">
           <li class="nav-header"><h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;个人设置</h4></li> 
            <ul class="nav nav-list">
           <li class="active" id="two"><a class="cont2" href="./index.php?r=teacher/teaInformation">个人资料</a></li>   
           <li  id="one"><a class="cont1" href="./index.php?r=teacher/set">修改密码</a></li>   
            </ul>
        </div>
</div>
<div class="span9">
    <h3>个人信息</h3>
    <div class="hero-unit">
    <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <td width="30%">工号:</td>
                    <td><?php echo $id;?></td>
                </tr>
                <tr>
                    <td>姓名:</td>
                    <td><?php echo $name;?></td>
                </tr>
            </tbody>
    </table>
    </div>
</div>

