<div class="span3">
    <div class="well" style="padding: 8px 0;">
        <ul class="nav nav-list">
            <li <?php
            if ($step == 1) {
                echo 'class="active"';
            }
            ?>  ><a href="./index.php?r=admin/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=1"><i class="icon-align-left"></i> 1</a></li>
            <li <?php
            if ($step == 2) {
                echo 'class="active"';
            }
            ?> ><a href="./index.php?r=admin/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=2"><i class="icon-align-left"></i> 2</a></li>
            <li <?php
            if ($step == 3) {
                echo 'class="active"';
            }
            ?> ><a href="./index.php?r=admin/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=3"><i class="icon-align-left"></i> 3</a></li>
            <li <?php
            if ($step == 4) {
                echo 'class="active"';
            }
            ?> ><a href="./index.php?r=admin/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=4"><i class="icon-align-left"></i> 4</a></li>
            <li <?php
            if ($step == 5) {
                echo 'class="active"';
            }
            ?> ><a href="./index.php?r=admin/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=5"><i class="icon-align-left"></i> 5</a></li>
            <li <?php
            if ($step == 6) {
                echo 'class="active"';
            }
            ?> ><a href="./index.php?r=admin/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=6"><i class="icon-align-left"></i> 6</a></li>
        </ul>
    </div>
</div>
<div class="span9">
    <h2>1</h2>
    <div align="center">
        <h3>持续时间以及配分</h3><br/>
        <form method="POST" action="./index.php?r=admin/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=1">
            时间：
            <textarea name="time" style="width:50px; height:20px;" id="time" ><?php echo $race['time']/60; ?></textarea> 分钟
            <br/><br>
            分数：
            <textarea name="score" style="width:50px; height:20px;" id="score" ><?php echo $race['score']; ?></textarea> &nbsp;&nbsp;&nbsp;分
            <br/><br/>
            <button type="submit" class="btn_4big">确定</button>
        </form>
    </div>
</div>


<script>
    window.addEventListener("submit", function (event) {
        var time = document.querySelector("#time").value;
        var score = document.querySelector("#score").value;
        var reg = new RegExp("^[0-9]*$");
        if (!(reg.test(time) && reg.test(score))) {
            event.preventDefault();
            window.wxc.xcConfirm('请输入正确的数字', window.wxc.xcConfirm.typeEnum.info);
        }
    }, true);
    $(document).ready(function () {
        var result = <?php echo "'$result'"; ?>;
        if (result === '1') {
            window.wxc.xcConfirm("评分成功！", window.wxc.xcConfirm.typeEnum.success, {
                onOk: function () {
                    window.location.href = "./index.php?r=admin/editRace&indexID=<?php echo $_GET['indexID']; ?>&step=2";
                }
            });
        }
    });
</script>
