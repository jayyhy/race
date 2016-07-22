<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AnalysisTool {

    //--------------------------------词语练习------------------------------------------
    //统计瞬时速度 
    //@param $setTime:设置瞬时速度统计的时间区间
    //@param $contentlength：区间内输入的字符长度，需要前端js计算
    //@return $momentSpeed: 获取瞬时速度  字/分钟
    public static function getMomentSpeed($setTime, $contentlength) {
        $momentSpeed = ($contentlength / $setTime) * 60;
        return number_format($momentSpeed, 1);
    }

    //统计平均速度 
    //@param $startTime:设置平均速度统计的开始时间
    //@param $content： 内容
    //@return $momentSpeed: 获取平均速度 字/分钟
    public static function getAverageSpeed($startTime, $content) {
        $nowTime = time();
        $goneTime = $nowTime - $startTime;
        if ($goneTime > 0) {
            $contentLength = strlen($content);
            $averageSpead = ($contentLength / $goneTime) * 60;
            return number_format($averageSpead, 1);
        } else {
            $averageSpead = 0;
            return $averageSpead;
        }
    }

    //统计回改字数
    //@param $doneCount:已统计的回改字数
    //@param $keyType：每击键位码
    //@return $donecount: 新的总回改字数
    public static function getBackDelete($doneCount, $keyType) {
        $array_keyType = explode(":", $keyType);
        $flag = 0;
        foreach ($array_keyType as $k) {
            if ($k == 'w') {
                $flag = 1;
            }
        }
        if ($flag == 1) {
            $doneCount++;
        }
        return $doneCount;
    }

    //统计正确，错误字数以及正确率
    //@param $originalContent:答案内容
    //@param $currentContent：输入内容 
    //@return array $data: [0]:正确字数 [1]:错误字数 [2]:正确率
    public static function getRight_Wrong_AccuracyRate($originalContent, $currentContent) {
        $allCount = 0;
        $wrongCount = 0;
        $rightCount = 0;
        $array_original = str_split($originalContent);
        $array_current = str_split($currentContent);
        unset($originalContent);
        unset($currentContent);
        foreach ($array_original as $k => $v) {
            if (isset($array_current[$k])) {
                if ($v != $array_current[$k]) {
                    $wrongCount++;
                } else {
                    $rightCount++;
                }
            }
            $allCount++;
        }

        if (count($array_current) > count($array_original)) {
            $rightCount -= (count($array_current) - count($array_original));
            if ($rightCount < 0) {
                $rightCount = 0;
            }
        }
        $accuracyRate = round(($rightCount / $allCount) * 100);
        unset($array_original);
        unset($array_current);
        $data = array($rightCount, $wrongCount, $accuracyRate);
        return $data;
    }

    //--------------------------------词语练习------------------------------------------
}
