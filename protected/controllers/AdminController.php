<?php

class AdminController extends CController {

    public $layout = '//layouts/adminBar';

    public function actionIndex() {
        $this->render('index');
    }

    public function actionSet() {       //set
        $result = 'no';
        $mail = '';
        $userid_now = Yii::app()->session['userid_now'];
        $user = Admin::model()->find('userID=?', array($userid_now));
        if (!empty($user->mail_address)) {
            $mail = $user->mail_address;
        }
        if (isset($_POST['old'])) {
            $new1 = $_POST['new1'];
            $defnew = $_POST['defnew'];
            $email = $_POST['email'];
            $usertype = Yii::app()->session['role_now'];
            $user = Admin::model()->find('userID=?', array($userid_now));
            if ($user->password != md5($_POST['old'])) {
                $result = 'old error';
                $this->render('set', ['result' => $result, 'mail' => $mail]);
                return;
            }
            $user->password = md5($new1);
            $user->mail_address = $email;
            $result = $user->update();
            $mail = $email;
        }

        $this->render('set', ['result' => $result, 'mail' => $mail]);
    }

    public function actionConfirmPass() {
        if (isset($_GET ['userID'])) {
            Yii::app()->session ['deleteStuID'] = $_GET ['userID'];
        } else if (isset($_POST ['checkbox'])) {
            Yii::app()->session ['deleteStuBox'] = $_POST ['checkbox'];
        }
        return $this->render('confirmPass');
    }

    public function actionChangeLog() {
        $sql = "SELECT changeLog FROM course WHERE courseID=" . $_GET ['courseID'];
        $result = Yii::app()->db->createCommand($sql)->query();
        $log = $result->read() ['changeLog'];
        $this->render('changeLog', array(
            'log' => $log,
            'source' => $_GET ['source'],
            'teacher' => $this->teaInClass()
        ));
    }

    public function actionNoticeLst() {
        $result = Notice::model()->findNotice();
        $noticeRecord = $result ['noticeLst'];
        $pages = $result ['pages'];
        $this->render('noticeLst', array('noticeRecord' => $noticeRecord, 'pages' => $pages));
    }

    public function ActionDeleteNotice() {
        if (isset($_POST['checkbox'])) {
            $userIDlist = $_POST['checkbox'];
            foreach ($userIDlist as $v) {
                Notice::model()->delNotice($v);
            }
            $result = Notice::model()->findNotice();
            $noticeRecord = $result ['noticeLst'];
            $pages = $result ['pages'];
            $this->render('noticeLst', array('noticeRecord' => $noticeRecord, 'pages' => $pages));
        }
        $id = $_GET['id'];
        Notice::model()->deleteAll("id='$id'");
        $result = Notice::model()->findNotice();
        $noticeRecord = $result ['noticeLst'];
        $pages = $result ['pages'];
        $this->render('noticeLst', array('noticeRecord' => $noticeRecord, 'pages' => $pages));
    }

    public function ActionNoticeContent() {
        $result = 0;
        if (isset($_GET['action']) && $_GET['action'] == 'edit') {
            $result = 1;
        }
        $id = $_GET['id'];
        $noticeRecord = Notice::model()->find("id= '$id'");
        $this->render('noticeContent', array('noticeRecord' => $noticeRecord, 'result' => $result));
    }

    public function actionGetNum() {
        $stuNumber = Tool::$studentNumber;
        $num = 0;
        if (isset($_GET['classID'])) {
            $classID = $_GET['classID'];
            $num = TbClass::model()->getStuNums($classID);
        }
        if ($num >= $stuNumber)
            echo "error";
        else
            echo "success";
    }

    // 是否存在指定班级
    public function exClass($classID) {
        $sql = "select * from tb_class where classID = '$classID'";
        $course = Yii::app()->db->createCommand($sql)->query();
        if (empty($course->read()))
            return FALSE;
        else
            return TRUE;
    }

    public function actionDeleteCourse() {
        if (isset($_GET['courseID'])) {
            $courseID = $_GET['courseID'];
            Course::model()->deleteAll('courseID=?', array($courseID));
            Teacher::model()->deleteAll('classID=?', array($courseID));
            Student::model()->deleteAll('classID=?', array($courseID));
            AnswerRecord::model()->deleteAll('courseID=?', array($courseID));
            $result = 1;
        }

        if (isset($_POST['checkbox'])) {
            $result = 1;
            $userIDlist = $_POST['checkbox'];
            foreach ($userIDlist as $v) {
                Course::model()->deleteAll('courseID=?', array($v));
                Teacher::model()->deleteAll('classID=?', array($v));
                Student::model()->deleteAll('classID=?', array($v));
            }
            $result1 = Course::model()->getAllLst();
            $courseLst = $result1 ['list'];
            $pages = $result1 ['pages'];
            $this->render('courseLst', array(
                'courseLst' => $courseLst,
                'pages' => $pages,
                'teacher' => Teacher::model()->findall(),
                'result' => $result,
            ));
        } else {
            $courses = Course::model()->getAllLst();
            $courseLst = $courses ['list'];
            $pages = $courses ['pages'];
            $this->render('courseLst', array(
                'courseLst' => $courseLst,
                'pages' => $pages,
                'teacher' => Teacher::model()->findall(),
                'result' => $result
            ));
        }
    }

    public function actionCourseLst() {
        $result = Course::model()->getAllLst();
        $courseLst = $result ['list'];
        $pages = $result ['pages'];
        $this->render('courseLst', array(
            'courseLst' => $courseLst,
            'pages' => $pages,
            'result' => ''
        ));
    }

    public function actionAddRaceCourse() {
        $courseName = $_GET['courseName'];
        Course::model()->addRaceCourse($courseName);
        $courseID = Course::model()->getAllLstDesc();
        Student::model()->addRaceStudent($courseID['courseID']);
        Teacher::model()->addRaceTeacher($courseID['courseID']);
        $result = Course::model()->getAllLst();
        $courseLst = $result ['list'];
        $pages = $result ['pages'];
        $this->render('courseLst', array(
            'courseLst' => $courseLst,
            'pages' => $pages,
            'result' => "1"
        ));
    }

    public function actionRaceLst() {
        $aList = RaceIndex::model()->getAllRaceIndex();
        $result = $aList['list'];
        $pages = $aList['pages'];
        $this->render('raceLst', array(
            'raceLst' => $result,
            'pages' => $pages,
            'result' => ''
        ));
    }

    public function actionAddRaceIndex() {
        $raceName = $_GET['raceName'];
        RaceIndex::model()->addRaceIndex($raceName);
        $aList = RaceIndex::model()->getAllRaceIndex();
        $result = $aList['list'];
        $pages = $aList['pages'];
        $this->render('raceLst', array(
            'raceLst' => $result,
            'pages' => $pages,
            'result' => ''
        ));
    }

    public function actionEditRace() {
        $step = $_GET["step"];
        $indexID = $_GET["indexID"];
        $result = "";
        $render = '';
        switch ($step) {
            case 1:
                if (isset($_POST['time'])) {
                    $time = $_POST['time'];
                    $score = $_POST['score'];
                    Race::model()->addRace($indexID, $step, "", $score, $time, "", "");
                    $result = 1;
                }
                $render = 'One';
                break;
            case 2:
                if (isset($_POST['time'])) {
                    $time = $_POST['time'];
                    $score = $_POST['score'];
                    $content = $_POST['content'];
                    Race::model()->addRace($indexID, $step, $content, $score, $time, "", "");
                    $result = 1;
                }
                $render = 'Two';
                break;
            case 3:
                if (isset($_POST['score'])) {
//                    $time = $_POST['time'];
                    $score = $_POST['score'];
                    $content = $_POST['content'];
                    $dir = "./resources/race/";                    
                    if (!is_dir($dir)) {
                        mkdir($dir, 0777);
                    }
                    $flag = Race::model()->find("indexID=? AND step =?", array($indexID, $step));
                    if ($flag==null){
                            if ($_FILES ['file'] ['type'] != "audio/mpeg" &&
                            $_FILES ['file'] ['type'] != "audio/wav" &&
                            $_FILES ['file'] ['type'] != "audio/x-wav") {
                            $result = '文件格式不正确，应为MP3或WAV格式';
                        } else if ($_FILES['file']['error'] > 0) {
                                 $result = '文件上传失败';
                         } else {
                        $oldName = $_FILES["file"]["name"];
                        $newName = Tool::createID() . "." . pathinfo($oldName, PATHINFO_EXTENSION);
                        move_uploaded_file($_FILES["file"]["tmp_name"], $dir . iconv("UTF-8", "gb2312", $newName));
                        Resourse::model()->insertRelaVoice($newName, $oldName);
                        $file=realpath($dir . iconv("UTF-8", "gb2312", $newName));
                        $player=new COM("WMPlayer.OCX");
                        $media=$player->newMedia($file);
                        $time=round($media->duration);
                        Race::model()->addRace($indexID, $step, $content, $score, $time, $newName, $oldName);
                        $step4 = Race::model()->find("indexID=? AND step=?", array($indexID, 4));
                        Race::model()->addRace($indexID, 4, $content, $step4['score'], $step4['time'], "", "");
                        $result = 1;
                            }                 
                                    }
                else {
                   if($_FILES["file"]["name"]!=""){
                        if ($_FILES ['file'] ['type'] != "audio/mpeg" &&
                            $_FILES ['file'] ['type'] != "audio/wav" &&
                            $_FILES ['file'] ['type'] != "audio/x-wav") {
                                $result = '文件格式不正确，应为MP3或WAV格式';
                            } else if ($_FILES['file']['error'] > 0) {
                                 $result = '文件上传失败';
                              }else {
                        $oldName = $_FILES["file"]["name"];
                        $newName = Tool::createID() . "." . pathinfo($oldName, PATHINFO_EXTENSION);
                        move_uploaded_file($_FILES["file"]["tmp_name"], $dir . iconv("UTF-8", "gb2312", $newName));
                        Resourse::model()->insertRelaVoice($newName, $oldName);
                        $file=realpath($dir . iconv("UTF-8", "gb2312", $newName));
                        $player=new COM("WMPlayer.OCX");
                        $media=$player->newMedia($file);
                        $time=round($media->duration);
                        Race::model()->addRace($indexID, $step, $content, $score, $time, $newName, $oldName);
                        $step4 = Race::model()->find("indexID=? AND step=?", array($indexID, 4));
                        Race::model()->addRace($indexID, 4, $content, $step4['score'], $step4['time'], "", "");
                        $result = 1;
                            } 
                        }
                else {
                     $newName = $flag['resourseID'];
                     $oldName = $flag['fileName'];
                     $time = $flag['time'];
                     Race::model()->addRace($indexID, $step, $content, $score, $time, $newName, $oldName);
                     $result = '1';
                    }
                        }
                }
                $render = 'Three';
                break;
            case 4:
                if (isset($_POST['time'])) {
                    $time = $_POST['time'];
                    $score = $_POST['score'];
                    $content = Race::model()->find("indexID=? AND step=?", array($indexID, 3))['content'];
                    Race::model()->addRace($indexID, $step, $content, $score, $time, "", "");
                    $result = 1;
                }
                $render = 'Four';
                break;
            case 5:
                if (isset($_POST['score'])) {
//                    $time = $_POST['time'];
                    $score = $_POST['score'];
                    $content = $_POST['content'];
                    $dir = "./resources/race/";
                    if (!is_dir($dir)) {
                        mkdir($dir, 0777);
                    }
                    if ($_FILES ['file'] ['type'] != "audio/mpeg" &&
                            $_FILES ['file'] ['type'] != "audio/wav" &&
                            $_FILES ['file'] ['type'] != "audio/x-wav") {
                        $result = '文件格式不正确，应为MP3或WAV格式';
                    } else if ($_FILES['file']['error'] > 0) {
                        $result = '文件上传失败';
                    } else {
                        $oldName = $_FILES["file"]["name"];
                        $newName = Tool::createID() . "." . pathinfo($oldName, PATHINFO_EXTENSION);
                        move_uploaded_file($_FILES["file"]["tmp_name"], $dir . iconv("UTF-8", "gb2312", $newName));
                        Resourse::model()->insertRelaVoice($newName, $oldName);
                        $file=realpath($dir . iconv("UTF-8", "gb2312", $newName));
                        $player=new COM("WMPlayer.OCX");
                        $media=$player->newMedia($file);
                        $time=round($media->duration);
                        Race::model()->addRace($indexID, $step, $content, $score, $time, $newName, $oldName);
                        $result = 1;
                    }
                }
                $render = 'Five';
                break;
            case 6:
                if (isset($_POST['score'])) {
//                    $time = $_POST['time'];
                    $score = $_POST['score'];
                    $content = $_POST['content'];
                    $dir = "./resources/race/";
                    if (!is_dir($dir)) {
                        mkdir($dir, 0777);
                    }
                    if ($_FILES["file"]["type"] == "video/mp4" || $_FILES["file"]["type"] == "application/octet-stream" && substr($_FILES["file"]["name"], strrpos($_FILES["file"]["name"], '.') + 1) != "rm" && substr($_FILES["file"]["name"], strrpos($_FILES["file"]["name"], '.') + 1) != "RM") {
                        if ($_FILES["file"]["error"] > 0) {
                            $result = "Return Code: " . $_FILES["file"]["error"];
                        } else {
                            $oldName = $_FILES["file"]["name"];
                            $newName = Tool::createID() . "." . pathinfo($oldName, PATHINFO_EXTENSION);
                            move_uploaded_file($_FILES["file"]["tmp_name"], $dir . iconv("UTF-8", "gb2312", $newName));
                            Resourse::model()->insertRelaVideo($newName, $oldName);
                            $file=realpath($dir . iconv("UTF-8", "gb2312", $newName));
                            $player=new COM("WMPlayer.OCX");
                            $media=$player->newMedia($file);
                            $time=round($media->duration);
                            Race::model()->addRace($indexID, $step, $content, $score, $time, $newName, $oldName);
                            $result = 1;
                        }
                    } else {
                        $result = "请上传正确类型的文件！";
                    }
                }
                $render = 'Six';
                break;
        }
        $race = Race::model()->find("indexID=? AND step=?", array($indexID, $step));
        $this->render('editRace' . $render, array(
            'race' => $race,
            'result' => $result,
            'step' => $step
        ));
    }

    public function actionDeleteRaceIndex() {
        if (isset($_GET['indexID'])) {
            $indexID = $_GET['indexID'];
            RaceIndex::model()->deleteRaceIndex($indexID);
            $result = 1;
        }

        if (isset($_POST['checkbox'])) {
            $result = 1;
            $userIDlist = $_POST['checkbox'];
            foreach ($userIDlist as $v) {
                RaceIndex::model()->deleteRaceIndex($v);
            }
            $aList = RaceIndex::model()->getAllRaceIndex();
            $raceLst = $aList ['list'];
            $pages = $aList ['pages'];
            $this->render('raceLst', array(
                'raceLst' => $raceLst,
                'pages' => $pages,
                'result' => $result,
            ));
        } else {
            $aList = RaceIndex::model()->getAllRaceIndex();
            $raceLst = $aList ['list'];
            $pages = $aList ['pages'];
            $this->render('raceLst', array(
                'raceLst' => $raceLst,
                'pages' => $pages,
                'result' => $result
            ));
        }
    }

    public function ActionGetProgress() {
        session_start();
        $i = ini_get('session.upload_progress.name');
        $key = ini_get("session.upload_progress.prefix") . $_GET[$i];
        if (!empty($_SESSION[$key])) {
            $current = $_SESSION[$key]["bytes_processed"];
            $total = $_SESSION[$key]["content_length"];
            echo $current < $total ? ceil($current / $total * 100) : 100;
        } else {
            echo 100;
        }
    }

}
