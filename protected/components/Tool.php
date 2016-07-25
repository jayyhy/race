<?php

class Tool {

    public static $studentNumber = 50;
    public static $EXER_TYPE = [
        'choice',
        'filling',
        'question',
        'key',
        'look',
        'listen',
    ];

    public static function getLastExer($exercise) {
        $result = Array();
        $result['type'] = '';
        $result['exerciseID'] = 0;
        foreach (Tool::$EXER_TYPE as $type) {
            foreach ($exercise[$type] as $oneexer) {
                $result['type'] = $type;
                $result['exerciseID'] = $oneexer['exerciseID'];
            }
        }
        return $result;
    }

    public function alertInfo($info, $url) {
        return "<script type='text/javascript'>alert('$info');location.href='$url';</script>";
    }

    public static function beCount($num) {
        $result = ($num + 12) * 1011;
        return $result;
    }

    public static function reCount($num) {
        $result = ($num / 1011) - 12;
        return $result;
    }

    public static function printprobar($value) {
        $sv = sprintf('%2.1f', $value * 100);
        $pro = '<div class="progress">';
        $bar = '<div class="bar" style="width:' . $sv . '%;">';
        $barend = '</div>';
        $proend = '</div>';
        $bw = "<font size=\"2\" color=\"#0d8fd1\">$sv%</font>";
        if ($sv > 10)
            echo $pro . $bar . $sv . '%' . $barend . $proend;
        else
            echo $pro . $bar . $barend . $bw . $proend;
    }

    public static function jsLog($info) {
        return "<script>console.log('" + $info + "');</script>";
    }

    public static function arrayMerge($a1, $a2) {
        foreach ($a2 as $key => $value) {
            $a1 [$key] = $value;
        }
        return $a1;
    }

    public static function clength($str, $charset = "utf-8") {
        /**
         * 可以统计中文字符串长度的函数
         *
         * @param $str 要计算长度的字符串,一个中文算一个字符        	
         */
        $re ['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re ['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re ['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re ['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re [$charset], $str, $match);
        return count($match [0]);
    }

    public static function csubstr($str, $start = 0, $length, $charset = "utf-8") {
        /*
         * 中文截取，支持gb2312,gbk,utf-8,big5
         * @param string $str 要截取的字串
         * @param int $start 截取起始位置
         * @param int $length 截取长度
         * @param string $charset utf-8|gb2312|gbk|big5 编码
         * @param $suffix 是否加尾缀
         */
        if (function_exists("mb_substr")) {
            if (mb_strlen($str, $charset) <= $length)
                return $str;
            $slice = mb_substr($str, $start, $length, $charset);
        } else {
            $re ['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
            $re ['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
            $re ['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
            $re ['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
            preg_match_all($re [$charset], $str, $match);
            if (count($match [0]) <= $length)
                return $str;
            $slice = join("", array_slice($match [0], $start, $length));
        }
        return $slice;
    }

    public static function deldir($dir) {
//删除目录下的文件：
        $dh = opendir($dir);
        while ($file = readdir($dh)) {
            if ($file != "." && $file != "..") {
                $fullpath = $dir . "/" . $file;
                if (!is_dir($fullpath)) {
                    unlink($fullpath);
                } else {
                    deldir($fullpath);
                }
            }
        }
        closedir($dh);
    }

    public static function createID() {
        // 7位系统时间，2位随机数，1位校验和
        $tm = time();
        $cs = 0;
        $i = 0;
        $tmp = $tm;
        for ($i = 0; $i < 7; $i ++) {
            $cs += $tmp % 10;
            $tmp = (int) $tmp / 10;
        }
        // echo("tm"."$tm\n");
        // echo("cs:$cs\n");
        srand((double) microtime() * 1000000);
        $rand_number = rand(0, 99);
        $cs = $cs + $rand_number % 10 + (int) $rand_number / 10;
        // echo("rand:$rand_number\n");
        // echo("cs:$cs\n");
        $tm = $tm + "";
        $id = "1" . substr($tm, - 7);
        // echo("id:$id\n");
        $str_rand = sprintf("%02d", $rand_number);
        $id = $id . $str_rand;
        // echo("id:$id\n");
        $cs = $cs % 10;
        $id = $id . ($cs + "");
        // echo("id:$id\n");
        return $id;
    }

    public static function mainLoginIn() {
        $result = 0;
        $McIo = new McIo('');
        $dateNow = date('Ymd');
        $datas = json_decode(file_get_contents(__DIR__ . "/../config/test2.php"));
        if (count($datas) === 0) {
            return $result;
        } else if (sha1($McIo->McIo('')) !== $datas[0]) {
            return $result;
        } else if ($dateNow > Tool::reCount(base64_decode($datas[1]))) {
            return $result;
        } else if ($dateNow < Tool::reCount(base64_decode($datas[2]))) {
            return $result;
        } else {
            $datas[2] = base64_encode(Tool::beCount($dateNow));
            Yii::app()->session['cfmLogin'] = 1;
            file_put_contents(__DIR__ . "/../config/test2.php", json_encode($datas));
            return 1;
        }
    }

    public static function mainLoginRe($flag) {
        $flag = str_replace(" ", "", $flag);
        $flagArray = explode("$", base64_decode($flag));
        $dateNow = date('Ymd');
        $m = "";
        $LimitDate = "";
        if (isset($flagArray[1])) {
            $m = $flagArray[0];
            $LimitDate = $flagArray[1];
        }
        $data[0] = $m;
        $data[1] = $LimitDate;
        $data[2] = base64_encode(Tool::beCount($dateNow));
        file_put_contents(__DIR__ . "/../config/test2.php", json_encode($data));
    }

    //检查学生公告状态
    public static function stuNotice() {
        $userId = Yii::app()->session['userid_now'];
        $noticeState = Student::model()->findByPK($userId)->noticestate;
        return $noticeState;
    }

    //检查老师公告状态
    public static function teacherNotice() {
        $userId = Yii::app()->session['userid_now'];
        $noticeState = Teacher::model()->findByPK($userId)->noticestate;
        return $noticeState;
    }

    /**
     * 验证邮箱格式是否正确
     * return true 正确; false 不正确
     */
    public static function checkMailAddress($email) {
        $regex = '/^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[-_a-z0-9][-_a-z0-9]*\.)*(?:[a-z0-9][-a-z0-9]{0,62})\.(?:(?:[a-z]{2}\.)?[a-z]{2,})$/i';
        if (preg_match($regex, $email)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * 验证ID格式是否正确
     * return true 正确; false 不正确
     */
    public static function checkID($ID) {
        $regex = '/^[A-Za-z]+[A-Za-z0-9]+$/';
        if (preg_match($regex, $ID)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //分页工具，$sql为SQL  返回值list为查询内容，$pages为分页结果

    public static function pager($sql, $pagesize) {
        $criteria = new CDbCriteria();
        $result = Yii::app()->db->createCommand($sql)->query();
        $pages = new CPagination($result->rowCount);
        $pages->pageSize = $pagesize;
        $pages->applyLimit($criteria);
        $result = Yii::app()->db->createCommand($sql . " LIMIT :offset,:limit");
        $result->bindValue(':offset', $pages->currentPage * $pages->pageSize);
        $result->bindValue(':limit', $pages->pageSize);
        $list = $result->query();
        return ['list' => $list, 'pages' => $pages,];
    }

    public static function quickSort($arr, $type) {
        if (count($arr) > 1) {
            $k = $arr[0][$type];
            $x = array();
            $y = array();
            $_size = count($arr);
            for ($i = 1; $i < $_size; $i++) {
                if ($arr[$i][$type] <= $k) {
                    array_push($y, $arr[$i]);
                } else if ($arr[$i][$type] > $k) {
                    array_push($x, $arr[$i]);
                }
            }
            $x = Tool::quickSort($x, $type);
            $y = Tool::quickSort($y, $type);
            return array_merge($x, array($arr[0]), $y);
        } else {
            return $arr;
        }
    }

    // 第一个参数：传入要转换的字符串
    // 第二个参数：取0，英文转简体；取1，简体到英文
    public static function SBC_DBC($str, $args2) {
        $DBC = Array(
            '：', '—',
            '。', '，', '/', '%', '#',
            '！', '＠', '＆', '（', '）',
            '《', '＞', '＂', '＇', '？',
            '【', '】', '{', '}', '\'',
            '｜', '+', '=', '_', '＾',
        );

        $SBC = Array(// 半角
            ':', '-',
            '.', ',', '/', '%', '#',
            '!', '@', '&', '(', ')',
            '<', '>', '"', '\'', '?',
            '[', ']', '{', '}', '\\',
            '|', '+', '=', '_', '^',
        );

        if ($args2 == 0) {
            return str_replace($SBC, $DBC, $str);  // 半角到全角
        } else if ($args2 == 1) {
            return str_replace($DBC, $SBC, $str);  // 全角到半角
        } else {
            return false;
        }
    }

    public static function filterKeyContent($content) {
        if (strstr($content, "$$")) {
            $string = "";
            $content = str_replace("$$", " ", $content);
            $array = explode(" ", $content);
            foreach ($array as $arr) {
                $pos = strpos($arr, "0");
                $arr = substr($arr, $pos + 1);
                $string = $string . " " . $arr;
            }
            return $string;
        } else {
            return $content;
        }
    }

    public static function filterKeyOfInputWithYaweiCode($content) {
        if (strstr($content, ">,<")) {
            $string = "";
            $content = substr($content, 1);
            $content = str_replace(">,<", " ", $content);
            $array = explode(" ", $content);
            foreach ($array as $arr) {
                $pos = strpos($arr, "><");
                $arr = substr($arr, 0, $pos);
                $string = $string . " " . $arr;
            }
            return $string;
        } else {
            return $content;
        }
    }

    public static function filterContentOfInputWithYaweiCode($content) {
        if (strstr($content, ">,<")) {
            $string = "";
            $content = substr($content, 1);
            $content = str_replace(">,<", " ", $content);
            $array = explode(" ", $content);
            foreach ($array as $arr) {
                $pos = strpos($arr, "><");
                $arr = substr($arr, 0, $pos);
                $string = $string . $arr;
            }
            return $string;
        } else {
            return $content;
        }
    }

    public static function spliceLookContent($content) {
        $result = '';
        $length = mb_strlen($content);
        if ($length > 4000) {
            $result = Tool::utf8_substr($content, 0, 4000);
        } else {
            $result = $content;
        }
        return $result;
    }

    public static function filterAllSpaceAndTab($content) {
        $new = str_replace("\n", "", $content);
        $newcontent = str_replace("\r", "", $new);
        $newcontent = str_replace(" ", "", $newcontent);
        $newcontent = str_replace("　", "", $newcontent);
        return $newcontent;
    }

    public static function utf8_substr($str, $start = 0) {
        if (empty($str)) {
            return false;
        }
        if (function_exists('mb_substr')) {
            if (func_num_args() >= 3) {
                $end = func_get_arg(2);
                return mb_substr($str, $start, $end, 'utf-8');
            } else {
                mb_internal_encoding("UTF-8");
                return mb_substr($str, $start);
            }
        } else {
            $null = "";
            preg_match_all("/./u", $str, $ar);
            if (func_num_args() >= 3) {
                $end = func_get_arg(2);
                return join($null, array_slice($ar[0], $start, $end));
            } else {
                return join($null, array_slice($ar[0], $start));
            }
        }
    }

}

class McIo {

    var $return_array = array(); // 返回带有物理地址的字串数组   
    var $mc_dr;

    public function McIo($os_type) {
        switch (strtolower($os_type)) {
            case "linux" :
                $this->forLinux();
                break;
            case "solaris" :
                break;
            case "unix" :
                break;
            case "aix" :
                break;
            default :
                $this->forwi();
                break;
        }
        $temp_array = array();
        foreach ($this->return_array as $value) {

            if (preg_match("/[0-9a-f][0-9a-f][:-]" . "[0-9a-f][0-9a-f][:-]" . "[0-9a-f][0-9a-f][:-]" . "[0-9a-f][0-9a-f][:-]" . "[0-9a-f][0-9a-f][:-]" . "[0-9a-f][0-9a-f]/i", $value, $temp_array)) {
                $this->mc_dr = $temp_array [0];
                break;
            }
        }
        unset($temp_array);
        return $this->mc_dr."GS";
    }

    function forwi() {
        @exec("ipconfig /all", $this->return_array);
        if ($this->return_array)
            return $this->return_array;
        else {
            $ipconfig = $_SERVER ["WINDIR"] . "/system32/ipconfig.exe";
            if (is_file($ipconfig))
                @exec($ipconfig . " /all", $this->return_array);
            else
                @exec($_SERVER ["WINDIR"] . "/system/ipconfig.exe /all", $this->return_array);
            return $this->return_array;
        }
    }

    function forLinux() {
        @exec("ifconfig -a", $this->return_array);
        return $this->return_array;
    }

}
