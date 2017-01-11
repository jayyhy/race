<?php require 'raceLstBar.php';
  if(count($raceLst) == 0) {?>
  <div class="rightbar" style="  background: url(<?php echo IMG_URL_NEW; ?>null_paper.png) no-repeat 50% 50% #F8F4F2 "> 
  </div>
<?php }?>

<script>
    
    $(document).ready(function () {
        window.parent.doClick();
        var result = <?php echo "'$result'"; ?>;
        if (result === '1')
            window.wxc.xcConfirm("操作成功！", window.wxc.xcConfirm.typeEnum.success, {
                onOk: function () {
                    window.location.href = "./index.php?r=teacher/RaceLst";
                }
            });
        else if (result === '0') {
            window.wxc.xcConfirm("已有班级进行需要删除的科目，无法删除！", window.wxc.xcConfirm.typeEnum.error, {
                onOk: function () {
                    window.location.href = "./index.php?r=teacher/RaceLst";
                }
            });
        }
    });
    function check_all(obj, cName)
    {
        var checkboxs = document.getElementsByName(cName);
        for (var i = 0; i < checkboxs.length; i++) {
            checkboxs[i].checked = obj.checked;
        }
    }

    function deleCheck() {
        var checkboxs = document.getElementsByName('checkbox[]');
        var flag = 0;
        for (var i = 0; i < checkboxs.length; i++) {
            if (checkboxs[i].checked) {
                flag = 1;
                break;
            }
        }
        if (flag === 0) {
            window.wxc.xcConfirm('未选中任何试卷', window.wxc.xcConfirm.typeEnum.info);
        } else {
            var option = {
                title: "警告",
                btn: parseInt("0011", 2),
                onOk: function () {
                    $('#deleForm').submit();
                }
            };
            window.wxc.xcConfirm("确定删除选中的试卷吗？", "custom", option);
        }

    }
        function adding(){
        document.getElementById("on_adding").style.display='block';
        document.getElementById("on_add").style.display='none';
    }
    function cancel(){
        document.getElementById("on_adding").style.display='none';
        document.getElementById("on_add").style.display='block';  
    }
    
</script>
