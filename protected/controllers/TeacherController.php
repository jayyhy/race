<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TeacherController extends CController {

    protected function renderJSON($data) {
        header('Content-type: application/json');
        echo CJSON::encode($data);

        foreach (Yii::app()->log->routes as $route) {
            if ($route instanceof CWebLogRoute) {
                $route->enabled = false; // disable any weblogroutes
            }
        }
        Yii::app()->end();
    }

    public $layout = '//layouts/teacherBar';

    public function actionSet() {       //set
        $result = 'no';
        $mail = '';
        $userid_now = Yii::app()->session['userid_now'];
        $user = Teacher::model()->find('userID=?', array($userid_now));
        if (!empty($user->mail_address)) {
            $mail = $user->mail_address;
        }
        if (isset($_POST['old'])) {
            $new1 = $_POST['new1'];
            $defnew = $_POST['defnew'];
            $usertype = Yii::app()->session['role_now'];
            $user = Teacher::model()->find('userID=?', array($userid_now));
            if ($user->password != md5($_POST['old'])) {
                $result = 'old error';
                $this->render('set', ['result' => $result, 'mail' => $mail]);
                return;
            }
            $user->password = md5($new1);
            $result = $user->update();
        }
        $this->render('set', ['result' => $result]);
    }

    public function actionIndex() {
        $this->render('index');
    }

    public function actionteaInformation() {
        $ID = Yii::app()->session['userid_now'];
        $teacher = Teacher::model()->find("userID = '$ID'");
        return $this->render('teaInformation', array(
                    'id' => $teacher ['userID'],
                    'name' => $teacher ['userName'],
                    'password' => $teacher['password'],
        ));
    }

    public function ActionUpdateTime() {      //更新时间
        $type = $_GET['type'];
        $examID = $_GET['examID'];
        /*
          $startTime=$_POST['startTime'];
          $endTime=$_POST['endTime'];
          $examTime=$_POST['examTime'];


          $date=floor((strtotime($endTime)-strtotime($startTime))/86400);
          $hour=floor((strtotime($endTime)-strtotime($startTime))%86400/3600);
          $minute=floor((strtotime($endTime)-strtotime($startTime))%86400/60);
          $second=floor((strtotime($endTime)-strtotime($startTime))%86400%60);
          if($second>=60){
          $minute+=($second/60);
          $second=$second%60;
          }

          if($minute>=60){
          $hour=$hour+(int)($hour/60);
          $minute=$minute%60;
          }
          if($hour>=24){
          $date+=($date/24);
          $hour=$hour%24;
          }
          $duration=(strtotime($endTime)-strtotime($startTime))/60;
          $duration=$examTime;
          Race::model()->updateByPk($examID,array('begintime'=>$startTime,'endtime'=>$endTime,'duration'=>$duration));
         * 
         */
        $this->renderModifyExam($type, $examID);
    }

    //公告信息
    public function actionteacherNotice() {
        $result = Notice::model()->findNotice();
        $noticeRecord = $result ['noticeLst'];
        $pages = $result ['pages'];
        $teacherID = Yii::app()->session['userid_now'];
        $noticeS = Teacher::model()->findByPK($teacherID);
        $noticeS->noticestate = '0';
        $noticeS->update();
        $this->render('teacherNotice', array('noticeRecord' => $noticeRecord, 'pages' => $pages));
    }

    public function actionNoticeContent() {
        $result = 0;
        if (isset($_GET['action']) && $_GET['action'] == 'edit') {
            $result = 1;
        }
        $id = $_GET['id'];
        $noticeRecord = Notice::model()->find("id= '$id'");
        $this->render('noticeContent', array('noticeRecord' => $noticeRecord));
    }

    public function actionRaceControl() {
        $teacherID = Yii::app()->session['userid_now'];
        $teacher = Teacher::model()->find("userID=?", array($teacherID));
        $course = Course::model()->find("courseID=?", array($teacher['classID']));
        $pager = RaceIndex::model()->getAllRaceIndex();
        $raceIndex = $pager['list'];
        $pages = $pager['pages'];
        $this->render('raceControl', array("course" => $course, "raceIndex" => $raceIndex, "pages" => $pages));
    }

    public function actionControl() {
        $step = $_GET['step'];
        $indexID = $_GET['indexID'];
        $flag = 0;
        $race = Race::model()->find("indexID=? AND step=?", array($indexID, $step));
        $teacherID = Yii::app()->session['userid_now'];
        switch ($step) {
            case 1:
                if (isset($_GET['raceID'])) {
                    Course::model()->startRace($_GET['raceID'], $teacherID);
                }
                $render = "One";
                break;
            case 2:
                if (isset($_GET['raceID'])) {
                    Course::model()->startRace($_GET['raceID'], $teacherID);
                }
                if (isset($_GET['over'])) {
                    Course::model()->overRace($teacherID);
                }
                $render = "Two";
                break;
            case 3:
                if (isset($_GET['raceID'])) {
                    Course::model()->startRace($_GET['raceID'], $teacherID);
                }
                if (isset($_GET['over'])) {
                    Course::model()->overRace($teacherID);
                }
                $render = "Three";
                break;
            case 4:
                if (isset($_GET['raceID'])) {
                    Course::model()->startRace($_GET['raceID'], $teacherID);
                }
                if (isset($_GET['over'])) {
                    Course::model()->overRace($teacherID);
                }
                $render = "Four";
                break;
            case 5:
                if (isset($_GET['raceID'])) {
                    Course::model()->startRace($_GET['raceID'], $teacherID);
                }
                if (isset($_GET['over'])) {
                    Course::model()->overRace($teacherID);
                }
                $render = "Five";
                break;
            case 6:
                if (isset($_GET['raceID'])) {
                    Course::model()->startRace($_GET['raceID'], $teacherID);
                }
                if (isset($_GET['over'])) {
                    Course::model()->overRace($teacherID);
                }
                $render = "Six";
                break;
        }
        $endTime = Course::model()->isOpen($teacherID);
        if ($endTime) {
            $flag = 1;
        }
        $nowOnStep = Course::model()->getNowOnStep($teacherID);
        $this->render('control' . $render, array("step" => $step, "race" => $race, "flag" => $flag, "endTime" => $endTime,"nowOnStep"=>$nowOnStep));
    }

}
