<?php require 'raceLstBar.php';?>
<style>
    .stage{
        float: left;
        margin-left: 40px;
        margin-top: 20px;
        height: 35px
    }
    .word{
        font-size: 18px;
        font-weight: bold;
        color: #29282e;
    }
    .words{
       font-size: 18px;
       color: #c9c9c9;
    }
    .currentTag{
         float: right;
         margin-top: -61px;
         margin-right: 25px;
         background-color: #F8F4EE;
         width: 184px;
         height: 38px;
    }
    .wordTag1{
        font-size: 16px;
        color: #DAD9D6;
        position: relative;
        left: 18px;
        top: 9px;
    }
    .wordTag2{
        font-size: 16px;
        color: #3F3E43;
        position: relative;
        left: 24px;
        top: 9px;
    }
    
</style>
<div class="span9" style="width: 1159px;height: 750px;margin-top: -19px;background-color: #f8f4f2">
    <div style="background-color: #fbf8f7;height: 58px;width: 1159px;">
        <?php 
            $index_id=$_GET['indexID'];
            $stepName1=  Race::model()->find("indexID=? AND step=?",array($index_id,1))['raceName'];
            $stepName2=  Race::model()->find("indexID=? AND step=?",array($index_id,2))['raceName'];
            $stepName3=  Race::model()->find("indexID=? AND step=?",array($index_id,3))['raceName'];
            $stepName4=  Race::model()->find("indexID=? AND step=?",array($index_id,4))['raceName'];
            $stepName5=  Race::model()->find("indexID=? AND step=?",array($index_id,5))['raceName'];
            $stepName6=  Race::model()->find("indexID=? AND step=?",array($index_id,6))['raceName'];
        ?>
        <div class="stage" style=" margin-left: 25px; "><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=1" class="word" ><?php echo $stepName1; ?></a></div>
        <div class="stage" ><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=2" class="word"><?php echo $stepName2; ?></a></div>
        <div class="stage"><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=3" class="word"><?php echo $stepName3; ?></a></div>
        <div class="stage" style="border-bottom:2px solid #ff0000;"><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=4" class="word" style=" color: #ff0000;"><?php echo $stepName4; ?></a></div>
        <div class="stage"><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=5" class="word"><?php echo $stepName5; ?></a></div>
        <div class="stage"><a href="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=6" class="word"><?php echo $stepName6; ?></a></div>
    </div>
    <div style="background-color: #fff;height: 600px;margin-top: 20px;width: 1082px;margin-left: 16px">
        <img src="<?php echo IMG_URL_NEW; ?>icon_proof.png" style="position: relative;left: 25px;top: 25px;"/><h3 style="position: relative;left: 61px;top: -18px;width: 180px">阶段四</h3>
        <form method="POST" action="./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=4" enctype="multipart/form-data">
            <div style="margin-top: -24px;margin-left: 60px" >
                <input id="name" type="text" class="search span2" placeholder="请输入本阶段名称" name="name" style="margin-top: 13px;width: 390px;height: 25px;border-color: #FEE1DA; " value="<?php echo $race['raceName']; ?>"/>&nbsp;&nbsp;
                <span style="font-size: 16px;color: #767679;position: relative;top: 2px">(可重命名)</span>
            </div><br>  
            <div style="margin-top: -24px;margin-left: 60px" >
                <input id="time" type="text" class="search span2" placeholder="请输入考试时间" name="time" style="margin-top: 13px;width: 390px;height: 25px;border-color: #FEE1DA; " value="<?php echo $race['time']/60; ?>"/>&nbsp;&nbsp;
                <span style="font-size: 16px;color: #767679;position: relative;top: 2px">分钟</span>
            
            </div>
            <div style=" margin-left: 38%;margin-top: 25px">
                <button class="btn_5big" style=" width: 96px" type="submit">确 定</button>
            </div>
        </form>
    </div>
</div>


<script>
    window.addEventListener("submit", function (event) {
        var time = document.querySelector("#time").value;
        var reg = new RegExp("^[0-9]*$");
        if (!(reg.test(time))) {
            event.preventDefault();
            window.wxc.xcConfirm('请输入正确的数字', window.wxc.xcConfirm.typeEnum.info);
        }
    }, true);
    $(document).ready(function () {
        var result = <?php echo "'$result'"; ?>;
        if (result === '1'){
            window.wxc.xcConfirm("设定成功！", window.wxc.xcConfirm.typeEnum.success, {
                onOk: function () {
                    window.location.href = "./index.php?r=teacher/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=5";
                }
            });
            }else if (result != ''){
               window.wxc.xcConfirm(result, window.wxc.xcConfirm.typeEnum.info);
        }
    });
</script>
