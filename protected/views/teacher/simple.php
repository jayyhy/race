<?php
    $title=array('学号','阶段一','阶段二','阶段三','阶段四','阶段五','阶段六');
    $filename='report';
    header("Content-type:application/octet-stream");
    header("Accept-Ranges:bytes");
    header("Content-type:application/vnd.ms-excel;charset=gbk");  
    header("Content-Disposition:attachment;filename=".$filename.".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    //导出xls 开始
    
    if (!empty($title)){
        foreach ($title as $k => $v) {
            //$title[$k]=iconv("UTF-8", "GB2312",$v);
            $title[$k]=$v;
        }
        $title= implode("\t", $title);
        echo "$title\n";
    }
    if (!empty($data)){
                   foreach ($data as $k => $model):
                echo $model['studentID']."\t";
                if($model['resultstep1']['rate']==null){echo"未作答"."\t";}else{echo $model['resultstep1']['rate']."\t";}
                if($model['resultstep2']['rate']==null){echo"未作答"."\t";}else{echo $model['resultstep2']['rate']."\t";}
                if($model['resultstep3']['rate']==null){echo"未作答"."\t";}else{echo $model['resultstep3']['rate']."\t";}
                if($model['resultstep4']['rate']==null){echo"未作答"."\t";}else{echo $model['resultstep4']['rate']."\t";}
                if($model['resultstep5']['rate']==null){echo"未作答"."\t";}else{echo $model['resultstep5']['rate']."\t";}
                if($model['resultstep6']['rate']==null){echo"未作答"."\n";}else{echo $model['resultstep6']['rate']."\n";}
           endforeach;
    }


?>
