<?php 
if(count($raceIndex)>0){
require 'examSideBar.php';
}  else {?>
<body  style="  background: url(<?php echo IMG_URL_NEW; ?>null_start.png) no-repeat 50% 50% #F8F4F2 "></body>
<?php
}
?>
<script>
    function getExam(indexID){
        <?php   if($isoncourse ==0){ ?>
         window.location.href = "./index.php?r=teacher/control&indexID="+indexID+"&&step=1";
        <?php }else{ 
            $onrace = Race::model()->find("raceID=?", array($isoncourse));
            $onstep = $onrace['step'];
            $onindexID = $onrace['indexID'];
            ?>
            window.location.href = "./index.php?r=teacher/control&indexID=<?php echo $onindexID; ?>&&step=<?php echo $onstep; ?>";
        <?php } ?>     
    }
    $(document).ready(function () {
    window.parent.doClick1();
    });
//    function getExam(indexID){
//         window.location.href = "./index.php?r=teacher/control&indexID="+indexID+"&&step=1";
//    }
</script>

