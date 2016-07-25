<div class="span3">
    <div class="well" style="padding: 8px 0;">
        <ul class="nav nav-list">
            <li <?php
            if ($step == 1) {
                echo 'class="active"';
            }
            ?>  ><a href="./index.php?r=teacher/detail&indexID=<?php echo $_GET['indexID']; ?>&step=1&stuID=<?php echo $_GET['stuID']; ?>"><i class="icon-align-left"></i> 阶段一</a></li>
            <li <?php
            if ($step == 2) {
                echo 'class="active"';
            }
            ?> ><a href="./index.php?r=teacher/detail&indexID=<?php echo $_GET['indexID']; ?>&step=2&stuID=<?php echo $_GET['stuID']; ?>"><i class="icon-align-left"></i> 阶段二</a></li>
            <li <?php
            if ($step == 3) {
                echo 'class="active"';
            }
            ?> ><a href="./index.php?r=teacher/detail&indexID=<?php echo $_GET['indexID']; ?>&step=3&stuID=<?php echo $_GET['stuID']; ?>"><i class="icon-align-left"></i> 阶段三</a></li>
            <li <?php
            if ($step == 4) {
                echo 'class="active"';
            }
            ?> ><a href="./index.php?r=teacher/detail&indexID=<?php echo $_GET['indexID']; ?>&step=4&stuID=<?php echo $_GET['stuID']; ?>"><i class="icon-align-left"></i> 阶段四</a></li>
            <li <?php
            if ($step == 5) {
                echo 'class="active"';
            }
            ?> ><a href="./index.php?r=teacher/detail&indexID=<?php echo $_GET['indexID']; ?>&step=5&stuID=<?php echo $_GET['stuID']; ?>"><i class="icon-align-left"></i> 阶段五</a></li>
            <li <?php
            if ($step == 6) {
                echo 'class="active"';
            }
            ?> ><a href="./index.php?r=teacher/detail&indexID=<?php echo $_GET['indexID']; ?>&step=6&stuID=<?php echo $_GET['stuID']; ?>"><i class="icon-align-left"></i> 阶段六</a></li>
        </ul>
        <br/>
        <ul class="nav nav-list">
            <li >总分:<?php echo $totalScore;?></li>
        </ul>
    </div>
</div>
<div class="span9">
    <h2>第六阶段</h2>
    <?php if ($answer == "") { ?>
        <h3>未作答</h3>
    <?php } else { ?>
        <h3>考试时间：<?php echo $race['time']; ?></h3>
        <h3>本阶段满分:<?php echo $race['score']; ?></h3>
        <textarea style="width: 600px;height: 140px" disabled="true"><?php echo $race['content']; ?></textarea>
        <textarea style="width: 600px;height: 140px" disabled="true"><?php echo $answer['content']; ?></textarea>
        <form method="POST" action="./index.php?r=teacher/detail&indexID=<?php echo $_GET['indexID']; ?>&step=6&stuID=<?php echo $_GET['stuID']; ?>">
            <h3>打分：<input <?php
                if ($answer['score'] != 0) {
                    echo 'disabled="true"';
                }
                ?>  type="text" name ="mark" id="mark" value="<?php echo $answer['score']; ?>"/></h3>
            <button type="submit" class="btn_4big">确定</button>
        </form>
    <?php } ?>
</div>
<script>
    window.addEventListener("submit", function (event) {
        var mark = document.querySelector("#mark").value;
        var stantScore = <?php echo $race['score']; ?>;
        var reg = new RegExp("^[0-9]*$");
        if (!reg.test(mark)) {
            event.preventDefault();
            window.wxc.xcConfirm('请输入正确的数字！', window.wxc.xcConfirm.typeEnum.error);
        } else {
            if (mark > stantScore) {
                event.preventDefault();
                window.wxc.xcConfirm('评分超出限制！', window.wxc.xcConfirm.typeEnum.error);
            }
        }
    }, true);
    $(document).ready(function () {
<?php if ($answer['score'] == 0) { ?>
            $("#mark").select();
<?php } ?>
        var result = <?php echo "'$result'"; ?>;
        if (result === "1") {
            window.wxc.xcConfirm("评分成功！", window.wxc.xcConfirm.typeEnum.success, {
                onOk: function () {
                    window.location.href = "./index.php?r=teacher/stuLst&indexID=<?php echo $_GET['indexID']; ?>";
                }
            });
        } else if (result === '0') {
            window.wxc.xcConfirm("评分失败！", window.wxc.xcConfirm.typeEnum.error);
        }
    });
</script>


