<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <title>亚伟速录</title>
    <META HTTP-EQUIV="Cache-Control" CONTENT="no-cache,no-store, must-revalidate">
    <META HTTP-EQUIV="pragma" CONTENT="no-cache">
    <META HTTP-EQUIV="expires" CONTENT="0"> 
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <script src="<?php echo JS_URL; ?>jquery.min.js"></script>
    <link href="<?php echo CSS_URL; ?>login.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo CSS_URL; ?>bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo CSS_URL; ?>font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo CSS_URL; ?>style.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>reset.css">
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>supersized.css">
    <!--            改变alter样式-- extensions/xcConfirm 工具包下-- --> 
    <link rel="stylesheet" type="text/css" href="<?php echo XC_Confirm; ?>css/xcConfirm.css"/>
    <script src="<?php echo XC_Confirm; ?>js/xcConfirm.js" type="text/javascript" charset="utf-8"></script>
    <!--            -->
</head>

<body oncontextmenu="return false">
    <script src="<?php echo JS_URL; ?>supersized.3.2.7.min.js"></script>
    <script src="<?php echo JS_URL; ?>supersized-init.js"></script>
    <script>
        $(document).ready(function () {
<?php if (isset($ok)) { ?>
        window.location.href = './index.php';
<?php } else { ?>
                window.wxc.xcConfirm("过期或已注销！请输入产品注册码：", window.wxc.xcConfirm.typeEnum.input, {
                    onOk: function (v) {
                        window.location.href = './index.php?r=user/login&flag=' + v;
                    }
                });
<?php } ?>
        });
        window.onload = function ()
        {
            $(".connect p").eq(0).animate({"left": "0%"}, 600);
            $(".connect p").eq(1).animate({"left": "0%"}, 400);
        };
    </script>
</body>

</html>

